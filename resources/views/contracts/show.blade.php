<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Contract Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 bg-navy text-white">
                    <h3 class="text-2xl font-bold">{{ $contract->contract_number }}</h3>
                    <p class="text-gray-300 mt-1">{{ $contract->project->name }}</p>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><p class="text-sm text-gray-500">Client</p><p class="text-lg font-semibold text-gray-900">{{ $contract->client ?? '—' }}</p></div>
                    <div><p class="text-sm text-gray-500">Status</p><p class="text-lg font-semibold text-gray-900 capitalize">{{ $contract->status }}</p></div>
                    <div><p class="text-sm text-gray-500">Contract Value</p><p class="text-lg font-semibold text-gray-900">${{ number_format($contract->contract_value, 2) }}</p></div>
                    <div><p class="text-sm text-gray-500">Currency</p><p class="text-lg font-semibold text-gray-900">{{ $contract->currency }}</p></div>
                    <div><p class="text-sm text-gray-500">Start Date</p><p class="text-lg font-semibold text-gray-900">{{ $contract->start_date?->format('M d, Y') ?? '—' }}</p></div>
                    <div><p class="text-sm text-gray-500">Completion Date</p><p class="text-lg font-semibold text-gray-900">{{ $contract->completion_date?->format('M d, Y') ?? '—' }}</p></div>
                    <div><p class="text-sm text-gray-500">Retention</p><p class="text-lg font-semibold text-gray-900">{{ $contract->retention_percent }}%</p></div>
                    <div><p class="text-sm text-gray-500">Defects Liability</p><p class="text-lg font-semibold text-gray-900">{{ $contract->defects_liability_months }} months</p></div>
                    <div class="md:col-span-2"><p class="text-sm text-gray-500">Scope Summary</p><p class="text-base text-gray-900">{{ $contract->scope_summary ?? '—' }}</p></div>
                    <div class="md:col-span-2"><p class="text-sm text-gray-500">Payment Terms</p><p class="text-base text-gray-900">{{ $contract->payment_terms ?? '—' }}</p></div>
                </div>

                <div class="px-6 pb-6 flex justify-end space-x-3">
                    <a href="{{ route('contracts.edit', $contract) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition">Edit</a>
                    <form action="{{ route('contracts.destroy', $contract) }}" method="POST" onsubmit="return confirm('Delete this contract?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>