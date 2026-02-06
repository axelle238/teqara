<div class="space-y-12 pb-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">BUILDER <span class="text-indigo-600">HALAMAN</span></h1>
            <p class="text-slate-500 font-medium text-lg">Manajemen blok konten dinamis untuk etalase toko.</p>
        </div>
        <button wire:click="tambahBlok" class="flex items-center gap-3 px-8 py-4 bg-slate-900 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            BLOK BARU
        </button>
    </div>

    <!-- Grid Blok Konten -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($daftarKonten as $konten)
        <div class="group bg-white rounded-[40px] border border-slate-100 overflow-hidden hover:shadow-2xl hover:border-indigo-100 transition-all duration-500 flex flex-col h-full">
            <div class="relative h-48 bg-slate-100 overflow-hidden">
                <img src="{{ $konten->gambar }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-[9px] font-black uppercase tracking-widest text-slate-900 border border-white/20">
                        {{ str_replace('_', ' ', $konten->bagian) }}
                    </span>
                </div>
            </div>
            
            <div class="p-8 flex-1 flex flex-col">
                <h3 class="text-lg font-black text-slate-900 mb-2 leading-tight">{{ $konten->judul }}</h3>
                <p class="text-xs text-slate-500 line-clamp-3 mb-6">{{ $konten->deskripsi }}</p>
                
                <div class="mt-auto flex items-center justify-between pt-6 border-t border-slate-50">
                    <span class="text-[9px] font-bold text-slate-300 uppercase tracking-widest">Urutan: {{ $konten->urutan }}</span>
                    <div class="flex gap-2">
                        <button wire:click="editBlok({{ $konten->id }})" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-xl transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                        <button wire:click="hapusBlok({{ $konten->id }})" wire:confirm="Hapus blok konten ini?" class="p-2 text-rose-400 hover:bg-rose-50 rounded-xl transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <p class="text-slate-400 font-bold uppercase text-xs tracking-widest">Belum ada blok konten. Silakan buat baru.</p>
        </div>
        @endforelse
    </div>

    <!-- Panel Form Konten -->
    <x-ui.panel-geser id="form-konten" judul="KONFIGURASI BLOK VISUAL">
        <form wire:submit.prevent="simpanBlok" class="space-y-8 p-2">
            <div class="space-y-4">
                <div class="border-2 border-dashed border-slate-200 rounded-3xl p-8 text-center hover:border-indigo-400 transition-colors relative cursor-pointer group">
                    @if($gambar_baru)
                        <img src="{{ $gambar_baru->temporaryUrl() }}" class="max-h-48 mx-auto rounded-xl shadow-lg">
                    @elseif($gambar_lama)
                        <img src="{{ $gambar_lama }}" class="max-h-48 mx-auto rounded-xl shadow-lg">
                    @else
                        <div class="py-8">
                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Unggah Visual</span>
                        </div>
                    @endif
                    <input type="file" wire:model="gambar_baru" class="absolute inset-0 opacity-0 cursor-pointer">
                </div>
                @error('gambar_baru') <span class="text-rose-500 text-[10px] font-bold block text-center">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Judul Blok</label>
                <input wire:model="judul" type="text" class="w-full bg-slate-50 border-none rounded-xl font-bold focus:ring-2 focus:ring-indigo-500">
                @error('judul') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Penempatan</label>
                    <select wire:model="bagian" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                        <option value="hero_section">Hero Section (Atas)</option>
                        <option value="promo_banner">Promo Banner</option>
                        <option value="fitur_unggulan">Fitur Unggulan</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Urutan</label>
                    <input wire:model="urutan" type="number" class="w-full bg-slate-50 border-none rounded-xl font-bold focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Deskripsi / Narasi</label>
                <textarea wire:model="deskripsi" rows="3" class="w-full bg-slate-50 border-none rounded-xl font-medium focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Label Tombol</label>
                    <input wire:model="teks_tombol" type="text" class="w-full bg-slate-50 border-none rounded-xl font-bold focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tautan (URL)</label>
                    <input wire:model="tautan_tujuan" type="text" class="w-full bg-slate-50 border-none rounded-xl font-bold focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl">
                    SIMPAN BLOK KONTEN
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>