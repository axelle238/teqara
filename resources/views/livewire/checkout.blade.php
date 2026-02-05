<div class="bg-white min-h-screen py-20 relative overflow-hidden">
    
    <!-- Decorative Tech Orbit -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-500/5 blur-[120px] rounded-full -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 shadow-sm mb-4">
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em]">Tahap Finalisasi</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">EKSEKUSI <span class="text-indigo-600">CHECKOUT</span></h1>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-x-16 lg:items-start">
            <!-- Delivery & Payment: Vibrant Cards -->
            <div class="lg:col-span-7 space-y-10">
                <!-- Shipping Info -->
                <div class="bg-white rounded-[48px] shadow-2xl shadow-indigo-500/5 border border-indigo-50 p-10 group hover:border-indigo-200 transition-all duration-500">
                    <h2 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-4 uppercase tracking-tighter">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        Informasi Pengiriman
                    </h2>

                    <div class="space-y-8">
                        <div class="space-y-2">
                            <label for="alamat" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-1">Alamat Destinasi Lengkap</label>
                            <textarea 
                                wire:model="alamat_pengiriman" 
                                id="alamat" 
                                rows="4" 
                                class="block w-full rounded-[24px] border-none bg-indigo-50/50 p-6 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 placeholder:text-slate-300 transition-all"
                                placeholder="Jalan, Nomor Rumah, RT/RW, Kecamatan, Kota, Kode Pos..."
                            ></textarea>
                            @error('alamat_pengiriman') <span class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-2 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="catatan" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-1">Catatan Khusus (Opsional)</label>
                            <input 
                                wire:model="catatan" 
                                type="text" 
                                id="catatan" 
                                class="block w-full rounded-[24px] border-none bg-indigo-50/50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 placeholder:text-slate-300 transition-all"
                                placeholder="Contoh: Titip di front desk, warna unit, dll..."
                            >
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="bg-white rounded-[48px] shadow-2xl shadow-indigo-500/5 border border-indigo-50 p-10">
                    <h2 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-4 uppercase tracking-tighter">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        Otoritas Pembayaran
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="group relative p-6 rounded-[28px] border-2 cursor-pointer transition-all duration-300 border-indigo-600 bg-indigo-50 shadow-xl shadow-indigo-500/10">
                            <input type="radio" name="payment" checked class="sr-only">
                            <div class="flex items-center gap-4">
                                <div class="w-8 h-8 rounded-full bg-white border-4 border-indigo-600 flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 bg-indigo-600 rounded-full"></div>
                                </div>
                                <span class="font-black text-slate-900 text-sm uppercase tracking-tight">Transfer Manual</span>
                            </div>
                        </label>
                        
                        <label class="group relative p-6 rounded-[28px] border-2 border-slate-50 bg-slate-50/50 opacity-60 cursor-not-allowed">
                            <input type="radio" name="payment" disabled class="sr-only">
                            <div class="flex items-center gap-4">
                                <div class="w-8 h-8 rounded-full bg-white border-2 border-slate-200"></div>
                                <span class="font-black text-slate-400 text-sm uppercase tracking-tight">E-Wallet (Segera)</span>
                            </div>
                        </label>
                    </div>

                    <div class="mt-8 p-6 bg-blue-50/50 rounded-3xl border border-blue-100 flex gap-4 items-start">
                        <span class="text-xl">ℹ️</span>
                        <p class="text-[10px] font-bold text-blue-600 leading-relaxed uppercase tracking-widest">Instruksi verifikasi dan detail rekening akan ditampilkan secara otomatis setelah konfirmasi pesanan diproses oleh sistem.</p>
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="mt-16 lg:mt-0 lg:col-span-5 sticky top-32">
                <div class="bg-white rounded-[56px] shadow-2xl shadow-indigo-500/10 border-2 border-indigo-50 overflow-hidden">
                    <div class="p-10 border-b border-indigo-50 flex items-center justify-between">
                        <h2 class="text-xl font-black text-slate-900 uppercase tracking-tighter">DAFTAR MANIFEST</h2>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-600 text-[10px] font-black rounded-lg">{{ $this->items->count() }} UNIT</span>
                    </div>
                    
                    <!-- Item Scroll Area -->
                    <div class="px-10 py-6 max-h-80 overflow-y-auto custom-scrollbar space-y-6 bg-slate-50/30">
                        @foreach($this->items as $item)
                        <div class="flex items-center gap-6 group">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden bg-white border border-indigo-50 flex-shrink-0 p-2 group-hover:scale-110 transition-transform">
                                <img src="{{ $item->produk->gambar_utama_url }}" class="w-full h-full object-contain">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-black text-slate-900 truncate uppercase tracking-tight">{{ $item->produk->nama }}</h4>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $item->jumlah }} Unit x Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm font-black text-slate-900">Rp {{ number_format($item->produk->harga_jual * $item->jumlah, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>

                    <!-- Voucher Activation -->
                    <div class="px-10 py-8 bg-indigo-50/30 border-t border-indigo-50">
                        <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-4">AKTIVASI VOUCHER</label>
                        <div class="flex gap-3">
                            <input wire:model="kodeVoucherInput" type="text" class="flex-1 rounded-2xl border-none bg-white px-6 py-3 text-sm uppercase font-black text-indigo-600 focus:ring-2 focus:ring-indigo-500 placeholder:text-slate-200" placeholder="KODE PROMO">
                            <button wire:click="terapkanVoucher" class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg">GUNAKAN</button>
                        </div>
                        @error('kodeVoucherInput') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest mt-2 block">{{ $message }}</span> @enderror
                        
                        @if($voucherTerpakai)
                        <div class="mt-4 flex items-center justify-between bg-emerald-500 text-white p-4 rounded-2xl shadow-xl shadow-emerald-500/20">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-xs font-black uppercase tracking-widest">{{ $voucherTerpakai->kode }} AKTIF</span>
                            </div>
                            <button wire:click="hapusVoucher" class="text-[10px] font-black uppercase tracking-widest bg-white/20 hover:bg-white/30 px-3 py-1 rounded-lg">Hapus</button>
                        </div>
                        @endif
                    </div>

                    <!-- Calculation View -->
                    <div class="p-10 space-y-4 bg-white border-t border-indigo-50">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase tracking-widest">
                            <span>Subtotal Unit</span>
                            <span class="text-slate-900">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        @if($nilaiPotongan > 0)
                        <div class="flex items-center justify-between text-xs font-black text-emerald-600 uppercase tracking-widest">
                            <span>Potongan Voucher</span>
                            <span>- Rp {{ number_format($nilaiPotongan, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase tracking-widest">
                            <span>Biaya Pengiriman</span>
                            <span class="text-emerald-600 font-black">BEBAS BIAYA</span>
                        </div>
                        
                        <div class="pt-8 mt-4 border-t-2 border-indigo-50 flex flex-col gap-6">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-black text-slate-900 uppercase tracking-widest">TOTAL TAGIHAN</span>
                                <span class="text-3xl font-black text-indigo-600 tracking-tighter leading-none">Rp {{ number_format($this->totalBayar, 0, ',', '.') }}</span>
                            </div>

                            <button 
                                wire:click="buatPesanan" 
                                class="w-full flex items-center justify-center gap-4 py-6 bg-gradient-to-r from-indigo-600 to-cyan-600 text-white rounded-[32px] text-sm font-black uppercase tracking-[0.2em] shadow-2xl shadow-indigo-500/30 hover:scale-[1.02] active:scale-95 transition-all group"
                            >
                                KONFIRMASI PEMESANAN
                                <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
