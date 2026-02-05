<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="/admin/produk" wire:navigate class="text-sm font-medium text-cyan-600 hover:text-cyan-500">&larr; Kembali ke Daftar</a>
    </div>

    <form wire:submit.prevent="simpan" class="space-y-8 bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
        <div>
            <h2 class="text-xl font-bold text-slate-900">{{ $produkId ? 'Ubah Produk' : 'Tambah Produk Baru' }}</h2>
            <p class="mt-1 text-sm text-slate-500">Lengkapi informasi detail produk di bawah ini.</p>
        </div>

        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
            <!-- Nama & Slug -->
            <div class="sm:col-span-4">
                <label class="block text-sm font-bold text-slate-700">Nama Produk</label>
                <input wire:model.live="nama" type="text" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm">
                @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="sm:col-span-2">
                <label class="block text-sm font-bold text-slate-700">SKU</label>
                <input wire:model="sku" type="text" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm" placeholder="PROD-001">
                @error('sku') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="sm:col-span-6">
                <label class="block text-sm font-bold text-slate-700">Slug (URL SEO)</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center rounded-l-md border border-r-0 border-slate-300 bg-slate-50 px-3 text-slate-500 sm:text-sm">teqara.com/produk/</span>
                    <input wire:model="slug" type="text" class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-slate-300 focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm" readonly>
                </div>
            </div>

            <!-- Kategori & Merek -->
            <div class="sm:col-span-3">
                <label class="block text-sm font-bold text-slate-700">Kategori</label>
                <select wire:model="kategori_id" class="mt-1 block w-full rounded-md border-slate-300 py-2 pl-3 pr-10 text-base focus:border-cyan-500 focus:outline-none focus:ring-cyan-500 sm:text-sm">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($daftarKategori as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                    @endforeach
                </select>
                @error('kategori_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-bold text-slate-700">Merek</label>
                <select wire:model="merek_id" class="mt-1 block w-full rounded-md border-slate-300 py-2 pl-3 pr-10 text-base focus:border-cyan-500 focus:outline-none focus:ring-cyan-500 sm:text-sm">
                    <option value="">-- Pilih Merek --</option>
                    @foreach($daftarMerek as $merk)
                        <option value="{{ $merk->id }}">{{ $merk->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Harga & Stok -->
            <div class="sm:col-span-2">
                <label class="block text-sm font-bold text-slate-700">Harga Modal (Rp)</label>
                <input wire:model="harga_modal" type="number" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-sm font-bold text-slate-700">Harga Jual (Rp)</label>
                <input wire:model="harga_jual" type="number" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-sm font-bold text-slate-700">Stok Awal</label>
                <input wire:model="stok" type="number" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm">
            </div>

            <!-- Gambar -->
            <div class="sm:col-span-6">
                <label class="block text-sm font-bold text-slate-700">Foto Produk</label>
                <div class="mt-2 flex items-center gap-4">
                    <div class="h-24 w-24 rounded-lg border border-slate-200 overflow-hidden bg-slate-50">
                        @if($gambar_baru)
                            <img src="{{ $gambar_baru->temporaryUrl() }}" class="h-full w-full object-cover">
                        @elseif($gambar_lama)
                            <img src="{{ $gambar_lama }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center text-slate-300 text-xs">No Image</div>
                        @endif
                    </div>
                    <input type="file" wire:model="gambar_baru" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                </div>
                @error('gambar_baru') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Deskripsi -->
            <div class="sm:col-span-6">
                <label class="block text-sm font-bold text-slate-700">Deskripsi Singkat (SEO)</label>
                <textarea wire:model="deskripsi_singkat" rows="3" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm"></textarea>
            </div>

            <div class="sm:col-span-6">
                <label class="block text-sm font-bold text-slate-700">Status Produk</label>
                <div class="mt-2 flex gap-4">
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="status" value="aktif" class="text-cyan-600 focus:ring-cyan-500">
                        <span class="ml-2 text-sm text-slate-700">Aktif</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="status" value="arsip" class="text-cyan-600 focus:ring-cyan-500">
                        <span class="ml-2 text-sm text-slate-700">Arsip</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="pt-5 border-t border-slate-100">
            <div class="flex justify-end gap-3">
                <a href="/admin/produk" wire:navigate class="rounded-md border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">Batal</a>
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-cyan-600 py-2 px-4 text-sm font-bold text-white shadow-sm hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition">
                    {{ $produkId ? 'Simpan Perubahan' : 'Tambah Produk' }}
                </button>
            </div>
        </div>
    </form>
</div>
