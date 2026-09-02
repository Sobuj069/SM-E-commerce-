@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)
@section('breadcrumb', 'Orders / #' . $order->order_number)

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-xl lg:text-2xl font-bold text-gray-900 font-mono">{{ $order->order_number }}</h1>
                <span class="kt-badge kt-badge-sm
                    @if($order->order_status === 'delivered') kt-badge-outline kt-badge-success
                    @elseif($order->order_status === 'shipped') kt-badge-outline kt-badge-info
                    @elseif($order->order_status === 'processing') kt-badge-outline kt-badge-primary
                    @elseif($order->order_status === 'cancelled') kt-badge-outline kt-badge-destructive
                    @else kt-badge-outline kt-badge-warning
                    @endif
                ">
                    {{ ucfirst($order->order_status) }}
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-0.5">Placed on {{ $order->created_at->format('M d, Y \a\t H:i A') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-700 flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-print text-xs"></i> Print Invoice
            </button>
            <a href="{{ route('admin.orders.index') }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-700">
                Back to Orders
            </a>
        </div>
    </div>

    <!-- 2-Grid: Fraud Risk Intelligence & Courier Dispatch -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Widget 1: Fraud Risk Analysis -->
        <div class="kt-card p-6 bg-white border border-gray-200/90 rounded-xl shadow-xs space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-halved text-primary"></i>
                    <span>Fraud & Risk Intelligence</span>
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
                    <span>Courier Dispatch & Consignment</span>
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
                        <span>Generate Consignment & Send</span>
                    </button>
                </form>
            @endif
        </div>

    </div>

    <!-- Status Updater Control Card -->
    <div class="kt-card p-6 bg-white border border-gray-200/90 rounded-xl shadow-xs">
        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Update Order & Payment Status</h3>
        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
            @csrf
            <div class="flex-1 w-full space-y-1">
                <label class="text-[10px] font-bold text-gray-600 uppercase tracking-wider block">Fulfillment Stage</label>
                <select name="order_status" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-xs font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="returned" {{ $order->order_status == 'returned' ? 'selected' : '' }}>Returned</option>
                </select>
            </div>

            <div class="flex-1 w-full space-y-1">
                <label class="text-[10px] font-bold text-gray-600 uppercase tracking-wider block">Payment Verification</label>
                <select name="payment_status" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-xs font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
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
                    <div class="text-xs text-gray-500">Fashion & Activewear Enterprise</div>
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
                </tfoot>
            </table>
        </div>

    </div>

</div>
@endsection