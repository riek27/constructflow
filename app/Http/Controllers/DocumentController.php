<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Project;
use App\Models\ActivityLog;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with('project', 'uploader');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('original_name', 'like', "%{$search}%");
            });
        }
        if ($request->filled('project')) {
            $query->where('project_id', $request->input('project'));
        }
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $documents = $query->latest()->paginate(20);
        $projects = Project::orderBy('name')->get();
        $categories = [
            'Contracts', 'Drawings', 'Variations', 'Invoices',
            'Purchase Orders', 'Photos', 'Letters', 'Reports', 'Other'
        ];

        return view('documents.index', compact('documents', 'projects', 'categories'));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();
        $categories = [
            'Contracts', 'Drawings', 'Variations', 'Invoices',
            'Purchase Orders', 'Photos', 'Letters', 'Reports', 'Other'
        ];
        return view('documents.create', compact('projects', 'categories'));
    }

    public function store(StoreDocumentRequest $request)
    {
        $data = $request->validated();
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $path = $file->store('documents/' . $data['project_id'], 'public');
        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        $document = Document::create([
            'project_id'          => $data['project_id'],
            'documentable_type'   => $data['documentable_type'] ?? null,
            'documentable_id'     => $data['documentable_id'] ?? null,
            'title'               => $data['title'],
            'category'            => $data['category'],
            'file_path'           => $path,
            'original_name'       => $originalName,
            'mime_type'           => $mimeType,
            'size'                => $size,
            'version'             => $data['version'] ?? '1.0',
            'description'         => $data['description'] ?? null,
            'uploaded_by'         => auth()->id(),
        ]);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Document::class,
            'model_id'    => $document->id,
            'action'      => 'created',
            'description' => auth()->user()->name . ' uploaded document ' . $document->title,
        ]);

        return redirect()->route('documents.index')
            ->with('success', 'Document uploaded successfully.');
    }

    public function show(Document $document)
    {
        $document->load('project', 'uploader', 'documentable');
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $projects = Project::orderBy('name')->get();
        $categories = [
            'Contracts', 'Drawings', 'Variations', 'Invoices',
            'Purchase Orders', 'Photos', 'Letters', 'Reports', 'Other'
        ];
        return view('documents.edit', compact('document', 'projects', 'categories'));
    }

    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($document->file_path);
            $file = $request->file('file');
            $data['file_path'] = $file->store('documents/' . $data['project_id'], 'public');
            $data['original_name'] = $file->getClientOriginalName();
            $data['mime_type'] = $file->getMimeType();
            $data['size'] = $file->getSize();
        }

        $document->update($data);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Document::class,
            'model_id'    => $document->id,
            'action'      => 'updated',
            'description' => auth()->user()->name . ' updated document ' . $document->title,
        ]);

        return redirect()->route('documents.index')
            ->with('success', 'Document updated successfully.');
    }

    public function destroy(Document $document)
    {
        $title = $document->title;
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Document::class,
            'model_id'    => $document->id,
            'action'      => 'deleted',
            'description' => auth()->user()->name . ' deleted document ' . $title,
        ]);

        return redirect()->route('documents.index')
            ->with('success', 'Document deleted successfully.');
    }

    public function download(Document $document)
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404);
        }
        return Storage::disk('public')->download($document->file_path, $document->original_name);
    }
}