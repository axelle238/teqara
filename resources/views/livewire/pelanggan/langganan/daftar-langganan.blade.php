<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-12 text-center animate-fade-in-down">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Langganan <span class="text-indigo-600">Rutin</span></h1>
            <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-2">Otomatisasi Stok Operasional Bisnis</p>
        </div>

        @if($this->langganan->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($this->langganan as $sub)
            <div class="group relative bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden animate-fade-in-up">
                
                <!-- Status Badge -->
                <div class="absolute top-6 right-6 z-10">
                    @if($sub->status == 'aktif')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-rose-100">
                            Terhenti
                        </span>
                    @endif
                </div>

                <!-- Product Image -->
                <div class="relative w-full aspect-square bg-slate-50 rounded-[2rem] mb-6 flex items-center justify-center p-8 group-hover:bg-indigo-50/30 transition-colors">
                    <img src="{{ $sub->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500">
                    
                    <!-- Interval Badge -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 px-4 py-2 bg-white/80 backdrop-blur-md rounded-xl shadow-sm border border-white/50 text-[10px] font-black uppercase tracking-widest text-slate-600 whitespace-nowrap">
                        Setiap {{ $sub->interval }} Hari
                    </div>
                </div>

                <!-- Info -->
                <div class="text-center mb-6">
                    <h4 class="text-lg font-black text-slate-900 leading-tight mb-1 line-clamp-1 group-hover:text-indigo-600 transition-colors">{{ $sub->produk->nama }}</h4>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Tagihan: {{ $sub->tagihan_berikutnya->format('d M Y') }}</p>
                </div>

                <!-- Actions -->
                <a href="{{ route('customer.subscription.detail', $sub->id) }}" class="block w-full py-4 bg-slate-900 text-white text-center rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/20 active:scale-95">
                    Kelola Paket
                </a>
            </div>
            @endforeach
        </div>
        
        <div class="mt-12 p-6 bg-indigo-50 rounded-[2rem] border border-indigo-100 text-center max-w-2xl mx-auto">
            <p class="text-xs font-bold text-indigo-800">💡 Tip Cerdas</p>
            <p class="text-[10px] text-indigo-600 mt-1">Berlangganan lebih dari 5 item? Hubungi Sales Enterprise untuk diskon volume khusus.</p>
        </div>

        @else
        <div class="flex flex-col items-center justify-center py-32 bg-white rounded-[3rem] border border-dashed border-slate-200 animate-fade-in-up">
            <div class="w-24 h-24 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-full flex items-center justify-center mb-8 text-4xl shadow-inner animate-spin-slow">🔄</div>
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Mulai Otomatisasi</h3>
            <p class="text-slate-400 text-sm font-medium max-w-md text-center mb-8 leading-relaxed">Jangan biarkan stok habis menghambat bisnis. Aktifkan pengiriman berkala untuk produk esensial Anda.</p>
            <a href="{{ route('katalog') }}" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/30 active:scale-95">
                Cari Produk
            </a>
        </div>
        @endif

    </div>
</div>
