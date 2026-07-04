<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Variations') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">All Variations</h3>
                    <a href="{{ route('variations.create') }}" class="bg-navy hover:bg-[#152a46] text-white font-medium py-2 px-4 rounded-lg transition">
                        + New Variation
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-navy text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Variation #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Project</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Estimated Cost</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($variations as $variation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $variation->variation_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $variation->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $variation->project->name ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($variation->estimated_cost, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @switch($variation->status)
                                            @case('approved') bg-green-100 text-green-800 @break
                                            @case('draft') bg-gray-100 text-gray-800 @break
                                            @case('submitted') bg-blue-100 text-blue-800 @break
                                            @case('under_review') bg-yellow-100 text-yellow-800 @break
                                            @case('rejected') bg-red-100 text-red-800 @break
                                            @case('in_progress') bg-indigo-100 text-indigo-800 @break
                                            @case('completed') bg-emerald-100 text-emerald-800 @break
                                            @default bg-gray-100 text-gray-800
                                        @endswitch">
                                        {{ ucfirst(str_replace('_', ' ', $variation->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('variations.show', $variation) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                    <a href="{{ route('variations.edit', $variation) }}" class="text-emerald-600 hover:text-emerald-900 mr-3">Edit</a>
                                    <form action="{{ route('variations.destroy', $variation) }}" method="POST" class="inline" onsubmit="return confirm('Delete this variation?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No variations found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>