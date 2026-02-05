<div class="bg-white min-h-screen py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm font-medium text-slate-500">
            <a href="/" wire:navigate class="hover:text-cyan-600 transition">Beranda</a>
            <span class="mx-2">/</span>
            <a href="/katalog" wire:navigate class="hover:text-cyan-600 transition">Katalog</a>
            <span class="mx-2">/</span>
            <a href="/katalog?kategori={{ $produk->kategori->slug }}" wire:navigate class="hover:text-cyan-600 transition">{{ $produk->kategori->nama }}</a>
            <span class="mx-2">/</span>
            <span class="text-slate-900 truncate max-w-xs">{{ $produk->nama }}</span>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
            
            <!-- Gallery (Kiri) -->
            <div class="flex flex-col-reverse">
                <!-- Image Selector (Hidden for now, single image) -->
                <!-- Main Image -->
                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-2xl bg-slate-100 border border-slate-200">
                    <img src="{{ $produk->gambar_utama }}" alt="{{ $produk->nama }}" class="h-full w-full object-cover object-center transform hover:scale-105 transition duration-500">
                </div>
            </div>

            <!-- Product Info (Kanan) -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                
                <!-- Brand & Name -->
                <div class="mb-4">
                    @if($produk->merek)
                    <a href="/katalog?merek={{ $produk->merek->slug }}" class="text-sm font-semibold text-cyan-600 uppercase tracking-wide hover:underline">
                        {{ $produk->merek->nama }}
                    </a>
                    @endif
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900 mt-1">{{ $produk->nama }}</h1>
                </div>

                <!-- Price & Stock -->
                <div class="mb-6">
                    <p class="text-3xl font-bold text-slate-900">{{ $produk->harga_rupiah }}</p>
                    <div class="mt-2 flex items-center space-x-2">
                        @if($produk->stok > 0)
                            <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                Stok Tersedia ({{ $produk->stok }})
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                Stok Habis
                            </span>
                        @endif
                        <span class="text-slate-300">|</span>
                        <span class="text-sm text-slate-500">SKU: {{ $produk->sku }}</span>
                    </div>
                </div>

                <!-- Short Description -->
                <div class="prose prose-sm text-slate-500 mb-8">
                    {!! $produk->deskripsi_singkat !!}
                </div>

                <!-- Actions -->
                @if($produk->stok > 0)
                <div class="border-t border-b border-slate-200 py-6 mb-8">
                    <div class="flex items-center gap-4">
                        <label class="text-sm font-medium text-slate-700">Jumlah:</label>
                        <div class="flex items-center border border-slate-300 rounded-lg">
                            <button wire:click="kurangJumlah" class="px-3 py-2 text-slate-600 hover:bg-slate-100 transition rounded-l-lg disabled:opacity-50" @if($jumlah <= 1) disabled @endif>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                            </button>
                            <span class="w-12 text-center text-slate-900 font-medium">{{ $jumlah }}</span>
                            <button wire:click="tambahJumlah" class="px-3 py-2 text-slate-600 hover:bg-slate-100 transition rounded-r-lg disabled:opacity-50" @if($jumlah >= $produk->stok) disabled @endif>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button wire:click="tambahKeKeranjang" class="flex-1 bg-cyan-600 border border-transparent rounded-xl py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition shadow-lg shadow-cyan-900/20">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Tambah ke Keranjang
                    </button>
                    <!-- Wishlist Button (Future) -->
                    <button class="flex-none bg-white border border-slate-300 rounded-xl py-3 px-4 flex items-center justify-center text-slate-400 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                @else
                <div class="rounded-lg bg-slate-50 p-4 border border-slate-200">
                    <p class="text-sm text-slate-500 text-center">Produk ini sedang tidak tersedia. Silakan cek kembali nanti.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Detail Tabs / Description -->
        <div class="mt-16 border-t border-slate-200 pt-10">
            <h3 class="text-lg font-bold text-slate-900 mb-6">Deskripsi Produk</h3>
            <div class="prose prose-slate max-w-none text-slate-600">
                {!! $produk->deskripsi_lengkap !!}
            </div>
        </div>

    </div>
</div>
