<div class="bg-slate-50 min-h-screen py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-black text-slate-900 tracking-tighter mb-8 flex items-center gap-3">
            <span class="text-pink-500">❤️</span> Daftar Keinginan Saya
        </h1>

        @if($wishlist->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($wishlist as $p)
            <div class="group relative flex flex-col bg-white rounded-3xl border border-slate-200 p-4 hover:shadow-xl hover:shadow-pink-500/10 transition-all duration-500">
                <!-- Hapus Button -->
                <button wire:click="hapus({{ $p->id }})" class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div class="relative aspect-square rounded-2xl overflow-hidden bg-slate-50 mb-4">
                    <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain p-6 transform group-hover:scale-110 transition-transform duration-700">
                </div>

                <div class="px-2 flex-1 flex flex-col">
                    <p class="text-[10px] font-black text-cyan-600 uppercase tracking-widest mb-1">{{ $p->kategori->nama }}</p>
                    <h4 class="text-base font-bold text-slate-900 leading-snug mb-2 line-clamp-2">
                        <a href="/produk/{{ $p->slug }}" wire:navigate class="hover:text-cyan-600 transition">{{ $p->nama }}</a>
                    </h4>
                    
                    <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                        <p class="text-lg font-black text-slate-900">{{ 'Rp ' . number_format($p->harga_jual/1000, 0) . 'k' }}</p>
                        <a href="/produk/{{ $p->slug }}" wire:navigate class="px-4 py-2 bg-slate-900 text-white text-xs font-bold rounded-lg hover:bg-cyan-600 transition shadow-lg shadow-slate-900/20">
                            Lihat
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-24 bg-white rounded-[32px] border border-dashed border-slate-200">
            <div class="text-6xl mb-6 grayscale opacity-20">🎁</div>
            <h3 class="text-xl font-black text-slate-900 mb-2">Daftar Keinginan Kosong</h3>
            <p class="text-slate-500 font-medium mb-8">Simpan barang impian Anda di sini untuk dibeli nanti.</p>
            <a href="/katalog" wire:navigate class="px-8 py-3 bg-cyan-600 text-white rounded-xl font-bold hover:bg-cyan-700 transition shadow-lg shadow-cyan-600/20">
                Jelajahi Katalog
            </a>
        </div>
        @endif
    </div>
</div>
