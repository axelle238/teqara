<div class="space-y-10">
    <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">CUSTOMER <span class="text-pink-600">SERVICE</span></h1>
        <p class="text-slate-500 font-medium">Manajemen interaksi, ulasan produk, dan resolusi kendala pelanggan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm flex items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-pink-50 flex items-center justify-center text-pink-600 font-black text-2xl">{{ number_format($rating_rata, 1) }}</div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kepuasan Rata-rata</p>
                <p class="text-2xl font-black text-slate-900">Skor Global</p>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm flex items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Interaksi</p>
                <p class="text-2xl font-black text-slate-900">{{ number_format($total_ulasan) }} Pesan</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Aktivitas Feedback</h3>
            <a href="{{ route('admin.pelanggan.ulasan') }}" wire:navigate class="text-xs font-black text-pink-600 uppercase tracking-widest">Lihat Semua</a>
        </div>
        <div class="divide-y divide-slate-50">
            @foreach($ulasan_terbaru as $u)
            <div class="p-8 flex items-start gap-6">
                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold shrink-0">{{ substr($u->pengguna->nama, 0, 1) }}</div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-slate-900">{{ $u->pengguna->nama }} <span class="text-[10px] font-black text-slate-300 uppercase ml-2">{{ $u->created_at->diffForHumans() }}</span></p>
                    <p class="text-xs text-indigo-600 font-bold mb-2">{{ $u->produk->nama }}</p>
                    <p class="text-sm text-slate-600 leading-relaxed italic">"{{ $u->komentar }}"</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
