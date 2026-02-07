<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Ruang <span class="text-rose-600">Redaksi</span></h1>
            <p class="text-slate-500 font-medium">Publikasikan berita terbaru dan artikel edukasi untuk pelanggan.</p>
        </div>
        
        @if(!$tampilkanEditor)
        <button wire:click="tambahBaru" class="flex items-center gap-2 px-6 py-3 bg-rose-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-rose-700 transition-all shadow-lg shadow-rose-500/20 active:scale-95">
            <i class="fa-solid fa-pen-nib"></i> Tulis Artikel
        </button>
        @endif
    </div>

    @if(!$tampilkanEditor)
        <!-- LIST VIEW -->
        <div class="space-y-8">
            <!-- Filter -->
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center justify-between">
                <div class="relative w-full md:w-96">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Judul Artikel..." class="w-full pl-11 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-500 transition-all">
                </div>
            </div>

            <!-- Grid Artikel -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @forelse($berita as $b)
                <div class="group bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-rose-100 transition-all duration-300 overflow-hidden flex flex-col h-full">
                    <!-- Image -->
                    <div class="relative h-48 bg-slate-100 overflow-hidden">
                        <img src="{{ $b->gambar_sampul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur-md rounded-lg text-[10px] font-black uppercase tracking-widest text-slate-800 shadow-sm">
                                {{ $b->kategori }}
                            </span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest shadow-sm {{ $b->status == 'publikasi' ? 'bg-emerald-500 text-white' : 'bg-slate-800 text-white' }}">
                                {{ $b->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="font-black text-lg text-slate-900 leading-tight mb-2 group-hover:text-rose-600 transition-colors line-clamp-2">
                            {{ $b->judul }}
                        </h3>
                        <p class="text-xs text-slate-500 font-medium mb-4">
                            Dibuat: {{ $b->dibuat_pada->format('d M Y') }}
                        </p>
                        
                        <div class="mt-auto flex gap-2 pt-4 border-t border-slate-50">
                            <button wire:click="edit({{ $b->id }})" class="flex-1 py-2.5 bg-slate-50 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                                Edit
                            </button>
                            <button wire:click="hapus({{ $b->id }})" wire:confirm="Hapus artikel ini?" class="w-10 flex items-center justify-center bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-rose-600 hover:border-rose-200 transition-all">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl text-slate-300">
                        <i class="fa-regular fa-newspaper"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Belum Ada Artikel</h3>
                    <p class="text-slate-400 text-sm font-medium mt-2">Mulai menulis untuk meningkatkan engagement pelanggan.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $berita->links() }}
            </div>
        </div>
    @else
        <!-- EDITOR VIEW -->
        <div class="animate-in slide-in-from-right-8 duration-500">
            <!-- Header Editor -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50 mb-8 sticky top-24 z-30">
                <div class="flex items-center gap-6">
                    <button wire:click="batal" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                    </button>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">{{ $beritaId ? 'Sunting Artikel' : 'Tulis Artikel Baru' }}</h1>
                        <p class="text-slate-500 font-medium uppercase tracking-widest text-[10px]">Editor Konten Enterprise</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-3xl text-sm font-black hover:bg-slate-100 transition-all">BATAL</button>
                    <button wire:click="simpan" class="px-10 py-4 bg-rose-600 hover:bg-rose-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-rose-600/20 transition-all active:scale-95 flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> PUBLIKASI
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Editor -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-10 rounded-[40px] border border-slate-200 shadow-sm space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Judul Artikel</label>
                            <input wire:model.live="judul" type="text" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xl font-bold text-slate-900 placeholder-slate-300 focus:ring-4 focus:ring-rose-500/10 transition-all" placeholder="Ketik judul yang menarik...">
                            @error('judul') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Slug (URL)</label>
                            <input wire:model="slug" type="text" class="w-full px-6 py-3 bg-slate-50 border-none rounded-2xl text-sm font-mono text-slate-500 focus:ring-2 focus:ring-rose-500/10 transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Konten Utama</label>
                            <textarea wire:model="konten" rows="20" class="w-full px-6 py-6 bg-slate-50 border-none rounded-[30px] text-base font-medium text-slate-700 placeholder-slate-300 focus:ring-4 focus:ring-rose-500/10 leading-relaxed resize-none transition-all" placeholder="Mulai menulis cerita Anda di sini... (HTML Supported)"></textarea>
                            @error('konten') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Sidebar Settings -->
                <div class="space-y-8">
                    <div class="bg-white p-8 rounded-[40px] border border-slate-200 shadow-sm space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Gambar Sampul</label>
                            <div class="relative aspect-video bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 overflow-hidden group hover:border-rose-300 transition-all cursor-pointer">
                                @if($gambar_sampul)
                                    <img src="{{ $gambar_sampul->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif($gambar_lama)
                                    <img src="{{ $gambar_lama }}" class="w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-300">
                                        <i class="fa-solid fa-image text-3xl mb-2"></i>
                                        <span class="text-[10px] font-bold uppercase tracking-widest">Upload Foto</span>
                                    </div>
                                @endif
                                <input type="file" wire:model="gambar_sampul" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kategori</label>
                            <select wire:model="kategori" class="w-full px-6 py-3 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-500 cursor-pointer">
                                <option value="berita">Berita Umum</option>
                                <option value="promo">Promo & Diskon</option>
                                <option value="tips">Tips & Trik</option>
                                <option value="event">Event Komunitas</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Status Publikasi</label>
                            <select wire:model="status" class="w-full px-6 py-3 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-500 cursor-pointer">
                                <option value="draft">Draft (Disimpan)</option>
                                <option value="publikasi">Publikasi (Tayang)</option>
                                <option value="arsip">Arsip (Sembunyikan)</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tags (Pemisah Koma)</label>
                            <input wire:model="tags" type="text" placeholder="teknologi, gadget, terbaru" class="w-full px-6 py-3 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
