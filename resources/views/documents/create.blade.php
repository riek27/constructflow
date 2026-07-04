<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Upload Document') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Project -->
                        <div>
                            <label for="project_id" class="block text-sm font-medium text-gray-700">Project *</label>
                            <select name="project_id" id="project_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="">-- Select Project --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                @endforeach
                            </select>
                            @error('project_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
                            <select name="category" id="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Document Title *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Version -->
                        <div>
                            <label for="version" class="block text-sm font-medium text-gray-700">Version</label>
                            <input type="text" name="version" id="version" value="{{ old('version', '1.0') }}" placeholder="1.0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <!-- Link to specific module (polymorphic) -->
                        <div>
                            <label for="documentable_type" class="block text-sm font-medium text-gray-700">Link to Module (optional)</label>
                            <select name="documentable_type" id="documentable_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" onchange="updateDocumentableId()">
                                <option value="">-- None --</option>
                                <option value="App\Models\Contract" {{ old('documentable_type') == 'App\Models\Contract' ? 'selected' : '' }}>Contract</option>
                                <option value="App\Models\Variation" {{ old('documentable_type') == 'App\Models\Variation' ? 'selected' : '' }}>Variation</option>
                                <option value="App\Models\Payment" {{ old('documentable_type') == 'App\Models\Payment' ? 'selected' : '' }}>Payment</option>
                                <option value="App\Models\Procurement" {{ old('documentable_type') == 'App\Models\Procurement' ? 'selected' : '' }}>Procurement</option>
                            </select>
                        </div>

                        <div>
                            <label for="documentable_id" class="block text-sm font-medium text-gray-700">Module ID</label>
                            <input type="number" name="documentable_id" id="documentable_id" value="{{ old('documentable_id') }}" placeholder="e.g. 5"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <p class="text-xs text-gray-500 mt-1">Enter the ID of the related record (leave blank if none).</p>
                        </div>

                        <!-- File upload -->
                        <div class="md:col-span-2">
                            <label for="file" class="block text-sm font-medium text-gray-700">File * (max 50MB)</label>
                            <input type="file" name="file" id="file" required
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-navy file:text-white hover:file:bg-[#152a46]">
                            @error('file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-navy hover:bg-[#152a46] text-white font-medium py-2 px-6 rounded-lg transition">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateDocumentableId() {
            // Optional: fetch IDs based on selected module via AJAX, but for now manual input.
        }
    </script>
</x-app-layout>