@extends('layouts.admin')

@section('title', 'Web Orders Management')
@section('breadcrumb', 'Orders List')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Web Order List & Status Maintainer</h1>
            <p class="text-xs text-gray-500 mt-0.5">Filter by fulfillment stage, manage courier dispatches, and print invoices</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.courier.index') }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-700 flex items-center gap-1.5">
                <i class="fa-solid fa-truck-fast text-xs text-primary"></i>
                <span>Courier Panel</span>
            </a>
            <a href="{{ route('admin.fraud.index') }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-700 flex items-center gap-1.5">
                <i class="fa-solid fa-shield-halved text-xs text-amber-500"></i>
                <span>Fraud Checker</span>
            </a>
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-semibold">
        <a href="{{ route('admin.orders.index', ['status' => 'all']) }}" class="px-4 py-2 rounded-lg transition shrink-0 {{ $status === 'all' ? 'bg-[#1b84ff] text-white shadow-xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            All Orders ({{ $statusTotals['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg transition shrink-0 {{ $status === 'pending' ? 'bg-amber-500 text-white shadow-xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            Pending ({{ $statusTotals['pending'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="px-4 py-2 rounded-lg transition shrink-0 {{ $status === 'processing' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            Processing ({{ $statusTotals['processing'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="px-4 py-2 rounded-lg transition shrink-0 {{ $status === 'shipped' ? 'bg-purple-600 text-white shadow-xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            Shipped ({{ $statusTotals['shipped'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="px-4 py-2 rounded-lg transition shrink-0 {{ $status === 'delivered' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            Delivered ({{ $statusTotals['delivered'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'partial_delivered']) }}" class="px-4 py-2 rounded-lg transition shrink-0 {{ $status === 'partial_delivered' ? 'bg-amber-600 text-white shadow-xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            📦 Partial Delivered ({{ $statusTotals['partial_delivered'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'returned']) }}" class="px-4 py-2 rounded-lg transition shrink-0 {{ $status === 'returned' ? 'bg-rose-700 text-white shadow-xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            ↩️ Returned ({{ $statusTotals['returned'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="px-4 py-2 rounded-lg transition shrink-0 {{ $status === 'cancelled' ? 'bg-gray-700 text-white shadow-xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            Cancelled ({{ $statusTotals['cancelled'] }})
        </a>
    </div>

    <!-- Metronic Orders Data Table -->
    <div class="kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                        <th class="py-3.5 px-6">Order #</th>
                        <th class="py-3.5 px-6">Customer &amp; Phone</th>
                        <th class="py-3.5 px-6">Total Amount</th>
                        <th class="py-3.5 px-6">Courier Logistics</th>
                        <th class="py-3.5 px-6">Order Status</th>
                        <th class="py-3.5 px-6">Placed At</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    @forelse($orders as $ord)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="py-3.5 px-6 font-mono font-bold text-primary">
                                {{ $ord->order_number }}
                            </td>
                            <td class="py-3.5 px-6">
                                <div class="font-bold text-gray-900 text-xs">{{ $ord->shipping_name ?? $ord->customer_name }}</div>
                                <div class="text-[10px] text-gray-500 font-mono">{{ $ord->customer_phone ?? ($ord->shipping_phone ?? 'N/A') }}</div>
                            </td>
                            <td class="py-3.5 px-6">
                                <div class="font-black text-gray-900 text-sm">${{ number_format($ord->total_amount, 2) }}</div>
                                <span class="text-[10px] uppercase font-bold text-gray-400">{{ $ord->payment_method }} &bull; {{ $ord->payment_status }}</span>
                            </td>
                            <td class="py-3.5 px-6">
                                @if($ord->consignment_id)
                                    <div class="font-bold uppercase text-[10px] text-primary">{{ $ord->courier_name }}</div>
                                    <div class="text-[10px] font-mono font-bold text-emerald-600">{{ $ord->consignment_id }}</div>
                                @else
                                    <a href="{{ route('admin.courier.index') }}" class="text-[11px] text-gray-400 hover:text-primary flex items-center gap-1 font-semibold">
                                        <i class="fa-solid fa-plus text-[9px]"></i> Assign Courier
                                    </a>
                                @endif
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="kt-badge kt-badge-sm
                                    @if($ord->order_status === 'delivered') kt-badge-outline kt-badge-success
                                    @elseif($ord->order_status === 'partial_delivered') kt-badge-outline kt-badge-warning
                                    @elseif($ord->order_status === 'returned') kt-badge-outline kt-badge-destructive
                                    @elseif($ord->order_status === 'shipped') kt-badge-outline kt-badge-info
                                    @elseif($ord->order_status === 'processing') kt-badge-outline kt-badge-primary
                                    @elseif($ord->order_status === 'cancelled') kt-badge-outline kt-badge-destructive
                                    @else kt-badge-outline kt-badge-warning
                                    @endif
                                ">
                                    @if($ord->order_status === 'partial_delivered')
                                        📦 Partial Delivered
                                    @elseif($ord->order_status === 'returned')
                                        ↩️ Returned
                                    @else
                                        {{ ucfirst($ord->order_status) }}
                                    @endif
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-gray-500 text-[11px]">
                                {{ $ord->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="kt-btn kt-btn-primary kt-btn-sm text-xs font-semibold inline-flex items-center gap-1.5 shadow-xs">
                                    <i class="fa-solid fa-file-invoice text-xs"></i>
                                    <span>Details</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-400 italic">No orders found in this status.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $orders->appends(['status' => $status])->links() }}
            </div>
        @endif
    </div>

</div>
@endsection