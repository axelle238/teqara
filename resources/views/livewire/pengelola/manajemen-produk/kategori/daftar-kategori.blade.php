<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Master Kategori</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola struktur kategori produk untuk katalog toko.</p>
        </div>
        <a href="{{ route('pengelola.kategori.tambah') }}" wire:navigate class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-widest shadow-lg shadow-emerald-600/20 transition-all active:scale-95">
            <i class="fa-solid fa-plus"></i> Kategori Baru
        </a>
    </div>

    <!-- Grid Kategori -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($kategori as $k)
        <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:border-emerald-100 transition-all group relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center overflow-hidden">
                    @if($k->ikon)
                        <img src="{{ asset('storage/'.$k->ikon) }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-tags text-slate-300"></i>
                    @endif
                </div>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                    <a href="{{ route('pengelola.kategori.edit', $k->id) }}" wire:navigate class="p-2 bg-slate-50 text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <button wire:click="hapus({{ $k->id }})" wire:confirm="Hapus kategori ini?" class="p-2 bg-slate-50 text-rose-600 rounded-lg hover:bg-rose-50 transition-colors">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
            
            <h3 class="font-bold text-slate-900 text-lg">{{ $k->nama }}</h3>
            <p class="text-xs text-slate-400 font-mono mt-1">{{ $k->slug }}</p>
            
            <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">{{ $k->produk_count }} Produk</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
        </div>
        @endforeach
    </div>
</div>
