@extends('layouts.admin')

@section('title', 'Executive Analytics Dashboard')

@section('content')
<div class="space-y-8">
    
    <!-- 1. Top KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="p-6 rounded-3xl bg-slate-900/80 border border-slate-800 shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Gross Revenue</span>
                <div class="w-10 h-10 rounded-2xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-4">${{ number_format($totalRevenue, 2) }}</div>
            <div class="text-[11px] text-emerald-400 font-bold mt-2 flex items-center gap-1">
                <i class="fa-solid fa-arrow-trend-up"></i> +18.4% this month
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-slate-900/80 border border-slate-800 shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Orders</span>
                <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-4">{{ $totalOrders }}</div>
            <div class="text-[11px] text-emerald-400 font-bold mt-2 flex items-center gap-1">
                <i class="fa-solid fa-arrow-trend-up"></i> +12.1% conversion rate
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-slate-900/80 border border-slate-800 shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Products</span>
                <div class="w-10 h-10 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-cube"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-4">{{ $totalProducts }}</div>
            <div class="text-[11px] text-amber-300 font-bold mt-2">
                100% 3D interactive ready
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-slate-900/80 border border-slate-800 shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-violet-500/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Customers</span>
                <div class="w-10 h-10 rounded-2xl bg-violet-500/20 text-violet-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-4">{{ $totalCustomers }}</div>
            <div class="text-[11px] text-violet-300 font-bold mt-2">
                Verified member accounts
            </div>
        </div>

    </div>

    <!-- 2. Interactive ApexCharts Analytics Area -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Revenue Trend Line/Area Chart -->
        <div class="lg:col-span-8 p-6 rounded-3xl bg-slate-900/80 border border-slate-800 shadow-xl space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-black text-white">Revenue & Orders Momentum</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Real-time daily transaction metrics</p>
                </div>
                <div class="text-xs font-bold text-indigo-400 bg-indigo-500/10 px-3 py-1 rounded-full border border-indigo-500/20">
                    Last 7 Days
                </div>
            </div>
            
            <div id="revenue-analytics-chart" class="w-full min-h-[300px]"></div>
        </div>

        <!-- Order Fulfillment Distribution Donut Chart -->
        <div class="lg:col-span-4 p-6 rounded-3xl bg-slate-900/80 border border-slate-800 shadow-xl space-y-4 flex flex-col justify-between">
            <div>
                <h3 class="text-base font-black text-white">Order Status Distribution</h3>
                <p class="text-xs text-slate-400 mt-0.5">Pipeline stage breakdown</p>
            </div>

            <div id="order-status-donut" class="w-full flex items-center justify-center min-h-[240px]"></div>

            <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-800 text-xs">
                <div class="flex items-center justify-between p-2 rounded-xl bg-slate-800/40">
                    <span class="text-amber-400 font-bold">Pending</span>
                    <span class="font-black text-white">{{ $statusCounts['pending'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2 rounded-xl bg-slate-800/40">
                    <span class="text-indigo-400 font-bold">Processing</span>
                    <span class="font-black text-white">{{ $statusCounts['processing'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2 rounded-xl bg-slate-800/40">
                    <span class="text-blue-400 font-bold">Shipped</span>
                    <span class="font-black text-white">{{ $statusCounts['shipped'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2 rounded-xl bg-slate-800/40">
                    <span class="text-emerald-400 font-bold">Delivered</span>
                    <span class="font-black text-white">{{ $statusCounts['delivered'] }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. Recent Orders & Top Products Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Recent Orders Table -->
        <div class="lg:col-span-8 p-6 rounded-3xl bg-slate-900/80 border border-slate-800 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                <h3 class="text-base font-black text-white">Recent Customer Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-indigo-400 hover:text-indigo-300">
                    View All Orders <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 border-b border-slate-800 font-black uppercase text-[10px] tracking-wider">
                            <th class="py-3 px-2">Order #</th>
                            <th class="py-3 px-2">Customer</th>
                            <th class="py-3 px-2">Amount</th>
                            <th class="py-3 px-2">Status</th>
                            <th class="py-3 px-2 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($recentOrders as $ord)
                            <tr class="hover:bg-slate-800/30 transition font-medium">
                                <td class="py-3 px-2 font-mono font-bold text-indigo-300">{{ $ord->order_number }}</td>
                                <td class="py-3 px-2 text-white">{{ $ord->customer_name }}</td>
                                <td class="py-3 px-2 font-black text-white">${{ number_format($ord->total_amount, 2) }}</td>
                                <td class="py-3 px-2">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $ord->order_status === 'delivered' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($ord->order_status === 'processing' ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30') }}">
                                        {{ $ord->order_status }}
                                    </span>
                                </td>
                                <td class="py-3 px-2 text-right">
                                    <a href="{{ route('admin.orders.show', $ord->id) }}" class="p-1.5 rounded-lg bg-slate-800 hover:bg-indigo-600 text-slate-300 hover:text-white transition inline-block">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-500 italic">No orders received yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Rated Products -->
        <div class="lg:col-span-4 p-6 rounded-3xl bg-slate-900/80 border border-slate-800 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                <h3 class="text-base font-black text-white">Top 3D Products</h3>
                <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-indigo-400 hover:text-indigo-300">Manage</a>
            </div>

            <div class="space-y-3">
                @foreach($topProducts as $prod)
                    <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-slate-800/40 border border-slate-800 hover:border-indigo-500/40 transition">
                        <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-11 h-11 rounded-xl object-cover shrink-0">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-white truncate">{{ $prod->name }}</h4>
                            <div class="flex items-center justify-between mt-1 text-[11px]">
                                <span class="text-amber-400 font-bold">★ {{ number_format($prod->rating, 1) }} ({{ $prod->reviews_count }})</span>
                                <span class="text-white font-black">${{ number_format($prod->effective_price, 2) }}</span>
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
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Revenue & Orders Trend Area Chart (ApexCharts)
    const revenueOptions = {
        series: [{
            name: 'Daily Revenue ($)',
            data: {!! json_encode($chartRevenue) !!}
        }, {
            name: 'Orders Count',
            data: {!! json_encode($chartOrders) !!}
        }],
        chart: {
            type: 'area',
            height: 300,
            background: 'transparent',
            toolbar: { show: false }
        },
        colors: ['#6366f1', '#10b981'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2.5 },
        fill: {
            type: 'gradient',
            gradient: { opacityFrom: 0.45, opacityTo: 0.05 }
        },
        xaxis: {
            categories: {!! json_encode($chartDates) !!},
            labels: { style: { colors: '#94a3b8', fontSize: '11px' } },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: { style: { colors: '#94a3b8', fontSize: '11px' } }
        },
        grid: { borderColor: '#1e293b', strokeDashArray: 4 },
        theme: { mode: 'dark' },
        legend: { position: 'top', horizontalAlign: 'right', labels: { colors: '#cbd5e1' } }
    };

    const revenueChart = new ApexCharts(document.querySelector("#revenue-analytics-chart"), revenueOptions);
    revenueChart.render();

    // 2. Order Status Donut Chart (ApexCharts)
    const donutOptions = {
        series: [
            {{ $statusCounts['pending'] }},
            {{ $statusCounts['processing'] }},
            {{ $statusCounts['shipped'] }},
            {{ $statusCounts['delivered'] }}
        ],
        labels: ['Pending', 'Processing', 'Shipped', 'Delivered'],
        chart: {
            type: 'donut',
            height: 240,
            background: 'transparent'
        },
        colors: ['#f59e0b', '#6366f1', '#3b82f6', '#10b981'],
        dataLabels: { enabled: false },
        plotOptions: {
            pie: {
                donut: {
                    size: '72%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total Orders',
                            color: '#94a3b8',
                            formatter: () => '{{ $totalOrders }}'
                        }
                    }
                }
            }
        },
        legend: { show: false },
        theme: { mode: 'dark' }
    };

    const donutChart = new ApexCharts(document.querySelector("#order-status-donut"), donutOptions);
    donutChart.render();
});
</script>
@endpush