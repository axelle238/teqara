<div class="w-full relative">
    <div class="relative">
        <input 
            wire:model.live.debounce.300ms="query" 
            type="text" 
            placeholder="Cari produk..." 
            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500 transition-all shadow-inner text-slate-700 placeholder:text-slate-400"
            autofocus
        >
        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
    </div>

    @if(strlen($query) >= 3)
        <div class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50">
            @if(count($hasil) > 0)
                <div class="p-2 space-y-1">
                    @foreach($hasil as $p)
                    <a href="{{ route('produk.detail', $p->slug) }}" wire:navigate class="flex items-center gap-3 p-2 hover:bg-slate-50 rounded-xl transition-colors group">
                        <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center p-1 shrink-0">
                            <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-slate-900 truncate group-hover:text-indigo-600 transition-colors">{{ $p->nama }}</h4>
                            <p class="text-[10px] text-slate-500">{{ $p->kategori->nama }}</p>
                        </div>
                        <span class="text-[10px] font-black text-indigo-600">{{ $p->harga_rupiah }}</span>
                    </a>
                    @endforeach
                </div>
                <a href="{{ route('pencarian', ['q' => $query]) }}" wire:navigate class="block text-center py-3 bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    Lihat Semua Hasil
                </a>
            @else
                <div class="p-6 text-center">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tidak Ditemukan</p>
                </div>
            @endif
        </div>
    @endif
</div>
