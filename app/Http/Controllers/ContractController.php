<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Project;
use App\Models\ActivityLog;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('project')->latest()->get();
        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();
        return view('contracts.create', compact('projects'));
    }

    public function store(StoreContractRequest $request)
    {
        $contract = Contract::create($request->validated());

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Contract::class,
            'model_id'    => $contract->id,
            'action'      => 'created',
            'description' => auth()->user()->name . ' created contract ' . $contract->contract_number,
        ]);

        return redirect()->route('contracts.index')
            ->with('success', 'Contract created successfully.');
    }

    public function show(Contract $contract)
    {
        $contract->load('project');
        return view('contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $projects = Project::orderBy('name')->get();
        return view('contracts.edit', compact('contract', 'projects'));
    }

    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $contract->update($request->validated());

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Contract::class,
            'model_id'    => $contract->id,
            'action'      => 'updated',
            'description' => auth()->user()->name . ' updated contract ' . $contract->contract_number,
        ]);

        return redirect()->route('contracts.index')
            ->with('success', 'Contract updated successfully.');
    }

    public function destroy(Contract $contract)
    {
        $contractNumber = $contract->contract_number;
        $contract->delete();

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Contract::class,
            'model_id'    => $contract->id,
            'action'      => 'deleted',
            'description' => auth()->user()->name . ' deleted contract ' . $contractNumber,
        ]);

        return redirect()->route('contracts.index')
            ->with('success', 'Contract deleted successfully.');
    }
}