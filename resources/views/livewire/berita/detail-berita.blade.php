<div class="bg-white min-h-screen">
    <!-- Progress Bar Reading (Optional Visual) -->
    <div class="fixed top-0 left-0 h-1 bg-indigo-600 z-[70] w-full origin-left scale-x-0" id="readingProgress"></div>

    <!-- Hero Header -->
    <div class="relative h-[500px] w-full overflow-hidden">
        <img src="{{ $berita->gambar_sampul }}" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px]"></div>
        
        <div class="absolute inset-0 flex items-center">
            <div class="mx-auto max-w-4xl px-6 text-center space-y-8">
                <div class="flex items-center justify-center gap-4 animate-in slide-in-from-bottom-4 duration-700">
                    <span class="px-4 py-1.5 bg-indigo-500/20 border border-indigo-400/30 text-indigo-200 rounded-full text-[10px] font-black uppercase tracking-[0.2em] backdrop-blur-md">
                        {{ $berita->kategori }}
                    </span>
                    <span class="text-white/60 text-xs font-bold uppercase tracking-widest">
                        {{ $berita->created_at->translatedFormat('d F Y') }}
                    </span>
                </div>
                
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter leading-tight animate-in slide-in-from-bottom-4 duration-1000 delay-100">
                    {{ $berita->judul }}
                </h1>
                
                <div class="flex items-center justify-center gap-3 animate-in slide-in-from-bottom-4 duration-1000 delay-200">
                    <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-black text-sm border-2 border-slate-900">
                        {{ substr($berita->penulis->nama ?? 'A', 0, 1) }}
                    </div>
                    <div class="text-left">
                        <p class="text-xs font-black text-white uppercase tracking-widest">{{ $berita->penulis->nama ?? 'Tim Editorial Teqara' }}</p>
                        <p class="text-[9px] font-bold text-indigo-300 uppercase tracking-widest">Penulis Terverifikasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            
            <!-- Main Content -->
            <article class="lg:col-span-8">
                <div class="prose prose-lg prose-slate max-w-none first-letter:text-7xl first-letter:font-black first-letter:text-slate-900 first-letter:mr-3 first-letter:float-left">
                    {!! $berita->konten !!}
                </div>
                
                <!-- Share & Tags -->
                <div class="mt-16 pt-10 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex gap-2">
                        @foreach(explode(',', $berita->tags ?? '') as $tag)
                            <span class="px-3 py-1 bg-slate-50 text-slate-500 rounded-lg text-xs font-bold uppercase tracking-wide">#{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Bagikan:</span>
                        <button class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-600 hover:bg-indigo-600 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </button>
                        <button class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-600 hover:bg-blue-600 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                        </button>
                    </div>
                </div>
            </article>

            <!-- Sidebar -->
            <aside class="lg:col-span-4 space-y-10">
                <!-- Newsletter -->
                <div class="bg-indigo-600 rounded-[40px] p-8 text-white relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <h3 class="text-xl font-black uppercase tracking-tight mb-2">Buletin Mingguan</h3>
                    <p class="text-sm text-white/80 mb-6 font-medium">Dapatkan wawasan teknologi terbaru langsung di inbox Anda.</p>
                    <div class="relative">
                        <input type="email" placeholder="Email Anda" class="w-full pl-4 pr-12 py-3 rounded-xl bg-white/10 border border-white/20 text-sm placeholder:text-white/50 focus:ring-2 focus:ring-white/30 text-white">
                        <button class="absolute right-2 top-2 p-1 bg-white text-indigo-600 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Related Posts -->
                <div>
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6 border-b border-slate-100 pb-4">Artikel Terkait</h3>
                    <div class="space-y-6">
                        @foreach($terkait as $t)
                        <a href="{{ route('berita.detail', $t->slug) }}" class="group flex gap-4 items-start">
                            <div class="w-20 h-20 rounded-2xl bg-slate-50 overflow-hidden shrink-0">
                                <img src="{{ $t->gambar_sampul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2 mb-2">{{ $t->judul }}</h4>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $t->created_at->translatedFormat('d M Y') }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>