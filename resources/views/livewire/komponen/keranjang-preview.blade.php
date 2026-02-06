<div 
    x-data="{ open: @entangle('isOpen') }"
    x-show="open"
    @open-slide-over.window="if ($event.detail.id === 'keranjang-preview') open = true"
    @keydown.window.escape="open = false"
    class="relative z-[100]"
    style="display: none;"
>
    <!-- Blur Backdrop -->
    <div 
        x-show="open"
        x-transition:enter="ease-in-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" 
        @click="open = false"
    ></div>

    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
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
                    <div class="flex h-full flex-col bg-white shadow-2xl border-l border-white/50">
                        
                        <!-- Header -->
                        <div class="bg-white/80 backdrop-blur-xl px-6 py-6 border-b border-slate-100 sticky top-0 z-10">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-tighter">Keranjang</h2>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Ringkasan Pesanan</p>
                                </div>
                                <button type="button" class="p-2 bg-slate-50 text-slate-400 hover:text-rose-500 rounded-xl transition-all hover:rotate-90" @click="open = false">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 overflow-y-auto px-6 py-6 bg-slate-50/50">
                            @if($items->count() > 0)
                                <ul role="list" class="space-y-6">
                                    @foreach($items as $item)
                                    <li class="group flex gap-4 bg-white p-4 rounded-[24px] border border-slate-100 shadow-sm hover:shadow-md transition-all">
                                        <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-2xl border border-slate-50 bg-slate-50 p-2 flex items-center justify-center">
                                            <img src="{{ $item->produk->gambar_utama_url }}" class="h-full w-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500">
                                        </div>

                                        <div class="flex flex-1 flex-col justify-between">
                                            <div>
                                                <div class="flex justify-between items-start">
                                                    <h3 class="font-bold text-slate-900 text-sm line-clamp-2 leading-tight">
                                                        <a href="/produk/{{ $item->produk->slug }}" class="hover:text-indigo-600 transition-colors">{{ $item->produk->nama }}</a>
                                                    </h3>
                                                    <p class="ml-4 font-black text-slate-900 text-sm tracking-tight">Rp {{ number_format($item->produk->harga_jual * $item->jumlah, 0, ',', '.') }}</p>
                                                </div>
                                                <p class="mt-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $item->produk->kategori->nama }}</p>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <div class="flex items-center gap-2 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">
                                                    <span class="text-[10px] font-black text-slate-400 uppercase">Qty</span>
                                                    <span class="font-bold text-slate-700">{{ $item->jumlah }}</span>
                                                </div>

                                                <button wire:click="hapusItem({{ $item->id }})" type="button" class="font-bold text-rose-400 hover:text-rose-600 text-[10px] uppercase tracking-widest bg-rose-50 px-3 py-1.5 rounded-lg hover:bg-rose-100 transition-colors">Hapus</button>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="h-full flex flex-col items-center justify-center text-center space-y-6 opacity-60">
                                    <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-slate-900 font-black uppercase tracking-widest text-sm">Keranjang Kosong</p>
                                        <p class="text-slate-500 text-xs mt-1">Belum ada unit teknologi yang ditambahkan.</p>
                                    </div>
                                    <button @click="open = false" class="px-6 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 uppercase tracking-widest hover:bg-slate-50 transition-all">
                                        Mulai Belanja
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Footer -->
                        @if($items->count() > 0)
                        <div class="border-t border-slate-100 px-6 py-6 bg-white safe-area-pb">
                            <div class="flex justify-between text-base font-black text-slate-900 mb-4">
                                <p class="uppercase tracking-widest text-xs text-slate-400 self-center">Subtotal Estimasi</p>
                                <p class="text-2xl tracking-tighter text-indigo-600">Rp {{ number_format($total, 0, ',', '.') }}</p>
                            </div>
                            <div class="space-y-3">
                                <a href="{{ route('checkout') }}" class="flex items-center justify-center w-full rounded-2xl bg-indigo-600 px-6 py-4 text-xs font-black text-white shadow-xl shadow-indigo-600/20 hover:bg-indigo-700 hover:scale-[1.02] active:scale-95 uppercase tracking-[0.2em] transition-all">
                                    Checkout Prioritas
                                </a>
                                <a href="{{ route('keranjang') }}" class="flex items-center justify-center w-full rounded-2xl bg-white border border-slate-200 px-6 py-4 text-xs font-black text-slate-600 hover:bg-slate-50 uppercase tracking-[0.2em] transition-all">
                                    Lihat Detail Penuh
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>