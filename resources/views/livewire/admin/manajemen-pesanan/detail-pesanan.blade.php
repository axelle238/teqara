<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Topbar: Identity & Primary Actions -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
        <div>
            <div class="flex items-center gap-3 text-sm text-slate-500 font-bold mb-2">
                <a href="{{ route('admin.pesanan.daftar') }}" wire:navigate class="hover:text-indigo-600 transition-colors"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                <span>/</span>
                <span>Order #{{ $pesanan->nomor_faktur }}</span>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Detail Pesanan</h1>
            <p class="text-slate-500 text-sm mt-1">Dibuat pada {{ $pesanan->created_at->translatedFormat('l, d F Y H:i') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <!-- Status Badge (Big) -->
            @php
                $statusColors = [
                    'menunggu' => 'bg-slate-100 text-slate-600',
                    'diproses' => 'bg-indigo-100 text-indigo-700',
                    'dikirim' => 'bg-cyan-100 text-cyan-700',
                    'selesai' => 'bg-emerald-100 text-emerald-700',
                    'batal' => 'bg-rose-100 text-rose-700',
                ];
                $color = $statusColors[$pesanan->status_pesanan] ?? 'bg-slate-100 text-slate-600';
            @endphp
            <div class="px-4 py-2 rounded-xl {{ $color }} font-black uppercase tracking-widest text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle text-[8px] animate-pulse"></i>
                {{ ucfirst($pesanan->status_pesanan) }}
            </div>

            <!-- Primary Actions -->
            @if($pesanan->status_pesanan == 'diproses')
                <button x-data @click="$dispatch('open-panel-geser', { id: 'panel-resi' })" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95 flex items-center gap-2">
                    <i class="fa-solid fa-truck-fast"></i> Input Resi & Kirim
                </button>
            @endif

            @if($pesanan->status_pesanan == 'dikirim')
                <button wire:click="selesaikanPesanan" wire:confirm="Pastikan barang sudah diterima pelanggan. Selesaikan pesanan?" class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-600/20 transition-all active:scale-95 flex items-center gap-2">
                    <i class="fa-solid fa-check-double"></i> Tandai Selesai
                </button>
            @endif

            <button class="p-3 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-colors" title="Cetak Invoice">
                <i class="fa-solid fa-print"></i>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Items & Shipping -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Ordered Items -->
            <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Item Dipesan</h3>
                    <span class="text-xs font-bold text-slate-500">{{ $pesanan->detailPesanan->count() }} Unit Barang</span>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach($pesanan->detailPesanan as $item)
                    <div class="p-6 flex gap-6 hover:bg-slate-50/30 transition-colors">
                        <div class="w-20 h-20 bg-slate-100 rounded-xl border border-slate-200 flex items-center justify-center overflow-hidden shrink-0">
                            @if($item->produk->gambar_utama)
                                <img src="{{ asset($item->produk->gambar_utama) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-box text-slate-300"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">{{ $item->produk->nama }}</h4>
                                    @if($item->varian)
                                        <p class="text-xs text-indigo-600 font-bold mt-1 uppercase tracking-wide bg-indigo-50 inline-block px-2 py-0.5 rounded">
                                            {{ $item->varian->nama_varian }}
                                        </p>
                                    @else
                                        <p class="text-xs text-slate-400 mt-1">Standar Unit</p>
                                    @endif
                                    <p class="text-xs text-slate-500 mt-1">SKU: {{ $item->produk->kode_unit }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $item->jumlah }} x Rp {{ number_format($item->harga_saat_ini, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="bg-slate-50 px-6 py-4 border-t border-slate-100">
                    <div class="flex justify-between items-center text-sm mb-2">
                        <span class="text-slate-500 font-medium">Subtotal Produk</span>
                        <span class="font-bold text-slate-700">Rp {{ number_format($pesanan->total_harga - $pesanan->biaya_pengiriman + $pesanan->potongan_diskon, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm mb-2">
                        <span class="text-slate-500 font-medium">Biaya Pengiriman ({{ strtoupper($pesanan->metode_pengiriman) }})</span>
                        <span class="font-bold text-slate-700">Rp {{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</span>
                    </div>
                    @if($pesanan->potongan_diskon > 0)
                    <div class="flex justify-between items-center text-sm mb-2 text-emerald-600">
                        <span class="font-medium">Potongan Diskon</span>
                        <span class="font-bold">- Rp {{ number_format($pesanan->potongan_diskon, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center text-lg mt-4 pt-4 border-t border-slate-200">
                        <span class="font-black text-slate-900 uppercase tracking-tight">Total Tagihan</span>
                        <span class="font-black text-indigo-600">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Details -->
            <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm p-6">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-map-location-dot text-indigo-500"></i> Informasi Pengiriman
                </h3>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                    <p class="text-sm font-bold text-slate-900 mb-1">{{ $pesanan->pengguna->nama }}</p>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $pesanan->alamat_pengiriman }}</p>
                    <div class="mt-4 flex items-center gap-4 text-xs font-medium text-slate-500">
                        <span class="flex items-center gap-1"><i class="fa-solid fa-phone"></i> {{ $pesanan->pengguna->telepon ?? '-' }}</span>
                        <span class="flex items-center gap-1"><i class="fa-solid fa-envelope"></i> {{ $pesanan->pengguna->email }}</span>
                    </div>
                </div>
                @if($pesanan->resi_pengiriman)
                <div class="mt-4 p-4 bg-emerald-50 border border-emerald-100 rounded-xl flex justify-between items-center">
                    <div>
                        <p class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Nomor Resi</p>
                        <p class="text-lg font-mono font-black text-emerald-900 mt-1">{{ $pesanan->resi_pengiriman }}</p>
                    </div>
                    <button class="text-emerald-600 hover:text-emerald-800 text-sm font-bold">Lacak</button>
                </div>
                @endif
            </div>

        </div>

        <!-- Right Column: Payment & Verification -->
        <div class="space-y-8">
            
            <!-- Customer Card -->
            <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm p-6 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-fuchsia-500 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl font-black text-white shadow-lg shadow-indigo-500/30">
                    {{ substr($pesanan->pengguna->nama, 0, 1) }}
                </div>
                <h3 class="font-bold text-slate-900 text-lg">{{ $pesanan->pengguna->nama }}</h3>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mt-1">Pelanggan Terdaftar</p>
                
                <div class="mt-6 grid grid-cols-2 gap-2 text-center">
                    <div class="p-2 bg-slate-50 rounded-lg">
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Total Order</p>
                        <p class="text-sm font-black text-slate-900">{{ $pesanan->pengguna->pesanan->count() }}</p>
                    </div>
                    <div class="p-2 bg-slate-50 rounded-lg">
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Total Belanja</p>
                        <p class="text-sm font-black text-slate-900">Rp {{ number_format($pesanan->pengguna->pesanan->where('status_pembayaran','lunas')->sum('total_harga')/1000000, 1) }}Jt</p>
                    </div>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm p-6">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-wallet text-indigo-500"></i> Status Pembayaran
                </h3>

                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <span class="text-xs font-bold text-slate-500">Status</span>
                        @if($pesanan->status_pembayaran == 'lunas')
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded text-xs font-black uppercase">LUNAS</span>
                        @elseif($pesanan->status_pembayaran == 'menunggu_verifikasi')
                            <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded text-xs font-black uppercase animate-pulse">Menunggu Cek</span>
                        @else
                            <span class="px-2 py-1 bg-slate-200 text-slate-600 rounded text-xs font-black uppercase">{{ $pesanan->status_pembayaran }}</span>
                        @endif
                    </div>

                    <!-- Payment Proof / Action -->
                    @if($pesanan->bukti_bayar)
                        <div class="rounded-xl overflow-hidden border border-slate-200 relative group cursor-pointer" onclick="window.open('{{ asset('storage/'.$pesanan->bukti_bayar) }}', '_blank')">
                            <img src="{{ asset('storage/'.$pesanan->bukti_bayar) }}" class="w-full h-32 object-cover">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white font-bold text-xs">
                                Klik untuk Perbesar
                            </div>
                        </div>
                    @endif

                    @if($pesanan->status_pembayaran == 'menunggu_verifikasi')
                        <div class="grid grid-cols-2 gap-2 mt-4">
                            <button wire:click="verifikasiPembayaran" wire:confirm="Konfirmasi pembayaran valid?" class="py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-xs font-bold shadow-md transition-all">
                                <i class="fa-solid fa-check mr-1"></i> Terima
                            </button>
                            <button wire:click="tolakPembayaran" wire:confirm="Tolak pembayaran dan batalkan pesanan?" class="py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-lg text-xs font-bold shadow-md transition-all">
                                <i class="fa-solid fa-xmark mr-1"></i> Tolak
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm p-6">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Jejak Pesanan</h3>
                <div class="relative border-l-2 border-slate-100 ml-3 space-y-6">
                    
                    <!-- Steps -->
                    <div class="relative pl-6">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-indigo-500 border-2 border-white shadow"></div>
                        <p class="text-xs font-black text-slate-900 uppercase">Pesanan Dibuat</p>
                        <p class="text-[10px] text-slate-400">{{ $pesanan->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    @if($pesanan->status_pembayaran == 'lunas')
                    <div class="relative pl-6 animate-in fade-in slide-in-from-left-2 duration-300">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white shadow"></div>
                        <p class="text-xs font-black text-slate-900 uppercase">Pembayaran Lunas</p>
                        <p class="text-[10px] text-slate-400">Terverifikasi Otomatis/Manual</p>
                    </div>
                    @endif

                    @if($pesanan->resi_pengiriman)
                    <div class="relative pl-6 animate-in fade-in slide-in-from-left-2 duration-300">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-cyan-500 border-2 border-white shadow"></div>
                        <p class="text-xs font-black text-slate-900 uppercase">Pesanan Dikirim</p>
                        <p class="text-[10px] text-slate-400">Resi: {{ $pesanan->resi_pengiriman }}</p>
                    </div>
                    @endif

                    @if($pesanan->status_pesanan == 'selesai')
                    <div class="relative pl-6 animate-in fade-in slide-in-from-left-2 duration-300">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-slate-900 border-2 border-white shadow"></div>
                        <p class="text-xs font-black text-slate-900 uppercase">Pesanan Selesai</p>
                        <p class="text-[10px] text-slate-400">Transaksi Ditutup</p>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

    <!-- Slide Over: Input Resi -->
    <x-ui.panel-geser id="panel-resi" judul="Input Resi Pengiriman">
        <div class="space-y-6">
            <div class="p-4 bg-indigo-50 border border-indigo-100 rounded-xl text-indigo-800 text-sm">
                Pastikan nomor resi valid. Status pesanan akan otomatis berubah menjadi <strong>DIKIRIM</strong> dan pelanggan akan menerima notifikasi.
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-widest">Nomor Resi / AWB</label>
                <input wire:model="resiInput" type="text" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 font-mono font-bold uppercase" placeholder="Contoh: JP778812399">
                @error('resiInput') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <button wire:click="updateResi" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
                Simpan & Kirim Notifikasi
            </button>
        </div>
    </x-ui.panel-geser>

</div>