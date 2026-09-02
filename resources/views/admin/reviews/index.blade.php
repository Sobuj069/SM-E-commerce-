@extends('layouts.admin')

@section('title', 'Review & Feedback Moderation')
@section('breadcrumb', 'Moderation / Reviews')

@section('content')
<div class="space-y-6">
    
    <div>
        <h1 class="text-xl font-black text-white">Athlete Reviews & Feedback Moderation</h1>
        <p class="text-xs text-gray-400 mt-0.5">Approve, moderate, or filter verified activewear reviews before public display</p>
    </div>

    <div class="bg-[#1e1e2d] rounded-2xl border border-[#2b2b40] shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-400 border-b border-[#2b2b40] font-black uppercase text-[10px] tracking-wider bg-[#151521]/60">
                        <th class="py-4 px-5">Activewear Item</th>
                        <th class="py-4 px-5">Author</th>
                        <th class="py-4 px-5">Rating</th>
                        <th class="py-4 px-5">Athlete Review</th>
                        <th class="py-4 px-5">Status</th>
                        <th class="py-4 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#2b2b40] font-medium">
                    @forelse($reviews as $rev)
                        <tr class="hover:bg-[#151521]/40 transition">
                            <td class="py-3.5 px-5 font-bold text-white max-w-xs truncate text-xs">
                                {{ $rev->product->name ?? 'Activewear Drop' }}
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="font-bold text-white text-xs">{{ $rev->user_name }}</div>
                                <div class="text-[10px] text-gray-500 font-mono">{{ $rev->user_email }}</div>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="text-amber-400 font-bold flex items-center gap-1">
                                    <i class="fa-solid fa-star text-[10px]"></i>
                                    <span>{{ $rev->rating }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-5 max-w-sm leading-relaxed">
                                @if($rev->title) <strong class="text-white block text-xs">{{ $rev->title }}</strong> @endif
                                <span class="line-clamp-2 text-[11px] text-gray-300">{{ $rev->comment }}</span>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $rev->is_approved ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/15 text-rose-400 border border-rose-500/30' }}">
                                    {{ $rev->is_approved ? 'Approved' : 'Pending/Hidden' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.reviews.toggle', $rev->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-[11px] font-bold transition {{ $rev->is_approved ? 'bg-amber-500/15 hover:bg-amber-500 hover:text-black text-amber-400 border border-amber-500/30' : 'bg-emerald-500/15 hover:bg-emerald-500 hover:text-white text-emerald-400 border border-emerald-500/30' }} cursor-pointer">
                                            {{ $rev->is_approved ? 'Hide' : 'Approve' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reviews.delete', $rev->id) }}" method="POST" onsubmit="return confirm('Delete this review permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white transition border border-rose-500/20 cursor-pointer" title="Delete Review">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500 italic">No reviews submitted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
            <div class="p-4 border-t border-[#2b2b40] bg-[#1a1a27]">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>

</div>
@endsection