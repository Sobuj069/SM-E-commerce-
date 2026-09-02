@extends('layouts.admin')

@section('title', 'Product Purchases & Inflow')
@section('breadcrumb', 'Inventory / Purchases')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Supplier Purchases & Stock Inflow</h1>
            <p class="text-xs text-gray-500 mt-0.5">Record inventory restocks from factories & suppliers. Automatically increments product stock!</p>
        </div>
        <div class="inline-flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-lg bg-white border border-gray-200 text-xs font-semibold text-gray-700 shadow-xs">
                Total Purchase Cost: <strong class="text-gray-900">${{ number_format($totalPurchasedValue, 2) }}</strong>
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Purchases Table (8 cols) -->
        <div class="lg:col-span-8 kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-base font-bold text-gray-900">Purchase Inflow Logs ({{ $purchases->total() }})</h3>
                <span class="text-xs text-gray-500">Auto-restocked items</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                            <th class="py-3.5 px-6">PO #</th>
                            <th class="py-3.5 px-6">Restocked Item</th>
                            <th class="py-3.5 px-6">Supplier</th>
                            <th class="py-3.5 px-6">Qty Added</th>
                            <th class="py-3.5 px-6">Unit Cost</th>
                            <th class="py-3.5 px-6">Total Cost</th>
                            <th class="py-3.5 px-6">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                        @forelse($purchases as $po)
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="py-3.5 px-6 font-mono font-bold text-primary">
                                    {{ $po->purchase_number }}
                                </td>
                                <td class="py-3.5 px-6">
                                    <div class="font-bold text-gray-900 text-xs">{{ $po->product->name ?? 'Product' }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono">{{ $po->product->sku ?? 'N/A' }}</div>
                                </td>
                                <td class="py-3.5 px-6 text-gray-800 font-semibold">
                                    {{ $po->supplier_name }}
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-success font-bold">
                                        +{{ $po->quantity }} Units
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-gray-600">
                                    ${{ number_format($po->unit_cost, 2) }}
                                </td>
                                <td class="py-3.5 px-6 font-bold text-gray-900">
                                    ${{ number_format($po->total_cost, 2) }}
                                </td>
                                <td class="py-3.5 px-6 text-gray-500 text-[11px]">
                                    {{ $po->purchase_date->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-400 italic">No purchase orders recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($purchases->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $purchases->links() }}
                </div>
            @endif
        </div>

        <!-- Right: New Purchase Form (4 cols) -->
        <div class="lg:col-span-4 kt-card bg-white border border-gray-200/90 rounded-xl p-6 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-gray-900 pb-3 border-b border-gray-100">
                Record Stock Inflow
            </h3>

            <form action="{{ route('admin.purchases.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Product / Drop to Restock</label>
                    <select name="product_id" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition" required>
                        @foreach($products as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->name }} (Current: {{ $prod->stock }} pcs)</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Supplier / Manufacturer Name</label>
                    <input type="text" name="supplier_name" placeholder="e.g. Apex Sportswear Ltd." class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition" required>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="block font-bold text-gray-700 uppercase text-[10px]">Restock Qty</label>
                        <input type="number" name="quantity" placeholder="100" min="1" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition" required>
                    </div>

                    <div class="space-y-1">
                        <label class="block font-bold text-gray-700 uppercase text-[10px]">Unit Cost ($)</label>
                        <input type="number" step="0.01" name="unit_cost" placeholder="18.50" min="0" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition" required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="block font-bold text-gray-700 uppercase text-[10px]">Purchase Date</label>
                        <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition" required>
                    </div>

                    <div class="space-y-1">
                        <label class="block font-bold text-gray-700 uppercase text-[10px]">Invoice Ref (Opt)</label>
                        <input type="text" name="invoice_no" placeholder="INV-8842" class="w-full px-3 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                    </div>
                </div>

                <button type="submit" class="w-full kt-btn kt-btn-primary text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs cursor-pointer py-3">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Record & Add Stock</span>
                </button>
            </form>
        </div>

    </div>

</div>
@endsection