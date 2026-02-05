<div class="bg-slate-50 min-h-screen py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-slate-900 mb-8">Keranjang Belanja</h1>

        @if($this->items->count() > 0)
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
            <!-- Daftar Item -->
            <div class="lg:col-span-8">
                <ul class="divide-y divide-slate-200 border-t border-b border-slate-200 bg-white rounded-xl overflow-hidden px-4 sm:px-6 shadow-sm">
                    @foreach($this->items as $item)
                    <li class="flex py-6 sm:py-10">
                        <div class="flex-shrink-0">
                            <img src="{{ $item->produk->gambar_utama }}" alt="{{ $item->produk->nama }}" class="h-24 w-24 rounded-lg object-cover object-center sm:h-32 sm:w-32 border border-slate-100">
                        </div>

                        <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                            <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                <div>
                                    <div class="flex justify-between">
                                        <h3 class="text-sm">
                                            <a href="/produk/{{ $item->produk->slug }}" wire:navigate class="font-bold text-slate-900 hover:text-cyan-600">
                                                {{ $item->produk->nama }}
                                            </a>
                                        </h3>
                                    </div>
                                    <p class="mt-1 text-sm text-slate-500">{{ $item->produk->kategori->nama }}</p>
                                    <p class="mt-1 text-sm font-bold text-slate-900">{{ 'Rp ' . number_format($item->produk->harga_jual, 0, ',', '.') }}</p>
                                </div>

                                <div class="mt-4 sm:mt-0 sm:pr-9">
                                    <div class="flex items-center border border-slate-300 rounded-lg w-fit">
                                        <button wire:click="kurangJumlah({{ $item->id }})" class="px-2 py-1 text-slate-600 hover:bg-slate-100 transition rounded-l-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                        </button>
                                        <span class="w-10 text-center text-sm font-bold text-slate-900">{{ $item->jumlah }}</span>
                                        <button wire:click="tambahJumlah({{ $item->id }})" class="px-2 py-1 text-slate-600 hover:bg-slate-100 transition rounded-r-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </div>

                                    <div class="absolute top-0 right-0">
                                        <button wire:click="hapusItem({{ $item->id }})" class="-m-2 inline-flex p-2 text-slate-400 hover:text-red-500 transition">
                                            <span class="sr-only">Hapus</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <p class="mt-4 flex space-x-2 text-sm text-slate-700">
                                <svg class="h-5 w-5 flex-shrink-0 text-emerald-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span>Subtotal: <span class="font-bold text-slate-900">{{ 'Rp ' . number_format($item->produk->harga_jual * $item->jumlah, 0, ',', '.') }}</span></span>
                            </p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Ringkasan -->
            <div class="mt-16 lg:mt-0 lg:col-span-4">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-6">Ringkasan Belanja</h2>
                    <div class="flow-root">
                        <dl class="-my-4 divide-y divide-slate-100 text-sm">
                            <div class="flex items-center justify-between py-4">
                                <dt class="text-slate-600">Total Harga ({{ $this->items->sum('jumlah') }} item)</dt>
                                <dd class="font-medium text-slate-900">{{ 'Rp ' . number_format($this->total_harga, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex items-center justify-between py-4">
                                <dt class="text-slate-600">Biaya Pengiriman</dt>
                                <dd class="font-medium text-slate-900 text-emerald-600 uppercase text-xs">Gratis</dd>
                            </div>
                            <div class="flex items-center justify-between py-4 pt-6">
                                <dt class="text-base font-bold text-slate-900">Total Tagihan</dt>
                                <dd class="text-base font-bold text-cyan-600">{{ 'Rp ' . number_format($this->total_harga, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-8">
                        <a href="/checkout" wire:navigate class="w-full flex items-center justify-center rounded-xl bg-cyan-600 px-6 py-3 text-base font-bold text-white shadow-lg shadow-cyan-900/20 hover:bg-cyan-700 transition">
                            Lanjut ke Checkout
                        </a>
                        <p class="mt-4 text-center text-xs text-slate-500">
                            Pajak dan biaya lainnya dihitung saat checkout.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-20 bg-white rounded-2xl border border-dashed border-slate-300">
            <div class="mx-auto h-16 w-16 text-slate-300 mb-4">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900">Keranjang Anda Kosong</h3>
            <p class="mt-2 text-slate-500">Sepertinya Anda belum menambahkan produk apapun ke keranjang.</p>
            <div class="mt-8">
                <a href="/katalog" wire:navigate class="inline-flex items-center rounded-xl bg-cyan-600 px-6 py-3 text-sm font-bold text-white hover:bg-cyan-700 transition">
                    Mulai Belanja
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
