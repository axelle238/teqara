<div class="bg-white min-h-screen">
    
    <!-- Top Vibrant Summary Bar (No Slate-900) -->
    <div class="bg-gradient-to-r from-indigo-600 via-indigo-500 to-cyan-500 py-16 shadow-inner relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0 100 L50 0 L100 100 Z" fill="white"></path></svg>
        </div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex items-center gap-4 mb-4">
                <span class="px-4 py-1.5 rounded-2xl bg-white/20 backdrop-blur-md text-[10px] font-black text-white uppercase tracking-[0.3em]">Unit Eksplorasi</span>
            </div>
            <h1 class="text-5xl font-black text-white tracking-tighter mb-6 uppercase">KATALOG <span class="text-cyan-200">TEKNOLOGI</span></h1>
            <div class="flex flex-wrap items-center gap-6 text-indigo-100 text-xs font-black uppercase tracking-[0.2em]">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    {{ $produk->total() }} Produk Terverifikasi
                </div>
                @if($cari)
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        Filter: "{{ $cari }}"
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
        <div class="flex flex-col lg:flex-row gap-16">
            
            <!-- Sidebar Filter: Vibrant Glassmorphism -->
            <aside class="w-full lg:w-80 flex-shrink-0">
                <div class="sticky top-32 space-y-12 bg-white p-10 rounded-[48px] border border-indigo-50 shadow-2xl shadow-indigo-500/5">
                    
                    <!-- Search Control -->
                    <div class="space-y-6">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-indigo-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            PENCARIAN UNIT
                        </h3>
                        <div class="relative group">
                            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari model atau spesifikasi..." class="w-full pl-12 pr-4 py-4 bg-indigo-50/50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-400">
                            <div class="absolute left-4 top-4 text-indigo-300 group-focus-within:text-indigo-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori Filter: Vibrant Badges -->
                    <div class="space-y-6">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-emerald-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            KLASIFIKASI
                        </h3>
                        <div class="grid gap-3">
                            @foreach($semuaKategori as $kat)
                            <label class="flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition-all {{ in_array($kat->slug, (array)$filterKategori) ? 'border-emerald-500 bg-emerald-50' : 'border-slate-50 bg-slate-50/50 hover:border-emerald-200' }}">
                                <span class="text-xs font-black uppercase tracking-widest {{ in_array($kat->slug, (array)$filterKategori) ? 'text-emerald-700' : 'text-slate-500' }}">{{ $kat->nama }}</span>
                                <input type="checkbox" wire:model.live="filterKategori" value="{{ $kat->slug }}" class="w-5 h-5 rounded-lg border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Merek Control -->
                    <div class="space-y-6">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-amber-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            PRODUSEN
                        </h3>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($semuaMerek as $merk)
                            <button 
                                wire:click="$toggle('filterMerek', '{{ $merk->slug }}')"
                                class="p-3 rounded-2xl border-2 text-[10px] font-black uppercase tracking-tighter transition-all {{ in_array($merk->slug, (array)$filterMerek) ? 'border-amber-500 bg-amber-50 text-amber-700 shadow-lg shadow-amber-500/10' : 'border-slate-50 bg-slate-50/50 text-slate-400 hover:border-amber-200' }}"
                            >
                                {{ $merk->nama }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Reset Trigger -->
                    <div class="pt-8 border-t border-indigo-50">
                        <button wire:click="resetFilter" class="w-full py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/10">RESET PARAMETER</button>
                    </div>
                </div>
            </aside>

            <!-- Product Grid: Colorful Cards -->
            <div class="flex-1 space-y-12">
                <!-- Toolbar -->
                <div class="flex items-center justify-between bg-white p-6 rounded-[32px] border border-indigo-50 shadow-sm">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Unit Terdaftar: {{ $produk->total() }}</p>
                    <select wire:model.live="urutkan" class="bg-indigo-50/50 border-none rounded-xl text-xs font-black text-indigo-600 focus:ring-2 focus:ring-indigo-500 py-2.5 pl-4 pr-10 uppercase tracking-widest">
                        <option value="terbaru">Rilisan Terbaru</option>
                        <option value="rating">Rating Tertinggi</option>
                        <option value="termurah">Harga Terendah</option>
                        <option value="termahal">Harga Tertinggi</option>
                    </select>
                </div>

                <!-- Main Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-10">
                    @forelse($produk as $p)
                    <div class="group relative flex flex-col bg-white rounded-[48px] border border-slate-100 p-6 hover:shadow-2xl hover:shadow-indigo-500/15 transition-all duration-500">
                        <!-- Media Viewport -->
                        <div class="relative aspect-square rounded-[36px] overflow-hidden bg-slate-50 mb-8 border border-slate-50 flex items-center justify-center">
                            <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain p-10 transform group-hover:scale-110 transition-transform duration-1000">
                            @if($p->stok < 1)
                                <div class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center">
                                    <span class="px-6 py-2 rounded-2xl bg-rose-600 text-white text-[10px] font-black uppercase tracking-[0.2em] shadow-xl">OUT OF STOCK</span>
                                </div>
                            @endif
                        </div>

                        <!-- Info Content -->
                        <div class="px-2 space-y-4 flex-1">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase tracking-widest">{{ $p->merek->nama ?? 'Unit' }}</span>
                                <div class="flex items-center gap-1.5 px-2 py-1 rounded-lg bg-amber-50">
                                    <span class="text-xs">⭐</span>
                                    <span class="text-[10px] font-black text-amber-700">{{ $p->rating_rata_rata }}</span>
                                </div>
                            </div>
                            <h4 class="text-xl font-black text-slate-900 leading-snug h-14 line-clamp-2 group-hover:text-indigo-600 transition-colors uppercase tracking-tight">
                                <a href="/produk/{{ $p->slug }}" wire:navigate>{{ $p->nama }}</a>
                            </h4>
                            
                            <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                                <div>
                                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1">Mulai Dari</p>
                                    <p class="text-2xl font-black text-slate-900 tracking-tighter">Rp {{ number_format($p->harga_jual/1000, 0) }}<span class="text-sm ml-0.5">k</span></p>
                                </div>
                                <a href="/produk/{{ $p->slug }}" wire:navigate class="w-14 h-14 rounded-2xl bg-slate-900 flex items-center justify-center text-white hover:bg-indigo-600 hover:scale-110 transition-all shadow-xl shadow-slate-900/10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 4v16m8-8H4"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-32 text-center bg-white rounded-[48px] border border-dashed border-indigo-100">
                        <div class="text-7xl mb-8">🛰️</div>
                        <h3 class="text-3xl font-black text-slate-900 mb-4 tracking-tighter uppercase">Sinyal Unit Terputus</h3>
                        <p class="text-slate-400 font-bold max-w-sm mx-auto uppercase text-xs tracking-widest">Tidak ada unit yang sesuai dengan kriteria radar Anda.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Navigation -->
                <div class="mt-20">
                    {{ $produk->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
