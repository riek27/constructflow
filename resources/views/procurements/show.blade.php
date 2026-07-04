<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Purchase Order Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 bg-navy text-white">
                    <h3 class="text-2xl font-bold">{{ $procurement->po_number }}</h3>
                    <p class="text-gray-300 mt-1">{{ $procurement->project->name ?? 'No project' }}</p>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><p class="text-sm text-gray-500">Supplier</p><p class="text-lg font-semibold text-gray-900">{{ $procurement->supplier->name ?? '—' }}</p></div>
                    <div><p class="text-sm text-gray-500">Status</p><p class="text-lg font-semibold text-gray-900 capitalize">{{ $procurement->status }}</p></div>
                    <div><p class="text-sm text-gray-500">Description</p><p class="text-lg font-semibold text-gray-900">{{ $procurement->description ?? '—' }}</p></div>
                    <div><p class="text-sm text-gray-500">Quantity</p><p class="text-lg font-semibold text-gray-900">{{ $procurement->quantity }} {{ $procurement->unit }}</p></div>
                    <div><p class="text-sm text-gray-500">Unit Cost</p><p class="text-lg font-semibold text-gray-900">${{ number_format($procurement->unit_cost, 2) }}</p></div>
                    <div><p class="text-sm text-gray-500">Total Cost</p><p class="text-lg font-semibold text-gray-900">${{ number_format($procurement->total_cost, 2) }}</p></div>
                    <div><p class="text-sm text-gray-500">Order Date</p><p class="text-lg font-semibold text-gray-900">{{ $procurement->order_date?->format('M d, Y') ?? '—' }}</p></div>
                    <div><p class="text-sm text-gray-500">Delivery Date</p><p class="text-lg font-semibold text-gray-900">{{ $procurement->delivery_date?->format('M d, Y') ?? '—' }}</p></div>
                </div>

                <div class="px-6 pb-6 flex justify-end space-x-3">
                    <a href="{{ route('procurements.edit', $procurement) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition">Edit</a>
                    <form action="{{ route('procurements.destroy', $procurement) }}" method="POST" onsubmit="return confirm('Delete this PO?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>