<div class="max-w-2xl mx-auto space-y-8 animate-in slide-in-from-bottom-8 duration-500 pb-20">
    
    <!-- Header Form -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('pengelola.merek') }}" wire:navigate class="w-12 h-12 bg-white rounded-2xl border border-slate-200 flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">{{ $merekId ? 'Edit Brand' : 'Brand Baru' }}</h1>
            <p class="text-slate-500 font-medium text-sm">Kelola identitas merek produk.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-[40px] p-10 border border-slate-100 shadow-xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-[100px] -mr-10 -mt-10 z-0"></div>
        
        <form wire:submit.prevent="simpan" class="relative z-10 space-y-8">
            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em] px-1">Nama Brand</label>
                <input wire:model.live="nama" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-lg font-black text-slate-800 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300 transition-all" placeholder="Cth: Apple, Samsung">
                @error('nama') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em] px-1">Slug URL</label>
                <input wire:model="slug" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-mono text-indigo-600 focus:ring-4 focus:ring-indigo-500/10" readonly>
                @error('slug') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-8 flex justify-end">
                <button type="submit" class="px-10 py-4 bg-indigo-600 text-white rounded-3xl text-sm font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 transition-all active:scale-95 flex items-center gap-3">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
