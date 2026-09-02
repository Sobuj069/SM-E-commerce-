@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)
@section('breadcrumb', 'Orders / #' . $order->order_number)

@section('content')
<div class="space-y-6 max-w-5xl mx-auto" x-data="{
    returnModalOpen: false,
    returnType: 'full_return', // 'full_return' | 'partial_delivery'
    collectedAmount: '{{ $order->collected_amount ?? ($order->total_amount / 2) }}',
    returnCharge: '{{ $order->return_charge ?? 0 }}',
    returnReason: '{{ $order->return_reason ?? '' }}'
}">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-xl lg:text-2xl font-bold text-gray-900 font-mono">{{ $order->order_number }}</h1>
                <span class="kt-badge kt-badge-sm
                    @if($order->order_status === 'delivered') kt-badge-outline kt-badge-success
                    @elseif($order->order_status === 'partial_delivered') kt-badge-outline kt-badge-warning
                    @elseif($order->order_status === 'returned') kt-badge-outline kt-badge-destructive
                    @elseif($order->order_status === 'shipped') kt-badge-outline kt-badge-info
                    @elseif($order->order_status === 'processing') kt-badge-outline kt-badge-primary
                    @elseif($order->order_status === 'cancelled') kt-badge-outline kt-badge-destructive
                    @else kt-badge-outline kt-badge-warning
                    @endif
                ">
                    @if($order->order_status === 'partial_delivered')
                        📦 Partial Delivered
                    @elseif($order->order_status === 'returned')
                        ↩️ Returned
                    @else
                        {{ ucfirst($order->order_status) }}
                    @endif
                </span>

                @if($order->stock_restored)
                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200">
                        <i class="fa-solid fa-boxes-stacked mr-1"></i> Stock Restored
                    </span>
                @endif
            </div>
            <p class="text-xs text-gray-500 mt-0.5">Placed on {{ $order->created_at->format('M d, Y \a\t H:i A') }}</p>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <!-- Process Return / Partial Delivery Action Button -->
            <button 
                type="button" 
                @click="returnModalOpen = true" 
                class="px-3.5 py-2 bg-rose-50 text-rose-700 hover:bg-rose-600 hover:text-white border border-rose-200 rounded-lg text-xs font-bold flex items-center gap-1.5 transition cursor-pointer shadow-xs"
            >
                <i class="fa-solid fa-arrow-rotate-left text-xs"></i>
                <span>Courier Return / Partial Delivery</span>
            </button>

            <button onclick="window.print()" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-700 flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-print text-xs"></i> Print Invoice
            </button>
            <a href="{{ route('admin.orders.index') }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-700">
                Back to Orders
            </a>
        </div>
    </div>

    <!-- Return / Partial Delivery Information Banner (if already returned or partial) -->
    @if($order->order_status === 'returned' || $order->order_status === 'partial_delivered')
        <div class="p-4 rounded-xl border {{ $order->order_status === 'returned' ? 'bg-rose-50 border-rose-200 text-rose-900' : 'bg-amber-50 border-amber-200 text-amber-900' }} space-y-1 text-xs">
            <div class="font-bold flex items-center gap-2">
                <i class="fa-solid {{ $order->order_status === 'returned' ? 'fa-circle-xmark text-rose-600' : 'fa-triangle-exclamation text-amber-600' }}"></i>
                <span class="uppercase tracking-wider">
                    {{ $order->order_status === 'returned' ? 'Courier Return Record' : 'Partial Delivery Record' }}
                </span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 pt-1 text-[11px]">
                <div>Reason: <strong>{{ $order->return_reason ?? 'Not specified' }}</strong></div>
                <div>Cash Collected: <strong class="text-emerald-700">${{ number_format($order->collected_amount ?? 0, 2) }}</strong></div>
                <div>Courier Return Fee: <strong>${{ number_format($order->return_charge ?? 0, 2) }}</strong></div>
            </div>
        </div>
    @endif

    <!-- 2-Grid: Fraud Risk Intelligence & Courier Dispatch -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Widget 1: Fraud Risk Analysis -->
        <div class="kt-card p-6 bg-white border border-gray-200/90 rounded-xl shadow-xs space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-halved text-primary"></i>
                    <span>Fraud &amp; Risk Intelligence</span>
                </h3>
                <span class="kt-badge kt-badge-sm font-bold {{ $fraudAnalysis['status'] === 'safe' ? 'kt-badge-outline kt-badge-success' : ($fraudAnalysis['status'] === 'review' ? 'kt-badge-outline kt-badge-warning' : 'kt-badge-outline kt-badge-destructive') }}">
                    Risk Score: {{ $fraudAnalysis['score'] }}/100 ({{ ucfirst($fraudAnalysis['status']) }})
                </span>
            </div>

            <div class="p-3 rounded-lg {{ $fraudAnalysis['status'] === 'safe' ? 'bg-emerald-50/60 border border-emerald-100 text-emerald-800' : 'bg-rose-50/60 border border-rose-100 text-rose-800' }} text-xs">
                <div class="font-bold flex items-center gap-1.5">
                    <i class="fa-solid {{ $fraudAnalysis['status'] === 'safe' ? 'fa-circle-check text-emerald-600' : 'fa-triangle-exclamation text-rose-600' }}"></i>
                    <span>{{ $fraudAnalysis['status'] === 'safe' ? 'Customer Profile Appears Safe' : 'Security Alert: Review Carefully' }}</span>
                </div>
                <div class="text-[11px] mt-1 text-gray-600">
                    Delivery Success Rate: <strong class="text-gray-900">{{ $fraudAnalysis['success_rate'] }}%</strong> &bull; Past Orders: {{ $fraudAnalysis['total_orders'] }}
                </div>
            </div>

            @if(count($fraudAnalysis['reasons']) > 0)
                <div class="space-y-1 text-[11px] text-gray-600">
                    <div class="font-bold text-gray-700 text-[10px] uppercase">Risk Factors:</div>
                    @foreach($fraudAnalysis['reasons'] as $r)
                        <div class="flex items-center gap-1.5 text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[9px]"></i>
                            <span>{{ $r }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="pt-2 flex items-center justify-between text-xs border-t border-gray-100">
                <a href="{{ route('admin.fraud.index', ['phone' => $order->customer_phone]) }}" class="text-primary font-semibold hover:underline">
                    Detailed Fraud History &rarr;
                </a>

                @if($fraudAnalysis['status'] !== 'blacklisted')
                    <form action="{{ route('admin.fraud.blacklist.add') }}" method="POST" onsubmit="return confirm('Blacklist this customer phone number?');">
                        @csrf
                        <input type="hidden" name="phone" value="{{ $order->customer_phone }}">
                        <input type="hidden" name="reason" value="Suspicious activity from order #{{ $order->order_number }}">
                        <button type="submit" class="text-rose-600 font-semibold hover:underline cursor-pointer">
                            Blacklist Phone
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Widget 2: Courier Logistics & Dispatch -->
        <div class="kt-card p-6 bg-white border border-gray-200/90 rounded-xl shadow-xs space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-truck-fast text-emerald-600"></i>
                    <span>Courier Dispatch &amp; Consignment</span>
                </h3>
                @if($order->consignment_id)
                    <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-info font-bold">
                        {{ ucfirst($order->courier_status) }}
                    </span>
                @else
                    <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-warning">
                        Not Dispatched
                    </span>
                @endif
            </div>

            @if($order->consignment_id)
                <div class="p-3.5 rounded-lg bg-gray-50 border border-gray-100 space-y-1.5 text-xs">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Assigned Courier:</span>
                        <strong class="uppercase text-gray-900">{{ $order->courier_name }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Consignment ID:</span>
                        <strong class="font-mono text-emerald-600">{{ $order->consignment_id }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tracking Code:</span>
                        <strong class="font-mono text-gray-700">{{ $order->tracking_code }}</strong>
                    </div>
                </div>
            @else
                <form action="{{ route('admin.courier.send', $order->id) }}" method="POST" class="space-y-3 text-xs">
                    @csrf
                    <div class="space-y-1">
                        <label class="block font-bold text-gray-700 uppercase text-[10px]">Select Courier Provider</label>
                        <select name="courier" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 focus:outline-none focus:border-primary">
                            <option value="steadfast">Steadfast Courier</option>
                            <option value="pathao">Pathao Express</option>
                            <option value="redx">RedX Logistics</option>
                            <option value="paperfly">Paperfly</option>
                            <option value="dhl">DHL Worldwide</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full kt-btn kt-btn-primary kt-btn-sm text-xs font-semibold shadow-xs flex items-center justify-center gap-1.5 py-2.5 cursor-pointer">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>Generate Consignment &amp; Send</span>
                    </button>
                </form>
            @endif
        </div>

    </div>

    <!-- Standard Status Updater Control Card -->
    <div class="kt-card p-6 bg-white border border-gray-200/90 rounded-xl shadow-xs">
        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Update Order &amp; Payment Status</h3>
        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
            @csrf
            <div class="flex-1 w-full space-y-1">
                <label class="text-[10px] font-bold text-gray-600 uppercase tracking-wider block">Fulfillment Stage</label>
                <select name="order_status" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-xs font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="partial_delivered" {{ $order->order_status == 'partial_delivered' ? 'selected' : '' }}>Partial Delivered</option>
                    <option value="returned" {{ $order->order_status == 'returned' ? 'selected' : '' }}>Returned</option>
                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="flex-1 w-full space-y-1">
                <label class="text-[10px] font-bold text-gray-600 uppercase tracking-wider block">Payment Verification</label>
                <select name="payment_status" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-xs font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="partial" {{ $order->payment_status == 'partial' ? 'selected' : '' }}>Partial Paid</option>
                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed / Refunded</option>
                </select>
            </div>

            <div class="sm:self-end w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto kt-btn kt-btn-primary kt-btn-sm text-xs font-semibold shadow-xs cursor-pointer">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Printable Invoice & Order Details -->
    <div class="kt-card p-8 bg-white border border-gray-200/90 rounded-xl shadow-xs space-y-8 print:bg-white print:p-0 print:border-none">
        
        <!-- Header -->
        <div class="flex justify-between items-start pb-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="SM Shop" class="h-10 w-auto object-contain">
                <div>
                    <div class="text-base font-black text-gray-900 uppercase">SM SHOP</div>
                    <div class="text-xs text-gray-500">Fashion &amp; Activewear Enterprise</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm font-mono font-bold text-primary">{{ $order->order_number }}</div>
                <div class="text-xs text-gray-500">{{ $order->created_at->format('d M Y') }}</div>
            </div>
        </div>

        <!-- Customer & Shipping Addresses -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <div class="space-y-1.5 p-4 rounded-lg bg-gray-50 border border-gray-100">
                <span class="font-bold text-primary uppercase tracking-wider block text-[10px]">Customer Details</span>
                <div class="font-bold text-gray-900 text-sm">{{ $order->shipping_name ?? $order->customer_name }}</div>
                <div class="text-gray-600">{{ $order->shipping_email ?? $order->customer_email }}</div>
                <div class="text-gray-600 font-mono font-bold">{{ $order->shipping_phone ?? $order->customer_phone }}</div>
            </div>

            <div class="space-y-1.5 p-4 rounded-lg bg-gray-50 border border-gray-100">
                <span class="font-bold text-emerald-600 uppercase tracking-wider block text-[10px]">Shipping Destination</span>
                <div class="text-gray-600">{{ $order->shipping_address }}</div>
                <div class="text-gray-600">{{ $order->city }} {{ $order->postal_code ? '(' . $order->postal_code . ')' : '' }}</div>
                <div class="text-gray-500 text-[11px] pt-1">Payment Method: <strong class="uppercase text-gray-900">{{ $order->payment_method }}</strong></div>
            </div>
        </div>

        <!-- Line Items -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] bg-gray-50/70">
                        <th class="py-3 px-4">Activewear Item</th>
                        <th class="py-3 px-4 text-center">Qty</th>
                        <th class="py-3 px-4 text-right">Unit Price</th>
                        <th class="py-3 px-4 text-right">Line Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-gray-900 text-xs">{{ $item->product_name ?? ($item->product->name ?? 'Product') }}</div>
                                @if($item->variant_info)
                                    <div class="text-[10px] text-gray-400">{{ $item->variant_info }}</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-gray-900">{{ $item->quantity }}</td>
                            <td class="py-3.5 px-4 text-right text-gray-600">${{ number_format($item->price, 2) }}</td>
                            <td class="py-3.5 px-4 text-right font-black text-gray-900">${{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t border-gray-100">
                        <td colspan="3" class="py-4 px-4 text-right font-bold text-gray-500 uppercase text-[10px]">Grand Total:</td>
                        <td class="py-4 px-4 text-right font-black text-base text-emerald-600">${{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                    @if($order->collected_amount)
                        <tr class="border-t border-gray-100 bg-emerald-50/50">
                            <td colspan="3" class="py-2 px-4 text-right font-bold text-emerald-800 uppercase text-[10px]">Actual Cash Collected:</td>
                            <td class="py-2 px-4 text-right font-black text-sm text-emerald-700">${{ number_format($order->collected_amount, 2) }}</td>
                        </tr>
                    @endif
                </tfoot>
            </table>
        </div>

    </div>

    <!-- =========================================================================
         COURIER RETURN & PARTIAL DELIVERY PROCESS MODAL
         ========================================================================= -->
    <div 
        x-cloak
        x-show="returnModalOpen" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
    >
        <div 
            @click.away="returnModalOpen = false"
            class="bg-white rounded-2xl shadow-2xl border border-gray-200 max-w-lg w-full overflow-hidden space-y-4 p-6"
        >
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-sm font-black">
                        <i class="fa-solid fa-box-archive"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm">Process Courier Return / Partial</h3>
                        <p class="text-[10px] text-gray-400">Order #{{ $order->order_number }}</p>
                    </div>
                </div>
                <button @click="returnModalOpen = false" class="text-gray-400 hover:text-gray-700 cursor-pointer p-1">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <form action="{{ route('admin.orders.return', $order->id) }}" method="POST" class="space-y-4 text-xs">
                @csrf
                
                <!-- Action Type Selector (Full Return vs Partial Delivery) -->
                <div class="space-y-1.5">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Select Return Action *</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label 
                            @click="returnType = 'full_return'"
                            :class="returnType === 'full_return' ? 'bg-rose-50 border-rose-500 text-rose-900 font-bold' : 'bg-gray-50 border-gray-200 text-gray-600'"
                            class="p-3 rounded-xl border flex flex-col items-center justify-center gap-1 cursor-pointer transition text-center"
                        >
                            <input type="radio" name="action_type" value="full_return" x-model="returnType" class="hidden">
                            <i class="fa-solid fa-arrow-rotate-left text-rose-600 text-base"></i>
                            <span class="text-xs">1. Full Return</span>
                            <span class="text-[9px] text-gray-500 font-normal">Customer rejected entire parcel</span>
                        </label>

                        <label 
                            @click="returnType = 'partial_delivery'"
                            :class="returnType === 'partial_delivery' ? 'bg-amber-50 border-amber-500 text-amber-900 font-bold' : 'bg-gray-50 border-gray-200 text-gray-600'"
                            class="p-3 rounded-xl border flex flex-col items-center justify-center gap-1 cursor-pointer transition text-center"
                        >
                            <input type="radio" name="action_type" value="partial_delivery" x-model="returnType" class="hidden">
                            <i class="fa-solid fa-box-open text-amber-600 text-base"></i>
                            <span class="text-xs">2. Partial Delivery</span>
                            <span class="text-[9px] text-gray-500 font-normal">Customer kept part &amp; returned rest</span>
                        </label>
                    </div>
                </div>

                <!-- Partial Delivery Settings: Cash collected & Returned items selection -->
                <div x-show="returnType === 'partial_delivery'" class="p-3.5 bg-amber-50/70 border border-amber-200 rounded-xl space-y-3">
                    <div class="space-y-1">
                        <label class="block font-bold text-amber-900 uppercase text-[10px]">Actual Cash Collected from Customer ($) *</label>
                        <input type="number" step="0.01" name="collected_amount" x-model="collectedAmount" placeholder="e.g. 45.00" class="w-full px-3 py-2 bg-white border border-amber-300 rounded-lg text-xs font-bold text-gray-900 focus:outline-none focus:border-amber-600">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-amber-900 uppercase text-[10px]">Specify Returned Item Quantities to Restock:</label>
                        <div class="space-y-1.5 bg-white p-2.5 rounded-lg border border-amber-200">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between gap-2 text-xs">
                                    <span class="truncate text-gray-800 font-medium">{{ $item->product_name ?? 'Product' }} (Ordered: {{ $item->quantity }})</span>
                                    <div class="flex items-center gap-1 shrink-0">
                                        <span class="text-[10px] text-gray-500">Qty Returned:</span>
                                        <input type="number" name="returned_items[{{ $item->id }}]" min="0" max="{{ $item->quantity }}" value="1" class="w-14 px-2 py-1 bg-gray-50 border border-gray-300 rounded text-center text-xs font-bold">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Courier Return Fee (Charge) -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="block font-bold text-gray-700 uppercase text-[10px]">Courier Return Charge ($)</label>
                        <input type="number" step="0.01" name="return_charge" x-model="returnCharge" placeholder="0.00" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 focus:outline-none focus:border-primary">
                    </div>

                    <div class="space-y-1">
                        <label class="block font-bold text-gray-700 uppercase text-[10px]">Auto Restock Inventory</label>
                        <div class="p-2 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-[11px] font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check text-emerald-600"></i>
                            <span>Auto Stock Replenish ON</span>
                        </div>
                    </div>
                </div>

                <!-- Return Reason -->
                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Reason for Return</label>
                    <select name="return_reason" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 focus:outline-none focus:border-primary">
                        <option value="Customer refused delivery / Not available">Customer refused delivery / Not available</option>
                        <option value="Customer wanted different size / fit issue">Customer wanted different size / fit issue</option>
                        <option value="Customer changed mind / Ordered by mistake">Customer changed mind / Ordered by mistake</option>
                        <option value="Delayed delivery by courier">Delayed delivery by courier</option>
                        <option value="Damaged in transit / Defective parcel">Damaged in transit / Defective parcel</option>
                        <option value="Partial delivery accepted">Partial delivery accepted</option>
                    </select>
                </div>

                <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-2">
                    <button type="button" @click="returnModalOpen = false" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-600">
                        Cancel
                    </button>
                    <button type="submit" class="kt-btn kt-btn-primary kt-btn-sm text-xs font-bold shadow-xs cursor-pointer px-4 py-2">
                        <span x-text="returnType === 'full_return' ? 'Confirm Full Return & Restock' : 'Confirm Partial Delivery & Restock'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection