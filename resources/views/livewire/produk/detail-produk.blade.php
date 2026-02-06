<div class="bg-white min-h-screen py-12">
    <div class="container mx-auto px-6">
        
        <!-- Breadcrumb -->
        <nav class="flex text-xs font-bold text-slate-400 uppercase tracking-widest mb-10 gap-2">
            <a href="/" class="hover:text-indigo-600 transition-colors">Beranda</a>
            <span>/</span>
            <a href="/katalog?kategori={{ $produk->kategori->slug }}" class="hover:text-indigo-600 transition-colors">{{ $produk->kategori->nama }}</a>
            <span>/</span>
            <span class="text-slate-900">{{ $produk->nama }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            
            <!-- Gallery Section (Sticky) -->
            <div class="space-y-6 lg:sticky lg:top-32 h-fit">
                <div class="bg-slate-50 rounded-[40px] border border-slate-100 aspect-[4/3] flex items-center justify-center p-10 relative overflow-hidden group">
                    <img src="{{ $gambarAktif }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-700">
                    
                    @if($stokAktif <= 5 && $stokAktif > 0)
                        <span class="absolute top-6 left-6 px-4 py-2 bg-amber-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg animate-pulse">
                            Stok Menipis
                        </span>
                    @endif
                </div>
                
                <div class="grid grid-cols-4 gap-4">
                    @foreach($produk->gambar as $img)
                    <button wire:click="gantiGambar('{{ $img->url }}')" class="bg-white rounded-2xl border-2 {{ $gambarAktif === $img->url ? 'border-indigo-600 ring-2 ring-indigo-100' : 'border-slate-100 hover:border-indigo-200' }} aspect-square p-2 flex items-center justify-center transition-all">
                        <img src="{{ $img->url }}" class="w-full h-full object-contain">
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Product Info -->
            <div class="space-y-10">
                <div>
                    <div class="flex items-center gap-4 mb-4">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-widest">
                            {{ $produk->merek->nama ?? 'Official Brand' }}
                        </span>
                        @if($produk->rating_rata_rata > 0)
                        <div class="flex items-center gap-1 text-amber-400">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-4 h-4 {{ $i < round($produk->rating_rata_rata) ? 'fill-current' : 'text-slate-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                            <span class="text-xs font-bold text-slate-400 ml-2">({{ $produk->ulasan->count() }} Ulasan)</span>
                        </div>
                        @endif
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter leading-tight mb-6">
                        {{ $produk->nama }}
                    </h1>
                    
                    <div class="flex items-end gap-4">
                        <h2 class="text-4xl font-black text-indigo-600 tracking-tighter">
                            Rp {{ number_format($hargaAktif, 0, ',', '.') }}
                        </h2>
                        @if($produk->harga_jual < $hargaAktif) <!-- Contoh logika diskon -->
                            <span class="text-lg text-slate-400 line-through font-bold mb-1">
                                Rp {{ number_format($produk->harga_jual * 1.2, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Varian Selector -->
                @if($produk->memiliki_varian)
                <div class="space-y-4 pt-8 border-t border-slate-100">
                    <span class="text-xs font-black text-slate-900 uppercase tracking-widest">Pilih Varian</span>
                    <div class="flex flex-wrap gap-3">
                        @foreach($produk->varian as $v)
                        <button 
                            wire:click="pilihVarian({{ $v->id }})"
                            class="px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-widest border-2 transition-all {{ $varianTerpilihId === $v->id ? 'border-indigo-600 bg-indigo-50 text-indigo-700' : 'border-slate-200 text-slate-500 hover:border-slate-300' }} {{ $v->stok < 1 ? 'opacity-50 cursor-not-allowed decoration-slice' : '' }}"
                            {{ $v->stok < 1 ? 'disabled' : '' }}
                        >
                            {{ $v->nama_varian }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quantity & Action -->
                <div class="space-y-6 pt-8 border-t border-slate-100">
                    <div class="flex items-center gap-6">
                        <div class="flex items-center border-2 border-slate-200 rounded-2xl h-14">
                            <button wire:click="kurangJumlah" class="px-4 h-full text-slate-400 hover:text-indigo-600 font-black">-</button>
                            <span class="w-12 text-center font-black text-slate-900">{{ $jumlah }}</span>
                            <button wire:click="tambahJumlah" class="px-4 h-full text-slate-400 hover:text-indigo-600 font-black">+</button>
                        </div>
                        <span class="text-xs font-bold text-slate-500">
                            Stok Tersedia: <span class="text-slate-900">{{ $stokAktif }}</span> Unit
                        </span>
                    </div>

                    <div class="flex gap-4">
                        <button 
                            wire:click="tambahKeKeranjang" 
                            class="flex-1 bg-slate-900 text-white py-5 rounded-[20px] font-black text-sm uppercase tracking-[0.2em] hover:bg-indigo-600 hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-slate-900/20 disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ $stokAktif < 1 ? 'disabled' : '' }}
                        >
                            {{ $stokAktif < 1 ? 'Stok Habis' : 'Tambah Keranjang' }}
                        </button>
                        <button class="w-16 h-full border-2 border-slate-200 rounded-[20px] flex items-center justify-center text-slate-400 hover:border-rose-200 hover:text-rose-500 hover:bg-rose-50 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Tabs: Spesifikasi & Deskripsi -->
                <div x-data="{ tab: 'deskripsi' }" class="pt-10">
                    <div class="flex gap-8 border-b border-slate-200 mb-6">
                        <button @click="tab = 'deskripsi'" :class="tab === 'deskripsi' ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : 'text-slate-400 hover:text-slate-600 pb-4'" class="text-xs font-black uppercase tracking-widest transition-all">Deskripsi</button>
                        <button @click="tab = 'spesifikasi'" :class="tab === 'spesifikasi' ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : 'text-slate-400 hover:text-slate-600 pb-4'" class="text-xs font-black uppercase tracking-widest transition-all">Spesifikasi Teknis</button>
                        <button @click="tab = 'ulasan'" :class="tab === 'ulasan' ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : 'text-slate-400 hover:text-slate-600 pb-4'" class="text-xs font-black uppercase tracking-widest transition-all">Ulasan ({{ $produk->ulasan->count() }})</button>
                    </div>

                    <div x-show="tab === 'deskripsi'" class="prose prose-slate max-w-none text-sm text-slate-600 leading-relaxed animate-in fade-in slide-in-from-bottom-2">
                        {!! $produk->deskripsi_lengkap !!}
                    </div>

                    <div x-show="tab === 'spesifikasi'" class="space-y-4 animate-in fade-in slide-in-from-bottom-2" style="display: none;">
                        @foreach($produk->spesifikasi as $spek)
                        <div class="flex justify-between py-3 border-b border-slate-50 last:border-0">
                            <span class="font-bold text-slate-500 text-sm">{{ $spek->label }}</span>
                            <span class="font-black text-slate-900 text-sm">{{ $spek->nilai }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div x-show="tab === 'ulasan'" class="space-y-6 animate-in fade-in slide-in-from-bottom-2" style="display: none;">
                        @forelse($produk->ulasan as $ulasan)
                        <div class="bg-slate-50 p-6 rounded-2xl">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center font-black text-indigo-600 text-xs">
                                    {{ substr($ulasan->pengguna->nama, 0, 1) }}
                                </div>
                                <span class="font-bold text-slate-900 text-sm">{{ $ulasan->pengguna->nama }}</span>
                                <div class="flex text-amber-400 text-[10px]">
                                    @for($i=0; $i<$ulasan->rating; $i++) ★ @endfor
                                </div>
                            </div>
                            <p class="text-sm text-slate-600">{{ $ulasan->komentar }}</p>
                        </div>
                        @empty
                        <p class="text-center text-slate-400 text-sm py-10">Belum ada ulasan untuk produk ini.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>