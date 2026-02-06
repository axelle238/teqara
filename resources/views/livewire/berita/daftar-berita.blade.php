<div class="bg-slate-50 min-h-screen pb-24">
    <!-- Hero Header -->
    <div class="bg-slate-900 text-white py-20 relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10 text-center">
            <h1 class="text-5xl font-black tracking-tighter mb-4 uppercase">News<span class="text-indigo-500">room</span></h1>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto">Wawasan teknologi terkini, panduan pembelian, dan rilis produk terbaru.</p>
        </div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
    </div>

    <div class="container mx-auto px-6 -mt-10 relative z-20">
        <!-- Search & Filter -->
        <div class="bg-white p-6 rounded-[32px] shadow-xl shadow-indigo-900/10 border border-slate-100 flex flex-col md:flex-row items-center gap-6 mb-12">
            <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
                <button wire:click="$set('kategori', 'semua')" class="px-6 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-all {{ $kategori === 'semua' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">Semua</button>
                <button wire:click="$set('kategori', 'teknologi')" class="px-6 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-all {{ $kategori === 'teknologi' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">Teknologi</button>
                <button wire:click="$set('kategori', 'tutorial')" class="px-6 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-all {{ $kategori === 'tutorial' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">Tutorial</button>
            </div>
            <div class="flex-1 w-full">
                <div class="relative group">
                    <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari artikel menarik..." class="w-full pl-12 pr-6 py-3 bg-slate-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                    <svg class="w-5 h-5 absolute left-4 top-3.5 text-slate-400 group-focus-within:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>

        @if($beritaUtama && !$cari && $daftarBerita->onFirstPage())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <div class="relative h-[400px] rounded-[40px] overflow-hidden group">
                <img src="{{ $beritaUtama->gambar_utama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent p-10 flex flex-col justify-end">
                    <span class="px-3 py-1 bg-indigo-600 text-white rounded-lg text-[10px] font-black uppercase tracking-widest w-fit mb-4">Berita Utama</span>
                    <h2 class="text-3xl md:text-4xl font-black text-white leading-tight mb-4 hover:text-indigo-300 transition-colors">
                        <a href="{{ route('berita.detail', $beritaUtama->slug) }}">{{ $beritaUtama->judul }}</a>
                    </h2>
                    <p class="text-slate-300 line-clamp-2 mb-6">{{ $beritaUtama->ringkasan }}</p>
                    <div class="flex items-center gap-4 text-xs font-bold text-slate-400">
                        <span>{{ $beritaUtama->penulis->nama }}</span>
                        <span>•</span>
                        <span>{{ $beritaUtama->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
            <!-- Bisa diisi secondary featured news disini jika ada -->
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($daftarBerita as $b)
                @if($beritaUtama && $b->id === $beritaUtama->id && !$cari && $daftarBerita->onFirstPage()) @continue @endif
                
                <div class="group bg-white rounded-[32px] overflow-hidden border border-slate-100 hover:shadow-2xl hover:shadow-indigo-500/10 hover:border-indigo-100 transition-all duration-500 flex flex-col h-full">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $b->gambar_utama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-[9px] font-black uppercase tracking-widest text-slate-900 border border-white/20">
                                {{ $b->kategori }}
                            </span>
                        </div>
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <a href="{{ route('berita.detail', $b->slug) }}" class="block mb-3">
                            <h3 class="text-xl font-black text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2">{{ $b->judul }}</h3>
                        </a>
                        <p class="text-sm text-slate-500 line-clamp-3 mb-6 leading-relaxed">{{ $b->ringkasan }}</p>
                        <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            <span>{{ $b->created_at->format('d M Y') }}</span>
                            <a href="{{ route('berita.detail', $b->slug) }}" class="text-indigo-600 hover:text-indigo-800 flex items-center gap-1 group/link">
                                Baca
                                <svg class="w-3 h-3 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-slate-400 font-bold uppercase text-xs tracking-widest">Tidak ada artikel ditemukan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $daftarBerita->links() }}
        </div>
    </div>
</div>
