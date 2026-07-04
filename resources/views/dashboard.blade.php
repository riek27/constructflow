<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-navy leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Key Metrics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Projects -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Projects</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalProjects }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Projects -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-500 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Active Projects</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $activeProjects }}</p>
                        </div>
                        <div class="p-3 bg-emerald-100 rounded-full">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Contract Value -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-indigo-500 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Contract Value</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($totalContractValue, 0) }}</p>
                        </div>
                        <div class="p-3 bg-indigo-100 rounded-full">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Outstanding Payments -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Outstanding Payments</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($outstandingPayments, 0) }}</p>
                        </div>
                        <div class="p-3 bg-orange-100 rounded-full">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Row: Financial Cards (now dynamic) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-400">
                    <p class="text-sm text-gray-500">Approved Variations Value</p>
                    <p class="text-xl font-bold text-gray-900 mt-1">${{ number_format($approvedVariationsValue, 0) }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-400">
                    <p class="text-sm text-gray-500">Pending Variations Value</p>
                    <p class="text-xl font-bold text-gray-900 mt-1">${{ number_format($pendingVariationsValue, 0) }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                    <p class="text-sm text-gray-500">Payments Received</p>
                    <p class="text-xl font-bold text-gray-900 mt-1">${{ number_format($paymentsReceived, 0) }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-cyan-500">
                    <p class="text-sm text-gray-500">Procurement Value</p>
                    <p class="text-xl font-bold text-gray-900 mt-1">${{ number_format($procurementValue, 0) }}</p>
                </div>
            </div>

            <!-- Charts Row (LIVE CHARTS) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Monthly Revenue Chart -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Revenue</h3>
                    <div class="h-64">
                        <canvas id="monthlyRevenueChart"></canvas>
                    </div>
                </div>
                <!-- Variation Trend Chart -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Variation Trend</h3>
                    <div class="h-64">
                        <canvas id="variationTrendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Projects Table (dynamic) -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Projects</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-navy text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Project</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Contract Value</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Outstanding</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($recentProjects as $project)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $project->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($project->status === 'active') bg-green-100 text-green-800 
                                        @elseif($project->status === 'completed') bg-blue-100 text-blue-800 
                                        @elseif($project->status === 'on-hold') bg-yellow-100 text-yellow-800 
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($project->contract_value, 0) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">—</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No projects found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Variations & Payments Side by Side (now dynamic) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Variations -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Variations</h3>
                    @forelse ($recentVariations as $variation)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                            <div>
                                <a href="{{ route('variations.show', $variation) }}" class="text-sm font-medium text-navy hover:text-emerald-600">
                                    {{ $variation->variation_number }} – {{ Str::limit($variation->title, 40) }}
                                </a>
                                <p class="text-xs text-gray-500">{{ $variation->project->name ?? '' }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full 
                                @if($variation->status == 'approved') bg-green-100 text-green-800
                                @elseif($variation->status == 'rejected') bg-red-100 text-red-800
                                @elseif($variation->status == 'draft') bg-gray-100 text-gray-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $variation->status)) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No variations yet.</p>
                    @endforelse
                </div>

                <!-- Recent Payments -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Payments</h3>
                    @forelse ($recentPayments as $payment)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                            <div>
                                <a href="{{ route('payments.show', $payment) }}" class="text-sm font-medium text-navy hover:text-emerald-600">
                                    {{ $payment->invoice_number }}
                                </a>
                                <p class="text-xs text-gray-500">{{ $payment->project->name ?? '' }} · ${{ number_format($payment->total_amount, 0) }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full 
                                @if($payment->status == 'paid') bg-green-100 text-green-800
                                @elseif($payment->status == 'overdue') bg-red-100 text-red-800
                                @elseif($payment->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No payments yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activity Logs (dynamic) -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activities</h3>
                @forelse ($recentActivities as $activity)
                    <div class="flex items-center text-sm text-gray-500 py-2 border-b border-gray-100 last:border-0">
                        <span class="w-2 h-2 rounded-full mr-3
                            @if($activity->action == 'created') bg-green-500
                            @elseif($activity->action == 'updated') bg-blue-500
                            @elseif($activity->action == 'deleted') bg-red-500
                            @else bg-gray-500 @endif">
                        </span>
                        <span class="font-medium mr-1">{{ $activity->user->name ?? 'System' }}</span>
                        <span>{{ $activity->description }}</span>
                        <span class="ml-auto text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-gray-500">No activities yet.</p>
                @endforelse
            </div>

        </div>
    </div>

    <!-- Chart.js CDN and rendering -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        // Prepare data from PHP
        const monthlyLabels = @json($monthlyRevenueLabels);
        const monthlyData = @json($monthlyRevenueData);

        const variationLabels = @json($variationTrendLabels);
        const variationData = @json($variationTrendData);

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        };

        // Monthly Revenue Chart (bar)
        if (monthlyLabels.length > 0) {
            new Chart(document.getElementById('monthlyRevenueChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        data: monthlyData,
                        backgroundColor: '#10B981', // emerald
                        borderRadius: 6,
                    }]
                },
                options: chartOptions
            });
        } else {
            document.getElementById('monthlyRevenueChart').parentElement.innerHTML =
                '<p class="text-center text-gray-500 mt-12">No paid invoices yet.</p>';
        }

        // Variation Trend Chart (line)
        if (variationLabels.length > 0) {
            new Chart(document.getElementById('variationTrendChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: variationLabels,
                    datasets: [{
                        label: 'Approved Variations',
                        data: variationData,
                        borderColor: '#2563EB',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#2563EB',
                    }]
                },
                options: chartOptions
            });
        } else {
            document.getElementById('variationTrendChart').parentElement.innerHTML =
                '<p class="text-center text-gray-500 mt-12">No approved variations yet.</p>';
        }
    </script>
</x-app-layout>