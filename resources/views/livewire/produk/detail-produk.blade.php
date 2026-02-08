<div class="bg-slate-50 min-h-screen pb-24 font-sans antialiased" x-data="{ tab: 'deskripsi' }">
    
    <!-- Breadcrumb & Nav -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <nav class="flex items-center gap-2 text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em] overflow-hidden">
                <a href="/" class="hover:text-indigo-600 transition-colors whitespace-nowrap">Beranda</a>
                <span class="text-slate-300">/</span>
                <a href="/katalog" class="hover:text-indigo-600 transition-colors whitespace-nowrap">Katalog</a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-900 truncate italic">#{{ $produk->kode_unit }}</span>
            </nav>
            
            <div class="flex items-center gap-4">
                <button wire:click="toggleWishlist" class="flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 text-[10px] font-black uppercase tracking-widest transition-all hover:bg-slate-50 {{ $isInWishlist ? 'bg-rose-50 text-rose-600 border-rose-100' : 'bg-white text-slate-500' }}">
                    <i class="fa-{{ $isInWishlist ? 'solid' : 'regular' }} fa-heart"></i>
                    <span class="hidden sm:inline">Simpan Ke Wishlist</span>
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-start">
            
            <!-- LEFT: VISUAL SHOWCASE -->
            <div class="lg:col-span-7 space-y-8 sticky top-28">
                <!-- Main Visual -->
                <div class="relative bg-white rounded-[4rem] aspect-square overflow-hidden shadow-2xl shadow-slate-200 p-12 border border-slate-100 group">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-fuchsia-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                    <img src="{{ $gambarAktif }}" class="w-full h-full object-contain mix-blend-multiply drop-shadow-2xl transition-transform duration-700 group-hover:scale-105">
                    
                    @if($stokAktif <= 5 && $stokAktif > 0)
                        <div class="absolute top-10 left-10 flex items-center gap-3 px-4 py-2 bg-rose-600 text-white rounded-2xl shadow-xl shadow-rose-500/40 animate-bounce">
                            <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest italic">Sisa {{ $stokAktif }} Unit!</span>
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Reel -->
                <div class="grid grid-cols-5 gap-4">
                    @foreach($produk->gambar as $img)
                    <button wire:click="gantiGambar('{{ $img->url }}')" class="aspect-square rounded-2xl bg-white p-2 border-2 transition-all {{ $gambarAktif == $img->url ? 'border-indigo-600 shadow-lg shadow-indigo-500/20' : 'border-slate-100 hover:border-indigo-200' }}">
                        <img src="{{ $img->url }}" class="w-full h-full object-contain mix-blend-multiply">
                    </button>
                    @endforeach
                </div>

                <!-- BUNDLING INTEGRATION -->
                @if($produk->tipe_produk == 'bundle' && $produk->bundlingItems->count() > 0)
                <div class="bg-gradient-to-r from-slate-900 to-indigo-900 rounded-[3rem] p-10 text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/20 rounded-full blur-[100px]"></div>
                    <div class="relative z-10 space-y-8">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-black uppercase tracking-widest italic">Bundling <span class="text-indigo-400">Enterprise</span></h3>
                            <span class="px-3 py-1 bg-white/10 rounded-lg text-[9px] font-bold">PAKET HEMAT</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($produk->bundlingItems as $bund)
                            <div class="flex items-center gap-4 bg-white/5 p-4 rounded-3xl border border-white/10">
                                <div class="w-12 h-12 rounded-xl bg-white p-1 overflow-hidden shrink-0">
                                    <img src="{{ $bund->child->gambar_utama_url }}" class="w-full h-full object-contain">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-black truncate uppercase italic">{{ $bund->child->nama }}</p>
                                    <p class="text-[9px] text-indigo-300 font-bold uppercase tracking-widest">{{ $bund->jumlah }} Unit</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- RIGHT: PURCHASE COMMAND PANEL -->
            <div class="lg:col-span-5 space-y-10">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[9px] font-black uppercase tracking-widest border border-indigo-100">{{ $produk->kategori->nama }}</span>
                        <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[9px] font-black uppercase tracking-widest border border-slate-200 italic">{{ $produk->merek->nama }}</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black text-slate-900 leading-none tracking-tighter uppercase italic">{{ $produk->nama }}</h1>
                    <div class="flex items-center gap-4 pt-2">
                        <div class="flex items-center gap-1 text-amber-400 text-sm">
                            @for($i=1; $i<=5; $i++)
                                <i class="fa-solid fa-star {{ $i <= $produk->ulasan_avg_rating ? '' : 'text-slate-200' }}"></i>
                            @endfor
                        </div>
                        <span class="text-sm font-bold text-slate-400 italic">({{ $produk->ulasan_count }} Review Terverifikasi)</span>
                    </div>
                </div>

                <div class="bg-white rounded-[3.5rem] p-10 border border-slate-100 shadow-xl shadow-slate-200/50 space-y-10">
                    <!-- Price Panel -->
                    <div class="flex items-end justify-between">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Investasi Aset</p>
                            <h2 class="text-4xl font-black text-indigo-600 tracking-tighter italic">Rp {{ number_format($hargaAktif, 0, ',', '.') }}</h2>
                        </div>
                        <div class="text-right">
                            <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Inventaris</span>
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                                {{ $stokAktif > 0 ? 'Ready Unit' : 'Out of Stock' }}
                            </span>
                        </div>
                    </div>

                    <!-- Varian Selector -->
                    @if($produk->memiliki_varian && $produk->varian->count() > 0)
                    <div class="space-y-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pilih Konfigurasi Unit</p>
                        <div class="flex flex-wrap gap-3">
                            @foreach($produk->varian as $v)
                            <button wire:click="pilihVarian({{ $v->id }})" class="px-6 py-3 rounded-2xl border-2 transition-all text-xs font-black uppercase tracking-widest {{ $varianTerpilihId == $v->id ? 'bg-indigo-600 border-indigo-600 text-white shadow-xl shadow-indigo-500/20 scale-105' : 'bg-slate-50 border-slate-100 text-slate-500 hover:border-indigo-200' }}">
                                {{ $v->nama_varian }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Quantity Control -->
                    <div class="flex items-center gap-8">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Jumlah Order</p>
                        <div class="flex items-center bg-slate-100 rounded-2xl p-1 shrink-0">
                            <button wire:click="kurangJumlah" class="w-12 h-12 flex items-center justify-center text-slate-500 hover:text-rose-600 transition-colors"><i class="fa-solid fa-minus"></i></button>
                            <span class="w-12 text-center font-black text-lg text-slate-900">{{ $jumlah }}</span>
                            <button wire:click="tambahJumlah" class="w-12 h-12 flex items-center justify-center text-slate-500 hover:text-emerald-600 transition-colors"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </div>

                    <!-- Purchase Actions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <button wire:click="tambahKeKeranjang" class="py-6 bg-slate-950 text-white rounded-[2rem] text-[10px] font-black uppercase tracking-[0.3em] hover:bg-indigo-600 transition-all shadow-2xl active:scale-95">
                            <i class="fa-solid fa-cart-plus mr-3"></i> Tambah Keranjang
                        </button>
                        <button wire:click="beliSekarang" class="py-6 bg-indigo-600 text-white rounded-[2rem] text-[10px] font-black uppercase tracking-[0.3em] hover:bg-slate-900 transition-all shadow-2xl shadow-indigo-500/30 active:scale-95">
                            Beli Sekarang <i class="fa-solid fa-bolt-lightning ml-3"></i>
                        </button>
                    </div>
                </div>

                <!-- LOGISTICS & ESTIMATE -->
                <div class="bg-white rounded-[3rem] p-8 border border-slate-100 shadow-sm space-y-6">
                    <div class="flex items-center gap-4 border-b border-slate-50 pb-4">
                        <i class="fa-solid fa-truck-fast text-indigo-500 text-xl"></i>
                        <h4 class="text-xs font-black uppercase tracking-widest text-slate-900">Estimasi Pengiriman Enterprise</h4>
                    </div>
                    @if($estimasiOngkir)
                        <div class="space-y-4">
                            @foreach($estimasiOngkir as $opsi)
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-slate-600">{{ $opsi['layanan'] }} ({{ $opsi['kurir'] }})</span>
                                <span class="font-black text-indigo-600 italic">Rp {{ number_format($opsi['biaya'], 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-[10px] font-bold text-slate-400 italic text-center leading-relaxed">Hubungkan alamat utama di profil Anda untuk mendapatkan estimasi ongkir real-time.</p>
                    @endif
                </div>
            </div>

        </div>

        <!-- BOTTOM AREA: SPECS & REVIEWS -->
        <div class="mt-24 space-y-12">
            <div class="flex justify-center p-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm max-w-2xl mx-auto overflow-hidden">
                <button @click="tab = 'deskripsi'" :class="tab === 'deskripsi' ? 'bg-slate-950 text-white shadow-xl' : 'text-slate-400'" class="flex-1 py-4 rounded-[2rem] text-[10px] font-black uppercase tracking-widest transition-all">Deskripsi Naratif</button>
                <button @click="tab = 'spek'" :class="tab === 'spek' ? 'bg-slate-950 text-white shadow-xl' : 'text-slate-400'" class="flex-1 py-4 rounded-[2rem] text-[10px] font-black uppercase tracking-widest transition-all">Spesifikasi Teknis</button>
                <button @click="tab = 'ulasan'" :class="tab === 'ulasan' ? 'bg-slate-950 text-white shadow-xl' : 'text-slate-400'" class="flex-1 py-4 rounded-[2rem] text-[10px] font-black uppercase tracking-widest transition-all">Review Hub</button>
            </div>

            <div class="bg-white rounded-[4rem] p-10 md:p-20 shadow-sm border border-slate-100">
                <!-- Deskripsi Tab -->
                <div x-show="tab === 'deskripsi'" class="animate-in fade-in duration-500">
                    <div class="prose prose-slate max-w-none prose-p:text-slate-500 prose-p:italic prose-p:leading-loose prose-h3:font-black prose-h3:uppercase prose-h3:tracking-tighter prose-h3:text-slate-900">
                        {!! $produk->deskripsi_lengkap !!}
                    </div>
                </div>

                <!-- Spesifikasi Tab -->
                <div x-show="tab === 'spek'" class="animate-in fade-in duration-500">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($produk->spesifikasi as $s)
                        <div class="flex justify-between items-center py-4 border-b border-slate-50">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $s->label }}</span>
                            <span class="text-sm font-bold text-slate-800 italic">{{ $s->nilai }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Review Tab -->
                <div x-show="tab === 'ulasan'" class="animate-in fade-in duration-500 space-y-12">
                    <div class="flex flex-col md:flex-row gap-12">
                        <div class="md:w-1/3 bg-slate-50 p-10 rounded-[3rem] text-center space-y-4">
                            <h4 class="text-6xl font-black text-indigo-600 italic tracking-tighter">{{ number_format($produk->ulasan_avg_rating, 1) }}</h4>
                            <div class="flex justify-center gap-1 text-amber-400">
                                @for($i=1; $i<=5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $produk->ulasan_avg_rating ? '' : 'text-slate-200' }}"></i>
                                @endfor
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Rating Rata-rata</p>
                        </div>
                        <div class="flex-1 space-y-4">
                            @foreach($this->statistikRating as $bintang => $data)
                            <div class="flex items-center gap-6">
                                <span class="text-[10px] font-black text-slate-400 w-12">{{ $bintang }} BINTANG</span>
                                <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-600" style="width: {{ $data['persen'] }}%"></div>
                                </div>
                                <span class="text-[10px] font-bold text-slate-500 w-12">{{ $data['jumlah'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>