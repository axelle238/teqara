<div>
    <div class="mb-6">
        <a href="/admin/pesanan" wire:navigate class="text-sm font-medium text-cyan-600 hover:text-cyan-500">&larr; Kembali ke Daftar Pesanan</a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Kolom Kiri: Detail Produk -->
        <div class="space-y-6">
            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 bg-slate-50 border-b border-slate-200">
                    <h3 class="text-lg font-medium leading-6 text-slate-900">Rincian Item</h3>
                    <p class="mt-1 max-w-2xl text-sm text-slate-500">Daftar barang yang dibeli pelanggan.</p>
                </div>
                <ul class="divide-y divide-slate-200">
                    @foreach($pesanan->detailPesanan as $detail)
                    <li class="flex items-center px-4 py-4 sm:px-6">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-md object-cover" src="{{ $detail->produk->gambar_utama }}" alt="">
                        </div>
                        <div class="ml-4 flex-1">
                            <h4 class="text-sm font-bold text-slate-900">{{ $detail->produk->nama }}</h4>
                            <p class="text-sm text-slate-500">
                                {{ $detail->jumlah }} x {{ 'Rp ' . number_format($detail->harga_saat_ini, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="font-medium text-slate-900">
                            {{ 'Rp ' . number_format($detail->subtotal, 0, ',', '.') }}
                        </div>
                    </li>
                    @endforeach
                    <li class="px-4 py-4 sm:px-6 bg-slate-50 flex justify-between items-center border-t border-slate-200">
                        <span class="font-bold text-slate-900">Total Transaksi</span>
                        <span class="text-xl font-bold text-cyan-600">{{ 'Rp ' . number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 bg-slate-50 border-b border-slate-200">
                    <h3 class="text-lg font-medium leading-6 text-slate-900">Informasi Pelanggan</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-slate-500">Nama Pelanggan</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ $pesanan->pengguna->nama }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-slate-500">Email</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ $pesanan->pengguna->email }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-slate-500">Alamat Pengiriman</dt>
                            <dd class="mt-1 text-sm text-slate-900 whitespace-pre-line">{{ $pesanan->alamat_pengiriman }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Aksi & Status -->
        <div class="space-y-6">
            <div class="bg-white shadow sm:rounded-lg border-l-4 border-cyan-600">
                <div class="px-4 py-5 sm:px-6 bg-slate-50 border-b border-slate-200">
                    <h3 class="text-lg font-bold leading-6 text-slate-900">Kontrol Pesanan</h3>
                    <p class="mt-1 text-sm text-slate-500">Perbarui status pesanan ini.</p>
                </div>
                <div class="px-4 py-5 sm:p-6 space-y-6">
                    <!-- Status Pembayaran -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Status Pembayaran</label>
                        <select wire:model="statusPembayaran" class="mt-1 block w-full rounded-md border-slate-300 py-2 pl-3 pr-10 text-base focus:border-cyan-500 focus:outline-none focus:ring-cyan-500 sm:text-sm">
                            <option value="belum_dibayar">Belum Dibayar</option>
                            <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                            <option value="lunas">Lunas</option>
                            <option value="gagal">Gagal</option>
                        </select>
                    </div>

                    <!-- Status Pesanan -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Status Pesanan</label>
                        <select wire:model="statusPesanan" class="mt-1 block w-full rounded-md border-slate-300 py-2 pl-3 pr-10 text-base focus:border-cyan-500 focus:outline-none focus:ring-cyan-500 sm:text-sm">
                            <option value="menunggu">Menunggu Proses</option>
                            <option value="diproses">Sedang Diproses (Packing)</option>
                            <option value="dikirim">Dikirim (Kurir)</option>
                            <option value="selesai">Selesai (Diterima)</option>
                            <option value="batal">Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Resi -->
                    <div x-show="$wire.statusPesanan === 'dikirim' || $wire.statusPesanan === 'selesai'" x-transition>
                        <label class="block text-sm font-medium text-slate-700">Nomor Resi Pengiriman</label>
                        <input wire:model="resiPengiriman" type="text" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm" placeholder="Contoh: JNE-12345678">
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <button wire:click="simpanPerubahan" class="w-full inline-flex justify-center rounded-md border border-transparent bg-cyan-600 py-2 px-4 text-sm font-bold text-white shadow-sm hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
