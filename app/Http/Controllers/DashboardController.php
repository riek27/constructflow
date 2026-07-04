<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Variation;
use App\Models\Payment;
use App\Models\Procurement;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Projects
        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'active')->count();
        $totalContractValue = Project::sum('contract_value');

        // Variations
        $approvedVariationsValue = Variation::where('status', 'approved')->sum('approved_cost');
        $pendingVariationsValue = Variation::whereIn('status', ['draft', 'submitted', 'under_review'])->sum('estimated_cost');

        // Payments
        $paymentsReceived = Payment::where('status', 'paid')->sum('total_amount');
        $outstandingPayments = Payment::whereIn('status', ['pending', 'approved', 'partially_paid'])->sum('total_amount');

        // Procurement
        $procurementValue = Procurement::sum('total_cost');

        // Recent items
        $recentProjects = Project::latest()->take(5)->get();
        $recentVariations = Variation::with('project')->latest()->take(5)->get();
        $recentPayments = Payment::with('project')->latest()->take(5)->get();
        $recentActivities = ActivityLog::with('user')->latest()->take(8)->get();

        // Monthly Revenue Chart Data
        $monthlyRevenueLabels = [];
        $monthlyRevenueData = [];
        $paidPayments = Payment::where('status', 'paid')
            ->selectRaw("DATE_FORMAT(invoice_date, '%Y-%m') as month, SUM(total_amount) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        foreach ($paidPayments as $row) {
            $monthlyRevenueLabels[] = \Carbon\Carbon::createFromFormat('Y-m', $row->month)->format('M Y');
            $monthlyRevenueData[] = (float) $row->total;
        }

        // Variation Trend Chart Data
        $variationTrendLabels = [];
        $variationTrendData = [];
        $approvedVariations = Variation::where('status', 'approved')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(approved_cost) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        foreach ($approvedVariations as $row) {
            $variationTrendLabels[] = \Carbon\Carbon::createFromFormat('Y-m', $row->month)->format('M Y');
            $variationTrendData[] = (float) $row->total;
        }

        return view('dashboard', compact(
            'totalProjects',
            'activeProjects',
            'totalContractValue',
            'outstandingPayments',
            'approvedVariationsValue',
            'pendingVariationsValue',
            'paymentsReceived',
            'procurementValue',
            'recentProjects',
            'recentVariations',
            'recentPayments',
            'recentActivities',
            'monthlyRevenueLabels',
            'monthlyRevenueData',
            'variationTrendLabels',
            'variationTrendData'
        ));
    }
}