<div class="max-w-2xl mx-auto space-y-8 animate-in slide-in-from-bottom-8 duration-500 pb-20">
    
    <!-- Header Form -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('pengelola.kategori') }}" wire:navigate class="w-12 h-12 bg-white rounded-2xl border border-slate-200 flex items-center justify-center text-slate-400 hover:text-rose-600 transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">{{ $kategoriId ? 'Edit Kategori' : 'Kategori Baru' }}</h1>
            <p class="text-slate-500 font-medium text-sm">Kelola metadata dan hierarki.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-[40px] p-10 border border-slate-100 shadow-xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50 rounded-bl-[100px] -mr-10 -mt-10 z-0"></div>
        
        <form wire:submit.prevent="simpan" class="relative z-10 space-y-8">
            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em] px-1">Nama Kategori</label>
                <input wire:model.live="nama" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-lg font-black text-slate-800 focus:ring-4 focus:ring-rose-500/10 placeholder:text-slate-300 transition-all" placeholder="Cth: Laptop Gaming">
                @error('nama') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em] px-1">Slug URL (Otomatis)</label>
                <input wire:model="slug" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-mono text-rose-600 focus:ring-4 focus:ring-rose-500/10" readonly>
                @error('slug') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em] px-1">Ikon (FontAwesome)</label>
                <div class="flex gap-4">
                    <div class="w-16 h-16 bg-rose-50 rounded-2xl flex items-center justify-center text-2xl text-rose-500 shrink-0">
                        <i class="{{ $ikon ?? 'fa-solid fa-icons' }}"></i>
                    </div>
                    <input wire:model.live="ikon" type="text" class="flex-1 bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-medium text-slate-600 focus:ring-4 focus:ring-rose-500/10" placeholder="fa-solid fa-laptop">
                </div>
                <p class="text-[10px] text-slate-400 px-1">Gunakan kelas ikon dari FontAwesome 6 Free.</p>
            </div>

            <div class="pt-8 flex justify-end">
                <button type="submit" class="px-10 py-4 bg-rose-600 text-white rounded-3xl text-sm font-black uppercase tracking-widest hover:bg-rose-700 shadow-lg shadow-rose-600/20 transition-all active:scale-95 flex items-center gap-3">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>