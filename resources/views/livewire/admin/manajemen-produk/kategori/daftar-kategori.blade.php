<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Master Kategori</h1>
            <p class="text-slate-500 text-sm mt-1">Klasifikasi produk dan atribut visual.</p>
        </div>
        <button wire:click="tambah" class="flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
            <i class="fa-solid fa-plus"></i> Kategori Baru
        </button>
    </div>

    <!-- Category Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach($kategori as $kat)
        <div class="group bg-white rounded-[24px] border border-slate-100 p-6 hover:shadow-xl hover:border-indigo-100 transition-all duration-300 relative text-center">
            <!-- Icon -->
            <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-50 flex items-center justify-center text-3xl mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                @if($kat->ikon)
                    <img src="{{ asset('storage/'.$kat->ikon) }}" class="w-10 h-10 object-contain">
                @else
                    <i class="fa-solid fa-layer-group"></i>
                @endif
            </div>

            <h3 class="font-bold text-slate-900 mb-1 group-hover:text-indigo-600 transition-colors">{{ $kat->nama }}</h3>
            <span class="inline-block px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-black uppercase tracking-widest">
                {{ $kat->produk_count }} Produk
            </span>

            <!-- Actions Overlay -->
            <div class="absolute inset-0 bg-white/90 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 rounded-[24px]">
                <button wire:click="edit({{ $kat->id }})" class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-all shadow-sm">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <button wire:click="hapus({{ $kat->id }})" wire:confirm="Hapus kategori ini?" class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-all shadow-sm">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Slide Over Form -->
    <x-ui.panel-geser id="form-kategori" :judul="$modeEdit ? 'Edit Kategori' : 'Kategori Baru'">
        <form wire:submit="simpan" class="space-y-6">
            
            <div class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 rounded-2xl hover:border-indigo-500 transition-colors bg-slate-50 relative group">
                @if($ikon_baru)
                    <img src="{{ $ikon_baru->temporaryUrl() }}" class="w-24 h-24 object-contain">
                @else
                    <div class="text-center">
                        <i class="fa-solid fa-image text-3xl text-slate-300 mb-2"></i>
                        <p class="text-xs font-bold text-slate-500">Unggah Ikon (PNG/SVG)</p>
                    </div>
                @endif
                <input type="file" wire:model="ikon_baru" class="absolute inset-0 opacity-0 cursor-pointer">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Nama Kategori</label>
                <input wire:model="nama" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold" placeholder="Laptop Gaming">
                @error('nama') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="fixed bottom-0 right-0 w-full md:w-[480px] bg-white border-t border-slate-200 p-6 z-50">
                <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
                    Simpan
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>
