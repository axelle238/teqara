<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Jejak <span class="text-indigo-600">Penelusuran</span></h1>
                <p class="text-slate-500 font-medium text-sm mt-1">Produk yang baru saja Anda eksplorasi.</p>
            </div>
            <a href="{{ route('katalog') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700">Lihat Semua Katalog →</a>
        </div>

        @if($this->produkList->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($this->produkList as $p)
            <a href="{{ route('produk.detail', $p->slug) }}" class="group bg-white rounded-[2rem] p-4 border border-slate-100 hover:shadow-2xl transition-all duration-300 flex flex-col relative overflow-hidden">
                <!-- Hover Overlay -->
                <div class="absolute inset-0 bg-indigo-600/0 group-hover:bg-indigo-600/5 transition-colors z-0"></div>

                <div class="aspect-square bg-slate-50 rounded-[1.5rem] mb-4 overflow-hidden p-6 flex items-center justify-center relative z-10">
                    <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500 mix-blend-multiply">
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-1">{{ $p->kategori->nama }}</p>
                    <h3 class="font-bold text-slate-900 text-sm leading-tight mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $p->nama }}</h3>
                    <div class="flex justify-between items-end">
                        <p class="text-base font-black text-slate-900">{{ $p->harga_rupiah }}</p>
                        <span class="text-[10px] text-slate-400 font-bold">Lihat Lagi</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-24 bg-white rounded-[3rem] border border-dashed border-slate-200">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl opacity-50">👀</div>
            <h3 class="text-slate-900 font-black mb-1">Belum Ada Riwayat</h3>
            <p class="text-slate-400 text-sm mb-6">Mulai jelajahi katalog kami untuk melihat produk tersimpan di sini.</p>
            <a href="{{ route('katalog') }}" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all">Mulai Eksplorasi</a>
        </div>
        @endif

    </div>
</div>
