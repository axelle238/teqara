<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('customer.wishlist.index') }}" class="flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-indigo-600 transition-colors mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar
                </a>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">{{ $daftar->nama_daftar }}</h1>
            </div>
            
            @if($daftar->items->count() > 0)
            <button wire:click="masukkanKeranjang" class="flex items-center gap-3 px-6 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg hover:shadow-indigo-500/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Beli Semua
            </button>
            @endif
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
            <div class="p-8 bg-slate-50/30 border-b border-slate-50">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ $daftar->items->count() }} Produk Tersimpan</h3>
            </div>
            
            <div class="divide-y divide-slate-50">
                @forelse($daftar->items as $item)
                <div class="p-6 flex items-center justify-between hover:bg-slate-50 transition-colors group">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-slate-50 rounded-xl overflow-hidden p-2 border border-slate-100">
                            <img src="{{ $item->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply">
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm mb-1">{{ $item->produk->nama }}</h4>
                            <p class="text-xs text-slate-500 font-medium">Qty: {{ $item->jumlah }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <span class="text-sm font-black text-slate-900">Rp {{ number_format($item->produk->harga_jual * $item->jumlah, 0, ',', '.') }}</span>
                        <button wire:click="hapusItem({{ $item->id }})" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
                @empty
                <div class="p-16 text-center">
                    <p class="text-slate-400 font-bold text-sm">Daftar belanja ini masih kosong.</p>
                    <a href="{{ route('katalog') }}" class="inline-block mt-4 text-indigo-600 text-xs font-black uppercase tracking-widest hover:underline">Cari Produk</a>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
