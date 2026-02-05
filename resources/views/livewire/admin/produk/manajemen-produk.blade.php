<!-- 
    Nama File: resources/views/livewire/admin/produk/manajemen-produk.blade.php
    Tujuan: Antarmuka dashboard admin untuk manajemen produk komputer.
    Gaya: High-Tech Enterprise, Tanpa Modal, Full Icon.
-->
<div class="p-6 lg:p-10 space-y-10">
    
    <!-- Header Dashboard -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter">GUDANG <span class="text-cyan-600">PRODUK</span></h1>
            <p class="text-slate-500 font-medium">Kelola inventaris perangkat keras dan gadget Anda secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <button 
                wire:click="tambahBaru" 
                class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-2xl font-bold shadow-xl shadow-slate-900/20 hover:bg-slate-800 transition-all group"
            >
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Produk Baru
            </button>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[32px] shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-cyan-50 flex items-center justify-center text-cyan-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Produk</p>
                <p class="text-2xl font-black text-slate-900">{{ $produk->total() }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[32px] shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Stok Menipis</p>
                <p class="text-2xl font-black text-slate-900">3 Perangkat</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[32px] shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Produk Aktif</p>
                <p class="text-2xl font-black text-slate-900">85%</p>
            </div>
        </div>
    </div>

    <!-- Tabel Data & Filter -->
    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <!-- Toolbar Tabel -->
        <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative w-full md:w-96">
                <input 
                    wire:model.live.debounce.300ms="cari" 
                    type="text" 
                    placeholder="Cari nama produk atau SKU..." 
                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-cyan-500 transition-all"
                >
                <svg class="w-5 h-5 absolute left-4 top-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0">
                <button class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition">Filter</button>
                <button class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition">Ekspor</button>
            </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Produk</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kategori</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Stok</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Harga</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-5 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($produk as $p)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex-shrink-0 p-1">
                                    <img src="{{ $p->gambar_utama }}" class="w-full h-full object-contain">
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 leading-none mb-1">{{ $p->nama }}</p>
                                    <p class="text-xs text-slate-400 font-medium tracking-tight">SKU: {{ $p->sku }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 bg-cyan-50 text-cyan-600 rounded-lg text-[10px] font-black uppercase">{{ $p->kategori->nama }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <p class="text-sm font-black text-slate-900">{{ $p->stok }} <span class="text-[10px] text-slate-400 font-medium">UNIT</span></p>
                                @if($p->stok_ditahan > 0)
                                    <p class="text-[10px] text-amber-500 font-bold">DITAHAN: {{ $p->stok_ditahan }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5 font-black text-slate-900 text-sm">
                            Rp {{ number_format($p->harga_jual/1000, 0) }}K
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full {{ $p->status === 'aktif' ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                                <span class="text-xs font-bold text-slate-600 capitalize">{{ $p->status }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.produk.spesifikasi', $p->id) }}" wire:navigate class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Atur Spesifikasi"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></a>
                                <button class="p-2 text-slate-400 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                                <button class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-8 bg-slate-50/30">
            {{ $produk->links() }}
        </div>
    </div>

    <!-- Panel Geser Form Produk (Modal Killer) -->
    <x-ui.panel-geser id="form-produk" judul="TAMBAH UNIT BARU">
        <form wire:submit.prevent="simpan" class="space-y-8">
            <!-- Info Dasar -->
            <div class="space-y-4">
                <p class="text-[10px] font-black text-cyan-600 uppercase tracking-[0.2em]">Informasi Perangkat</p>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Produk Lengkap</label>
                        <input wire:model="nama" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 font-bold" placeholder="Contoh: MacBook Pro M3 14 Inch 2024">
                        @error('nama') <span class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">SKU / Kode Unit</label>
                        <input wire:model="sku" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 text-sm" placeholder="TEQ-MBP-M3-001">
                        @error('sku') <span class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kategori</label>
                        <select wire:model="kategori_id" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 text-sm">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $k) <option value="{{ $k->id }}">{{ $k->nama }}</option> @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Stok & Harga -->
            <div class="space-y-4">
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.2em]">Inventaris & Komersial</p>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Stok Awal</label>
                        <input wire:model="stok" type="number" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Harga Jual (Rp)</label>
                        <input wire:model="harga_jual" type="number" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 text-sm font-black">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Status</label>
                        <select wire:model="status" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 text-sm">
                            <option value="aktif">Aktif</option>
                            <option value="arsip">Arsip</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Media -->
            <div class="space-y-4">
                <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em]">Visual & Media</p>
                <div class="border-2 border-dashed border-slate-200 rounded-3xl p-8 flex flex-col items-center justify-center bg-slate-50 hover:bg-indigo-50 transition-colors group cursor-pointer relative">
                    @if($gambar_baru)
                        <img src="{{ $gambar_baru->temporaryUrl() }}" class="max-h-48 rounded-xl shadow-lg mb-4">
                    @else
                        <svg class="w-12 h-12 text-slate-300 group-hover:text-indigo-400 mb-4 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-xs font-bold text-slate-400">Klik atau seret gambar ke sini</p>
                    @endif
                    <input type="file" wire:model="gambar_baru" class="absolute inset-0 opacity-0 cursor-pointer">
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-6 flex gap-3">
                <button type="submit" class="flex-1 bg-slate-900 text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-slate-800 transition shadow-xl shadow-slate-900/20">Simpan Perangkat</button>
                <button type="button" @click="$dispatch('close-panel-form-produk')" class="px-8 py-4 bg-slate-100 text-slate-400 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-red-50 hover:text-red-500 transition">Batal</button>
            </div>
        </form>
    </x-ui.panel-geser>

</div>
