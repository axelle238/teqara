<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Master Merek</h1>
            <p class="text-slate-500 text-sm mt-1">Daftar brand resmi mitra Teqara.</p>
        </div>
        <a href="{{ route('pengelola.merek.tambah') }}" wire:navigate class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-widest shadow-lg shadow-emerald-600/20 transition-all active:scale-95">
            <i class="fa-solid fa-plus"></i> Tambah Merek
        </a>
    </div>

    <!-- Grid Merek -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
        @foreach($merek as $m)
        <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:border-emerald-100 transition-all group text-center relative">
            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                <a href="{{ route('pengelola.merek.edit', $m->id) }}" wire:navigate class="p-2 bg-slate-50 text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors">
                    <i class="fa-solid fa-pen"></i>
                </a>
                <button wire:click="hapus({{ $m->id }})" wire:confirm="Hapus merek ini?" class="p-2 bg-slate-50 text-rose-600 rounded-lg hover:bg-rose-50 transition-colors">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>

            <div class="w-20 h-20 mx-auto rounded-full bg-slate-50 flex items-center justify-center overflow-hidden mb-4 border-4 border-white shadow-md">
                @if($m->logo)
                    <img src="{{ asset('storage/'.$m->logo) }}" class="w-full h-full object-contain p-2">
                @else
                    <span class="text-2xl font-black text-slate-300">{{ substr($m->nama, 0, 1) }}</span>
                @endif
            </div>
            
            <h3 class="font-bold text-slate-900 text-lg">{{ $m->nama }}</h3>
            <p class="text-xs text-slate-400 font-mono mt-1 mb-4">{{ $m->slug }}</p>
            
            <span class="inline-block px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-black uppercase tracking-widest">
                {{ $m->produk_count }} Produk
            </span>
        </div>
        @endforeach
    </div>
</div>
