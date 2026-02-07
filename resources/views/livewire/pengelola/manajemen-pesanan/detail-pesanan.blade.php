<div class="animate-in fade-in slide-in-from-bottom-4 duration-500 pb-20">
    
    <!-- Top Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('pengelola.pesanan.daftar') }}" class="w-12 h-12 bg-white rounded-2xl border border-slate-200 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Order #{{ $pesanan->nomor_faktur }}</h1>
                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-slate-100 text-slate-600 border border-slate-200">
                        {{ $pesanan->dibuat_pada->format('d M Y') }}
                    </span>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Detail & Manajemen Pemenuhan</p>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            @if($pesanan->status_pesanan != 'dibatalkan' && $pesanan->status_pesanan != 'selesai')
                @if($pesanan->status_pembayaran != 'lunas')
                    <button wire:click="verifikasiPembayaran" wire:confirm="Verifikasi pembayaran ini sebagai LUNAS?" class="px-6 py-3 bg-emerald-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-500/20 transition-all">
                        <i class="fa-solid fa-check-double mr-2"></i> Verifikasi Bayar
                    </button>
                @endif
                
                @if($pesanan->status_pesanan == 'dikirim')
                    <button wire:click="tandaiSelesai" wire:confirm="Selesaikan pesanan ini?" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-500/20 transition-all">
                        <i class="fa-solid fa-flag-checkered mr-2"></i> Tandai Selesai
                    </button>
                @endif

                <button wire:click="batalkanPesanan" wire:confirm="Yakin batalkan pesanan? Stok akan dikembalikan." class="px-6 py-3 bg-white border border-rose-200 text-rose-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-rose-50 transition-all">
                    <i class="fa-solid fa-ban mr-2"></i> Batalkan
                </button>
            @endif
            
            <a href="#" target="_blank" class="px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-800 shadow-lg shadow-slate-900/20 transition-all">
                <i class="fa-solid fa-print mr-2"></i> Invoice
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Left: Order Details -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Products Card -->
            <div class="bg-white rounded-[30px] border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Rincian Barang</h3>
                    <span class="text-xs font-bold text-slate-500">{{ $pesanan->detailPesanan->count() }} Item</span>
                </div>
                <div class="divide-y divide-slate-50">
                    @foreach($pesanan->detailPesanan as $detail)
                    <div class="p-6 flex items-center gap-6">
                        <div class="w-20 h-20 bg-slate-50 rounded-2xl border border-slate-100 p-2 flex-shrink-0">
                            <img src="{{ $detail->produk->gambar_utama_url ?? asset('img/no-image.png') }}" class="w-full h-full object-contain mix-blend-multiply">
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-slate-900 text-sm mb-1">{{ $detail->produk->nama }}</h4>
                            <p class="text-xs text-slate-500 mb-2">
                                @if($detail->varian)
                                    <span class="bg-slate-100 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide mr-2">{{ $detail->varian->nama_varian }}</span>
                                @endif
                                SKU: {{ $detail->produk->kode_unit }}
                            </p>
                            <div class="flex justify-between items-end">
                                <p class="text-xs font-bold text-slate-600">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_saat_ini, 0, ',', '.') }}</p>
                                <p class="text-sm font-black text-slate-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="bg-slate-50 p-8 space-y-3">
                    <div class="flex justify-between text-xs font-bold text-slate-500">
                        <span>Subtotal Produk</span>
                        <span>Rp {{ number_format($pesanan->total_harga - $pesanan->biaya_pengiriman + $pesanan->potongan_diskon, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xs font-bold text-slate-500">
                        <span>Biaya Pengiriman</span>
                        <span>Rp {{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</span>
                    </div>
                    @if($pesanan->potongan_diskon > 0)
                    <div class="flex justify-between text-xs font-bold text-emerald-600">
                        <span>Diskon / Voucher</span>
                        <span>- Rp {{ number_format($pesanan->potongan_diskon, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="pt-4 border-t border-slate-200 mt-4 flex justify-between items-center">
                        <span class="text-sm font-black text-slate-900 uppercase tracking-widest">Total Tagihan</span>
                        <span class="text-2xl font-black text-indigo-600">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Customer & Shipping Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-[30px] p-8 border border-slate-200 shadow-sm">
                    <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 mb-6 text-xl">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Informasi Pelanggan</h3>
                    <p class="text-lg font-bold text-slate-900">{{ $pesanan->pengguna->nama ?? 'Tamu' }}</p>
                    <p class="text-sm text-slate-500">{{ $pesanan->pengguna->email ?? '-' }}</p>
                    <p class="text-sm text-slate-500">{{ $pesanan->pengguna->nomor_telepon ?? '-' }}</p>
                </div>

                <div class="bg-white rounded-[30px] p-8 border border-slate-200 shadow-sm">
                    <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 mb-6 text-xl">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Pengiriman</h3>
                    <p class="text-sm font-medium text-slate-700 leading-relaxed">{{ $pesanan->alamat_pengiriman }}</p>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kurir:</span>
                        <span class="text-xs font-black text-slate-900 uppercase ml-2">{{ $pesanan->metode_pengiriman }}</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right: Status & Actions -->
        <div class="space-y-8">
            
            <!-- Status Card -->
            <div class="bg-white rounded-[30px] p-8 border border-slate-200 shadow-lg shadow-indigo-500/5 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-5">
                    <i class="fa-solid fa-rotate text-9xl"></i>
                </div>
                
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Status Pesanan</h3>
                
                <div class="space-y-6 relative z-10">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Status Pembayaran</label>
                        @php
                            $bayarColor = $pesanan->status_pembayaran == 'lunas' ? 'emerald' : ($pesanan->status_pembayaran == 'gagal' ? 'rose' : 'amber');
                        @endphp
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-{{ $bayarColor }}-500 animate-pulse"></span>
                            <span class="text-lg font-black text-{{ $bayarColor }}-600 uppercase">{{ str_replace('_', ' ', $pesanan->status_pembayaran) }}</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Proses Pemenuhan</label>
                        <div class="w-full bg-slate-100 rounded-full h-2 mb-2">
                            @php
                                $progress = match($pesanan->status_pesanan) {
                                    'menunggu' => 25,
                                    'diproses' => 50,
                                    'dikirim' => 75,
                                    'selesai' => 100,
                                    default => 0
                                };
                                $progressColor = $pesanan->status_pesanan == 'dibatalkan' ? 'bg-rose-500' : 'bg-indigo-600';
                            @endphp
                            <div class="{{ $progressColor }} h-2 rounded-full transition-all duration-1000" style="width: {{ $progress }}%"></div>
                        </div>
                        <span class="text-sm font-bold text-slate-900 uppercase">{{ $pesanan->status_pesanan }}</span>
                    </div>

                    @if($pesanan->status_pesanan != 'dibatalkan' && $pesanan->status_pesanan != 'menunggu')
                    <div class="pt-6 border-t border-slate-100">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Nomor Resi</label>
                        <div class="flex gap-2">
                            <input wire:model="resiPengiriman" type="text" class="w-full bg-slate-50 border-none rounded-xl text-xs font-bold font-mono focus:ring-2 focus:ring-indigo-500" placeholder="Input Resi...">
                            <button wire:click="updateResi" class="bg-indigo-600 text-white rounded-xl w-10 flex items-center justify-center hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20">
                                <i class="fa-solid fa-save text-xs"></i>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Activity Log -->
            <div class="bg-white rounded-[30px] border border-slate-200 shadow-sm p-8">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Riwayat Aktivitas</h3>
                <div class="space-y-6 relative border-l-2 border-slate-100 ml-3 pl-6">
                    @forelse($this->logAktivitas as $log)
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full border-2 border-white bg-indigo-500 shadow-sm"></div>
                        <p class="text-xs font-bold text-slate-900">{{ $log->pesan_naratif ?? $log->aksi }}</p>
                        <p class="text-[10px] text-slate-400 mt-1">{{ $log->waktu->format('d M Y • H:i') }}</p>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic">Belum ada log aktivitas.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>
