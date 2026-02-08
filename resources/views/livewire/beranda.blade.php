<div x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 50)" class="relative overflow-hidden bg-slate-50/50">
    
    <!-- 1. HERO SECTION (FUTURISTIC & DYNAMIC) -->
    <section class="relative min-h-[90vh] flex items-center pt-20 overflow-hidden">
        <!-- Background Decor -->
        <div class="absolute top-0 right-0 w-full h-full bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-indigo-100/50 via-white to-white z-0"></div>
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-indigo-500/10 rounded-full blur-[120px] animate-pulse z-0"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-emerald-500/10 rounded-full blur-[100px] animate-pulse z-0"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="space-y-8 animate-in slide-in-from-left duration-1000">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 border border-indigo-100 rounded-full">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-600"></span>
                        </span>
                        <span class="text-[10px] font-black text-indigo-700 uppercase tracking-widest">{{ $hero->judul_kecil }}</span>
                    </div>

                    <h1 class="text-5xl lg:text-7xl font-black text-slate-900 leading-[1.1] tracking-tight">
                        {{ $hero->judul_utama }}
                    </h1>
                    
                    <p class="text-lg text-slate-500 font-medium leading-relaxed max-w-xl">
                        {{ $hero->deskripsi }}
                    </p>

                    <div class="flex flex-wrap items-center gap-6">
                        <a href="{{ $hero->url_cta }}" wire:navigate class="px-10 py-5 bg-slate-900 text-white rounded-2xl text-sm font-black uppercase tracking-widest hover:bg-indigo-600 hover:shadow-2xl hover:shadow-indigo-500/30 transition-all duration-300 active:scale-95 flex items-center gap-3">
                            {{ $hero->teks_cta }}
                            <i class="fa-solid fa-arrow-right-long animate-bounce-x"></i>
                        </a>
                        <div class="flex items-center gap-4">
                            <div class="flex -space-x-4">
                                @foreach(range(1,4) as $i)
                                    <div class="w-12 h-12 rounded-full border-4 border-white bg-slate-200 overflow-hidden shadow-sm">
                                        <img src="https://i.pravatar.cc/100?img={{ $i+10 }}" alt="User">
                                    </div>
                                @endforeach
                            </div>
                            <div class="leading-none">
                                <span class="block text-sm font-black text-slate-900">5.000+ Pelanggan</span>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase mt-1">Puas dengan Layanan Kami</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visual Element -->
                <div class="relative hidden lg:block animate-in zoom-in duration-1000">
                    <div class="relative z-10 w-full aspect-square rounded-[3rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] border-8 border-white group">
                        @if($hero->gambar)
                            <img src="{{ asset($hero->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center">
                                <i class="fa-solid fa-laptop-code text-white text-9xl opacity-20 group-hover:rotate-12 transition-transform duration-500"></i>
                            </div>
                        @endif
                        <!-- Floating Cards -->
                        <div class="absolute top-10 -left-10 bg-white/80 backdrop-blur-xl p-6 rounded-3xl shadow-2xl border border-white/50 animate-bounce-slow">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                                    <i class="fa-solid fa-shield-check"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase">Garansi Resmi</p>
                                    <p class="text-xs font-black text-slate-900">100% Original</p>
                                </div>
                            </div>
                        </div>
                        <div class="absolute bottom-10 -right-10 bg-white/80 backdrop-blur-xl p-6 rounded-3xl shadow-2xl border border-white/50 animate-float">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                                    <i class="fa-solid fa-truck-fast"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase">Pengiriman Kilat</p>
                                    <p class="text-xs font-black text-slate-900">Hari Ini Sampai</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. KATEGORI UTAMA (ICONIC GRID) -->
    <section class="py-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
                <div class="space-y-3">
                    <span class="text-xs font-black text-indigo-600 uppercase tracking-[0.3em]">Kategori Terpopuler</span>
                    <h2 class="text-4xl font-black text-slate-900 tracking-tight">Eksplorasi Teknologi</h2>
                </div>
                <a href="/katalog" wire:navigate class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2 group">
                    LIHAT SEMUA KATEGORI 
                    <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:bg-slate-900 group-hover:text-white transition-all">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach($kategori as $kat)
                <a href="/katalog?kategori={{ $kat->slug }}" wire:navigate class="group relative bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:border-indigo-200 transition-all duration-500 overflow-hidden text-center">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-16 h-16 rounded-[1.5rem] bg-slate-50 flex items-center justify-center text-2xl text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 mx-auto mb-6 relative z-10 shadow-inner">
                        <i class="{{ $kat->ikon ?? 'fa-solid fa-layer-group' }}"></i>
                    </div>
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest relative z-10">{{ $kat->nama }}</h4>
                    <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-wide relative z-10">{{ $kat->produk_count }} Produk</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 3. FLASH SALE (SINKRON & REAL-TIME) -->
    @if($penjualanKilat)
    <section class="py-24 bg-[#0f172a] relative overflow-hidden rounded-[4rem] mx-4 sm:mx-6 lg:mx-8">
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light z-0"></div>
        <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-rose-500/20 via-transparent to-indigo-500/20 z-0"></div>
        
        <div class="max-w-7xl mx-auto px-10 relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-12 mb-16">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-3 px-4 py-2 bg-rose-500 text-white rounded-xl shadow-lg shadow-rose-500/30">
                        <i class="fa-solid fa-bolt animate-pulse"></i>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em]">Penjualan Kilat</span>
                    </div>
                    <h2 class="text-5xl font-black text-white tracking-tight italic">Diskon Heboh <span class="text-rose-500">Terbatas!</span></h2>
                </div>
                
                <div class="flex items-center gap-6" x-data="{ 
                    timeLeft: '',
                    expiry: new Date('{{ $penjualanKilat->waktu_selesai }}').getTime(),
                    update() {
                        let now = new Date().getTime();
                        let diff = this.expiry - now;
                        if(diff <= 0) { this.timeLeft = 'SELESAI'; return; }
                        let h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        let m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        let s = Math.floor((diff % (1000 * 60)) / 1000);
                        this.timeLeft = `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                    }
                }" x-init="update(); setInterval(() => update(), 1000)">
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Berakhir Dalam</span>
                    <div class="flex gap-4">
                        <div class="px-6 py-4 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl text-3xl font-black text-white font-mono tracking-widest shadow-2xl" x-text="timeLeft"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($penjualanKilat->produkPenjualanKilat as $item)
                <div class="bg-white/5 backdrop-blur-xl rounded-[2.5rem] p-4 border border-white/10 hover:bg-white hover:border-white transition-all duration-500 group relative">
                    <div class="absolute top-6 left-6 z-10 bg-rose-500 text-white px-3 py-1.5 rounded-xl text-[10px] font-black shadow-lg">
                        -{{ round((($item->produk->harga_jual - $item->harga_diskon) / $item->produk->harga_jual) * 100) }}%
                    </div>
                    
                    <div class="aspect-square rounded-3xl bg-slate-900/50 overflow-hidden mb-6 relative">
                        <img src="{{ $item->produk->gambar_utama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>

                    <div class="px-2 pb-4 space-y-4">
                        <h3 class="text-sm font-black text-white group-hover:text-slate-900 transition-colors line-clamp-1 italic">{{ $item->produk->nama }}</h3>
                        <div class="space-y-1">
                            <p class="text-[10px] text-slate-500 line-through">Rp{{ number_format($item->produk->harga_jual, 0, ',', '.') }}</p>
                            <p class="text-xl font-black text-rose-500">Rp{{ number_format($item->harga_diskon, 0, ',', '.') }}</p>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="space-y-2">
                            <div class="flex justify-between text-[8px] font-black text-slate-400 uppercase">
                                <span>Terjual {{ $item->terjual }} Unit</span>
                                <span>Sisa {{ $item->kuota_stok - $item->terjual }}</span>
                            </div>
                            <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-rose-500 to-amber-500 rounded-full transition-all duration-1000" style="width: {{ ($item->terjual / $item->kuota_stok) * 100 }}%"></div>
                            </div>
                        </div>

                        <button wire:click="addToCart({{ $item->produk_id }})" class="w-full py-4 bg-rose-500 group-hover:bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-rose-500/20 active:scale-95">
                            Sikat Sekarang!
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- 4. PRODUK UNGGULAN (ENTERPRISE GRID) -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
            <div class="space-y-3">
                <span class="text-xs font-black text-indigo-600 uppercase tracking-[0.3em]">Kurasi Terbaik</span>
                <h2 class="text-4xl font-black text-slate-900 tracking-tight">Katalog Pilihan <span class="text-indigo-600">Terbaru</span></h2>
            </div>
            <div class="flex gap-4">
                <button class="w-12 h-12 rounded-2xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-200 transition-all flex items-center justify-center shadow-sm active:scale-95">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </button>
                <button class="w-12 h-12 rounded-2xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-200 transition-all flex items-center justify-center shadow-sm active:scale-95">
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($produkUnggulan as $p)
            <div class="group bg-white rounded-[3rem] p-4 border border-slate-100 shadow-sm hover:shadow-2xl hover:border-indigo-200 transition-all duration-500 relative flex flex-col h-full">
                <!-- Badges -->
                <div class="absolute top-8 left-8 z-10 flex flex-col gap-2">
                    @if($p->stok < 5)
                        <span class="px-3 py-1 bg-amber-500 text-white text-[8px] font-black uppercase rounded-lg shadow-lg">Stok Terbatas</span>
                    @endif
                    @if($p->dibuat_pada->diffInDays(now()) < 7)
                        <span class="px-3 py-1 bg-emerald-500 text-white text-[8px] font-black uppercase rounded-lg shadow-lg">Baru</span>
                    @endif
                </div>

                <div class="aspect-square rounded-[2.5rem] bg-slate-50 overflow-hidden mb-6 relative">
                    <img src="{{ asset($p->gambar->where('is_utama', 1)->first()->url ?? 'https://via.placeholder.com/400?text=Produk') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <!-- Overlay Actions -->
                    <div class="absolute inset-0 bg-indigo-600/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-4">
                        <button class="w-12 h-12 bg-white text-slate-900 rounded-2xl shadow-2xl hover:bg-indigo-600 hover:text-white transition-all active:scale-90" title="Detail Cepat">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button class="w-12 h-12 bg-white text-slate-900 rounded-2xl shadow-2xl hover:bg-pink-500 hover:text-white transition-all active:scale-90" title="Wishlist">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                    </div>
                </div>

                <div class="px-2 flex-grow flex flex-col space-y-4">
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <p class="text-[9px] font-black text-indigo-500 uppercase tracking-widest mb-1">{{ $p->kategori->nama ?? 'Umum' }}</p>
                            <h3 class="font-black text-slate-900 text-lg leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2 italic">{{ $p->nama }}</h3>
                        </div>
                        <div class="flex items-center gap-1 bg-slate-50 px-2 py-1 rounded-lg">
                            <i class="fa-solid fa-star text-[10px] text-amber-400"></i>
                            <span class="text-[10px] font-black text-slate-600">{{ $p->rating_rata_rata ?? '5.0' }}</span>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <p class="text-2xl font-black text-slate-900 tracking-tighter italic">Rp{{ number_format($p->harga_jual, 0, ',', '.') }}</p>
                        <div class="h-px bg-slate-100 my-4"></div>
                        <button wire:click="addToCart({{ $p->id }})" class="w-full py-4 bg-slate-50 group-hover:bg-indigo-600 text-slate-600 group-hover:text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 flex items-center justify-center gap-3">
                            <i class="fa-solid fa-cart-plus"></i>
                            TAMBAH KE KERANJANG
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- 5. FEATURES BENTO (ENTERPRISE TRUST) -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-10 bg-indigo-50 rounded-[3rem] space-y-6 group hover:bg-indigo-600 transition-all duration-500 border border-indigo-100">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-3xl text-indigo-600 shadow-xl group-hover:rotate-12 transition-transform">
                        <i class="fa-solid fa-truck-ramp-box"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 group-hover:text-white">Logistik Terintegrasi</h3>
                    <p class="text-sm text-slate-500 group-hover:text-indigo-100 leading-relaxed font-medium">Pengiriman aman dengan asuransi penuh ke seluruh pelosok nusantara tanpa khawatir.</p>
                </div>
                <div class="p-10 bg-emerald-50 rounded-[3rem] space-y-6 group hover:bg-emerald-600 transition-all duration-500 border border-emerald-100">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-3xl text-emerald-600 shadow-xl group-hover:rotate-12 transition-transform">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 group-hover:text-white">Harga Kompetitif</h3>
                    <p class="text-sm text-slate-500 group-hover:text-emerald-100 leading-relaxed font-medium">Beli eceran dengan harga grosir untuk kebutuhan kantor maupun penggunaan pribadi.</p>
                </div>
                <div class="p-10 bg-amber-50 rounded-[3rem] space-y-6 group hover:bg-amber-600 transition-all duration-500 border border-amber-100">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-3xl text-amber-600 shadow-xl group-hover:rotate-12 transition-transform">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 group-hover:text-white">Support 24/7</h3>
                    <p class="text-sm text-slate-500 group-hover:text-amber-100 leading-relaxed font-medium">Tim teknis ahli siap membantu instalasi dan troubleshoot perangkat Anda kapan saja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. BERITA & INSIGHTS (COLORFUL CARDS) -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-16">
            <h2 class="text-4xl font-black text-slate-900 tracking-tight italic">Teqara <span class="text-indigo-600">Insights</span></h2>
            <a href="/berita" wire:navigate class="px-6 py-3 bg-slate-50 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 transition-colors">Baca Semua</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach($beritaTerbaru as $news)
            <div class="group flex flex-col gap-6 animate-in fade-in duration-700">
                <div class="aspect-[16/9] rounded-[2.5rem] overflow-hidden relative shadow-lg">
                    <img src="{{ $news->gambar_unggulan ?? 'https://via.placeholder.com/800x450' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent"></div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 text-[9px] font-black text-indigo-600 uppercase tracking-widest">
                        <span>{{ $news->dibuat_pada->translatedFormat('d M Y') }}</span>
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <span>{{ $news->kategori_nama ?? 'Teknologi' }}</span>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2 italic">{{ $news->judul }}</h3>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed line-clamp-3">{{ $news->ringkasan }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- 7. CTA FOOTER (DYNAMIC) -->
    @if($ctaFooter)
    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-[4rem] p-16 text-center text-white relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 left-0 w-full h-full bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10 mix-blend-soft-light z-0"></div>
            <div class="relative z-10 max-w-3xl mx-auto space-y-8">
                <h2 class="text-5xl font-black tracking-tight leading-tight italic">{{ $ctaFooter->judul }}</h2>
                <p class="text-lg text-indigo-100 font-medium opacity-90 leading-relaxed">{{ $ctaFooter->deskripsi }}</p>
                <div class="flex justify-center pt-4">
                    <a href="{{ $ctaFooter->tautan_tujuan }}" class="px-12 py-5 bg-white text-indigo-700 rounded-2xl text-sm font-black uppercase tracking-widest hover:bg-indigo-50 hover:scale-105 transition-all shadow-xl active:scale-95">
                        {{ $ctaFooter->teks_tombol }}
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

</div>