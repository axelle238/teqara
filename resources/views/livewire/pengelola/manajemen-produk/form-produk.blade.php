<div class="pb-20">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Editor <span class="text-emerald-600">Unit</span></h1>
            <p class="text-slate-500 font-medium">Konfigurasi mendalam parameter produk dan spesifikasi teknis.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('pengelola.produk.katalog') }}" wire:navigate class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition-all">
                Batal
            </a>
            <button wire:click="simpan" class="px-8 py-3 bg-emerald-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">
                Simpan Perubahan
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Sidebar Navigasi (Sticky) -->
        <div class="lg:col-span-3 sticky top-24 space-y-2 hidden lg:block">
            <button wire:click="$set('activeTab', 'info')" class="w-full text-left px-5 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest transition-all {{ $activeTab === 'info' ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-100' }}">
                <i class="fa-solid fa-circle-info mr-3"></i> Informasi Dasar
            </button>
            <button wire:click="$set('activeTab', 'media')" class="w-full text-left px-5 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest transition-all {{ $activeTab === 'media' ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-100' }}">
                <i class="fa-solid fa-images mr-3"></i> Galeri Visual
            </button>
            <button wire:click="$set('activeTab', 'varian')" class="w-full text-left px-5 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest transition-all {{ $activeTab === 'varian' ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-100' }}">
                <i class="fa-solid fa-layer-group mr-3"></i> Varian Unit
            </button>
            <button wire:click="$set('activeTab', 'spesifikasi')" class="w-full text-left px-5 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest transition-all {{ $activeTab === 'spesifikasi' ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-100' }}">
                <i class="fa-solid fa-list-check mr-3"></i> Spesifikasi
            </button>
            <button wire:click="$set('activeTab', 'logistik')" class="w-full text-left px-5 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest transition-all {{ $activeTab === 'logistik' ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-100' }}">
                <i class="fa-solid fa-truck-fast mr-3"></i> Logistik
            </button>
            <button wire:click="$set('activeTab', 'seo')" class="w-full text-left px-5 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest transition-all {{ $activeTab === 'seo' ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-100' }}">
                <i class="fa-solid fa-magnifying-glass mr-3"></i> SEO & Metadata
            </button>
        </div>

        <!-- Form Content -->
        <div class="lg:col-span-9 space-y-8">
            
            <!-- 1. Informasi Dasar -->
            <div class="{{ $activeTab === 'info' ? 'block' : 'hidden' }} space-y-6">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-6 border-b border-slate-100 pb-4">Identitas Unit</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Produk</label>
                            <input type="text" wire:model.live="nama" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 placeholder-slate-300" placeholder="Contoh: MacBook Pro M3 Max">
                            @error('nama') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kode Unit (SKU)</label>
                            <input type="text" wire:model="kode_unit" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-mono text-sm font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 uppercase" placeholder="MBP-M3-16">
                            @error('kode_unit') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Slug (URL)</label>
                            <input type="text" wire:model="slug" class="w-full px-5 py-4 bg-slate-100 border-none rounded-xl font-mono text-xs text-slate-500 cursor-not-allowed" readonly>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori</label>
                            <select wire:model="kategori_id" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                                <option value="">Pilih Kategori</option>
                                @foreach($daftarKategori as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Merek</label>
                            <select wire:model="merek_id" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                                <option value="">Pilih Merek</option>
                                @foreach($daftarMerek as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                                @endforeach
                            </select>
                            @error('merek_id') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-6 border-b border-slate-100 pb-4">Parameter Niaga</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Harga Modal</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">Rp</span>
                                <input type="number" wire:model="harga_modal" class="w-full pl-10 pr-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Harga Jual</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-600 font-bold text-xs">Rp</span>
                                <input type="number" wire:model="harga_jual" class="w-full pl-10 pr-5 py-4 bg-emerald-50 border-none rounded-xl font-black text-emerald-800 focus:ring-2 focus:ring-emerald-500 text-lg">
                            </div>
                            @error('harga_jual') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Stok Awal</label>
                            <input type="number" wire:model="stok" {{ $tipe_produk === 'bundle' || $memiliki_varian ? 'disabled' : '' }} class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 disabled:bg-slate-100 disabled:text-slate-400">
                            @if($tipe_produk === 'bundle' || $memiliki_varian)
                                <p class="text-[9px] text-slate-400 mt-1 font-bold">Stok dihitung dari varian/komponen.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-6 border-b border-slate-100 pb-4">Naratif Produk</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Singkat (Excerpt)</label>
                            <textarea wire:model="deskripsi_singkat" rows="3" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-medium text-slate-600 focus:ring-2 focus:ring-emerald-500 resize-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Lengkap</label>
                            <textarea wire:model="deskripsi_lengkap" rows="10" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-medium text-slate-600 focus:ring-2 focus:ring-emerald-500 resize-none"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Galeri Visual -->
            <div class="{{ $activeTab === 'media' ? 'block' : 'hidden' }}">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-6 border-b border-slate-100 pb-4">Galeri Visual</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                        @foreach($gambar_lama as $img)
                        <div class="relative group aspect-square bg-slate-100 rounded-2xl overflow-hidden border border-slate-200">
                            <img src="{{ $img['url'] }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button wire:click="hapusGambarLama({{ $img['id'] }})" class="w-10 h-10 bg-white rounded-full text-rose-500 hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach

                        @if($gambar_baru)
                            @foreach($gambar_baru as $tempImg)
                            <div class="relative aspect-square bg-emerald-50 rounded-2xl overflow-hidden border border-emerald-200">
                                <img src="{{ $tempImg->temporaryUrl() }}" class="w-full h-full object-cover opacity-80">
                                <div class="absolute bottom-2 right-2 bg-emerald-600 text-white text-[10px] px-2 py-1 rounded-lg font-bold">Baru</div>
                            </div>
                            @endforeach
                        @endif

                        <label class="aspect-square rounded-2xl border-2 border-dashed border-slate-300 flex flex-col items-center justify-center cursor-pointer hover:border-emerald-500 hover:bg-emerald-50 transition-all group">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-300 group-hover:text-emerald-500 mb-2 transition-colors"></i>
                            <span class="text-xs font-black text-slate-400 group-hover:text-emerald-600 uppercase tracking-wider">Upload</span>
                            <input type="file" wire:model="gambar_baru" multiple class="hidden">
                        </label>
                    </div>
                </div>
            </div>

            <!-- 3. Varian -->
            <div class="{{ $activeTab === 'varian' ? 'block' : 'hidden' }}">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Variasi Produk</h3>
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-slate-500 uppercase">Aktifkan Varian?</span>
                            <button wire:click="$toggle('memiliki_varian')" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none {{ $memiliki_varian ? 'bg-emerald-500' : 'bg-slate-200' }}">
                                <span class="translate-x-1 inline-block h-4 w-4 transform rounded-full bg-white transition {{ $memiliki_varian ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                        </div>
                    </div>

                    @if($memiliki_varian)
                        <div class="space-y-4">
                            @foreach($daftarVarian as $index => $varian)
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 items-end">
                                <div class="md:col-span-4">
                                    <label class="text-[9px] font-black text-slate-400 uppercase">Nama Varian</label>
                                    <input type="text" wire:model="daftarVarian.{{ $index }}.nama_varian" class="w-full px-3 py-2 bg-white border-none rounded-lg text-sm font-bold shadow-sm" placeholder="Contoh: Merah, 8GB">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="text-[9px] font-black text-slate-400 uppercase">Kode Unik</label>
                                    <input type="text" wire:model="daftarVarian.{{ $index }}.kode_unit" class="w-full px-3 py-2 bg-white border-none rounded-lg text-sm font-mono shadow-sm uppercase">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase">Stok</label>
                                    <input type="number" wire:model="daftarVarian.{{ $index }}.stok" class="w-full px-3 py-2 bg-white border-none rounded-lg text-sm font-bold shadow-sm">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase">+ Harga</label>
                                    <input type="number" wire:model="daftarVarian.{{ $index }}.harga_tambahan" class="w-full px-3 py-2 bg-white border-none rounded-lg text-sm font-bold shadow-sm">
                                </div>
                                <div class="md:col-span-1">
                                    <button wire:click="hapusBarisVarian({{ $index }})" class="w-full py-2 bg-rose-100 text-rose-500 rounded-lg hover:bg-rose-500 hover:text-white transition-colors">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                            
                            <button wire:click="tambahBarisVarian" class="w-full py-3 border-2 border-dashed border-slate-300 rounded-xl text-slate-400 font-bold text-xs uppercase tracking-widest hover:border-emerald-500 hover:text-emerald-600 transition-all">
                                <i class="fa-solid fa-plus mr-2"></i> Tambah Varian Baru
                            </button>
                        </div>
                    @else
                        <div class="text-center py-10 text-slate-400 font-medium">
                            <i class="fa-solid fa-cube text-4xl mb-3 opacity-50"></i>
                            <p>Produk ini adalah unit tunggal tanpa variasi.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 4. Spesifikasi -->
            <div class="{{ $activeTab === 'spesifikasi' ? 'block' : 'hidden' }}">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Spesifikasi Teknis</h3>
                        <div class="flex gap-2">
                            <button wire:click="terapkanTemplate('laptop')" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-indigo-100">Template Laptop</button>
                            <button wire:click="terapkanTemplate('smartphone')" class="px-4 py-2 bg-purple-50 text-purple-600 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-purple-100">Template HP</button>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @foreach($daftarSpesifikasi as $index => $spek)
                        <div class="flex gap-4 items-center group">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-black text-slate-400">{{ $index + 1 }}</div>
                            <input type="text" wire:model="daftarSpesifikasi.{{ $index }}.label" class="w-1/3 px-4 py-3 bg-slate-50 border-none rounded-xl font-bold text-slate-700 placeholder-slate-300 focus:ring-2 focus:ring-emerald-500" placeholder="Label (Misal: Processor)">
                            <input type="text" wire:model="daftarSpesifikasi.{{ $index }}.nilai" class="w-2/3 px-4 py-3 bg-slate-50 border-none rounded-xl font-medium text-slate-600 placeholder-slate-300 focus:ring-2 focus:ring-emerald-500" placeholder="Nilai (Misal: Intel Core i9)">
                            <button wire:click="hapusBarisSpesifikasi({{ $index }})" class="text-slate-300 hover:text-rose-500 transition-colors">
                                <i class="fa-solid fa-xmark text-xl"></i>
                            </button>
                        </div>
                        @endforeach

                        <button wire:click="tambahBarisSpesifikasi" class="mt-4 px-6 py-2 bg-slate-100 text-slate-500 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition-all">
                            + Baris Baru
                        </button>
                    </div>
                </div>
            </div>

            <!-- 5. Logistik -->
            <div class="{{ $activeTab === 'logistik' ? 'block' : 'hidden' }}">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-6 border-b border-slate-100 pb-4">Dimensi & Pengiriman</h3>
                    
                    <div class="grid grid-cols-3 gap-6 mb-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Panjang (cm)</label>
                            <input type="number" wire:model="dimensi.p" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Lebar (cm)</label>
                            <input type="number" wire:model="dimensi.l" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tinggi (cm)</label>
                            <input type="number" wire:model="dimensi.t" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Berat (Gram)</label>
                        <div class="relative">
                            <input type="number" wire:model="berat_gram" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800">
                            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-xs font-black text-slate-400">GR</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. SEO & Metadata -->
            <div class="{{ $activeTab === 'seo' ? 'block' : 'hidden' }}">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-6 border-b border-slate-100 pb-4">Optimasi Mesin Pencari</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Meta Judul (Title Tag)</label>
                            <input type="text" wire:model="meta_judul" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500" placeholder="Judul yang tampil di Google">
                            <p class="text-[10px] text-slate-400 mt-2">Biarkan kosong untuk menggunakan nama produk secara otomatis.</p>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Meta Deskripsi</label>
                            <textarea wire:model="meta_deskripsi" rows="4" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-medium text-slate-600 focus:ring-2 focus:ring-emerald-500 resize-none" placeholder="Ringkasan menarik untuk hasil pencarian..."></textarea>
                        </div>

                        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Pratinjau Hasil Pencarian</p>
                            <div class="font-sans">
                                <p class="text-sm text-blue-800 hover:underline cursor-pointer truncate font-medium">{{ $meta_judul ?: ($nama ?: 'Judul Produk') }} - Teqara Enterprise</p>
                                <p class="text-xs text-emerald-700 truncate">https://teqara.com/produk/{{ $slug ?: 'slug-produk' }}</p>
                                <p class="text-xs text-slate-600 line-clamp-2 mt-1">{{ $meta_deskripsi ?: ($deskripsi_singkat ?: 'Deskripsi produk akan muncul di sini...') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
