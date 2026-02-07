<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Master <span class="text-rose-500">Kategori</span></h1>
            <p class="text-slate-500 font-medium">Struktur hierarki produk untuk navigasi pelanggan yang optimal.</p>
        </div>
        
        <a href="{{ route('pengelola.kategori.tambah') }}" wire:navigate class="flex items-center gap-3 px-6 py-3 bg-rose-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rose-600 transition-all shadow-lg shadow-rose-500/20 active:scale-95">
            <i class="fa-solid fa-plus"></i> Kategori Baru
        </a>
    </div>

    <!-- Tree Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($kategori as $kat)
        <div class="group bg-white rounded-[35px] p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:border-rose-100 transition-all duration-300 relative overflow-hidden">
            <!-- Icon -->
            <div class="w-16 h-16 rounded-2xl bg-rose-50 flex items-center justify-center text-3xl text-rose-500 mb-6 group-hover:scale-110 transition-transform duration-500">
                <i class="{{ $kat->ikon ?? 'fa-solid fa-layer-group' }}"></i>
            </div>

            <!-- Content -->
            <h3 class="text-lg font-black text-slate-900 mb-1 group-hover:text-rose-600 transition-colors">{{ $kat->nama }}</h3>
            <p class="text-xs font-mono text-slate-400 mb-4">{{ $kat->slug }}</p>

            <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-widest">
                    {{ $kat->produk_count }} Produk
                </span>
                
                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('pengelola.kategori.edit', $kat->id) }}" wire:navigate class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <button wire:click="hapus({{ $kat->id }})" wire:confirm="Hapus kategori ini? Pastikan kosong." class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-white rounded-[40px] border border-dashed border-slate-200">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl text-slate-300">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Belum Ada Kategori</h3>
            <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Buat kategori pertama untuk mengelompokkan produk.</p>
        </div>
        @endforelse
    </div>
</div>