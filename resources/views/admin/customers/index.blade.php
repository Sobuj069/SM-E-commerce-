@extends('layouts.admin')

@section('title', 'Registered Athletes & Customers')
@section('breadcrumb', 'Customers')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Customer Roster & Athletes</h1>
            <p class="text-xs text-gray-500 mt-0.5">Manage customer accounts, verified gymwear athletes, and purchase histories</p>
        </div>
        <div class="inline-flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-lg bg-white border border-gray-200 text-xs font-semibold text-gray-700 shadow-xs">
                Total Members: <strong class="text-gray-900">{{ $customers->total() }}</strong>
            </span>
        </div>
    </div>

    <!-- Metronic Customers Data Table -->
    <div class="kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
        
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="text-xs font-semibold text-gray-500">
                Displaying <span class="text-gray-900 font-bold">{{ $customers->count() }}</span> registered customer profiles
            </div>
            <div class="inline-flex items-center gap-2">
                <span class="text-xs text-gray-500 font-medium">Filter:</span>
                <span class="px-2.5 py-1 bg-gray-50 border border-gray-200 text-primary text-xs font-bold rounded-md">All Members</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                        <th class="py-3.5 px-6">Customer Profile</th>
                        <th class="py-3.5 px-6">Email Address</th>
                        <th class="py-3.5 px-6">Account Status</th>
                        <th class="py-3.5 px-6">Joined Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    @forelse($customers as $cust)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="py-3.5 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-500 to-blue-600 flex items-center justify-center text-xs font-bold text-white shrink-0 shadow-xs">
                                        {{ strtoupper(substr($cust->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-xs">{{ $cust->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-mono">ID: #CUST-{{ $cust->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-6 font-mono text-gray-600 text-xs">
                                {{ $cust->email }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-success font-bold">
                                    <i class="fa-solid fa-circle-check text-[9px] mr-1"></i> Verified
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-gray-500 text-[11px]">
                                {{ $cust->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-400 italic">No customer profiles registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection