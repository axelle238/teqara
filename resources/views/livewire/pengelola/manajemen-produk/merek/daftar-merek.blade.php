<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Master <span class="text-indigo-500">Merek</span></h1>
            <p class="text-slate-500 font-medium">Database brand partner resmi dan distributor.</p>
        </div>
        
        @if(!$tampilkanForm)
        <button wire:click="tambahBaru" class="flex items-center gap-3 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
            <i class="fa-solid fa-plus"></i> Tambah Brand
        </button>
        @endif
    </div>

    @if($tampilkanForm)
    <!-- INLINE FORM -->
    <div class="bg-white rounded-[40px] p-8 md:p-10 border border-indigo-50 shadow-xl shadow-indigo-500/5 animate-in slide-in-from-top-4 duration-500 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-full blur-3xl -mr-20 -mt-20 opacity-50"></div>
        
        <div class="relative z-10">
            <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-8">{{ $merekId ? 'Sunting Brand' : 'Registrasi Brand Baru' }}</h2>
            
            <form wire:submit.prevent="simpan" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama Brand</label>
                        <input wire:model.live="nama" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 transition-all" placeholder="Cth: Apple, Asus, Samsung">
                        @error('nama') <span class="text-[10px] font-bold text-rose-500 mt-1 block px-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Slug (Otomatis)</label>
                        <input wire:model="slug" type="text" readonly class="w-full bg-slate-100 border-none rounded-2xl px-6 py-4 text-sm font-mono text-slate-500 cursor-not-allowed">
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Deskripsi / Catatan Brand</label>
                        <textarea wire:model="deskripsi" rows="5" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-medium text-slate-600 focus:ring-4 focus:ring-indigo-500/10 transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="md:col-span-2 flex justify-end gap-4 mt-4">
                    <button type="button" wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-100 transition-all">Batal</button>
                    <button type="submit" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all active:scale-95">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Brand
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-5 gap-6">
        @forelse($merek as $mrk)
        <div class="group bg-white rounded-[35px] p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-100 transition-all duration-300 relative text-center">
            
            <div class="w-20 h-20 mx-auto rounded-full bg-slate-50 flex items-center justify-center text-3xl font-black text-indigo-300 mb-4 border-4 border-white shadow-lg group-hover:scale-110 transition-transform">
                {{ substr($mrk->nama, 0, 1) }}
            </div>

            <h3 class="text-lg font-black text-slate-900 mb-1 group-hover:text-indigo-600 transition-colors">{{ $mrk->nama }}</h3>
            <p class="text-xs font-mono text-slate-400 mb-6">{{ $mrk->slug }}</p>

            <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <button wire:click="edit({{ $mrk->id }})" class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <button wire:click="hapus({{ $mrk->id }})" wire:confirm="Hapus brand ini?" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-sm">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>

            <div class="absolute top-4 right-4">
                <span class="px-2 py-1 bg-slate-100 rounded text-[9px] font-black text-slate-500">{{ $mrk->produk_count }}</span>
            </div>
        </div>
        @empty
        @if(!$tampilkanForm)
        <div class="col-span-full py-20 text-center bg-white rounded-[40px] border border-dashed border-slate-200">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl text-slate-300">
                <i class="fa-solid fa-copyright"></i>
            </div>
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Belum Ada Brand</h3>
            <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Tambahkan merek produk yang Anda jual.</p>
        </div>
        @endif
        @endforelse
    </div>
</div>
