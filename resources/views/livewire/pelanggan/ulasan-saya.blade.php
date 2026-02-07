<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-12 animate-fade-in-down">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Riwayat <span class="text-indigo-600">Ulasan</span></h1>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-2">Jejak Pendapat & Kontribusi Anda</p>
            </div>
            <div class="bg-white px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-black uppercase tracking-widest text-slate-500 shadow-sm flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Total: {{ $this->ulasan->count() }}
            </div>
        </div>

        @if($this->ulasan->count() > 0)
        <div class="grid grid-cols-1 gap-8">
            @foreach($this->ulasan as $ulasan)
            <div class="group bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 animate-fade-in-up">
                <div class="flex flex-col md:flex-row gap-8">
                    
                    <!-- Product Thumb -->
                    <div class="w-full md:w-64 aspect-video md:aspect-square rounded-[2rem] bg-slate-50 border border-slate-100 p-6 flex items-center justify-center shrink-0 relative overflow-hidden group-hover:bg-indigo-50/20 transition-colors">
                        <img src="{{ $ulasan->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500">
                        
                        <div class="absolute top-4 left-4 bg-white/80 backdrop-blur-md px-3 py-1 rounded-lg border border-white/50 shadow-sm">
                            <div class="flex items-center gap-1">
                                <span class="text-lg font-black text-amber-500">{{ $ulasan->rating }}</span>
                                <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Review Content -->
                    <div class="flex-1 min-w-0 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-black text-slate-900 text-xl uppercase tracking-tight leading-tight mb-1 group-hover:text-indigo-600 transition-colors">{{ $ulasan->produk->nama }}</h3>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                        <span>{{ $ulasan->dibuat_pada->format('d M Y') }}</span>
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span>Variasi: {{ $ulasan->varian ?? 'Default' }}</span>
                                    </p>
                                </div>
                                <div class="hidden md:block">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[9px] font-black uppercase tracking-widest">Terverifikasi</span>
                                </div>
                            </div>

                            <div class="relative">
                                <svg class="absolute -top-3 -left-3 w-8 h-8 text-slate-200 transform -scale-x-100" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg>
                                <p class="bg-slate-50/80 rounded-2xl p-6 border border-slate-100 text-sm font-medium text-slate-600 leading-relaxed italic relative z-10 shadow-inner">
                                    {{ $ulasan->komentar }}
                                </p>
                            </div>
                        </div>

                        @if($ulasan->foto_ulasan && count($ulasan->foto_ulasan) > 0)
                        <div class="mt-6">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Foto Lampiran</p>
                            <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                                @foreach($ulasan->foto_ulasan as $foto)
                                <div class="w-20 h-20 rounded-xl overflow-hidden border border-slate-200 shrink-0 shadow-sm hover:scale-105 transition-transform cursor-zoom-in">
                                    <img src="{{ $foto }}" class="w-full h-full object-cover">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="flex flex-col items-center justify-center py-32 bg-white rounded-[3rem] border border-dashed border-slate-200 animate-fade-in-up">
            <div class="w-24 h-24 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full flex items-center justify-center mb-8 text-4xl shadow-inner animate-bounce-slow text-amber-500">⭐</div>
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Suara Anda Penting</h3>
            <p class="text-slate-400 text-sm font-medium max-w-sm text-center mb-8 leading-relaxed">Belum ada ulasan yang diberikan. Bagikan pengalaman belanja Anda untuk membantu komunitas Teqara.</p>
            <a href="{{ route('pesanan.riwayat') }}" class="px-10 py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/20 active:scale-95">
                Lihat Pesanan Selesai
            </a>
        </div>
        @endif

    </div>
</div>