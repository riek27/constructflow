<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Project Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 bg-navy text-white">
                    <h3 class="text-2xl font-bold">{{ $project->name }}</h3>
                    <p class="text-gray-300 mt-1">{{ $project->client ?? 'No client' }}</p>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <p class="text-lg font-semibold text-gray-900 capitalize">{{ $project->status }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contract Value</p>
                        <p class="text-lg font-semibold text-gray-900">${{ number_format($project->contract_value, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Location</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $project->location ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Consultant</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $project->consultant ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Start Date</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $project->start_date ? $project->start_date->format('M d, Y') : '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">End Date</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $project->end_date ? $project->end_date->format('M d, Y') : '—' }}</p>
                    </div>
                </div>

                <div class="px-6 pb-6 flex justify-end space-x-3">
                    <a href="{{ route('projects.edit', $project) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition">
                        Edit
                    </a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST"
                          onsubmit="return confirm('Delete this project?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>