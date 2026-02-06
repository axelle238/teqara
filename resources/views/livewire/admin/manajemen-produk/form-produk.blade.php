<div class="max-w-7xl mx-auto pb-20">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $produkId ? 'Edit Produk' : 'Produk Baru' }}</h1>
            <p class="text-slate-500 text-sm">Kelola informasi, varian, dan media produk secara detail.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.produk.katalog') }}" wire:navigate class="px-4 py-2 bg-white border border-slate-300 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-50 transition">Batal</a>
            <button wire:click="simpan" class="px-6 py-2 bg-cyan-600 text-white rounded-xl text-sm font-bold hover:bg-cyan-700 shadow-lg shadow-cyan-600/30 transition">Simpan Produk</button>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="mb-6 border-b border-slate-200">
        <nav class="-mb-px flex space-x-8 overflow-x-auto custom-scrollbar" aria-label="Tabs">
            <button wire:click="$set('activeTab', 'info')" class="{{ $activeTab === 'info' ? 'border-cyan-500 text-cyan-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition">
                Informasi Dasar
            </button>
            <button wire:click="$set('activeTab', 'media')" class="{{ $activeTab === 'media' ? 'border-cyan-500 text-cyan-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition">
                Media & Galeri
            </button>
            <button wire:click="$set('activeTab', 'varian')" class="{{ $activeTab === 'varian' ? 'border-cyan-500 text-cyan-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition" style="{{ $tipe_produk === 'bundle' ? 'display:none;' : '' }}">
                Varian & Harga
            </button>
            <button wire:click="$set('activeTab', 'bundling')" class="{{ $activeTab === 'bundling' ? 'border-cyan-500 text-cyan-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition" style="{{ $tipe_produk !== 'bundle' ? 'display:none;' : '' }}">
                Komponen Paket
            </button>
            <button wire:click="$set('activeTab', 'logistik')" class="{{ $activeTab === 'logistik' ? 'border-cyan-500 text-cyan-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition">
                Logistik & Dimensi
            </button>
            <button wire:click="$set('activeTab', 'spesifikasi')" class="{{ $activeTab === 'spesifikasi' ? 'border-cyan-500 text-cyan-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition">
                Spesifikasi Teknis
            </button>
            <button wire:click="$set('activeTab', 'seo')" class="{{ $activeTab === 'seo' ? 'border-cyan-500 text-cyan-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition">
                SEO & Metadata
            </button>
        </nav>
    </div>

    <!-- Tab Contents -->
    <div class="space-y-8">
        
        <!-- Tab 1: Informasi Dasar -->
        <div x-show="$wire.activeTab === 'info'" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Identitas Produk</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Nama Produk</label>
                            <input wire:model.live="nama" type="text" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500" placeholder="Contoh: MacBook Pro M3">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">KODE UNIT (Kode Stok)</label>
                                <input wire:model="kode_unit" type="text" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Slug URL</label>
                                <input wire:model="slug" type="text" class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-500" readonly>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                            <textarea wire:model="deskripsi_singkat" rows="3" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Deskripsi Lengkap (HTML Support)</label>
                            <textarea wire:model="deskripsi_lengkap" rows="6" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Pengelompokan</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Klasifikasi Produk</label>
                            <select wire:model.live="tipe_produk" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500 font-bold text-slate-900 bg-slate-50">
                                <option value="fisik">📦 Produk Fisik (Standard)</option>
                                <option value="bundle">🎁 Paket Bundling</option>
                                <option value="digital">☁️ Produk Digital</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Status</label>
                            <select wire:model="status" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500">
                                <option value="aktif">🟢 PUBLIKASI AKTIF</option>
                                <option value="arsip">⚪ ARSIP INTERNAL</option>
                                <option value="habis">🔴 STOK KOSONG</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Kategori</label>
                            <select wire:model="kategori_id" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500">
                                <option value="">Pilih Kategori</option>
                                @foreach($daftarKategori as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Merek</label>
                            <select wire:model="merek_id" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500">
                                <option value="">Pilih Merek</option>
                                @foreach($daftarMerek as $merk)
                                    <option value="{{ $merk->id }}">{{ $merk->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Harga & Stok Dasar</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Harga Jual (Rp)</label>
                            <input wire:model="harga_jual" type="number" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Harga Modal (Rp)</label>
                            <input wire:model="harga_modal" type="number" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Stok Total</label>
                            <input wire:model="stok" type="number" class="w-full rounded-xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500" {{ $tipe_produk === 'bundle' ? 'disabled bg-slate-100' : '' }}>
                            @if($tipe_produk === 'bundle')
                                <p class="text-[10px] text-slate-500 mt-1">Stok bundle dihitung otomatis dari komponen.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Media -->
        <div x-show="$wire.activeTab === 'media'" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Galeri Produk</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
                <!-- Existing Images -->
                @foreach($gambar_lama as $img)
                <div class="relative group aspect-square rounded-xl overflow-hidden border border-slate-200">
                    <img src="{{ $img['url'] }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                        <button type="button" wire:click="hapusGambarLama({{ $img['id'] }})" class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
                @endforeach

                <!-- Upload Placeholder -->
                <label class="border-2 border-dashed border-slate-300 rounded-xl flex flex-col items-center justify-center p-4 cursor-pointer hover:border-cyan-500 hover:bg-cyan-50 transition aspect-square">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span class="text-xs font-bold text-slate-500 mt-2 text-center">Tambah Foto</span>
                    <input type="file" wire:model="gambar_baru" multiple class="hidden">
                </label>
            </div>

            @if($gambar_baru)
                <p class="text-sm text-emerald-600 font-bold">{{ count($gambar_baru) }} gambar baru siap diunggah.</p>
            @endif
        </div>

        <!-- Tab 3: Varian -->
        <div x-show="$wire.activeTab === 'varian'" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input wire:model.live="memiliki_varian" type="checkbox" class="w-5 h-5 text-cyan-600 rounded border-slate-300 focus:ring-cyan-500">
                    <label class="ml-2 text-lg font-bold text-slate-900">Aktifkan Varian Produk</label>
                </div>
                <button type="button" wire:click="tambahBarisVarian" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-bold hover:bg-slate-200" {{ !$memiliki_varian ? 'disabled' : '' }}>+ Tambah Baris</button>
            </div>

            @if($memiliki_varian)
            <div class="overflow-x-auto mb-10">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Nama Varian (Warna/Size)</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">KODE UNIT Unik</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Tambahan Harga (Rp)</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Stok</th>
                            <th class="px-4 py-3 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($daftarVarian as $index => $varian)
                        <tr>
                            <td class="px-4 py-2">
                                <input wire:model="daftarVarian.{{ $index }}.nama_varian" type="text" class="w-full rounded-lg border-slate-200 text-sm" placeholder="Merah / XL">
                            </td>
                            <td class="px-4 py-2">
                                <input wire:model="daftarVarian.{{ $index }}.kode_unit" type="text" class="w-full rounded-lg border-slate-200 text-sm">
                            </td>
                            <td class="px-4 py-2">
                                <input wire:model="daftarVarian.{{ $index }}.harga_tambahan" type="number" class="w-full rounded-lg border-slate-200 text-sm">
                            </td>
                            <td class="px-4 py-2">
                                <input wire:model="daftarVarian.{{ $index }}.stok" type="number" class="w-full rounded-lg border-slate-200 text-sm">
                            </td>
                            <td class="px-4 py-2 text-right">
                                <button type="button" wire:click="hapusBarisVarian({{ $index }})" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Wholesale Pricing -->
            <div class="mt-8 border-t border-slate-100 pt-8">
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-900">Harga Grosir (Tiered Pricing)</h3>
                    <button type="button" wire:click="tambahBarisGrosir" class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-bold hover:bg-emerald-100">+ Tambah Tier</button>
                </div>
                <div class="space-y-3">
                    @foreach($daftarGrosir as $index => $grosir)
                    <div class="flex gap-4 items-center bg-emerald-50/30 p-3 rounded-xl border border-emerald-100">
                        <div class="flex-1">
                            <label class="text-[10px] font-bold text-slate-500 uppercase">Min. Kuantitas</label>
                            <input wire:model="daftarGrosir.{{ $index }}.min_qty" type="number" class="w-full rounded-lg border-slate-200 text-sm font-bold">
                        </div>
                        <div class="flex-1">
                            <label class="text-[10px] font-bold text-slate-500 uppercase">Harga Satuan (Rp)</label>
                            <input wire:model="daftarGrosir.{{ $index }}.harga" type="number" class="w-full rounded-lg border-slate-200 text-sm font-bold text-emerald-700">
                        </div>
                        <button type="button" wire:click="hapusBarisGrosir({{ $index }})" class="mt-4 p-2 text-rose-500 hover:bg-rose-50 rounded-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    @endforeach
                    @if(empty($daftarGrosir))
                        <p class="text-center text-slate-400 text-sm italic">Belum ada konfigurasi harga grosir.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab: Bundling -->
        <div x-show="$wire.activeTab === 'bundling'" class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 space-y-8">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Komposisi Paket Bundling</h3>
                    <p class="text-sm text-slate-500">Tentukan produk apa saja yang termasuk dalam paket ini.</p>
                </div>
                <button type="button" wire:click="tambahBarisBundling" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-500/20">+ Tambah Komponen</button>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-widest">Produk Komponen</th>
                            <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-widest w-40">Jumlah (Qty)</th>
                            <th class="px-6 py-4 w-20"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($daftarBundling as $index => $bund)
                        <tr>
                            <td class="px-6 py-4">
                                <select wire:model="daftarBundling.{{ $index }}.child_id" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-indigo-500">
                                    <option value="">Pilih Produk</option>
                                    @foreach($semuaProduk as $p)
                                        @if($p->id != $produkId) 
                                            <option value="{{ $p->id }}">{{ $p->nama }} (Stok: {{ $p->stok }})</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <input wire:model="daftarBundling.{{ $index }}.jumlah" type="number" min="1" class="w-full rounded-xl border-slate-200 text-sm font-bold text-center focus:ring-indigo-500">
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button type="button" wire:click="hapusBarisBundling({{ $index }})" class="p-2 bg-rose-50 text-rose-500 rounded-lg hover:bg-rose-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @if(empty($daftarBundling))
                        <tr><td colspan="3" class="px-6 py-12 text-center text-slate-400 font-medium italic">Belum ada komponen dalam paket ini.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab 4: Logistik -->
        <div x-show="$wire.activeTab === 'logistik'" class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 space-y-8">
            <h3 class="text-lg font-bold text-slate-900">Dimensi & Pengiriman</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Panjang (cm)</label>
                    <input wire:model="dimensi.p" type="number" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Lebar (cm)</label>
                    <input wire:model="dimensi.l" type="number" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Tinggi (cm)</label>
                    <input wire:model="dimensi.t" type="number" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500">
                </div>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl flex items-center gap-4 border border-slate-200">
                <div class="p-3 bg-white rounded-lg shadow-sm">⚖️</div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase">Estimasi Volume</p>
                    <p class="text-lg font-black text-slate-900">
                        {{ number_format((($dimensi['p'] ?? 0) * ($dimensi['l'] ?? 0) * ($dimensi['t'] ?? 0)) / 6000, 2) }} kg (Volumetrik)
                    </p>
                </div>
            </div>
        </div>

        <!-- Tab 5: Spesifikasi -->
        <div x-show="$wire.activeTab === 'spesifikasi'" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-900">Spesifikasi Teknis</h3>
                <button type="button" wire:click="tambahBarisSpesifikasi" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-bold hover:bg-slate-200">+ Tambah Spesifikasi</button>
            </div>
            
            <div class="space-y-3">
                @foreach($daftarSpesifikasi as $index => $spek)
                <div class="flex gap-4">
                    <input wire:model="daftarSpesifikasi.{{ $index }}.label" type="text" class="flex-1 rounded-lg border-slate-200 text-sm" placeholder="Judul (Processor)">
                    <input wire:model="daftarSpesifikasi.{{ $index }}.nilai" type="text" class="flex-1 rounded-lg border-slate-200 text-sm" placeholder="Nilai (Intel i9)">
                    <button type="button" wire:click="hapusBarisSpesifikasi({{ $index }})" class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tab 6: SEO -->
        <div x-show="$wire.activeTab === 'seo'" class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 space-y-6">
            <h3 class="text-lg font-bold text-slate-900">Optimasi Mesin Pencari</h3>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Meta Title</label>
                <input wire:model="meta_judul" type="text" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500" placeholder="{{ $nama }}">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Meta Description</label>
                <textarea wire:model="meta_deskripsi" rows="3" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500" placeholder="{{ $deskripsi_singkat }}"></textarea>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                <p class="text-xs font-bold text-slate-400 uppercase mb-2">Pratinjau Google</p>
                <div class="font-sans">
                    <p class="text-xs text-slate-600">teqara.id › produk › {{ $slug }}</p>
                    <h4 class="text-lg text-blue-800 hover:underline cursor-pointer truncate">{{ $meta_judul ?: $nama }}</h4>
                    <p class="text-sm text-slate-600 line-clamp-2">{{ $meta_deskripsi ?: $deskripsi_singkat }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
