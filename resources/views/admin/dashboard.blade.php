@extends('layouts.admin')

@section('title', 'Executive Dashboard')
@section('breadcrumb', 'Dark Sidebar')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8">
    
    <!-- =========================================================================
         1. METRONIC SUBHEADER / TOOLBAR
         ========================================================================= -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Dashboard Overview</h1>
            <p class="text-xs text-gray-500 mt-0.5 font-medium">Central Hub for Store Performance, Real-Time Orders & Drops Inventory</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg text-xs font-semibold text-gray-700 shadow-xs">
                <i class="fa-regular fa-calendar text-gray-400 text-xs"></i>
                <span>{{ date('M d, Y') }}</span>
            </div>

            <a href="{{ route('admin.products.create') }}" class="kt-btn kt-btn-primary kt-btn-sm text-xs font-semibold shadow-xs flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add New Drop</span>
            </a>
        </div>
    </div>

    <!-- =========================================================================
         2. METRONIC 4-GRID KPI METRIC CARDS
         ========================================================================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Metric 1: Gross Sales -->
        <div class="kt-card p-6 bg-white border border-gray-200/90 rounded-xl shadow-xs hover:border-primary/40 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Gross Revenue</span>
                <div class="flex items-center justify-center size-10 rounded-lg bg-blue-50 text-[#1b84ff]">
                    <i class="fa-solid fa-dollar-sign text-base"></i>
                </div>
            </div>
            <div class="text-2xl lg:text-3xl font-black text-gray-900 mt-3 tracking-tight">
                ${{ number_format($totalRevenue, 2) }}
            </div>
            <div class="flex items-center gap-2 mt-2">
                <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-success font-bold">+18.4%</span>
                <span class="text-xs text-gray-500 font-medium">vs last month</span>
            </div>
        </div>

        <!-- Metric 2: Total Orders -->
        <div class="kt-card p-6 bg-white border border-gray-200/90 rounded-xl shadow-xs hover:border-primary/40 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Orders</span>
                <div class="flex items-center justify-center size-10 rounded-lg bg-emerald-50 text-emerald-600">
                    <i class="fa-solid fa-bag-shopping text-base"></i>
                </div>
            </div>
            <div class="text-2xl lg:text-3xl font-black text-gray-900 mt-3 tracking-tight">
                {{ $totalOrders }}
            </div>
            <div class="flex items-center gap-2 mt-2">
                <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-info font-bold">+12.1%</span>
                <span class="text-xs text-gray-500 font-medium">conversion rate</span>
            </div>
        </div>

        <!-- Metric 3: Active Products -->
        <div class="kt-card p-6 bg-white border border-gray-200/90 rounded-xl shadow-xs hover:border-primary/40 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Active Drops</span>
                <div class="flex items-center justify-center size-10 rounded-lg bg-amber-50 text-amber-600">
                    <i class="fa-solid fa-box text-base"></i>
                </div>
            </div>
            <div class="text-2xl lg:text-3xl font-black text-gray-900 mt-3 tracking-tight">
                {{ $totalProducts }}
            </div>
            <div class="flex items-center gap-2 mt-2">
                <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-warning font-bold">100% In-Stock</span>
                <span class="text-xs text-gray-500 font-medium">Active catalog</span>
            </div>
        </div>

        <!-- Metric 4: Total Customers -->
        <div class="kt-card p-6 bg-white border border-gray-200/90 rounded-xl shadow-xs hover:border-primary/40 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Athletes</span>
                <div class="flex items-center justify-center size-10 rounded-lg bg-purple-50 text-purple-600">
                    <i class="fa-solid fa-users text-base"></i>
                </div>
            </div>
            <div class="text-2xl lg:text-3xl font-black text-gray-900 mt-3 tracking-tight">
                {{ $totalCustomers }}
            </div>
            <div class="flex items-center gap-2 mt-2">
                <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-primary font-bold">Verified</span>
                <span class="text-xs text-gray-500 font-medium">member accounts</span>
            </div>
        </div>

    </div>

    <!-- =========================================================================
         3. APEXCHARTS ANALYTICS: REVENUE & PIPELINE STATUS
         ========================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        
        <!-- Left: Sales & Revenue Momentum Area Chart (8 cols) -->
        <div class="lg:col-span-8 kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs flex flex-col justify-between p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 pb-4">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Sales & Revenue Momentum</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Real-time daily transaction and order distribution</p>
                </div>

                <div class="inline-flex p-1 bg-gray-100 rounded-lg text-xs font-semibold">
                    <button type="button" class="px-3 py-1 bg-white text-gray-900 font-bold rounded-md shadow-xs cursor-pointer">7 Days</button>
                    <button type="button" class="px-3 py-1 text-gray-500 hover:text-gray-900 transition cursor-pointer">30 Days</button>
                </div>
            </div>

            <div id="revenue-analytics-chart" class="w-full min-h-[300px] mt-2"></div>

            <div class="grid grid-cols-3 gap-4 pt-4 border-t border-gray-100 text-center text-xs">
                <div>
                    <div class="text-gray-500 font-medium">Gross Volume</div>
                    <div class="text-base font-bold text-gray-900 mt-0.5">${{ number_format($totalRevenue, 2) }}</div>
                </div>
                <div>
                    <div class="text-gray-500 font-medium">Avg Order Value</div>
                    <div class="text-base font-bold text-emerald-600 mt-0.5">${{ number_format($totalOrders > 0 ? $totalRevenue / $totalOrders : 0, 2) }}</div>
                </div>
                <div>
                    <div class="text-gray-500 font-medium">Fulfillment Rate</div>
                    <div class="text-base font-bold text-[#1b84ff] mt-0.5">99.8%</div>
                </div>
            </div>
        </div>

        <!-- Right: Order Pipeline Status Donut Chart (4 cols) -->
        <div class="lg:col-span-4 kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs flex flex-col justify-between p-6">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="text-base font-bold text-gray-900">Order Pipeline Status</h3>
                <p class="text-xs text-gray-500 mt-0.5">Fulfillment stage breakdown</p>
            </div>

            <div id="order-status-donut" class="w-full flex items-center justify-center min-h-[220px]"></div>

            <div class="grid grid-cols-2 gap-2 pt-3 border-t border-gray-100 text-xs">
                <div class="flex items-center justify-between p-2.5 rounded-lg bg-gray-50 border border-gray-100">
                    <span class="text-amber-600 font-semibold">Pending</span>
                    <span class="font-bold text-gray-900">{{ $statusCounts['pending'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2.5 rounded-lg bg-gray-50 border border-gray-100">
                    <span class="text-[#1b84ff] font-semibold">Processing</span>
                    <span class="font-bold text-gray-900">{{ $statusCounts['processing'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2.5 rounded-lg bg-gray-50 border border-gray-100">
                    <span class="text-cyan-600 font-semibold">Shipped</span>
                    <span class="font-bold text-gray-900">{{ $statusCounts['shipped'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2.5 rounded-lg bg-gray-50 border border-gray-100">
                    <span class="text-emerald-600 font-semibold">Delivered</span>
                    <span class="font-bold text-gray-900">{{ $statusCounts['delivered'] }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- =========================================================================
         4. METRONIC RECENT ORDERS & TOP PRODUCTS
         ========================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        
        <!-- Recent Orders Table (8 cols) -->
        <div class="lg:col-span-8 kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden flex flex-col justify-between">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Recent Customer Orders</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Latest activewear sales and dispatch orders</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
                    <span>View All Orders</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                            <th class="py-3.5 px-5">Order #</th>
                            <th class="py-3.5 px-5">Customer Profile</th>
                            <th class="py-3.5 px-5">Amount</th>
                            <th class="py-3.5 px-5">Fulfillment Status</th>
                            <th class="py-3.5 px-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="py-3.5 px-5 font-mono font-bold text-primary">
                                    {{ $order->order_number }}
                                </td>
                                <td class="py-3.5 px-5">
                                    <div class="font-bold text-gray-900 text-xs">{{ $order->shipping_name ?? $order->customer_name }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono">{{ $order->shipping_email ?? $order->customer_email }}</div>
                                </td>
                                <td class="py-3.5 px-5 font-bold text-gray-900 text-sm">
                                    ${{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="py-3.5 px-5">
                                    <span class="kt-badge kt-badge-sm
                                        @if($order->order_status === 'delivered') kt-badge-outline kt-badge-success
                                        @elseif($order->order_status === 'shipped') kt-badge-outline kt-badge-info
                                        @elseif($order->order_status === 'processing') kt-badge-outline kt-badge-primary
                                        @else kt-badge-outline kt-badge-warning
                                        @endif
                                    ">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-700 hover:text-primary">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400 italic">No customer orders recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Performing Apparel (4 cols) -->
        <div class="lg:col-span-4 kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs p-6 space-y-4">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="text-base font-bold text-gray-900">Top Activewear Drops</h3>
                <p class="text-xs text-gray-500 mt-0.5">Most rated and popular workout apparel</p>
            </div>

            <div class="space-y-3.5">
                @foreach($topProducts as $prod)
                    <div class="flex items-center gap-3 p-2.5 rounded-lg border border-gray-100 hover:border-gray-200 bg-gray-50/50 transition">
                        <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-11 h-11 rounded-lg object-cover bg-gray-100 shrink-0 border border-gray-200">
                        <div class="min-w-0 flex-1">
                            <h4 class="font-bold text-xs text-gray-900 truncate">{{ $prod->name }}</h4>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-xs font-black text-gray-900">${{ number_format($prod->price, 2) }}</span>
                                <span class="text-[10px] text-amber-500 font-bold flex items-center gap-0.5">
                                    <i class="fa-solid fa-star text-[10px]"></i> {{ number_format($prod->rating, 1) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Revenue Area Chart
        const chartDates = {!! json_encode($chartDates) !!};
        const chartRevenue = {!! json_encode($chartRevenue) !!};
        const chartOrders = {!! json_encode($chartOrders) !!};

        const revenueOptions = {
            series: [
                { name: 'Revenue ($)', data: chartRevenue },
                { name: 'Orders Count', data: chartOrders }
            ],
            chart: {
                type: 'area',
                height: 280,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            colors: ['#1b84ff', '#17c653'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2.5 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.05,
                    stops: [20, 100]
                }
            },
            xaxis: {
                categories: chartDates,
                labels: { style: { colors: '#78829d', fontSize: '11px', fontFamily: 'Inter' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: { style: { colors: '#78829d', fontSize: '11px', fontFamily: 'Inter' } }
            },
            grid: {
                borderColor: '#f1f1f4',
                strokeDashArray: 3
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                labels: { colors: '#4b5675' }
            }
        };

        const revChart = new ApexCharts(document.querySelector("#revenue-analytics-chart"), revenueOptions);
        revChart.render();

        // 2. Order Status Donut Chart
        const statusCounts = {!! json_encode(array_values($statusCounts)) !!};
        const statusLabels = ['Pending', 'Processing', 'Shipped', 'Delivered'];

        const donutOptions = {
            series: statusCounts.reduce((a, b) => a + b, 0) > 0 ? statusCounts : [1, 0, 0, 0],
            chart: {
                type: 'donut',
                height: 220,
                fontFamily: 'Inter, sans-serif'
            },
            labels: statusLabels,
            colors: ['#f6c000', '#1b84ff', '#7239ea', '#17c653'],
            stroke: { show: false },
            dataLabels: { enabled: false },
            legend: { show: false },
            plotOptions: {
                pie: {
                    donut: {
                        size: '72%',
                        labels: {
                            show: true,
                            name: { show: true, fontSize: '12px', color: '#78829d' },
                            value: { show: true, fontSize: '20px', fontWeight: '800', color: '#071437' },
                            total: {
                                show: true,
                                label: 'Total Orders',
                                color: '#78829d',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            }
        };

        const donutChart = new ApexCharts(document.querySelector("#order-status-donut"), donutOptions);
        donutChart.render();
    });
</script>
@endpush