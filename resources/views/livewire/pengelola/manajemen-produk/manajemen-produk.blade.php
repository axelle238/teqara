<div class="space-y-10 animate-in fade-in duration-500 pb-20" x-data="{ tabAktif: 'dasar' }">
    
    @if(!$tampilkanForm)
        <!-- 1. TAMPILAN KATALOG PRODUK (DASHBOARD GRID) -->
        <div class="space-y-8">
            <!-- Header Operasional -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-cyan-500/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="relative z-10 space-y-2">
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight uppercase leading-none">Manajemen <span class="text-cyan-600">Inventaris</span></h1>
                    <p class="text-slate-500 font-medium tracking-wide italic">Kelola siklus hidup produk komputer & gadget hulu ke hilir.</p>
                </div>
                <div class="flex items-center gap-4 relative z-10">
                    <button wire:click="tambahBaru" class="px-8 py-4 bg-slate-900 text-white rounded-2xl text-sm font-black uppercase tracking-widest hover:bg-cyan-600 hover:shadow-2xl hover:shadow-cyan-500/30 transition-all active:scale-95 flex items-center gap-3">
                        <i class="fa-solid fa-plus-circle text-lg"></i> REGISTRASI SKU BARU
                    </button>
                </div>
            </div>

            <!-- Toolbar Canggih (Filter & Cari) -->
            <div class="bg-white p-6 rounded-[35px] border border-indigo-50 flex flex-col md:flex-row gap-6 justify-between items-center shadow-sm">
                <div class="flex flex-wrap gap-4 w-full md:w-auto">
                    <div class="relative flex-1 md:w-80">
                        <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Nama Produk atau SKU..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-cyan-500/10 placeholder:text-slate-300">
                    </div>
                    <select wire:model.live="filter_kategori" class="bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-600 focus:ring-4 focus:ring-cyan-500/10 cursor-pointer uppercase tracking-widest">
                        <option value="">SEMUA KATEGORI</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                @if(count($selectedProduk) > 0)
                <div class="flex items-center gap-3 animate-in zoom-in duration-300 bg-cyan-50 p-2 rounded-2xl border border-cyan-100">
                    <span class="text-[10px] font-black text-cyan-700 px-4 py-2 uppercase tracking-widest">{{ count($selectedProduk) }} Terpilih</span>
                    <button wire:click="bulkArchive" class="px-6 py-3 bg-white text-amber-600 border border-amber-100 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-amber-50">ARSIPKAN</button>
                    <button wire:click="bulkDelete" wire:confirm="Hapus permanen data terpilih?" class="px-6 py-3 bg-rose-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-rose-500/20">HAPUS MASSAL</button>
                </div>
                @endif
            </div>

            <!-- Grid Inventaris (Colorful Cards) -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">
                @forelse($produk as $p)
                <div class="group bg-white rounded-[45px] p-3 border border-slate-100 shadow-sm hover:shadow-2xl hover:border-cyan-200 transition-all duration-500 relative flex flex-col h-full">
                    <div class="absolute top-6 left-6 z-10">
                        <input type="checkbox" wire:model.live="selectedProduk" value="{{ $p->id }}" class="w-6 h-6 rounded-lg border-2 border-slate-200 text-cyan-600 focus:ring-cyan-500">
                    </div>
                    
                    <div class="aspect-square rounded-[38px] bg-slate-50 overflow-hidden relative mb-6 border border-slate-50">
                        <img src="{{ $p->gambar_utama ?? 'https://via.placeholder.com/400?text=TEQARA' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute bottom-4 left-4 right-4 flex justify-between items-end">
                            <span class="px-4 py-1.5 rounded-full bg-white/90 backdrop-blur-md text-[9px] font-black text-slate-800 uppercase tracking-widest shadow-sm border border-white/50">
                                {{ $p->kategori->nama ?? 'General' }}
                            </span>
                            <div class="w-10 h-10 rounded-2xl bg-slate-900/90 backdrop-blur-md flex items-center justify-center text-white shadow-lg">
                                <i class="fa-solid fa-microchip text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 pb-6 space-y-4 flex-grow flex flex-col">
                        <div>
                            <h3 class="font-black text-lg text-slate-800 leading-tight line-clamp-2 group-hover:text-cyan-600 transition-colors italic">{{ $p->nama }}</h3>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">{{ $p->kode_unit }}</span>
                                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                <span class="text-[9px] font-black text-cyan-500 uppercase">{{ $p->merek->nama ?? 'No Brand' }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4 border-y border-slate-50">
                            <div class="space-y-1">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Harga Jual</p>
                                <p class="text-lg font-black text-slate-900 italic">Rp{{ number_format($p->harga_jual, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right space-y-1">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Siklus Stok</p>
                                <p class="text-lg font-black {{ $p->stok < 5 ? 'text-rose-500 animate-pulse' : 'text-emerald-500' }}">{{ $p->stok }} <span class="text-[10px] text-slate-400 uppercase">Unit</span></p>
                            </div>
                        </div>

                        <div class="pt-2 flex gap-3 mt-auto">
                            <button wire:click="edit({{ $p->id }})" class="flex-1 py-3 bg-slate-50 text-slate-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-cyan-600 hover:text-white transition-all shadow-sm">Sunting Detail</button>
                            <button wire:click="hapus({{ $p->id }})" wire:confirm="Hapus SKU ini secara permanen?" class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-32 text-center bg-white rounded-[50px] border-2 border-dashed border-slate-100">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                        <i class="fa-solid fa-box-open text-4xl text-slate-200"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Gudang Masih Kosong</h3>
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Segera daftarkan produk baru untuk memulai siklus penjualan.</p>
                </div>
                @endforelse
            </div>

            <div class="pt-10">
                {{ $produk->links() }}
            </div>
        </div>
    @else
        <!-- 2. TAMPILAN EDITOR SKU (ADVANCED FORM - ONE PAGE) -->
        <div class="space-y-8 animate-in slide-in-from-right-10 duration-700">
            <!-- Header Sticky Editor -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 bg-white/80 backdrop-blur-xl p-8 rounded-[40px] shadow-2xl border border-white sticky top-24 z-30">
                <div class="flex items-center gap-6">
                    <button wire:click="batal" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-900 hover:text-white flex items-center justify-center transition-all shadow-inner">
                        <i class="fa-solid fa-chevron-left text-xl"></i>
                    </button>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase italic">{{ $produk_id ? 'Modifikasi Detail Unit' : 'Registrasi Inventaris Baru' }}</h1>
                        <p class="text-cyan-600 font-black uppercase tracking-[0.3em] text-[10px]">Pusat Data Master Teqara Enterprise</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-2xl text-sm font-black hover:bg-rose-50 hover:text-rose-600 transition-all uppercase tracking-widest">Batalkan</button>
                    <button wire:click="simpan" class="px-10 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-sm font-black shadow-xl shadow-emerald-600/30 transition-all active:scale-95 flex items-center gap-3 uppercase tracking-widest">
                        <i class="fa-solid fa-save"></i> SIMPAN PERUBAHAN
                    </button>
                </div>
            </div>

            <!-- Form Sidebar & Content -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <!-- Navigasi Internal Form (Tab) -->
                <div class="space-y-2">
                    @php
                        $menus = [
                            ['id' => 'dasar', 'label' => 'Informasi Dasar', 'icon' => 'fa-info-circle'],
                            ['id' => 'inventaris', 'label' => 'Inventaris & Varian', 'icon' => 'fa-boxes-stacked'],
                            ['id' => 'teknis', 'label' => 'Spesifikasi Teknis', 'icon' => 'fa-microchip'],
                            ['id' => 'finansial', 'label' => 'Finansial & B2B', 'icon' => 'fa-file-invoice-dollar'],
                            ['id' => 'media', 'label' => 'Media & Visual', 'icon' => 'fa-camera-retro'],
                        ];
                    @endphp
                    @foreach($menus as $menu)
                    <button @click="tabAktif = '{{ $menu['id'] }}'" :class="tabAktif === '{{ $menu['id'] }}' ? 'bg-cyan-600 text-white shadow-xl shadow-cyan-500/20' : 'bg-white text-slate-500 hover:bg-cyan-50 hover:text-cyan-600'" class="w-full flex items-center gap-4 px-6 py-5 rounded-2xl transition-all duration-300 text-sm font-black uppercase tracking-widest border border-transparent">
                        <i class="fa-solid {{ $menu['icon'] }} text-lg"></i>
                        {{ $menu['label'] }}
                    </button>
                    @endforeach
                </div>

                <!-- Konten Form Dinamis -->
                <div class="lg:col-span-3 space-y-8">
                    
                    <!-- TAB 1: INFORMASI DASAR -->
                    <div x-show="tabAktif === 'dasar'" class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10 animate-in fade-in duration-500">
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-widest border-b border-slate-100 pb-6 italic">Identitas Produk</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-3">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Nama SKU Lengkap</label>
                                <input wire:model="nama" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 text-sm font-black text-slate-800 focus:ring-4 focus:ring-cyan-500/10" placeholder="Cth: ROG Zephyrus G14 2024">
                                @error('nama') <span class="text-[10px] font-black text-rose-500 uppercase mt-2 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-3">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Kode Unit (SKU)</label>
                                <input wire:model="kode_unit" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 text-sm font-black text-cyan-600 focus:ring-4 focus:ring-cyan-500/10 uppercase font-mono" placeholder="ROG-G14-001">
                                @error('kode_unit') <span class="text-[10px] font-black text-rose-500 uppercase mt-2 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                            <div class="space-y-3">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Kategori</label>
                                <select wire:model="kategori_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 text-sm font-black text-slate-800 focus:ring-4 focus:ring-cyan-500/10 cursor-pointer">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategori as $kat) <option value="{{ $kat->id }}">{{ strtoupper($kat->nama) }}</option> @endforeach
                                </select>
                            </div>
                            <div class="space-y-3">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Merek</label>
                                <select wire:model="merek_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 text-sm font-black text-slate-800 focus:ring-4 focus:ring-cyan-500/10 cursor-pointer">
                                    <option value="">Pilih Brand</option>
                                    @foreach($merek as $mrk) <option value="{{ $mrk->id }}">{{ strtoupper($mrk->nama) }}</option> @endforeach
                                </select>
                            </div>
                            <div class="space-y-3">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Status Publikasi</label>
                                <select wire:model="status" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 text-sm font-black text-slate-800 focus:ring-4 focus:ring-cyan-500/10 cursor-pointer">
                                    <option value="aktif">🟢 Publik Aktif</option>
                                    <option value="arsip">📁 Arsip Internal</option>
                                    <option value="habis">🔴 Stok Habis</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Narasi Singkat (SEO)</label>
                            <textarea wire:model="deskripsi_singkat" rows="3" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 text-sm font-bold text-slate-600 focus:ring-4 focus:ring-cyan-500/10" placeholder="Ringkasan singkat untuk tampilan katalog..."></textarea>
                        </div>
                    </div>

                    <!-- TAB 2: INVENTARIS & VARIAN -->
                    <div x-show="tabAktif === 'inventaris'" class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10 animate-in fade-in duration-500">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-6">
                            <h3 class="text-xl font-black text-slate-900 uppercase tracking-widest italic">Kontrol Stok & Varian</h3>
                            <button type="button" wire:click="tambahBarisVarian" class="px-6 py-3 bg-cyan-50 text-cyan-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-cyan-600 hover:text-white transition-all">+ Tambah Varian Produk</button>
                        </div>

                        <!-- Stok Utama -->
                        <div class="bg-slate-50 p-8 rounded-[35px] border border-slate-100 flex items-center justify-between gap-10">
                            <div class="space-y-2">
                                <h4 class="text-sm font-black text-slate-800 uppercase italic">Stok Dasar Gudang Utama</h4>
                                <p class="text-xs text-slate-400 font-medium">Total unit fisik yang tersedia untuk SKU ini (non-varian).</p>
                            </div>
                            <div class="flex items-center gap-6">
                                <button type="button" @click="$wire.stok > 0 ? $wire.stok-- : 0" class="w-14 h-14 bg-white rounded-2xl shadow-sm text-slate-400 hover:text-rose-500 flex items-center justify-center transition-all"><i class="fa-solid fa-minus"></i></button>
                                <input wire:model="stok" type="number" class="w-24 bg-transparent border-none text-center text-4xl font-black text-slate-900 focus:ring-0">
                                <button type="button" @click="$wire.stok++" class="w-14 h-14 bg-white rounded-2xl shadow-sm text-slate-400 hover:text-emerald-500 flex items-center justify-center transition-all"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>

                        <!-- List Varian -->
                        <div class="space-y-6">
                            @foreach($varian as $idx => $v)
                            <div class="p-8 bg-white rounded-[35px] border border-slate-100 shadow-sm relative group hover:border-cyan-200 transition-all flex flex-wrap gap-8 items-end">
                                <button type="button" wire:click="hapusBarisVarian({{ $idx }})" class="absolute top-6 right-6 text-slate-200 hover:text-rose-500 transition-colors"><i class="fa-solid fa-trash-can"></i></button>
                                <div class="flex-1 min-w-[200px] space-y-3">
                                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Nama Varian (Warna/Size)</label>
                                    <input type="text" wire:model="varian.{{ $idx }}.nama" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-black shadow-inner">
                                </div>
                                <div class="w-32 space-y-3">
                                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Stok Varian</label>
                                    <input type="number" wire:model="varian.{{ $idx }}.stok" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-black shadow-inner">
                                </div>
                                <div class="w-48 space-y-3">
                                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Harga Tambahan (+)</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-emerald-500">Rp</span>
                                        <input type="number" wire:model="varian.{{ $idx }}.harga_tambahan" class="w-full bg-slate-50 border-none rounded-xl pl-10 pr-4 py-3 text-xs font-black text-emerald-600 shadow-inner">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- TAB 3: SPESIFIKASI TEKNIS -->
                    <div x-show="tabAktif === 'teknis'" class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10 animate-in fade-in duration-500">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-6">
                            <h3 class="text-xl font-black text-slate-900 uppercase tracking-widest italic">Parameter Teknis</h3>
                            <button type="button" wire:click="tambahBarisSpesifikasi" class="px-6 py-3 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all">+ Tambah Baris Spek</button>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            @foreach($spesifikasi as $idx => $s)
                            <div class="flex gap-4 items-center animate-in slide-in-from-left duration-300">
                                <div class="w-1/3">
                                    <input type="text" wire:model="spesifikasi.{{ $idx }}.judul" placeholder="Judul (Contoh: RAM)" class="w-full bg-slate-50 border-none rounded-xl px-6 py-4 text-xs font-black text-slate-700 uppercase tracking-widest shadow-inner">
                                </div>
                                <div class="flex-1">
                                    <input type="text" wire:model="spesifikasi.{{ $idx }}.nilai" placeholder="Nilai (Contoh: 32GB DDR5)" class="w-full bg-white border border-slate-100 rounded-xl px-6 py-4 text-xs font-bold text-slate-600 shadow-sm">
                                </div>
                                <button type="button" wire:click="hapusBarisSpesifikasi({{ $idx }})" class="p-4 text-slate-300 hover:text-rose-500 transition-colors"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- TAB 4: FINANSIAL & B2B -->
                    <div x-show="tabAktif === 'finansial'" class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10 animate-in fade-in duration-500">
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-widest border-b border-slate-100 pb-6 italic">Parameter Finansial & Grosir</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="bg-emerald-50 p-8 rounded-[35px] border border-emerald-100 space-y-4">
                                <label class="block text-xs font-black text-emerald-700 uppercase tracking-[0.3em]">Harga Jual Publik (Retail)</label>
                                <div class="relative">
                                    <span class="absolute left-6 top-1/2 -translate-y-1/2 text-2xl font-black text-emerald-300">Rp</span>
                                    <input wire:model="harga_jual" type="number" class="w-full bg-white border-none rounded-2xl pl-16 pr-6 py-6 text-3xl font-black text-emerald-600 shadow-inner">
                                </div>
                            </div>
                            <div class="bg-rose-50 p-8 rounded-[35px] border border-rose-100 space-y-4">
                                <label class="block text-xs font-black text-rose-700 uppercase tracking-[0.3em]">Harga Modal (HPP Enterprise)</label>
                                <div class="relative">
                                    <span class="absolute left-6 top-1/2 -translate-y-1/2 text-2xl font-black text-rose-300">Rp</span>
                                    <input wire:model="harga_modal" type="number" class="w-full bg-white border-none rounded-2xl pl-16 pr-6 py-6 text-3xl font-black text-rose-600 shadow-inner">
                                </div>
                            </div>
                        </div>

                        <!-- Harga Grosir B2B -->
                        <div class="space-y-6">
                            <div class="flex justify-between items-center">
                                <h4 class="text-sm font-black text-slate-800 uppercase italic">Skema Harga Grosir (B2B)</h4>
                                <button type="button" wire:click="tambahBarisGrosir" class="px-4 py-2 bg-amber-50 text-amber-600 rounded-lg text-[10px] font-black uppercase tracking-widest">+ Skema Baru</button>
                            </div>
                            @foreach($harga_grosir as $idx => $g)
                            <div class="flex gap-6 items-center bg-slate-50 p-6 rounded-3xl border border-slate-100">
                                <div class="flex-1 space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase">Min. Pembelian (Unit)</label>
                                    <input type="number" wire:model="harga_grosir.{{ $idx }}.min_qty" class="w-full bg-white border-none rounded-xl px-4 py-3 text-sm font-black shadow-sm">
                                </div>
                                <div class="flex-[2] space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase">Harga Satuan Grosir</label>
                                    <input type="number" wire:model="harga_grosir.{{ $idx }}.harga" class="w-full bg-white border-none rounded-xl px-4 py-3 text-sm font-black text-amber-600 shadow-sm">
                                </div>
                                <button type="button" wire:click="hapusBarisGrosir({{ $idx }})" class="p-4 text-slate-300 hover:text-rose-500 transition-colors mt-6"><i class="fa-solid fa-trash-can text-sm"></i></button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- TAB 5: MEDIA & VISUAL -->
                    <div x-show="tabAktif === 'media'" class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10 animate-in fade-in duration-500">
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-widest border-b border-slate-100 pb-6 italic">Aset Media Produk</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-6">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Gambar Utama SKU</label>
                                <div class="relative group aspect-square rounded-[40px] bg-slate-50 border-4 border-dashed border-slate-100 flex items-center justify-center overflow-hidden transition-all hover:border-cyan-200">
                                    @if($gambar_baru)
                                        <img src="{{ $gambar_baru->temporaryUrl() }}" class="w-full h-full object-cover">
                                    @elseif($gambar_lama)
                                        <img src="{{ asset($gambar_lama) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="text-center space-y-4">
                                            <i class="fa-solid fa-camera-retro text-6xl text-slate-200 group-hover:text-cyan-400 transition-colors"></i>
                                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Unggah Foto Utama</p>
                                        </div>
                                    @endif
                                    <input type="file" wire:model="gambar_baru" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                    <div wire:loading wire:target="gambar_baru" class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-20">
                                        <i class="fa-solid fa-spinner animate-spin text-3xl text-cyan-600"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-slate-900 rounded-[40px] p-8 text-white flex flex-col justify-center space-y-6">
                                <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-2xl text-cyan-400 shadow-lg border border-white/5">
                                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                                </div>
                                <h4 class="text-xl font-black uppercase italic leading-tight">Optimasi Visual Otomatis</h4>
                                <p class="text-sm text-slate-400 font-medium leading-relaxed">Sistem akan secara otomatis melakukan kompresi, pemberian watermark, dan penyesuaian rasio gambar untuk performa toko yang maksimal.</p>
                                <ul class="space-y-3">
                                    <li class="flex items-center gap-3 text-[10px] font-black uppercase tracking-widest text-emerald-400">
                                        <i class="fa-solid fa-check-circle"></i> Auto-Resize 1000x1000px
                                    </li>
                                    <li class="flex items-center gap-3 text-[10px] font-black uppercase tracking-widest text-emerald-400">
                                        <i class="fa-solid fa-check-circle"></i> WebP Next-Gen Format
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif

</div>