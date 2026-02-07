<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Master <span class="text-indigo-500">Merek</span></h1>
            <p class="text-slate-500 font-medium">Database brand partner resmi dan distributor.</p>
        </div>
        
        <a href="{{ route('pengelola.merek.tambah') }}" wire:navigate class="flex items-center gap-3 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
            <i class="fa-solid fa-plus"></i> Tambah Brand
        </a>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-5 gap-6">
        @forelse($merek as $mrk)
        <div class="group bg-white rounded-[35px] p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-100 transition-all duration-300 relative text-center">
            
            <div class="w-20 h-20 mx-auto rounded-full bg-slate-50 flex items-center justify-center text-3xl font-black text-indigo-300 mb-4 border-4 border-white shadow-lg group-hover:scale-110 transition-transform">
                {{ substr($mrk->nama, 0, 1) }}
            </div>

            <h3 class="text-lg font-black text-slate-900 mb-1">{{ $mrk->nama }}</h3>
            <p class="text-xs font-mono text-slate-400 mb-6">{{ $mrk->slug }}</p>

            <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <a href="{{ route('pengelola.merek.edit', $mrk->id) }}" wire:navigate class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                    <i class="fa-solid fa-pen"></i>
                </a>
                <button wire:click="hapus({{ $mrk->id }})" wire:confirm="Hapus brand ini?" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-sm">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>

            <div class="absolute top-4 right-4">
                <span class="px-2 py-1 bg-slate-100 rounded text-[9px] font-black text-slate-500">{{ $mrk->produk_count }}</span>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-white rounded-[40px] border border-dashed border-slate-200">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl text-slate-300">
                <i class="fa-solid fa-copyright"></i>
            </div>
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Belum Ada Brand</h3>
            <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Tambahkan merek produk yang Anda jual.</p>
        </div>
        @endforelse
    </div>
</div>