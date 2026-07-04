<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Edit Document') }} – {{ $document->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <form action="{{ route('documents.update', $document) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="project_id" class="block text-sm font-medium text-gray-700">Project *</label>
                            <select name="project_id" id="project_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $document->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
                            <select name="category" id="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $document->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $document->title) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="version" class="block text-sm font-medium text-gray-700">Version</label>
                            <input type="text" name="version" id="version" value="{{ old('version', $document->version) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700">Replace File (max 50MB)</label>
                            <input type="file" name="file" id="file"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-navy file:text-white hover:file:bg-[#152a46]">
                            <p class="text-xs text-gray-500 mt-1">Current file: {{ $document->original_name }} ({{ number_format($document->size / 1024, 1) }} KB)</p>
                        </div>
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('description', $document->description) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-navy hover:bg-[#152a46] text-white font-medium py-2 px-6 rounded-lg transition">
                            Update Document
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>