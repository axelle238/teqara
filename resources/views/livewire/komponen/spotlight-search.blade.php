<div 
    x-data="{ 
        pencarianTerbuka: false,
        toggle() { this.pencarianTerbuka = !this.pencarianTerbuka },
        close() { this.pencarianTerbuka = false }
    }"
    @keydown.escape.window="close()"
    @open-search.window="pencarianTerbuka = true"
>
    <!-- Trigger Button (Navbar) -->
    <button @click="toggle()" class="p-2.5 text-slate-500 hover:bg-slate-100 rounded-xl transition-all">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    </button>

    <!-- Full Screen Overlay -->
    <div 
        x-show="pencarianTerbuka" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] bg-white/95 backdrop-blur-xl flex flex-col items-center pt-20 px-4"
        style="display: none;"
    >
        <button @click="close()" class="absolute top-8 right-8 p-3 text-slate-400 hover:text-slate-900 transition-colors">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="w-full max-w-3xl" @click.away="close()">
            <input 
                wire:model.live.debounce.300ms="query" 
                type="text" 
                placeholder="Ketik produk, kategori, atau merek..." 
                class="w-full bg-transparent border-none border-b-4 border-cyan-500 text-4xl sm:text-5xl font-black text-slate-900 placeholder:text-slate-200 focus:ring-0 transition-all mb-12"
                autofocus
            >
            
            @if(strlen($query) >= 2)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-h-[60vh] overflow-y-auto">
                    <!-- Hasil Produk -->
                    <div>
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">Produk Ditemukan</h3>
                        @if(count($hasilProduk) > 0)
                            <div class="space-y-4">
                                @foreach($hasilProduk as $p)
                                <a href="/produk/{{ $p->slug }}" class="flex items-center gap-4 group p-2 hover:bg-slate-50 rounded-xl transition">
                                    <img src="{{ $p->gambar_utama_url }}" class="w-12 h-12 rounded-lg object-cover bg-white border border-slate-100">
                                    <div>
                                        <h4 class="font-bold text-slate-900 group-hover:text-cyan-600 transition">{{ $p->nama }}</h4>
                                        <p class="text-xs text-slate-500">{{ 'Rp ' . number_format($p->harga_jual, 0, ',', '.') }}</p>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-slate-400 italic">Tidak ada produk yang cocok.</p>
                        @endif
                    </div>

                    <!-- Hasil Kategori & Merek -->
                    <div>
                        <div class="mb-8">
                            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">Kategori</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($hasilKategori as $k)
                                <a href="/katalog?kategori={{ $k->slug }}" class="px-4 py-2 bg-slate-50 hover:bg-cyan-500 hover:text-white rounded-xl text-sm font-bold transition-all border border-slate-100">
                                    {{ $k->nama }}
                                </a>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">Merek</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($hasilMerek as $m)
                                <a href="/katalog?merek={{ $m->slug }}" class="px-4 py-2 bg-slate-50 hover:bg-indigo-500 hover:text-white rounded-xl text-sm font-bold transition-all border border-slate-100">
                                    {{ $m->nama }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Default View (Trending) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div>
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">Pencarian Populer</h3>
                        <div class="flex flex-wrap gap-2">
                            <button wire:click="$set('query', 'Laptop')" class="px-4 py-2 bg-slate-50 hover:bg-slate-100 rounded-xl text-sm font-bold transition text-slate-600">Laptop Gaming</button>
                            <button wire:click="$set('query', 'iPhone')" class="px-4 py-2 bg-slate-50 hover:bg-slate-100 rounded-xl text-sm font-bold transition text-slate-600">iPhone 15</button>
                            <button wire:click="$set('query', 'Keyboard')" class="px-4 py-2 bg-slate-50 hover:bg-slate-100 rounded-xl text-sm font-bold transition text-slate-600">Mechanical Keyboard</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
