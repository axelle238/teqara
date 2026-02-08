<div class="space-y-10 animate-in fade-in zoom-in duration-700 pb-20">
    
    <!-- 1. HEADER & STATUS VISUAL -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-64 h-64 bg-pink-500/5 rounded-full blur-3xl -mr-20 -mt-20 group-hover:bg-pink-500/10 transition-colors duration-1000"></div>
        
        <div class="relative z-10 space-y-2">
            <h1 class="text-4xl font-black text-slate-900 tracking-tight uppercase leading-none">CMS <span class="text-pink-500">Center</span></h1>
            <p class="text-slate-500 font-medium tracking-wide italic">Pusat kendali visual & konten digital Teqara.</p>
        </div>

        <div class="flex gap-4 relative z-10">
            <a href="/" target="_blank" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:border-pink-200 hover:text-pink-600 transition-all shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Toko
            </a>
            <a href="{{ route('pengelola.toko.konten') }}" wire:navigate class="px-8 py-3 bg-pink-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-pink-700 shadow-xl shadow-pink-600/30 transition-all flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square"></i> Kelola Konten
            </a>
        </div>
    </div>

    <!-- 2. STATISTIK KONTEN (COLORFUL GRID) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Hero Banner -->
        <div class="p-8 rounded-[35px] bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-xl shadow-indigo-500/20 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
            <div class="absolute right-4 top-4 text-white/20 text-6xl group-hover:scale-110 transition-transform"><i class="fa-solid fa-panorama"></i></div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-2">Spanduk Utama</p>
            <h3 class="text-4xl font-black tracking-tight mb-1">{{ $konten['total_hero'] }}</h3>
            <p class="text-xs font-medium opacity-90">{{ $konten['hero_aktif'] }} Tayang Aktif</p>
        </div>

        <!-- Promo -->
        <div class="p-8 rounded-[35px] bg-gradient-to-br from-pink-500 to-rose-600 text-white shadow-xl shadow-pink-500/20 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
            <div class="absolute right-4 top-4 text-white/20 text-6xl group-hover:scale-110 transition-transform"><i class="fa-solid fa-bullhorn"></i></div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-2">Kampanye Promo</p>
            <h3 class="text-4xl font-black tracking-tight mb-1">{{ $konten['total_promo'] }}</h3>
            <p class="text-xs font-medium opacity-90">Banner Penawaran</p>
        </div>

        <!-- Artikel -->
        <div class="p-8 rounded-[35px] bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-xl shadow-emerald-500/20 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
            <div class="absolute right-4 top-4 text-white/20 text-6xl group-hover:scale-110 transition-transform"><i class="fa-solid fa-newspaper"></i></div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-2">Artikel & Berita</p>
            <h3 class="text-4xl font-black tracking-tight mb-1">{{ $berita['total'] }}</h3>
            <p class="text-xs font-medium opacity-90">{{ $berita['total_baca'] }}x Dibaca</p>
        </div>

        <!-- Fitur -->
        <div class="p-8 rounded-[35px] bg-gradient-to-br from-amber-500 to-orange-600 text-white shadow-xl shadow-amber-500/20 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
            <div class="absolute right-4 top-4 text-white/20 text-6xl group-hover:scale-110 transition-transform"><i class="fa-solid fa-star"></i></div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-2">Fitur Unggulan</p>
            <h3 class="text-4xl font-black tracking-tight mb-1">{{ $konten['fitur_unggulan'] }}</h3>
            <p class="text-xs font-medium opacity-90">Poin Key Selling</p>
        </div>
    </div>

    <!-- 3. AKTIVITAS TERBARU & AKSES CEPAT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Feed Aktivitas -->
        <div class="lg:col-span-2 bg-white rounded-[40px] p-10 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Jejak Perubahan</h3>
                <span class="px-3 py-1 bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-widest rounded-lg">Terakhir Diupdate</span>
            </div>

            <div class="space-y-6">
                @foreach($feed as $item)
                <div class="flex gap-6 group">
                    <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 overflow-hidden flex-shrink-0 relative">
                        @if($item['gambar'])
                            <img src="{{ asset($item['gambar']) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300"><i class="fa-solid fa-image"></i></div>
                        @endif
                    </div>
                    <div class="flex-1 py-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[9px] font-black text-pink-500 uppercase tracking-widest mb-1">{{ $item['bagian'] }}</p>
                                <h4 class="text-sm font-black text-slate-900 group-hover:text-pink-600 transition-colors">{{ $item['judul'] }}</h4>
                            </div>
                            <span class="text-[9px] font-bold text-slate-400">{{ $item['waktu']->diffForHumans() }}</span>
                        </div>
                        <div class="mt-2 flex gap-2">
                            <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest {{ $item['status'] == 'Aktif' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                                {{ $item['status'] }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Navigasi Cepat (Quick Links) -->
        <div class="bg-slate-900 rounded-[40px] p-10 text-white relative overflow-hidden flex flex-col justify-between">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10 mix-blend-soft-light"></div>
            
            <div class="relative z-10 space-y-6">
                <h3 class="text-xl font-black uppercase tracking-tight text-white border-b border-white/10 pb-4">Akses Cepat</h3>
                
                <a href="{{ route('pengelola.toko.konten') }}" wire:navigate class="flex items-center gap-4 group p-4 rounded-2xl hover:bg-white/5 transition-all border border-transparent hover:border-white/10">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold group-hover:text-indigo-300 transition-colors">Tata Letak Utama</p>
                        <p class="text-[9px] text-slate-400">Atur Hero & Fitur</p>
                    </div>
                </a>

                <a href="{{ route('pengelola.toko.berita') }}" wire:navigate class="flex items-center gap-4 group p-4 rounded-2xl hover:bg-white/5 transition-all border border-transparent hover:border-white/10">
                    <div class="w-10 h-10 rounded-xl bg-pink-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-pen-nib"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold group-hover:text-pink-300 transition-colors">Blog & Artikel</p>
                        <p class="text-[9px] text-slate-400">Tulis Berita Baru</p>
                    </div>
                </a>

                <a href="#" class="flex items-center gap-4 group p-4 rounded-2xl hover:bg-white/5 transition-all border border-transparent hover:border-white/10 opacity-50 cursor-not-allowed" title="Segera Hadir">
                    <div class="w-10 h-10 rounded-xl bg-slate-700 flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-palette"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Tema Warna</p>
                        <p class="text-[9px] text-slate-400">Kustomisasi CSS</p>
                    </div>
                </a>
            </div>

            <div class="relative z-10 pt-8 border-t border-white/10 text-center">
                <p class="text-[9px] text-slate-500 font-mono">CMS Engine v2.0 Active</p>
            </div>
        </div>
    </div>

</div>