<div class="animate-in fade-in duration-500">
    
    @if(!$tampilkanForm)
        <!-- TAMPILAN 1: DAFTAR ARTIKEL (FULL PAGE LIST) -->
        <div class="space-y-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="space-y-1">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Pusat Informasi & Berita</h1>
                    <p class="text-slate-500 font-medium text-sm uppercase tracking-widest">Edukasi & Update Teknologi untuk Pelanggan Teqara.</p>
                </div>
                <button wire:click="tambahBaru" class="flex items-center gap-3 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-indigo-600/20 transition-all active:scale-95">
                    <i class="fa-solid fa-file-signature text-lg"></i> TULIS ARTIKEL BARU
                </button>
            </div>

            <!-- Filter & Search -->
            <div class="bg-white p-4 rounded-[30px] border border-indigo-50 flex items-center px-6 gap-4">
                <i class="fa-solid fa-magnifying-glass text-slate-300"></i>
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari judul artikel..." class="flex-1 bg-transparent border-none text-sm font-bold text-slate-700 focus:ring-0 placeholder:text-slate-300">
            </div>

            <!-- Grid Berita -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($daftar_berita as $item)
                <div class="group bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden hover:shadow-2xl hover:border-indigo-200 transition-all duration-500 flex flex-col md:flex-row">
                    <div class="md:w-48 h-48 md:h-auto bg-slate-100 shrink-0 overflow-hidden">
                        <img src="{{ $item->gambar_unggulan ?? 'https://via.placeholder.com/400x400?text=News+Thumb' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-8 flex flex-1 flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $item->status === 'publikasi' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                                    {{ $item->status }}
                                </span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase">{{ $item->created_at->translatedFormat('d M Y') }}</span>
                            </div>
                            <h3 class="font-black text-lg text-slate-800 leading-tight line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $item->judul }}</h3>
                            <p class="text-slate-500 text-xs font-medium leading-relaxed line-clamp-2">{{ $item->ringkasan }}</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                            <div class="flex gap-2">
                                <button wire:click="edit({{ $item->id }})" class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-all shadow-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button wire:click="hapus({{ $item->id }})" wire:confirm="Hapus artikel ini?" class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-all shadow-sm">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                            <div class="flex items-center gap-2 text-slate-400">
                                <i class="fa-solid fa-user-pen text-[10px]"></i>
                                <span class="text-[10px] font-bold uppercase tracking-widest">{{ $item->penulis->nama ?? 'Admin' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center bg-white rounded-[50px] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-newspaper text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Arsip Berita Kosong</h3>
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Segera tulis artikel teknologi pertama Anda untuk mengedukasi pelanggan.</p>
                </div>
                @endforelse
            </div>

            <div class="pt-6">
                {{ $daftar_berita->links() }}
            </div>
        </div>
    @else
        <!-- TAMPILAN 2: EDITOR ARTIKEL (FULL PAGE FORM) -->
        <div class="space-y-8 animate-in slide-in-from-right-8 duration-500">
            <!-- Header Editor -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="flex items-center gap-6">
                    <button wire:click="batal" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                    </button>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">{{ $berita_id ? 'Sunting Artikel' : 'Tulis Artikel Baru' }}</h1>
                        <p class="text-slate-500 font-medium uppercase tracking-widest text-[10px]">Editor Konten Teqara v16.0</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-3xl text-sm font-black hover:bg-slate-100 transition-all">BATAL</button>
                    <button wire:click="simpan" class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-indigo-600/20 transition-all active:scale-95">PUBLIKASIKAN SEKARANG</button>
                </div>
            </div>

            <!-- Editor Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kolom Kiri: Konten -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Judul Artikel (H1)</label>
                            <input wire:model="judul" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 text-xl font-black text-slate-800 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300" placeholder="Masukkan judul artikel yang SEO friendly...">
                            @error('judul') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Ringkasan Eksekutif (Snippet)</label>
                            <textarea wire:model="ringkasan" rows="3" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-600 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300" placeholder="Berikan gambaran singkat mengenai isi berita ini..."></textarea>
                            @error('ringkasan') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Isi Konten Lengkap</label>
                            <div class="space-y-4">
                                <textarea wire:model="konten" rows="15" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-6 text-sm font-medium text-slate-700 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300 leading-relaxed" placeholder="Tuliskan seluruh narasi artikel di sini..."></textarea>
                                @error('konten') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Pengaturan & Media -->
                <div class="space-y-8">
                    <!-- Status & Meta -->
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Status Publikasi</label>
                            <select wire:model="status" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                                <option value="draft">📁 DRAFT INTERNAL</option>
                                <option value="publikasi">🌍 PUBLIKASIKAN KE TOKO</option>
                                <option value="arsip">📦 ARSIP ARTIKEL</option>
                            </select>
                        </div>

                        <div class="space-y-4 pt-8 border-t border-slate-50">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Gambar Unggulan</label>
                            <div class="relative aspect-square bg-slate-50 rounded-3xl border-4 border-dashed border-slate-100 flex items-center justify-center overflow-hidden group hover:border-indigo-200 transition-all">
                                @if($gambar_baru)
                                    <img src="{{ $gambar_baru->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif($gambar_lama)
                                    <img src="{{ asset($gambar_lama) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-center space-y-3">
                                        <i class="fa-solid fa-images text-4xl text-slate-200 group-hover:text-indigo-400 transition-colors"></i>
                                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Unggah Thumbnail</p>
                                    </div>
                                @endif
                                <input type="file" wire:model="gambar_baru" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 leading-relaxed italic text-center">*Rasio 1:1 atau 4:3 sangat disarankan untuk tampilan grid.</p>
                        </div>
                    </div>

                    <!-- Tips SEO -->
                    <div class="bg-emerald-500 p-10 rounded-[50px] text-white shadow-2xl shadow-emerald-500/30 space-y-4 relative overflow-hidden group">
                        <i class="fa-solid fa-bolt text-4xl opacity-20 absolute -right-4 -top-4 group-hover:scale-150 transition-transform duration-1000"></i>
                        <h4 class="text-lg font-black uppercase tracking-tight">Tips SEO Teqara</h4>
                        <p class="text-xs font-bold text-emerald-50 leading-relaxed opacity-90">
                            "Gunakan kata kunci teknologi populer di judul dan 50 kata pertama isi konten untuk meningkatkan peringkat pencarian di Google."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>