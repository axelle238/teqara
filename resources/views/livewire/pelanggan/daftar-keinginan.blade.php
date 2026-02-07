<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row items-center justify-between mb-12 gap-6 animate-fade-in-down">
            <div class="text-center sm:text-left">
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Daftar <span class="text-indigo-600">Keinginan</span></h1>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-2">Koleksi Produk Favorit Anda</p>
            </div>
            <a href="{{ route('katalog') }}" class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 hover:text-indigo-600 transition-all shadow-sm group">
                Lanjut Belanja
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

        @if($this->wishlist->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($this->wishlist as $p)
            <div class="group relative bg-white rounded-[2.5rem] p-6 border border-slate-100 hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-500 animate-fade-in-up">
                
                <!-- Remove Button -->
                <button wire:click="hapus({{ $p->id }})" class="absolute top-6 right-6 z-20 w-10 h-10 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-slate-400 hover:bg-rose-50 hover:text-rose-500 border border-slate-100 transition-all shadow-sm" title="Hapus dari Wishlist">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <a href="{{ route('produk.detail', $p->slug) }}" class="block relative z-10">
                    <div class="aspect-[4/5] bg-slate-50 rounded-[2rem] mb-6 overflow-hidden flex items-center justify-center p-8 group-hover:bg-indigo-50/20 transition-colors relative">
                        <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700 mix-blend-multiply">
                        
                        @if($p->stok <= 0)
                            <div class="absolute inset-0 bg-white/50 backdrop-blur-[2px] flex items-center justify-center">
                                <span class="bg-slate-900 text-white px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest">Stok Habis</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex justify-between items-start">
                            <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest bg-indigo-50 px-2 py-1 rounded-md">{{ $p->kategori->nama }}</p>
                            @if($p->rating_rata_rata > 0)
                                <div class="flex items-center gap-1 text-[10px] font-bold text-amber-500">
                                    <span>★</span> {{ $p->rating_rata_rata }}
                                </div>
                            @endif
                        </div>
                        
                        <h3 class="font-black text-slate-900 text-base leading-tight line-clamp-2 min-h-[2.5em] group-hover:text-indigo-600 transition-colors">{{ $p->nama }}</h3>
                        
                        <div class="flex items-end justify-between pt-2">
                            <p class="text-lg font-black text-slate-900">{{ 'Rp ' . number_format($p->harga_jual, 0, ',', '.') }}</p>
                            
                            <!-- Quick Add to Cart -->
                            <button wire:click.prevent="tambahKeKeranjang({{ $p->id }})" class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center shadow-lg hover:bg-indigo-600 hover:scale-110 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" @if($p->stok <= 0) disabled @endif>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </button>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="flex flex-col items-center justify-center py-32 bg-white rounded-[3rem] border border-dashed border-slate-200 animate-fade-in-up">
            <div class="w-24 h-24 bg-gradient-to-br from-rose-50 to-pink-50 rounded-full flex items-center justify-center mb-8 text-4xl shadow-inner animate-pulse-slow text-rose-400">💝</div>
            <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Wishlist Kosong</h2>
            <p class="text-slate-400 text-sm font-medium max-w-xs text-center mb-8">Temukan produk impian Anda dan simpan di sini.</p>
            <a href="{{ route('katalog') }}" class="px-10 py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/20 active:scale-95">
                Mulai Menjelajah
            </a>
        </div>
        @endif
    </div>
</div>
