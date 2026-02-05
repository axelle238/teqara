<div class="bg-slate-50 min-h-screen py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-slate-900 mb-8">Checkout Pesanan</h1>

        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
            <!-- Form Pengiriman -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="h-6 w-6 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Informasi Pengiriman
                    </h2>

                    <form wire:submit.prevent="buatPesanan" class="space-y-6">
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

                        <div class="pt-6 border-t border-slate-100">
                            <p class="text-xs text-slate-500 mb-4 italic">
                                * Dengan mengeklik tombol di bawah, Anda setuju dengan syarat dan ketentuan pembelian di Teqara.
                            </p>
                            <button type="submit" class="w-full flex items-center justify-center rounded-xl bg-cyan-600 px-6 py-4 text-lg font-bold text-white shadow-xl shadow-cyan-900/20 hover:bg-cyan-700 transition">
                                Konfirmasi & Bayar Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="mt-12 lg:mt-0 lg:col-span-5">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 bg-slate-50 border-b border-slate-200">
                        <h2 class="text-lg font-bold text-slate-900">Ringkasan Pesanan</h2>
                    </div>
                    <ul class="divide-y divide-slate-100 px-6">
                        @foreach($this->items as $item)
                        <li class="flex py-4">
                            <img src="{{ $item->produk->gambar_utama }}" class="h-16 w-16 rounded-lg object-cover border border-slate-100">
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
                    <div class="p-6 bg-slate-50 space-y-3">
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>Subtotal Produk</span>
                            <span class="font-medium text-slate-900">{{ 'Rp ' . number_format($this->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>Biaya Layanan</span>
                            <span class="font-medium text-emerald-600">GRATIS</span>
                        </div>
                        <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
                            <span class="text-base font-bold text-slate-900">Total Pembayaran</span>
                            <span class="text-xl font-extrabold text-cyan-600">{{ 'Rp ' . number_format($this->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
