<div class="bg-slate-50 min-h-screen pb-20 font-sans antialiased selection:bg-indigo-500 selection:text-white" x-data="{ mobileFilterOpen: false }">
    <!-- Navbar / Breadcrumb Sticky -->
    <div class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <nav class="flex items-center gap-2 text-[10px] md:text-xs font-bold text-slate-500 uppercase tracking-widest overflow-hidden">
                <a href="/" class="hover:text-indigo-600 transition-colors whitespace-nowrap">Beranda</a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-900 truncate max-w-[150px] md:max-w-xs">Katalog Toko</span>
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
        
        <!-- Promo Banners (Admin Managed) -->
        @if($this->bannerToko->count() > 0)
        <div class="mb-12 grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($this->bannerToko as $banner)
            <div class="relative rounded-[2.5rem] overflow-hidden aspect-[2/1] md:aspect-[5/2] group">
                <img src="{{ asset($banner->gambar) }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/20 to-transparent flex flex-col justify-center p-8 md:p-12">
                    <h2 class="text-2xl md:text-4xl font-black text-white uppercase tracking-tight mb-2 leading-tight max-w-md">{{ $banner->judul }}</h2>
                    <p class="text-slate-200 font-medium mb-6 max-w-sm line-clamp-2">{{ $banner->deskripsi }}</p>
                    @if($banner->tautan_tujuan)
                    <a href="{{ $banner->tautan_tujuan }}" class="self-start px-6 py-3 bg-white text-slate-900 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all">
                        {{ $banner->teks_tombol ?? 'Lihat Penawaran' }}
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="flex flex-col md:flex-row items-start justify-between gap-6 mb-10">
            <div>
                 <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase mb-2">Eksplorasi <span class="text-indigo-600">Teknologi</span></h1>
                 <p class="text-slate-500 text-sm font-medium">Menampilkan koleksi terbaik untuk kebutuhan digital Anda.</p>
            </div>

            <!-- Mobile Filter Toggle -->
            <button @click="mobileFilterOpen = !mobileFilterOpen" class="md:hidden w-full flex items-center justify-between px-6 py-4 bg-white border border-slate-200 rounded-2xl text-xs font-black uppercase tracking-widest shadow-sm">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    Filter & Urutkan
                </span>
                <svg class="w-4 h-4 transition-transform duration-300" :class="{'rotate-180': mobileFilterOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-10 items-start">
            
            <!-- Sidebar Filter (Desktop) -->
            <aside class="hidden lg:block w-72 shrink-0 space-y-8 sticky top-28">
                <!-- Search -->
                <div class="relative">
                    <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Model..." class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
                    <svg class="w-5 h-5 absolute left-4 top-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <!-- Sort -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                     <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-4">Urutkan</h3>
                     <select wire:model.live="urutkan" class="w-full bg-slate-50 border-transparent rounded-xl text-xs font-bold p-3 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="terbaru">Terbaru Diupdate</option>
                        <option value="termurah">Harga Terendah</option>
                        <option value="termahal">Harga Tertinggi</option>
                        <option value="rating">Rating Terbaik</option>
                    </select>
                </div>

                <!-- Categories -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Kategori</h3>
                        @if($filterKategori)
                            <button wire:click="$set('filterKategori', [])" class="text-[10px] font-bold text-rose-500 hover:text-rose-600">Reset</button>
                        @endif
                    </div>
                    <div class="space-y-3 max-h-60 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-slate-200">
                        @foreach($semuaKategori as $k)
                        <label class="flex items-center gap-3 cursor-pointer group select-none">
                            <div class="relative flex items-center">
                                <input type="checkbox" wire:model.live="filterKategori" value="{{ $k->slug }}" class="peer appearance-none w-5 h-5 border-2 border-slate-200 rounded-lg checked:bg-indigo-600 checked:border-indigo-600 transition-all">
                                <svg class="w-3 h-3 text-white absolute top-1 left-1 opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm font-bold text-slate-600 group-hover:text-indigo-600 transition-colors">{{ $k->nama }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                 <!-- Brands -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Merek</h3>
                        @if($filterMerek)
                            <button wire:click="$set('filterMerek', [])" class="text-[10px] font-bold text-rose-500 hover:text-rose-600">Reset</button>
                        @endif
                    </div>
                    <div class="space-y-3 max-h-60 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-slate-200">
                        @foreach($semuaMerek as $m)
                        <label class="flex items-center gap-3 cursor-pointer group select-none">
                             <div class="relative flex items-center">
                                <input type="checkbox" wire:model.live="filterMerek" value="{{ $m->slug }}" class="peer appearance-none w-5 h-5 border-2 border-slate-200 rounded-lg checked:bg-indigo-600 checked:border-indigo-600 transition-all">
                                <svg class="w-3 h-3 text-white absolute top-1 left-1 opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm font-bold text-slate-600 group-hover:text-indigo-600 transition-colors">{{ $m->nama }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Dynamic Specs Filter -->
                @foreach($this->opsiSpesifikasi as $judul => $nilaiOpsi)
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm" x-data="{ expanded: false }">
                    <button @click="expanded = !expanded" class="flex items-center justify-between w-full mb-2">
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">{{ $judul }}</h3>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform" :class="expanded ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="expanded" x-collapse class="space-y-3 pt-2 max-h-40 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-slate-200">
                        @foreach($nilaiOpsi as $nilai)
                        <label class="flex items-center gap-3 cursor-pointer group select-none">
                            <div class="relative flex items-center">
                                <input type="checkbox" wire:model.live="filterSpesifikasi.{{ $judul }}" value="{{ $nilai }}" class="peer appearance-none w-5 h-5 border-2 border-slate-200 rounded-lg checked:bg-indigo-600 checked:border-indigo-600 transition-all">
                                <svg class="w-3 h-3 text-white absolute top-1 left-1 opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm font-bold text-slate-600 group-hover:text-indigo-600 transition-colors">{{ $nilai }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <!-- Price Range -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-4">Rentang Harga</h3>
                    <div class="space-y-3">
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-xs font-black text-slate-400">Rp</span>
                            <input wire:model.live.debounce.1000ms="hargaMin" type="number" placeholder="Min" class="w-full rounded-xl border-slate-200 text-sm font-bold pl-10 pr-4 py-2 focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-xs font-black text-slate-400">Rp</span>
                            <input wire:model.live.debounce.1000ms="hargaMax" type="number" placeholder="Max" class="w-full rounded-xl border-slate-200 text-sm font-bold pl-10 pr-4 py-2 focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Mobile Filter (Inline Accordion) -->
            <div x-show="mobileFilterOpen" class="lg:hidden w-full bg-white rounded-[2rem] border border-slate-100 shadow-xl p-6 mb-8" x-transition>
                 <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <!-- Search Mobile -->
                    <div class="relative col-span-full">
                        <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Model..." class="w-full pl-12 pr-4 py-3 bg-slate-50 border-transparent rounded-2xl text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5 absolute left-4 top-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    <!-- Categories Mobile -->
                    <div>
                         <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-3">Kategori</h3>
                         <div class="space-y-2 max-h-40 overflow-y-auto">
                            @foreach($semuaKategori as $k)
                            <label class="flex items-center gap-3">
                                <input type="checkbox" wire:model.live="filterKategori" value="{{ $k->slug }}" class="rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 w-5 h-5">
                                <span class="text-sm font-bold text-slate-600">{{ $k->nama }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sort Mobile -->
                    <div>
                         <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-3">Urutkan</h3>
                         <select wire:model.live="urutkan" class="w-full bg-slate-50 border-transparent rounded-xl text-xs font-bold p-3">
                            <option value="terbaru">Terbaru</option>
                            <option value="termurah">Termurah</option>
                            <option value="termahal">Termahal</option>
                        </select>
                    </div>
                </div>
                
                <button @click="mobileFilterOpen = false" class="w-full mt-6 py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em]">Terapkan Filter</button>
            </div>

            <!-- Product Grid -->
            <div class="flex-1 w-full">
                @if($produk->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    @foreach($produk as $p)
                    <a href="{{ route('produk.detail', $p->slug) }}" class="group bg-white rounded-[2.5rem] p-4 border border-slate-100 hover:shadow-2xl hover:shadow-indigo-500/10 hover:border-indigo-100 transition-all duration-500 flex flex-col h-full transform hover:-translate-y-1">
                        <!-- Image -->
                        <div class="relative bg-slate-50 rounded-[2rem] aspect-[4/3] overflow-hidden mb-5 flex items-center justify-center p-8 group-hover:bg-indigo-50/30 transition-colors">
                            @if($p->stok <= 0)
                                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px] z-10 flex items-center justify-center">
                                    <span class="px-4 py-2 bg-white text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg transform -rotate-12">Stok Habis</span>
                                </div>
                            @elseif($p->stok <= 5)
                                <span class="absolute top-4 left-4 px-3 py-1 bg-amber-500 text-white text-[9px] font-black uppercase tracking-widest rounded-lg z-10 shadow-lg shadow-amber-500/20">Stok Menipis</span>
                            @elseif($p->dibuat_pada && $p->dibuat_pada->diffInDays(now()) < 30)
                                <span class="absolute top-4 left-4 px-3 py-1 bg-indigo-600 text-white text-[9px] font-black uppercase tracking-widest rounded-lg z-10 shadow-lg shadow-indigo-600/20">Baru</span>
                            @endif
                            
                            <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700 mix-blend-multiply filter grayscale-[10%] group-hover:grayscale-0">
                            
                            <!-- Action Overlay -->
                            <div class="absolute bottom-4 right-4 translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-indigo-600 shadow-xl shadow-indigo-900/10 hover:bg-indigo-600 hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="px-2 pb-2 flex-1 flex flex-col">
                            <div class="mb-4">
                                <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-2 flex items-center gap-1">
                                    {{ $p->kategori->nama }}
                                </p>
                                <h3 class="font-bold text-slate-900 text-base leading-snug mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $p->nama }}</h3>
                            </div>
                            
                            <div class="mt-auto pt-4 border-t border-slate-50 flex items-end justify-between">
                                <div>
                                    @if($p->rating_rata_rata > 0)
                                    <div class="flex items-center gap-1 mb-1">
                                        <svg class="w-3 h-3 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <span class="text-[10px] font-bold text-slate-400">{{ number_format($p->rating_rata_rata, 1) }}</span>
                                    </div>
                                    @endif
                                    <p class="text-lg font-black text-slate-900 tracking-tight">{{ $p->harga_rupiah }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                
                <div class="mt-16">
                    {{ $produk->links() }}
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-40 text-center bg-white rounded-[2.5rem] border border-slate-100 border-dashed">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6 animate-pulse">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-2 tracking-tight">Tidak Ditemukan</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-8 font-medium">Maaf, kami tidak dapat menemukan produk yang sesuai dengan filter pencarian Anda.</p>
                    <button wire:click="resetFilter" class="px-8 py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl hover:shadow-indigo-500/30">
                        Reset Pencarian
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
