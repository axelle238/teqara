<div class="bg-slate-50 min-h-screen py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-slate-900 mb-8">Checkout Pesanan</h1>

        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
            <!-- Form Pengiriman -->
            <div class="lg:col-span-7 space-y-8">
                <!-- Alamat -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="h-6 w-6 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Informasi Pengiriman
                    </h2>

                    <div class="space-y-6">
                        <div>
                            <label for="alamat" class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap Pengiriman</label>
                            <textarea 
                                wire:model="alamat_pengiriman" 
                                id="alamat" 
                                rows="4" 
                                class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm"
                                placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, Kecamatan, Kota, dan Kode Pos..."
                            ></textarea>
                            @error('alamat_pengiriman') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="catatan" class="block text-sm font-bold text-slate-700 mb-2">Catatan Pesanan (Opsional)</label>
                            <input 
                                wire:model="catatan" 
                                type="text" 
                                id="catatan" 
                                class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm"
                                placeholder="Contoh: Titip di satpam, warna hitam, dll..."
                            >
                        </div>
                    </div>
                </div>

                <!-- Metode Pembayaran (Placeholder Visual) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="h-6 w-6 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Metode Pembayaran
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="border p-4 rounded-xl flex items-center cursor-pointer hover:border-cyan-500 hover:bg-cyan-50 transition border-cyan-500 bg-cyan-50">
                            <input type="radio" name="payment" checked class="text-cyan-600 focus:ring-cyan-500">
                            <span class="ml-3 font-bold text-slate-700">Transfer Bank Manual</span>
                        </label>
                        <label class="border p-4 rounded-xl flex items-center cursor-not-allowed opacity-50 bg-slate-50">
                            <input type="radio" name="payment" disabled class="text-slate-400">
                            <span class="ml-3 font-bold text-slate-500">E-Wallet (Segera)</span>
                        </label>
                    </div>
                    <p class="mt-4 text-xs text-slate-500 bg-blue-50 p-3 rounded-lg border border-blue-100">
                        ℹ️ Instruksi pembayaran akan ditampilkan setelah pesanan dibuat.
                    </p>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="mt-12 lg:mt-0 lg:col-span-5">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                    <div class="p-6 bg-slate-50 border-b border-slate-200">
                        <h2 class="text-lg font-bold text-slate-900">Ringkasan Pesanan</h2>
                    </div>
                    
                    <!-- Item List -->
                    <ul class="divide-y divide-slate-100 px-6 max-h-80 overflow-y-auto custom-scrollbar">
                        @foreach($this->items as $item)
                        <li class="flex py-4">
                            <img src="{{ $item->produk->gambar_utama_url }}" class="h-14 w-14 rounded-lg object-cover border border-slate-100 bg-slate-50">
                            <div class="ml-4 flex-1 flex flex-col justify-center">
                                <h4 class="text-sm font-bold text-slate-900">{{ $item->produk->nama }}</h4>
                                <p class="text-xs text-slate-500">{{ $item->jumlah }} x {{ 'Rp ' . number_format($item->produk->harga_jual, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex items-center">
                                <p class="text-sm font-bold text-slate-900">{{ 'Rp ' . number_format($item->produk->harga_jual * $item->jumlah, 0, ',', '.') }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <!-- Voucher Section -->
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Punya Kode Voucher?</label>
                        <div class="flex gap-2">
                            <input wire:model="kodeVoucherInput" type="text" class="flex-1 rounded-lg border-slate-200 text-sm uppercase font-bold focus:ring-cyan-500 focus:border-cyan-500" placeholder="Masukkan Kode">
                            <button wire:click="terapkanVoucher" class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-slate-800 transition">Pakai</button>
                        </div>
                        @error('kodeVoucherInput') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        
                        @if($voucherTerpakai)
                        <div class="mt-3 flex items-center justify-between bg-emerald-50 border border-emerald-100 p-2 rounded-lg">
                            <span class="text-xs font-bold text-emerald-700 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $voucherTerpakai->kode }} Diterapkan
                            </span>
                            <button wire:click="hapusVoucher" class="text-xs text-red-500 hover:text-red-700 font-bold">Hapus</button>
                        </div>
                        @endif
                    </div>

                    <!-- Kalkulasi Harga -->
                    <div class="p-6 bg-slate-50 space-y-3 border-t border-slate-200">
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>Subtotal Produk</span>
                            <span class="font-medium text-slate-900">{{ 'Rp ' . number_format($this->subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        @if($nilaiPotongan > 0)
                        <div class="flex items-center justify-between text-sm text-emerald-600">
                            <span>Diskon Voucher</span>
                            <span class="font-bold">- {{ 'Rp ' . number_format($nilaiPotongan, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>Biaya Pengiriman</span>
                            <span class="font-medium text-emerald-600">GRATIS (Promo)</span>
                        </div>
                        
                        <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                            <span class="text-base font-bold text-slate-900">Total Pembayaran</span>
                            <span class="text-2xl font-black text-cyan-600">{{ 'Rp ' . number_format($this->totalBayar, 0, ',', '.') }}</span>
                        </div>

                        <button wire:click="buatPesanan" class="w-full flex items-center justify-center rounded-xl bg-cyan-600 px-6 py-4 text-lg font-bold text-white shadow-xl shadow-cyan-900/20 hover:bg-cyan-700 transition transform active:scale-95 mt-4">
                            Konfirmasi Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>