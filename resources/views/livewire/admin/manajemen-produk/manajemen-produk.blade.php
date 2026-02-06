<div class="space-y-10">
    
    <!-- Header: Vibrant & Clear -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Gudang Unit Terintegrasi</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">KATALOG <span class="text-emerald-600">INVENTARIS</span></h1>
            <p class="text-slate-500 font-medium">Manajemen seluruh unit komputasi dan gadget dalam satu kendali terpusat.</p>
        </div>
        <div class="flex items-center gap-3">
            <button 
                wire:click="tambahBaru" 
                class="flex items-center gap-3 px-8 py-4 bg-indigo-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest shadow-2xl shadow-indigo-500/30 hover:bg-indigo-700 hover:scale-105 transition-all group"
            >
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"></path></svg>
                Registrasi Unit Baru
            </button>
        </div>
    </div>

    <!-- Statistik Ringkas: Vibrant High-Tech -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[48px] shadow-sm border border-indigo-50 flex items-center gap-6 group hover:shadow-xl transition-all duration-500">
            <div class="w-16 h-16 rounded-[24px] bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Populasi Unit</p>
                <p class="text-3xl font-black text-slate-900 tracking-tighter">{{ $produk->total() }} <span class="text-xs text-slate-400 font-bold uppercase">UNIT</span></p>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[48px] shadow-sm border border-indigo-50 flex items-center gap-6 group hover:shadow-xl transition-all duration-500">
            <div class="w-16 h-16 rounded-[24px] bg-amber-50 flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Stok Kritis</p>
                <p class="text-3xl font-black text-amber-600 tracking-tighter">3 <span class="text-xs text-slate-400 font-bold uppercase">Unit</span></p>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[48px] shadow-sm border border-indigo-50 flex items-center gap-6 group hover:shadow-xl transition-all duration-500">
            <div class="w-16 h-16 rounded-[24px] bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Efisiensi Katalog</p>
                <p class="text-3xl font-black text-emerald-600 tracking-tighter">85% <span class="text-xs text-slate-400 font-bold uppercase">Aktif</span></p>
            </div>
        </div>
    </div>

    <!-- Tabel Data & Filter -->
    <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
        <!-- Toolbar -->
        <div class="p-8 border-b border-indigo-50 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-slate-50/30">
            <div class="relative w-full md:w-96 group">
                <input 
                    wire:model.live.debounce.300ms="cari" 
                    type="text" 
                    placeholder="Cari model atau kode unit..." 
                    class="w-full pl-12 pr-4 py-4 bg-white border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 shadow-sm transition-all"
                >
                <svg class="w-5 h-5 absolute left-4 top-4 text-slate-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <div class="flex items-center gap-3">
                <button class="px-6 py-3 bg-white border border-indigo-100 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-indigo-50 hover:text-indigo-600 transition-all shadow-sm">Filter Lanjutan</button>
                <button class="px-6 py-3 bg-white border border-indigo-100 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-indigo-50 hover:text-indigo-600 transition-all shadow-sm">Ekspor Jurnal</button>
            </div>
        </div>

        <!-- Main Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Identitas Unit</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Klasifikasi</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Status Stok</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Nilai Jual</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Otoritas</th>
                        <th class="px-10 py-6 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($produk as $p)
                    <tr class="group hover:bg-indigo-50/20 transition-colors duration-300">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-16 rounded-[24px] bg-white border border-indigo-50 flex-shrink-0 p-2 shadow-sm group-hover:scale-110 transition-transform">
                                    <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain">
                                </div>
                                <div class="space-y-1">
                                    <p class="font-black text-slate-900 tracking-tight leading-none text-base">{{ $p->nama }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">KODE: {{ $p->kode_unit }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-indigo-100">{{ $p->kategori->nama }}</span>
                        </td>
                        <td class="px-6 py-6">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-black text-slate-900 tracking-tighter">{{ $p->stok }} <span class="text-[10px] text-slate-400 uppercase ml-0.5">Unit</span></p>
                                    @if($p->stok <= 5)
                                        <span class="px-2 py-0.5 bg-rose-100 text-rose-600 rounded text-[9px] font-black uppercase tracking-widest animate-pulse">KRITIS</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-600 rounded text-[9px] font-black uppercase tracking-widest">AMAN</span>
                                    @endif
                                </div>
                                @if($p->stok_ditahan > 0)
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                        <p class="text-[9px] text-amber-600 font-black uppercase">Reserver: {{ $p->stok_ditahan }}</p>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-6 font-black text-slate-900 text-sm tracking-tighter">
                            Rp {{ number_format($p->harga_jual, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full {{ $p->status === 'aktif' ? 'bg-emerald-500 shadow-lg shadow-emerald-500/50' : 'bg-slate-200' }}"></div>
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $p->status }}</span>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-0 translate-x-4">
                                <a href="{{ route('admin.produk.spesifikasi', $p->id) }}" wire:navigate class="p-3 bg-white border border-indigo-100 text-indigo-400 hover:text-white hover:bg-indigo-600 rounded-2xl transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                </a>
                                <button wire:click="edit({{ $p->id }})" class="p-3 bg-white border border-indigo-100 text-indigo-400 hover:text-white hover:bg-indigo-600 rounded-2xl transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button wire:click="hapus({{ $p->id }})" wire:confirm="Apakah Anda yakin ingin menghapus unit ini dari inventaris? Tindakan ini tidak dapat dibatalkan." class="p-3 bg-white border border-rose-100 text-rose-400 hover:text-white hover:bg-rose-600 rounded-2xl transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-10 bg-slate-50/30 border-t border-slate-50 flex justify-center">
            {{ $produk->links() }}
        </div>
    </div>

    <!-- Panel Form Unit (Vibrant Slide-over) -->
    <x-ui.panel-geser id="form-produk" judul="REGISTRASI UNIT INVENTARIS">
        <form wire:submit.prevent="simpan" class="space-y-10 p-2">
            <!-- Info Dasar -->
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-1 bg-indigo-600 rounded-full"></span>
                    <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em]">Identitas Perangkat</p>
                </div>
                <div class="grid grid-cols-1 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Unit Lengkap</label>
                        <input wire:model="nama" type="text" class="w-full rounded-2xl border-none bg-indigo-50/50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 placeholder:text-slate-300 transition-all" placeholder="Contoh: MacBook Pro M3 Max 16-inch">
                        @error('nama') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">KODE UNIT / SKU</label>
                        <input wire:model="kode_unit" type="text" class="w-full rounded-2xl border-none bg-indigo-50/50 px-6 py-4 text-sm font-black text-indigo-600 focus:ring-2 focus:ring-indigo-500 placeholder:text-slate-300 transition-all uppercase" placeholder="TEQ-UNIT-001">
                        @error('kode_unit') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Merek (Brand)</label>
                        <select wire:model="merek_id" class="w-full rounded-2xl border-none bg-indigo-50/50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 transition-all">
                            <option value="">Pilih Merek</option>
                            @foreach($merek as $m) <option value="{{ $m->id }}">{{ $m->nama }}</option> @endforeach
                        </select>
                        @error('merek_id') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Klasifikasi Kategori</label>
                        <select wire:model="kategori_id" class="w-full rounded-2xl border-none bg-indigo-50/50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 transition-all">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $k) <option value="{{ $k->id }}">{{ $k->nama }}</option> @endforeach
                        </select>
                        @error('kategori_id') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Deskripsi Singkat</label>
                    <textarea wire:model="deskripsi_singkat" rows="3" class="w-full rounded-2xl border-none bg-indigo-50/50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="Ringkasan fitur utama..."></textarea>
                </div>
            </div>

            <!-- Financial & Stock -->
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-1 bg-emerald-600 rounded-full"></span>
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em]">Komersial & Stok</p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Stok Awal</label>
                        <input wire:model="stok" type="number" class="w-full rounded-2xl border-none bg-emerald-50/50 px-6 py-4 text-sm font-black text-emerald-700 focus:ring-2 focus:ring-emerald-500 transition-all">
                        @error('stok') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Harga Modal (Rp)</label>
                        <input wire:model="harga_modal" type="number" class="w-full rounded-2xl border-none bg-emerald-50/50 px-6 py-4 text-sm font-black text-slate-900 focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Harga Jual (Rp)</label>
                        <input wire:model="harga_jual" type="number" class="w-full rounded-2xl border-none bg-emerald-50/50 px-6 py-4 text-sm font-black text-slate-900 focus:ring-2 focus:ring-emerald-500 transition-all">
                        @error('harga_jual') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Otoritas</label>
                        <select wire:model="status" class="w-full rounded-2xl border-none bg-emerald-50/50 px-6 py-4 text-sm font-black text-slate-900 focus:ring-2 focus:ring-emerald-500 transition-all">
                            <option value="aktif">PUBLIKASIKAN</option>
                            <option value="arsip">ARSIP INTERNAL</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Visual Asset -->
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-1 bg-purple-600 rounded-full"></span>
                    <p class="text-[10px] font-black text-purple-600 uppercase tracking-[0.3em]">Aset Visual Unit</p>
                </div>
                <div class="border-4 border-dashed border-purple-50 rounded-[40px] p-12 flex flex-col items-center justify-center bg-purple-50/30 hover:bg-purple-50 hover:border-purple-200 transition-all group cursor-pointer relative shadow-inner">
                    @if($gambar_baru)
                        <img src="{{ $gambar_baru->temporaryUrl() }}" class="max-h-64 rounded-3xl shadow-2xl mb-6 ring-8 ring-white">
                    @else
                        <div class="w-20 h-20 rounded-[32px] bg-white flex items-center justify-center text-purple-400 mb-6 shadow-xl group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-[10px] font-black text-purple-400 uppercase tracking-[0.3em]">Aktivasi Kamera Media</p>
                        <p class="text-xs font-bold text-slate-400 mt-2">Format: JPG, PNG, WEBP (Maks 2MB)</p>
                    @endif
                    <input type="file" wire:model="gambar_baru" class="absolute inset-0 opacity-0 cursor-pointer">
                </div>
            </div>

            <!-- Action Command -->
            <div class="pt-10 border-t-2 border-dashed border-slate-100 flex gap-4">
                <button type="submit" class="flex-1 bg-slate-900 text-white py-5 rounded-[28px] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 hover:scale-[1.02] active:scale-95 transition-all shadow-2xl shadow-indigo-500/20 group">
                    EKSEKUSI PENDAFTARAN UNIT
                </button>
                <button type="button" @click="$dispatch('close-panel-form-produk')" class="px-10 py-5 bg-slate-100 text-slate-400 rounded-[28px] font-black text-xs uppercase tracking-[0.2em] hover:bg-rose-50 hover:text-rose-600 transition-all">BATAL</button>
            </div>
        </form>
    </x-ui.panel-geser>

</div>