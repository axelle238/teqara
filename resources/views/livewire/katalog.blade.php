<div class="bg-slate-50 min-h-screen py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Katalog Produk</h1>
                <p class="text-sm text-slate-500 mt-1">Menampilkan koleksi terbaik untuk kebutuhan teknologi Anda.</p>
            </div>
            
            <!-- Mobile Search & Sort (Visible on small screens) -->
            <div class="flex flex-col gap-2 md:hidden">
                 <input wire:model.live.debounce.300ms="cari" type="search" placeholder="Cari produk..." class="w-full rounded-lg border-slate-200 text-sm focus:border-cyan-500 focus:ring-cyan-500">
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-64 flex-shrink-0 space-y-8">
                <!-- Search (Desktop) -->
                <div class="hidden md:block">
                    <label class="text-sm font-medium text-slate-700 mb-2 block">Pencarian</label>
                    <input wire:model.live.debounce.300ms="cari" type="search" placeholder="Cari nama produk..." class="w-full rounded-lg border-slate-300 text-sm focus:border-cyan-500 focus:ring-cyan-500 shadow-sm">
                </div>

                <!-- Filter Kategori -->
                <div>
                    <h3 class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-wider">Kategori</h3>
                    <div class="space-y-2 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($semuaKategori as $kat)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" wire:model.live="filterKategori" value="{{ $kat->slug }}" class="rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
                            <span class="text-sm text-slate-600 group-hover:text-cyan-700 transition">{{ $kat->nama }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Filter Merek -->
                <div>
                    <h3 class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-wider">Merek</h3>
                    <div class="space-y-2 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($semuaMerek as $merk)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" wire:model.live="filterMerek" value="{{ $merk->slug }}" class="rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
                            <span class="text-sm text-slate-600 group-hover:text-cyan-700 transition">{{ $merk->nama }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Tombol Reset -->
                <button wire:click="resetFilter" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                    Reset Filter
                </button>
            </aside>

            <!-- Product Grid -->
            <div class="flex-1">
                <!-- Toolbar Atas -->
                <div class="mb-6 flex items-center justify-between border-b border-slate-200 pb-4">
                    <span class="text-sm text-slate-600">
                        Menampilkan <span class="font-bold text-slate-900">{{ $produk->total() }}</span> produk
                    </span>
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-slate-600 hidden sm:block">Urutkan:</label>
                        <select wire:model.live="urutkan" class="rounded-lg border-slate-300 py-1.5 text-sm focus:border-cyan-500 focus:ring-cyan-500">
                            <option value="terbaru">Terbaru</option>
                            <option value="termurah">Harga Terendah</option>
                            <option value="termahal">Harga Tertinggi</option>
                        </select>
                    </div>
                </div>

                <!-- Grid -->
                @if($produk->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($produk as $p)
                        <div class="group relative flex flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm hover:shadow-lg transition duration-300">
                            <!-- Image -->
                            <div class="aspect-h-3 aspect-w-4 bg-slate-100 sm:aspect-none group-hover:opacity-90 sm:h-56 relative overflow-hidden">
                                <img src="{{ $p->gambar_utama }}" alt="{{ $p->nama }}" class="h-full w-full object-cover object-center transition duration-500 group-hover:scale-110">
                                
                                <!-- Badge -->
                                @if($p->stok < 1)
                                    <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                                        <span class="bg-slate-800 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Stok Habis</span>
                                    </div>
                                @elseif($p->stok < 5)
                                    <span class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">Sisa {{ $p->stok }}</span>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex flex-1 flex-col p-4">
                                <div class="flex-1">
                                    <p class="text-xs font-medium text-cyan-600 mb-1">{{ $p->kategori->nama }}</p>
                                    <h3 class="text-sm font-bold text-slate-900 leading-tight">
                                        <a href="/produk/{{ $p->slug }}" wire:navigate>
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ $p->nama }}
                                        </a>
                                    </h3>
                                    <p class="mt-2 text-xs text-slate-500 line-clamp-2">{{ strip_tags($p->deskripsi_singkat) }}</p>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <p class="text-lg font-bold text-slate-900">{{ $p->harga_rupiah }}</p>
                                    <div class="relative z-10">
                                        <button class="flex items-center justify-center h-8 w-8 rounded-full bg-slate-100 text-slate-600 hover:bg-cyan-600 hover:text-white transition">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-10">
                        {{ $produk->links(data: ['scrollTo' => false]) }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-20 bg-white rounded-xl border border-dashed border-slate-300">
                        <div class="mx-auto h-12 w-12 text-slate-300 mb-4">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="mt-2 text-sm font-semibold text-slate-900">Tidak ada produk ditemukan</h3>
                        <p class="mt-1 text-sm text-slate-500">Coba ubah kata kunci atau filter pencarian Anda.</p>
                        <button wire:click="resetFilter" class="mt-6 inline-flex items-center rounded-md bg-cyan-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                            Reset Semua Filter
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
