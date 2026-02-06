<div class="bg-slate-50 min-h-screen py-12">
    <div class="container mx-auto px-6">
        
        <div class="flex items-center gap-4 mb-8">
            <a href="/" class="text-xs font-bold text-slate-400 hover:text-indigo-600 transition-colors uppercase tracking-widest">Beranda</a>
            <span class="text-slate-300">/</span>
            <span class="text-xs font-black text-slate-900 uppercase tracking-widest">Checkout Aman</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Kolom Kiri: Form -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Langkah 1: Pengiriman -->
                <div class="bg-white rounded-[32px] p-8 border border-slate-100 shadow-sm relative overflow-hidden">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center font-black text-lg shadow-lg">1</div>
                        <h2 class="text-lg font-black text-slate-900 uppercase tracking-widest">Informasi Pengiriman</h2>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Alamat Lengkap</label>
                            <textarea wire:model="alamat_pengiriman" rows="4" class="w-full rounded-2xl border-slate-200 focus:ring-indigo-500 p-4 text-sm font-medium" placeholder="Nama Jalan, Nomor Rumah, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos..."></textarea>
                            @error('alamat_pengiriman') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="p-4 bg-indigo-50 rounded-2xl border border-indigo-100 flex gap-4 items-start">
                            <div class="w-8 h-8 rounded-full bg-white text-indigo-600 flex items-center justify-center shrink-0 shadow-sm mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="text-xs text-indigo-800 leading-relaxed">
                                <span class="font-black block mb-1 uppercase tracking-widest">Jaminan Pengiriman</span>
                                Pastikan alamat Anda benar. Kami menggunakan layanan logistik prioritas untuk memastikan barang sampai dengan aman.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Langkah 2: Pembayaran -->
                <div class="bg-white rounded-[32px] p-8 border border-slate-100 shadow-sm opacity-50 cursor-not-allowed">
                    <div class="flex items-center gap-4 mb-2">
                        <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-black text-lg">2</div>
                        <h2 class="text-lg font-black text-slate-400 uppercase tracking-widest">Pembayaran</h2>
                    </div>
                    <p class="text-xs text-slate-400 ml-14">Langkah ini akan tersedia setelah pesanan dibuat.</p>
                </div>

            </div>

            <!-- Kolom Kanan: Ringkasan (Sticky) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[32px] p-8 border border-slate-100 shadow-xl sticky top-24">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-4 mb-6 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                        @foreach($this->items as $item)
                        <div class="flex gap-4">
                            <div class="w-16 h-16 bg-slate-50 rounded-xl shrink-0 overflow-hidden border border-slate-100">
                                <img src="{{ $item->produk->gambar_utama_url }}" class="w-full h-full object-contain">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-slate-900 truncate">{{ $item->produk->nama }}</p>
                                <p class="text-xs text-slate-500">{{ $item->jumlah }} x Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm font-black text-slate-900">Rp {{ number_format($item->produk->harga_jual * $item->jumlah, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>

                    <!-- Voucher Input -->
                    <div class="py-6 border-y border-slate-100 space-y-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase">Kode Promo</label>
                        <div class="flex gap-2">
                            <input wire:model="kodeVoucherInput" type="text" placeholder="Masukkan Kode" class="w-full rounded-xl border-slate-200 text-sm font-bold uppercase placeholder:normal-case focus:ring-indigo-500">
                            <button wire:click="terapkanVoucher" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-700 transition">Pakai</button>
                        </div>
                        @error('kodeVoucherInput') <span class="text-rose-500 text-xs font-bold block">{{ $message }}</span> @enderror

                        @if($voucherTerpakai)
                        <div class="flex justify-between items-center bg-emerald-50 px-4 py-3 rounded-xl border border-emerald-100">
                            <div>
                                <p class="text-xs font-black text-emerald-700 uppercase tracking-widest">{{ $voucherTerpakai->kode }}</p>
                                <p class="text-[10px] text-emerald-600 font-bold">Diskon diterapkan</p>
                            </div>
                            <button wire:click="hapusVoucher" class="text-emerald-400 hover:text-emerald-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        @endif
                    </div>

                    <!-- Totals -->
                    <div class="py-6 space-y-2">
                        <div class="flex justify-between text-sm text-slate-500">
                            <span>Subtotal</span>
                            <span class="font-bold text-slate-700">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if($nilaiPotongan > 0)
                        <div class="flex justify-between text-sm text-emerald-600">
                            <span>Diskon</span>
                            <span class="font-bold">- Rp {{ number_format($nilaiPotongan, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-lg font-black text-slate-900 pt-2 border-t border-slate-100 mt-2">
                            <span>Total</span>
                            <span>Rp {{ number_format($this->totalBayar, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button wire:click="buatPesanan" class="w-full py-4 bg-indigo-600 text-white rounded-[20px] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-600/30 hover:scale-[1.02] active:scale-95 transition-all">
                        BUAT PESANAN SEKARANG
                    </button>
                    
                    <p class="text-[10px] text-slate-400 text-center mt-4 font-medium">
                        Dengan melanjutkan, Anda menyetujui <a href="#" class="underline hover:text-slate-600">Syarat & Ketentuan</a> kami.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>