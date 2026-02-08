<div class="space-y-24 pb-20 animate-in fade-in duration-1000" wire:poll.30s>
    
    <!-- HEADER: PERSONALIZED COMMAND CENTER (Logged In) -->
    @auth
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
        <div class="relative overflow-hidden rounded-[4rem] bg-slate-900 border border-white/5 shadow-2xl p-10 sm:p-16 text-white group">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/20 via-transparent to-fuchsia-600/10"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px] group-hover:scale-110 transition-transform duration-1000"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-12">
                <div class="flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
                    <div class="w-24 h-24 rounded-[2.5rem] bg-gradient-to-tr from-indigo-500 to-purple-500 p-1 shadow-2xl shadow-indigo-500/40 transform -rotate-3 group-hover:rotate-0 transition-transform duration-500">
                        <div class="w-full h-full bg-slate-900 rounded-[2.3rem] flex items-center justify-center text-4xl font-black italic">
                            {{ substr(auth()->user()->nama, 0, 1) }}
                        </div>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full border border-white/10 mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-[9px] font-black text-indigo-200 uppercase tracking-widest">{{ auth()->user()->level_member ?? 'Classic' }} Member</span>
                        </div>
                        <h2 class="text-4xl font-black tracking-tighter leading-none italic">Halo, <span class="text-indigo-400">{{ explode(' ', auth()->user()->nama)[0] }}!</span></h2>
                        <p class="text-slate-400 mt-2 font-medium tracking-wide">Akses cepat ke aset teknologi dan riwayat transaksi Anda.</p>
                    </div>
                </div>
                
                <div class="flex flex-wrap justify-center gap-4">
                    <div class="bg-white/5 backdrop-blur-md rounded-3xl p-6 border border-white/5 text-center min-w-[140px]">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Poin</p>
                        <p class="text-2xl font-black text-indigo-400 italic">{{ number_format(auth()->user()->poin_loyalitas ?? 0) }}</p>
                    </div>
                    <a href="{{ route('pelanggan.dasbor') }}" class="px-10 py-6 bg-white text-slate-900 rounded-3xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-2xl hover:shadow-indigo-500/40 active:scale-95">Pusat Kendali Saya</a>
                </div>
            </div>
        </div>
    </section>
    @endauth

    <!-- HERO SECTION: ENTERPRISE HIGHLIGHT (Logged Out) -->
    @guest
    <section class="relative pt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative min-h-[600px] flex items-center rounded-[5rem] overflow-hidden bg-slate-950 shadow-2xl border border-white/5">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/30 via-transparent to-rose-600/20"></div>
                <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay"></div>
                
                <div class="relative z-10 grid lg:grid-cols-2 gap-16 items-center p-12 md:p-24">
                    <div class="space-y-8 text-center lg:text-left">
                        <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/10 border border-white/20 backdrop-blur-md">
                            <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                            <span class="text-[10px] font-black text-indigo-200 uppercase tracking-[0.3em] italic">{{ $hero->judul_kecil ?? 'ENTERPRISE READY' }}</span>
                        </div>
                        <h1 class="text-5xl md:text-7xl font-black text-white leading-[1.1] tracking-tighter italic">
                            {{ $hero->judul_utama ?? 'Upgrade Performa Bisnis Anda.' }}
                        </h1>
                        <p class="text-lg text-slate-300 font-medium max-w-xl mx-auto lg:mx-0 leading-relaxed italic opacity-80">
                            "{{ $hero->deskripsi ?? 'Solusi pengadaan perangkat keras dan lunak terpadu untuk skala korporasi dan profesional.' }}"
                        </p>
                        <div class="flex flex-wrap justify-center lg:justify-start gap-6">
                            <a href="{{ $hero->url_cta ?? '/katalog' }}" class="px-10 py-5 bg-indigo-600 text-white rounded-2xl text-sm font-black uppercase tracking-widest shadow-2xl shadow-indigo-500/40 hover:bg-white hover:text-slate-900 transition-all active:scale-95">
                                {{ $hero->teks_cta ?? 'MULAI EKSPLORASI' }}
                            </a>
                        </div>
                    </div>
                    <div class="hidden lg:block relative group">
                        <div class="absolute -inset-10 bg-indigo-500/20 rounded-full blur-[100px] group-hover:bg-indigo-500/40 transition-all"></div>
                        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=1000&auto=format&fit=crop" class="relative w-full rounded-[3rem] shadow-2xl transform rotate-3 group-hover:rotate-0 transition-transform duration-1000">
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endguest

    <!-- USP: PILAR KEUNGGULAN -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach($fiturUnggulan as $fitur)
            <div class="p-8 bg-white rounded-[3rem] border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 group border-b-8 border-b-indigo-500/10 hover:border-b-indigo-500">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-3xl group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 mb-6">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-3">{{ $fitur->judul }}</h3>
                <p class="text-sm text-slate-500 font-medium leading-relaxed italic">"{{ $fitur->deskripsi }}"</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- FLASH SALE: PENJUALAN KILAT (DYNAMIC COUNTDOWN) -->
    @if($penjualanKilat)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-rose-600 to-orange-500 rounded-[4rem] p-1 shadow-2xl">
            <div class="bg-white rounded-[3.8rem] p-10 md:p-16 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-96 h-96 bg-rose-50 rounded-full blur-[100px] -mr-20 -mt-20 opacity-50"></div>
                
                <div class="flex flex-col lg:flex-row justify-between items-center gap-12 mb-16 relative z-10">
                    <div class="flex items-center gap-8">
                        <div class="w-20 h-20 bg-rose-600 text-white rounded-3xl flex items-center justify-center text-4xl shadow-2xl shadow-rose-500/40 animate-pulse transform -rotate-6">
                            <i class="fa-solid fa-bolt-lightning"></i>
                        </div>
                        <div>
                            <h2 class="text-4xl font-black text-slate-900 uppercase tracking-tighter italic leading-none">Flash Sale <span class="text-rose-600">Kilat!</span></h2>
                            <p class="text-slate-500 font-bold uppercase tracking-[0.2em] text-[10px] mt-2">Penawaran Terbatas Skala Enterprise</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-6 bg-slate-950 p-6 rounded-[2.5rem] text-white px-12 shadow-2xl border border-white/10" 
                         x-data="{ 
                            timer: '',
                            deadline: '{{ $penjualanKilat->waktu_selesai }}',
                            update() {
                                const total = Date.parse(this.deadline) - Date.parse(new Date());
                                if (total <= 0) return this.timer = 'BERAKHIR';
                                const seconds = Math.floor((total / 1000) % 60);
                                const minutes = Math.floor((total / 1000 / 60) % 60);
                                const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
                                this.timer = `${hours}:${minutes}:${seconds}`;
                            }
                         }" x-init="setInterval(() => update(), 1000)">
                        <span class="text-[10px] font-black text-rose-400 uppercase tracking-widest hidden sm:block">Waktu Tersisa</span>
                        <span class="text-3xl font-black italic tracking-[0.2em] font-mono text-white" x-text="timer">00:00:00</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 relative z-10">
                    @foreach($penjualanKilat->produkPenjualanKilat as $item)
                    <div class="group relative bg-slate-50 rounded-[3rem] p-6 border border-slate-100 hover:bg-white hover:shadow-2xl transition-all duration-500">
                        <div class="aspect-square rounded-[2.5rem] bg-white overflow-hidden mb-6 relative">
                            <img src="{{ asset($item->produk->gambar_utama) }}" class="w-full h-full object-contain p-6 group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-4 left-4 px-3 py-1 bg-rose-600 text-white text-[10px] font-black rounded-lg shadow-lg shadow-rose-500/40 italic">-{{ round((($item->produk->harga_jual - $item->harga_diskon) / $item->produk->harga_jual) * 100) }}%</div>
                        </div>
                        <h4 class="font-black text-slate-900 uppercase truncate px-2 italic tracking-tighter">{{ $item->produk->nama }}</h4>
                        <div class="mt-4 flex items-center justify-between px-2">
                            <div>
                                <p class="text-[10px] text-slate-400 line-through italic">Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }}</p>
                                <p class="text-xl font-black text-rose-600 italic">Rp {{ number_format($item->harga_diskon, 0, ',', '.') }}</p>
                            </div>
                            <button wire:click="addToCart({{ $item->produk->id }})" class="w-12 h-12 rounded-2xl bg-slate-950 text-white flex items-center justify-center hover:bg-rose-600 transition-all shadow-xl active:scale-90"><i class="fa-solid fa-plus text-lg"></i></button>
                        </div>
                        <div class="mt-6 px-2">
                            <div class="flex justify-between text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">
                                <span>Terjual {{ $item->terjual ?? 0 }}</span>
                                <span>Sisa {{ $item->kuota_stok - ($item->terjual ?? 0) }}</span>
                            </div>
                            <div class="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-rose-500 to-orange-400 rounded-full transition-all duration-1000" style="width: {{ (($item->terjual ?? 0) / $item->kuota_stok) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- KATALOG UNGGULAN: GRID MODERN -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end gap-8 mb-16">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-50 rounded-full border border-indigo-100">
                    <span class="text-[9px] font-black text-indigo-600 uppercase tracking-widest">Katalog Pilihan</span>
                </div>
                <h2 class="text-5xl font-black text-slate-900 uppercase tracking-tighter italic">Eksplorasi <span class="text-indigo-600">Teknologi</span></h2>
                <p class="text-slate-500 font-medium tracking-wide">Unit inventaris terbaik dengan standar kualitas enterprise global.</p>
            </div>
            <a href="/katalog" class="px-10 py-5 bg-slate-950 text-white rounded-3xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-2xl active:scale-95">Lihat Seluruh Koleksi</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            @foreach($produkUnggulan as $p)
            <div class="group bg-white rounded-[3.5rem] p-3 border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-700 relative hover:-translate-y-2">
                <div class="aspect-square rounded-[3rem] bg-slate-50 overflow-hidden relative mb-8">
                    <img src="{{ asset($p->gambar_utama) }}" class="w-full h-full object-contain p-8 group-hover:scale-110 transition-transform duration-1000">
                    <div class="absolute inset-0 bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                        <button wire:click="addToCart({{ $p->id }})" class="px-8 py-4 bg-white text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-2xl hover:scale-105 active:scale-95 transition-all">Tambah Ke Keranjang</button>
                    </div>
                    <div class="absolute top-8 left-8 px-4 py-1.5 bg-white/90 backdrop-blur-md rounded-full text-[9px] font-black text-slate-800 uppercase tracking-[0.2em] shadow-sm">{{ $p->kategori->nama }}</div>
                </div>

                <div class="px-6 pb-10 space-y-5">
                    <div>
                        <div class="flex items-center gap-1 text-amber-400 text-[10px] mb-2">
                            @for($i=1; $i<=5; $i++)
                                <i class="fa-solid fa-star {{ $i <= $p->ulasan_avg_rating ? '' : 'text-slate-200' }}"></i>
                            @endfor
                            <span class="text-slate-400 font-bold ml-2">({{ $p->ulasan_count }})</span>
                        </div>
                        <h3 class="font-black text-xl text-slate-900 leading-tight line-clamp-2 uppercase italic tracking-tighter group-hover:text-indigo-600 transition-colors">{{ $p->nama }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-2">{{ $p->kode_unit }}</p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                        <p class="text-2xl font-black text-slate-900 tracking-tighter italic">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</p>
                        @if($p->stok <= 5)
                            <div class="flex items-center gap-2 px-2 py-1 bg-rose-50 text-rose-600 rounded-lg text-[8px] font-black uppercase tracking-widest animate-pulse">
                                <span class="w-1 h-1 rounded-full bg-rose-600"></span> Sisa {{ $p->stok }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- NEWS & BLOG: ENTERPRISE INSIGHTS -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-16 border-b border-slate-100 pb-8">
            <h2 class="text-4xl font-black text-slate-900 uppercase tracking-tighter italic">Berita & <span class="text-indigo-600">Wawasan</span></h2>
            <a href="/berita" class="px-6 py-3 bg-indigo-50 text-indigo-600 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-indigo-600 hover:text-white transition-all">Semua Update</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            @foreach($beritaTerbaru as $b)
            <a href="/berita/{{ $b->slug }}" class="group space-y-8">
                <div class="aspect-video rounded-[3.5rem] bg-slate-100 overflow-hidden shadow-sm group-hover:shadow-2xl transition-all duration-700">
                    <img src="{{ asset($b->gambar_utama) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                </div>
                <div class="space-y-4 px-2">
                    <div class="flex items-center gap-4">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[8px] font-black uppercase tracking-widest">Enterprise</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $b->dibuat_pada->translatedFormat('d M Y') }}</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 group-hover:text-indigo-600 transition-colors leading-tight italic tracking-tighter">{{ $b->judul }}</h3>
                    <p class="text-sm text-slate-500 font-medium line-clamp-2 leading-relaxed italic opacity-80">"{{ $b->ringkasan }}"</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- FAQ SECTION: DINAMIS DARI CMS -->
    @if($faqData->count() > 0)
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-16 space-y-4">
            <h2 class="text-4xl font-black text-slate-900 uppercase tracking-tighter italic">Pertanyaan <span class="text-indigo-600">Populer</span></h2>
            <p class="text-slate-500 font-medium tracking-wide italic">Informasi teknis dan layanan bantuan cepat untuk Anda.</p>
        </div>
        
        <div class="space-y-6" x-data="{ aktif: null }">
            @foreach($faqData as $idx => $faq)
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden transition-all duration-500 hover:shadow-xl hover:border-indigo-100">
                <button @click="aktif = (aktif === {{ $idx }} ? null : {{ $idx }})" class="w-full px-10 py-8 flex items-center justify-between text-left group">
                    <div class="flex items-center gap-6">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shadow-inner transition-colors" 
                             :class="aktif === {{ $idx }} ? 'bg-indigo-600 text-white shadow-indigo-200' : 'bg-slate-50 text-slate-400'"
                             :style="aktif === {{ $idx }} ? 'color: #ffffff' : 'color: {{ $faq->metadata['warna_aksen'] ?? '#94a3b8' }}'">
                            <i class="{{ $faq->metadata['ikon'] ?? 'fa-solid fa-circle-question' }}"></i>
                        </div>
                        <span class="text-lg font-black text-slate-800 italic group-hover:text-indigo-600 transition-colors">{{ $faq->judul }}</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-slate-300 transition-transform duration-500" :class="aktif === {{ $idx }} ? 'rotate-180 text-indigo-600' : ''"></i>
                </button>
                <div x-show="aktif === {{ $idx }}" x-collapse>
                    <div class="px-10 pb-10 ml-16">
                        <div class="h-px bg-slate-50 w-full mb-6"></div>
                        <p class="text-slate-500 font-medium leading-relaxed italic opacity-90">{{ $faq->deskripsi }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- CTA FOOTER: CONVERSION CENTER -->
    @if($ctaFooter)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-[5rem] overflow-hidden p-16 md:p-24 shadow-2xl group" style="background-color: {{ $ctaFooter->metadata['warna_aksen'] ?? '#4f46e5' }}">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay"></div>
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-white opacity-10 rounded-full blur-[100px] group-hover:scale-150 transition-transform duration-1000"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-16">
                <div class="space-y-6 text-center md:text-left">
                    <h2 class="text-4xl md:text-6xl font-black text-white uppercase italic tracking-tighter leading-none">{{ $ctaFooter->judul }}</h2>
                    <p class="text-lg text-white/80 font-medium max-w-xl italic">"{{ $ctaFooter->deskripsi }}"</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ $ctaFooter->tautan_tujuan ?? '/katalog' }}" class="px-12 py-6 bg-white text-slate-900 rounded-3xl text-xs font-black uppercase tracking-[0.3em] shadow-2xl hover:scale-110 active:scale-95 transition-all">
                        {{ $ctaFooter->teks_tombol ?? 'MULAI SEKARANG' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
