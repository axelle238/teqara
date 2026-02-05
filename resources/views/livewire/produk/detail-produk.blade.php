<div class="bg-white min-h-screen pb-32">
    
    <!-- Breadcrumb: Vibrant & Clean -->
    <div class="bg-white border-b border-indigo-50 sticky top-24 z-40 backdrop-blur-md bg-white/90">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex items-center gap-3 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                <a href="/katalog" class="hover:text-indigo-600 transition">KATALOG</a>
                <svg class="w-3 h-3 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M9 5l7 7-7 7"></path></svg>
                <a href="/katalog?kategori={{ $produk->kategori->slug }}" class="hover:text-indigo-600 transition">{{ $produk->kategori->nama }}</a>
                <svg class="w-3 h-3 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M9 5l7 7-7 7"></path></svg>
                <span class="text-indigo-600 truncate max-w-[200px]">{{ $produk->nama }}</span>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
            
            <!-- Media Viewport (No Slate-900) -->
            <div class="space-y-8">
                <div class="relative aspect-square rounded-[64px] overflow-hidden bg-white shadow-2xl shadow-indigo-500/10 border-4 border-indigo-50 group flex items-center justify-center">
                    <img src="{{ $gambarAktif }}" class="w-full h-full object-contain p-12 transform transition-transform duration-1000 group-hover:scale-110">
                    
                    @if($produk->stok < 10 && $produk->stok > 0)
                        <div class="absolute top-8 left-8 px-5 py-2.5 bg-amber-500 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-amber-500/30">
                            UNIT TERBATAS
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-4 gap-6 px-4">
                    <button wire:click="gantiGambar('{{ $produk->gambar_utama_url }}')" class="aspect-square rounded-3xl bg-white border-4 transition-all {{ $gambarAktif == $produk->gambar_utama_url ? 'border-indigo-500 shadow-xl' : 'border-slate-50 hover:border-indigo-200' }} p-3 overflow-hidden">
                        <img src="{{ $produk->gambar_utama_url }}" class="w-full h-full object-contain">
                    </button>
                    @foreach($produk->gambar as $g)
                    <button wire:click="gantiGambar('{{ $g->url }}')" class="aspect-square rounded-3xl bg-white border-4 transition-all {{ $gambarAktif == $g->url ? 'border-indigo-500 shadow-xl' : 'border-slate-50 hover:border-indigo-200' }} p-3 overflow-hidden">
                        <img src="{{ $g->url }}" class="w-full h-full object-contain">
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Control & Info Panel -->
            <div class="flex flex-col">
                <div class="space-y-8 mb-12">
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest">{{ $produk->merek->nama ?? 'Unit Resmi' }}</span>
                            <div class="h-1 w-1 rounded-full bg-slate-200"></div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ `produk->kode_unit }}</span>
                        </div>
                        <h1 class="text-4xl sm:text-5xl font-black text-slate-900 leading-[1.1] tracking-tighter uppercase">{{ $produk->nama }}</h1>
                    </div>
                    
                    <div class="flex items-center gap-6 p-6 rounded-[32px] bg-slate-50/50 border border-slate-100">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1.5 mb-1">
                                <div class="flex text-amber-400">
                                    @for($i=0; $i<5; $i++)
                                        <svg class="w-5 h-5 {{ $i < round($produk->rating_rata_rata) ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                                <span class="text-sm font-black text-slate-900 ml-1">{{ $produk->rating_rata_rata }}</span>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $produk->ulasan->count() }} Ulasan Member</p>
                        </div>
                        <div class="h-10 w-px bg-slate-200"></div>
                        <div class="flex flex-col">
                            <p class="text-sm font-black text-emerald-600 uppercase tracking-widest mb-1">{{ $stokAktif }} UNIT</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SIAP TERDISTRIBUSI</p>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Nilai Investasi Unit</p>
                        <h2 class="text-5xl font-black text-slate-900 tracking-tighter">Rp {{ number_format($hargaAktif, 0, ',', '.') }}</h2>
                    </div>
                </div>

                <!-- Model Selection (No Slate-900) -->
                @if($produk->memiliki_varian)
                <div class="mb-12 space-y-6">
                    <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em]">PILIH KONFIGURASI UNIT</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($produk->varian as $v)
                        <button 
                            wire:click="pilihVarian({{ $v->id }})"
                            class="p-5 rounded-[24px] text-left border-2 transition-all duration-300 {{ $varianTerpilihId == $v->id ? 'border-indigo-600 bg-indigo-50/50 shadow-xl shadow-indigo-500/10' : 'border-slate-50 bg-slate-50/50 hover:border-indigo-200' }}"
                        >
                            <p class="text-xs font-black text-slate-900 uppercase mb-1">{{ $v->nama }}</p>
                            <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Stok: {{ $v->stok }} Unit</p>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Purchase Flow: Vibrant & Clear -->
                <div class="mt-auto pt-12 border-t-2 border-dashed border-indigo-50 flex flex-col sm:flex-row gap-6">
                    <div class="flex items-center bg-slate-100/50 p-2 rounded-[28px] border-2 border-white shadow-inner">
                        <button wire:click="kurangJumlah" class="w-14 h-14 flex items-center justify-center bg-white rounded-2xl shadow-sm text-indigo-600 hover:bg-rose-50 hover:text-rose-600 transition-all font-black text-xl">-</button>
                        <input type="text" readonly class="w-20 bg-transparent border-none text-center font-black text-xl text-slate-900" value="{{ $jumlah }}">
                        <button wire:click="tambahJumlah" class="w-14 h-14 flex items-center justify-center bg-white rounded-2xl shadow-sm text-indigo-600 hover:bg-emerald-50 hover:text-emerald-600 transition-all font-black text-xl">+</button>
                    </div>
                    <button 
                        wire:click="tambahKeKeranjang" 
                        class="flex-1 px-10 py-5 bg-gradient-to-r from-indigo-600 to-cyan-600 text-white rounded-[32px] font-black text-sm uppercase tracking-[0.2em] hover:scale-[1.02] active:scale-95 transition-all shadow-2xl shadow-indigo-500/30 flex items-center justify-center gap-4 group"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>AKTIVASI KERANJANG</span>
                        <span wire:loading class="animate-pulse tracking-widest">MEMPROSES...</span>
                        <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Spec & Info Tabs: High-Tech View -->
        <div x-data="{ tab: 'deskripsi' }" class="mt-40">
            <div class="flex justify-center mb-20">
                <div class="p-2 bg-slate-100/50 rounded-[28px] border-2 border-white shadow-inner flex gap-2">
                    <button @click="tab = 'deskripsi'" :class="tab === 'deskripsi' ? 'bg-indigo-600 text-white shadow-xl' : 'text-slate-500 hover:text-indigo-600'" class="px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all">ANALISIS UNIT</button>
                    <button @click="tab = 'spesifikasi'" :class="tab === 'spesifikasi' ? 'bg-indigo-600 text-white shadow-xl' : 'text-slate-500 hover:text-indigo-600'" class="px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all">RINCIAN TEKNIS</button>
                    <button @click="tab = 'ulasan'" :class="tab === 'ulasan' ? 'bg-indigo-600 text-white shadow-xl' : 'text-slate-500 hover:text-indigo-600'" class="px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all">LOG KEPUASAN</button>
                </div>
            </div>

            <!-- Tab Viewports -->
            <div class="max-w-5xl mx-auto">
                <!-- Deskripsi -->
                <div x-show="tab === 'deskripsi'" class="animate-in fade-in slide-in-from-bottom-10 duration-700">
                    <div class="bg-white p-12 rounded-[56px] border border-indigo-50 shadow-sm prose prose-indigo prose-lg max-w-none text-slate-600 leading-loose uppercase tracking-tight font-medium">
                        {!! $produk->deskripsi_lengkap !!}
                    </div>
                </div>

                <!-- Spesifikasi: Grid with Icons -->
                <div x-show="tab === 'spesifikasi'" style="display: none;" class="animate-in fade-in slide-in-from-bottom-10 duration-700">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($produk->spesifikasi as $spek)
                        <div class="flex items-center gap-6 p-8 bg-white rounded-[32px] border border-indigo-50 shadow-sm group hover:border-indigo-300 transition-colors">
                            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">⚙️</div>
                            <div>
                                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">{{ $spek->judul }}</p>
                                <p class="text-lg font-black text-slate-900 tracking-tight">{{ $spek->nilai }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full py-20 text-center uppercase font-black text-slate-300 tracking-[0.3em]">Data Teknis Belum Terkatalog</div>
                        @endforelse
                    </div>
                </div>

                <!-- Ulasan: Social Style -->
                <div x-show="tab === 'ulasan'" style="display: none;" class="animate-in fade-in slide-in-from-bottom-10 duration-700">
                    <div class="grid grid-cols-1 gap-8">
                        @forelse($produk->ulasan as $ulasan)
                        <div class="bg-white p-10 rounded-[48px] border border-indigo-50 shadow-sm flex gap-8 items-start">
                            <div class="w-16 h-16 rounded-3xl bg-indigo-100 flex items-center justify-center font-black text-xl text-indigo-600 shrink-0 shadow-inner">{{ substr($ulasan->pengguna->nama, 0, 1) }}</div>
                            <div class="flex-1 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-black text-slate-900 uppercase tracking-tight text-lg">{{ $ulasan->pengguna->nama }}</p>
                                        <div class="flex text-amber-400 mt-1">
                                            @for($i=0; $i<$ulasan->rating; $i++) <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg> @endfor
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">{{ $ulasan->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-slate-600 leading-relaxed font-medium">"{{ $ulasan->komentar }}"</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-32 bg-slate-50/50 rounded-[56px] border-2 border-dashed border-indigo-100">
                            <p class="text-slate-400 font-black uppercase tracking-[0.3em]">Belum Ada Log Kepuasan Member</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
