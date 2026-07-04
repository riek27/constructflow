<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Document Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 bg-navy text-white">
                    <h3 class="text-2xl font-bold">{{ $document->title }}</h3>
                    <p class="text-gray-300 mt-1">{{ $document->original_name }}</p>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><p class="text-sm text-gray-500">Project</p><p class="text-lg font-semibold text-gray-900">{{ $document->project->name ?? '—' }}</p></div>
                    <div><p class="text-sm text-gray-500">Category</p><p class="text-lg font-semibold text-gray-900">{{ $document->category }}</p></div>
                    <div><p class="text-sm text-gray-500">Version</p><p class="text-lg font-semibold text-gray-900">{{ $document->version }}</p></div>
                    <div><p class="text-sm text-gray-500">File Size</p><p class="text-lg font-semibold text-gray-900">{{ number_format($document->size / 1024, 1) }} KB</p></div>
                    <div><p class="text-sm text-gray-500">MIME Type</p><p class="text-lg font-semibold text-gray-900">{{ $document->mime_type }}</p></div>
                    <div><p class="text-sm text-gray-500">Uploaded By</p><p class="text-lg font-semibold text-gray-900">{{ $document->uploader->name ?? '—' }}</p></div>
                    <div><p class="text-sm text-gray-500">Uploaded At</p><p class="text-lg font-semibold text-gray-900">{{ $document->created_at->format('M d, Y H:i') }}</p></div>
                    @if($document->documentable)
                    <div>
                        <p class="text-sm text-gray-500">Linked to</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ class_basename($document->documentable_type) }} #{{ $document->documentable_id }}
                        </p>
                    </div>
                    @endif
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Description</p>
                        <p class="text-base text-gray-900">{{ $document->description ?? '—' }}</p>
                    </div>
                </div>

                <div class="px-6 pb-6 flex justify-end space-x-3">
                    <a href="{{ route('documents.download', $document) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition">
                        Download
                    </a>
                    <a href="{{ route('documents.edit', $document) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition">Edit</a>
                    <form action="{{ route('documents.destroy', $document) }}" method="POST" onsubmit="return confirm('Delete this document?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>