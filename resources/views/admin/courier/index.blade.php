@extends('layouts.admin')

@section('title', 'Courier Integration & Dispatch Panel')
@section('breadcrumb', 'Logistics / Courier Panel')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Courier Integration & Dispatch Panel</h1>
            <p class="text-xs text-gray-500 mt-0.5">Automated parcel booking with Steadfast, Pathao, RedX, Paperfly & DHL API</p>
        </div>
    </div>

    <!-- Supported Couriers Status Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        @foreach(['steadfast' => ['name' => 'Steadfast', 'color' => 'blue', 'icon' => 'truck-fast'], 'pathao' => ['name' => 'Pathao', 'color' => 'rose', 'icon' => 'motorcycle'], 'redx' => ['name' => 'RedX', 'color' => 'red', 'icon' => 'box'], 'paperfly' => ['name' => 'Paperfly', 'color' => 'emerald', 'icon' => 'paper-plane'], 'dhl' => ['name' => 'DHL Global', 'color' => 'amber', 'icon' => 'plane']] as $key => $courier)
            <div class="kt-card p-4 bg-white border border-gray-200/90 rounded-xl shadow-xs text-center flex flex-col items-center justify-center gap-2">
                <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-700 text-sm border border-gray-200">
                    <i class="fa-solid fa-{{ $courier['icon'] }}"></i>
                </div>
                <div class="font-bold text-xs text-gray-900">{{ $courier['name'] }}</div>
                <span class="kt-badge kt-badge-sm kt-badge-outline {{ isset($settings[$key]) && $settings[$key]->is_active ? 'kt-badge-success' : 'kt-badge-primary' }}">
                    {{ isset($settings[$key]) && $settings[$key]->is_active ? 'API Active' : 'Ready' }}
                </span>
            </div>
        @endforeach
    </div>

    <!-- Unassigned Orders Pending Courier Dispatch -->
    <div class="kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-gray-900">Orders Awaiting Courier Dispatch</h3>
                <p class="text-xs text-gray-500 mt-0.5">Generate Consignment ID & ship parcels in one click</p>
            </div>
            <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-warning font-bold">
                {{ $pendingOrders->count() }} Orders Ready to Ship
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                        <th class="py-3.5 px-6">Order #</th>
                        <th class="py-3.5 px-6">Customer & Address</th>
                        <th class="py-3.5 px-6">COD Amount</th>
                        <th class="py-3.5 px-6">Select Courier</th>
                        <th class="py-3.5 px-6 text-right">Instant Dispatch</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    @forelse($pendingOrders as $order)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="py-3.5 px-6 font-mono font-bold text-primary">
                                {{ $order->order_number }}
                            </td>
                            <td class="py-3.5 px-6">
                                <div class="font-bold text-gray-900 text-xs">{{ $order->shipping_name ?? $order->customer_name }}</div>
                                <div class="text-[10px] text-gray-500 truncate max-w-xs">{{ $order->shipping_address }}, {{ $order->city }} ({{ $order->customer_phone }})</div>
                            </td>
                            <td class="py-3.5 px-6 font-black text-gray-900 text-sm">
                                ${{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="py-3.5 px-6">
                                <form id="courier-form-{{ $order->id }}" action="{{ route('admin.courier.send', $order->id) }}" method="POST">
                                    @csrf
                                    <select name="courier" class="px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 focus:outline-none focus:border-primary">
                                        <option value="steadfast">Steadfast Courier</option>
                                        <option value="pathao">Pathao Express</option>
                                        <option value="redx">RedX Logistics</option>
                                        <option value="paperfly">Paperfly</option>
                                        <option value="dhl">DHL Worldwide</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <button type="submit" form="courier-form-{{ $order->id }}" class="kt-btn kt-btn-primary kt-btn-sm text-xs font-semibold flex items-center gap-1.5 shadow-xs cursor-pointer">
                                    <i class="fa-solid fa-paper-plane text-xs"></i>
                                    <span>Book Parcel</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400 italic">No pending orders awaiting courier dispatch.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Dispatched Parcels Tracking Table -->
    <div class="kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-base font-bold text-gray-900">Live Dispatched Parcels & Tracking</h3>
            <span class="text-xs text-gray-500">{{ $dispatchedOrders->total() }} parcels dispatched</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                        <th class="py-3.5 px-6">Order #</th>
                        <th class="py-3.5 px-6">Courier Service</th>
                        <th class="py-3.5 px-6">Consignment ID</th>
                        <th class="py-3.5 px-6">Tracking Code</th>
                        <th class="py-3.5 px-6">Courier Status</th>
                        <th class="py-3.5 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    @forelse($dispatchedOrders as $ord)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="py-3.5 px-6 font-mono font-bold text-primary">
                                {{ $ord->order_number }}
                            </td>
                            <td class="py-3.5 px-6 font-bold uppercase text-[11px] text-gray-800">
                                {{ $ord->courier_name }}
                            </td>
                            <td class="py-3.5 px-6 font-mono font-bold text-emerald-600 text-xs">
                                {{ $ord->consignment_id }}
                            </td>
                            <td class="py-3.5 px-6 font-mono text-gray-500 text-xs">
                                {{ $ord->tracking_code }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-info font-bold">
                                    <i class="fa-solid fa-truck-moving text-[9px] mr-1"></i> {{ ucfirst($ord->courier_status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-700">
                                    View Order
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400 italic">No parcels booked with couriers yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($dispatchedOrders->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $dispatchedOrders->links() }}
            </div>
        @endif
    </div>

    <!-- Courier API Credentials Configuration Form -->
    <div class="kt-card bg-white border border-gray-200/90 rounded-xl p-6 shadow-xs space-y-4">
        <h3 class="text-base font-bold text-gray-900 pb-3 border-b border-gray-100">
            Courier API Configuration (Steadfast / Pathao / RedX)
        </h3>

        <form action="{{ route('admin.courier.settings') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
            @csrf
            <div class="space-y-1">
                <label class="block font-bold text-gray-700 uppercase text-[10px]">Select Provider</label>
                <select name="provider" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 focus:outline-none focus:border-primary">
                    <option value="steadfast">Steadfast Courier</option>
                    <option value="pathao">Pathao Express</option>
                    <option value="redx">RedX Logistics</option>
                    <option value="paperfly">Paperfly</option>
                    <option value="dhl">DHL Global</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-gray-700 uppercase text-[10px]">API Key</label>
                <input type="text" name="api_key" placeholder="Enter API Key" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-900 font-mono focus:outline-none focus:border-primary">
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-gray-700 uppercase text-[10px]">Secret Key / Password</label>
                <input type="password" name="secret_key" placeholder="Enter Secret Key" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-900 font-mono focus:outline-none focus:border-primary">
            </div>

            <div class="md:col-span-3 flex items-center justify-between pt-2">
                <label class="flex items-center gap-2 cursor-pointer font-semibold text-gray-700">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-primary">
                    <span>Enable Live Automatic Booking for this Courier</span>
                </label>

                <button type="submit" class="kt-btn kt-btn-primary text-xs font-semibold flex items-center gap-1.5 shadow-xs cursor-pointer">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Save API Keys</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection