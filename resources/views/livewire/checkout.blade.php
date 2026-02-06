<div class="bg-slate-50 min-h-screen py-20 relative overflow-hidden">
    <!-- Background Accents -->
    <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-indigo-500/5 blur-[150px] rounded-full -translate-y-1/2 translate-x-1/3"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-cyan-500/5 blur-[120px] rounded-full translate-y-1/2 -translate-x-1/4"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div class="space-y-4">
                <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">
                    <a href="/keranjang" class="hover:text-indigo-600 transition-colors">Keranjang</a>
                    <span>/</span>
                    <span class="text-indigo-600">Finalisasi Pesanan</span>
                </nav>
                <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Otorisasi <span class="text-indigo-600">Transaksi</span></h1>
            </div>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-x-16 lg:items-start">
            
            <!-- Konfigurasi Pesanan -->
            <div class="lg:col-span-8 space-y-10">
                
                <!-- Section 1: Alamat Distribusi -->
                <div class="bg-white rounded-[48px] p-10 shadow-sm border border-slate-100">
                    <div class="flex items-center gap-6 mb-10">
                        <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-xl shadow-xl shadow-slate-900/20">01</div>
                        <div>
                            <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">ALAMAT DISTRIBUSI</h2>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Tujuan Pengiriman Unit Teknologi</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                        @foreach($this->daftarAlamat as $alamat)
                        <button 
                            wire:click="pilihAlamat({{ $alamat->id }})"
                            class="relative text-left p-6 rounded-[32px] border-2 transition-all duration-300 {{ $alamatTerpilihId === $alamat->id ? 'border-indigo-600 bg-indigo-50/50 shadow-xl shadow-indigo-500/10' : 'border-slate-50 bg-slate-50 hover:border-slate-200' }}"
                        >
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-3 py-1 bg-white rounded-lg text-[9px] font-black uppercase tracking-widest text-slate-900 border border-slate-100">{{ $alamat->label_alamat }}</span>
                                @if($alamatTerpilihId === $alamat->id)
                                    <div class="w-5 h-5 bg-indigo-600 rounded-full flex items-center justify-center text-white">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <p class="text-sm font-black text-slate-900 mb-1">{{ $alamat->penerima }}</p>
                            <p class="text-[11px] font-bold text-slate-500 mb-4">{{ $alamat->telepon }}</p>
                            <p class="text-[11px] text-slate-600 leading-relaxed line-clamp-2 font-medium">{{ $alamat->alamat_lengkap }}, {{ $alamat->kota }}</p>
                        </button>
                        @endforeach
                        
                        <button 
                            wire:click="$toggle('alamat_baru')"
                            class="flex flex-col items-center justify-center p-6 rounded-[32px] border-2 border-dashed border-slate-200 hover:border-indigo-400 hover:bg-indigo-50 transition-all group"
                        >
                            <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] group-hover:text-indigo-600">Gunakan Alamat Lain</span>
                        </button>
                    </div>

                    @if($alamat_baru || !$alamatTerpilihId)
                    <div class="animate-in fade-in slide-in-from-top-4 duration-500">
                        <textarea 
                            wire:model="alamat_pengiriman" 
                            rows="4" 
                            class="w-full rounded-[32px] border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 p-8 text-sm font-medium placeholder:text-slate-300" 
                            placeholder="Masukkan detail alamat pengiriman secara manual di sini..."
                        ></textarea>
                        @error('alamat_pengiriman') <span class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-3 block px-4">{{ $message }}</span> @enderror
                    </div>
                    @endif
                </div>

                <!-- Section 2: Logistik Pengiriman -->
                <div class="bg-white rounded-[48px] p-10 shadow-sm border border-slate-100">
                    <div class="flex items-center gap-6 mb-10">
                        <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-xl shadow-xl shadow-slate-900/20">02</div>
                        <div>
                            <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">LOGISTIK PRIORITAS</h2>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Pilih Kecepatan Penyerahan Unit</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        @php
                            $opsiPengiriman = [
                                'standar' => ['label' => 'Standar', 'harga' => 15000, 'estimasi' => '3-5 Hari Kerja', 'icon' => '🚚'],
                                'ekspres' => ['label' => 'Ekspres', 'harga' => 35000, 'estimasi' => '1-2 Hari Kerja', 'icon' => '⚡'],
                                'prioritas' => ['label' => 'Prioritas', 'harga' => 75000, 'estimasi' => 'Besok Sampai', 'icon' => '💎'],
                            ];
                        @endphp

                        @foreach($opsiPengiriman as $key => $opsi)
                        <button 
                            wire:click="setMetodePengiriman('{{ $key }}')"
                            class="relative flex flex-col items-center text-center p-8 rounded-[40px] border-2 transition-all duration-500 {{ $metodePengiriman === $key ? 'border-indigo-600 bg-indigo-600 text-white shadow-2xl shadow-indigo-600/30 -translate-y-2' : 'border-slate-50 bg-slate-50 hover:border-slate-200 text-slate-600' }}"
                        >
                            <span class="text-3xl mb-4">{{ $opsi['icon'] }}</span>
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] {{ $metodePengiriman === $key ? 'text-white/70' : 'text-slate-400' }} mb-1">{{ $opsi['label'] }}</span>
                            <span class="text-sm font-black mb-4 uppercase">{{ $opsi['estimasi'] }}</span>
                            <span class="text-xs font-black {{ $metodePengiriman === $key ? 'text-white' : 'text-indigo-600' }}">Rp {{ number_format($opsi['harga'], 0, ',', '.') }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Section 3: Loyalitas & Voucher -->
                <div class="bg-white rounded-[48px] p-10 shadow-sm border border-slate-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-emerald-500/5 rounded-full blur-[60px] translate-x-1/2 -translate-y-1/2"></div>
                    
                    <div class="flex items-center gap-6 mb-10">
                        <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-xl shadow-xl shadow-slate-900/20">03</div>
                        <div>
                            <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">POIN & VOUCHER</h2>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Otorisasi Diskon Pelanggan</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <!-- Poin Loyalitas -->
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Saldo Poin Anda</span>
                                <span class="text-sm font-black text-slate-900">{{ number_format(auth()->user()->poin_loyalitas ?? 0) }} POIN</span>
                            </div>
                            
                            <label class="flex items-center justify-between p-6 rounded-[32px] bg-slate-50 border border-slate-100 cursor-pointer group transition-all hover:border-indigo-200">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-xl">🌟</div>
                                    <div>
                                        <p class="text-xs font-black text-slate-900 uppercase tracking-tight">Gunakan Poin</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase">Maks. 50% Potongan</p>
                                    </div>
                                </div>
                                <div class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model.live="gunakanPoin" wire:click="togglePoin" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </div>
                            </label>

                            @if($gunakanPoin && $nilaiPotonganPoin > 0)
                            <div class="animate-in zoom-in duration-300 flex items-center justify-between px-6 py-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Potongan Terapan</span>
                                <span class="text-sm font-black text-emerald-700">- Rp {{ number_format($nilaiPotonganPoin, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Voucher Code -->
                        <div class="space-y-6 border-l border-slate-50 pl-10">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Kode Promo Keamanan</span>
                            <div class="relative">
                                <input 
                                    wire:model="kodeVoucherInput" 
                                    type="text" 
                                    placeholder="MASUKKAN KODE" 
                                    class="w-full pl-6 pr-32 py-4 bg-slate-50 border-none rounded-2xl text-sm font-black uppercase placeholder:normal-case focus:ring-4 focus:ring-indigo-500/10 transition-all"
                                >
                                <button 
                                    wire:click="terapkanVoucher" 
                                    class="absolute right-2 top-2 bottom-2 px-6 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all"
                                >
                                    AKTIVASI
                                </button>
                            </div>
                            @error('kodeVoucherInput') <span class="text-rose-500 text-[10px] font-black uppercase tracking-widest block px-2">{{ $message }}</span> @enderror

                            @if($voucherTerpakai)
                            <div class="flex justify-between items-center bg-indigo-600 px-6 py-4 rounded-[24px] shadow-lg shadow-indigo-600/20 text-white animate-in slide-in-from-right-4">
                                <div>
                                    <p class="text-xs font-black uppercase tracking-widest">{{ $voucherTerpakai->kode }}</p>
                                    <p class="text-[9px] font-bold text-white/70 uppercase">Voucher Berhasil Aktif</p>
                                </div>
                                <button wire:click="hapusVoucher" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan & Konfirmasi (Sticky) -->
            <div class="mt-16 lg:mt-0 lg:col-span-4 sticky top-32">
                <div class="bg-white rounded-[56px] shadow-2xl shadow-indigo-500/10 border-4 border-white p-10 space-y-10">
                    
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tighter flex items-center gap-3">
                        <span class="w-8 h-1.5 bg-indigo-600 rounded-full"></span>
                        FINALISASI NILAI
                    </h3>

                    <!-- Mini Cart List -->
                    <div class="space-y-6 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($this->items as $item)
                        <div class="flex gap-4">
                            <div class="w-14 h-14 bg-slate-50 rounded-2xl shrink-0 p-2 flex items-center justify-center border border-slate-100">
                                <img src="{{ $item->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-black text-slate-900 truncate uppercase">{{ $item->produk->nama }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $item->jumlah }} UNIT X RP {{ number_format($item->produk->harga_jual, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- breakdown -->
                    <div class="space-y-4 pt-8 border-t border-slate-50">
                        <div class="flex justify-between text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                            <span>Total Unit</span>
                            <span class="text-slate-900">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                            <span>Logistik ({{ strtoupper($metodePengiriman) }})</span>
                            <span class="text-slate-900">Rp {{ number_format($this->biayaPengiriman, 0, ',', '.') }}</span>
                        </div>
                        @if($nilaiPotonganVoucher > 0)
                        <div class="flex justify-between text-[11px] font-black text-indigo-600 uppercase tracking-widest">
                            <span>Diskon Voucher</span>
                            <span>- Rp {{ number_format($nilaiPotonganVoucher, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        @if($nilaiPotonganPoin > 0)
                        <div class="flex justify-between text-[11px] font-black text-emerald-600 uppercase tracking-widest">
                            <span>Potongan Poin</span>
                            <span>- Rp {{ number_format($nilaiPotonganPoin, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        <div class="pt-6 border-t-2 border-dashed border-slate-100 flex flex-col gap-2">
                            <div class="flex justify-between items-end">
                                <span class="text-sm font-black text-slate-900 uppercase tracking-widest">TOTAL AKHIR</span>
                                <span class="text-3xl font-black text-indigo-600 tracking-tighter leading-none">Rp {{ number_format($this->totalBayar, 0, ',', '.') }}</span>
                            </div>
                            <p class="text-[9px] font-bold text-slate-400 text-right uppercase tracking-widest italic">Sudah termasuk PPN 11%</p>
                        </div>
                    </div>

                    <div class="pt-4 space-y-4">
                        <button 
                            wire:click="buatPesanan" 
                            wire:loading.attr="disabled"
                            class="w-full flex items-center justify-center gap-4 py-6 bg-gradient-to-r from-indigo-600 to-indigo-800 text-white rounded-[32px] text-sm font-black uppercase tracking-[0.2em] shadow-2xl shadow-indigo-600/30 hover:scale-[1.02] active:scale-95 transition-all group disabled:opacity-50"
                        >
                            <span wire:loading.remove>OTORISASI PESANAN</span>
                            <span wire:loading>PEMROSESAN SISTEM...</span>
                            <svg wire:loading.remove class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </button>
                        
                        <p class="text-[9px] text-slate-400 text-center font-bold uppercase tracking-widest leading-relaxed px-6">
                            Sistem akan mengunci unit stok & menghapus item keranjang setelah otorisasi berhasil.
                        </p>
                    </div>
                </div>

                <!-- Trust Badges -->
                <div class="mt-10 grid grid-cols-2 gap-4">
                    <div class="bg-white/50 backdrop-blur-sm p-4 rounded-3xl border border-white flex flex-col items-center text-center">
                        <span class="text-2xl mb-2">🔒</span>
                        <span class="text-[9px] font-black text-slate-900 uppercase tracking-widest">Sistem Enkripsi</span>
                    </div>
                    <div class="bg-white/50 backdrop-blur-sm p-4 rounded-3xl border border-white flex flex-col items-center text-center">
                        <span class="text-2xl mb-2">🛡️</span>
                        <span class="text-[9px] font-black text-slate-900 uppercase tracking-widest">Proteksi Unit</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>