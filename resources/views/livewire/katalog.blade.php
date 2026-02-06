<div class="bg-slate-50 min-h-screen py-12" x-data="{ filterOpen: false }">
    <div class="container mx-auto px-6">
        
        <!-- Header Katalog -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
            <div>
                <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 gap-2">
                    <a href="/" class="hover:text-indigo-600 transition-colors">Beranda</a>
                    <span>/</span>
                    <span class="text-slate-900">Katalog</span>
                </nav>
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">Eksplorasi <span class="text-indigo-600">Teknologi</span></h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Menampilkan {{ $produk->total() }} unit perangkat premium siap kirim.</p>
            </div>
            
            <div class="flex items-center gap-4 w-full md:w-auto">
                <button @click="filterOpen = true" class="md:hidden flex items-center gap-2 px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs font-bold uppercase tracking-widest shadow-sm hover:bg-slate-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter
                </button>
                
                <div class="relative group flex-1 md:w-80">
                    <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Model, Spesifikasi, atau SKU..." class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
                    <svg class="w-5 h-5 absolute left-4 top-3.5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <div class="relative">
                    <select wire:model.live="urutkan" class="appearance-none bg-white border border-slate-200 rounded-2xl pl-6 pr-10 py-3 text-xs font-black uppercase tracking-widest focus:ring-2 focus:ring-indigo-500 shadow-sm cursor-pointer hover:bg-slate-50 transition-colors">
                        <option value="terbaru">Terbaru</option>
                        <option value="termurah">Harga Terendah</option>
                        <option value="termahal">Harga Tertinggi</option>
                        <option value="rating">Rating Terbaik</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 top-3.5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        <div class="flex gap-10 items-start">
            
            <!-- Sidebar Filter (Desktop) -->
            <aside class="hidden md:block w-72 shrink-0 space-y-8 sticky top-32">
                <!-- Kategori -->
                <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
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

                <!-- Merek -->
                <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
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

                <!-- Harga -->
                <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Rentang Harga</h3>
                    <div class="space-y-4">
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

                <!-- Stok Toggle -->
                <div class="bg-gradient-to-br from-indigo-50 to-white p-6 rounded-[32px] border border-indigo-100">
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span class="text-xs font-black text-indigo-900 uppercase tracking-widest group-hover:text-indigo-700 transition-colors">Stok Tersedia</span>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="filterStok" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </div>
                    </label>
                </div>

                @if($filterKategori || $filterMerek || $cari || $filterStok || $hargaMin || $hargaMax)
                <button wire:click="resetFilter" class="w-full py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-rose-600 transition-all shadow-lg hover:shadow-rose-600/30">
                    Hapus Semua Filter
                </button>
                @endif
            </aside>

            <!-- Product Grid -->
            <div class="flex-1">
                @if($produk->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($produk as $p)
                    <a href="{{ route('produk.detail', $p->slug) }}" class="group bg-white rounded-[40px] p-4 border border-slate-100 hover:shadow-2xl hover:shadow-indigo-500/10 hover:border-indigo-100 transition-all duration-500 flex flex-col h-full transform hover:-translate-y-1">
                        <!-- Image -->
                        <div class="relative bg-slate-50 rounded-[32px] aspect-square overflow-hidden mb-5 flex items-center justify-center p-8 group-hover:bg-indigo-50/30 transition-colors">
                            @if($p->stok <= 0)
                                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px] z-10 flex items-center justify-center">
                                    <span class="px-4 py-2 bg-white text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg transform -rotate-12">Stok Habis</span>
                                </div>
                            @elseif($p->stok <= 5)
                                <span class="absolute top-4 left-4 px-3 py-1 bg-amber-500 text-white text-[9px] font-black uppercase tracking-widest rounded-lg z-10 shadow-lg shadow-amber-500/20">Stok Menipis</span>
                            @elseif($p->created_at->diffInDays(now()) < 7)
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
                                <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-2">{{ $p->kategori->nama }}</p>
                                <h3 class="font-bold text-slate-900 text-base leading-snug mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $p->nama }}</h3>
                            </div>
                            
                            <div class="mt-auto pt-4 border-t border-slate-50 flex items-end justify-between">
                                <div>
                                    @if($p->rating_rata_rata > 0)
                                    <div class="flex items-center gap-1 mb-1">
                                        <svg class="w-3 h-3 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <span class="text-[10px] font-bold text-slate-400">{{ $p->rating_rata_rata }}</span>
                                    </div>
                                    @endif
                                    <p class="text-lg font-black text-slate-900 tracking-tight">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</p>
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
                <div class="flex flex-col items-center justify-center py-40 text-center bg-white rounded-[40px] border border-slate-100 border-dashed">
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

    <!-- Mobile Filter Slide-over (Inline for simplicity & performance) -->
    <div x-show="filterOpen" class="fixed inset-0 z-50 lg:hidden" style="display: none;">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="filterOpen = false" x-transition.opacity></div>
        <div class="fixed inset-y-0 right-0 w-80 bg-white shadow-2xl p-8 overflow-y-auto" x-transition:enter="transform transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
            <div class="flex justify-between items-center mb-10">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-lg">Filter</h3>
                <button @click="filterOpen = false" class="p-2 bg-slate-100 rounded-full text-slate-500 hover:bg-rose-100 hover:text-rose-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="space-y-10">
                <!-- Mobile Categories -->
                <div>
                    <h4 class="font-black text-slate-900 text-xs uppercase tracking-widest mb-4">Kategori</h4>
                    <div class="space-y-3">
                        @foreach($semuaKategori as $k)
                        <label class="flex items-center gap-3">
                            <input type="checkbox" wire:model.live="filterKategori" value="{{ $k->slug }}" class="rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 w-5 h-5">
                            <span class="text-sm font-bold text-slate-600">{{ $k->nama }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Mobile Brands -->
                <div>
                    <h4 class="font-black text-slate-900 text-xs uppercase tracking-widest mb-4">Merek</h4>
                    <div class="space-y-3">
                        @foreach($semuaMerek as $m)
                        <label class="flex items-center gap-3">
                            <input type="checkbox" wire:model.live="filterMerek" value="{{ $m->slug }}" class="rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 w-5 h-5">
                            <span class="text-sm font-bold text-slate-600">{{ $m->nama }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                
                <button wire:click="resetFilter" @click="filterOpen = false" class="w-full py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] shadow-xl">
                    Lihat {{ $produk->total() }} Produk
                </button>
            </div>
        </div>
    </div>
</div>
