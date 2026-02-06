<div class="bg-white min-h-screen">
    <!-- Progress Bar Reading -->
    <div class="fixed top-0 left-0 h-1 bg-indigo-600 z-50 w-0" id="reading-progress"></div>

    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Article Content -->
            <article class="lg:col-span-8">
                <nav class="flex text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-8 gap-2">
                    <a href="/berita" class="hover:text-indigo-600">Newsroom</a>
                    <span>/</span>
                    <span class="text-indigo-600">{{ $berita->kategori }}</span>
                </nav>

                <h1 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight mb-6 tracking-tighter">{{ $berita->judul }}</h1>
                
                <div class="flex items-center gap-6 mb-10 pb-10 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-black text-slate-500">
                            {{ substr($berita->penulis->nama, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">{{ $berita->penulis->nama }}</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest">Editor</p>
                        </div>
                    </div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <p>{{ $berita->created_at->format('d F Y') }}</p>
                        <p>5 Menit Baca</p>
                    </div>
                </div>

                <div class="rounded-[32px] overflow-hidden mb-12 shadow-xl shadow-indigo-900/5">
                    <img src="{{ $berita->gambar_utama }}" class="w-full h-auto object-cover">
                </div>

                <div class="prose prose-lg prose-slate max-w-none prose-headings:font-black prose-headings:tracking-tight prose-a:text-indigo-600 hover:prose-a:text-indigo-500">
                    {!! $berita->isi !!}
                </div>

                <!-- Tags -->
                <div class="mt-12 pt-12 border-t border-slate-100 flex gap-2">
                    <span class="px-4 py-2 bg-slate-50 rounded-lg text-xs font-bold text-slate-600">#Teknologi</span>
                    <span class="px-4 py-2 bg-slate-50 rounded-lg text-xs font-bold text-slate-600">#Gadget</span>
                </div>
            </article>

            <!-- Sidebar -->
            <aside class="lg:col-span-4 space-y-12">
                
                <!-- Related Products -->
                @if($produkTerkait->count() > 0)
                <div class="bg-indigo-50 rounded-[32px] p-8 border border-indigo-100 sticky top-24">
                    <h3 class="font-black text-indigo-900 uppercase tracking-widest text-xs mb-6">Produk Terkait</h3>
                    <div class="space-y-6">
                        @foreach($produkTerkait as $p)
                        <div class="flex gap-4 group">
                            <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center shrink-0 shadow-sm border border-indigo-100 p-2">
                                <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform">
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm leading-tight mb-1 group-hover:text-indigo-600 transition-colors">
                                    <a href="{{ route('produk.detail', $p->slug) }}">{{ $p->nama }}</a>
                                </h4>
                                <p class="text-xs font-black text-indigo-500">Rp {{ number_format($p->harga_jual) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a href="/katalog" class="block w-full py-3 bg-white text-indigo-600 text-center rounded-xl text-[10px] font-black uppercase tracking-widest mt-8 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                        Lihat Katalog Lengkap
                    </a>
                </div>
                @endif

                <!-- More News -->
                <div>
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Artikel Lainnya</h3>
                    <div class="space-y-6">
                        @foreach($beritaLain as $bl)
                        <div class="group">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">{{ $bl->kategori }}</span>
                            <h4 class="font-bold text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors">
                                <a href="{{ route('berita.detail', $bl->slug) }}">{{ $bl->judul }}</a>
                            </h4>
                        </div>
                        @endforeach
                    </div>
                </div>

            </aside>
        </div>
    </div>

    <!-- Reading Progress Script -->
    <script>
        window.onscroll = function() {
            var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var scrolled = (winScroll / height) * 100;
            document.getElementById("reading-progress").style.width = scrolled + "%";
        };
    </script>
</div>
