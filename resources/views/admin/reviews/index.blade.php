@extends('layouts.admin')

@section('title', 'Review & Feedback Moderation')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-xl font-black text-white">Review Moderation Engine</h1>
        <p class="text-xs text-slate-400 mt-1">Approve or reject customer ratings & feedback before displaying publicly</p>
    </div>

    <div class="bg-slate-900/80 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 font-black uppercase text-[10px] tracking-wider bg-slate-950/40">
                        <th class="py-4 px-4">Product</th>
                        <th class="py-4 px-4">Author</th>
                        <th class="py-4 px-4">Rating</th>
                        <th class="py-4 px-4">Comment</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($reviews as $rev)
                        <tr class="hover:bg-slate-800/30 transition">
                            <td class="py-3 px-4 font-bold text-white max-w-xs truncate">{{ $rev->product->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-slate-300">
                                <div>{{ $rev->user_name }}</div>
                                <div class="text-[10px] text-slate-500">{{ $rev->user_email }}</div>
                            </td>
                            <td class="py-3 px-4 text-amber-400 font-bold">★ {{ $rev->rating }}</td>
                            <td class="py-3 px-4 text-slate-300 max-w-sm leading-relaxed">
                                @if($rev->title) <strong class="text-white block">{{ $rev->title }}</strong> @endif
                                <span class="line-clamp-2 text-[11px]">{{ $rev->comment }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase {{ $rev->is_approved ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }}">
                                    {{ $rev->is_approved ? 'Approved' : 'Pending/Hidden' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.reviews.toggle', $rev->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl text-[11px] font-bold transition {{ $rev->is_approved ? 'bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-slate-950' : 'bg-emerald-500/10 hover:bg-emerald-500 text-emerald-400 hover:text-white' }}">
                                            {{ $rev->is_approved ? 'Hide' : 'Approve' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reviews.delete', $rev->id) }}" method="POST" onsubmit="return confirm('Delete this review permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white transition">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500 italic">No reviews submitted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection