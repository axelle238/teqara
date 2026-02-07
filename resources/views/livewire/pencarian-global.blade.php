<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-2xl mx-auto text-center mb-12 animate-fade-in-down">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase mb-6">Pencarian <span class="text-indigo-600">Global</span></h1>
            
            <div class="relative group">
                <input wire:model.live.debounce.300ms="q" type="text" placeholder="Ketik nama produk, kategori, atau merek..." class="w-full py-5 pl-14 pr-6 bg-white border-2 border-slate-100 rounded-[2rem] text-lg font-bold shadow-xl shadow-indigo-500/5 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>

        @if(strlen($q) >= 3)
            <div class="flex items-center justify-between mb-6 animate-fade-in-up">
                <p class="text-sm font-bold text-slate-500">Hasil untuk "<span class="text-slate-900">{{ $q }}</span>"</p>
                <span class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-black uppercase tracking-widest text-slate-400">{{ $this->hasilPencarian->count() }} Ditemukan</span>
            </div>

            @if($this->hasilPencarian->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 animate-fade-in-up delay-100">
                @foreach($this->hasilPencarian as $p)
                <a href="{{ route('produk.detail', $p->slug) }}" class="flex items-center gap-6 p-4 bg-white rounded-[2rem] border border-slate-100 hover:shadow-xl hover:border-indigo-100 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-24 h-24 bg-slate-50 rounded-2xl flex items-center justify-center p-2 shrink-0 group-hover:bg-indigo-50/30 transition-colors">
                        <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-1">{{ $p->kategori->nama }}</p>
                        <h3 class="text-lg font-black text-slate-900 leading-tight mb-1 truncate group-hover:text-indigo-600 transition-colors">{{ $p->nama }}</h3>
                        <p class="text-sm font-bold text-slate-500">{{ $p->harga_rupiah }}</p>
                    </div>
                    <div class="pr-4 text-slate-300 group-hover:text-indigo-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="text-center py-24 bg-white rounded-[3rem] border border-dashed border-slate-200 animate-fade-in-up">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl opacity-50">🤔</div>
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Tidak Ditemukan</h3>
                <p class="text-slate-400 text-sm">Coba kata kunci lain atau periksa ejaan Anda.</p>
            </div>
            @endif
        @else
            @if(strlen($q) > 0)
            <p class="text-center text-slate-400 text-sm font-bold animate-pulse">Ketik minimal 3 karakter untuk mulai mencari...</p>
            @endif
            
            <!-- Popular Suggestions (Dummy) -->
            <div class="mt-12 text-center animate-fade-in-up delay-200">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Pencarian Populer</p>
                <div class="flex flex-wrap justify-center gap-3">
                    @foreach(['Laptop Gaming', 'iPhone 15', 'Monitor 144Hz', 'Keyboard Mekanikal', 'Mouse Logitech'] as $tag)
                    <button wire:click="$set('q', '{{ $tag }}')" class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all shadow-sm">
                        {{ $tag }}
                    </button>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>