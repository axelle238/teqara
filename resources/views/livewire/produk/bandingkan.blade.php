<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Bandingkan <span class="text-indigo-600">Produk</span></h1>
                <p class="text-slate-500 font-medium text-sm mt-2">Komparasi spesifikasi untuk keputusan terbaik.</p>
            </div>
            @if($this->produkList->count() > 0)
            <button wire:click="hapusSemua" wire:confirm="Hapus semua produk dari daftar perbandingan?" class="text-xs font-bold text-rose-500 hover:text-rose-600 uppercase tracking-widest bg-rose-50 px-4 py-2 rounded-xl transition-colors">
                Reset Semua
            </button>
            @endif
        </div>

        @if($this->produkList->count() > 0)
        <div class="overflow-x-auto pb-8">
            <div class="min-w-[800px]">
                <!-- Header: Product Info -->
                <div class="grid grid-cols-{{ $this->produkList->count() + 1 }} gap-8 mb-8">
                    <div class="flex items-end pb-8">
                        <div class="text-sm font-bold text-slate-400">Spesifikasi</div>
                    </div>
                    @foreach($this->produkList as $p)
                    <div class="relative bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-xl group hover:-translate-y-2 transition-transform duration-300">
                        <button wire:click="hapus({{ $p->id }})" class="absolute top-4 right-4 w-8 h-8 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center hover:bg-rose-50 hover:text-rose-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                        
                        <div class="aspect-square bg-slate-50 rounded-2xl mb-4 p-4 flex items-center justify-center">
                            <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply">
                        </div>
                        
                        <h3 class="font-black text-slate-900 text-sm mb-2 h-10 line-clamp-2">{{ $p->nama }}</h3>
                        <p class="text-lg font-black text-indigo-600 mb-4">{{ $p->harga_rupiah }}</p>
                        
                        <a href="{{ route('produk.detail', $p->slug) }}" class="block w-full py-3 bg-slate-900 text-white text-center rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                    @endforeach
                </div>

                <!-- Specs Comparison Grid -->
                <div class="space-y-2">
                    @php
                        // Collect all unique spec keys
                        $allSpecs = $this->produkList->flatMap->spesifikasi->pluck('judul')->unique();
                    @endphp

                    @foreach($allSpecs as $specKey)
                    <div class="grid grid-cols-{{ $this->produkList->count() + 1 }} gap-8 p-4 bg-white rounded-2xl border border-slate-100 hover:border-indigo-100 hover:shadow-sm transition-all">
                        <div class="flex items-center text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $specKey }}</div>
                        @foreach($this->produkList as $p)
                            @php
                                $val = $p->spesifikasi->firstWhere('judul', $specKey);
                            @endphp
                            <div class="flex items-center text-sm font-bold text-slate-900">
                                {{ $val ? $val->nilai : '-' }}
                            </div>
                        @endforeach
                    </div>
                    @endforeach

                    <!-- Rating Row -->
                    <div class="grid grid-cols-{{ $this->produkList->count() + 1 }} gap-8 p-4 bg-amber-50 rounded-2xl border border-amber-100 mt-4">
                        <div class="flex items-center text-xs font-bold text-amber-600 uppercase tracking-widest">Rating Pengguna</div>
                        @foreach($this->produkList as $p)
                        <div class="flex items-center gap-1 font-black text-amber-500">
                            <span>{{ number_format($p->rating_rata_rata, 1) }}</span>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="flex flex-col items-center justify-center py-32 bg-white rounded-[3rem] border border-dashed border-slate-200">
            <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl shadow-inner">⚖️</div>
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Belum Ada Produk</h3>
            <p class="text-slate-400 text-sm font-medium mb-8 max-w-sm text-center">Tambahkan produk dari halaman detail untuk mulai membandingkan.</p>
            <a href="{{ route('katalog') }}" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20">
                Ke Katalog
            </a>
        </div>
        @endif

    </div>
</div>
