<div class="bg-white min-h-screen">
    
    <!-- Top Search Summary Bar -->
    <div class="bg-slate-900 py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-black text-white tracking-tighter mb-4">Eksplorasi Teknologi</h1>
            <div class="flex flex-wrap items-center gap-4 text-slate-400 text-sm font-bold uppercase tracking-widest">
                <span>{{ $produk->total() }} Produk Ditemukan</span>
                <span class="h-1.5 w-1.5 rounded-full bg-slate-700"></span>
                @if($cari)
                    <span class="text-cyan-400">Kata Kunci: "{{ $cari }}"</span>
                @else
                    <span>Menampilkan Koleksi Terbaik</span>
                @endif
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Sidebar Filter (Fixed Desktop, Scroll Mobile) -->
            <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="sticky top-32 space-y-10">
                    
                    <!-- Search Input Inside Sidebar -->
                    <div>
                        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Pencarian Cepat</h3>
                        <div class="relative group">
                            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari model..." class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-cyan-500 transition-all">
                            <svg class="absolute left-4 top-3.5 w-5 h-5 text-slate-400 group-focus-within:text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>

                    <!-- Kategori Filter -->
                    <div>
                        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Kategori Utama</h3>
                        <div class="grid gap-3">
                            @foreach($semuaKategori as $kat)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" wire:model.live="filterKategori" value="{{ $kat->slug }}" class="w-5 h-5 rounded-lg border-slate-200 text-cyan-600 focus:ring-cyan-500 transition-all">
                                <span class="text-sm font-bold text-slate-600 group-hover:text-slate-900 transition-colors">{{ $kat->nama }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Merek Filter -->
                    <div>
                        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Produsen / Merek</h3>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($semuaMerek as $merk)
                            <label class="relative flex items-center justify-center p-3 rounded-xl border-2 cursor-pointer transition-all {{ in_array($merk->slug, (array)$filterMerek) ? 'border-cyan-600 bg-cyan-50 text-cyan-700' : 'border-slate-50 bg-slate-50 text-slate-500 hover:border-slate-200' }}">
                                <input type="checkbox" wire:model.live="filterMerek" value="{{ $merk->slug }}" class="sr-only">
                                <span class="text-xs font-black uppercase tracking-tighter">{{ $merk->nama }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Stok & Reset -->
                    <div class="pt-10 border-t border-slate-100">
                        <label class="flex items-center gap-3 cursor-pointer mb-6">
                            <div class="relative inline-flex h-6 w-11 items-center rounded-full bg-slate-200 transition-colors {{ $filterStok ? 'bg-emerald-500' : '' }}">
                                <input type="checkbox" wire:model.live="filterStok" class="sr-only peer">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $filterStok ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </div>
                            <span class="text-sm font-bold text-slate-700">Tampilkan Stok Ready</span>
                        </label>
                        <button wire:click="resetFilter" class="w-full py-3 bg-slate-100 text-slate-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition-all">Reset Semua Filter</button>
                    </div>
                </div>
            </aside>

            <!-- Product Grid Area -->
            <div class="flex-1">
                <!-- Grid Toolbar -->
                <div class="mb-10 flex items-center justify-between">
                    <div class="hidden sm:block">
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Urutan Katalog</p>
                    </div>
                    <select wire:model.live="urutkan" class="bg-slate-50 border-none rounded-xl text-sm font-black text-slate-900 focus:ring-2 focus:ring-cyan-500 py-3 pl-4 pr-10">
                        <option value="terbaru">Rilis Terbaru</option>
                        <option value="rating">Rating Tertinggi</option>
                        <option value="termurah">Harga Termurah</option>
                        <option value="termahal">Harga Termahal</option>
                    </select>
                </div>

                <!-- Main Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                    @forelse($produk as $p)
                    <div class="group relative flex flex-col bg-white rounded-[32px] border border-slate-200/60 p-4 hover:shadow-2xl hover:shadow-cyan-500/10 transition-all duration-500">
                        <!-- Media -->
                        <div class="relative aspect-square rounded-2xl overflow-hidden bg-slate-50 mb-6 group-hover:scale-[0.98] transition-transform duration-500">
                            <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain p-6 transform group-hover:scale-110 transition-transform duration-700">
                            <!-- Out of Stock Overlay -->
                            @if($p->stok < 1)
                                <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] flex items-center justify-center">
                                    <span class="px-4 py-2 rounded-full bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest">Stok Habis</span>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="px-2 flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-0.5 rounded bg-cyan-50 text-cyan-600 text-[9px] font-black uppercase tracking-widest">{{ $p->merek->nama ?? 'Teqara' }}</span>
                                <div class="flex items-center gap-1">
                                    <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <span class="text-[10px] font-black text-slate-400">{{ $p->rating_rata_rata }}</span>
                                </div>
                            </div>
                            <h4 class="text-lg font-black text-slate-900 leading-snug mb-4 line-clamp-2 h-14 group-hover:text-cyan-600 transition-colors">
                                <a href="/produk/{{ $p->slug }}" wire:navigate>{{ $p->nama }}</a>
                            </h4>
                            
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-50">
                                <div>
                                    <p class="text-xl font-black text-slate-900 tracking-tighter">{{ 'Rp ' . number_format($p->harga_jual/1000, 0) . 'k' }}</p>
                                </div>
                                <a href="/produk/{{ $p->slug }}" wire:navigate class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white hover:bg-cyan-600 transition-all shadow-lg shadow-slate-900/10">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-24 text-center">
                        <div class="text-6xl mb-6">🔍</div>
                        <h3 class="text-2xl font-black text-slate-900 mb-2">Produk Tidak Ditemukan</h3>
                        <p class="text-slate-500 font-bold">Coba ubah kata kunci atau reset filter Anda.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination Enterprise -->
                <div class="mt-20">
                    {{ $produk->links() }}
                </div>
            </div>
        </div>
    </div>
</div>