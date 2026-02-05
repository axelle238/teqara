<div class="bg-slate-50 min-h-screen pb-20">
    
    <!-- Breadcrumb & Header -->
    <div class="bg-white border-b border-slate-200 sticky top-20 z-40 shadow-sm backdrop-blur-md bg-white/90">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 uppercase tracking-widest">
                <a href="/katalog" class="hover:text-cyan-600 transition">Katalog</a>
                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="/katalog?kategori={{ $produk->kategori->slug }}" class="hover:text-cyan-600 transition">{{ $produk->kategori->nama }}</a>
                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-slate-900 line-clamp-1">{{ $produk->nama }}</span>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">
            
            <!-- Kolom Kiri: Galeri Media -->
            <div class="space-y-6">
                <div class="relative aspect-square rounded-[40px] overflow-hidden bg-white shadow-xl shadow-slate-200 border border-slate-100 group">
                    <img src="{{ $gambarAktif }}" class="w-full h-full object-contain p-8 transform transition-transform duration-700 group-hover:scale-105">
                    
                    @if($produk->stok < 5 && $produk->stok > 0)
                        <div class="absolute top-6 left-6 px-4 py-2 bg-red-500 text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-lg shadow-red-500/30">
                            Stok Menipis
                        </div>
                    @elseif($produk->stok == 0)
                        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center">
                            <span class="px-6 py-3 bg-white text-slate-900 text-sm font-black uppercase tracking-widest rounded-2xl shadow-2xl">
                                Stok Habis
                            </span>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-4 gap-4">
                    <button wire:click="gantiGambar('{{ $produk->gambar_utama_url }}')" class="aspect-square rounded-2xl bg-white border-2 {{ $gambarAktif == $produk->gambar_utama_url ? 'border-cyan-500 shadow-lg shadow-cyan-500/20' : 'border-slate-100 hover:border-slate-300' }} p-2 transition-all">
                        <img src="{{ $produk->gambar_utama_url }}" class="w-full h-full object-contain">
                    </button>
                    @foreach($produk->gambar as $g)
                    <button wire:click="gantiGambar('{{ $g->url }}')" class="aspect-square rounded-2xl bg-white border-2 {{ $gambarAktif == $g->url ? 'border-cyan-500 shadow-lg shadow-cyan-500/20' : 'border-slate-100 hover:border-slate-300' }} p-2 transition-all">
                        <img src="{{ $g->url }}" class="w-full h-full object-contain">
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Kolom Kanan: Info & Aksi -->
            <div class="flex flex-col">
                <div class="mb-8">
                    <h1 class="text-3xl sm:text-4xl font-black text-slate-900 leading-tight mb-4 tracking-tight">{{ $produk->nama }}</h1>
                    
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center gap-1">
                            <div class="flex text-yellow-400">
                                @for($i=0; $i<5; $i++)
                                    <svg class="w-5 h-5 {{ $i < round($produk->rating_rata_rata) ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                            <span class="text-sm font-bold text-slate-500 ml-2">({{ $produk->ulasan->count() }} Ulasan)</span>
                        </div>
                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                        <span class="text-sm font-bold text-cyan-600 uppercase tracking-wider">Tersedia {{ $stokAktif }} Unit</span>
                    </div>

                    <div class="text-4xl font-black text-slate-900 tracking-tighter mb-2">
                        {{ 'Rp ' . number_format($hargaAktif, 0, ',', '.') }}
                    </div>
                    @if($produk->harga_modal > 0 && $hargaAktif < ($produk->harga_modal * 1.2))
                        <p class="text-sm font-bold text-emerald-600 bg-emerald-50 inline-block px-3 py-1 rounded-lg">Harga Terbaik Minggu Ini</p>
                    @endif
                </div>

                <div class="h-px bg-slate-100 mb-8"></div>

                <!-- Pilihan Varian -->
                @if($produk->memiliki_varian)
                <div class="mb-8 space-y-4">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Pilih Model</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach($produk->varian as $v)
                        <button 
                            wire:click="pilihVarian({{ $v->id }})"
                            class="px-6 py-3 rounded-xl text-sm font-bold border-2 transition-all {{ $varianTerpilihId == $v->id ? 'border-cyan-600 bg-cyan-50 text-cyan-700 shadow-md' : 'border-slate-200 text-slate-600 hover:border-slate-300' }}"
                        >
                            {{ $v->nama }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Kontrol Jumlah & Beli -->
                <div class="flex flex-col sm:flex-row gap-4 mt-auto">
                    <div class="flex items-center bg-slate-100 rounded-2xl p-1 w-fit">
                        <button wire:click="kurangJumlah" class="w-12 h-12 flex items-center justify-center bg-white rounded-xl shadow-sm text-slate-600 hover:text-red-500 font-bold text-lg transition disabled:opacity-50">-</button>
                        <input type="text" readonly class="w-16 bg-transparent border-none text-center font-black text-slate-900" value="{{ $jumlah }}">
                        <button wire:click="tambahJumlah" class="w-12 h-12 flex items-center justify-center bg-white rounded-xl shadow-sm text-slate-600 hover:text-emerald-500 font-bold text-lg transition disabled:opacity-50">+</button>
                    </div>
                    <button 
                        wire:click="tambahKeKeranjang" 
                        class="flex-1 bg-slate-900 text-white py-4 px-8 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-slate-800 transition shadow-xl shadow-slate-900/20 flex items-center justify-center gap-3 group"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Tambah Keranjang</span>
                        <span wire:loading>Memproses...</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </button>
                    <button class="aspect-square bg-white border-2 border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-red-500 hover:border-red-200 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Tab Navigasi Detail (Alpine.js) -->
        <div x-data="{ tab: 'deskripsi' }" class="mt-24">
            <div class="flex justify-center border-b border-slate-200 mb-12">
                <nav class="flex gap-8 -mb-px">
                    <button @click="tab = 'deskripsi'" :class="tab === 'deskripsi' ? 'border-cyan-600 text-cyan-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'" class="pb-4 px-2 border-b-4 font-black text-sm uppercase tracking-widest transition-all">Deskripsi</button>
                    <button @click="tab = 'spesifikasi'" :class="tab === 'spesifikasi' ? 'border-cyan-600 text-cyan-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'" class="pb-4 px-2 border-b-4 font-black text-sm uppercase tracking-widest transition-all">Spesifikasi Teknis</button>
                    <button @click="tab = 'ulasan'" :class="tab === 'ulasan' ? 'border-cyan-600 text-cyan-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'" class="pb-4 px-2 border-b-4 font-black text-sm uppercase tracking-widest transition-all">Ulasan Pengguna</button>
                </nav>
            </div>

            <!-- Konten Tab -->
            <div class="max-w-4xl mx-auto">
                <!-- Deskripsi -->
                <div x-show="tab === 'deskripsi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="prose prose-slate prose-lg max-w-none text-slate-600 leading-relaxed">
                        {!! $produk->deskripsi_lengkap !!}
                    </div>
                </div>

                <!-- Spesifikasi -->
                <div x-show="tab === 'spesifikasi'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                        <table class="w-full">
                            <tbody class="divide-y divide-slate-100">
                                @foreach($produk->spesifikasi as $spek)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-8 py-5 text-sm font-bold text-slate-500 w-1/3 bg-slate-50">{{ $spek->nama }}</td>
                                    <td class="px-8 py-5 text-sm font-bold text-slate-900">{{ $spek->nilai }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($produk->spesifikasi->count() == 0)
                            <div class="p-12 text-center text-slate-400 font-medium">Belum ada data spesifikasi teknis.</div>
                        @endif
                    </div>
                </div>

                <!-- Ulasan -->
                <div x-show="tab === 'ulasan'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="space-y-8">
                        @forelse($produk->ulasan as $ulasan)
                        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500">{{ substr($ulasan->pengguna->nama, 0, 1) }}</div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $ulasan->pengguna->nama }}</p>
                                        <div class="flex text-yellow-400 text-xs">
                                            @for($i=0; $i<$ulasan->rating; $i++) <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg> @endfor
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-slate-400">{{ $ulasan->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-slate-600 leading-relaxed">{{ $ulasan->komentar }}</p>
                        </div>
                        @empty
                        <div class="text-center py-12 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                            <p class="text-slate-500 font-bold mb-4">Belum ada ulasan untuk produk ini.</p>
                            <button class="px-6 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold hover:border-cyan-500 hover:text-cyan-600 transition">Jadilah yang pertama</button>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
