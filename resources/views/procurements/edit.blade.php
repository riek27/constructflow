<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Edit Purchase Order') }} – {{ $procurement->po_number }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <form action="{{ route('procurements.update', $procurement) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="project_id" class="block text-sm font-medium text-gray-700">Project *</label>
                            <select name="project_id" id="project_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $procurement->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="">-- Select Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $procurement->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="po_number" class="block text-sm font-medium text-gray-700">PO Number *</label>
                            <input type="text" name="po_number" id="po_number" value="{{ old('po_number', $procurement->po_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('description', $procurement->description) }}</textarea>
                        </div>
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" step="0.01" name="quantity" id="quantity" value="{{ old('quantity', $procurement->quantity) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                            <input type="text" name="unit" id="unit" value="{{ old('unit', $procurement->unit) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="unit_cost" class="block text-sm font-medium text-gray-700">Unit Cost</label>
                            <input type="number" step="0.01" name="unit_cost" id="unit_cost" value="{{ old('unit_cost', $procurement->unit_cost) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="total_cost" class="block text-sm font-medium text-gray-700">Total Cost</label>
                            <input type="number" step="0.01" name="total_cost" id="total_cost" value="{{ old('total_cost', $procurement->total_cost) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Auto-calculated if blank">
                        </div>
                        <div>
                            <label for="order_date" class="block text-sm font-medium text-gray-700">Order Date</label>
                            <input type="date" name="order_date" id="order_date" value="{{ old('order_date', $procurement->order_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="delivery_date" class="block text-sm font-medium text-gray-700">Delivery Date</label>
                            <input type="date" name="delivery_date" id="delivery_date" value="{{ old('delivery_date', $procurement->delivery_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                @foreach(['requested', 'approved', 'ordered', 'delivered', 'closed'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $procurement->status) == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-navy hover:bg-[#152a46] text-white font-medium py-2 px-6 rounded-lg transition">
                            Update PO
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>