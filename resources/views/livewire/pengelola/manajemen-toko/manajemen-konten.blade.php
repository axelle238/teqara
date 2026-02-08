<div class="animate-in fade-in zoom-in duration-500 pb-20">
    
    @if(!$tampilkanForm)
        <!-- LIST VIEW -->
        <div class="space-y-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Visual <span class="text-rose-600">Editor</span></h1>
                    <p class="text-slate-500 font-medium">Kelola banner, slider, dan konten visual halaman depan.</p>
                </div>
                <button wire:click="tambahBaru" class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-rose-600 transition-all shadow-lg shadow-slate-900/20 active:scale-95">
                    <i class="fa-solid fa-plus"></i> Konten Baru
                </button>
            </div>

            <!-- Tab Filter -->
            <div class="flex overflow-x-auto pb-2 gap-2 scrollbar-hide">
                @php
                    $tabs = [
                        'hero_section' => ['label' => 'Hero Banner', 'icon' => 'fa-images'],
                        'promo_banner' => ['label' => 'Promo Strip', 'icon' => 'fa-rectangle-ad'],
                        'fitur_unggulan' => ['label' => 'Fitur Utama', 'icon' => 'fa-star'],
                        'faq_section' => ['label' => 'FAQ / Bantuan', 'icon' => 'fa-circle-question'],
                        'cta_footer' => ['label' => 'CTA Footer', 'icon' => 'fa-bullhorn'],
                    ];
                @endphp
                @foreach($tabs as $key => $t)
                <button wire:click="gantiTab('{{ $key }}')" 
                    class="flex items-center gap-3 px-6 py-3 rounded-2xl font-bold text-xs uppercase tracking-widest transition-all whitespace-nowrap border {{ $filterBagian === $key ? 'bg-white border-rose-200 text-rose-600 shadow-md shadow-rose-100' : 'bg-slate-50 border-transparent text-slate-500 hover:bg-white hover:border-slate-200' }}">
                    <i class="fa-solid {{ $t['icon'] }}"></i> {{ $t['label'] }}
                </button>
                @endforeach
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @forelse($daftar_konten as $k)
                <div class="group bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-rose-100 transition-all duration-300 relative overflow-hidden flex flex-col h-full">
                    
                    <!-- Status Indicator -->
                    <div class="absolute top-4 left-4 z-10">
                        <button wire:click="toggleStatus({{ $k->id }})" class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest backdrop-blur-md shadow-sm border transition-all {{ $k->aktif ? 'bg-emerald-500/90 text-white border-emerald-400' : 'bg-slate-800/90 text-slate-300 border-slate-700' }}">
                            {{ $k->aktif ? 'AKTIF' : 'NONAKTIF' }}
                        </button>
                    </div>

                    <!-- Image/Icon Preview -->
                    <div class="relative aspect-[16/9] bg-slate-100 overflow-hidden flex items-center justify-center">
                        @if($k->gambar)
                            <img src="{{ asset($k->gambar) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @elseif(isset($k->metadata['ikon']))
                            <div class="text-6xl text-slate-300 group-hover:text-rose-500 transition-colors duration-500">
                                <i class="{{ $k->metadata['ikon'] }}"></i>
                            </div>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <i class="fa-regular fa-image text-4xl"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-60"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <span class="text-[10px] font-bold opacity-80 uppercase tracking-widest">Urutan: {{ $k->urutan }}</span>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $k->metadata['warna_aksen'] ?? '#cbd5e1' }}"></span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ str_replace('_', ' ', $k->bagian) }}</span>
                        </div>
                        <h4 class="font-black text-slate-900 text-lg leading-tight mb-2 line-clamp-2">{{ $k->judul }}</h4>
                        <p class="text-xs text-slate-500 font-medium line-clamp-2 mb-4">{{ $k->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                        
                        <div class="mt-auto flex gap-2 pt-4 border-t border-slate-50">
                            <button wire:click="edit({{ $k->id }})" class="flex-1 py-2.5 bg-slate-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all">
                                Sunting Konten
                            </button>
                            <button wire:click="hapus({{ $k->id }})" wire:confirm="Hapus konten visual ini?" class="w-10 flex items-center justify-center bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-rose-600 hover:border-rose-200 transition-all">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center bg-white rounded-[40px] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl text-slate-300">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Bagian Kosong</h3>
                    <p class="text-slate-400 font-medium text-sm mt-2">Belum ada konten visual di bagian ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    @else
        <!-- FORM EDITOR -->
        <div class="animate-in slide-in-from-right-8 duration-500">
            <div class="flex items-center justify-between mb-8 bg-white p-6 rounded-[30px] border border-slate-100 shadow-sm sticky top-24 z-30">
                <div class="flex items-center gap-4">
                    <button wire:click="batal" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-500 hover:text-indigo-600 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-wide italic">Editor Konten: <span class="text-rose-600">{{ str_replace('_', ' ', $bagian) }}</span></h2>
                </div>
                <button wire:click="simpan" class="px-10 py-3 bg-emerald-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">
                    Simpan Perubahan
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Preview & Metadata -->
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-[30px] border border-slate-200 shadow-sm">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Media Utama</label>
                        <div class="relative aspect-video bg-slate-100 rounded-2xl overflow-hidden border-2 border-dashed border-slate-300 hover:border-indigo-400 transition-colors cursor-pointer group">
                            @if($gambar)
                                <img src="{{ $gambar->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif($gambar_lama)
                                <img src="{{ asset($gambar_lama) }}" class="w-full h-full object-cover">
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl mb-2"></i>
                                    <span class="text-[10px] font-bold uppercase">Upload Media</span>
                                </div>
                            @endif
                            <input type="file" wire:model="gambar" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-[30px] border border-slate-200 shadow-sm space-y-6">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 pb-2">Konfigurasi Tambahan</h4>
                        
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Warna Aksen</label>
                            <input type="color" wire:model="konfigurasi.warna_aksen" class="w-full h-12 bg-transparent border-none rounded-xl cursor-pointer">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Ikon (FontAwesome)</label>
                            <input type="text" wire:model="konfigurasi.ikon" class="w-full bg-slate-50 border-none rounded-xl text-sm font-mono text-indigo-600 focus:ring-2 focus:ring-indigo-500" placeholder="fa-solid fa-star">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Posisi Konten</label>
                            <select wire:model="konfigurasi.posisi_teks" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                                <option value="kiri">Rata Kiri</option>
                                <option value="tengah">Rata Tengah</option>
                                <option value="kanan">Rata Kanan</option>
                            </select>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-slate-50">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Aktif</label>
                            <button wire:click="$toggle('aktif')" class="w-12 h-6 rounded-full transition-colors relative {{ $aktif ? 'bg-emerald-500' : 'bg-slate-200' }}">
                                <span class="absolute top-1 left-1 bg-white w-4 h-4 rounded-full transition-transform {{ $aktif ? 'translate-x-6' : '' }}"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Text Content -->
                <div class="lg:col-span-2 bg-white p-8 rounded-[40px] border border-slate-200 shadow-sm space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Headline / Pertanyaan</label>
                        <input type="text" wire:model="judul" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-xl font-bold text-slate-900 placeholder-slate-300 focus:ring-4 focus:ring-indigo-500/10" placeholder="Teks utama yang menonjol...">
                        @error('judul') <span class="text-rose-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi / Jawaban</label>
                        <textarea wire:model="deskripsi" rows="6" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-medium text-slate-600 placeholder-slate-300 focus:ring-4 focus:ring-indigo-500/10 resize-none"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Urutan Tampil</label>
                            <input type="number" wire:model="urutan" class="w-full bg-slate-50 border-none rounded-xl px-5 py-3 text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Label Tombol</label>
                            <input type="text" wire:model="teks_tombol" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500" placeholder="Pelajari Lebih Lanjut">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">URL Tujuan</label>
                            <input type="text" wire:model="tautan_tujuan" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3 text-sm font-mono text-indigo-600 focus:ring-2 focus:ring-indigo-500" placeholder="https://...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

</div>
