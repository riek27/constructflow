<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use App\Models\Project;
use App\Models\Supplier;
use App\Models\ActivityLog;
use App\Http\Requests\StoreProcurementRequest;
use App\Http\Requests\UpdateProcurementRequest;

class ProcurementController extends Controller
{
    public function index()
    {
        $procurements = Procurement::with(['project', 'supplier'])->latest()->get();
        return view('procurements.index', compact('procurements'));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('procurements.create', compact('projects', 'suppliers'));
    }

    public function store(StoreProcurementRequest $request)
    {
        $data = $request->validated();
        if (empty($data['total_cost'])) {
            $data['total_cost'] = ($data['quantity'] ?? 0) * ($data['unit_cost'] ?? 0);
        }
        $procurement = Procurement::create($data);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Procurement::class,
            'model_id'    => $procurement->id,
            'action'      => 'created',
            'description' => auth()->user()->name . ' created PO ' . $procurement->po_number,
        ]);

        return redirect()->route('procurements.index')
            ->with('success', 'Purchase Order created successfully.');
    }

    public function show(Procurement $procurement)
    {
        $procurement->load('project', 'supplier');
        return view('procurements.show', compact('procurement'));
    }

    public function edit(Procurement $procurement)
    {
        $projects = Project::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('procurements.edit', compact('procurement', 'projects', 'suppliers'));
    }

    public function update(UpdateProcurementRequest $request, Procurement $procurement)
    {
        $data = $request->validated();
        if (empty($data['total_cost'])) {
            $data['total_cost'] = ($data['quantity'] ?? 0) * ($data['unit_cost'] ?? 0);
        }
        $procurement->update($data);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Procurement::class,
            'model_id'    => $procurement->id,
            'action'      => 'updated',
            'description' => auth()->user()->name . ' updated PO ' . $procurement->po_number,
        ]);

        return redirect()->route('procurements.index')
            ->with('success', 'Purchase Order updated successfully.');
    }

    public function destroy(Procurement $procurement)
    {
        $poNumber = $procurement->po_number;
        $procurement->delete();

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Procurement::class,
            'model_id'    => $procurement->id,
            'action'      => 'deleted',
            'description' => auth()->user()->name . ' deleted PO ' . $poNumber,
        ]);

        return redirect()->route('procurements.index')
            ->with('success', 'Purchase Order deleted successfully.');
    }
}