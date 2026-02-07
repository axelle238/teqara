<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-12 text-center animate-fade-in-down">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Beli <span class="text-indigo-600">Lagi</span></h1>
            <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-2">Pesan Ulang Produk Favorit Anda dengan Cepat</p>
        </div>

        @if($this->riwayatProduk->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach($this->riwayatProduk as $item)
            @if($item->produk) <!-- Safety check if product deleted -->
            <div class="group bg-white rounded-[2rem] p-4 border border-slate-100 hover:shadow-xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-300 animate-fade-in-up">
                
                <!-- Image -->
                <div class="relative w-full aspect-square bg-slate-50 rounded-2xl mb-4 flex items-center justify-center p-4 overflow-hidden">
                    <img src="{{ $item->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500">
                    
                    <!-- Quick Add Button (Hover) -->
                    <button wire:click="tambahKeKeranjang({{ $item->produk_id }})" class="absolute bottom-3 right-3 w-10 h-10 bg-slate-900 text-white rounded-full flex items-center justify-center shadow-lg translate-y-10 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 hover:bg-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>

                <!-- Info -->
                <div>
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-tight line-clamp-2 min-h-[2.5em] mb-1 group-hover:text-indigo-600 transition-colors">
                        {{ $item->produk->nama }}
                    </h3>
                                                    <p class="text-[10px] text-slate-500 font-medium mb-3">Terakhir dibeli: {{ $item->dibuat_pada->diffForHumans() }}</p>                    
                    <div class="flex items-end justify-between">
                        <span class="text-sm font-black text-slate-900">Rp {{ number_format($item->produk->harga_jual/1000, 0) }}K</span>
                        <div class="flex gap-1">
                            @for($i=0; $i<5; $i++)
                                <span class="text-[8px] text-amber-400">★</span>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        @else
        <div class="flex flex-col items-center justify-center py-32 bg-white rounded-[3rem] border border-dashed border-slate-200 animate-fade-in-up">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6 text-4xl opacity-50 shadow-inner">🛍️</div>
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Belum Ada Riwayat</h3>
            <p class="text-slate-400 text-sm font-medium mb-8">Selesaikan pesanan pertama Anda untuk melihat produk di sini.</p>
            <a href="{{ route('katalog') }}" class="px-10 py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/20">
                Mulai Belanja
            </a>
        </div>
        @endif

    </div>
</div>
