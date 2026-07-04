<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Contract;
use App\Models\Variation;
use App\Models\Payment;
use App\Models\Procurement;
use App\Models\Document;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Show the reports index page with filter form and preview.
     */
    public function index(Request $request)
    {
        $type = $request->input('type', 'projects');
        $projectId = $request->input('project_id');
        $status = $request->input('status');
        $from = $request->input('from');
        $to = $request->input('to');

        $data = [];
        $projects = Project::orderBy('name')->get();

        switch ($type) {
            case 'projects':
                $query = Project::query();
                if ($projectId) $query->where('id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                break;
            case 'contracts':
                $query = Contract::with('project');
                if ($projectId) $query->where('project_id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                break;
            case 'variations':
                $query = Variation::with('project');
                if ($projectId) $query->where('project_id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                break;
            case 'payments':
                $query = Payment::with('project');
                if ($projectId) $query->where('project_id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                break;
            case 'procurements':
                $query = Procurement::with('project', 'supplier');
                if ($projectId) $query->where('project_id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                break;
            case 'documents':
                $query = Document::with('project');
                if ($projectId) $query->where('project_id', $projectId);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                break;
        }

        return view('reports.index', compact('type', 'projects', 'data', 'projectId', 'status', 'from', 'to'));
    }

    /**
     * Export the currently filtered data to CSV (Excel compatible).
     */
    public function exportExcel(Request $request)
    {
        $type = $request->input('type', 'projects');
        $projectId = $request->input('project_id');
        $status = $request->input('status');
        $from = $request->input('from');
        $to = $request->input('to');

        switch ($type) {
            case 'projects':
                $query = Project::query();
                if ($projectId) $query->where('id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                $headers = ['ID', 'Name', 'Client', 'Contract Value', 'Status'];
                $filename = 'projects.csv';
                break;
            case 'contracts':
                $query = Contract::with('project');
                if ($projectId) $query->where('project_id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                $headers = ['ID', 'Project', 'Contract Number', 'Client', 'Value', 'Status', 'Start Date', 'Completion Date'];
                $filename = 'contracts.csv';
                break;
            case 'variations':
                $query = Variation::with('project');
                if ($projectId) $query->where('project_id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                $headers = ['ID', 'Project', 'Variation #', 'Title', 'Estimated Cost', 'Approved Cost', 'Status'];
                $filename = 'variations.csv';
                break;
            case 'payments':
                $query = Payment::with('project');
                if ($projectId) $query->where('project_id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                $headers = ['ID', 'Project', 'Invoice #', 'Type', 'Amount', 'VAT', 'Total', 'Due Date', 'Status'];
                $filename = 'payments.csv';
                break;
            case 'procurements':
                $query = Procurement::with('project', 'supplier');
                if ($projectId) $query->where('project_id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                $headers = ['ID', 'Project', 'PO Number', 'Supplier', 'Total Cost', 'Order Date', 'Delivery Date', 'Status'];
                $filename = 'procurements.csv';
                break;
            case 'documents':
                $query = Document::with('project');
                if ($projectId) $query->where('project_id', $projectId);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                $headers = ['ID', 'Project', 'Title', 'Category', 'Original Name', 'Size (KB)', 'Uploaded At'];
                $filename = 'documents.csv';
                break;
            default:
                abort(400, 'Invalid report type');
        }

        $callback = function() use ($data, $headers, $type) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($data as $item) {
                switch ($type) {
                    case 'projects':
                        fputcsv($file, [$item->id, $item->name, $item->client, $item->contract_value, $item->status]);
                        break;
                    case 'contracts':
                        fputcsv($file, [
                            $item->id, $item->project->name ?? '', $item->contract_number, $item->client,
                            $item->contract_value, $item->status, $item->start_date, $item->completion_date
                        ]);
                        break;
                    case 'variations':
                        fputcsv($file, [
                            $item->id, $item->project->name ?? '', $item->variation_number, $item->title,
                            $item->estimated_cost, $item->approved_cost, $item->status
                        ]);
                        break;
                    case 'payments':
                        fputcsv($file, [
                            $item->id, $item->project->name ?? '', $item->invoice_number, $item->type,
                            $item->amount, $item->vat, $item->total_amount, $item->due_date, $item->status
                        ]);
                        break;
                    case 'procurements':
                        fputcsv($file, [
                            $item->id, $item->project->name ?? '', $item->po_number,
                            $item->supplier->name ?? $item->supplier_name, $item->total_cost,
                            $item->order_date, $item->delivery_date, $item->status
                        ]);
                        break;
                    case 'documents':
                        fputcsv($file, [
                            $item->id, $item->project->name ?? '', $item->title, $item->category,
                            $item->original_name, round($item->size / 1024, 1), $item->created_at
                        ]);
                        break;
                }
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Export the currently filtered data to PDF.
     */
    public function exportPdf(Request $request)
    {
        $type = $request->input('type', 'projects');
        $projectId = $request->input('project_id');
        $status = $request->input('status');
        $from = $request->input('from');
        $to = $request->input('to');

        switch ($type) {
            case 'projects':
                $query = Project::query();
                if ($projectId) $query->where('id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                $view = 'exports.projects_pdf';
                break;
            case 'contracts':
                $query = Contract::with('project');
                if ($projectId) $query->where('project_id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                $view = 'exports.contracts_pdf';
                break;
            case 'variations':
                $query = Variation::with('project');
                if ($projectId) $query->where('project_id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                $view = 'exports.variations_pdf';
                break;
            case 'payments':
                $query = Payment::with('project');
                if ($projectId) $query->where('project_id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                $view = 'exports.payments_pdf';
                break;
            case 'procurements':
                $query = Procurement::with('project', 'supplier');
                if ($projectId) $query->where('project_id', $projectId);
                if ($status) $query->where('status', $status);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                $view = 'exports.procurements_pdf';
                break;
            case 'documents':
                $query = Document::with('project');
                if ($projectId) $query->where('project_id', $projectId);
                if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
                $data = $query->latest()->get();
                $view = 'exports.documents_pdf';
                break;
            default:
                abort(400, 'Invalid report type');
        }

        $pdf = Pdf::loadView($view, compact('data'))->setPaper('a4', 'landscape');
        return $pdf->download($type . '.pdf');
    }
}