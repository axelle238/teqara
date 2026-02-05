<div class="space-y-12 pb-32">
    <!-- Header: Vibrant & Professional -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-50 border border-purple-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-purple-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-purple-600 uppercase tracking-widest">Pusat Kendali Visual</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">BERANDA <span class="text-purple-600">HALAMAN TOKO</span></h1>
            <p class="text-slate-500 font-medium text-lg">Optimalkan pengalaman belanja pelanggan dengan konten yang memukau.</p>
        </div>
        <a href="/" target="_blank" class="flex items-center gap-3 px-8 py-4 bg-purple-50 text-purple-700 rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-purple-600 hover:text-white transition-all shadow-sm">
            LIHAT TOKO PUBLIK
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
        </a>
    </div>

    <!-- Statistik Pilar: Colorful Enterprise Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-14 h-14 rounded-[20px] bg-indigo-50 flex items-center justify-center text-indigo-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1-0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1-0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Total Spanduk Hero</p>
                <h3 class="text-5xl font-black text-slate-900 tracking-tighter">{{ number_format($total_banner) }} <span class="text-sm text-slate-400 font-bold uppercase ml-1">Asset</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-pink-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-14 h-14 rounded-[20px] bg-pink-50 flex items-center justify-center text-pink-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Promo Banner Aktif</p>
                <h3 class="text-5xl font-black text-slate-900 tracking-tighter">{{ number_format($total_promo) }} <span class="text-sm text-slate-400 font-bold uppercase ml-1">Unit</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-pink-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-gradient-to-br from-purple-600 to-indigo-700 p-10 rounded-[48px] text-white shadow-2xl shadow-indigo-500/30 relative overflow-hidden group">
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <h3 class="text-2xl font-black mb-3 tracking-tight">AKSES EDITOR</h3>
                    <p class="text-sm font-medium text-purple-100 leading-relaxed mb-10 opacity-80">Modifikasi struktur dan tata letak pemasaran digital Anda secara langsung.</p>
                </div>
                <a href="{{ route('admin.toko.konten') }}" wire:navigate class="w-full py-4 bg-white text-indigo-600 rounded-2xl text-xs font-black uppercase tracking-[0.2em] text-center hover:scale-105 transition-all shadow-xl">BUKA EDITOR VISUAL</a>
            </div>
            <!-- Background Deco -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full translate-x-10 -translate-y-10 group-hover:scale-150 transition-transform duration-1000"></div>
        </div>
    </div>

    <!-- Feed Log Konten: No Slate-900 -->
    <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
        <div class="px-10 py-8 border-b border-indigo-50 bg-slate-50/30 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Pembaruan Visual Terakhir</h3>
            </div>
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Sinkronisasi Real-time</span>
        </div>
        
        <div class="divide-y divide-indigo-50">
            @forelse($konten_terbaru as $k)
            <div class="px-10 py-8 flex items-center gap-8 group hover:bg-indigo-50/20 transition-all duration-300">
                <div class="w-24 h-16 rounded-2xl bg-white border border-indigo-50 overflow-hidden shrink-0 shadow-sm p-1 group-hover:scale-110 transition-transform">
                    @if($k->gambar)
                        <img src="{{ $k->gambar }}" class="w-full h-full object-cover rounded-xl">
                    @else
                        <div class="w-full h-full bg-slate-50 flex items-center justify-center text-slate-300 italic text-[10px]">No Asset</div>
                    @endif
                </div>
                <div class="flex-1 space-y-1">
                    <p class="font-black text-slate-900 text-lg tracking-tight group-hover:text-indigo-600 transition-colors uppercase">{{ $k->judul ?? 'Elemen Tanpa Judul' }}</p>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-indigo-100">{{ $k->bagian }}</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Update: {{ $k->updated_at?->diffForHumans() ?? 'Inisialisasi' }}</p>
                    </div>
                </div>
                <button class="p-4 bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white rounded-2xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
            </div>
            @empty
            <div class="px-10 py-20 text-center">
                <div class="text-6xl mb-6">🏜️</div>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter uppercase mb-2">Arsip Konten Kosong</h3>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Belum ada aktivitas modifikasi visual yang tercatat.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
