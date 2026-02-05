<div class="relative overflow-hidden">
    
    <!-- Modern Hero Section -->
    <section class="relative pt-20 pb-32 overflow-hidden bg-white">
        <!-- Abstract Background Ornaments -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-slate-50 rounded-l-[100px] -z-10 translate-x-20"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-cyan-500/10 blur-[100px] rounded-full -z-10"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:items-center gap-16">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-cyan-50 border border-cyan-100 mb-8 animate-bounce">
                        <span class="flex h-2 w-2 rounded-full bg-cyan-600"></span>
                        <span class="text-xs font-black text-cyan-700 uppercase tracking-widest">Edisi Enterprise 2026</span>
                    </div>
                    <h1 class="text-5xl sm:text-7xl font-black text-slate-900 leading-[1.1] tracking-tighter mb-8">
                        {!! nl2br(e($hero->judul ?? 'Definisikan Ulang Standar Teknologi Masa Depan')) !!}
                    </h1>
                    <p class="text-xl text-slate-500 leading-relaxed mb-10 max-w-lg font-medium">
                        {{ $hero->deskripsi ?? 'Platform pengadaan perangkat komputasi high-end tercepat dan terpercaya.' }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ $hero->url_target ?? '/katalog' }}" wire:navigate class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-lg hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 flex items-center justify-center gap-3 group">
                            {{ $hero->tombol_text ?? 'Mulai Menjelajah' }}
                            <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <div class="flex items-center gap-4 px-6 py-4 rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <div class="flex -space-x-3">
                                <img class="w-10 h-10 rounded-full border-4 border-white shadow-sm" src="https://ui-avatars.com/api/?name=A&background=0891b2&color=fff">
                                <img class="w-10 h-10 rounded-full border-4 border-white shadow-sm" src="https://ui-avatars.com/api/?name=B&background=4f46e5&color=fff">
                                <img class="w-10 h-10 rounded-full border-4 border-white shadow-sm" src="https://ui-avatars.com/api/?name=C&background=10b981&color=fff">
                            </div>
                            <span class="text-sm font-bold text-slate-600">Terpercaya oleh 10rb+ Staf TI</span>
                        </div>
                    </div>
                </div>

                <div class="relative mt-20 lg:mt-0">
                    <!-- Tech Illustration Placeholder -->
                    <div class="relative rounded-[40px] overflow-hidden shadow-2xl shadow-cyan-500/20 aspect-[4/5] bg-slate-900 group">
                        <img src="{{ $hero->gambar ?? 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&q=80&w=2070' }}" class="w-full h-full object-cover opacity-60 group-hover:scale-110 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                        
                        <!-- Floating Card 1 -->
                        <div class="absolute bottom-8 left-8 right-8 p-6 glass-effect border border-white/20 rounded-3xl shadow-2xl backdrop-blur-md">
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 rounded-lg bg-cyan-500 text-[10px] font-black text-white uppercase">Stok Terbatas</span>
                                <span class="text-white font-bold">Rp 32.500.000</span>
                            </div>
                            <h3 class="text-white text-xl font-black mb-1 leading-tight">ROG Strix G16 (2024)</h3>
                            <p class="text-slate-300 text-xs font-bold uppercase tracking-widest">Intel Core i9 + RTX 4070</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stat Bar -->
    <section class="py-12 bg-slate-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center border-r border-slate-800 last:border-none">
                    <p class="text-cyan-400 text-3xl font-black mb-1">{{ number_format($statistik['transaksi_sukses']) }}+</p>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Transaksi Sukses</p>
                </div>
                <div class="text-center border-r border-slate-800 last:border-none">
                    <p class="text-indigo-400 text-3xl font-black mb-1">{{ $statistik['produk_aktif'] }}</p>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Produk Tersedia</p>
                </div>
                <div class="text-center border-r border-slate-800 last:border-none">
                    <p class="text-emerald-400 text-3xl font-black mb-1">99.9%</p>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Kepuasan Pelanggan</p>
                </div>
                <div class="text-center border-r border-slate-800 last:border-none">
                    <p class="text-violet-400 text-3xl font-black mb-1">24/7</p>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Dukungan Teknis</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Grid -->
    <section class="py-24 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div>
                    <h2 class="text-xs font-black text-cyan-600 uppercase tracking-[0.3em] mb-4">Klasifikasi Produk</h2>
                    <h3 class="text-4xl font-black text-slate-900 tracking-tighter">Telusuri Kategori Spesifik</h3>
                </div>
                <a href="/katalog" class="text-sm font-black text-slate-900 group flex items-center gap-2 border-b-2 border-cyan-500 pb-1">
                    Lihat Semua
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($kategori as $kat)
                <a href="/katalog?kategori={{ $kat->slug }}" class="group relative p-8 rounded-[32px] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-cyan-500/10 transition-all duration-500 overflow-hidden">
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition-transform duration-500 border border-slate-50">
                            {{ $kat->ikon === 'laptop' ? '💻' : ($kat->ikon === 'smartphone' ? '📱' : '⚙️') }}
                        </div>
                        <h4 class="text-lg font-black text-slate-900 mb-1">{{ $kat->nama }}</h4>
                        <p class="text-sm text-slate-500 font-bold">{{ $kat->produk_count }} Produk Ready</p>
                    </div>
                    <!-- Decorative Element -->
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-gradient-to-br from-cyan-500/5 to-indigo-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Trending Products -->
    <section class="py-24 bg-slate-50/50 border-t border-slate-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-xs font-black text-indigo-600 uppercase tracking-[0.3em] mb-4 text-center">Rekomendasi Teratas</h2>
            <h3 class="text-4xl font-black text-slate-900 tracking-tighter text-center mb-16">Pilihan Produk Unggulan</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($produkUnggulan as $p)
                <div class="group relative flex flex-col bg-white rounded-[32px] border border-slate-200/60 p-4 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500">
                    <!-- Badge & Rating -->
                    <div class="absolute top-6 left-6 z-10">
                        <div class="flex items-center gap-1 px-2 py-1 rounded-lg bg-white/80 backdrop-blur-sm border border-slate-100 shadow-sm">
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <span class="text-[10px] font-black text-slate-700">{{ $p->rating_rata_rata }}</span>
                        </div>
                    </div>

                    <!-- Media -->
                    <div class="relative aspect-square rounded-2xl overflow-hidden bg-slate-50 mb-6 group-hover:scale-[0.98] transition-transform duration-500">
                        <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain p-6 transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 to-transparent"></div>
                    </div>

                    <!-- Content -->
                    <div class="px-2 flex-1">
                        <p class="text-[10px] font-black text-cyan-600 uppercase tracking-widest mb-2">{{ $p->kategori->nama }}</p>
                        <h4 class="text-lg font-black text-slate-900 leading-snug mb-4 line-clamp-2 h-14 group-hover:text-cyan-600 transition-colors">
                            <a href="/produk/{{ $p->slug }}" wire:navigate>{{ $p->nama }}</a>
                        </h4>
                        
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-50">
                            <div>
                                <p class="text-xs font-bold text-slate-400 mb-1 uppercase tracking-tighter">Mulai Dari</p>
                                <p class="text-xl font-black text-slate-900 tracking-tighter">{{ 'Rp ' . number_format($p->harga_jual/1000, 0) . 'k' }}</p>
                            </div>
                            <a href="/produk/{{ $p->slug }}" wire:navigate class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-900 hover:bg-cyan-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Berita & Informasi Teknologi -->
    <section class="py-24 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div>
                    <h2 class="text-xs font-black text-purple-600 uppercase tracking-[0.3em] mb-4">Wawasan & Update</h2>
                    <h3 class="text-4xl font-black text-slate-900 tracking-tighter">Berita & Informasi Teknologi</h3>
                </div>
                <div class="hidden md:block">
                    <p class="text-slate-500 font-medium max-w-xs text-sm">Tetap terinformasi dengan tren perangkat keras dan software terkini dari tim analis kami.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @foreach($beritaTerbaru as $b)
                <article class="group cursor-pointer">
                    <div class="relative aspect-[16/10] rounded-[32px] overflow-hidden bg-slate-100 mb-8 border border-slate-100 shadow-sm transition-all duration-500 group-hover:shadow-2xl group-hover:shadow-purple-500/10">
                        <img src="{{ $b->gambar_unggulan ?? 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&q=80&w=2070' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent"></div>
                        <div class="absolute bottom-6 left-6">
                            <span class="px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-[10px] font-black text-white uppercase tracking-widest">Wawasan TI</span>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $b->created_at->translatedFormat('d F Y') }}</span>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span class="text-[10px] font-black text-purple-600 uppercase tracking-widest">Oleh {{ $b->penulis->nama }}</span>
                        </div>
                        <h4 class="text-xl font-black text-slate-900 leading-tight mb-4 group-hover:text-purple-600 transition-colors line-clamp-2">{{ $b->judul }}</h4>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-3">{{ $b->ringkasan }}</p>
                        <a href="#" class="inline-flex items-center gap-2 text-xs font-black text-slate-900 uppercase tracking-widest group-hover:gap-4 transition-all">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

</div>
