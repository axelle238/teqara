<div class="bg-white min-h-screen py-12">
    <div class="container mx-auto px-6">
        
        <!-- Breadcrumb & Navigasi -->
        <nav class="flex text-xs font-bold text-slate-400 uppercase tracking-widest mb-10 gap-2 overflow-x-auto whitespace-nowrap">
            <a href="/" class="hover:text-indigo-600 transition-colors">Beranda</a>
            <span>/</span>
            <a href="/katalog" class="hover:text-indigo-600 transition-colors">Katalog</a>
            <span>/</span>
            <a href="/katalog?kategori={{ $produk->kategori->slug }}" class="hover:text-indigo-600 transition-colors">{{ $produk->kategori->nama }}</a>
            <span>/</span>
            <span class="text-slate-900 truncate">{{ $produk->nama }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            
            <!-- Gallery Section (Sticky) -->
            <div class="space-y-6 lg:sticky lg:top-32 h-fit">
                <div class="bg-slate-50 rounded-[40px] border border-slate-100 aspect-[4/3] flex items-center justify-center p-10 relative overflow-hidden group">
                    <img src="{{ $gambarAktif }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700 mix-blend-multiply">
                    
                    @if($stokAktif <= 0)
                         <span class="absolute top-6 left-6 px-4 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg">Habis</span>
                    @elseif($stokAktif <= 5)
                        <span class="absolute top-6 left-6 px-4 py-2 bg-amber-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg animate-pulse">
                            Segera Habis
                        </span>
                    @endif
                </div>
                
                <div class="grid grid-cols-4 gap-4">
                    @foreach($produk->gambar as $img)
                    <button wire:click="gantiGambar('{{ $img->url }}')" class="bg-white rounded-2xl border-2 {{ $gambarAktif === $img->url ? 'border-indigo-600 ring-2 ring-indigo-100' : 'border-slate-100 hover:border-indigo-200' }} aspect-square p-2 flex items-center justify-center transition-all">
                        <img src="{{ $img->url }}" class="w-full h-full object-contain mix-blend-multiply">
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
                        <span class="px-3 py-1 bg-slate-50 text-slate-500 rounded-lg text-[10px] font-black uppercase tracking-widest">
                            SKU: {{ $produk->kode_sku ?? 'TEQ-'.str_pad($produk->id, 6, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter leading-tight mb-4">
                        {{ $produk->nama }}
                    </h1>

                    <!-- Rating & Social Proof -->
                    <div class="flex items-center gap-6 pb-6 border-b border-slate-50">
                        @if($produk->rating_rata_rata > 0)
                        <div class="flex items-center gap-1 text-amber-400">
                            <span class="text-lg font-black text-slate-900 mr-1">{{ $produk->rating_rata_rata }}</span>
                            @for($i=0; $i<5; $i++)
                                <svg class="w-4 h-4 {{ $i < round($produk->rating_rata_rata) ? 'fill-current' : 'text-slate-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                            <span class="text-xs font-bold text-slate-400 ml-2 hover:text-indigo-600 cursor-pointer underline decoration-dotted">({{ $produk->ulasan->count() }} Ulasan)</span>
                        </div>
                        @endif
                        <div class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Terverifikasi
                        </div>
                    </div>
                    
                    <div class="flex items-end gap-4 mt-6">
                        <h2 class="text-5xl font-black text-indigo-600 tracking-tighter">
                            Rp {{ number_format($hargaAktif, 0, ',', '.') }}
                        </h2>
                        @if($produk->harga_jual < $hargaAktif)
                            <div class="mb-2">
                                <span class="text-lg text-slate-400 line-through font-bold block">
                                    Rp {{ number_format($produk->harga_jual * 1.2, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] font-black text-rose-500 bg-rose-50 px-2 py-1 rounded">HEMAT 20%</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Varian Selector -->
                @if($produk->memiliki_varian)
                <div class="space-y-4 pt-8 border-t border-slate-100">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-black text-slate-900 uppercase tracking-widest">Pilih Varian</span>
                        @if($varianTerpilihId)
                            <span class="text-xs font-bold text-indigo-600">{{ $produk->varian->find($varianTerpilihId)->nama_varian }}</span>
                        @endif
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @foreach($produk->varian as $v)
                        <button 
                            wire:click="pilihVarian({{ $v->id }})"
                            class="group relative px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-widest border-2 transition-all {{ $varianTerpilihId === $v->id ? 'border-indigo-600 bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'border-slate-200 text-slate-500 hover:border-indigo-300 hover:text-indigo-600 bg-white' }} {{ $v->stok < 1 ? 'opacity-50 cursor-not-allowed decoration-slice' : '' }}"
                            {{ $v->stok < 1 ? 'disabled' : '' }}
                        >
                            {{ $v->nama_varian }}
                            @if($v->stok < 1)
                                <span class="absolute -top-2 -right-2 w-4 h-4 bg-rose-500 rounded-full border-2 border-white"></span>
                            @endif
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quantity & Action -->
                <div class="space-y-6 pt-8 border-t border-slate-100">
                    <!-- Stock Indicator -->
                    @if($stokAktif > 0)
                    <div class="space-y-2">
                        <div class="flex justify-between text-[10px] font-black uppercase tracking-widest">
                            <span class="{{ $stokAktif < 10 ? 'text-amber-600' : 'text-emerald-600' }}">
                                {{ $stokAktif < 10 ? 'Stok Hampir Habis!' : 'Stok Tersedia' }}
                            </span>
                            <span class="text-slate-400">{{ $stokAktif }} Unit</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full {{ $stokAktif < 10 ? 'bg-amber-500' : 'bg-emerald-500' }} transition-all duration-500" style="width: {{ min(100, ($stokAktif / 20) * 100) }}%"></div>
                        </div>
                    </div>
                    @endif

                    <div class="flex items-center gap-6">
                        <div class="flex items-center bg-slate-50 rounded-2xl h-14 p-1">
                            <button wire:click="kurangJumlah" class="w-12 h-full rounded-xl bg-white shadow-sm text-slate-400 hover:text-indigo-600 font-black transition active:scale-90">-</button>
                            <span class="w-12 text-center font-black text-slate-900">{{ $jumlah }}</span>
                            <button wire:click="tambahJumlah" class="w-12 h-full rounded-xl bg-white shadow-sm text-slate-400 hover:text-indigo-600 font-black transition active:scale-90">+</button>
                        </div>
                        <div class="flex-1 text-xs text-slate-500 font-medium">
                            Garansi 100% uang kembali jika produk tidak sesuai deskripsi.
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button 
                            wire:click="tambahKeKeranjang" 
                            class="py-4 bg-white border-2 border-slate-900 text-slate-900 rounded-[20px] font-black text-xs uppercase tracking-[0.2em] hover:bg-slate-50 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ $stokAktif < 1 ? 'disabled' : '' }}
                        >
                            + Keranjang
                        </button>
                        <button 
                            wire:click="beliSekarang" 
                            class="py-4 bg-indigo-600 text-white rounded-[20px] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-600/30 transition-all transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                            {{ $stokAktif < 1 ? 'disabled' : '' }}
                        >
                            {{ $stokAktif < 1 ? 'Stok Habis' : 'Beli Sekarang' }}
                        </button>
                    </div>
                </div>

                <!-- Tabs Information -->
                <div x-data="{ tab: 'deskripsi' }" class="pt-10">
                    <div class="flex gap-8 border-b border-slate-200 mb-8 overflow-x-auto">
                        <button @click="tab = 'deskripsi'" :class="tab === 'deskripsi' ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : 'text-slate-400 hover:text-slate-600 pb-4'" class="text-xs font-black uppercase tracking-widest transition-all whitespace-nowrap">Deskripsi</button>
                        <button @click="tab = 'spesifikasi'" :class="tab === 'spesifikasi' ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : 'text-slate-400 hover:text-slate-600 pb-4'" class="text-xs font-black uppercase tracking-widest transition-all whitespace-nowrap">Spesifikasi</button>
                        <button @click="tab = 'ulasan'" :class="tab === 'ulasan' ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : 'text-slate-400 hover:text-slate-600 pb-4'" class="text-xs font-black uppercase tracking-widest transition-all whitespace-nowrap">Ulasan ({{ $produk->ulasan->count() }})</button>
                    </div>

                    <div x-show="tab === 'deskripsi'" class="prose prose-slate prose-lg max-w-none text-slate-600 leading-relaxed animate-in fade-in slide-in-from-bottom-2">
                        {!! $produk->deskripsi_lengkap !!}
                    </div>

                    <div x-show="tab === 'spesifikasi'" class="animate-in fade-in slide-in-from-bottom-2" style="display: none;">
                        <div class="bg-slate-50 rounded-[32px] p-8 border border-slate-100">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-slate-200">
                                    @forelse($produk->spesifikasi as $spek)
                                    <tr>
                                        <td class="py-4 font-bold text-slate-500 text-sm w-1/3">{{ $spek->label }}</td>
                                        <td class="py-4 font-black text-slate-900 text-sm">{{ $spek->nilai }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="2" class="text-center text-slate-400 py-4">Tidak ada spesifikasi khusus.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div x-show="tab === 'ulasan'" class="space-y-8 animate-in fade-in slide-in-from-bottom-2" style="display: none;">
                        <!-- Review Stats -->
                        @if(count($this->statistikRating) > 0)
                        <div class="flex items-center gap-8 bg-slate-50 p-8 rounded-[32px] mb-8">
                            <div class="text-center">
                                <span class="text-5xl font-black text-slate-900 block">{{ number_format($produk->rating_rata_rata, 1) }}</span>
                                <div class="flex text-amber-400 justify-center my-2">
                                    @for($i=0; $i<5; $i++) ★ @endfor
                                </div>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $produk->ulasan->count() }} Ulasan</span>
                            </div>
                            <div class="flex-1 space-y-2 border-l border-slate-200 pl-8">
                                @foreach($this->statistikRating as $bintang => $data)
                                <div class="flex items-center gap-3 text-xs font-bold">
                                    <span class="w-8 text-slate-500">{{ $bintang }} ★</span>
                                    <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-indigo-500" style="width: {{ $data['persen'] }}%"></div>
                                    </div>
                                    <span class="w-8 text-right text-slate-400">{{ $data['jumlah'] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @forelse($produk->ulasan as $ulasan)
                        <div class="group border-b border-slate-100 pb-8 last:border-0">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-100 to-white flex items-center justify-center font-black text-indigo-600 text-sm border border-indigo-50">
                                        {{ substr($ulasan->pengguna->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-sm">{{ $ulasan->pengguna->nama }}</h4>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $ulasan->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex text-amber-400 text-xs">
                                    @for($i=0; $i<$ulasan->rating; $i++) ★ @endfor
                                </div>
                            </div>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $ulasan->komentar }}</p>
                        </div>
                        @empty
                        <div class="text-center py-12 bg-slate-50 rounded-[32px] border border-dashed border-slate-200">
                            <p class="text-slate-400 font-bold">Belum ada ulasan untuk produk ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

        <!-- Cross-Selling: Produk Terkait -->
        @if($this->produkTerkait->count() > 0)
        <div class="mt-32 border-t border-slate-100 pt-16">
            <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tighter mb-10">Mungkin Anda <span class="text-indigo-600">Suka</span></h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($this->produkTerkait as $p)
                <a href="{{ route('produk.detail', $p->slug) }}" class="group bg-white rounded-[32px] p-4 border border-slate-100 hover:shadow-xl hover:border-indigo-100 transition-all duration-300">
                    <div class="relative bg-slate-50 rounded-[24px] aspect-square overflow-hidden mb-4 flex items-center justify-center p-6">
                        <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500 mix-blend-multiply">
                    </div>
                    <div class="px-2 pb-2">
                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">{{ $p->kategori->nama }}</p>
                        <h4 class="font-bold text-slate-900 text-sm leading-tight mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $p->nama }}</h4>
                        <p class="text-lg font-black text-slate-900 tracking-tight">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>