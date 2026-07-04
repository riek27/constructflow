<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ActivityLog;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Project::class,
            'model_id'    => $project->id,
            'action'      => 'created',
            'description' => auth()->user()->name . ' created project ' . $project->name,
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Project::class,
            'model_id'    => $project->id,
            'action'      => 'updated',
            'description' => auth()->user()->name . ' updated project ' . $project->name,
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $projectName = $project->name;
        $project->delete();

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Project::class,
            'model_id'    => $project->id,
            'action'      => 'deleted',
            'description' => auth()->user()->name . ' deleted project ' . $projectName,
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}