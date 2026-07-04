<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Report Type</label>
                        <select name="type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="projects" {{ $type == 'projects' ? 'selected' : '' }}>Projects</option>
                            <option value="contracts" {{ $type == 'contracts' ? 'selected' : '' }}>Contracts</option>
                            <option value="variations" {{ $type == 'variations' ? 'selected' : '' }}>Variations</option>
                            <option value="payments" {{ $type == 'payments' ? 'selected' : '' }}>Payments</option>
                            <option value="procurements" {{ $type == 'procurements' ? 'selected' : '' }}>Procurement</option>
                            <option value="documents" {{ $type == 'documents' ? 'selected' : '' }}>Documents</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Project</label>
                        <select name="project_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">All Projects</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ $projectId == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <input type="text" name="status" value="{{ $status }}" placeholder="e.g., active, paid" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">From</label>
                        <input type="date" name="from" value="{{ $from }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">To</label>
                        <input type="date" name="to" value="{{ $to }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="flex items-end space-x-2 md:col-span-5">
                        <button type="submit" class="bg-navy hover:bg-[#152a46] text-white font-medium py-2 px-4 rounded-lg transition">Filter</button>
                        <a href="{{ route('reports.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition">Clear</a>
                    </div>
                </form>
            </div>

            <!-- Export Buttons -->
            <div class="flex justify-end space-x-3 mb-4">
                <a href="{{ route('reports.export.excel', request()->query()) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition">
                    📊 Export Excel
                </a>
                <a href="{{ route('reports.export.pdf', request()->query()) }}" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">
                    📄 Export PDF
                </a>
            </div>

            <!-- Results Table -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $type }} Report</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-navy text-white">
                            @switch($type)
                                @case('projects')
                                    <tr><th class="px-6 py-3 text-left text-xs font-medium uppercase">Name</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Client</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Value</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Status</th></tr>
                                    @break
                                @case('contracts')
                                    <tr><th class="px-6 py-3 text-left text-xs font-medium uppercase">Project</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Contract #</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Client</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Value</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Status</th></tr>
                                    @break
                                @case('variations')
                                    <tr><th class="px-6 py-3 text-left text-xs font-medium uppercase">Project</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Variation #</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Title</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Estimated</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Status</th></tr>
                                    @break
                                @case('payments')
                                    <tr><th class="px-6 py-3 text-left text-xs font-medium uppercase">Project</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Invoice #</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Total</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Due</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Status</th></tr>
                                    @break
                                @case('procurements')
                                    <tr><th class="px-6 py-3 text-left text-xs font-medium uppercase">Project</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">PO #</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Supplier</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Total</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Status</th></tr>
                                    @break
                                @case('documents')
                                    <tr><th class="px-6 py-3 text-left text-xs font-medium uppercase">Project</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Title</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Category</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">File</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Uploaded</th></tr>
                                    @break
                            @endswitch
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($data as $item)
                                <tr class="hover:bg-gray-50">
                                    @if($type == 'projects')
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->client }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">${{ number_format($item->contract_value, 0) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->status }}</td>
                                    @elseif($type == 'contracts')
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->project->name ?? '' }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->contract_number }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->client }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">${{ number_format($item->contract_value, 0) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->status }}</td>
                                    @elseif($type == 'variations')
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->project->name ?? '' }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->variation_number }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->title }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">${{ number_format($item->estimated_cost, 0) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->status }}</td>
                                    @elseif($type == 'payments')
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->project->name ?? '' }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->invoice_number }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">${{ number_format($item->total_amount, 0) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->due_date?->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->status }}</td>
                                    @elseif($type == 'procurements')
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->project->name ?? '' }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->po_number }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->supplier->name ?? $item->supplier_name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">${{ number_format($item->total_cost, 0) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->status }}</td>
                                    @elseif($type == 'documents')
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->project->name ?? '' }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->title }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->category }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->original_name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->created_at->format('M d, Y') }}</td>
                                    @endif
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No records found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>