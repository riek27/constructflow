<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success message -->
            @if (session('success'))
                <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-navy">All Projects</h3>
                        <a href="{{ route('projects.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + New Project
                        </a>
                    </div>

                    @if($projects->isEmpty())
                        <p class="text-gray-500">No projects yet. Create your first one.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-navy text-white">
                                    <tr>
                                        <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium uppercase tracking-wider">Client</th>
                                        <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium uppercase tracking-wider">Contract Value</th>
                                        <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 border-b border-gray-200"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($projects as $project)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $project->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $project->client }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($project->contract_value, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($project->status === 'active') bg-green-100 text-green-800 
                                                @elseif($project->status === 'completed') bg-blue-100 text-blue-800 
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($project->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                            <a href="{{ route('projects.edit', $project) }}" class="text-emerald-600 hover:text-emerald-900 mr-3">Edit</a>
                                            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>