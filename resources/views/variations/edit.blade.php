<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Edit Variation') }} – {{ $variation->variation_number }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <form action="{{ route('variations.update', $variation) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="project_id" class="block text-sm font-medium text-gray-700">Project *</label>
                            <select name="project_id" id="project_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $variation->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="contract_id" class="block text-sm font-medium text-gray-700">Contract (optional)</label>
                            <select name="contract_id" id="contract_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="">-- None --</option>
                                @foreach($contracts as $contract)
                                    <option value="{{ $contract->id }}" {{ old('contract_id', $variation->contract_id) == $contract->id ? 'selected' : '' }}>{{ $contract->contract_number }} ({{ $contract->project->name }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="variation_number" class="block text-sm font-medium text-gray-700">Variation Number *</label>
                            <input type="text" name="variation_number" id="variation_number" value="{{ old('variation_number', $variation->variation_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $variation->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('description', $variation->description) }}</textarea>
                        </div>

                        <div>
                            <label for="estimated_cost" class="block text-sm font-medium text-gray-700">Estimated Cost</label>
                            <input type="number" step="0.01" name="estimated_cost" id="estimated_cost" value="{{ old('estimated_cost', $variation->estimated_cost) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label for="approved_cost" class="block text-sm font-medium text-gray-700">Approved Cost</label>
                            <input type="number" step="0.01" name="approved_cost" id="approved_cost" value="{{ old('approved_cost', $variation->approved_cost) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label for="quotation_amount" class="block text-sm font-medium text-gray-700">Quotation Amount</label>
                            <input type="number" step="0.01" name="quotation_amount" id="quotation_amount" value="{{ old('quotation_amount', $variation->quotation_amount) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                @foreach(['draft', 'submitted', 'under_review', 'approved', 'rejected', 'in_progress', 'completed'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $variation->status) == $status ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-navy hover:bg-[#152a46] text-white font-medium py-2 px-6 rounded-lg transition">
                            Update Variation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>