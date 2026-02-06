<div class="bg-white min-h-screen pb-12">
    <!-- Breadcrumb -->
    <div class="bg-slate-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex text-xs font-bold text-slate-400 uppercase tracking-widest gap-2">
                <a href="/" class="hover:text-indigo-600 transition-colors">Beranda</a>
                <span>/</span>
                <a href="/katalog" class="hover:text-indigo-600 transition-colors">Katalog</a>
                <span>/</span>
                <a href="/katalog?kategori={{ $produk->kategori->slug }}" class="hover:text-indigo-600 transition-colors">{{ $produk->kategori->nama }}</a>
                <span>/</span>
                <span class="text-slate-900 truncate max-w-[150px]">{{ $produk->nama }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
            
            <!-- Gallery Section -->
            <div class="flex flex-col-reverse">
                <!-- Image Selector -->
                <div class="hidden mt-6 w-full max-w-2xl mx-auto sm:block lg:max-w-none">
                    <div class="grid grid-cols-4 gap-6" x-data>
                        @foreach($produk->gambar as $img)
                        <button wire:click="gantiGambar('{{ $img->url }}')" class="relative h-24 bg-white rounded-2xl flex items-center justify-center text-sm font-medium uppercase text-slate-900 cursor-pointer hover:bg-slate-50 focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-offset-4 ring-indigo-500 overflow-hidden border-2 {{ $gambarAktif == $img->url ? 'border-indigo-600' : 'border-transparent' }}">
                            <img src="{{ asset('storage/'.$img->url) }}" class="w-full h-full object-contain p-2">
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Main Image -->
                <div class="w-full aspect-square rounded-[2.5rem] bg-slate-50 border border-slate-100 overflow-hidden flex items-center justify-center p-8 relative group">
                    <img src="{{ asset('storage/'.$gambarAktif) }}" class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-110" alt="{{ $produk->nama }}">
                    
                    <!-- Zoom Icon -->
                    <div class="absolute top-4 right-4 p-2 bg-white/80 backdrop-blur rounded-full text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                    </div>

                    @if($stokAktif < 1)
                        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px] z-10 flex items-center justify-center">
                            <span class="px-6 py-3 bg-white text-slate-900 text-sm font-black uppercase tracking-[0.2em] rounded-2xl shadow-2xl transform -rotate-12">Stok Habis</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                <!-- Brand Badge -->
                @if($produk->merek)
                <div class="mb-4">
                    <a href="/katalog?merek={{ $produk->merek->slug }}" class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                        {{ $produk->merek->nama }}
                    </a>
                </div>
                @endif

                <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl leading-tight mb-4">{{ $produk->nama }}</h1>
                
                <!-- Rating -->
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex items-center">
                        @for($i=0; $i<5; $i++)
                            <svg class="w-5 h-5 {{ $i < round($produk->rating_rata_rata) ? 'text-amber-400' : 'text-slate-200' }} fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    <a href="#ulasan" class="text-sm font-bold text-indigo-600 hover:text-indigo-500">{{ $produk->ulasan->count() }} Ulasan</a>
                </div>

                <!-- Price -->
                <div class="mb-8">
                    <p class="text-4xl font-black text-slate-900 tracking-tight">
                        Rp {{ number_format($hargaAktif, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-slate-500 mt-1">Termasuk pajak. Gratis ongkir wilayah tertentu.</p>
                </div>

                <div class="h-px w-full bg-slate-100 mb-8"></div>

                <!-- Varian Selector -->
                @if($produk->memiliki_varian && $produk->varian->count() > 0)
                <div class="mb-8">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4">Pilih Varian</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($produk->varian as $varian)
                        <button wire:click="pilihVarian({{ $varian->id }})" class="relative group px-4 py-3 rounded-xl border-2 text-left transition-all {{ $varianTerpilihId == $varian->id ? 'border-indigo-600 bg-indigo-50' : 'border-slate-200 bg-white hover:border-indigo-300' }}">
                            <span class="block text-xs font-bold text-slate-900 uppercase mb-1">{{ $varian->nama_varian }}</span>
                            <span class="block text-xs text-slate-500 group-hover:text-indigo-600 font-medium">
                                + Rp {{ number_format($varian->harga_tambahan, 0, ',', '.') }}
                            </span>
                            @if($varianTerpilihId == $varian->id)
                                <div class="absolute top-2 right-2 w-2 h-2 rounded-full bg-indigo-600"></div>
                            @endif
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quantity & Actions -->
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    <!-- Quantity Input -->
                    <div class="flex items-center border border-slate-200 rounded-2xl p-1 w-full sm:w-auto">
                        <button wire:click="kurangJumlah" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-500 hover:text-indigo-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                        </button>
                        <input type="number" wire:model="jumlah" class="w-12 text-center border-none p-0 text-slate-900 font-bold focus:ring-0" readonly>
                        <button wire:click="tambahJumlah" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-500 hover:text-indigo-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>

                    <!-- Add to Cart -->
                    <button wire:click="tambahKeKeranjang" class="flex-1 px-8 py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl hover:shadow-indigo-500/30 flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed" @if($stokAktif < 1) disabled @endif>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        {{ $stokAktif < 1 ? 'Habis' : 'Keranjang' }}
                    </button>

                    <!-- Buy Now -->
                    {{-- <button wire:click="beliSekarang" class="flex-1 px-8 py-4 bg-white border-2 border-slate-900 text-slate-900 rounded-2xl font-black uppercase tracking-widest hover:bg-slate-50 transition-all disabled:opacity-50" @if($stokAktif < 1) disabled @endif>
                        Beli Langsung
                    </button> --}}
                </div>

                <!-- Stock Indicator -->
                <div class="mb-8">
                    <div class="flex items-center justify-between text-xs font-bold uppercase tracking-widest text-slate-500 mb-2">
                        <span>Ketersediaan Stok</span>
                        <span class="{{ $stokAktif < 5 ? 'text-rose-500' : 'text-emerald-500' }}">{{ $stokAktif }} Unit Tersedia</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500 {{ $stokAktif < 5 ? 'bg-rose-500' : 'bg-emerald-500' }}" style="width: {{ min(100, ($stokAktif / 50) * 100) }}%"></div>
                    </div>
                </div>

                <!-- Policies -->
                <div class="bg-indigo-50/50 rounded-3xl p-6 border border-indigo-100">
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm text-slate-600"><strong class="text-slate-900">Garansi 1 Tahun.</strong> Tukar baru jika cacat pabrik dalam 7 hari.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm text-slate-600"><strong class="text-slate-900">Pengiriman Cepat.</strong> Pesan sebelum 14:00 dikirim hari ini.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tabs Section (Desc, Specs, Reviews) -->
        <div class="mt-24" x-data="{ tab: 'deskripsi' }">
            <div class="flex items-center gap-8 border-b border-slate-200 overflow-x-auto">
                <button @click="tab = 'deskripsi'" :class="{ 'border-indigo-600 text-indigo-600': tab === 'deskripsi', 'border-transparent text-slate-500 hover:text-slate-700': tab !== 'deskripsi' }" class="whitespace-nowrap pb-4 border-b-2 text-sm font-black uppercase tracking-widest transition-colors">
                    Deskripsi Produk
                </button>
                <button @click="tab = 'spesifikasi'" :class="{ 'border-indigo-600 text-indigo-600': tab === 'spesifikasi', 'border-transparent text-slate-500 hover:text-slate-700': tab !== 'spesifikasi' }" class="whitespace-nowrap pb-4 border-b-2 text-sm font-black uppercase tracking-widest transition-colors">
                    Spesifikasi Teknis
                </button>
                <button @click="tab = 'ulasan'" :class="{ 'border-indigo-600 text-indigo-600': tab === 'ulasan', 'border-transparent text-slate-500 hover:text-slate-700': tab !== 'ulasan' }" class="whitespace-nowrap pb-4 border-b-2 text-sm font-black uppercase tracking-widest transition-colors">
                    Ulasan ({{ $produk->ulasan->count() }})
                </button>
            </div>

            <div class="py-10">
                <!-- Deskripsi -->
                <div x-show="tab === 'deskripsi'" class="prose prose-slate prose-lg max-w-none text-slate-500 leading-relaxed">
                    {!! $produk->deskripsi_lengkap !!}
                </div>

                <!-- Spesifikasi -->
                <div x-show="tab === 'spesifikasi'" style="display: none;">
                    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden max-w-3xl">
                        <table class="w-full text-left text-sm">
                            <tbody class="divide-y divide-slate-100">
                                @foreach($produk->spesifikasi as $spec)
                                <tr class="hover:bg-slate-50/50">
                                    <th class="px-6 py-4 font-bold text-slate-900 w-1/3">{{ $spec->judul }}</th>
                                    <td class="px-6 py-4 text-slate-600">{{ $spec->nilai }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Ulasan -->
                <div x-show="tab === 'ulasan'" style="display: none;">
                    <div class="grid md:grid-cols-12 gap-12">
                        <!-- Summary -->
                        <div class="md:col-span-4 space-y-8">
                            <div class="bg-indigo-50/50 rounded-3xl p-8 text-center border border-indigo-100">
                                <div class="text-6xl font-black text-indigo-600 mb-2">{{ number_format($produk->rating_rata_rata, 1) }}</div>
                                <div class="flex justify-center text-amber-400 text-lg mb-2">
                                    @for($i=0; $i<5; $i++)
                                        <span>{{ $i < round($produk->rating_rata_rata) ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                                <div class="text-sm font-bold text-slate-500 uppercase tracking-widest">Berdasarkan {{ $produk->ulasan->count() }} Ulasan</div>
                            </div>
                            
                            <!-- Breakdown -->
                            <div class="space-y-3">
                                @foreach($this->statistikRating as $bintang => $data)
                                <div class="flex items-center gap-3 text-xs font-bold text-slate-500">
                                    <span class="w-8">{{ $bintang }} ★</span>
                                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-400 rounded-full" style="width: {{ $data['persen'] }}%"></div>
                                    </div>
                                    <span class="w-8 text-right">{{ $data['jumlah'] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- List -->
                        <div class="md:col-span-8 space-y-8">
                            @forelse($produk->ulasan as $ulasan)
                            <div class="flex gap-4">
                                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center font-bold text-slate-500 uppercase">
                                    {{ substr($ulasan->pengguna->nama ?? 'A', 0, 2) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-bold text-slate-900">{{ $ulasan->pengguna->nama ?? 'Anonim' }}</h4>
                                        <span class="text-xs text-slate-400 font-bold uppercase">{{ $ulasan->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex text-amber-400 text-xs mb-3">
                                        @for($i=0; $i<5; $i++)
                                            <span>{{ $i < $ulasan->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                    <p class="text-slate-600 text-sm leading-relaxed">{{ $ulasan->komentar }}</p>
                                </div>
                            </div>
                            <div class="h-px bg-slate-50"></div>
                            @empty
                            <div class="text-center py-12 text-slate-400">
                                Belum ada ulasan untuk produk ini.
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-24 border-t border-slate-200 pt-16">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-10">Produk Serupa</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($this->produkTerkait as $rel)
                <a href="{{ route('produk.detail', $rel->slug) }}" class="group block">
                    <div class="bg-slate-50 rounded-3xl aspect-[4/3] mb-4 overflow-hidden flex items-center justify-center p-6 border border-slate-100 group-hover:border-indigo-200 transition-colors">
                        <img src="{{ $rel->gambar_utama_url }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <h3 class="font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $rel->nama }}</h3>
                    <p class="text-sm font-black text-slate-900 mt-1">{{ $rel->harga_rupiah }}</p>
                </a>
                @endforeach
            </div>
        </div>

    </div>
</div>
