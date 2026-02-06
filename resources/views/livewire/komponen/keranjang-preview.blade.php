<div 
    x-data="{ open: @entangle('isOpen') }"
    x-show="open"
    @keydown.window.escape="open = false"
    class="relative z-50"
    style="display: none;"
>
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" @click="open = false"></div>

    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
        <div 
            x-show="open"
            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="pointer-events-auto w-screen max-w-md"
        >
            <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                    <div class="flex items-start justify-between">
                        <h2 class="text-lg font-black text-slate-900 uppercase tracking-widest">Keranjang Belanja</h2>
                        <div class="ml-3 flex h-7 items-center">
                            <button type="button" class="relative -m-2 p-2 text-slate-400 hover:text-slate-500" @click="open = false">
                                <span class="sr-only">Close panel</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="flow-root">
                            <ul role="list" class="-my-6 divide-y divide-slate-100">
                                @forelse($items as $item)
                                <li class="flex py-6">
                                    <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-xl border border-slate-100 bg-slate-50 p-2">
                                        <img src="{{ $item->produk->gambar_utama_url }}" class="h-full w-full object-contain object-center">
                                    </div>

                                    <div class="ml-4 flex flex-1 flex-col">
                                        <div>
                                            <div class="flex justify-between text-base font-bold text-slate-900">
                                                <h3 class="line-clamp-2 leading-tight">
                                                    <a href="#">{{ $item->produk->nama }}</a>
                                                </h3>
                                                <p class="ml-4">Rp {{ number_format($item->produk->harga_jual * $item->jumlah, 0, ',', '.') }}</p>
                                            </div>
                                            <p class="mt-1 text-sm text-slate-500">{{ $item->produk->kategori->nama }}</p>
                                        </div>
                                        <div class="flex flex-1 items-end justify-between text-sm">
                                            <p class="text-slate-500 font-bold">Qty {{ $item->jumlah }}</p>

                                            <button wire:click="hapusItem({{ $item->id }})" type="button" class="font-bold text-rose-500 hover:text-rose-400 text-xs uppercase tracking-widest">Hapus</button>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <li class="py-20 text-center">
                                    <p class="text-slate-400 font-bold uppercase text-xs tracking-widest">Keranjang Kosong</p>
                                </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 px-4 py-6 sm:px-6 bg-slate-50">
                    <div class="flex justify-between text-base font-black text-slate-900">
                        <p>Subtotal</p>
                        <p>Rp {{ number_format($total, 0, ',', '.') }}</p>
                    </div>
                    <p class="mt-0.5 text-xs text-slate-500">Ongkir dihitung saat checkout.</p>
                    <div class="mt-6">
                        <a href="{{ route('checkout') }}" class="flex items-center justify-center rounded-2xl border border-transparent bg-indigo-600 px-6 py-4 text-xs font-black text-white shadow-xl hover:bg-indigo-700 uppercase tracking-[0.2em] transition-all">Checkout Sekarang</a>
                    </div>
                    <div class="mt-6 flex justify-center text-center text-xs text-slate-500">
                        <p>
                            atau
                            <button type="button" class="font-bold text-indigo-600 hover:text-indigo-500" @click="open = false">
                                Lanjut Belanja
                                <span aria-hidden="true"> &rarr;</span>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
