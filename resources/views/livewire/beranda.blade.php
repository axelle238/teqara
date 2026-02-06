<div class="bg-slate-50 min-h-screen">
    
    <!-- Hero Section (CMS Dinamis) -->
    @if(isset($konten['hero_section']) && $konten['hero_section']->count() > 0)
        @foreach($konten['hero_section'] as $hero)
        <div class="relative w-full h-[600px] overflow-hidden group">
            <div class="absolute inset-0">
                <img src="{{ $hero->gambar ?? 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&q=80' }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" alt="{{ $hero->judul }}">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/50 to-transparent"></div>
            </div>
            <div class="relative z-10 container mx-auto px-6 h-full flex items-center">
                <div class="max-w-2xl space-y-8 animate-in slide-in-from-left-10 duration-700">
                    <span class="inline-block px-4 py-2 bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 rounded-full text-xs font-black uppercase tracking-[0.2em] backdrop-blur-md">
                        Teqara Enterprise Store
                    </span>
                    <h1 class="text-5xl md:text-7xl font-black text-white leading-tight tracking-tighter">
                        {{ $hero->judul }}
                    </h1>
                    <p class="text-lg md:text-xl text-slate-300 font-medium leading-relaxed max-w-lg">
                        {{ $hero->deskripsi }}
                    </p>
                    <div class="flex items-center gap-4 pt-4">
                        <a href="{{ $hero->tautan_tujuan ?? '/katalog' }}" wire:navigate class="px-8 py-4 bg-white text-slate-900 rounded-full font-black text-sm uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all shadow-xl hover:shadow-indigo-500/50 transform hover:-translate-y-1">
                            {{ $hero->teks_tombol ?? 'Jelajahi Sekarang' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <!-- Fallback Hero -->
        <div class="relative w-full h-[500px] bg-slate-900 flex items-center justify-center">
            <div class="text-center text-white space-y-4">
                <h1 class="text-5xl font-black tracking-tighter">SELAMAT DATANG DI TEQARA</h1>
                <p class="text-slate-400">Pusat teknologi masa depan.</p>
                <a href="/katalog" class="inline-block px-8 py-3 bg-white text-slate-900 rounded-full font-bold mt-4">Lihat Katalog</a>
            </div>
        </div>
    @endif

    <!-- Kategori Pilihan -->
    <div class="container mx-auto px-6 py-20">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tighter uppercase mb-2">Eksplorasi <span class="text-indigo-600">Kategori</span></h2>
                <p class="text-slate-500">Temukan perangkat yang sesuai dengan kebutuhan Anda.</p>
            </div>
            <a href="/katalog" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-2 group">
                Lihat Semua
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($kategori as $kat)
            <a href="/katalog?kategori={{ $kat->slug }}" wire:navigate class="group relative bg-white rounded-[32px] p-6 text-center border border-slate-100 hover:border-indigo-100 hover:shadow-xl hover:shadow-indigo-500/10 transition-all duration-300">
                <div class="w-16 h-16 mx-auto bg-slate-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-indigo-600 group-hover:scale-110 transition-all duration-300">
                    <!-- Icon Placeholder (bisa diganti icon dinamis) -->
                    <svg class="w-8 h-8 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="font-black text-slate-900 text-sm group-hover:text-indigo-600 transition-colors">{{ $kat->nama }}</h3>
                <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest">{{ $kat->produk_count }} Unit</p>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Promo Banner (CMS) -->
    @if(isset($konten['promo_banner']))
    <div class="container mx-auto px-6 mb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($konten['promo_banner'] as $promo)
            <div class="relative h-64 rounded-[40px] overflow-hidden group">
                <img src="{{ $promo->gambar }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent p-10 flex flex-col justify-center items-start">
                    <span class="px-3 py-1 bg-white/20 text-white rounded-lg text-[9px] font-black uppercase tracking-widest backdrop-blur mb-4">Promo Spesial</span>
                    <h3 class="text-3xl font-black text-white mb-2 leading-tight max-w-xs">{{ $promo->judul }}</h3>
                    <p class="text-white/80 text-sm mb-6 max-w-xs">{{ $promo->deskripsi }}</p>
                    <a href="{{ $promo->tautan_tujuan }}" class="px-6 py-3 bg-white text-slate-900 rounded-full text-xs font-black uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all">
                        {{ $promo->teks_tombol }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Produk Terlaris (Showcase) -->
    <div class="bg-slate-900 py-24 text-white relative overflow-hidden">
        <!-- Background Accents -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-600/20 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-rose-600/20 rounded-full blur-[120px] translate-x-1/2 translate-y-1/2"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-indigo-400 font-black tracking-[0.2em] text-xs uppercase mb-2 block">Pilihan Pelanggan</span>
                <h2 class="text-4xl md:text-5xl font-black tracking-tighter mb-6">PRODUK <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-rose-400">BEST SELLER</span></h2>
                <p class="text-slate-400 text-lg">Unit paling diminati bulan ini dengan performa dan nilai terbaik.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($produkTerlaris as $p)
                <div class="group bg-slate-800 rounded-[32px] p-4 hover:bg-slate-700 transition-all duration-300 border border-white/5 hover:border-indigo-500/50">
                    <div class="relative bg-white rounded-[24px] aspect-square overflow-hidden mb-6 p-6 flex items-center justify-center">
                        <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                        
                        <!-- Quick Action Overlay -->
                        <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <a href="{{ route('produk.detail', $p->slug) }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-900 shadow-xl hover:bg-indigo-600 hover:text-white transition-all transform hover:scale-110" title="Lihat Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </div>
                    </div>
                    
                    <div class="px-2 pb-2">
                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">{{ $p->kategori->nama }}</p>
                        <h3 class="text-lg font-bold text-white mb-2 line-clamp-2 leading-tight min-h-[3rem] group-hover:text-indigo-300 transition-colors">{{ $p->nama }}</h3>
                        <div class="flex items-end justify-between">
                            <div>
                                <p class="text-xs text-slate-400 line-through">Rp {{ number_format($p->harga_jual * 1.1, 0, ',', '.') }}</p>
                                <p class="text-xl font-black text-white tracking-tight">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex items-center text-amber-400 text-xs font-bold gap-1">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                {{ $p->rating_rata_rata }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Koleksi Terbaru -->
    <div class="container mx-auto px-6 py-24">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tighter uppercase mb-2">Koleksi <span class="text-indigo-600">Terbaru</span></h2>
                <p class="text-slate-500">Inovasi terkini yang baru saja mendarat.</p>
            </div>
            <a href="/katalog" class="px-6 py-3 bg-white border border-slate-200 rounded-full text-xs font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($produkUnggulan as $p)
            <div class="bg-white rounded-[32px] p-4 border border-slate-100 hover:shadow-xl hover:border-indigo-100 transition-all duration-300 group">
                <div class="relative bg-slate-50 rounded-[24px] aspect-[4/3] overflow-hidden mb-6 flex items-center justify-center">
                    <span class="absolute top-4 left-4 px-3 py-1 bg-rose-500 text-white text-[9px] font-black uppercase tracking-widest rounded-lg z-10">New Arrival</span>
                    <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain p-6 group-hover:scale-105 transition-transform duration-500 mix-blend-multiply">
                </div>
                <div class="px-2">
                    <h3 class="font-bold text-slate-900 text-lg mb-1 truncate">{{ $p->nama }}</h3>
                    <p class="text-sm text-indigo-600 font-black mb-4">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</p>
                    <a href="{{ route('produk.detail', $p->slug) }}" class="block w-full py-3 bg-slate-900 text-white text-center rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Trust Badge -->
    <div class="bg-indigo-50 border-y border-indigo-100 py-16">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="space-y-4">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto text-indigo-600 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-black text-slate-900 uppercase tracking-widest">Garansi Resmi</h3>
                    <p class="text-sm text-slate-500 max-w-xs mx-auto">Semua produk 100% original dengan garansi resmi manufaktur.</p>
                </div>
                <div class="space-y-4">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto text-indigo-600 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="font-black text-slate-900 uppercase tracking-widest">Pengiriman Kilat</h3>
                    <p class="text-sm text-slate-500 max-w-xs mx-auto">Layanan logistik prioritas dengan asuransi pengiriman penuh.</p>
                </div>
                <div class="space-y-4">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto text-indigo-600 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="font-black text-slate-900 uppercase tracking-widest">Dukungan 24/7</h3>
                    <p class="text-sm text-slate-500 max-w-xs mx-auto">Tim ahli siap membantu konsultasi teknis dan purna jual.</p>
                </div>
            </div>
        </div>
    </div>
</div>