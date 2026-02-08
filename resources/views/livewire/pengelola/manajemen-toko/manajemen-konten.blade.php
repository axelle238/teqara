<div class="space-y-8 animate-in fade-in duration-500 pb-32">
    
    <!-- 1. HEADER & NAVIGASI BAGIAN (STICKY) -->
    <div class="sticky top-24 z-30 bg-white/80 backdrop-blur-xl p-2 rounded-[2rem] shadow-xl border border-white/50 flex flex-wrap gap-2 justify-center lg:justify-start">
        @php
            $tabs = [
                'hero_section' => ['label' => 'Hero Utama', 'icon' => 'fa-panorama', 'color' => 'indigo'],
                'promo_banner' => ['label' => 'Banner Promo', 'icon' => 'fa-bullhorn', 'color' => 'pink'],
                'fitur_unggulan' => ['label' => 'Fitur Unggulan', 'icon' => 'fa-star', 'color' => 'amber'],
                'faq_section' => ['label' => 'Tanya Jawab (FAQ)', 'icon' => 'fa-circle-question', 'color' => 'cyan'],
                'cta_footer' => ['label' => 'Call to Action', 'icon' => 'fa-arrow-right-to-bracket', 'color' => 'emerald'],
            ];
        @endphp

        @foreach($tabs as $key => $tab)
        <button wire:click="gantiTab('{{ $key }}')" 
                class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-3 border {{ $filterBagian === $key ? 'bg-'.$tab['color'].'-500 text-white shadow-lg shadow-'.$tab['color'].'-500/30 border-transparent scale-105' : 'bg-white text-slate-500 border-slate-100 hover:bg-slate-50' }}">
            <i class="fa-solid {{ $tab['icon'] }}"></i> {{ $tab['label'] }}
        </button>
        @endforeach
    </div>

    <!-- 2. AREA UTAMA: LIST vs EDITOR -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI: DAFTAR KONTEN -->
        <div class="{{ $tampilkanForm ? 'hidden lg:block lg:col-span-1' : 'col-span-full' }} space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Daftar Item</h3>
                <button wire:click="tambahBaru" class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center hover:bg-indigo-600 transition-colors shadow-lg">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>

            <div class="grid {{ $tampilkanForm ? 'grid-cols-1' : 'grid-cols-1 md:grid-cols-2 xl:grid-cols-3' }} gap-6">
                @forelse($daftar_konten as $item)
                <div class="group relative bg-white rounded-[2.5rem] p-4 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 {{ $kontenId === $item->id ? 'ring-4 ring-indigo-500/10 border-indigo-200' : '' }}">
                    <!-- Status Badge -->
                    <div class="absolute top-6 left-6 z-10">
                        <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest shadow-sm {{ $item->aktif ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-500' }}">
                            {{ $item->aktif ? 'ON' : 'OFF' }}
                        </span>
                    </div>

                    <!-- Actions Overlay -->
                    <div class="absolute top-6 right-6 z-10 opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                        <button wire:click="toggleStatus({{ $item->id }})" class="w-8 h-8 rounded-full bg-white text-slate-400 hover:text-emerald-600 shadow-md flex items-center justify-center" title="Toggle Aktif">
                            <i class="fa-solid fa-power-off"></i>
                        </button>
                        <button wire:click="hapus({{ $item->id }})" wire:confirm="Hapus konten ini?" class="w-8 h-8 rounded-full bg-white text-slate-400 hover:text-rose-600 shadow-md flex items-center justify-center" title="Hapus">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>

                    <!-- Preview Gambar -->
                    <div class="aspect-video rounded-[2rem] bg-slate-50 overflow-hidden mb-4 relative cursor-pointer" wire:click="edit({{ $item->id }})">
                        @if($item->gambar)
                            <img src="{{ asset($item->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-200 text-4xl bg-slate-50">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-indigo-900/0 group-hover:bg-indigo-900/10 transition-colors"></div>
                    </div>

                    <!-- Info -->
                    <div class="px-2 pb-2 cursor-pointer" wire:click="edit({{ $item->id }})">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-black text-slate-800 text-sm line-clamp-1 group-hover:text-indigo-600 transition-colors">{{ $item->judul }}</h4>
                            <span class="text-[9px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded">#{{ $item->urutan }}</span>
                        </div>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $item->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center border-2 border-dashed border-slate-200 rounded-[3rem]">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300 text-2xl">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Belum ada konten di bagian ini.</p>
                    <button wire:click="tambahBaru" class="mt-4 text-indigo-600 text-xs font-black uppercase hover:underline">Buat Baru Sekarang</button>
                </div>
                @endforelse
            </div>
        </div>

        <!-- KOLOM KANAN: FORM EDITOR (INLINE) -->
        @if($tampilkanForm)
        <div class="lg:col-span-2 animate-in slide-in-from-right duration-500 relative">
            <div class="sticky top-40">
                <div class="bg-white p-8 rounded-[3rem] shadow-2xl border border-indigo-50 relative overflow-hidden">
                    <!-- Decor -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-bl-[100px] -mr-10 -mt-10"></div>

                    <div class="flex items-center justify-between mb-8 relative z-10">
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">
                            {{ $kontenId ? 'Edit Konten' : 'Konten Baru' }}
                        </h3>
                        <button wire:click="batal" class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-colors flex items-center justify-center">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <div class="space-y-6 relative z-10">
                        <!-- Judul & Urutan -->
                        <div class="grid grid-cols-3 gap-6">
                            <div class="col-span-2 space-y-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Judul Utama</label>
                                <input type="text" wire:model="judul" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-indigo-500/20 placeholder:text-slate-300" placeholder="Judul menarik...">
                                @error('judul') <span class="text-rose-500 text-[9px] font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Urutan</label>
                                <input type="number" wire:model="urutan" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-indigo-500/20 text-center">
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Deskripsi / Sub-judul</label>
                            <textarea wire:model="deskripsi" rows="3" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 placeholder:text-slate-300" placeholder="Penjelasan singkat..."></textarea>
                        </div>

                        <!-- CTA (Tombol) -->
                        <div class="grid grid-cols-2 gap-6 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Teks Tombol (CTA)</label>
                                <input type="text" wire:model="teks_tombol" class="w-full bg-white border-none rounded-xl px-4 py-2 text-xs font-bold shadow-sm" placeholder="Contoh: Beli Sekarang">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Link Tujuan</label>
                                <input type="text" wire:model="tautan_tujuan" class="w-full bg-white border-none rounded-xl px-4 py-2 text-xs font-bold shadow-sm" placeholder="https://...">
                            </div>
                        </div>

                        <!-- Media: Upload Gambar atau Icon Class -->
                        <div class="space-y-3">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                {{ $filterBagian === 'fitur_unggulan' ? 'Ikon FontAwesome' : 'Visual Pendukung' }}
                            </label>

                            @if($filterBagian === 'fitur_unggulan')
                                <!-- Mode Input Icon -->
                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <input type="text" wire:model="gambar_lama" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-indigo-500/20 placeholder:text-slate-300" placeholder="cth: fa-solid fa-rocket">
                                        <p class="mt-2 text-[9px] text-slate-400">Gunakan class dari FontAwesome 6 Free.</p>
                                    </div>
                                    <div class="w-16 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-2xl text-indigo-600 border border-indigo-100">
                                        <i class="{{ $gambar_lama ?? 'fa-solid fa-question' }}"></i>
                                    </div>
                                </div>
                            @else
                                <!-- Mode Upload Gambar -->
                                <div class="relative group w-full aspect-[2/1] bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 hover:border-indigo-300 transition-all flex flex-col items-center justify-center overflow-hidden cursor-pointer">
                                    @if($gambar)
                                        <img src="{{ $gambar->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                                    @elseif($gambar_lama && !str_contains($gambar_lama, 'fa-'))
                                        <img src="{{ asset($gambar_lama) }}" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:opacity-100 transition-opacity">
                                    @else
                                        <div class="text-center p-4">
                                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-300 mb-2"></i>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase">Klik untuk Unggah</p>
                                        </div>
                                    @endif
                                    
                                    <input type="file" wire:model="gambar" class="absolute inset-0 opacity-0 cursor-pointer z-20">
                                    
                                    <div wire:loading wire:target="gambar" class="absolute inset-0 bg-white/80 backdrop-blur flex items-center justify-center z-30">
                                        <i class="fa-solid fa-circle-notch animate-spin text-indigo-600"></i>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="pt-4 border-t border-slate-100 flex gap-3">
                            <button wire:click="batal" class="flex-1 py-3 bg-white border border-slate-200 text-slate-500 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-colors">Batal</button>
                            <button wire:click="simpan" class="flex-[2] py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all active:scale-95 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>