@extends('layouts.admin')

@section('title', 'Review & Feedback Moderation')
@section('breadcrumb', 'Reviews')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8">
    
    <div>
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Athlete Reviews & Feedback Moderation</h1>
        <p class="text-xs text-gray-500 mt-0.5">Approve, moderate, or filter verified activewear reviews before public display</p>
    </div>

    <div class="kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                        <th class="py-3.5 px-6">Activewear Item</th>
                        <th class="py-3.5 px-6">Author</th>
                        <th class="py-3.5 px-6">Rating</th>
                        <th class="py-3.5 px-6">Athlete Review</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    @forelse($reviews as $rev)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="py-3.5 px-6 font-bold text-gray-900 max-w-xs truncate text-xs">
                                {{ $rev->product->name ?? 'Activewear Drop' }}
                            </td>
                            <td class="py-3.5 px-6">
                                <div class="font-bold text-gray-900 text-xs">{{ $rev->user_name }}</div>
                                <div class="text-[10px] text-gray-400 font-mono">{{ $rev->user_email }}</div>
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="text-amber-500 font-bold flex items-center gap-1">
                                    <i class="fa-solid fa-star text-[10px]"></i>
                                    <span>{{ $rev->rating }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-6 max-w-sm leading-relaxed">
                                @if($rev->title) <strong class="text-gray-900 block text-xs">{{ $rev->title }}</strong> @endif
                                <span class="line-clamp-2 text-[11px] text-gray-600">{{ $rev->comment }}</span>
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="kt-badge kt-badge-sm {{ $rev->is_approved ? 'kt-badge-outline kt-badge-success' : 'kt-badge-outline kt-badge-destructive' }}">
                                    {{ $rev->is_approved ? 'Approved' : 'Hidden' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.reviews.toggle', $rev->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="kt-btn kt-btn-sm text-xs font-semibold {{ $rev->is_approved ? 'kt-btn-outline' : 'kt-btn-primary' }} cursor-pointer">
                                            {{ $rev->is_approved ? 'Hide' : 'Approve' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reviews.delete', $rev->id) }}" method="POST" onsubmit="return confirm('Delete this review permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white transition cursor-pointer" title="Delete Review">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400 italic">No reviews submitted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>

</div>
@endsection