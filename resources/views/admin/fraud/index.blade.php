@extends('layouts.admin')

@section('title', 'Fraud Checker & Risk Analyzer')
@section('breadcrumb', 'Security / Fraud Checker')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Fraud Detection & Customer Risk Analyzer</h1>
            <p class="text-xs text-gray-500 mt-0.5">Real-time risk scoring, phone return rate verification, and blacklisted contact filtering</p>
        </div>
    </div>

    <!-- Phone Number Search Bar -->
    <div class="kt-card p-6 bg-white border border-gray-200/90 rounded-xl shadow-xs">
        <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Quick Phone / Customer Fraud Scan</h3>
        <form action="{{ route('admin.fraud.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <i class="fa-solid fa-phone absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input 
                    type="text" 
                    name="phone" 
                    value="{{ $searchPhone }}" 
                    placeholder="Enter customer phone number (e.g. 01700000000)..." 
                    class="w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition"
                    required
                >
            </div>
            <button type="submit" class="w-full sm:w-auto kt-btn kt-btn-primary kt-btn-sm text-xs font-semibold flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                <i class="fa-solid fa-shield-halved text-xs"></i>
                <span>Analyze Customer Risk</span>
            </button>
            @if($searchPhone)
                <a href="{{ route('admin.fraud.index') }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-600">
                    Reset
                </a>
            @endif
        </form>

        <!-- Search Result Report Card -->
        @if($searchResult)
            <div class="mt-6 p-6 rounded-xl border {{ $searchResult['is_blacklisted'] || $searchResult['cancelled'] > 2 ? 'bg-rose-50/70 border-rose-200' : 'bg-emerald-50/70 border-emerald-200' }} space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full {{ $searchResult['is_blacklisted'] ? 'bg-rose-600' : 'bg-emerald-600' }} text-white flex items-center justify-center text-lg font-bold shadow-xs">
                            <i class="fa-solid {{ $searchResult['is_blacklisted'] ? 'fa-triangle-exclamation' : 'fa-shield-check' }}"></i>
                        </div>
                        <div>
                            <div class="font-mono font-bold text-gray-900 text-sm">Phone: {{ $searchResult['phone'] }}</div>
                            <div class="text-xs {{ $searchResult['is_blacklisted'] ? 'text-rose-700 font-bold' : 'text-emerald-700 font-semibold' }}">
                                @if($searchResult['is_blacklisted'])
                                    ⚠️ BLACKLISTED CUSTOMER (Do Not Dispatch COD)
                                @elseif($searchResult['cancelled'] > 1)
                                    ⚠️ Moderate Risk: History of {{ $searchResult['cancelled'] }} cancelled/returned parcels
                                @else
                                    ✅ Verified Safe: {{ $searchResult['success_rate'] }}% Delivery Success Rate
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <div class="text-[10px] uppercase font-bold text-gray-500">Delivery Success</div>
                            <div class="text-lg font-black text-gray-900">{{ $searchResult['success_rate'] }}%</div>
                        </div>

                        @if(!$searchResult['is_blacklisted'])
                            <form action="{{ route('admin.fraud.blacklist.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="phone" value="{{ $searchResult['phone'] }}">
                                <input type="hidden" name="reason" value="Flagged from risk analyzer">
                                <button type="submit" class="kt-btn kt-btn-sm bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-xs cursor-pointer">
                                    <i class="fa-solid fa-ban text-xs mr-1"></i> Blacklist Phone
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Previous Orders Table for this Phone -->
                <div class="pt-3 border-t border-gray-200/60">
                    <div class="text-xs font-bold text-gray-700 mb-2">Order History with this Phone ({{ $searchResult['total_orders'] }} orders):</div>
                    <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="text-gray-500 border-b border-gray-100 uppercase text-[10px] bg-gray-50">
                                    <th class="py-2.5 px-4">Order #</th>
                                    <th class="py-2.5 px-4">Amount</th>
                                    <th class="py-2.5 px-4">Status</th>
                                    <th class="py-2.5 px-4">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                                @forelse($searchResult['orders'] as $ord)
                                    <tr>
                                        <td class="py-2.5 px-4 font-mono font-bold text-primary">{{ $ord->order_number }}</td>
                                        <td class="py-2.5 px-4 font-bold text-gray-900">${{ number_format($ord->total_amount, 2) }}</td>
                                        <td class="py-2.5 px-4">
                                            <span class="kt-badge kt-badge-sm {{ $ord->order_status === 'delivered' ? 'kt-badge-outline kt-badge-success' : ($ord->order_status === 'cancelled' ? 'kt-badge-outline kt-badge-destructive' : 'kt-badge-outline kt-badge-info') }}">
                                                {{ ucfirst($ord->order_status) }}
                                            </span>
                                        </td>
                                        <td class="py-2.5 px-4 text-gray-500">{{ $ord->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center text-gray-400 italic">No past orders found in store database for this number.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Blacklist Contacts & Suspicious Activity 2-Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Fraud Blacklist Roster (7 cols) -->
        <div class="lg:col-span-7 kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Blacklisted Contacts & Numbers</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Orders from these numbers will trigger instant high-risk alert</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                            <th class="py-3.5 px-6">Blocked Number</th>
                            <th class="py-3.5 px-6">Reason</th>
                            <th class="py-3.5 px-6">Date Blocked</th>
                            <th class="py-3.5 px-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                        @forelse($blacklists as $bl)
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="py-3.5 px-6 font-mono font-bold text-rose-600">
                                    {{ $bl->phone }}
                                </td>
                                <td class="py-3.5 px-6 text-gray-600 text-[11px]">
                                    {{ $bl->reason }}
                                </td>
                                <td class="py-3.5 px-6 text-gray-400 text-[11px]">
                                    {{ $bl->created_at->format('M d, Y') }}
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    <form action="{{ route('admin.fraud.blacklist.remove', $bl->id) }}" method="POST" onsubmit="return confirm('Remove number from blacklist?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-gray-100 hover:bg-rose-50 text-gray-600 hover:text-rose-600 transition cursor-pointer" title="Remove">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400 italic">No blacklisted contacts recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($blacklists->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $blacklists->links() }}
                </div>
            @endif
        </div>

        <!-- Right: Add Blacklist Contact Form (5 cols) -->
        <div class="lg:col-span-5 kt-card bg-white border border-gray-200/90 rounded-xl p-6 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-gray-900 pb-3 border-b border-gray-100">
                Add Number to Blacklist
            </h3>

            <form action="{{ route('admin.fraud.blacklist.add') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Phone Number</label>
                    <input type="text" name="phone" placeholder="01700000000" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-mono font-bold focus:outline-none focus:border-rose-500 focus:bg-white transition" required>
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Reason for Blacklisting</label>
                    <textarea name="reason" rows="3" placeholder="e.g. Refused delivery 3 times, fake address..." class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-rose-500 focus:bg-white transition" required></textarea>
                </div>

                <button type="submit" class="w-full kt-btn bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs cursor-pointer py-3">
                    <i class="fa-solid fa-ban text-xs"></i>
                    <span>Block & Blacklist Number</span>
                </button>
            </form>
        </div>

    </div>

</div>
@endsection