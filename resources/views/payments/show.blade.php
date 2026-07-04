<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Payment Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 bg-navy text-white">
                    <h3 class="text-2xl font-bold">{{ $payment->invoice_number }}</h3>
                    <p class="text-gray-300 mt-1">{{ $payment->project->name ?? 'No project' }}</p>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><p class="text-sm text-gray-500">Type</p><p class="text-lg font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $payment->type)) }}</p></div>
                    <div><p class="text-sm text-gray-500">Status</p><p class="text-lg font-semibold text-gray-900 capitalize">{{ ucfirst(str_replace('_', ' ', $payment->status)) }}</p></div>
                    <div><p class="text-sm text-gray-500">Contract</p><p class="text-lg font-semibold text-gray-900">{{ $payment->contract->contract_number ?? '—' }}</p></div>
                    <div><p class="text-sm text-gray-500">Variation</p><p class="text-lg font-semibold text-gray-900">{{ $payment->variation->variation_number ?? '—' }}</p></div>
                    <div><p class="text-sm text-gray-500">Amount (excl. VAT)</p><p class="text-lg font-semibold text-gray-900">${{ number_format($payment->amount, 2) }}</p></div>
                    <div><p class="text-sm text-gray-500">VAT</p><p class="text-lg font-semibold text-gray-900">${{ number_format($payment->vat, 2) }}</p></div>
                    <div><p class="text-sm text-gray-500">Total Amount</p><p class="text-lg font-semibold text-gray-900">${{ number_format($payment->total_amount, 2) }}</p></div>
                    <div><p class="text-sm text-gray-500">Invoice Date</p><p class="text-lg font-semibold text-gray-900">{{ $payment->invoice_date?->format('M d, Y') ?? '—' }}</p></div>
                    <div><p class="text-sm text-gray-500">Due Date</p><p class="text-lg font-semibold text-gray-900">{{ $payment->due_date?->format('M d, Y') ?? '—' }}</p></div>
                    <div class="md:col-span-2"><p class="text-sm text-gray-500">Notes</p><p class="text-base text-gray-900">{{ $payment->notes ?? '—' }}</p></div>
                </div>

                <div class="px-6 pb-6 flex justify-end space-x-3">
                    <a href="{{ route('payments.edit', $payment) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition">Edit</a>
                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Delete this payment?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>