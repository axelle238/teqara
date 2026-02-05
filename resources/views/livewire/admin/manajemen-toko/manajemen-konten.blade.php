<div class="max-w-6xl mx-auto pb-32">
    <!-- Header: Vibrant & Modern -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50 mb-12">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Editor Visual Real-time</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">MANAJEMEN <span class="text-indigo-600">KONTEN TOKO</span></h1>
            <p class="text-slate-500 font-medium text-lg">Konfigurasi elemen visual dan narasi pemasaran halaman depan.</p>
        </div>
        <a href="/" target="_blank" class="flex items-center gap-3 px-8 py-4 bg-indigo-50 text-indigo-600 rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
            PREVIEW PUBLIK
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
        </a>
    </div>

    <!-- Hero Section Configuration Card -->
    <div class="bg-white rounded-[56px] shadow-2xl shadow-indigo-500/5 border-2 border-indigo-50 overflow-hidden group">
        <div class="px-10 py-8 border-b border-indigo-50 bg-slate-50/30 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1-0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1-0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tighter">Spanduk Utama (Hero Section)</h3>
            </div>
            <div class="flex items-center gap-2 px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-widest">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                Status: Aktif
            </div>
        </div>
        
        <form wire:submit.prevent="simpanHero" class="p-10 space-y-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Visual Asset Viewport -->
                <div class="space-y-4">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-1">Aset Visual Spanduk</label>
                    <div class="relative aspect-video rounded-[40px] overflow-hidden bg-slate-100 border-4 border-white shadow-xl group/asset">
                        @if($hero_gambar_baru)
                            <img src="{{ $hero_gambar_baru->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif($hero_gambar_lama)
                            <img src="{{ $hero_gambar_lama }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-slate-300">
                                <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-xs font-black uppercase tracking-widest">Belum Ada Aset</p>
                            </div>
                        @endif
                        
                        <div class="absolute inset-0 bg-indigo-600/40 opacity-0 group-hover/asset:opacity-100 flex items-center justify-center transition-all duration-500 backdrop-blur-sm">
                            <label class="cursor-pointer px-10 py-4 bg-white text-indigo-600 rounded-[24px] text-xs font-black uppercase tracking-widest shadow-2xl hover:scale-105 transition-all">
                                UNGGAH ASET BARU
                                <input type="file" wire:model="hero_gambar_baru" class="hidden">
                            </label>
                        </div>
                    </div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest text-center">Rasio 16:9 • Resolusi Tinggi Direkomendasikan (Maks 2MB)</p>
                    @error('hero_gambar_baru') <span class="text-rose-500 text-[10px] font-black uppercase tracking-widest text-center block">{{ $message }}</span> @enderror
                </div>

                <!-- Textual & Navigation Configuration -->
                <div class="space-y-8">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-1">Judul Utama (Headline)</label>
                        <textarea wire:model="hero_judul" rows="2" class="w-full rounded-[24px] border-none bg-indigo-50/50 p-6 text-xl font-black text-slate-900 focus:ring-2 focus:ring-indigo-500 placeholder:text-slate-300 transition-all"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-1">Narasi Pemasaran (Sub-judul)</label>
                        <textarea wire:model="hero_deskripsi" rows="3" class="w-full rounded-[24px] border-none bg-indigo-50/50 p-6 text-sm font-medium text-slate-600 leading-relaxed focus:ring-2 focus:ring-indigo-500 placeholder:text-slate-300 transition-all"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-1">Teks Tombol Aksi</label>
                            <input wire:model="hero_tombol" type="text" class="w-full rounded-[20px] border-none bg-indigo-50/50 px-6 py-4 text-xs font-black text-indigo-600 focus:ring-2 focus:ring-indigo-500 uppercase tracking-widest">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-1">Tautan Tujuan</label>
                            <input wire:model="hero_url" type="text" class="w-full rounded-[20px] border-none bg-indigo-50/50 px-6 py-4 text-xs font-bold text-slate-500 focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Global Action Command -->
            <div class="pt-8 border-t-2 border-dashed border-indigo-50 text-right">
                <button type="submit" class="px-12 py-5 bg-indigo-600 text-white rounded-[32px] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 hover:scale-105 transition-all shadow-2xl shadow-indigo-500/30 group">
                    PUBLIKASIKAN PERUBAHAN
                    <svg class="inline-block w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </button>
            </div>
        </form>
    </div>
</div>
