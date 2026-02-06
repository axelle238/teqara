<div class="bg-slate-50 min-h-screen py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16">
            <div class="space-y-4">
                <span class="px-4 py-2 bg-white border border-indigo-100 rounded-full text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] shadow-sm">Pusat Informasi</span>
                <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">
                    TEQARA <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-cyan-500">INSIGHTS</span>
                </h1>
            </div>
            
            <div class="flex items-center gap-4 bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
                <div class="relative">
                    <input 
                        wire:model.live.debounce.300ms="cari" 
                        type="text" 
                        placeholder="Cari Artikel..." 
                        class="pl-10 pr-4 py-3 bg-transparent border-none text-sm font-bold focus:ring-0 placeholder:text-slate-300 w-64"
                    >
                    <svg class="w-5 h-5 absolute left-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <div class="h-8 w-px bg-slate-100"></div>
                <select wire:model.live="kategori" class="bg-transparent border-none text-xs font-black uppercase tracking-widest text-slate-500 focus:ring-0 cursor-pointer">
                    <option value="">Semua Topik</option>
                    @foreach($kategoriList as $k)
                        <option value="{{ $k }}">{{ ucfirst($k) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Featured Article -->
        @if($beritaUtama)
        <div class="mb-16 group relative rounded-[48px] overflow-hidden aspect-[21/9] shadow-2xl shadow-indigo-500/10">
            <img src="{{ $beritaUtama->gambar_sampul }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
            
            <div class="absolute bottom-0 left-0 w-full p-10 md:p-16">
                <div class="max-w-3xl space-y-6">
                    <div class="flex items-center gap-4">
                        <span class="px-3 py-1 bg-indigo-600 text-white rounded-lg text-[10px] font-black uppercase tracking-widest">{{ $beritaUtama->kategori }}</span>
                        <span class="text-slate-300 text-xs font-bold uppercase tracking-widest">{{ $beritaUtama->created_at->translatedFormat('d F Y') }}</span>
                    </div>
                    <a href="{{ route('berita.detail', $beritaUtama->slug) }}" class="block">
                        <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight leading-tight group-hover:text-indigo-300 transition-colors">
                            {{ $beritaUtama->judul }}
                        </h2>
                    </a>
                    <p class="text-slate-300 text-lg font-medium line-clamp-2 max-w-2xl">
                        {{ Str::limit(strip_tags($beritaUtama->konten), 150) }}
                    </p>
                    <a href="{{ route('berita.detail', $beritaUtama->slug) }}" class="inline-flex items-center gap-3 text-white font-black uppercase tracking-widest text-xs hover:gap-6 transition-all duration-300">
                        Baca Selengkapnya <span class="text-xl">→</span>
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Grid Articles -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($berita as $b)
            <article class="group bg-white rounded-[40px] p-4 border border-white shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-indigo-500/10 hover:border-indigo-50 transition-all duration-500 flex flex-col h-full">
                <div class="relative aspect-[4/3] rounded-[32px] overflow-hidden mb-6">
                    <img src="{{ $b->gambar_sampul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <span class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur-md rounded-lg text-[9px] font-black uppercase tracking-widest text-slate-900">
                        {{ $b->kategori }}
                    </span>
                </div>
                
                <div class="px-4 pb-4 flex-1 flex flex-col">
                    <div class="mb-4">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $b->created_at->translatedFormat('d M Y') }}</span>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $b->penulis->nama ?? 'Admin' }}</span>
                        </div>
                        <a href="{{ route('berita.detail', $b->slug) }}" class="block">
                            <h3 class="text-xl font-black text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2">
                                {{ $b->judul }}
                            </h3>
                        </a>
                    </div>
                    
                    <p class="text-sm text-slate-500 font-medium line-clamp-3 mb-6 flex-1">
                        {{ Str::limit(strip_tags($b->konten), 100) }}
                    </p>
                    
                    <a href="{{ route('berita.detail', $b->slug) }}" class="inline-flex items-center justify-between w-full py-3 px-6 bg-slate-50 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-600 group-hover:bg-slate-900 group-hover:text-white transition-all">
                        Baca Artikel
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </article>
            @empty
            <div class="col-span-full py-20 text-center">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-900 uppercase">Artikel Tidak Ditemukan</h3>
                <p class="text-slate-500 text-sm mt-2">Coba kata kunci lain atau reset filter.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-16">
            {{ $berita->links() }}
        </div>
    </div>
</div>
