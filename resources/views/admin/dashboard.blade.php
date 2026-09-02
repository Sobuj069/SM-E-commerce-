@extends('layouts.admin')

@section('title', 'Executive Analytics Dashboard')
@section('breadcrumb', 'Analytics')

@section('content')
<div class="space-y-8">
    
    <!-- =========================================================================
         1. TOP WELCOME HIGHLIGHT BAR (METRONIC DEMO 1 HEADER)
         ========================================================================= -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-[#1e1e2d] via-[#1a1f37] to-[#1e1e2d] border border-slate-800 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight">Welcome back, SM Administrator! 🎉</h1>
                <span class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-400 text-[10px] font-black border border-emerald-500/30 uppercase">Active</span>
            </div>
            <p class="text-xs text-slate-400">
                Here is your daily activewear storefront summary. You have <strong class="text-white font-bold">{{ $totalOrders }} orders</strong> and <strong class="text-emerald-400 font-bold">${{ number_format($totalRevenue, 2) }}</strong> in gross volume.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black transition shadow-lg shadow-indigo-600/30 flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add New Drop</span>
            </a>
            <a href="{{ route('home') }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 text-white text-xs font-bold transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-indigo-400"></i>
                <span>View Store</span>
            </a>
        </div>
    </div>

    <!-- =========================================================================
         2. METRONIC 4-GRID KPI METRIC CARDS
         ========================================================================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Metric 1: Gross Sales -->
        <div class="p-6 rounded-2xl bg-[#0f172a] border border-slate-800 shadow-xl relative overflow-hidden group hover:border-slate-700 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Gross Revenue</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-500/15 text-indigo-400 flex items-center justify-center text-sm font-black border border-indigo-500/20">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-4 tracking-tight">${{ number_format($totalRevenue, 2) }}</div>
            <div class="text-[11px] text-emerald-400 font-bold mt-2 flex items-center gap-1.5">
                <span class="px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-black text-[10px]">+18.4%</span>
                <span class="text-slate-400 font-medium">vs last month</span>
            </div>
        </div>

        <!-- Metric 2: Total Orders -->
        <div class="p-6 rounded-2xl bg-[#0f172a] border border-slate-800 shadow-xl relative overflow-hidden group hover:border-slate-700 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Orders</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/15 text-emerald-400 flex items-center justify-center text-sm font-black border border-emerald-500/20">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-4 tracking-tight">{{ $totalOrders }}</div>
            <div class="text-[11px] text-emerald-400 font-bold mt-2 flex items-center gap-1.5">
                <span class="px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-black text-[10px]">+12.1%</span>
                <span class="text-slate-400 font-medium">conversion rate</span>
            </div>
        </div>

        <!-- Metric 3: Active Products -->
        <div class="p-6 rounded-2xl bg-[#0f172a] border border-slate-800 shadow-xl relative overflow-hidden group hover:border-slate-700 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Catalog</span>
                <div class="w-10 h-10 rounded-xl bg-amber-500/15 text-amber-400 flex items-center justify-center text-sm font-black border border-amber-500/20">
                    <i class="fa-solid fa-box"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-4 tracking-tight">{{ $totalProducts }}</div>
            <div class="text-[11px] text-amber-400 font-bold mt-2 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                <span>100% In-Stock & Available</span>
            </div>
        </div>

        <!-- Metric 4: Total Customers -->
        <div class="p-6 rounded-2xl bg-[#0f172a] border border-slate-800 shadow-xl relative overflow-hidden group hover:border-slate-700 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Athletes</span>
                <div class="w-10 h-10 rounded-xl bg-violet-500/15 text-violet-400 flex items-center justify-center text-sm font-black border border-violet-500/20">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-4 tracking-tight">{{ $totalCustomers }}</div>
            <div class="text-[11px] text-violet-300 font-bold mt-2 flex items-center gap-1">
                <span>Verified accounts</span>
            </div>
        </div>

    </div>

    <!-- =========================================================================
         3. APEXCHARTS ANALYTICS: REVENUE & ORDER FULFILLMENT
         ========================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Revenue Trend Line/Area Chart -->
        <div class="lg:col-span-8 p-6 rounded-2xl bg-[#0f172a] border border-slate-800 shadow-xl space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-800 pb-4">
                <div>
                    <h3 class="text-base font-black text-white">Sales & Revenue Momentum</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Real-time transaction tracking across 7 days</p>
                </div>
                <div class="inline-flex items-center gap-1 p-1 bg-slate-900 rounded-xl border border-slate-800">
                    <span class="text-xs font-black text-white bg-indigo-600 px-3 py-1 rounded-lg">7 Days</span>
                    <span class="text-xs font-bold text-slate-400 px-3 py-1 hover:text-white cursor-pointer">30 Days</span>
                </div>
            </div>
            
            <div id="revenue-analytics-chart" class="w-full min-h-[320px]"></div>

            <div class="grid grid-cols-3 gap-4 pt-4 border-t border-slate-800 text-xs text-center">
                <div>
                    <div class="text-slate-400 font-medium">Gross Volume</div>
                    <div class="text-white font-black text-sm mt-0.5">${{ number_format($totalRevenue, 2) }}</div>
                </div>
                <div>
                    <div class="text-slate-400 font-medium">Average Order</div>
                    <div class="text-emerald-400 font-black text-sm mt-0.5">${{ number_format($totalOrders > 0 ? $totalRevenue / $totalOrders : 0, 2) }}</div>
                </div>
                <div>
                    <div class="text-slate-400 font-medium">Success Rate</div>
                    <div class="text-indigo-400 font-black text-sm mt-0.5">99.8%</div>
                </div>
            </div>
        </div>

        <!-- Order Fulfillment Distribution Donut Chart -->
        <div class="lg:col-span-4 p-6 rounded-2xl bg-[#0f172a] border border-slate-800 shadow-xl space-y-4 flex flex-col justify-between">
            <div class="border-b border-slate-800 pb-4">
                <h3 class="text-base font-black text-white">Order Pipeline Status</h3>
                <p class="text-xs text-slate-400 mt-0.5">Fulfillment stage breakdown</p>
            </div>

            <div id="order-status-donut" class="w-full flex items-center justify-center min-h-[240px]"></div>

            <div class="grid grid-cols-2 gap-2 pt-3 border-t border-slate-800 text-xs">
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-900 border border-slate-800">
                    <span class="text-amber-400 font-bold">Pending</span>
                    <span class="font-black text-white">{{ $statusCounts['pending'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-900 border border-slate-800">
                    <span class="text-indigo-400 font-bold">Processing</span>
                    <span class="font-black text-white">{{ $statusCounts['processing'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-900 border border-slate-800">
                    <span class="text-cyan-400 font-bold">Shipped</span>
                    <span class="font-black text-white">{{ $statusCounts['shipped'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-900 border border-slate-800">
                    <span class="text-emerald-400 font-bold">Delivered</span>
                    <span class="font-black text-white">{{ $statusCounts['delivered'] }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- =========================================================================
         4. RECENT ORDERS & TOP PERFORMING APPAREL
         ========================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Recent Orders Table -->
        <div class="lg:col-span-8 bg-[#0f172a] border border-slate-800 rounded-2xl shadow-xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-black text-white">Recent Customer Orders</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Latest activewear sales and dispatch orders</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 transition flex items-center gap-1">
                    <span>View All Orders</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 border-b border-slate-800 font-black uppercase text-[10px] tracking-wider bg-slate-900/60">
                            <th class="py-3.5 px-5">Order #</th>
                            <th class="py-3.5 px-5">Customer</th>
                            <th class="py-3.5 px-5">Amount</th>
                            <th class="py-3.5 px-5">Status</th>
                            <th class="py-3.5 px-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 font-medium">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-slate-900/40 transition">
                                <td class="py-3.5 px-5 font-mono font-bold text-indigo-400">
                                    {{ $order->order_number }}
                                </td>
                                <td class="py-3.5 px-5">
                                    <div class="font-bold text-white text-xs">{{ $order->shipping_name ?? $order->customer_name }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">{{ $order->shipping_email ?? $order->customer_email }}</div>
                                </td>
                                <td class="py-3.5 px-5 font-black text-white text-sm">
                                    ${{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="py-3.5 px-5">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                        @if($order->order_status === 'delivered') bg-emerald-500/15 text-emerald-400 border border-emerald-500/30
                                        @elseif($order->order_status === 'shipped') bg-cyan-500/15 text-cyan-400 border border-cyan-500/30
                                        @elseif($order->order_status === 'processing') bg-indigo-500/15 text-indigo-400 border border-indigo-500/30
                                        @else bg-amber-500/15 text-amber-400 border border-amber-500/30
                                        @endif
                                    ">
                                        {{ $order->order_status }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-indigo-600 hover:text-white text-slate-300 text-xs font-bold transition border border-slate-800">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500 italic">No orders received yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Performing Activewear Drops -->
        <div class="lg:col-span-4 bg-[#0f172a] border border-slate-800 rounded-2xl shadow-xl p-6 space-y-4">
            <div class="border-b border-slate-800 pb-4">
                <h3 class="text-base font-black text-white">Top Activewear Drops</h3>
                <p class="text-xs text-slate-400 mt-0.5">Most rated and purchased gymwear</p>
            </div>

            <div class="space-y-3.5">
                @foreach($topProducts as $prod)
                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-slate-900 border border-slate-800">
                        <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-11 h-11 rounded-lg object-cover bg-zinc-900 shrink-0 border border-slate-800">
                        <div class="min-w-0 flex-1">
                            <h4 class="font-bold text-xs text-white truncate">{{ $prod->name }}</h4>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-xs font-black text-emerald-400">${{ number_format($prod->price, 2) }}</span>
                                <span class="text-[10px] text-amber-400 font-bold flex items-center gap-0.5">
                                    <i class="fa-solid fa-star text-[9px]"></i> {{ number_format($prod->rating, 1) }}
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
                height: 300,
                toolbar: { show: false },
                background: 'transparent'
            },
            colors: ['#6366f1', '#10b981'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100]
                }
            },
            xaxis: {
                categories: chartDates,
                labels: { style: { colors: '#94a3b8', fontSize: '11px', fontFamily: 'Inter' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: { style: { colors: '#94a3b8', fontSize: '11px', fontFamily: 'Inter' } }
            },
            grid: {
                borderColor: '#1e293b',
                strokeDashArray: 4
            },
            theme: { mode: 'dark' },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                labels: { colors: '#cbd5e1' }
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
                height: 240,
                background: 'transparent'
            },
            labels: statusLabels,
            colors: ['#f59e0b', '#6366f1', '#06b6d4', '#10b981'],
            stroke: { show: false },
            dataLabels: { enabled: false },
            legend: { show: false },
            theme: { mode: 'dark' },
            plotOptions: {
                pie: {
                    donut: {
                        size: '72%',
                        labels: {
                            show: true,
                            name: { show: true, fontSize: '12px', color: '#94a3b8' },
                            value: { show: true, fontSize: '20px', fontWeight: '900', color: '#ffffff' },
                            total: {
                                show: true,
                                label: 'Total Orders',
                                color: '#94a3b8',
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