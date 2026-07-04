<?php

namespace App\Http\Controllers;

use App\Models\Variation;
use App\Models\Project;
use App\Models\Contract;
use App\Models\ActivityLog;
use App\Http\Requests\StoreVariationRequest;
use App\Http\Requests\UpdateVariationRequest;

class VariationController extends Controller
{
    public function index()
    {
        $variations = Variation::with(['project', 'contract'])->latest()->get();
        return view('variations.index', compact('variations'));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();
        $contracts = Contract::orderBy('contract_number')->get();
        return view('variations.create', compact('projects', 'contracts'));
    }

    public function store(StoreVariationRequest $request)
    {
        $variation = Variation::create($request->validated());

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Variation::class,
            'model_id'    => $variation->id,
            'action'      => 'created',
            'description' => auth()->user()->name . ' created variation ' . $variation->variation_number,
        ]);

        return redirect()->route('variations.index')
            ->with('success', 'Variation created successfully.');
    }

    public function show(Variation $variation)
    {
        $variation->load('project', 'contract');
        return view('variations.show', compact('variation'));
    }

    public function edit(Variation $variation)
    {
        $projects = Project::orderBy('name')->get();
        $contracts = Contract::orderBy('contract_number')->get();
        return view('variations.edit', compact('variation', 'projects', 'contracts'));
    }

    public function update(UpdateVariationRequest $request, Variation $variation)
    {
        $variation->update($request->validated());

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Variation::class,
            'model_id'    => $variation->id,
            'action'      => 'updated',
            'description' => auth()->user()->name . ' updated variation ' . $variation->variation_number,
        ]);

        return redirect()->route('variations.index')
            ->with('success', 'Variation updated successfully.');
    }

    public function destroy(Variation $variation)
    {
        $variationNumber = $variation->variation_number;
        $variation->delete();

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Variation::class,
            'model_id'    => $variation->id,
            'action'      => 'deleted',
            'description' => auth()->user()->name . ' deleted variation ' . $variationNumber,
        ]);

        return redirect()->route('variations.index')
            ->with('success', 'Variation deleted successfully.');
    }
}