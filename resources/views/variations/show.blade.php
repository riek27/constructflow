<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Variation Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 bg-navy text-white">
                    <h3 class="text-2xl font-bold">{{ $variation->variation_number }}</h3>
                    <p class="text-gray-300 mt-1">{{ $variation->title }}</p>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><p class="text-sm text-gray-500">Project</p><p class="text-lg font-semibold text-gray-900">{{ $variation->project->name ?? '—' }}</p></div>
                    <div><p class="text-sm text-gray-500">Contract</p><p class="text-lg font-semibold text-gray-900">{{ $variation->contract->contract_number ?? '—' }}</p></div>
                    <div><p class="text-sm text-gray-500">Status</p><p class="text-lg font-semibold text-gray-900 capitalize">{{ ucfirst(str_replace('_', ' ', $variation->status)) }}</p></div>
                    <div><p class="text-sm text-gray-500">Estimated Cost</p><p class="text-lg font-semibold text-gray-900">${{ number_format($variation->estimated_cost, 2) }}</p></div>
                    <div><p class="text-sm text-gray-500">Approved Cost</p><p class="text-lg font-semibold text-gray-900">${{ number_format($variation->approved_cost, 2) }}</p></div>
                    <div><p class="text-sm text-gray-500">Quotation Amount</p><p class="text-lg font-semibold text-gray-900">${{ number_format($variation->quotation_amount, 2) }}</p></div>
                    <div class="md:col-span-2"><p class="text-sm text-gray-500">Description</p><p class="text-base text-gray-900">{{ $variation->description ?? '—' }}</p></div>
                </div>

                <div class="px-6 pb-6 flex justify-end space-x-3">
                    <a href="{{ route('variations.edit', $variation) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition">Edit</a>
                    <form action="{{ route('variations.destroy', $variation) }}" method="POST" onsubmit="return confirm('Delete this variation?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>