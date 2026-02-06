<div class="bg-slate-50 min-h-screen py-20 relative overflow-hidden">
    
    <!-- Decorative Tech Background -->
    <div class="absolute top-0 left-0 w-full h-[500px] bg-gradient-to-b from-indigo-600/5 to-transparent pointer-events-none"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-500/10 blur-[100px] rounded-full"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-cyan-500/5 blur-[120px] rounded-full translate-x-1/4 translate-y-1/4"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
            <div class="space-y-4">
                <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">
                    <a href="/" class="hover:text-indigo-600 transition-colors">Beranda</a>
                    <span>/</span>
                    <span class="text-indigo-600">Sistem Manajemen Keranjang</span>
                </nav>
                <h1 class="text-6xl font-black text-slate-900 tracking-tighter uppercase leading-none">
                    ANTRIAN <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-cyan-600">UNIT</span>
                </h1>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-indigo-600 animate-ping"></span>
                    Monitoring Reservasi Stok Real-Time
                </p>
            </div>
            
            @if($this->items->count() > 0)
            <div class="flex items-center gap-4">
                <button 
                    wire:click="bersihkanKeranjang" 
                    wire:confirm="Sistem akan menghapus seluruh unit dari antrian. Lanjutkan?"
                    class="px-6 py-3 bg-white border-2 border-slate-100 text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:border-rose-200 hover:text-rose-500 hover:bg-rose-50 transition-all flex items-center gap-3 group"
                >
                    <svg class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Bersihkan Antrian
                </button>
            </div>
            @endif
        </div>

        @if($this->items->count() > 0)
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
            
            <!-- Item List -->
            <div class="lg:col-span-8 space-y-6">
                @foreach($this->items as $item)
                <div class="group bg-white rounded-[48px] p-8 border border-white shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 relative overflow-hidden">
                    <!-- Progress Background -->
                    <div class="absolute bottom-0 left-0 h-1.5 bg-indigo-600/10 w-full">
                        <div class="h-full bg-indigo-600 transition-all duration-1000" style="width: {{ ($item->jumlah / $item->produk->stok) * 100 }}%"></div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-10">
                        <!-- Product Visual -->
                        <div class="relative w-full sm:w-56 aspect-square rounded-[40px] bg-slate-50 border border-slate-100 p-8 flex items-center justify-center group-hover:bg-indigo-50/50 transition-colors shrink-0">
                            <img src="{{ $item->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute -top-3 -right-3 w-12 h-12 bg-white rounded-2xl shadow-lg border border-slate-50 flex items-center justify-center text-indigo-600 font-black text-xs">
                                #{{ $loop->iteration }}
                            </div>
                        </div>

                        <!-- Product Data -->
                        <div class="flex-1 flex flex-col justify-between py-2">
                            <div class="space-y-4">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-3 mb-1">
                                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded text-[9px] font-black uppercase tracking-widest">{{ $item->produk->kategori->nama }}</span>
                                            @if($item->produk->stok <= 5)
                                                <span class="text-[9px] font-black text-rose-500 uppercase tracking-widest animate-pulse">Stok Terbatas!</span>
                                            @endif
                                        </div>
                                        <h3 class="text-2xl font-black text-slate-900 tracking-tighter leading-none group-hover:text-indigo-600 transition-colors uppercase">
                                            {{ $item->produk->nama }}
                                        </h3>
                                    </div>
                                    <button wire:click="hapusItem({{ $item->id }})" class="w-12 h-12 bg-slate-50 text-slate-400 hover:bg-rose-500 hover:text-white rounded-2xl transition-all shadow-sm flex items-center justify-center group/btn">
                                        <svg class="w-6 h-6 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                
                                <p class="text-sm font-bold text-slate-400 leading-relaxed max-w-md line-clamp-1 italic">
                                    Unit SKU: {{ $item->produk->kode_sku ?? 'TEQ-'.str_pad($item->produk->id, 6, '0', STR_PAD_LEFT) }}
                                </p>
                            </div>

                            <!-- Controls & Pricing -->
                            <div class="mt-10 flex flex-wrap items-end justify-between gap-8">
                                <div class="space-y-3">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block px-2">Kuantitas Unit</span>
                                    <div class="flex items-center bg-slate-50 p-1.5 rounded-2xl border border-slate-100 shadow-inner">
                                        <button wire:click="kurangJumlah({{ $item->id }})" class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all font-black text-xl">-</button>
                                        <span class="w-14 text-center font-black text-slate-900 text-lg">{{ $item->jumlah }}</span>
                                        <button wire:click="tambahJumlah({{ $item->id }})" class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all font-black text-xl">+</button>
                                    </div>
                                </div>

                                <div class="text-right space-y-1">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Akumulasi Nilai</p>
                                    <div class="flex items-baseline gap-2 justify-end">
                                        <span class="text-xs font-bold text-slate-300">@ Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }}</span>
                                        <p class="text-3xl font-black text-indigo-600 tracking-tighter">Rp {{ number_format($item->produk->harga_jual * $item->jumlah, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Sticky Summary Sidebar -->
            <div class="mt-16 lg:mt-0 lg:col-span-4 sticky top-32">
                <div class="bg-white rounded-[56px] shadow-2xl shadow-indigo-500/10 border-4 border-white p-12 space-y-10 relative overflow-hidden">
                    <!-- Glass Background Decor -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-600/5 rounded-full blur-[40px]"></div>
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-cyan-600/5 rounded-full blur-[40px]"></div>

                    <div class="relative z-10">
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tighter flex items-center gap-4 mb-10">
                            <span class="w-10 h-2 bg-indigo-600 rounded-full"></span>
                            RINGKASAN
                        </h2>
                        
                        <dl class="space-y-8">
                            <div class="flex items-center justify-between">
                                <dt class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Kuantitas Total</dt>
                                <dd class="text-sm font-black text-slate-900">{{ $this->items->sum('jumlah') }} UNIT</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Estimasi Bobot</dt>
                                <dd class="text-sm font-black text-slate-900 uppercase">Prioritas</dd>
                            </div>
                            
                            <div class="pt-10 border-t-2 border-dashed border-slate-50 space-y-4">
                                <div class="flex items-end justify-between">
                                    <dt class="text-sm font-black text-slate-900 uppercase tracking-widest">TOTAL NILAI</dt>
                                    <dd class="text-4xl font-black text-indigo-600 tracking-tighter leading-none">
                                        <span class="text-xs font-bold align-top mt-1 mr-1">RP</span>{{ number_format($this->total_harga, 0, ',', '.') }}
                                    </dd>
                                </div>
                                <p class="text-[10px] text-right font-bold text-slate-400 uppercase tracking-widest italic leading-relaxed">
                                    Sudah Termasuk Pajak Pertambahan Nilai (PPN 11%)
                                </p>
                            </div>
                        </dl>
                    </div>

                    <div class="pt-4 relative z-10 space-y-6">
                        <a href="/checkout" wire:navigate class="w-full flex items-center justify-center gap-4 py-6 bg-gradient-to-r from-indigo-600 to-indigo-800 text-white rounded-[32px] text-sm font-black uppercase tracking-[0.2em] shadow-2xl shadow-indigo-600/30 hover:scale-[1.02] active:scale-95 transition-all group">
                            EKSEKUSI CHECKOUT
                            <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        
                        <div class="bg-indigo-50/50 p-6 rounded-[32px] border border-indigo-100 flex gap-4 items-start animate-in zoom-in duration-500">
                            <div class="w-10 h-10 rounded-2xl bg-white flex items-center justify-center text-indigo-600 shadow-sm shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <p class="text-[10px] font-bold text-indigo-800 leading-relaxed uppercase tracking-widest">
                                Unit Anda Telah Dilindungi Oleh <span class="font-black">Sistem Proteksi Teqara</span> Selama Proses Pemindahan Stok.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Improved Empty State -->
        <div class="max-w-4xl mx-auto text-center py-40 px-12 bg-white rounded-[80px] border-4 border-dashed border-slate-100 relative overflow-hidden group">
            <!-- Background Decoration -->
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
            
            <div class="relative z-10 space-y-12">
                <div class="relative inline-block">
                    <div class="w-40 h-40 bg-slate-50 rounded-[48px] flex items-center justify-center text-8xl mx-auto shadow-inner transform -rotate-12 group-hover:rotate-0 transition-transform duration-700">🛒</div>
                    <div class="absolute -top-4 -right-4 w-12 h-12 bg-rose-500 text-white rounded-full flex items-center justify-center font-black text-xl animate-bounce shadow-lg">!</div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">Radar Unit Kosong</h3>
                    <p class="text-slate-400 font-medium text-xl max-w-xl mx-auto leading-relaxed">
                        Sistem tidak mendeteksi adanya reservasi unit teknologi dalam antrian belanja Anda saat ini.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    <a href="/katalog" wire:navigate class="px-12 py-6 bg-slate-900 text-white rounded-[32px] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-2xl shadow-slate-900/20 transform hover:-translate-y-1">
                        EKSPLORASI TEKNOLOGI
                    </a>
                    <a href="/" wire:navigate class="px-12 py-6 bg-white border-2 border-slate-100 text-slate-400 rounded-[32px] font-black text-xs uppercase tracking-[0.2em] hover:border-indigo-600 hover:text-indigo-600 transition-all">
                        KEMBALI KE BERANDA
                    </a>
                </div>

                <!-- Recommendation Section in Empty Cart -->
                <div class="pt-20 border-t border-slate-50">
                    <h4 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.5em] mb-10">Unit Rekomendasi Sistem</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($this->rekomendasi as $p)
                        <a href="/produk/{{ $p->slug }}" wire:navigate class="group/item bg-slate-50/50 p-4 rounded-[32px] border border-transparent hover:border-indigo-100 hover:bg-white transition-all">
                            <div class="aspect-square bg-white rounded-2xl p-4 mb-4 flex items-center justify-center border border-slate-100 group-hover/item:scale-105 transition-transform">
                                <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply">
                            </div>
                            <p class="text-[9px] font-black text-slate-900 uppercase truncate px-2">{{ $p->nama }}</p>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>