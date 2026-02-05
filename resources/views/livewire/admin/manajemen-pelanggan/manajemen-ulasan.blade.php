<div class="space-y-10">
    <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">FEEDBACK <span class="text-pink-600">PELANGGAN</span></h1>
        <p class="text-slate-500 font-medium">Monitoring kepuasan pengguna dan kualitas unit produk.</p>
    </div>

    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="divide-y divide-slate-50">
            @forelse($ulasan as $u)
            <div class="p-8 flex flex-col md:flex-row gap-8 group hover:bg-slate-50/50 transition">
                <div class="w-full md:w-64 shrink-0">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500">{{ substr($u->pengguna->nama, 0, 1) }}</div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $u->pengguna->nama }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $u->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex gap-1 text-amber-400">
                        @for($i=1; $i<=5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $u->rating ? 'fill-current' : 'text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.783.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        @endfor
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-2">{{ $u->produk->nama }}</p>
                    <p class="text-slate-600 leading-relaxed italic">"{{ $u->komentar }}"</p>
                </div>
                <div class="shrink-0 flex items-center">
                    <button wire:click="hapus({{ $u->id }})" class="p-3 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-2xl transition-all opacity-0 group-hover:opacity-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
            @empty
            <div class="px-8 py-20 text-center text-slate-400 font-bold">Belum ada ulasan yang masuk.</div>
            @endforelse
        </div>
        <div class="p-6 bg-slate-50/30">{{ $ulasan->links() }}</div>
    </div>
</div>
