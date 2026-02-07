<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex text-xs font-bold text-slate-400 uppercase tracking-widest gap-2 mb-8">
            <a href="/" class="hover:text-indigo-600 transition-colors">Beranda</a>
            <span>/</span>
            <span class="text-slate-900">Keranjang Belanja</span>
        </nav>

        <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tighter mb-8 flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            Keranjang <span class="text-indigo-600">Saya</span>
        </h1>

        @if($this->items->count() > 0)
        <div class="lg:grid lg:grid-cols-12 lg:gap-12 lg:items-start">
            <!-- Cart Items -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-8 relative">
                    <!-- Decor -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full blur-3xl opacity-50 -z-0"></div>

                    <ul role="list" class="divide-y divide-slate-50 relative z-10">
                        @foreach($this->items as $item)
                        <li class="p-6 sm:p-8 flex flex-col sm:flex-row gap-6 hover:bg-slate-50/50 transition-colors group">
                            <!-- Image -->
                            <div class="h-28 w-28 flex-shrink-0 overflow-hidden rounded-2xl border border-slate-100 bg-slate-50 p-2 flex items-center justify-center group-hover:border-indigo-100 transition-colors">
                                <img src="{{ $item->produk->gambar_utama_url }}" class="h-full w-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500">
                            </div>

                            <div class="flex-1 flex flex-col sm:flex-row justify-between">
                                <div class="flex-1 pr-4">
                                    <h3 class="text-lg font-bold text-slate-900 leading-snug mb-1">
                                        <a href="{{ route('produk.detail', $item->produk->slug) }}" class="hover:text-indigo-600 transition-colors">{{ $item->produk->nama }}</a>
                                    </h3>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ $item->produk->kategori->nama }}</p>
                                    
                                    @if($item->varian)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest border border-indigo-100 shadow-sm">
                                            {{ $item->varian->nama_varian }}
                                        </span>
                                    @endif

                                    <div class="mt-4 flex items-baseline gap-2">
                                        <span class="text-xs font-bold text-slate-400">@</span>
                                        <p class="font-black text-slate-900 text-lg">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="mt-4 sm:mt-0 flex flex-row sm:flex-col items-center sm:items-end justify-between gap-4">
                                    <!-- Qty Control -->
                                    <div class="flex items-center bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-1">
                                        <button wire:click="kurangJumlah({{ $item->id }})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all active:scale-90">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                                        </button>
                                        <span class="w-8 text-center text-sm font-black text-slate-900">{{ $item->jumlah }}</span>
                                        <button wire:click="tambahJumlah({{ $item->id }})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-emerald-500 hover:bg-emerald-50 rounded-xl transition-all active:scale-90">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </div>

                                    <!-- Delete -->
                                    <button wire:click="hapusItem({{ $item->id }})" class="group/del flex items-center gap-2 text-[10px] font-bold text-slate-400 hover:text-rose-500 transition-colors uppercase tracking-widest">
                                        <span class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover/del:bg-rose-50 group-hover/del:text-rose-500 transition-colors">
                                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </span>
                                        <span class="hidden sm:inline">Hapus</span>
                                    </button>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="flex justify-end">
                    <button wire:click="bersihkanKeranjang" class="flex items-center gap-2 px-6 py-3 rounded-2xl text-xs font-bold text-rose-500 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-all uppercase tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Kosongkan Keranjang
                    </button>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-4 mt-8 lg:mt-0">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 p-8 sticky top-32 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-6 opacity-5 pointer-events-none">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>

                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6">Ringkasan</h2>

                    <div class="flow-root">
                        <dl class="-my-4 divide-y divide-slate-50 text-sm">
                            <div class="py-4 flex items-center justify-between">
                                <dt class="text-slate-500 font-bold">Subtotal</dt>
                                <dd class="font-black text-slate-900">Rp {{ number_format($this->totalHarga, 0, ',', '.') }}</dd>
                            </div>
                            <div class="py-4 flex items-center justify-between">
                                <dt class="text-slate-500 font-bold">Pajak (PPN 11%)</dt>
                                <dd class="font-black text-emerald-600 text-xs uppercase bg-emerald-50 px-2 py-1 rounded-lg">Termasuk</dd>
                            </div>
                            <div class="py-4 flex items-center justify-between">
                                <dt class="text-slate-500 font-bold">Pengiriman</dt>
                                <dd class="text-slate-400 text-xs italic font-medium">Hitung di Checkout</dd>
                            </div>
                            <div class="py-6 flex items-center justify-between border-t-2 border-slate-100 mt-4">
                                <dt class="text-base font-black text-slate-900 uppercase tracking-tight">Total Sementara</dt>
                                <dd class="text-2xl font-black text-indigo-600">Rp {{ number_format($this->totalHarga, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-8 space-y-4">
                        <a href="{{ route('checkout') }}" class="w-full flex items-center justify-center rounded-2xl border border-transparent bg-slate-900 px-6 py-4 text-xs font-black text-white shadow-xl shadow-slate-900/20 hover:bg-indigo-600 hover:shadow-indigo-500/30 transition-all uppercase tracking-[0.2em] group">
                            Checkout Sekarang
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="{{ route('katalog') }}" class="w-full flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-4 text-xs font-black text-slate-600 shadow-sm hover:bg-slate-50 hover:text-slate-900 transition-all uppercase tracking-[0.2em]">
                            Lanjut Belanja
                        </a>
                    </div>
                    
                    <div class="mt-8 flex items-center justify-center gap-2 text-slate-400 bg-slate-50 py-3 rounded-xl border border-slate-100">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Transaksi Aman SSL</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Cross Selling -->
        <div class="mt-24 border-t border-slate-200 pt-16">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-8 uppercase flex items-center gap-3">
                <span class="w-8 h-1 bg-indigo-600 rounded-full"></span>
                Rekomendasi Untuk Anda
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($this->rekomendasi as $rek)
                <a href="{{ route('produk.detail', $rek->slug) }}" class="group bg-white rounded-[2.5rem] p-4 border border-slate-100 hover:shadow-2xl hover:shadow-indigo-500/10 hover:border-indigo-100 transition-all duration-300 flex flex-col h-full hover:-translate-y-2">
                    <div class="bg-slate-50 rounded-[2rem] aspect-[4/3] mb-4 overflow-hidden flex items-center justify-center p-6 group-hover:bg-indigo-50/30 transition-colors">
                        <img src="{{ $rek->gambar_utama_url }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500 mix-blend-multiply">
                    </div>
                    <div class="px-2 pb-2">
                        <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-1">{{ $rek->kategori->nama ?? 'Produk' }}</p>
                        <h3 class="font-bold text-slate-900 group-hover:text-indigo-600 truncate transition-colors text-sm mb-2">{{ $rek->nama }}</h3>
                        <div class="flex items-center justify-between mt-auto">
                            <p class="text-base font-black text-slate-900">{{ $rek->harga_rupiah }}</p>
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        @else
        <div class="flex flex-col items-center justify-center py-32 text-center bg-white rounded-[3rem] border border-dashed border-slate-200 relative overflow-hidden">
            <div class="absolute inset-0 bg-slate-50/50 pattern-grid opacity-20"></div>
            <div class="relative z-10">
                <div class="w-32 h-32 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner animate-pulse">
                    <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight mb-3">Keranjang Masih Kosong</h2>
                <p class="text-slate-500 mb-10 max-w-md mx-auto font-medium leading-relaxed">Wah, keranjangmu sepi banget nih. Yuk isi dengan gadget impianmu dan rasakan kecanggihannya!</p>
                <a href="{{ route('katalog') }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-10 py-4 text-xs font-black text-white shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 hover:scale-105 transition-all uppercase tracking-[0.2em]">
                    Mulai Belanja
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
