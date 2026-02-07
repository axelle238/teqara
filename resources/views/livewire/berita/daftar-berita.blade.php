<div class="bg-slate-50 min-h-screen py-16 relative overflow-hidden font-sans antialiased">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-500/5 blur-[120px] rounded-full -z-0"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-cyan-500/5 blur-[100px] rounded-full -z-0"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row items-end justify-between gap-8 mb-16">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-black text-slate-900 uppercase tracking-tighter mb-4 leading-none">Pusat <span class="text-indigo-600">Informasi</span></h1>
                <p class="text-slate-500 text-lg font-medium leading-relaxed">Eksplorasi wawasan terbaru, panduan teknologi, dan pengumuman resmi dari ekosistem Teqara.</p>
            </div>
            <div class="flex gap-2">
                <div class="relative">
                    <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Artikel..." class="pl-12 pr-6 py-4 bg-white border border-slate-200 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 transition-all w-64">
                    <svg class="w-5 h-5 absolute left-4 top-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Featured News (If any) -->
        {{-- For now standard grid --}}

        <!-- Grid Berita -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($berita as $artikel)
            <article class="group bg-white rounded-[3rem] border border-slate-100 overflow-hidden shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col h-full">
                <!-- Thumbnail Stage -->
                <div class="relative aspect-video overflow-hidden">
                    @if($artikel->thumbnail)
                        <img src="{{ asset('storage/'.$artikel->thumbnail) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-6xl group-hover:bg-indigo-50 transition-colors">📰</div>
                    @endif
                    
                    <div class="absolute top-6 left-6 px-4 py-2 bg-white/90 backdrop-blur-md rounded-xl text-[10px] font-black uppercase tracking-widest text-indigo-600 shadow-sm border border-white">
                        {{ $artikel->kategori ?? 'TEKNOLOGI' }}
                    </div>
                </div>

                <!-- Content -->
                <div class="p-10 flex-1 flex flex-col">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $artikel->dibuat_pada->format('d M Y') }}</span>
                        <div class="w-1 h-1 rounded-full bg-slate-200"></div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $artikel->penulis->nama ?? 'Admin' }}</span>
                    </div>
                    
                    <h2 class="text-xl font-black text-slate-900 leading-tight mb-4 group-hover:text-indigo-600 transition-colors">
                        <a href="{{ route('berita.detail', $artikel->slug) }}">{{ $artikel->judul }}</a>
                    </h2>
                    
                    <p class="text-slate-500 text-sm font-medium leading-relaxed line-clamp-3 mb-8">
                        {{ $artikel->ringkasan }}
                    </p>

                    <div class="mt-auto pt-8 border-t border-slate-50">
                        <a href="{{ route('berita.detail', $artikel->slug) }}" class="inline-flex items-center gap-3 text-xs font-black text-indigo-600 uppercase tracking-[0.2em] group/btn">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full py-40 text-center bg-white rounded-[3rem] border border-slate-100 border-dashed">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-4xl">📭</span>
                </div>
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Belum Ada Berita</h3>
                <p class="text-slate-500 mt-2">Nantikan informasi menarik lainnya segera!</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-20">
            {{ $berita->links() }}
        </div>

    </div>
</div>