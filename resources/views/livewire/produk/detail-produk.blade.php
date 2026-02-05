<div class="bg-white min-h-screen py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm font-medium text-slate-500">
            <a href="/" wire:navigate class="hover:text-cyan-600 transition">Beranda</a>
            <span class="mx-2">/</span>
            <a href="/katalog" wire:navigate class="hover:text-cyan-600 transition">Katalog</a>
            <span class="mx-2">/</span>
            <span class="text-slate-900 truncate max-w-xs">{{ $produk->nama }}</span>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
            
            <!-- Gallery (Kiri) - UPGRADED -->
            <div class="flex flex-col gap-4">
                <!-- Main Image -->
                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-2xl bg-slate-50 border border-slate-100 shadow-sm relative group">
                    <img src="{{ $gambarAktif }}" alt="{{ $produk->nama }}" class="h-full w-full object-contain object-center transform group-hover:scale-105 transition duration-500 p-8">
                    <div class="absolute top-4 right-4">
                        <button class="p-2 rounded-full bg-white shadow-md text-slate-400 hover:text-red-500 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                    </div>
                </div>
                
                <!-- Thumbnails -->
                @if($produk->gambar->count() > 1)
                <div class="grid grid-cols-4 gap-4">
                    @foreach($produk->gambar as $img)
                    <button wire:click="gantiGambar('{{ $img->url }}')" class="relative rounded-lg overflow-hidden border-2 {{ $gambarAktif === $img->url ? 'border-cyan-600 ring-2 ring-cyan-100' : 'border-slate-200 hover:border-slate-300' }} aspect-square">
                        <img src="{{ $img->url }}" class="h-full w-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info (Kanan) -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                
                <!-- Brand & Rating -->
                <div class="flex justify-between items-start mb-4">
                    <div>
                        @if($produk->merek)
                        <a href="#" class="text-sm font-bold text-cyan-600 uppercase tracking-wide hover:underline mb-1 block">
                            {{ $produk->merek->nama }}
                        </a>
                        @endif
                        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">{{ $produk->nama }}</h1>
                    </div>
                    @if($produk->rating_rata_rata > 0)
                    <div class="flex items-center bg-yellow-50 px-2 py-1 rounded-lg border border-yellow-100">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <span class="ml-1 text-sm font-bold text-slate-700">{{ $produk->rating_rata_rata }}</span>
                    </div>
                    @endif
                </div>

                <!-- Price -->
                <div class="mb-8">
                    <p class="text-4xl font-black text-slate-900 tracking-tight">
                        {{ 'Rp ' . number_format($hargaAktif, 0, ',', '.') }}
                    </p>
                    <p class="mt-2 text-sm text-slate-500">
                        @if($stokAktif > 0)
                            <span class="text-emerald-600 font-bold">● Stok Tersedia ({{ $stokAktif }})</span>
                        @else
                            <span class="text-red-600 font-bold">● Stok Habis</span>
                        @endif
                        <span class="mx-2 text-slate-300">|</span> SKU: {{ $produk->sku }}
                    </p>
                </div>

                <div class="border-t border-slate-200 py-6 space-y-6">
                    <!-- Varian Selector -->
                    @if($produk->memiliki_varian)
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 mb-3">Pilih Varian</h3>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($produk->varian as $var)
                            <button 
                                wire:click="pilihVarian({{ $var->id }})" 
                                class="flex items-center justify-between px-4 py-3 rounded-xl border text-left transition relative overflow-hidden {{ $varianTerpilihId === $var->id ? 'border-cyan-600 ring-1 ring-cyan-600 bg-cyan-50/50' : 'border-slate-200 hover:border-slate-300 bg-white' }} {{ $var->stok < 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                @if($var->stok < 1) disabled @endif
                            >
                                <div>
                                    <span class="block text-sm font-bold {{ $varianTerpilihId === $var->id ? 'text-cyan-900' : 'text-slate-900' }}">{{ $var->nama_varian }}</span>
                                    <span class="block text-xs text-slate-500">{{ $var->stok }} unit tersisa</span>
                                </div>
                                @if($var->harga_tambahan > 0)
                                    <span class="text-xs font-bold text-slate-900">+{{ number_format($var->harga_tambahan/1000) }}k</span>
                                @endif
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Quantity & Action -->
                    <div class="flex items-end gap-4">
                        <div class="w-32">
                            <label class="block text-xs font-bold text-slate-700 mb-2">Jumlah</label>
                            <div class="flex items-center border border-slate-300 rounded-xl bg-white">
                                <button wire:click="kurangJumlah" class="px-3 py-3 text-slate-600 hover:bg-slate-50 rounded-l-xl transition disabled:opacity-50" @if($jumlah <= 1) disabled @endif>-</button>
                                <input type="text" value="{{ $jumlah }}" class="w-full text-center border-none p-0 text-slate-900 font-bold focus:ring-0" readonly>
                                <button wire:click="tambahJumlah" class="px-3 py-3 text-slate-600 hover:bg-slate-50 rounded-r-xl transition disabled:opacity-50" @if($jumlah >= $stokAktif) disabled @endif>+</button>
                            </div>
                        </div>
                        <button 
                            wire:click="tambahKeKeranjang" 
                            class="flex-1 bg-slate-900 text-white py-3.5 px-6 rounded-xl font-bold text-lg hover:bg-slate-800 transition shadow-lg shadow-slate-900/20 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            @if($stokAktif < 1) disabled @endif
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            {{ $stokAktif < 1 ? 'Stok Habis' : 'Tambah Keranjang' }}
                        </button>
                    </div>
                </div>

                <!-- Spesifikasi & Deskripsi (Accordion Style) -->
                <div class="mt-8 space-y-4" x-data="{ activeTab: 'deskripsi' }">
                    <div class="flex border-b border-slate-200">
                        <button @click="activeTab = 'deskripsi'" :class="activeTab === 'deskripsi' ? 'border-cyan-600 text-cyan-600' : 'border-transparent text-slate-500 hover:text-slate-700'" class="pb-3 px-4 text-sm font-bold border-b-2 transition">Deskripsi</button>
                        <button @click="activeTab = 'spesifikasi'" :class="activeTab === 'spesifikasi' ? 'border-cyan-600 text-cyan-600' : 'border-transparent text-slate-500 hover:text-slate-700'" class="pb-3 px-4 text-sm font-bold border-b-2 transition">Spesifikasi</button>
                    </div>

                    <div x-show="activeTab === 'deskripsi'" x-transition class="prose prose-sm text-slate-600 max-w-none">
                        {!! $produk->deskripsi_lengkap !!}
                    </div>

                    <div x-show="activeTab === 'spesifikasi'" x-transition>
                        <dl class="divide-y divide-slate-100">
                            @foreach($produk->spesifikasi as $spek)
                            <div class="grid grid-cols-3 gap-4 py-3">
                                <dt class="text-sm font-medium text-slate-500">{{ $spek->judul }}</dt>
                                <dd class="text-sm font-bold text-slate-900 col-span-2">{{ $spek->nilai }}</dd>
                            </div>
                            @endforeach
                        </dl>
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="mt-12 pt-12 border-t border-slate-200">
                    <h3 class="text-xl font-black text-slate-900 mb-6">Ulasan Pelanggan</h3>
                    
                    @if($produk->ulasan->count() > 0)
                        <div class="space-y-6">
                            @foreach($produk->ulasan as $ulasan)
                            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-500">
                                            {{ substr($ulasan->pengguna->nama, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">{{ $ulasan->pengguna->nama }}</p>
                                            <div class="flex text-yellow-400">
                                                @for($i=0; $i<$ulasan->rating; $i++) <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg> @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs text-slate-400">{{ $ulasan->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-slate-600 leading-relaxed">{{ $ulasan->komentar }}</p>
                                
                                @if(!empty($ulasan->foto_ulasan))
                                <div class="flex gap-2 mt-4">
                                    @foreach($ulasan->foto_ulasan as $foto)
                                        <img src="{{ $foto }}" class="w-16 h-16 rounded-lg object-cover border border-slate-200">
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <p class="text-slate-500 text-sm font-bold">Belum ada ulasan untuk produk ini.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Slide Over Cart (Preview) - The "No Modal" Implementation -->
    <x-ui.slide-over id="keranjang-preview" title="Keranjang Belanja">
        <div class="text-center py-10">
            <div class="h-16 w-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Berhasil Ditambahkan!</h3>
            <p class="text-slate-500 mt-2 text-sm">{{ $produk->nama }} telah masuk ke keranjang Anda.</p>
            
            <div class="mt-8 space-y-3">
                <a href="/keranjang" class="block w-full py-3 bg-cyan-600 text-white rounded-xl font-bold hover:bg-cyan-700 transition">Lihat Keranjang</a>
                <button @click="show = false" class="block w-full py-3 bg-white border border-slate-300 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition">Lanjut Belanja</button>
            </div>
        </div>
    </x-ui.slide-over>
</div>