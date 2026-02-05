<div class="bg-white min-h-screen py-20 relative overflow-hidden">
    
    <!-- Decorative Glow -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-500/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 shadow-sm">
                    <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em]">Manajemen Belanja</span>
                </div>
                <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">KERANJANG <span class="text-indigo-600">SAYA</span></h1>
            </div>
            @if($this->items->count() > 0)
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">{{ $this->items->count() }} UNIT SIAP AKTIVASI</p>
            @endif
        </div>

        @if($this->items->count() > 0)
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-16 lg:items-start">
            <!-- Daftar Item: High-Tech Card List -->
            <div class="lg:col-span-8 space-y-6">
                @foreach($this->items as $item)
                <div class="group relative flex flex-col sm:flex-row gap-8 p-8 bg-white rounded-[40px] border border-indigo-50 shadow-sm hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500">
                    <div class="relative w-full sm:w-48 aspect-square rounded-[32px] overflow-hidden bg-slate-50 border border-slate-100 shrink-0 flex items-center justify-center p-6">
                        <img src="{{ $item->produk->gambar_utama_url }}" alt="{{ $item->produk->nama }}" class="w-full h-full object-contain transform group-hover:scale-110 transition-transform duration-700">
                    </div>

                    <div class="flex-1 flex flex-col justify-between py-2">
                        <div class="space-y-4">
                            <div class="flex justify-between items-start gap-4">
                                <div class="space-y-1">
                                    <span class="text-[9px] font-black text-indigo-400 uppercase tracking-widest">{{ $item->produk->kategori->nama }}</span>
                                    <h3 class="text-xl font-black text-slate-900 tracking-tight leading-snug">
                                        <a href="/produk/{{ $item->produk->slug }}" wire:navigate class="hover:text-indigo-600 transition-colors uppercase">
                                            {{ $item->produk->nama }}
                                        </a>
                                    </h3>
                                </div>
                                <button wire:click="hapusItem({{ $item->id }})" class="p-3 bg-rose-50 text-rose-400 hover:bg-rose-600 hover:text-white rounded-2xl transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            
                            <p class="text-2xl font-black text-slate-900 tracking-tighter">Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }}</p>
                        </div>

                        <div class="mt-8 flex flex-wrap items-center justify-between gap-6 pt-6 border-t border-indigo-50">
                            <div class="flex items-center bg-indigo-50/50 p-1.5 rounded-2xl border border-white shadow-inner">
                                <button wire:click="kurangJumlah({{ $item->id }})" class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm text-indigo-600 hover:bg-rose-50 hover:text-rose-600 transition-all font-black text-lg">-</button>
                                <span class="w-12 text-center font-black text-slate-900">{{ $item->jumlah }}</span>
                                <button wire:click="tambahJumlah({{ $item->id }})" class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm text-indigo-600 hover:bg-emerald-50 hover:text-emerald-600 transition-all font-black text-lg">+</button>
                            </div>

                            <div class="flex items-center gap-3">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Subtotal Akumulasi</p>
                                <p class="text-xl font-black text-indigo-600 tracking-tighter">Rp {{ number_format($item->produk->harga_jual * $item->jumlah, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Summary: Floating Glass Sidebar -->
            <div class="mt-16 lg:mt-0 lg:col-span-4 sticky top-32">
                <div class="bg-white rounded-[48px] shadow-2xl shadow-indigo-500/10 border-2 border-indigo-50 p-10 space-y-10 relative overflow-hidden">
                    <!-- Tech Decoration -->
                    <div class="absolute bottom-0 right-0 w-full h-1/3 bg-gradient-to-t from-indigo-500/5 to-transparent pointer-events-none"></div>

                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-tighter flex items-center gap-3 relative z-10">
                        <span class="w-8 h-1.5 bg-indigo-600 rounded-full"></span>
                        RINGKASAN AKTIVASI
                    </h2>
                    
                    <div class="relative z-10">
                        <dl class="space-y-6">
                            <div class="flex items-center justify-between">
                                <dt class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Nilai Unit</dt>
                                <dd class="text-sm font-black text-slate-900 tracking-tight">Rp {{ number_format($this->total_harga, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-xs font-bold text-slate-400 uppercase tracking-widest">Alokasi Distribusi</dt>
                                <dd class="text-[10px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-lg">Prioritas Utama</dd>
                            </div>
                            <div class="pt-6 border-t-2 border-dashed border-indigo-50 flex items-center justify-between">
                                <dt class="text-sm font-black text-slate-900 uppercase tracking-widest">Total Akhir</dt>
                                <dd class="text-2xl font-black text-indigo-600 tracking-tighter">Rp {{ number_format($this->total_harga, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="pt-4 relative z-10">
                        <a href="/checkout" wire:navigate class="w-full flex items-center justify-center gap-4 py-5 bg-gradient-to-r from-indigo-600 to-cyan-600 text-white rounded-3xl text-sm font-black uppercase tracking-[0.2em] shadow-2xl shadow-indigo-500/30 hover:scale-[1.02] active:scale-95 transition-all group">
                            EKSEKUSI CHECKOUT
                            <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <p class="mt-6 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-relaxed">
                            Konfigurasi pajak & diskon <br> akan diterapkan pada tahap final.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty State: Futuristic Visualization -->
        <div class="max-w-2xl mx-auto text-center py-32 px-10 bg-white rounded-[64px] border-4 border-dashed border-indigo-50">
            <div class="text-8xl mb-10 animate-bounce">🛒</div>
            <h3 class="text-3xl font-black text-slate-900 tracking-tighter uppercase mb-4">Radar Belanja Kosong</h3>
            <p class="text-slate-400 font-medium text-lg leading-relaxed mb-12">Unit yang Anda cari belum ditambahkan ke dalam antrian belanja sistem.</p>
            <a href="/katalog" wire:navigate class="inline-flex items-center gap-4 px-10 py-5 bg-indigo-600 text-white rounded-3xl font-black text-sm uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20">
                AKTIFKAN KATALOG
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </a>
        </div>
        @endif
    </div>
</div>