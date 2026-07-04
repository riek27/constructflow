<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Documents') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search & Filters -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('documents.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title / filename…"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                    </div>
                    <div>
                        <select name="project" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            <option value="">All Projects</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ request('project') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="category" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="bg-navy hover:bg-[#152a46] text-white text-sm font-medium py-2 px-4 rounded-lg transition">
                            Filter
                        </button>
                        <a href="{{ route('documents.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium py-2 px-4 rounded-lg transition">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Documents List -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">All Documents</h3>
                    <a href="{{ route('documents.create') }}" class="bg-navy hover:bg-[#152a46] text-white font-medium py-2 px-4 rounded-lg transition">
                        + Upload Document
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-navy text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Project</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">File</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Size</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Uploaded</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($documents as $document)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $document->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $document->project->name ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $document->category }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $document->original_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($document->size / 1024, 1) }} KB</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" title="{{ $document->created_at }}">
                                    {{ $document->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('documents.download', $document) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Download</a>
                                    <a href="{{ route('documents.show', $document) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                    <a href="{{ route('documents.edit', $document) }}" class="text-emerald-600 hover:text-emerald-900 mr-3">Edit</a>
                                    <form action="{{ route('documents.destroy', $document) }}" method="POST" class="inline" onsubmit="return confirm('Delete this document?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No documents found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $documents->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>