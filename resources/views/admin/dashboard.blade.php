@extends('layouts.admin')

@section('title', 'Executive Analytics Dashboard')
@section('breadcrumb', 'Analytics')

@section('content')
<div class="space-y-8">
    
    <!-- =========================================================================
         1. METRONIC KPI STAT METRIC CARDS (4-Grid)
         ========================================================================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Gross Revenue -->
        <div class="p-6 rounded-2xl bg-[#1e1e2d] border border-[#2b2b40] shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none group-hover:bg-indigo-500/20 transition-all"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Gross Revenue</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-500/15 text-indigo-400 flex items-center justify-center text-sm font-black">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-4 tracking-tight">${{ number_format($totalRevenue, 2) }}</div>
            <div class="text-[11px] text-emerald-400 font-bold mt-2 flex items-center gap-1.5">
                <span class="px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-black text-[10px]">+18.4%</span>
                <span class="text-gray-400 font-medium">vs last month</span>
            </div>
        </div>

        <!-- Card 2: Total Orders -->
        <div class="p-6 rounded-2xl bg-[#1e1e2d] border border-[#2b2b40] shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none group-hover:bg-emerald-500/20 transition-all"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Orders</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/15 text-emerald-400 flex items-center justify-center text-sm font-black">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-4 tracking-tight">{{ $totalOrders }}</div>
            <div class="text-[11px] text-emerald-400 font-bold mt-2 flex items-center gap-1.5">
                <span class="px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-black text-[10px]">+12.1%</span>
                <span class="text-gray-400 font-medium">conversion rate</span>
            </div>
        </div>

        <!-- Card 3: Active Products -->
        <div class="p-6 rounded-2xl bg-[#1e1e2d] border border-[#2b2b40] shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl pointer-events-none group-hover:bg-amber-500/20 transition-all"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Active Catalog</span>
                <div class="w-10 h-10 rounded-xl bg-amber-500/15 text-amber-400 flex items-center justify-center text-sm font-black">
                    <i class="fa-solid fa-box"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-4 tracking-tight">{{ $totalProducts }}</div>
            <div class="text-[11px] text-amber-400 font-bold mt-2 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                <span>100% In-Stock & Active</span>
            </div>
        </div>

        <!-- Card 4: Total Customers -->
        <div class="p-6 rounded-2xl bg-[#1e1e2d] border border-[#2b2b40] shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-violet-500/10 rounded-full blur-2xl pointer-events-none group-hover:bg-violet-500/20 transition-all"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Athletes</span>
                <div class="w-10 h-10 rounded-xl bg-violet-500/15 text-violet-400 flex items-center justify-center text-sm font-black">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-4 tracking-tight">{{ $totalCustomers }}</div>
            <div class="text-[11px] text-violet-300 font-bold mt-2 flex items-center gap-1">
                <span>Verified member accounts</span>
            </div>
        </div>

    </div>

    <!-- =========================================================================
         2. APEXCHARTS ANALYTICS: REVENUE & ORDER FULFILLMENT
         ========================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Revenue Trend Line/Area Chart -->
        <div class="lg:col-span-8 p-6 rounded-2xl bg-[#1e1e2d] border border-[#2b2b40] shadow-xl space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-[#2b2b40] pb-4">
                <div>
                    <h3 class="text-base font-black text-white">Sales & Revenue Momentum</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Real-time daily transaction metrics</p>
                </div>
                <div class="inline-flex items-center gap-1 p-1 bg-[#151521] rounded-xl border border-[#2b2b40]">
                    <span class="text-xs font-black text-white bg-indigo-600 px-3 py-1 rounded-lg">7 Days</span>
                    <span class="text-xs font-bold text-gray-400 px-3 py-1 hover:text-white cursor-pointer">30 Days</span>
                </div>
            </div>
            
            <div id="revenue-analytics-chart" class="w-full min-h-[320px]"></div>
        </div>

        <!-- Order Fulfillment Distribution Donut Chart -->
        <div class="lg:col-span-4 p-6 rounded-2xl bg-[#1e1e2d] border border-[#2b2b40] shadow-xl space-y-4 flex flex-col justify-between">
            <div class="border-b border-[#2b2b40] pb-4">
                <h3 class="text-base font-black text-white">Order Pipeline Status</h3>
                <p class="text-xs text-gray-400 mt-0.5">Fulfillment stage breakdown</p>
            </div>

            <div id="order-status-donut" class="w-full flex items-center justify-center min-h-[240px]"></div>

            <div class="grid grid-cols-2 gap-2 pt-3 border-t border-[#2b2b40] text-xs">
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#151521] border border-[#2b2b40]">
                    <span class="text-amber-400 font-bold">Pending</span>
                    <span class="font-black text-white">{{ $statusCounts['pending'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#151521] border border-[#2b2b40]">
                    <span class="text-indigo-400 font-bold">Processing</span>
                    <span class="font-black text-white">{{ $statusCounts['processing'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#151521] border border-[#2b2b40]">
                    <span class="text-cyan-400 font-bold">Shipped</span>
                    <span class="font-black text-white">{{ $statusCounts['shipped'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#151521] border border-[#2b2b40]">
                    <span class="text-emerald-400 font-bold">Delivered</span>
                    <span class="font-black text-white">{{ $statusCounts['delivered'] }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- =========================================================================
         3. RECENT ORDERS & TOP PERFORMING PRODUCTS
         ========================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Recent Orders Table -->
        <div class="lg:col-span-8 bg-[#1e1e2d] border border-[#2b2b40] rounded-2xl shadow-xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-[#2b2b40] flex items-center justify-between">
                <div>
                    <h3 class="text-base font-black text-white">Recent Customer Orders</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Latest apparel sales and dispatch orders</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 transition flex items-center gap-1">
                    <span>View All Orders</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 border-b border-[#2b2b40] font-black uppercase text-[10px] tracking-wider bg-[#151521]/60">
                            <th class="py-3.5 px-4">Order #</th>
                            <th class="py-3.5 px-4">Customer</th>
                            <th class="py-3.5 px-4">Amount</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#2b2b40] font-medium">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-[#151521]/40 transition">
                                <td class="py-3 px-4 font-mono font-bold text-indigo-400">
                                    {{ $order->order_number }}
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-white">{{ $order->shipping_name }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $order->shipping_email }}</div>
                                </td>
                                <td class="py-3 px-4 font-black text-white">
                                    ${{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                        @if($order->order_status === 'delivered') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                                        @elseif($order->order_status === 'shipped') bg-cyan-500/20 text-cyan-400 border border-cyan-500/30
                                        @elseif($order->order_status === 'processing') bg-indigo-500/20 text-indigo-400 border border-indigo-500/30
                                        @else bg-amber-500/20 text-amber-400 border border-amber-500/30
                                        @endif
                                    ">
                                        {{ $order->order_status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1.5 rounded-lg bg-[#151521] hover:bg-indigo-600 hover:text-white text-gray-300 text-xs font-bold transition border border-[#2b2b40]">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500 italic">No orders received yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Performing Products -->
        <div class="lg:col-span-4 bg-[#1e1e2d] border border-[#2b2b40] rounded-2xl shadow-xl p-6 space-y-4">
            <div class="border-b border-[#2b2b40] pb-4">
                <h3 class="text-base font-black text-white">Top Activewear Drops</h3>
                <p class="text-xs text-gray-400 mt-0.5">Most rated and purchased gymwear</p>
            </div>

            <div class="space-y-3.5">
                @foreach($topProducts as $prod)
                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-[#151521] border border-[#2b2b40]">
                        <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-11 h-11 rounded-lg object-cover bg-zinc-900 shrink-0">
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
                labels: { style: { colors: '#9ca3af', fontSize: '11px', fontFamily: 'Inter' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: { style: { colors: '#9ca3af', fontSize: '11px', fontFamily: 'Inter' } }
            },
            grid: {
                borderColor: '#2b2b40',
                strokeDashArray: 4
            },
            theme: { mode: 'dark' },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                labels: { colors: '#d1d5db' }
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
                            name: { show: true, fontSize: '12px', color: '#9ca3af' },
                            value: { show: true, fontSize: '20px', fontWeight: '900', color: '#ffffff' },
                            total: {
                                show: true,
                                label: 'Total Orders',
                                color: '#9ca3af',
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