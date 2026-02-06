<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tighter mb-8 flex items-center gap-3">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            Keranjang Belanja
        </h1>

        @if($this->items->count() > 0)
        <div class="lg:grid lg:grid-cols-12 lg:gap-12 lg:items-start">
            <!-- Cart Items -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden mb-8">
                    <ul role="list" class="divide-y divide-slate-100">
                        @foreach($this->items as $item)
                        <li class="p-6 sm:p-8 flex flex-col sm:flex-row gap-6 hover:bg-slate-50/50 transition-colors">
                            <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-2xl border border-slate-100 bg-slate-50 p-2 flex items-center justify-center">
                                <img src="{{ $item->produk->gambar_utama_url }}" class="h-full w-full object-contain mix-blend-multiply">
                            </div>

                            <div class="flex-1 flex flex-col sm:flex-row justify-between">
                                <div>
                                    <div class="flex justify-between">
                                        <h3 class="text-lg font-bold text-slate-900">
                                            <a href="{{ route('produk.detail', $item->produk->slug) }}" class="hover:text-indigo-600 transition-colors">{{ $item->produk->nama }}</a>
                                        </h3>
                                    </div>
                                    <p class="mt-1 text-xs font-black text-slate-400 uppercase tracking-widest">{{ $item->produk->kategori->nama }}</p>
                                    
                                    @if($item->varian)
                                        <span class="inline-flex items-center gap-1 mt-2 px-2.5 py-0.5 rounded-lg bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase tracking-widest border border-indigo-100">
                                            {{ $item->varian->nama_varian }}
                                        </span>
                                    @endif

                                    <p class="mt-4 font-black text-slate-900">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                                </div>

                                <div class="mt-4 sm:mt-0 sm:pr-9 flex flex-row sm:flex-col items-center sm:items-end justify-between">
                                    <div class="flex items-center border border-slate-200 rounded-xl bg-white shadow-sm">
                                        <button wire:click="kurangJumlah({{ $item->id }})" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                        </button>
                                        <span class="px-2 text-sm font-bold text-slate-900 w-8 text-center">{{ $item->jumlah }}</span>
                                        <button wire:click="tambahJumlah({{ $item->id }})" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </div>

                                    <div class="absolute top-0 right-0 p-6 hidden sm:block">
                                        <button wire:click="hapusItem({{ $item->id }})" class="text-slate-300 hover:text-rose-500 transition-colors">
                                            <span class="sr-only">Remove</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </div>
                                    <!-- Mobile Remove -->
                                    <button wire:click="hapusItem({{ $item->id }})" class="text-xs font-bold text-rose-500 uppercase tracking-widest sm:hidden hover:bg-rose-50 px-3 py-2 rounded-lg transition-colors">Hapus</button>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <button wire:click="bersihkanKeranjang" class="text-xs font-bold text-slate-400 hover:text-rose-500 transition-colors uppercase tracking-widest">
                    Kosongkan Keranjang
                </button>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-4 mt-8 lg:mt-0">
                <div class="bg-white rounded-[32px] border border-slate-100 shadow-lg shadow-indigo-500/5 p-6 sm:p-8 sticky top-32">
                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6">Ringkasan Pesanan</h2>

                    <div class="flow-root">
                        <dl class="-my-4 divide-y divide-slate-100 text-sm">
                            <div class="py-4 flex items-center justify-between">
                                <dt class="text-slate-600 font-bold">Subtotal</dt>
                                <dd class="font-black text-slate-900">Rp {{ number_format($this->totalHarga, 0, ',', '.') }}</dd>
                            </div>
                            <div class="py-4 flex items-center justify-between">
                                <dt class="text-slate-600 font-bold">Pajak (PPN 11%)</dt>
                                <dd class="font-black text-slate-900">Termasuk</dd>
                            </div>
                            <div class="py-4 flex items-center justify-between">
                                <dt class="text-slate-600 font-bold">Estimasi Pengiriman</dt>
                                <dd class="text-slate-400 text-xs italic">Dihitung saat checkout</dd>
                            </div>
                            <div class="py-4 flex items-center justify-between border-t-2 border-slate-100 pt-4">
                                <dt class="text-base font-black text-slate-900 uppercase tracking-tight">Total</dt>
                                <dd class="text-xl font-black text-indigo-600">Rp {{ number_format($this->totalHarga, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-8 space-y-4">
                        <a href="{{ route('checkout') }}" class="w-full flex items-center justify-center rounded-2xl border border-transparent bg-slate-900 px-6 py-4 text-sm font-black text-white shadow-xl hover:bg-indigo-600 hover:shadow-indigo-600/30 transition-all uppercase tracking-widest">
                            Lanjut ke Pembayaran
                        </a>
                        <a href="{{ route('katalog') }}" class="w-full flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-4 text-xs font-black text-slate-600 shadow-sm hover:bg-slate-50 transition-all uppercase tracking-widest">
                            Lanjut Belanja
                        </a>
                    </div>
                    
                    <div class="mt-6 flex items-center justify-center gap-2 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Pembayaran Aman Terenkripsi</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Cross Selling -->
        <div class="mt-24 border-t border-slate-200 pt-16">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-8">Anda Mungkin Juga Suka</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($this->rekomendasi as $rek)
                <a href="{{ route('produk.detail', $rek->slug) }}" class="group bg-white rounded-[32px] p-4 border border-slate-100 hover:shadow-xl transition-all">
                    <div class="bg-slate-50 rounded-[24px] aspect-[4/3] mb-4 overflow-hidden flex items-center justify-center p-4">
                        <img src="{{ $rek->gambar_utama_url }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform">
                    </div>
                    <h3 class="font-bold text-slate-900 group-hover:text-indigo-600 truncate">{{ $rek->nama }}</h3>
                    <p class="text-sm font-black text-slate-900 mt-1">{{ $rek->harga_rupiah }}</p>
                </a>
                @endforeach
            </div>
        </div>

        @else
        <div class="text-center py-24 bg-white rounded-[40px] border border-dashed border-slate-200">
            <div class="w-32 h-32 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight mb-2">Keranjang Belanja Kosong</h2>
            <p class="text-slate-500 mb-8 max-w-md mx-auto">Tampaknya Anda belum menambahkan unit apapun. Mulai eksplorasi teknologi masa depan sekarang.</p>
            <a href="{{ route('katalog') }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-8 py-4 text-sm font-black text-white shadow-xl hover:bg-indigo-700 transition-all uppercase tracking-widest">
                Jelajahi Katalog
            </a>
        </div>
        @endif
    </div>
</div>
