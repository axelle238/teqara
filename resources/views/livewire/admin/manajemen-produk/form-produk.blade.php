<div class="space-y-12 pb-32">
    <!-- Header Command Hub -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <div class="flex items-center gap-8">
            <a href="{{ route('admin.produk.katalog') }}" wire:navigate class="w-16 h-16 rounded-[24px] bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-indigo-600 hover:text-white transition-all shadow-inner group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 mb-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                    <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em]">Editor Command Center</span>
                </div>
                <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">
                    {{ $produkId ? 'MODIFIKASI' : 'REGISTRASI' }} <span class="text-indigo-600">UNIT</span>
                </h1>
                <p class="text-slate-500 font-medium text-lg">Konfigurasi parameter mendalam untuk unit: <span class="font-black text-slate-900 uppercase">{{ $nama ?: 'Tanpa Nama' }}</span></p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button wire:click="simpan" class="px-10 py-5 bg-slate-900 text-white rounded-[28px] font-black text-xs uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/20 hover:bg-indigo-600 hover:scale-[1.02] active:scale-95 transition-all group">
                <span wire:loading.remove>EKSEKUSI SINKRONISASI</span>
                <span wire:loading>MENYINKRONKAN...</span>
            </button>
        </div>
    </div>

    <!-- Navigation Controller -->
    <div class="bg-white rounded-full p-2 shadow-sm border border-indigo-50 flex items-center gap-2 max-w-4xl mx-auto overflow-x-auto whitespace-nowrap scrollbar-hide">
        @php
            $tabs = [
                'info' => ['label' => 'Identitas Dasar', 'icon' => '🆔'],
                'media' => ['label' => 'Aset Visual', 'icon' => '🖼️'],
                'varian' => ['label' => 'Matriks Varian', 'icon' => '🎭'],
                'spesifikasi' => ['label' => 'Parameter Teknis', 'icon' => '⚙️'],
                'seo' => ['label' => 'Otoritas SEO', 'icon' => '🌍'],
            ];
        @endphp

        @foreach($tabs as $key => $tab)
        <button 
            wire:click="$set('activeTab', '{{ $key }}')"
            class="flex items-center gap-3 px-8 py-4 rounded-full text-[10px] font-black uppercase tracking-widest transition-all {{ $activeTab === $key ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}"
        >
            <span class="text-lg">{{ $tab['icon'] }}</span>
            {{ $tab['label'] }}
        </button>
        @endforeach
    </div>

    <!-- Operational Area -->
    <div class="animate-in fade-in slide-in-from-bottom-8 duration-700">
        
        <!-- Tab: Info Dasar -->
        @if($activeTab === 'info')
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <div class="lg:col-span-8 space-y-10">
                <div class="bg-white p-12 rounded-[56px] shadow-sm border border-indigo-50 space-y-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-xl">01</div>
                        <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Data Utama Perangkat</h3>
                    </div>
                    <div class="space-y-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Unit Lengkap</label>
                            <input wire:model.live="nama" type="text" class="w-full rounded-3xl border-none bg-slate-50 px-8 py-5 text-lg font-black text-slate-900 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300 transition-all">
                            @error('nama') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kode Unit (ERP SKU)</label>
                                <input wire:model="kode_unit" type="text" class="w-full rounded-3xl border-none bg-slate-50 px-8 py-5 text-sm font-black text-indigo-600 focus:ring-4 focus:ring-indigo-500/10 transition-all uppercase">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Identifier Slug (Auto)</label>
                                <input wire:model="slug" type="text" disabled class="w-full rounded-3xl border-none bg-indigo-50/30 px-8 py-5 text-sm font-bold text-slate-400 cursor-not-allowed">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Narasi Deskriptif Lengkap</label>
                            <textarea wire:model="deskripsi_lengkap" rows="10" class="w-full rounded-[40px] border-none bg-slate-50 px-8 py-6 text-sm font-medium text-slate-700 focus:ring-4 focus:ring-indigo-500/10 transition-all"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="lg:col-span-4 space-y-10">
                <div class="bg-white p-10 rounded-[56px] shadow-sm border border-indigo-50 space-y-8">
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight flex items-center gap-3">
                        <span class="w-8 h-1.5 bg-emerald-500 rounded-full"></span>
                        Status & Harga
                    </h3>
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Status Publikasi</label>
                            <select wire:model="status" class="w-full rounded-[24px] border-none bg-slate-50 px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                                <option value="aktif">🟢 PUBLIKASI AKTIF</option>
                                <option value="arsip">⚪ ARSIP INTERNAL</option>
                                <option value="habis">🔴 STOK KOSONG</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kategori Induk</label>
                            <select wire:model="kategori_id" class="w-full rounded-[24px] border-none bg-slate-50 px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                                <option value="">Pilih Kategori</option>
                                @foreach($daftarKategori as $kat) <option value="{{ $kat->id }}">{{ $kat->nama }}</option> @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Merek Prinsipal</label>
                            <select wire:model="merek_id" class="w-full rounded-[24px] border-none bg-slate-50 px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                                <option value="">Pilih Merek</option>
                                @foreach($daftarMerek as $merk) <option value="{{ $merk->id }}">{{ $merk->nama }}</option> @endforeach
                            </select>
                        </div>
                        <div class="pt-6 border-t border-slate-50 space-y-6">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest px-1">Nilai Jual (Retail)</label>
                                <input wire:model="harga_jual" type="number" class="w-full rounded-[24px] border-none bg-emerald-50 px-6 py-4 text-xl font-black text-emerald-700 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                            </div>
                            <div class="space-y-2 opacity-60">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Estimasi Modal</label>
                                <input wire:model="harga_modal" type="number" class="w-full rounded-[24px] border-none bg-slate-50 px-6 py-4 text-sm font-bold text-slate-500">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tab: Media -->
        @if($activeTab === 'media')
        <div class="bg-white p-12 rounded-[56px] shadow-sm border border-indigo-50 space-y-12">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <h3 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Galeri Visual</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Aset resolusi tinggi untuk katalog publik.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
                @foreach($gambar_lama as $img)
                <div class="relative group aspect-square rounded-[40px] overflow-hidden bg-slate-50 border-2 border-slate-50 hover:border-indigo-200 transition-all duration-500 shadow-sm p-4">
                    <img src="{{ $img['url'] }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                        <button type="button" wire:click="hapusGambarLama({{ $img['id'] }})" class="w-14 h-14 bg-rose-500 text-white rounded-full flex items-center justify-center hover:bg-rose-600 shadow-xl shadow-rose-500/30 transform group-hover:scale-110 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
                @endforeach

                <label class="relative aspect-square rounded-[40px] border-4 border-dashed border-slate-100 hover:border-indigo-400 hover:bg-indigo-50 transition-all flex flex-col items-center justify-center p-8 group cursor-pointer shadow-inner">
                    <div class="w-16 h-16 rounded-[24px] bg-white flex items-center justify-center text-slate-300 group-hover:text-indigo-600 shadow-xl group-hover:scale-110 transition-all mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 group-hover:text-indigo-600 uppercase tracking-widest text-center">Inisiasi Media</span>
                    <input type="file" wire:model="gambar_baru" multiple class="hidden">
                </label>
            </div>

            @if($gambar_baru)
            <div class="p-8 bg-emerald-50 rounded-[32px] border border-emerald-100 flex items-center justify-between animate-in zoom-in duration-500">
                <div class="flex items-center gap-4 text-emerald-700">
                    <span class="text-2xl">📸</span>
                    <p class="text-sm font-black uppercase tracking-widest">{{ count($gambar_baru) }} Unit Media Baru Siap Disinkronkan</p>
                </div>
                <button wire:click="$set('gambar_baru', [])" class="text-[9px] font-black text-rose-500 uppercase tracking-[0.2em] hover:underline">Batalkan Unggahan</button>
            </div>
            @endif
        </div>
        @endif

        <!-- Tab: Varian -->
        @if($activeTab === 'varian')
        <div class="bg-white p-12 rounded-[56px] shadow-sm border border-indigo-50 space-y-12">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <div class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="memiliki_varian" class="sr-only peer">
                        <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-600"></div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Matriks Varian</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Otoritas diferensiasi unit (Warna, Kapasitas, Ukuran).</p>
                    </div>
                </div>
                <button type="button" wire:click="tambahBarisVarian" class="px-8 py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl" {{ !$memiliki_varian ? 'disabled opacity-20' : '' }}>
                    TAMBAH VARIAN BARU
                </button>
            </div>

            @if($memiliki_varian)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Label Spesifikasi</th>
                            <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Kode Unit Varian</th>
                            <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Offset Harga (Rp)</th>
                            <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Posisi Stok</th>
                            <th class="px-8 py-6 text-right">Otoritas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($daftarVarian as $index => $varian)
                        <tr class="group hover:bg-indigo-50/20 transition-all duration-300">
                            <td class="px-8 py-4">
                                <input wire:model="daftarVarian.{{ $index }}.nama_varian" type="text" class="w-full rounded-2xl border-none bg-slate-50 px-6 py-3 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all" placeholder="Contoh: Space Grey / 1TB">
                            </td>
                            <td class="px-6 py-4">
                                <input wire:model="daftarVarian.{{ $index }}.kode_unit" type="text" class="w-full rounded-2xl border-none bg-slate-50 px-6 py-3 text-xs font-black text-indigo-600 focus:ring-4 focus:ring-indigo-500/10 transition-all uppercase">
                            </td>
                            <td class="px-6 py-4">
                                <input wire:model="daftarVarian.{{ $index }}.harga_tambahan" type="number" class="w-full rounded-2xl border-none bg-emerald-50 px-6 py-3 text-sm font-black text-emerald-700 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                            </td>
                            <td class="px-6 py-4">
                                <input wire:model="daftarVarian.{{ $index }}.stok" type="number" class="w-full rounded-2xl border-none bg-slate-50 px-6 py-3 text-sm font-black text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            </td>
                            <td class="px-8 py-4 text-right">
                                <button type="button" wire:click="hapusBarisVarian({{ $index }})" class="w-12 h-12 bg-white border border-rose-100 text-rose-400 hover:text-white hover:bg-rose-600 rounded-2xl transition-all shadow-sm flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="py-24 text-center bg-slate-50 rounded-[48px] border-4 border-dashed border-slate-100 flex flex-col items-center gap-6">
                <div class="w-20 h-20 bg-white rounded-[32px] flex items-center justify-center text-4xl shadow-xl">🎭</div>
                <div class="space-y-2">
                    <h4 class="text-xl font-black text-slate-900 uppercase">Varian Dinonaktifkan</h4>
                    <p class="text-slate-400 font-medium max-w-md mx-auto">Gunakan toggle di atas jika produk ini memiliki diferensiasi spesifikasi atau visual.</p>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Tab: Spesifikasi -->
        @if($activeTab === 'spesifikasi')
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <div class="lg:col-span-4">
                <div class="bg-slate-900 p-10 rounded-[56px] text-white shadow-2xl space-y-10 relative overflow-hidden">
                    <h3 class="text-xl font-black uppercase tracking-tight relative z-10">Pusat Parameter</h3>
                    <div class="space-y-6 relative z-10">
                        <div class="space-y-4">
                            <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest block">Templat Perangkat</span>
                            <div class="grid grid-cols-1 gap-3">
                                <button wire:click="terapkanTemplate('laptop')" class="w-full py-4 bg-white/10 hover:bg-white/20 border border-white/10 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">💻 Laptop Standard</button>
                                <button wire:click="terapkanTemplate('smartphone')" class="w-full py-4 bg-white/10 hover:bg-white/20 border border-white/10 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">📱 Smartphone Hub</button>
                            </div>
                        </div>
                        <div class="pt-10 border-t border-white/10">
                            <button type="button" wire:click="tambahBarisSpesifikasi" class="w-full py-5 bg-indigo-600 text-white rounded-[28px] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-indigo-600/20 hover:scale-[1.02] transition-all">
                                BARIS MANUAL BARU
                            </button>
                        </div>
                    </div>
                    <div class="absolute bottom-0 right-0 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl"></div>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="bg-white p-12 rounded-[56px] shadow-sm border border-indigo-50 space-y-10">
                    <div class="space-y-6">
                        @forelse($daftarSpesifikasi as $index => $spek)
                        <div class="flex flex-col sm:flex-row gap-6 p-6 rounded-[32px] bg-slate-50 border border-slate-100 group transition-all hover:border-indigo-200">
                            <div class="flex-1 space-y-2">
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] px-1">Label</label>
                                <input wire:model="daftarSpesifikasi.{{ $index }}.label" type="text" class="w-full rounded-2xl border-none bg-white px-6 py-3 text-xs font-black uppercase tracking-widest text-indigo-600 focus:ring-4 focus:ring-indigo-500/10 transition-all shadow-sm">
                            </div>
                            <div class="flex-[2] space-y-2">
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] px-1">Nilai Parameter</label>
                                <input wire:model="daftarSpesifikasi.{{ $index }}.nilai" type="text" class="w-full rounded-2xl border-none bg-white px-6 py-3 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all shadow-sm">
                            </div>
                            <div class="sm:pt-6">
                                <button type="button" wire:click="hapusBarisSpesifikasi({{ $index }})" class="w-12 h-12 bg-white text-rose-400 hover:text-white hover:bg-rose-500 rounded-2xl transition-all shadow-sm flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="py-20 text-center text-slate-400 font-black uppercase tracking-widest text-xs italic">Belum ada matriks teknis terdaftar.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tab: SEO -->
        @if($activeTab === 'seo')
        <div class="max-w-4xl mx-auto space-y-10">
            <div class="bg-white p-12 rounded-[56px] shadow-sm border border-indigo-50 space-y-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 text-2xl">🌍</div>
                    <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Otoritas Search Engine</h3>
                </div>
                <div class="space-y-8">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Meta Title (Max 60 Karakter)</label>
                        <input wire:model="meta_judul" type="text" class="w-full rounded-3xl border-none bg-slate-50 px-8 py-5 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Meta Description (Max 160 Karakter)</label>
                        <textarea wire:model="meta_deskripsi" rows="4" class="w-full rounded-[32px] border-none bg-slate-50 px-8 py-6 text-sm font-medium text-slate-700 focus:ring-4 focus:ring-indigo-500/10 transition-all"></textarea>
                    </div>
                </div>
            </div>

            <!-- Preview Browser Google -->
            <div class="bg-white p-10 rounded-[48px] border border-slate-100 shadow-inner space-y-4">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest px-2">Visualisasi Pencarian Global</p>
                <div class="space-y-1 p-6">
                    <p class="text-[14px] text-slate-500 font-medium">https://teqara.id › produk › <span class="text-indigo-600">{{ $slug }}</span></p>
                    <h4 class="text-xl text-[#1a0dab] font-medium hover:underline cursor-pointer">{{ $meta_judul ?: $nama ?: 'Judul Produk Teqara' }}</h4>
                    <p class="text-sm text-[#4d5156] line-clamp-2">{{ $meta_deskripsi ?: $deskripsi_singkat ?: 'Deskripsi produk ini akan muncul di mesin pencari untuk menarik pelanggan potensial...' }}</p>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>