<div class="bg-slate-50 min-h-screen pb-20 font-sans antialiased selection:bg-indigo-500 selection:text-white">
    <!-- Navbar / Breadcrumb Sticky -->
    <div class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <nav class="flex items-center gap-2 text-[10px] md:text-xs font-bold text-slate-500 uppercase tracking-widest overflow-hidden">
                <a href="/" class="hover:text-indigo-600 transition-colors whitespace-nowrap">Beranda</a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('katalog') }}" class="hover:text-indigo-600 transition-colors whitespace-nowrap">Katalog</a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('katalog', ['kategori' => $produk->kategori->slug]) }}" class="hover:text-indigo-600 transition-colors whitespace-nowrap hidden sm:block">{{ $produk->kategori->nama }}</a>
                <span class="text-slate-300 hidden sm:block">/</span>
                <span class="text-slate-900 truncate max-w-[150px] md:max-w-xs">{{ $produk->nama }}</span>
            </nav>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('keranjang') }}" class="relative group p-2 rounded-full hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5 text-slate-600 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <livewire:komponen.badge-keranjang /> 
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <div class="lg:grid lg:grid-cols-12 lg:gap-12 lg:items-start">
            
            <!-- Left Column: Gallery (7 Cols) -->
            <div class="lg:col-span-7 flex flex-col gap-6">
                <!-- Main Image Stage -->
                <div class="relative bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 aspect-[4/3] md:aspect-square lg:aspect-[4/3] overflow-hidden group">
                    <!-- Badges -->
                    <div class="absolute top-6 left-6 z-10 flex flex-col gap-3 items-start">
                         @if($stokAktif <= 0)
                            <span class="px-4 py-2 bg-rose-500 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl shadow-lg shadow-rose-500/20 backdrop-blur-sm">Stok Habis</span>
                        @elseif($produk->dibuat_pada && $produk->dibuat_pada->diffInDays(now()) < 30)
                            <span class="px-4 py-2 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl shadow-lg shadow-indigo-600/20 backdrop-blur-sm">Produk Baru</span>
                        @endif
                        @if($produk->merek)
                             <span class="px-4 py-2 bg-white/90 backdrop-blur text-slate-900 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl border border-slate-200 shadow-sm">{{ $produk->merek->nama }}</span>
                        @endif
                    </div>

                    <!-- Image Display -->
                    <div class="w-full h-full flex items-center justify-center p-8 md:p-12 transition-all duration-700 ease-in-out bg-gradient-to-br from-slate-50 via-white to-indigo-50/20">
                        <img src="{{ asset('storage/'.$gambarAktif) }}" class="w-full h-full object-contain drop-shadow-2xl transition-transform duration-500 group-hover:scale-105" alt="{{ $produk->nama }}">
                    </div>

                    <!-- Zoom Trigger (Visual Only) -->
                    <div class="absolute bottom-6 right-6 p-3 bg-white/80 backdrop-blur rounded-full text-slate-400 border border-white shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                    </div>
                </div>

                <!-- Thumbnails Grid -->
                <div class="grid grid-cols-5 gap-4">
                    @foreach($produk->gambar as $img)
                    <button wire:click="gantiGambar('{{ $img->url }}')" class="relative aspect-square bg-white rounded-2xl flex items-center justify-center cursor-pointer hover:bg-slate-50 focus:outline-none ring-offset-2 transition-all duration-300 {{ $gambarAktif == $img->url ? 'ring-2 ring-indigo-600 shadow-lg scale-95' : 'border border-slate-100 hover:border-indigo-200 opacity-70 hover:opacity-100' }}">
                        <img src="{{ asset('storage/'.$img->url) }}" class="w-full h-full object-contain p-2">
                    </button>
                    @endforeach
                </div>
                
                <!-- Desktop Description Tabs -->
                <div class="hidden lg:block bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8 mt-4" x-data="{ tab: 'deskripsi' }">
                    <div class="flex items-center gap-8 border-b border-slate-100 mb-8 overflow-x-auto">
                        <button @click="tab = 'deskripsi'" :class="{ 'text-indigo-600 border-indigo-600': tab === 'deskripsi', 'text-slate-400 border-transparent hover:text-slate-600': tab !== 'deskripsi' }" class="pb-4 border-b-2 text-xs font-black uppercase tracking-widest transition-all">Tentang Produk</button>
                        <button @click="tab = 'spesifikasi'" :class="{ 'text-indigo-600 border-indigo-600': tab === 'spesifikasi', 'text-slate-400 border-transparent hover:text-slate-600': tab !== 'spesifikasi' }" class="pb-4 border-b-2 text-xs font-black uppercase tracking-widest transition-all">Spesifikasi</button>
                        <button @click="tab = 'ulasan'" :class="{ 'text-indigo-600 border-indigo-600': tab === 'ulasan', 'text-slate-400 border-transparent hover:text-slate-600': tab !== 'ulasan' }" class="pb-4 border-b-2 text-xs font-black uppercase tracking-widest transition-all">Ulasan Pembeli</button>
                    </div>

                    <!-- Tab Content -->
                    <div x-show="tab === 'deskripsi'" class="prose prose-slate prose-sm max-w-none text-slate-600 leading-relaxed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        {!! $produk->deskripsi_lengkap !!}
                    </div>

                    <div x-show="tab === 'spesifikasi'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                            @foreach($produk->spesifikasi as $spec)
                            <div class="flex flex-col border-b border-slate-50 pb-2">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">{{ $spec->judul }}</span>
                                <span class="text-sm font-bold text-slate-800">{{ $spec->nilai }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                     <div x-show="tab === 'ulasan'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <!-- Review Stats -->
                        <div class="flex items-center gap-8 mb-10 bg-indigo-50/50 p-6 rounded-3xl border border-indigo-100">
                             <div class="text-center">
                                <div class="text-5xl font-black text-indigo-600 tracking-tighter">{{ number_format($produk->rating_rata_rata, 1) }}</div>
                                <div class="flex text-amber-400 text-sm justify-center mt-1">
                                    @for($i=0;$i<5;$i++) <span>★</span> @endfor
                                </div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase mt-1">{{ $produk->ulasan->count() }} Ulasan</div>
                            </div>
                            <div class="flex-1 space-y-2">
                                @foreach($this->statistikRating as $bintang => $data)
                                <div class="flex items-center gap-3">
                                    <span class="text-[10px] font-bold text-slate-400 w-3">{{ $bintang }}</span>
                                    <div class="flex-1 h-2 bg-white rounded-full overflow-hidden border border-indigo-100">
                                        <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $data['persen'] }}%"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Review List -->
                        <div class="space-y-8">
                             @forelse($produk->ulasan as $ulasan)
                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs shadow-lg shadow-indigo-500/20">
                                    {{ substr($ulasan->pengguna->nama ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">{{ $ulasan->pengguna->nama ?? 'Pengguna' }}</h4>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="flex text-amber-400 text-xs">
                                             @for($i=0; $i<5; $i++) <span>{{ $i < $ulasan->rating ? '★' : '☆' }}</span> @endfor
                                        </div>
                                        <span class="text-[10px] text-slate-400 font-medium">{{ $ulasan->dibuat_pada->format('d M Y') }}</span>
                                    </div>
                                    <p class="text-sm text-slate-600">{{ $ulasan->komentar }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-slate-400 py-4 italic">Belum ada ulasan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Info & Actions (Sticky) (5 Cols) -->
            <div class="lg:col-span-5 mt-10 lg:mt-0 sticky top-24">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 p-6 md:p-8 lg:p-10 relative overflow-hidden">
                    <!-- Background Decoration -->
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

                    <!-- Header -->
                    <div class="relative z-10">
                        <p class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-3 flex items-center gap-2">
                            <span class="w-2 h-2 bg-indigo-600 rounded-full animate-pulse"></span>
                            {{ $produk->kategori->nama }}
                        </p>
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-900 leading-tight mb-4 tracking-tight">{{ $produk->nama }}</h1>
                        
                        <!-- Rating Summary -->
                         <div class="flex items-center gap-4 mb-8">
                            <div class="flex items-center bg-amber-50 px-3 py-1 rounded-lg gap-1 border border-amber-100">
                                <svg class="w-4 h-4 text-amber-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span class="text-xs font-bold text-amber-700">{{ number_format($produk->rating_rata_rata, 1) }}</span>
                            </div>
                            <span class="text-xs font-medium text-slate-400">Terjual 1.2k+</span>
                        </div>

                        <!-- Price -->
                        <div class="mb-8">
                            <div class="flex items-baseline gap-2">
                                <span class="text-sm font-bold text-slate-400">Rp</span>
                                <span class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tighter">{{ number_format($hargaAktif, 0, ',', '.') }}</span>
                            </div>
                             <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Jaminan Harga Terbaik
                            </p>
                        </div>
                    </div>

                    <div class="w-full h-px bg-slate-100 my-8"></div>

                    <!-- Wholesale Pricing (Enterprise) -->
                    @if(count($produk->harga_grosir ?? []) > 0)
                    <div class="bg-indigo-50/50 rounded-2xl p-4 border border-indigo-100 mb-8">
                        <h3 class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-3">Harga Grosir (Enterprise)</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs text-left">
                                <thead class="text-[10px] font-black text-indigo-400 uppercase tracking-wider border-b border-indigo-100">
                                    <tr>
                                        <th class="pb-2">Jumlah Beli</th>
                                        <th class="pb-2 text-right">Harga Satuan</th>
                                    </tr>
                                </thead>
                                <tbody class="text-slate-600 font-bold">
                                    @foreach($produk->harga_grosir as $grosir)
                                    <tr class="group hover:bg-indigo-100/50 transition-colors">
                                        <td class="py-2 pl-2 border-b border-indigo-50 group-last:border-0">Min. {{ $grosir['min_qty'] }}</td>
                                        <td class="py-2 pr-2 text-right border-b border-indigo-50 group-last:border-0 text-indigo-700">Rp {{ number_format($grosir['harga'], 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Configurator -->
                    <div class="space-y-6 relative z-10">
                        <!-- Variants -->
                        @if($produk->memiliki_varian && $produk->varian->count() > 0)
                        <div>
                            <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-widest mb-3">Pilih Varian</h3>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($produk->varian as $varian)
                                <button wire:click="pilihVarian({{ $varian->id }})" class="relative group px-4 py-3 rounded-2xl border-2 text-left transition-all duration-200 {{ $varianTerpilihId == $varian->id ? 'border-indigo-600 bg-indigo-50 shadow-md shadow-indigo-100' : 'border-slate-100 bg-slate-50 hover:border-indigo-200 hover:bg-white' }}">
                                    <span class="block text-xs font-bold text-slate-900 uppercase mb-1">{{ $varian->nama_varian }}</span>
                                    <span class="block text-[10px] text-slate-500 font-bold group-hover:text-indigo-600 transition-colors">
                                        + Rp {{ number_format($varian->harga_tambahan, 0, ',', '.') }}
                                    </span>
                                    @if($varianTerpilihId == $varian->id)
                                        <div class="absolute top-3 right-3 w-2 h-2 rounded-full bg-indigo-600 shadow-lg shadow-indigo-500/50"></div>
                                    @endif
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Quantity -->
                         <div>
                            <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-widest mb-3">Jumlah</h3>
                            <div class="flex items-center justify-between bg-slate-50 rounded-2xl border border-slate-200 p-1">
                                <button wire:click="kurangJumlah" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white shadow-sm hover:text-indigo-600 hover:shadow-md transition-all disabled:opacity-50 text-slate-600" {{ $jumlah <= 1 ? 'disabled' : '' }}>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                </button>
                                <input type="number" wire:model="jumlah" class="w-16 text-center border-none bg-transparent p-0 text-slate-900 font-black text-lg focus:ring-0" readonly>
                                <button wire:click="tambahJumlah" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white shadow-sm hover:text-indigo-600 hover:shadow-md transition-all disabled:opacity-50 text-slate-600" {{ $jumlah >= $stokAktif ? 'disabled' : '' }}>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                            <p class="text-[10px] text-slate-400 font-bold text-right mt-2 uppercase tracking-wide">
                                Stok: <span class="{{ $stokAktif < 5 ? 'text-rose-500' : 'text-slate-600' }}">{{ $stokAktif }} Unit</span>
                            </p>
                            <!-- Warehouse Availability (Enterprise) -->
                            @if($produk->stokGudang->count() > 0)
                            <div class="mt-4 pt-4 border-t border-slate-100">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Lokasi Ketersediaan</p>
                                <div class="space-y-1">
                                    @foreach($produk->stokGudang as $stok)
                                    <div class="flex justify-between text-xs">
                                        <span class="text-slate-600 font-medium">{{ $stok->gudang->nama }}</span>
                                        <span class="font-bold text-slate-900">{{ $stok->jumlah }} Unit</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Shipping Estimator (Enterprise) -->
                    @if(count($this->estimasiOngkir) > 0)
                    <div class="mt-8 p-6 bg-slate-50 rounded-3xl border border-slate-200">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-truck-ramp-box text-indigo-600"></i>
                            <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Estimasi Pengiriman Ke Anda</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach(array_slice($this->estimasiOngkir, 0, 2) as $ongkir)
                            <div class="flex justify-between items-center bg-white p-3 rounded-xl shadow-sm border border-slate-100">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-900 uppercase">{{ $ongkir['nama'] }}</span>
                                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">Estimasi: {{ $ongkir['estimasi'] }} Hari</span>
                                </div>
                                <span class="text-xs font-black text-indigo-600">Rp{{ number_format($ongkir['nominal'], 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col gap-3 relative z-10">
                        <div class="flex gap-3">
                            <button wire:click="tambahKeKeranjang" wire:loading.attr="disabled" class="flex-1 py-5 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-600 hover:shadow-xl hover:shadow-indigo-500/30 transition-all active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-3 group">
                                 <svg wire:loading.remove class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                 <svg wire:loading class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                 <span>{{ $stokAktif < 1 ? 'Stok Habis' : 'Keranjang' }}</span>
                            </button>
                            <button wire:click="toggleWishlist" class="w-14 bg-white border-2 border-slate-100 rounded-2xl flex items-center justify-center text-rose-500 hover:bg-rose-50 hover:border-rose-200 transition-all active:scale-90 shadow-sm">
                                <svg class="w-6 h-6 {{ $isInWishlist ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>
                            <button wire:click="tambahBandingkan" class="w-14 bg-white border-2 border-slate-100 rounded-2xl flex items-center justify-center text-indigo-500 hover:bg-indigo-50 hover:border-indigo-200 transition-all active:scale-90 shadow-sm" title="Bandingkan">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                            </button>
                        </div>
                        
                        <button wire:click="beliSekarang" class="w-full py-4 bg-white border-2 border-slate-100 text-slate-900 rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:border-slate-900 hover:bg-slate-50 transition-all active:scale-[0.98] disabled:opacity-50">
                            Beli Langsung
                        </button>
                    </div>
                    
                    <!-- Safety Info -->
                    <div class="mt-8 pt-8 border-t border-slate-100 grid grid-cols-2 gap-4">
                        <div class="flex items-center gap-3">
                             <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             </div>
                             <div>
                                 <h4 class="text-[10px] font-black text-slate-900 uppercase">Garansi Resmi</h4>
                                 <p class="text-[10px] text-slate-500">12 Bulan Perlindungan</p>
                             </div>
                        </div>
                        <div class="flex items-center gap-3">
                             <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                             </div>
                             <div>
                                 <h4 class="text-[10px] font-black text-slate-900 uppercase">Kirim Cepat</h4>
                                 <p class="text-[10px] text-slate-500">Estimasi 2-3 Hari</p>
                             </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Mobile Content Tabs (Description etc) - Shown below on mobile -->
        <div class="lg:hidden mt-12 space-y-8">
            <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
                <h3 class="font-black text-slate-900 text-lg mb-4">Deskripsi</h3>
                <div class="prose prose-slate prose-sm max-w-none text-slate-600">
                    {!! $produk->deskripsi_lengkap !!}
                </div>
            </div>
            
             <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
                <h3 class="font-black text-slate-900 text-lg mb-4">Spesifikasi</h3>
                 <div class="space-y-4">
                    @foreach($produk->spesifikasi as $spec)
                    <div class="flex justify-between border-b border-slate-50 pb-2">
                        <span class="text-xs font-bold text-slate-500">{{ $spec->judul }}</span>
                        <span class="text-xs font-bold text-slate-900">{{ $spec->nilai }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-20 md:mt-32">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Mungkin Anda Suka</h2>
                    <p class="text-sm text-slate-500 font-medium mt-1">Pilihan alternatif dengan spesifikasi serupa.</p>
                </div>
                <a href="{{ route('katalog', ['kategori' => $produk->kategori->slug]) }}" class="hidden md:flex items-center gap-2 text-xs font-black uppercase tracking-widest text-indigo-600 hover:text-indigo-700 transition-colors">
                    Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                @foreach($this->produkTerkait as $rel)
                <a href="{{ route('produk.detail', $rel->slug) }}" class="group bg-white rounded-[2rem] border border-slate-100 hover:border-indigo-100 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-300 p-4 flex flex-col">
                    <div class="aspect-square bg-slate-50 rounded-[1.5rem] mb-4 overflow-hidden p-6 flex items-center justify-center">
                        <img src="{{ $rel->gambar_utama_url }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500 mix-blend-multiply">
                    </div>
                    <div class="mt-auto">
                        <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-1">{{ $rel->kategori->nama }}</p>
                        <h3 class="font-bold text-slate-900 text-sm leading-tight mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $rel->nama }}</h3>
                        <p class="text-base font-black text-slate-900">{{ $rel->harga_rupiah }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
