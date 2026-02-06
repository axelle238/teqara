<div class="animate-in fade-in duration-500 pb-20">
    
    @if(!$tampilkanForm)
        <!-- TAMPILAN 1: KATALOG INVENTARIS (FULL PAGE LIST) -->
        <div class="space-y-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="space-y-1">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">INVENTARIS TEKNOLOGI</h1>
                    <p class="text-slate-500 font-medium">Kelola seluruh unit produk, parameter harga, dan siklus stok hulu-ke-hilir.</p>
                </div>
                <button wire:click="tambahBaru" class="flex items-center gap-3 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-indigo-600/20 transition-all active:scale-95">
                    <i class="fa-solid fa-box-archive text-lg"></i> REGISTRASI UNIT BARU
                </button>
            </div>

            <!-- Toolbar & Filter -->
            <div class="bg-white p-6 rounded-[35px] border border-indigo-50 flex flex-col md:flex-row gap-6 justify-between items-center shadow-sm">
                <div class="flex gap-4 w-full md:w-auto">
                    <div class="relative flex-1 md:w-80">
                        <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Nama atau SKU..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300">
                    </div>
                    <select wire:model.live="filter_kategori" class="bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-600 focus:ring-4 focus:ring-indigo-500/10 cursor-pointer">
                        <option value="">SEMUA KATEGORI</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                @if(count($selectedProduk) > 0)
                <div class="flex items-center gap-3 animate-in zoom-in duration-300">
                    <span class="text-xs font-black text-indigo-600 bg-indigo-50 px-4 py-2 rounded-xl">{{ count($selectedProduk) }} TERPILIH</span>
                    <button wire:click="bulkArchive" class="px-6 py-3 bg-amber-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-amber-500/20">ARSIPKAN</button>
                    <button wire:click="bulkDelete" wire:confirm="Hapus permanen unit terpilih?" class="px-6 py-3 bg-rose-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-rose-500/20">HAPUS</button>
                </div>
                @endif
            </div>

            <!-- Grid Produk -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">
                @forelse($produk as $p)
                <div class="group bg-white rounded-[45px] p-2 border border-slate-100 shadow-sm hover:shadow-2xl hover:border-indigo-200 transition-all duration-500 relative">
                    <div class="absolute top-6 left-6 z-10">
                        <input type="checkbox" wire:model.live="selectedProduk" value="{{ $p->id }}" class="w-6 h-6 rounded-lg border-2 border-white/50 text-indigo-600 focus:ring-indigo-500 bg-white/20 backdrop-blur-md">
                    </div>
                    
                    <div class="aspect-square rounded-[38px] bg-slate-50 overflow-hidden relative mb-6">
                        <img src="{{ $p->gambar_utama ?? 'https://via.placeholder.com/400?text=Produk' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute bottom-4 left-4 right-4 flex justify-between items-end">
                            <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-[9px] font-black text-slate-800 uppercase tracking-widest shadow-sm">
                                {{ $p->kategori->nama ?? 'Umum' }}
                            </span>
                            <div class="w-10 h-10 rounded-2xl bg-white/90 backdrop-blur-sm flex items-center justify-center text-slate-800 shadow-sm">
                                <i class="fa-solid fa-barcode text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 pb-8 space-y-4">
                        <div>
                            <h3 class="font-black text-lg text-slate-800 leading-tight line-clamp-1 group-hover:text-indigo-600 transition-colors">{{ $p->nama }}</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1">{{ $p->kode_unit }}</p>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="space-y-1">
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Harga Jual</p>
                                <p class="text-xl font-black text-slate-900 tracking-tighter">Rp{{ number_format($p->harga_jual, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right space-y-1">
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Stok</p>
                                <p class="text-lg font-black {{ $p->stok < 5 ? 'text-rose-500' : 'text-emerald-500' }}">{{ $p->stok }}</p>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-slate-50">
                            <button wire:click="edit({{ $p->id }})" class="flex-1 py-3 bg-indigo-50 text-indigo-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-sm">EDIT DETAIL</button>
                            <button wire:click="hapus({{ $p->id }})" wire:confirm="Hapus unit ini?" class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center bg-white rounded-[50px] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-laptop-code text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Katalog Masih Kosong</h3>
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Belum ada unit teknologi yang terdaftar di sistem.</p>
                </div>
                @endforelse
            </div>

            <div class="pt-10">
                {{ $produk->links() }}
            </div>
        </div>
    @else
        <!-- TAMPILAN 2: EDITOR INVENTARIS (FULL PAGE FORM) -->
        <div class="space-y-8 animate-in slide-in-from-right-8 duration-500">
            <!-- Header Editor -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="flex items-center gap-6">
                    <button wire:click="batal" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                    </button>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">{{ $produk_id ? 'Sunting Detail Unit' : 'Registrasi Unit Baru' }}</h1>
                        <p class="text-slate-500 font-medium uppercase tracking-widest text-[10px]">Data Master Inventaris Teqara</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-3xl text-sm font-black hover:bg-slate-100 transition-all">BATAL</button>
                    <button wire:click="simpan" class="px-10 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-emerald-600/20 transition-all active:scale-95">SIMPAN DATA UNIT</button>
                </div>
            </div>

            <!-- Form Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kolom Kiri: Spesifikasi Unit -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Nama Produk Lengkap</label>
                                <input wire:model="nama" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300" placeholder="Cth: MacBook Pro M3 Max 14-inch">
                                @error('nama') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Kode Unit (SKU)</label>
                                <input wire:model="kode_unit" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-indigo-600 focus:ring-4 focus:ring-indigo-500/10 uppercase font-mono" placeholder="MBP-M3-001">
                                @error('kode_unit') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Kategori Produk</label>
                                <select wire:model="kategori_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                                    <option value="">PILIH KATEGORI</option>
                                    @foreach($kategori as $kat)
                                        <option value="{{ $kat->id }}">{{ strtoupper($kat->nama) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Merek / Brand</label>
                                <select wire:model="merek_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                                    <option value="">PILIH MEREK</option>
                                    @foreach($merek as $mrk)
                                        <option value="{{ $mrk->id }}">{{ strtoupper($mrk->nama) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Narasi Produk (Ringkasan)</label>
                            <textarea wire:model="deskripsi_singkat" rows="3" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-600 focus:ring-4 focus:ring-indigo-500/10" placeholder="Berikan gambaran singkat keunggulan produk ini..."></textarea>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Spesifikasi & Deskripsi Lengkap</label>
                            <textarea wire:model="deskripsi_lengkap" rows="8" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-6 text-sm font-medium text-slate-700 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300 leading-relaxed" placeholder="Detail teknis, fitur, dan informasi garansi lengkap..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Finansial & Stok -->
                <div class="space-y-8">
                    <!-- Kartu Stok & Status -->
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
                        <div class="space-y-4 text-center">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Ketersediaan Fisik</label>
                            <div class="flex items-center justify-center gap-6">
                                <button type="button" @click="$wire.stok > 0 ? $wire.stok-- : 0" class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-all shadow-sm">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <input wire:model="stok" type="number" class="w-24 bg-transparent border-none text-center text-4xl font-black text-slate-800 focus:ring-0">
                                <button type="button" @click="$wire.stok++" class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 hover:bg-emerald-50 hover:text-emerald-500 transition-all shadow-sm">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Unit Tersedia</p>
                        </div>

                        <div class="space-y-4 pt-8 border-t border-slate-50">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Status Katalog</label>
                            <select wire:model="status" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                                <option value="aktif">🟢 PUBLIKASI AKTIF</option>
                                <option value="arsip">📁 ARSIP INTERNAL</option>
                                <option value="habis">🔴 STOK HABIS</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kartu Valuasi -->
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Harga Jual Publik</label>
                            <div class="relative">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-300">Rp</span>
                                <input wire:model="harga_jual" type="number" class="w-full bg-slate-50 border-none rounded-2xl pl-14 pr-6 py-4 text-lg font-black text-emerald-600 focus:ring-4 focus:ring-indigo-500/10">
                            </div>
                        </div>
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Harga Modal (HPP)</label>
                            <div class="relative">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-300">Rp</span>
                                <input wire:model="harga_modal" type="number" class="w-full bg-slate-50 border-none rounded-2xl pl-14 pr-6 py-4 text-lg font-black text-rose-600 focus:ring-4 focus:ring-indigo-500/10">
                            </div>
                        </div>
                    </div>

                    <!-- Media Utama -->
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-4">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Visual Utama</label>
                        <div class="relative aspect-square bg-slate-50 rounded-3xl border-4 border-dashed border-slate-100 flex items-center justify-center overflow-hidden group hover:border-indigo-200 transition-all">
                            @if($gambar_baru)
                                <img src="{{ $gambar_baru->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif($gambar_lama)
                                <img src="{{ asset($gambar_lama) }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center space-y-3">
                                    <i class="fa-solid fa-camera-retro text-4xl text-slate-200 group-hover:text-indigo-400 transition-colors"></i>
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Pilih Foto</p>
                                </div>
                            @endif
                            <input type="file" wire:model="gambar_baru" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
