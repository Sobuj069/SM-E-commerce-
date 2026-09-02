@extends('layouts.admin')

@section('title', 'Customer Orders & Invoices')
@section('breadcrumb', 'Orders')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Order Pipeline & Invoices</h1>
            <p class="text-xs text-gray-500 mt-0.5">Track apparel purchases, update dispatch stages, and manage customer fulfillment</p>
        </div>
        <div class="inline-flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-lg bg-white border border-gray-200 text-xs font-semibold text-gray-700 shadow-xs">
                Total Orders: <strong class="text-gray-900">{{ $orders->total() }}</strong>
            </span>
        </div>
    </div>

    <!-- Metronic Orders Data Table -->
    <div class="kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                        <th class="py-3.5 px-6">Order #</th>
                        <th class="py-3.5 px-6">Customer Profile</th>
                        <th class="py-3.5 px-6">Payment</th>
                        <th class="py-3.5 px-6">Total Amount</th>
                        <th class="py-3.5 px-6">Fulfillment Status</th>
                        <th class="py-3.5 px-6">Placed Date</th>
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
                                <div class="text-[10px] text-gray-400 font-mono">{{ $ord->shipping_email ?? $ord->customer_email }}</div>
                            </td>
                            <td class="py-3.5 px-6">
                                <div class="flex items-center gap-1.5">
                                    <span class="uppercase font-bold text-[11px] text-gray-700">{{ $ord->payment_method }}</span>
                                    <span class="kt-badge kt-badge-sm {{ $ord->payment_status === 'paid' ? 'kt-badge-outline kt-badge-success' : 'kt-badge-outline kt-badge-warning' }}">
                                        {{ $ord->payment_status }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3.5 px-6 font-black text-gray-900 text-sm">
                                ${{ number_format($ord->total_amount, 2) }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="kt-badge kt-badge-sm
                                    @if($ord->order_status === 'delivered') kt-badge-outline kt-badge-success
                                    @elseif($ord->order_status === 'shipped') kt-badge-outline kt-badge-info
                                    @elseif($ord->order_status === 'processing') kt-badge-outline kt-badge-primary
                                    @else kt-badge-outline kt-badge-warning
                                    @endif
                                ">
                                    {{ ucfirst($ord->order_status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-gray-500 text-[11px]">
                                {{ $ord->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="kt-btn kt-btn-primary kt-btn-sm text-xs font-semibold inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-file-invoice text-xs"></i>
                                    <span>Manage</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-400 italic">No customer orders recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection