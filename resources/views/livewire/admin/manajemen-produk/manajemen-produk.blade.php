<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Inventaris Produk</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data unit, harga, dan stok dari hulu rantai pasok.</p>
        </div>
        <button wire:click="tambahBaru" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
            <i class="fa-solid fa-plus"></i> Tambah Unit Baru
        </button>
    </div>

    <!-- Filter & Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <!-- Search & Filter -->
        <div class="flex gap-2 w-full md:w-auto">
            <div class="relative flex-1 md:w-64">
                <i class="fa-solid fa-search absolute left-3 top-3 text-slate-400 text-xs"></i>
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari SKU atau Nama Produk..." class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <select wire:model.live="filter_kategori" class="bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-600 py-2.5 px-4 focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $kat)
                    <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- Bulk Actions -->
        @if(count($selectedProduk) > 0)
        <div class="flex items-center gap-2 animate-in fade-in zoom-in duration-200">
            <span class="text-xs font-bold text-slate-500">{{ count($selectedProduk) }} terpilih</span>
            <button wire:click="bulkArchive" class="px-3 py-2 bg-amber-100 text-amber-700 rounded-lg text-xs font-bold hover:bg-amber-200 transition-colors">
                <i class="fa-solid fa-box-archive mr-1"></i> Arsipkan
            </button>
            <button wire:click="bulkDelete" wire:confirm="Yakin ingin menghapus permanen data terpilih?" class="px-3 py-2 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold hover:bg-rose-200 transition-colors">
                <i class="fa-solid fa-trash mr-1"></i> Hapus
            </button>
        </div>
        @endif
    </div>

    <!-- Data Table (High Density) -->
    <div class="bg-white border border-slate-100 rounded-[24px] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-black tracking-wider">
                    <tr>
                        <th class="px-6 py-4 w-10 text-center">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                        </th>
                        <th class="px-6 py-4">Unit Produk</th>
                        <th class="px-6 py-4">Kategori & Merek</th>
                        <th class="px-6 py-4 text-right">Harga Jual</th>
                        <th class="px-6 py-4 text-center">Stok</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($produk as $p)
                    <tr class="hover:bg-indigo-50/30 transition-colors group">
                        <td class="px-6 py-4 text-center">
                            <input type="checkbox" wire:model.live="selectedProduk" value="{{ $p->id }}" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                    @if($p->gambar_utama)
                                        <img src="{{ asset($p->gambar_utama) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300 text-xs">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 hover:text-indigo-600 transition-colors cursor-pointer" wire:click="edit({{ $p->id }})">
                                        {{ $p->nama }}
                                    </div>
                                    <div class="text-[10px] font-mono text-slate-400 mt-0.5 uppercase tracking-wide">
                                        SKU: {{ $p->kode_unit }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="block text-xs font-bold text-slate-700">{{ $p->kategori->nama ?? '-' }}</span>
                            <span class="block text-[10px] text-slate-400">{{ $p->merek->nama ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-right font-mono font-bold text-slate-900">
                            Rp {{ number_format($p->harga_jual, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($p->stok <= 5)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700 animate-pulse">
                                    {{ $p->stok }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                    {{ $p->stok }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($p->status == 'aktif')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-100 text-slate-500">
                                    Arsip
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button wire:click="edit({{ $p->id }})" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit Detail">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button wire:click="hapus({{ $p->id }})" wire:confirm="Yakin hapus produk ini?" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Permanen">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-box-open text-4xl mb-4 text-slate-200"></i>
                                <p class="font-medium">Data inventaris kosong atau tidak ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $produk->links() }}
        </div>
    </div>

    <!-- Slide Over Panel Form Produk -->
    <x-ui.panel-geser id="panel-form-produk" :judul="$produk_id ? 'Edit Unit Inventaris' : 'Registrasi Unit Baru'">
        <form wire:submit="simpan" class="space-y-8 pb-20">
            
            <!-- Upload Foto -->
            <div class="space-y-4">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Visualisasi Produk</label>
                <div class="flex items-center gap-6">
                    <div class="w-32 h-32 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center relative overflow-hidden group hover:border-indigo-500 transition-colors">
                        @if($gambar_baru)
                            <img src="{{ $gambar_baru->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif($produk_id && \App\Models\Produk::find($produk_id)->gambar_utama)
                            <img src="{{ asset(\App\Models\Produk::find($produk_id)->gambar_utama) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-camera text-slate-300 text-2xl group-hover:text-indigo-500 transition-colors"></i>
                        @endif
                        
                        <input type="file" wire:model="gambar_baru" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-slate-900 mb-1">Unggah Gambar Utama</p>
                        <p class="text-xs text-slate-500 mb-3">Format JPG/PNG, Maks. 2MB. Disarankan rasio 1:1.</p>
                        <div wire:loading wire:target="gambar_baru" class="text-xs font-bold text-indigo-600 animate-pulse">Mengunggah...</div>
                    </div>
                </div>
            </div>

            <div class="h-px bg-slate-100"></div>

            <!-- Informasi Dasar -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-2">Nama Produk Lengkap</label>
                    <input wire:model="nama" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold" placeholder="Contoh: MacBook Pro M3 Max 14 Inch">
                    @error('nama') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">Kode Unit (SKU)</label>
                    <input wire:model="kode_unit" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500 font-mono uppercase" placeholder="MBP-M3-001">
                    @error('kode_unit') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">Status Katalog</label>
                    <select wire:model="status" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold">
                        <option value="aktif">Aktif (Publik)</option>
                        <option value="arsip">Arsip (Sembunyi)</option>
                        <option value="habis">Stok Habis</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">Kategori</label>
                    <select wire:model="kategori_id" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">Merek (Brand)</label>
                    <select wire:model="merek_id" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Pilih Merek</option>
                        @foreach($merek as $mrk)
                            <option value="{{ $mrk->id }}">{{ $mrk->nama }}</option>
                        @endforeach
                    </select>
                    @error('merek_id') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="h-px bg-slate-100"></div>

            <!-- Harga & Inventaris -->
            <div class="space-y-4">
                <h3 class="text-xs font-black text-slate-500 uppercase tracking-widest">Valuasi & Fisik</h3>
                
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Harga Modal (HPP)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-xs font-bold text-slate-400">Rp</span>
                            <input wire:model="harga_modal" type="number" class="w-full pl-8 rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Harga Jual (Publik)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-xs font-bold text-slate-400">Rp</span>
                            <input wire:model="harga_jual" type="number" class="w-full pl-8 rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Stok Fisik</label>
                        <input wire:model="stok" type="number" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                @error('harga_jual') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="h-px bg-slate-100"></div>

            <!-- Konten Detail -->
            <div class="space-y-4">
                <h3 class="text-xs font-black text-slate-500 uppercase tracking-widest">Detail Konten</h3>
                
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">Deskripsi Singkat (SEO Meta)</label>
                    <textarea wire:model="deskripsi_singkat" rows="2" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ringkasan produk untuk tampilan kartu dan hasil pencarian Google..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">Spesifikasi Lengkap (HTML Support)</label>
                    <textarea wire:model="deskripsi_lengkap" rows="6" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500 font-mono text-xs" placeholder="<ul><li>Spesifikasi 1</li>...</ul>"></textarea>
                    <p class="text-[10px] text-slate-400 mt-1">*Mendukung format HTML dasar untuk layout spesifikasi.</p>
                </div>
            </div>

            <!-- Action Buttons (Sticky Bottom) -->
            <div class="fixed bottom-0 right-0 w-full md:w-[480px] bg-white border-t border-slate-200 p-6 flex items-center justify-between gap-4 z-50">
                <button type="button" @click="$dispatch('close-panel-form-produk')" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition-colors w-full">
                    Batal
                </button>
                <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold text-sm hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 transition-all active:scale-95 w-full">
                    <span wire:loading.remove>Simpan Data</span>
                    <span wire:loading>Memproses...</span>
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>
