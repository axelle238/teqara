<div class="bg-slate-50 min-h-screen py-12" x-data="{ filterOpen: false }">
    <div class="container mx-auto px-6">
        
        <!-- Header Katalog -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">Eksplorasi <span class="text-indigo-600">Teknologi</span></h1>
                <p class="text-slate-500 text-sm mt-1">Menampilkan {{ $produk->total() }} unit perangkat premium.</p>
            </div>
            
            <div class="flex items-center gap-4 w-full md:w-auto">
                <button @click="filterOpen = true" class="md:hidden flex items-center gap-2 px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs font-bold uppercase tracking-widest shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter
                </button>
                
                <div class="relative group flex-1 md:w-64">
                    <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Spesifikasi..." class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                    <svg class="w-4 h-4 absolute left-3 top-3.5 text-slate-400 group-focus-within:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <select wire:model.live="urutkan" class="bg-white border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold uppercase tracking-widest focus:ring-2 focus:ring-indigo-500">
                    <option value="terbaru">Terbaru</option>
                    <option value="termurah">Harga Terendah</option>
                    <option value="termahal">Harga Tertinggi</option>
                    <option value="rating">Rating Terbaik</option>
                </select>
            </div>
        </div>

        <div class="flex gap-10 items-start">
            
            <!-- Sidebar Filter (Desktop) -->
            <aside class="hidden md:block w-72 shrink-0 space-y-8 sticky top-24">
                <!-- Kategori -->
                <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-4">Kategori</h3>
                    <div class="space-y-3">
                        @foreach($semuaKategori as $k)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" wire:model.live="filterKategori" value="{{ $k->slug }}" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                            <span class="text-sm font-bold text-slate-600 group-hover:text-indigo-600 transition-colors">{{ $k->nama }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Merek -->
                <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-4">Merek</h3>
                    <div class="space-y-3">
                        @foreach($semuaMerek as $m)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" wire:model.live="filterMerek" value="{{ $m->slug }}" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                            <span class="text-sm font-bold text-slate-600 group-hover:text-indigo-600 transition-colors">{{ $m->nama }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Harga -->
                <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-4">Rentang Harga</h3>
                    <div class="space-y-4">
                        <input wire:model.live.debounce.500ms="hargaMin" type="number" placeholder="Min" class="w-full rounded-xl border-slate-200 text-sm font-bold px-3 py-2">
                        <input wire:model.live.debounce.500ms="hargaMax" type="number" placeholder="Max" class="w-full rounded-xl border-slate-200 text-sm font-bold px-3 py-2">
                    </div>
                </div>

                <!-- Stok -->
                <div class="bg-indigo-50 p-6 rounded-[24px] border border-indigo-100">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="filterStok" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </div>
                        <span class="text-xs font-black text-indigo-900 uppercase tracking-widest">Hanya Stok Tersedia</span>
                    </label>
                </div>

                @if($filterKategori || $filterMerek || $cari || $filterStok || $hargaMin || $hargaMax)
                <button wire:click="resetFilter" class="w-full py-3 bg-slate-200 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-300 transition-all">
                    Reset Filter
                </button>
                @endif
            </aside>

            <!-- Product Grid -->
            <div class="flex-1">
                @if($produk->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($produk as $p)
                    <div class="group bg-white rounded-[32px] p-4 border border-slate-100 hover:shadow-2xl hover:shadow-indigo-500/10 hover:border-indigo-100 transition-all duration-500 relative flex flex-col">
                        <!-- Image -->
                        <div class="relative bg-slate-50 rounded-[24px] aspect-square overflow-hidden mb-4 flex items-center justify-center p-6">
                            @if($p->stok <= 0)
                                <div class="absolute inset-0 bg-slate-900/10 backdrop-blur-[1px] z-10 flex items-center justify-center">
                                    <span class="px-4 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-lg">Habis</span>
                                </div>
                            @elseif($p->stok <= 5)
                                <span class="absolute top-4 left-4 px-3 py-1 bg-amber-500 text-white text-[9px] font-black uppercase tracking-widest rounded-lg z-10">Stok Terbatas</span>
                            @endif
                            
                            <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500 mix-blend-multiply">
                            
                            <!-- Quick Action -->
                            <div class="absolute bottom-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-all translate-y-4 group-hover:translate-y-0">
                                <a href="{{ route('produk.detail', $p->slug) }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-indigo-600 shadow-lg hover:bg-indigo-600 hover:text-white transition-all" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="px-2 pb-2 flex-1 flex flex-col">
                            <div class="mb-auto">
                                <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-1">{{ $p->kategori->nama }}</p>
                                <a href="{{ route('produk.detail', $p->slug) }}" class="block">
                                    <h3 class="font-bold text-slate-900 text-base leading-tight mb-2 line-clamp-2 hover:text-indigo-600 transition-colors">{{ $p->nama }}</h3>
                                </a>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-slate-50 flex items-end justify-between">
                                <div>
                                    <p class="text-lg font-black text-slate-900 tracking-tight">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</p>
                                    @if($p->rating_rata_rata > 0)
                                    <div class="flex items-center gap-1 mt-1">
                                        <svg class="w-3 h-3 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <span class="text-[10px] font-bold text-slate-500">{{ $p->rating_rata_rata }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-12">
                    {{ $produk->links() }}
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-32 text-center bg-white rounded-[40px] border border-slate-100 border-dashed">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-2">Tidak Ditemukan</h3>
                    <p class="text-slate-500 max-w-xs mx-auto mb-6">Coba sesuaikan kata kunci pencarian atau kurangi filter yang aktif.</p>
                    <button wire:click="resetFilter" class="px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-800 transition">Reset Pencarian</button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Mobile Filter Slide-over (Menggunakan Panel Geser Admin Component untuk efisiensi, atau buat inline) -->
    <!-- Kita buat inline sederhana untuk mobile -->
    <div x-show="filterOpen" class="fixed inset-0 z-50 lg:hidden" style="display: none;">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="filterOpen = false" x-transition.opacity></div>
        <div class="fixed inset-y-0 right-0 w-80 bg-white shadow-2xl p-6 overflow-y-auto" x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-black text-slate-900 uppercase tracking-widest">Filter Produk</h3>
                <button @click="filterOpen = false" class="p-2 bg-slate-100 rounded-full text-slate-500 hover:bg-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Mobile Filters Content (Clone of Sidebar) -->
            <div class="space-y-8">
                <!-- Kategori -->
                <div>
                    <h4 class="font-bold text-slate-900 text-xs uppercase mb-3">Kategori</h4>
                    <div class="space-y-2">
                        @foreach($semuaKategori as $k)
                        <label class="flex items-center gap-3">
                            <input type="checkbox" wire:model.live="filterKategori" value="{{ $k->slug }}" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm text-slate-600">{{ $k->nama }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <!-- ... (Merek & Harga same as desktop) ... -->
                <button wire:click="resetFilter" @click="filterOpen = false" class="w-full py-3 bg-slate-900 text-white rounded-xl text-xs font-bold uppercase tracking-widest mt-8">Terapkan Filter</button>
            </div>
        </div>
    </div>
</div>