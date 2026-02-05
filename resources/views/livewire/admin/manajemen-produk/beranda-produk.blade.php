<div class="space-y-12 pb-32">
    <!-- Header: Vibrant & Professional -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Pusat Inventaris Teknologi</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">BERANDA <span class="text-emerald-600">PRODUK</span></h1>
            <p class="text-slate-500 font-medium text-lg">Kelola katalog unit, master data kategori, dan audit merek dalam satu radar.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.produk.katalog') }}" wire:navigate class="px-8 py-4 bg-emerald-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/20">KELOLA KATALOG</a>
        </div>
    </div>

    <!-- Statistik Pilar: Colorful Inventory Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="bg-white p-8 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-12 h-12 rounded-[18px] bg-indigo-50 flex items-center justify-center text-indigo-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Populasi Varian Unit</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($total_produk) }} <span class="text-xs text-slate-400 font-bold uppercase ml-1">SKU</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-white p-8 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-12 h-12 rounded-[18px] bg-amber-50 flex items-center justify-center text-amber-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Radar Stok Kritis</p>
                <h3 class="text-4xl font-black text-amber-600 tracking-tighter">{{ number_format($stok_menipis) }} <span class="text-xs text-slate-400 font-bold uppercase ml-1">Unit</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-white p-8 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-12 h-12 rounded-[18px] bg-blue-50 flex items-center justify-center text-blue-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Total Kategori</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($total_kategori) }} <span class="text-xs text-slate-400 font-bold uppercase ml-1">Grup</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-white p-8 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-12 h-12 rounded-[18px] bg-purple-50 flex items-center justify-center text-purple-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Afiliasi Merek</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($total_merek) }} <span class="text-xs text-slate-400 font-bold uppercase ml-1">Brand</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-purple-500/5 rounded-full blur-3xl"></div>
        </div>
    </div>

    <!-- Feed Produk Baru: No Dark Policy -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
            <div class="px-10 py-8 border-b border-indigo-50 bg-slate-50/30 flex items-center justify-between">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Unit Registrasi Terbaru</h3>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Live Inventory</span>
            </div>
            <div class="divide-y divide-indigo-50">
                @foreach($produk_terbaru as $p)
                <div class="px-10 py-6 flex items-center gap-6 group hover:bg-indigo-50/20 transition-all">
                    <div class="w-16 h-16 rounded-[24px] bg-white border border-indigo-50 overflow-hidden shrink-0 shadow-sm p-2 group-hover:scale-110 transition-transform">
                        <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain">
                    </div>
                    <div class="flex-1 space-y-1">
                        <p class="font-black text-slate-900 text-base tracking-tight uppercase group-hover:text-indigo-600 transition-colors">{{ $p->nama }}</p>
                        <div class="flex items-center gap-3">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Stok: {{ $p->stok }} Unit</span>
                            <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                            <span class="text-[10px] font-black text-indigo-600 uppercase tracking-tighter">Rp {{ number_format($p->harga_jual) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.produk.spesifikasi', $p->id) }}" wire:navigate class="p-3 bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white rounded-2xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Master Data Shortcuts -->
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-[56px] p-12 text-white shadow-2xl relative overflow-hidden flex flex-col justify-between">
            <div class="relative z-10 space-y-8">
                <div>
                    <h2 class="text-3xl font-black tracking-tighter uppercase mb-4">KONTROL <br> MASTER DATA</h2>
                    <p class="text-indigo-100 font-medium text-lg opacity-80">Konfigurasi parameter dasar kategori dan merek untuk standarisasi katalog.</p>
                </div>
                
                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('admin.kategori') }}" wire:navigate class="flex items-center justify-between p-6 bg-white/10 hover:bg-white/20 border border-white/10 rounded-[32px] transition-all group">
                        <span class="font-black uppercase tracking-widest text-sm">Klasifikasi Kategori</span>
                        <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                    <a href="{{ route('admin.merek') }}" wire:navigate class="flex items-center justify-between p-6 bg-white/10 hover:bg-white/20 border border-white/10 rounded-[32px] transition-all group">
                        <span class="font-black uppercase tracking-widest text-sm">Otoritas Merek</span>
                        <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
            <div class="absolute top-0 left-0 w-64 h-64 bg-emerald-400/10 rounded-full blur-[100px] -translate-x-1/2 -translate-y-1/2"></div>
        </div>
    </div>
</div>
