<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Konten Toko Visual</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola tampilan Halaman Depan pelanggan secara dinamis.</p>
        </div>
        <button wire:click="tambahBlok" class="flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
            <i class="fa-solid fa-paintbrush"></i> Tambah Blok Baru
        </button>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($daftarKonten as $konten)
        <div class="group bg-white rounded-[24px] border border-slate-100 shadow-sm overflow-hidden hover:shadow-xl hover:border-indigo-200 transition-all duration-300">
            <!-- Preview Image -->
            <div class="relative h-48 bg-slate-100 overflow-hidden">
                <img src="{{ $konten->gambar ?? 'https://via.placeholder.com/400x200?text=No+Image' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent"></div>
                <div class="absolute bottom-4 left-4 right-4 text-white">
                    <span class="inline-block px-2 py-1 mb-2 rounded bg-white/20 backdrop-blur text-[10px] font-black uppercase tracking-widest border border-white/10">
                        {{ strtoupper(str_replace('_', ' ', $konten->bagian)) }}
                    </span>
                    <h3 class="font-bold text-lg leading-tight truncate">{{ $konten->judul }}</h3>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <p class="text-slate-500 text-sm line-clamp-2 mb-4 h-10">{{ $konten->deskripsi }}</p>
                
                <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
                    <div class="flex gap-2">
                        <button wire:click="editBlok({{ $konten->id }})" class="w-8 h-8 rounded-lg bg-slate-50 text-indigo-600 hover:bg-indigo-100 flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-pen-nib"></i>
                        </button>
                        <button wire:click="hapusBlok({{ $konten->id }})" wire:confirm="Hapus blok konten ini?" class="w-8 h-8 rounded-lg bg-slate-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                    <div class="text-xs font-bold text-slate-400">
                        Urutan: {{ $konten->urutan }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Slide Over Editor -->
    <x-ui.panel-geser id="form-konten" :judul="$blokTerpilihId ? 'Edit Blok Visual' : 'Buat Blok Baru'">
        <form wire:submit="simpanBlok" class="space-y-6">
            
            <!-- Type Selector -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Tipe Bagian</label>
                <div class="grid grid-cols-3 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="bagian" value="hero_section" class="peer sr-only">
                        <div class="px-3 py-2 rounded-lg border text-center text-xs font-bold transition-all peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 hover:bg-slate-50">
                            HERO UTAMA
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="bagian" value="promo_banner" class="peer sr-only">
                        <div class="px-3 py-2 rounded-lg border text-center text-xs font-bold transition-all peer-checked:bg-fuchsia-600 peer-checked:text-white peer-checked:border-fuchsia-600 hover:bg-slate-50">
                            BANNER
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="bagian" value="fitur_unggulan" class="peer sr-only">
                        <div class="px-3 py-2 rounded-lg border text-center text-xs font-bold transition-all peer-checked:bg-cyan-600 peer-checked:text-white peer-checked:border-cyan-600 hover:bg-slate-50">
                            FITUR
                        </div>
                    </label>
                </div>
            </div>

            <!-- Upload -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Visual</label>
                <div class="flex items-center gap-4">
                    <div class="w-24 h-24 rounded-xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden relative">
                        @if($gambar_baru)
                            <img src="{{ $gambar_baru->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif($gambar_lama)
                            <img src="{{ asset($gambar_lama) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-image text-slate-300 text-xl"></i>
                        @endif
                        <input type="file" wire:model="gambar_baru" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-slate-500">Klik kotak untuk mengunggah. Disarankan ukuran 1920x800px untuk Hero.</p>
                        <div wire:loading wire:target="gambar_baru" class="text-xs text-indigo-600 font-bold mt-1">Mengunggah...</div>
                    </div>
                </div>
            </div>

            <!-- Text Fields -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Judul Utama</label>
                <input wire:model="judul" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold" placeholder="Contoh: Promo Akhir Tahun">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Deskripsi Pendek</label>
                <textarea wire:model="deskripsi" rows="3" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500" placeholder="Jelaskan penawaran menariknya..."></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Teks Tombol</label>
                    <input wire:model="teks_tombol" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500" placeholder="Beli Sekarang">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Link Tujuan</label>
                    <input wire:model="tautan_tujuan" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500" placeholder="/katalog">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Urutan Tampil</label>
                <input wire:model="urutan" type="number" class="w-20 rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold text-center">
            </div>

            <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold shadow-lg transition-all mt-4">
                Simpan Perubahan
            </button>
        </form>
    </x-ui.panel-geser>
</div>
