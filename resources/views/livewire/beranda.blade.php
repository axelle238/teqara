<div class="relative overflow-hidden bg-white">
    
    <!-- Futuristic Vibrant Hero Section -->
    <section class="relative pt-24 pb-40 overflow-hidden">
        <!-- Colorful Ornaments -->
        <div class="absolute top-0 right-0 w-full h-full pointer-events-none -z-10">
            <div class="absolute top-[-20%] right-[-10%] w-[60%] h-[60%] bg-indigo-500/10 blur-[150px] rounded-full animate-pulse"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[50%] h-[50%] bg-cyan-500/10 blur-[150px] rounded-full"></div>
            <div class="absolute top-[20%] left-[30%] w-[30%] h-[30%] bg-emerald-500/5 blur-[120px] rounded-full animate-bounce duration-[10s]"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:items-center gap-20">
                <div class="space-y-10">
                    <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-2xl bg-indigo-50 border border-indigo-100 shadow-sm">
                        <span class="flex h-3 w-3 rounded-full bg-indigo-600 animate-ping"></span>
                        <span class="text-xs font-black text-indigo-700 uppercase tracking-[0.3em]">Era Baru Teknologi 2026</span>
                    </div>
                    
                    <h1 class="text-6xl sm:text-8xl font-black text-slate-900 leading-[0.95] tracking-tighter">
                        UPGRADE <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-cyan-600">DNA DIGITAL</span> <br>
                        ANDA<span class="text-indigo-600">.</span>
                    </h1>

                    <p class="text-xl text-slate-500 leading-relaxed max-w-lg font-medium">
                        Pengadaan perangkat komputasi tingkat tinggi dengan standar keamanan korporasi, kini hadir lebih dekat dan lebih berwarna.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-6">
                        <a href="/katalog" wire:navigate class="px-10 py-5 bg-gradient-to-r from-indigo-600 to-cyan-600 text-white rounded-3xl font-black text-lg hover:scale-105 transition-all shadow-2xl shadow-indigo-500/40 flex items-center justify-center gap-4 group">
                            Mulai Menjelajah
                            <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <div class="flex items-center gap-4 px-8 py-5 rounded-3xl border-2 border-indigo-50 bg-white/50 backdrop-blur-sm shadow-sm group hover:border-indigo-200 transition-colors">
                            <div class="flex -space-x-4">
                                <div class="w-12 h-12 rounded-full border-4 border-white bg-amber-100 flex items-center justify-center text-xl shadow-md">👨‍💻</div>
                                <div class="w-12 h-12 rounded-full border-4 border-white bg-emerald-100 flex items-center justify-center text-xl shadow-md">👩‍🚀</div>
                                <div class="w-12 h-12 rounded-full border-4 border-white bg-indigo-100 flex items-center justify-center text-xl shadow-md">🦸</div>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900 leading-none">12.5k+</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Profesional Puas</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <!-- Tech Canvas -->
                    <div class="relative rounded-[64px] overflow-hidden shadow-2xl shadow-indigo-500/20 aspect-square bg-indigo-50 border-8 border-white group">
                        <img src="{{ $hero->gambar ?? 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&q=80&w=2070' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-tr from-indigo-600/20 via-transparent to-transparent"></div>
                        
                        <!-- Floating Glass Info -->
                        <div class="absolute top-10 right-10 p-6 bg-white/80 backdrop-blur-xl border border-white rounded-[32px] shadow-2xl animate-in slide-in-from-right-10 duration-1000">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center text-white mb-4 shadow-lg shadow-indigo-500/40">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Power Tech</p>
                            <p class="text-sm font-black text-slate-900">Performa Tanpa Batas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vibrant Multi-Color Stats -->
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="p-8 rounded-[40px] bg-indigo-50 border border-indigo-100 text-center group hover:bg-white hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500">
                    <div class="text-4xl mb-4 group-hover:scale-125 transition-transform">🚀</div>
                    <p class="text-indigo-600 text-3xl font-black mb-1 leading-none">{{ number_format($statistik['transaksi_sukses']) }}</p>
                    <p class="text-indigo-400 text-[10px] font-black uppercase tracking-[0.2em]">Kirim Terkonfirmasi</p>
                </div>
                <div class="p-8 rounded-[40px] bg-emerald-50 border border-emerald-100 text-center group hover:bg-white hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500">
                    <div class="text-4xl mb-4 group-hover:scale-125 transition-transform">📦</div>
                    <p class="text-emerald-600 text-3xl font-black mb-1 leading-none">{{ $statistik['produk_aktif'] }}</p>
                    <p class="text-emerald-400 text-[10px] font-black uppercase tracking-[0.2em]">Unit Ready Stock</p>
                </div>
                <div class="p-8 rounded-[40px] bg-amber-50 border border-amber-100 text-center group hover:bg-white hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-500">
                    <div class="text-4xl mb-4 group-hover:scale-125 transition-transform">💎</div>
                    <p class="text-amber-600 text-3xl font-black mb-1 leading-none">99%</p>
                    <p class="text-amber-400 text-[10px] font-black uppercase tracking-[0.2em]">Indeks Kepuasan</p>
                </div>
                <div class="p-8 rounded-[40px] bg-rose-50 border border-rose-100 text-center group hover:bg-white hover:shadow-2xl hover:shadow-rose-500/10 transition-all duration-500">
                    <div class="text-4xl mb-4 group-hover:scale-125 transition-transform">🛠️</div>
                    <p class="text-rose-600 text-3xl font-black mb-1 leading-none">24/7</p>
                    <p class="text-rose-400 text-[10px] font-black uppercase tracking-[0.2em]">Tim Ahli Siaga</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories: High-Tech Tiles -->
    <section class="py-32 bg-slate-50/50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 gap-8">
                <div class="space-y-4">
                    <h2 class="text-xs font-black text-indigo-600 uppercase tracking-[0.4em] flex items-center gap-3">
                        <span class="w-8 h-1 bg-indigo-600 rounded-full"></span>
                        NAVIGASI KATALOG
                    </h2>
                    <h3 class="text-5xl font-black text-slate-900 tracking-tighter">Telusuri Ekosistem <span class="text-indigo-600">Unit</span></h3>
                </div>
                <a href="/katalog" class="px-8 py-4 bg-white border-2 border-indigo-100 rounded-2xl text-xs font-black text-indigo-600 uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-sm">Lihat Seluruh Koleksi</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($kategori as $kat)
                <a href="/katalog?kategori={{ $kat->slug }}" class="group relative p-10 rounded-[48px] bg-white border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-500/15 transition-all duration-500 overflow-hidden">
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="w-24 h-24 rounded-[32px] bg-slate-50 flex items-center justify-center text-5xl mb-8 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-inner">
                            {{ $kat->ikon === 'laptop' ? '💻' : ($kat->ikon === 'smartphone' ? '📱' : '🚀') }}
                        </div>
                        <h4 class="text-2xl font-black text-slate-900 mb-2 uppercase tracking-tight">{{ $kat->nama }}</h4>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">{{ $kat->produk_count }} Koleksi Tersedia</p>
                        
                        <div class="mt-8 px-6 py-2 rounded-full bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-[0.2em] group-hover:bg-indigo-600 group-hover:text-white transition-colors">Jelajahi</div>
                    </div>
                    <!-- Glow Decoration -->
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-colors duration-700"></div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Units Grid -->
    <section class="py-32 bg-white relative">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-xs font-black text-emerald-600 uppercase tracking-[0.4em] mb-4 text-center">KURASI PILIHAN</h2>
            <h3 class="text-5xl font-black text-slate-900 tracking-tighter text-center mb-24">Unit Performa <span class="text-emerald-600">Tertinggi</span></h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                @foreach($produkUnggulan as $p)
                <div class="group relative flex flex-col bg-white rounded-[48px] border border-slate-100 p-6 hover:shadow-2xl hover:shadow-emerald-500/15 transition-all duration-500">
                    <!-- Hover Visual -->
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent rounded-[48px] opacity-0 group-hover:opacity-100 transition-opacity"></div>

                    <div class="relative aspect-square rounded-[36px] overflow-hidden bg-slate-50 mb-8 border border-slate-50">
                        <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain p-10 transform group-hover:scale-110 transition-transform duration-1000">
                        <div class="absolute top-4 right-4 flex items-center gap-1.5 px-3 py-1.5 rounded-2xl bg-white shadow-xl">
                            <span class="text-amber-400">⭐</span>
                            <span class="text-[10px] font-black text-slate-900">{{ $p->rating_rata_rata }}</span>
                        </div>
                    </div>

                    <div class="px-2 space-y-4 flex-1">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-lg">{{ $p->kategori->nama }}</span>
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">{{ `p->kode_unit }}</span>
                        </div>
                        <h4 class="text-xl font-black text-slate-900 leading-[1.2] line-clamp-2 h-14 group-hover:text-emerald-600 transition-colors">
                            <a href="/produk/{{ $p->slug }}" wire:navigate>{{ $p->nama }}</a>
                        </h4>
                        
                        <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                            <p class="text-2xl font-black text-slate-900 tracking-tighter">Rp {{ number_format($p->harga_jual/1000, 0) }}<span class="text-xs text-slate-400 ml-0.5 font-bold uppercase">k</span></p>
                            <a href="/produk/{{ $p->slug }}" wire:navigate class="w-14 h-14 rounded-2xl bg-slate-900 flex items-center justify-center text-white hover:bg-emerald-600 hover:scale-110 transition-all shadow-xl shadow-slate-900/10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 4v16m8-8H4"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- News & Insights: Vibrant Newspaper Style -->
    <section class="py-32 bg-indigo-50/30 border-t border-indigo-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-20 gap-8">
                <div>
                    <h2 class="text-xs font-black text-purple-600 uppercase tracking-[0.4em] mb-4">LOG AKTIVITAS & BERITA</h2>
                    <h3 class="text-5xl font-black text-slate-900 tracking-tighter">Wawasan Teknologi <span class="text-purple-600">Teqara</span></h3>
                </div>
                <button class="px-8 py-4 bg-purple-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-purple-700 transition-all shadow-xl shadow-purple-600/20">Semua Informasi</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                @foreach($beritaTerbaru as $b)
                <article class="group">
                    <div class="relative aspect-[16/10] rounded-[48px] overflow-hidden bg-slate-200 mb-10 border-4 border-white shadow-2xl transition-all duration-500 group-hover:scale-[1.02]">
                        <img src="{{ $b->gambar_unggulan ?? 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&q=80&w=2070' }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/40 to-transparent"></div>
                        <div class="absolute top-6 left-6">
                            <span class="px-4 py-2 bg-white/90 backdrop-blur-md rounded-2xl text-[10px] font-black text-purple-600 uppercase tracking-widest shadow-sm">NEWS UPDATE</span>
                        </div>
                    </div>
                    <div class="px-2 space-y-4">
                        <div class="flex items-center gap-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            <span>{{ $b->created_at->translatedFormat('d F Y') }}</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span>
                            <span class="text-purple-600">Admin {{ $b->penulis->nama }}</span>
                        </div>
                        <h4 class="text-2xl font-black text-slate-900 leading-tight group-hover:text-purple-600 transition-colors line-clamp-2 uppercase tracking-tight">{{ $b->judul }}</h4>
                        <p class="text-slate-500 text-sm font-medium leading-relaxed line-clamp-3">{{ $b->ringkasan }}</p>
                        <a href="#" class="inline-flex items-center gap-3 text-xs font-black text-slate-900 uppercase tracking-widest border-b-2 border-purple-500 pb-1 group-hover:gap-6 transition-all duration-300">
                            Baca Narasi Lengkap
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

</div>
