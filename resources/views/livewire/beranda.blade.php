<div class="space-y-16 pb-16" wire:poll.20s>

    <!-- Personalized Welcome (Logged In Only) -->
    @auth
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-8">
        <div class="relative overflow-hidden rounded-[3rem] bg-gradient-to-r from-indigo-600 to-purple-600 shadow-2xl shadow-indigo-500/20 p-8 sm:p-12 text-white">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-[2rem] bg-white/20 backdrop-blur-md flex items-center justify-center text-3xl font-black shadow-inner border border-white/20">
                        {{ substr(auth()->user()->nama, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-indigo-200 text-xs font-black uppercase tracking-[0.2em] mb-1">Selamat Datang Kembali</p>
                        <h2 class="text-3xl font-black tracking-tight leading-none">{{ auth()->user()->nama }}</h2>
                        <div class="flex items-center gap-4 mt-3">
                            <span class="px-3 py-1 rounded-full bg-white/10 border border-white/10 text-[10px] font-bold uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                {{ auth()->user()->level_member ?? 'Classic' }} Member
                            </span>
                            <span class="text-xs font-bold text-indigo-100">{{ number_format(auth()->user()->poin_loyalitas ?? 0) }} Poin</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <a href="{{ route('pelanggan.dasbor') }}" class="px-8 py-4 bg-white text-indigo-600 rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-50 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                        Ke Dasbor Saya
                    </a>
                    <a href="{{ route('pesanan.riwayat') }}" class="px-8 py-4 bg-indigo-800/50 border border-indigo-400/30 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-800 transition-all backdrop-blur-sm">
                        Lacak Pesanan
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endauth

    <!-- Hero Section (Logged Out or General) -->
    @guest
    <section class="relative pt-8 pb-4 overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-[2.5rem] bg-slate-900 overflow-hidden shadow-2xl shadow-indigo-500/30">
                <!-- Background Decoration -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-gradient-to-br from-indigo-600 to-cyan-500 rounded-full blur-3xl opacity-30 animate-pulse"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[400px] h-[400px] bg-gradient-to-tr from-fuchsia-600 to-pink-500 rounded-full blur-3xl opacity-20"></div>
                
                <div class="relative grid lg:grid-cols-2 gap-12 items-center p-8 sm:p-16">
                    <div class="space-y-8">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-cyan-300 text-xs font-bold uppercase tracking-widest shadow-lg">
                            <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                            {{ $hero->judul_kecil ?? 'Teknologi Masa Depan' }}
                        </div>
                        <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black text-white leading-tight tracking-tight">
                            {{ $hero->judul_utama ?? 'Upgrade Duniamu Sekarang.' }}
                        </h1>
                        <p class="text-lg text-slate-300 max-w-xl leading-relaxed">
                            {{ $hero->deskripsi ?? 'Temukan koleksi gadget dan komputer terbaru dengan performa maksimal untuk kebutuhan profesional dan gaming Anda.' }}
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ $hero->url_cta ?? '/katalog' }}" wire:navigate class="px-8 py-4 bg-white text-slate-900 rounded-2xl font-black hover:scale-105 transition-transform shadow-[0_0_20px_rgba(255,255,255,0.3)]">
                                {{ $hero->teks_cta ?? 'BELANJA SEKARANG' }}
                            </a>
                            <a href="#unggulan" class="px-8 py-4 bg-transparent border border-white/20 text-white rounded-2xl font-bold hover:bg-white/10 transition-colors backdrop-blur-sm">
                                Lihat Produk
                            </a>
                        </div>
                    </div>
                    
                    <div class="relative hidden lg:block h-[500px]">
                        @if($hero && $hero->gambar)
                            <img src="{{ asset('storage/'.$hero->gambar) }}" alt="Hero Image" class="absolute inset-0 w-full h-full object-contain drop-shadow-[0_20px_50px_rgba(0,0,0,0.5)] hover:scale-105 transition-transform duration-700 ease-out">
                        @else
                            <!-- Placeholder 3D Abstract -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-80 h-80 bg-gradient-to-tr from-indigo-500 to-cyan-400 rounded-3xl rotate-12 shadow-2xl flex items-center justify-center">
                                    <span class="text-9xl">💻</span>
                                </div>
                                <div class="absolute w-80 h-80 bg-gradient-to-tr from-fuchsia-500 to-pink-400 rounded-3xl -rotate-6 -z-10 opacity-70 scale-90 translate-x-12 translate-y-12"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endguest

    <!-- USP Section -->
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($fiturUnggulan as $fitur)
            <div class="flex items-start gap-6 p-6 rounded-3xl bg-white border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-3xl group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 overflow-hidden">
                    @if($fitur->gambar)
                        <img src="{{ asset($fitur->gambar) }}" class="w-full h-full object-cover">
                    @else
                        🛡️
                    @endif
                </div>
                <div>
                    <h3 class="font-black text-lg text-slate-900 mb-2">{{ $fitur->judul }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">{{ $fitur->deskripsi }}</p>
                </div>
            </div>
            @empty
            <!-- Fallback Static USP 1 -->
            <div class="flex items-start gap-6 p-6 rounded-3xl bg-white border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-3xl group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                    🛡️
                </div>
                <div>
                    <h3 class="font-black text-lg text-slate-900 mb-2">Garansi Resmi</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Semua produk 100% original dengan jaminan garansi resmi distributor Indonesia.</p>
                </div>
            </div>
             <!-- USP 2 -->
             <div class="flex items-start gap-6 p-6 rounded-3xl bg-white border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-16 h-16 rounded-2xl bg-cyan-50 flex items-center justify-center text-3xl group-hover:scale-110 group-hover:bg-cyan-600 group-hover:text-white transition-all duration-300">
                    🚀
                </div>
                <div>
                    <h3 class="font-black text-lg text-slate-900 mb-2">Pengiriman Kilat</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Layanan pengiriman instan dan berasuransi ke seluruh pelosok Nusantara.</p>
                </div>
            </div>
             <!-- USP 3 -->
             <div class="flex items-start gap-6 p-6 rounded-3xl bg-white border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-3xl group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                    💳
                </div>
                <div>
                    <h3 class="font-black text-lg text-slate-900 mb-2">Cicilan 0%</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Nikmati kemudahan pembayaran dengan cicilan ringan tanpa bunga.</p>
                </div>
            </div>
            @endforelse
        </div>
    </section>

    <!-- Dynamic Promo Banners -->
    @if($promoBanners->count() > 0)
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($promoBanners as $banner)
            <div class="relative rounded-[2rem] overflow-hidden aspect-[21/9] group shadow-lg shadow-indigo-500/10 hover:shadow-xl transition-all duration-500">
                @if($banner->gambar)
                    <img src="{{ asset($banner->gambar) }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                @else
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/40 to-transparent p-8 flex flex-col justify-center items-start">
                    <h3 class="text-xl md:text-2xl font-black text-white uppercase leading-none mb-2 max-w-[80%]">{{ $banner->judul }}</h3>
                    <p class="text-xs text-indigo-200 font-medium mb-4 line-clamp-2 max-w-[70%]">{{ $banner->deskripsi }}</p>
                    @if($banner->tautan_tujuan)
                    <a href="{{ $banner->tautan_tujuan }}" class="px-5 py-2 bg-white text-indigo-900 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 transition-colors backdrop-blur-sm">
                        {{ $banner->teks_tombol ?? 'Cek Sekarang' }}
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Kategori Populer -->
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Kategori Populer</h2>
                <div class="h-1.5 w-24 bg-gradient-to-r from-indigo-500 to-cyan-400 rounded-full mt-2"></div>
            </div>
            <a href="/katalog" wire:navigate class="group flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-700">
                Lihat Semua
                <span class="group-hover:translate-x-1 transition-transform">→</span>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($kategori as $kat)
                <a href="/katalog?kategori={{ $kat->slug }}" wire:navigate class="group relative overflow-hidden rounded-3xl bg-white border border-slate-100 p-6 hover:shadow-xl transition-all duration-300 text-center hover:-translate-y-1">
                    <div class="mb-4 relative z-10 w-16 h-16 mx-auto rounded-2xl bg-slate-50 flex items-center justify-center text-3xl group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        {{-- Menggunakan Ikon dari DB atau Placeholder --}}
                        @if($kat->ikon && !str_starts_with($kat->ikon, 'fa'))
                             <img src="{{ asset('storage/'.$kat->ikon) }}" class="w-10 h-10 object-contain">
                        @else
                             <span>💻</span>
                        @endif
                    </div>
                    <h3 class="font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $kat->nama }}</h3>
                    <p class="text-xs text-slate-500 mt-1">{{ $kat->produk_count }} Produk</p>
                    
                    <!-- Hover Decoration -->
                    <div class="absolute -bottom-10 -right-10 w-24 h-24 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-500 -z-0"></div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Flash Sale (Enterprise Real-time) -->
    @if($penjualanKilat)
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12" x-data="{ 
        timeLeft: '',
        targetDate: new Date('{{ $penjualanKilat->waktu_selesai }}').getTime(),
        init() {
            setInterval(() => {
                const now = new Date().getTime();
                const distance = this.targetDate - now;
                if (distance < 0) { this.timeLeft = 'BERAKHIR'; return; }
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                this.timeLeft = hours + 'j ' + minutes + 'm ' + seconds + 's';
            }, 1000);
        }
    }">
        <div class="bg-slate-900 rounded-[3rem] p-10 relative overflow-hidden shadow-2xl border border-white/5">
            <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px]"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 mb-12">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-3xl flex items-center justify-center text-4xl shadow-lg animate-pulse">⚡</div>
                    <div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase italic">Flash Sale <span class="text-yellow-400">Kilat</span></h2>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="px-3 py-1 bg-white/10 rounded-lg text-[10px] font-black text-white uppercase tracking-widest">Berakhir Dalam:</span>
                            <span class="text-xl font-mono font-black text-yellow-400 tracking-tighter" x-text="timeLeft">00:00:00</span>
                        </div>
                    </div>
                </div>
                <a href="/katalog" class="px-8 py-4 bg-white text-slate-900 rounded-2xl font-black uppercase tracking-widest hover:scale-105 transition-transform">Lihat Semua Promo</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative z-10">
                @foreach($penjualanKilat->produkPenjualanKilat as $item)
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-[2.5rem] p-5 group hover:bg-white/10 transition-all cursor-pointer">
                    <div class="relative aspect-square rounded-3xl bg-white overflow-hidden mb-4">
                        <img src="{{ $item->produk->gambar_utama_url }}" class="w-full h-full object-contain p-6 group-hover:scale-110 transition-transform">
                        <div class="absolute top-3 left-3 px-3 py-1 bg-rose-600 text-white text-[10px] font-black rounded-lg">HEMAT {{ round((($item->produk->harga_jual - $item->harga_diskon) / $item->produk->harga_jual) * 100) }}%</div>
                    </div>
                    <h3 class="text-white font-bold text-sm truncate">{{ $item->produk->nama }}</h3>
                    <div class="mt-2 flex items-center gap-3">
                        <span class="text-yellow-400 font-black text-lg">Rp{{ number_format($item->harga_diskon, 0, ',', '.') }}</span>
                        <span class="text-white/30 text-xs line-through">Rp{{ number_format($item->produk->harga_jual, 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-4 space-y-1.5">
                        <div class="flex justify-between text-[9px] font-bold text-white/50 uppercase tracking-widest">
                            <span>Terjual {{ $item->terjual }}</span>
                            <span>Sisa {{ $item->kuota_stok - $item->terjual }}</span>
                        </div>
                        <div class="w-full bg-white/10 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-full transition-all duration-1000" style="width: {{ ($item->terjual / $item->kuota_stok) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Produk Unggulan (With Stock Pulse) -->
    <section id="unggulan" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase">Pilihan <span class="text-indigo-600">Teknisi</span></h2>
                <p class="text-slate-500 font-medium mt-2 uppercase tracking-widest text-[10px]">Unit Terlaris & Paling Direkomendasikan</p>
            </div>
            <div class="flex gap-2">
                <button class="w-12 h-12 rounded-2xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 transition-all shadow-sm flex items-center justify-center"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="w-12 h-12 rounded-2xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 transition-all shadow-sm flex items-center justify-center"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($produkUnggulan as $produk)
                <div class="bg-white rounded-[3rem] p-6 border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-500/10 transition-all group relative">
                    <!-- Stock Pulse Indicator -->
                    <div class="absolute top-8 right-8 z-20 flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-full border border-slate-100">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $produk->stok > 10 ? 'bg-emerald-400' : ($produk->stok > 0 ? 'bg-amber-400' : 'bg-rose-400') }} opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 {{ $produk->stok > 10 ? 'bg-emerald-500' : ($produk->stok > 0 ? 'bg-amber-500' : 'bg-rose-500') }}"></span>
                        </span>
                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-500">{{ $produk->stok > 0 ? 'Ready Stock' : 'Habis' }}</span>
                    </div>

                    <a href="{{ route('produk.detail', $produk->slug) }}" wire:navigate class="block aspect-square rounded-[2rem] bg-slate-50 overflow-hidden mb-6 p-8 relative">
                        <img src="{{ $produk->gambar_utama_url }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-indigo-600/0 group-hover:bg-indigo-600/5 transition-colors"></div>
                    </a>

                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">{{ $produk->kategori->nama }}</p>
                            <h3 class="font-black text-slate-900 text-lg leading-tight mt-1 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $produk->nama }}</h3>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Harga Enterprise</span>
                                <span class="text-xl font-black text-slate-900 tracking-tight">Rp{{ number_format($produk->harga_jual, 0, ',', '.') }}</span>
                            </div>
                            <button wire:click="addToCart({{ $produk->id }})" class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center hover:bg-indigo-600 transition-all shadow-lg active:scale-90">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
        
        <div class="mt-12 text-center">
            <a href="/katalog" wire:navigate class="inline-flex items-center gap-3 px-8 py-4 bg-white border border-slate-200 text-slate-900 rounded-2xl font-black hover:bg-slate-50 hover:border-indigo-200 hover:text-indigo-600 transition-all shadow-sm">
                JELAJAHI KATALOG LENGKAP
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </section>

    <!-- Berita Terbaru -->
    <section class="bg-indigo-50/50 py-16 border-y border-indigo-100/50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Kabar Teqara</h2>
                    <div class="h-1.5 w-24 bg-gradient-to-r from-indigo-500 to-cyan-400 rounded-full mt-2"></div>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse($beritaTerbaru as $berita)
                    <article class="bg-white rounded-3xl p-4 shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div class="aspect-video bg-slate-200 rounded-2xl overflow-hidden mb-4 relative">
                            @if($berita->thumbnail)
                                <img src="{{ asset('storage/'.$berita->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-4xl bg-indigo-50 text-indigo-200">📰</div>
                            @endif
                            <div class="absolute bottom-3 left-3 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-[10px] font-black uppercase tracking-widest text-indigo-600">
                                {{ $berita->dibuat_pada->format('d M Y') }}
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2 leading-tight group-hover:text-indigo-600 transition-colors">
                            <a href="#">{{ $berita->judul }}</a>
                        </h3>
                        <p class="text-sm text-slate-500 line-clamp-2 mb-4">{{ $berita->ringkasan }}</p>
                        <a href="#" class="inline-flex items-center text-xs font-black text-indigo-600 uppercase tracking-widest hover:gap-2 transition-all">
                            Baca Selengkapnya ->
                        </a>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-400">
                        Belum ada berita terbaru.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Dynamic Payment Partners (Real-time Integration) -->
    <section class="py-12 border-t border-slate-100 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Official Payment Partners</p>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-70 hover:opacity-100 transition-opacity">
                <!-- Midtrans (Always show if configured) -->
                @if(isset($paymentConfig['payment_midtrans_id']) && !empty($paymentConfig['payment_midtrans_id']))
                    <div class="group flex flex-col items-center gap-2">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Midtrans.png/1200px-Midtrans.png" class="h-8 grayscale group-hover:grayscale-0 transition-all">
                        @if(($paymentConfig['payment_midtrans_mode'] ?? 'sandbox') === 'sandbox')
                            <span class="text-[8px] font-bold bg-amber-100 text-amber-700 px-2 py-0.5 rounded uppercase">Sandbox Mode</span>
                        @endif
                    </div>
                @endif

                <!-- Xendit (Only if configured) -->
                @if(isset($paymentConfig['payment_xendit_secret']) && !empty($paymentConfig['payment_xendit_secret']))
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/9b/Xendit_logo.png" class="h-8 grayscale hover:grayscale-0 transition-all">
                @endif

                <!-- Bank Logos (Static for visual completeness) -->
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/2560px-Bank_Central_Asia.svg.png" class="h-8 grayscale hover:grayscale-0 transition-all">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0e/Logo_Bank_Mandiri_North_Europe_Ltd.svg/2560px-Logo_Bank_Mandiri_North_Europe_Ltd.svg.png" class="h-8 grayscale hover:grayscale-0 transition-all">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/2560px-BANK_BRI_logo.svg.png" class="h-8 grayscale hover:grayscale-0 transition-all">
            </div>
        </div>
    </section>

    <!-- Mobile App Banner -->
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-16">
        <div class="relative bg-[#0f172a] rounded-[3rem] overflow-hidden p-12 flex flex-col md:flex-row items-center gap-12">
            <!-- Background FX -->
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10"></div>
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/30 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>

            <div class="flex-1 relative z-10 space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-500/20 border border-indigo-500/30 rounded-full text-indigo-300 text-xs font-black uppercase tracking-widest">
                    <i class="fa-solid fa-mobile-screen"></i> Mobile First
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-white tracking-tight leading-none">
                    Belanja Lebih Cepat<br>
                    <span class="text-indigo-500">Dalam Genggaman.</span>
                </h2>
                <p class="text-slate-400 text-lg max-w-md">Download aplikasi Teqara Enterprise sekarang. Nikmati promo eksklusif aplikasi dan notifikasi pesanan real-time.</p>
                <div class="flex gap-4 pt-4">
                    <button class="bg-white text-slate-900 px-6 py-3 rounded-xl flex items-center gap-3 font-bold hover:bg-indigo-50 transition-colors">
                        <i class="fa-brands fa-apple text-2xl"></i>
                        <div class="text-left leading-none">
                            <span class="text-[9px] uppercase tracking-wider block">Download on the</span>
                            <span class="text-sm font-black">App Store</span>
                        </div>
                    </button>
                    <button class="bg-transparent border border-slate-700 text-white px-6 py-3 rounded-xl flex items-center gap-3 font-bold hover:bg-white/5 transition-colors">
                        <i class="fa-brands fa-google-play text-2xl"></i>
                        <div class="text-left leading-none">
                            <span class="text-[9px] uppercase tracking-wider block">Get it on</span>
                            <span class="text-sm font-black">Google Play</span>
                        </div>
                    </button>
                </div>
            </div>
            
            <div class="flex-1 relative h-64 md:h-96 w-full flex items-center justify-center">
                <!-- Phone Mockup CSS -->
                <div class="relative w-48 h-96 bg-slate-900 rounded-[3rem] border-8 border-slate-800 shadow-2xl rotate-12 hover:rotate-6 transition-transform duration-500">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-24 h-6 bg-slate-800 rounded-b-xl z-20"></div>
                    <div class="w-full h-full bg-indigo-600 rounded-[2.5rem] overflow-hidden relative">
                        <div class="p-4 pt-12 space-y-4">
                            <div class="h-8 w-24 bg-white/20 rounded-lg"></div>
                            <div class="h-32 w-full bg-white/10 rounded-2xl"></div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="h-24 bg-white/10 rounded-xl"></div>
                                <div class="h-24 bg-white/10 rounded-xl"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter CTA -->
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-[2.5rem] bg-indigo-600 overflow-hidden px-8 py-16 sm:px-16 text-center shadow-2xl shadow-indigo-500/30">
            <!-- Background Decoration -->
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-cyan-400 rounded-full blur-3xl opacity-30"></div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-fuchsia-400 rounded-full blur-3xl opacity-30"></div>

            <div class="relative z-10 max-w-2xl mx-auto space-y-8">
                <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Jangan Ketinggalan Info Terbaru!</h2>
                <p class="text-indigo-100 text-lg">Dapatkan info eksklusif tentang produk baru, promo flash sale, dan tips teknologi langsung di inbox Anda.</p>
                
                <form class="flex flex-col sm:flex-row gap-4">
                    <input type="email" placeholder="Masukkan alamat email Anda" class="flex-1 px-6 py-4 rounded-2xl border-none focus:ring-4 focus:ring-cyan-400/50 bg-white/10 text-white placeholder-indigo-200 backdrop-blur-sm transition-all">
                    <button type="submit" class="px-8 py-4 bg-white text-indigo-600 rounded-2xl font-black uppercase tracking-widest hover:bg-cyan-50 transition-colors shadow-lg">
                        Berlangganan
                    </button>
                </form>
                <p class="text-xs text-indigo-200">Kami menghargai privasi Anda. Unsubscribe kapan saja.</p>
            </div>
        </div>
    </section>

</div>
