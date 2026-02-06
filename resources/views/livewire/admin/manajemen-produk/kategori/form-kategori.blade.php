<div class="max-w-3xl mx-auto pb-20 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $kategoriId ? 'Edit Kategori' : 'Kategori Baru' }}</h1>
            <p class="text-slate-500 font-medium text-sm mt-1">Klasifikasi produk untuk memudahkan navigasi pelanggan.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.kategori') }}" wire:navigate class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all">
                Batal
            </a>
            <button wire:click="simpan" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all flex items-center gap-2">
                <i class="fa-solid fa-save"></i> Simpan
            </button>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[24px] shadow-sm border border-slate-100">
        <div class="space-y-6">
            <!-- Upload Icon -->
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center relative overflow-hidden group hover:border-emerald-500 transition-colors">
                    @if($ikon_baru)
                        <img src="{{ $ikon_baru->temporaryUrl() }}" class="w-full h-full object-cover">
                    @elseif($ikon_lama)
                        <img src="{{ asset('storage/'.$ikon_lama) }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-image text-slate-300 text-2xl group-hover:text-emerald-500"></i>
                    @endif
                    <input type="file" wire:model="ikon_baru" class="absolute inset-0 opacity-0 cursor-pointer">
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Ikon Kategori</h3>
                    <p class="text-xs text-slate-500 mt-1">Format PNG/JPG, Maksimal 1MB.</p>
                    <div wire:loading wire:target="ikon_baru" class="text-xs text-emerald-600 font-bold mt-2 animate-pulse">Mengunggah...</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Nama Kategori</label>
                    <input wire:model.live="nama" type="text" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 font-bold text-sm" placeholder="Contoh: Laptop Gaming">
                    @error('nama') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Slug URL</label>
                    <input wire:model="slug" type="text" class="w-full rounded-xl border-slate-200 bg-slate-100 text-slate-500 font-mono text-xs" readonly>
                </div>
            </div>
        </div>
    </div>
</div>
