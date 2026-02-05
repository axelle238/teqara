<div>
    <!-- Hero Section -->
    <div class="relative bg-slate-900 text-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-cyan-900/40 to-slate-900/90 z-10"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center opacity-30"></div>
        
        <div class="relative z-20 mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8 lg:py-32">
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl mb-6">
                Teknologi Masa Depan <br>
                <span class="text-cyan-400">Dalam Genggaman</span>
            </h1>
            <p class="mt-4 max-w-2xl text-xl text-slate-300 mb-8">
                Temukan komputer, laptop, dan gadget performa tinggi untuk kebutuhan gaming, kreatif, dan profesional Anda di Teqara.
            </p>
            <div class="flex gap-4">
                <a href="/katalog" class="rounded-lg bg-cyan-600 px-6 py-3 text-base font-semibold text-white shadow-lg shadow-cyan-900/50 hover:bg-cyan-500 transition">
                    Belanja Sekarang
                </a>
                <a href="#kategori" class="rounded-lg bg-white/10 px-6 py-3 text-base font-semibold text-white backdrop-blur-sm hover:bg-white/20 transition">
                    Lihat Kategori
                </a>
            </div>
        </div>
    </div>

    <!-- Kategori Section -->
    <section id="kategori" class="py-16 bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 mb-8">Kategori Pilihan</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($kategori as $kat)
                <a href="/katalog?kategori={{ $kat->slug }}" class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm hover:shadow-md transition border border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <span class="h-10 w-10 rounded-full bg-cyan-50 flex items-center justify-center text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white transition">
                            <!-- Icon Placeholder (bisa diganti icon library) -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        </span>
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-cyan-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 group-hover:text-cyan-600 transition">{{ $kat->nama }}</h3>
                    <p class="text-sm text-slate-500 mt-1">Lihat Produk</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Produk Terbaru Section -->
    <section class="py-16 bg-white border-t border-slate-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Produk Terbaru</h2>
                <a href="/katalog" class="text-sm font-semibold text-cyan-600 hover:text-cyan-700">Lihat Semua &rarr;</a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($produkTerbaru as $produk)
                <div class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white hover:shadow-lg transition">
                    <!-- Image -->
                    <div class="aspect-h-3 aspect-w-4 bg-slate-200 sm:aspect-none group-hover:opacity-75 sm:h-60 relative overflow-hidden">
                        <img src="{{ $produk->gambar_utama }}" alt="{{ $produk->nama }}" class="h-full w-full object-cover object-center sm:h-full sm:w-full transition duration-300 group-hover:scale-105">
                        <!-- Badge Stok -->
                        @if($produk->stok < 5)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">Sisa {{ $produk->stok }}</span>
                        @endif
                    </div>
                    
                    <!-- Content -->
                    <div class="flex flex-1 flex-col p-4">
                        <div class="flex-1">
                            <p class="text-xs font-medium text-cyan-600 mb-1">{{ $produk->kategori->nama }}</p>
                            <h3 class="text-sm font-bold text-slate-900">
                                <a href="/produk/{{ $produk->slug }}">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $produk->nama }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-slate-500 line-clamp-2">{{ strip_tags($produk->deskripsi_singkat) }}</p>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <p class="text-lg font-bold text-slate-900">{{ $produk->harga_rupiah }}</p>
                            <button class="rounded-full bg-slate-100 p-2 text-slate-600 hover:bg-cyan-600 hover:text-white transition z-10 relative">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Grid (Asli) -->
    <div class="py-12 bg-slate-50 border-t border-slate-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-4">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-100 text-cyan-600 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Produk Resmi</h3>
                    <p class="mt-2 text-slate-500">Jaminan produk 100% original dan bergaransi resmi distributor Indonesia.</p>
                </div>
                <div class="p-4">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-100 text-cyan-600 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Pengiriman Cepat</h3>
                    <p class="mt-2 text-slate-500">Proses packing aman dan pengiriman instan tersedia untuk wilayah tertentu.</p>
                </div>
                <div class="p-4">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-100 text-cyan-600 mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Dukungan 24/7</h3>
                    <p class="mt-2 text-slate-500">Tim teknis kami siap membantu konsultasi spesifikasi sebelum Anda membeli.</p>
                </div>
            </div>
        </div>
    </div>
</div>