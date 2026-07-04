<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Edit Payment') }} – {{ $payment->invoice_number }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <form action="{{ route('payments.update', $payment) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="project_id" class="block text-sm font-medium text-gray-700">Project *</label>
                            <select name="project_id" id="project_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $payment->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="contract_id" class="block text-sm font-medium text-gray-700">Contract (optional)</label>
                            <select name="contract_id" id="contract_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="">-- None --</option>
                                @foreach($contracts as $contract)
                                    <option value="{{ $contract->id }}" {{ old('contract_id', $payment->contract_id) == $contract->id ? 'selected' : '' }}>{{ $contract->contract_number }} ({{ $contract->project->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="variation_id" class="block text-sm font-medium text-gray-700">Variation (optional)</label>
                            <select name="variation_id" id="variation_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="">-- None --</option>
                                @foreach($variations as $variation)
                                    <option value="{{ $variation->id }}" {{ old('variation_id', $payment->variation_id) == $variation->id ? 'selected' : '' }}>{{ $variation->variation_number }} – {{ $variation->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type *</label>
                            <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="client_payment" {{ old('type', $payment->type) == 'client_payment' ? 'selected' : '' }}>Client Payment</option>
                                <option value="payment_application" {{ old('type', $payment->type) == 'payment_application' ? 'selected' : '' }}>Payment Application</option>
                            </select>
                        </div>
                        <div>
                            <label for="invoice_number" class="block text-sm font-medium text-gray-700">Invoice Number *</label>
                            <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number', $payment->invoice_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount (excl. VAT)</label>
                            <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $payment->amount) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="vat" class="block text-sm font-medium text-gray-700">VAT</label>
                            <input type="number" step="0.01" name="vat" id="vat" value="{{ old('vat', $payment->vat) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Amount</label>
                            <input type="number" step="0.01" name="total_amount" id="total_amount" value="{{ old('total_amount', $payment->total_amount) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Auto-calculated if left blank">
                        </div>
                        <div>
                            <label for="invoice_date" class="block text-sm font-medium text-gray-700">Invoice Date</label>
                            <input type="date" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', $payment->invoice_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $payment->due_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                @foreach(['pending', 'approved', 'paid', 'partially_paid', 'overdue'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $payment->status) == $status ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('notes', $payment->notes) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-navy hover:bg-[#152a46] text-white font-medium py-2 px-6 rounded-lg transition">
                            Update Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>