<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Edit Contract') }} – {{ $contract->contract_number }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <form action="{{ route('contracts.update', $contract) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="project_id" class="block text-sm font-medium text-gray-700">Project *</label>
                            <select name="project_id" id="project_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $contract->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                @endforeach
                            </select>
                            @error('project_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="contract_number" class="block text-sm font-medium text-gray-700">Contract Number *</label>
                            <input type="text" name="contract_number" id="contract_number" value="{{ old('contract_number', $contract->contract_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                            @error('contract_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="client" class="block text-sm font-medium text-gray-700">Client</label>
                            <input type="text" name="client" id="client" value="{{ old('client', $contract->client) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label for="contract_value" class="block text-sm font-medium text-gray-700">Contract Value</label>
                            <input type="number" step="0.01" name="contract_value" id="contract_value" value="{{ old('contract_value', $contract->contract_value) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                            <select name="currency" id="currency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="USD" {{ old('currency', $contract->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="EUR" {{ old('currency', $contract->currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
                                <option value="GBP" {{ old('currency', $contract->currency) == 'GBP' ? 'selected' : '' }}>GBP</option>
                                <option value="AED" {{ old('currency', $contract->currency) == 'AED' ? 'selected' : '' }}>AED</option>
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="draft" {{ old('status', $contract->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ old('status', $contract->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ old('status', $contract->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="terminated" {{ old('status', $contract->status) == 'terminated' ? 'selected' : '' }}>Terminated</option>
                            </select>
                        </div>

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $contract->start_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label for="completion_date" class="block text-sm font-medium text-gray-700">Completion Date</label>
                            <input type="date" name="completion_date" id="completion_date" value="{{ old('completion_date', $contract->completion_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label for="retention_percent" class="block text-sm font-medium text-gray-700">Retention %</label>
                            <input type="number" step="0.01" name="retention_percent" id="retention_percent" value="{{ old('retention_percent', $contract->retention_percent) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label for="defects_liability_months" class="block text-sm font-medium text-gray-700">Defects Liability (months)</label>
                            <input type="number" name="defects_liability_months" id="defects_liability_months" value="{{ old('defects_liability_months', $contract->defects_liability_months) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <div class="md:col-span-2">
                            <label for="scope_summary" class="block text-sm font-medium text-gray-700">Scope Summary</label>
                            <textarea name="scope_summary" id="scope_summary" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('scope_summary', $contract->scope_summary) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label for="payment_terms" class="block text-sm font-medium text-gray-700">Payment Terms</label>
                            <textarea name="payment_terms" id="payment_terms" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('payment_terms', $contract->payment_terms) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-navy hover:bg-[#152a46] text-white font-medium py-2 px-6 rounded-lg transition">
                            Update Contract
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>