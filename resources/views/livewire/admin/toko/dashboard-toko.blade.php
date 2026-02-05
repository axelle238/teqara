<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">HALAMAN <span class="text-purple-600">TOKO</span></h1>
            <p class="text-slate-500 font-medium">Kelola tampilan visual, banner, dan konten publik.</p>
        </div>
        <a href="/katalog" target="_blank" class="px-6 py-3 bg-purple-50 text-purple-700 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-purple-100 transition shadow-sm flex items-center gap-2">
            Lihat Toko
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Hero Banner</p>
                <h3 class="text-4xl font-black text-slate-900">{{ number_format($total_banner) }} <span class="text-sm text-slate-400">Slide</span></h3>
            </div>
            <div class="absolute right-0 top-0 w-32 h-32 bg-purple-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
        </div>
        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Promo Aktif</p>
                <h3 class="text-4xl font-black text-slate-900">{{ number_format($total_promo) }} <span class="text-sm text-slate-400">Banner</span></h3>
            </div>
            <div class="absolute right-0 top-0 w-32 h-32 bg-pink-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
        </div>
        <div class="bg-gradient-to-br from-purple-600 to-indigo-600 p-8 rounded-[32px] text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-xl font-black mb-2">Editor Visual</h3>
                <p class="text-xs font-medium text-purple-100 mb-6 leading-relaxed">Ubah susunan halaman depan secara real-time tanpa koding.</p>
                <a href="{{ route('admin.toko.konten') }}" wire:navigate class="inline-block px-5 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl text-xs font-bold uppercase tracking-widest transition">Buka Editor</a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Pembaruan Konten Terakhir</h3>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($konten_terbaru as $k)
            <div class="px-8 py-5 flex items-center gap-6 hover:bg-slate-50 transition">
                <div class="w-16 h-10 rounded-lg bg-slate-100 overflow-hidden shrink-0">
                    @if($k->gambar)
                    <img src="{{ $k->gambar }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <div>
                    <p class="font-bold text-slate-900 text-sm">{{ $k->judul }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $k->bagian }} • {{ $k->updated_at?->diffForHumans() ?? 'Baru saja' }}</p>
                </div>
            </div>
            @empty
            <div class="px-8 py-10 text-center text-slate-400 font-bold text-sm">Belum ada konten yang diunggah.</div>
            @endforelse
        </div>
    </div>
</div>
