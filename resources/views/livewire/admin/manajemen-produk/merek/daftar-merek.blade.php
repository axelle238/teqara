<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Master Merek</h1>
            <p class="text-slate-500 text-sm mt-1">Mitra brand dan prinsipal resmi.</p>
        </div>
        <button wire:click="tambah" class="flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
            <i class="fa-solid fa-plus"></i> Tambah Merek
        </button>
    </div>

    <!-- Brand Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @foreach($merek as $m)
        <div class="group bg-white rounded-[24px] border border-slate-100 p-6 hover:shadow-xl hover:border-indigo-100 transition-all duration-300 relative text-center flex flex-col items-center justify-center">
            <!-- Logo -->
            <div class="w-20 h-20 rounded-full bg-white border border-slate-100 flex items-center justify-center p-4 mb-4 shadow-sm group-hover:scale-110 transition-transform duration-300">
                @if($m->logo)
                    <img src="{{ asset('storage/'.$m->logo) }}" class="w-full h-full object-contain mix-blend-multiply">
                @else
                    <span class="text-2xl font-black text-slate-300">{{ substr($m->nama, 0, 1) }}</span>
                @endif
            </div>

            <h3 class="font-bold text-slate-900 mb-1 group-hover:text-indigo-600 transition-colors">{{ $m->nama }}</h3>
            <span class="inline-block px-3 py-1 rounded-full bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-widest border border-slate-100">
                {{ $m->produk_count }} Unit
            </span>

            <!-- Actions Overlay -->
            <div class="absolute inset-0 bg-white/90 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 rounded-[24px]">
                <button wire:click="edit({{ $m->id }})" class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-all shadow-sm">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <button wire:click="hapus({{ $m->id }})" wire:confirm="Hapus merek ini?" class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-all shadow-sm">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Slide Over Form -->
    <x-ui.panel-geser id="form-merek" :judul="$modeEdit ? 'Edit Merek' : 'Merek Baru'">
        <form wire:submit="simpan" class="space-y-6">
            
            <div class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 rounded-2xl hover:border-indigo-500 transition-colors bg-slate-50 relative group">
                @if($logo_baru)
                    <img src="{{ $logo_baru->temporaryUrl() }}" class="w-32 h-32 object-contain">
                @else
                    <div class="text-center">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-300 mb-2"></i>
                        <p class="text-xs font-bold text-slate-500">Unggah Logo (PNG Transparan)</p>
                    </div>
                @endif
                <input type="file" wire:model="logo_baru" class="absolute inset-0 opacity-0 cursor-pointer">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Nama Brand</label>
                <input wire:model="nama" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold" placeholder="ASUS">
                @error('nama') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="fixed bottom-0 right-0 w-full md:w-[480px] bg-white border-t border-slate-200 p-6 z-50">
                <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
                    Simpan Data
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>
