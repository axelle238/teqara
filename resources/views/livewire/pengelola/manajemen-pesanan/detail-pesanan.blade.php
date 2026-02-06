<div class="space-y-10 animate-in fade-in duration-500 pb-20">
    
    <!-- Topbar: Navigasi & Identitas Utama -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="flex items-center gap-6">
            <a href="{{ route('pengelola.pesanan.daftar') }}" wire:navigate class="w-14 h-14 rounded-2xl bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-all shadow-sm group">
                <i class="fa-solid fa-arrow-left text-xl group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div class="space-y-1">
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-none">ORDER #{{ $pesanan->nomor_faktur }}</h1>
                    <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase tracking-widest border border-indigo-100">Enterprise Order</span>
                </div>
                <p class="text-slate-500 font-medium text-sm">Pemenuhan transaksi hulu-ke-hilir Teqara Hub.</p>
            </div>
        </div>

        <div class="flex items-center gap-4">
            @php
                $statusColors = [
                    'menunggu' => 'bg-slate-100 text-slate-600 border-slate-200',
                    'diproses' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                    'dikirim' => 'bg-cyan-100 text-cyan-700 border-cyan-200',
                    'selesai' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                    'batal' => 'bg-rose-100 text-rose-700 border-rose-200',
                ];
                $colorClass = $statusColors[$pesanan->status_pesanan] ?? 'bg-slate-100 text-slate-600';
            @endphp
            <div class="px-6 py-3 rounded-2xl {{ $colorClass }} font-black uppercase tracking-widest text-xs border flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle text-[8px] animate-pulse"></i>
                {{ $pesanan->status_pesanan }}
            </div>
            <button class="w-12 h-12 bg-white border border-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 hover:bg-indigo-50 transition-all shadow-sm">
                <i class="fa-solid fa-print"></i>
            </button>
        </div>
    </div>

    <!-- AREA KONTROL DINAMIS: FULL PAGE SECTIONS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- KOLOM KIRI: RINCIAN PRODUK & LOGISTIK -->
        <div class="lg:col-span-2 space-y-10">
            
            <!-- Daftar Item (Katalog Internal) -->
            <div class="bg-white rounded-[50px] shadow-sm border border-indigo-50 overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-lg">
                            <i class="fa-solid fa-list-ul"></i>
                        </div>
                        <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest">Komposisi Keranjang</h3>
                    </div>
                    <span class="text-xs font-black text-indigo-600 bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-100">{{ $pesanan->detailPesanan->count() }} UNIT BARANG</span>
                </div>
                
                <div class="divide-y divide-slate-50">
                    @foreach($pesanan->detailPesanan as $item)
                    <div class="p-10 flex flex-col md:flex-row gap-8 hover:bg-indigo-50/20 transition-all group">
                        <div class="w-32 h-32 bg-slate-50 rounded-[35px] border border-slate-100 flex items-center justify-center overflow-hidden shrink-0 group-hover:scale-105 transition-transform duration-500">
                            @if($item->produk->gambar_utama)
                                <img src="{{ asset($item->produk->gambar_utama) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-microchip text-4xl text-slate-200"></i>
                            @endif
                        </div>
                        <div class="flex-1 space-y-4">
                            <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                                <div class="space-y-1">
                                    <h4 class="font-black text-xl text-slate-800 leading-tight">{{ $item->produk->nama }}</h4>
                                    <div class="flex flex-wrap gap-2 pt-1">
                                        <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black uppercase tracking-widest">SKU: {{ $item->produk->kode_unit }}</span>
                                        @if($item->varian)
                                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-indigo-100">VARIAN: {{ $item->varian->nama_varian }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-left md:text-right space-y-1">
                                    <p class="font-black text-2xl text-slate-900 tracking-tighter">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $item->jumlah }} x Rp{{ number_format($item->harga_saat_ini, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Ringkasan Finansial -->
                <div class="bg-slate-50 p-10 space-y-4">
                    <div class="flex justify-between items-center text-sm font-bold">
                        <span class="text-slate-400 uppercase tracking-widest">Subtotal Produk</span>
                        <span class="text-slate-700">Rp{{ number_format($pesanan->total_harga - $pesanan->biaya_pengiriman + $pesanan->potongan_diskon, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-bold">
                        <span class="text-slate-400 uppercase tracking-widest">Ongkos Kirim ({{ strtoupper($pesanan->metode_pengiriman) }})</span>
                        <span class="text-slate-700">Rp{{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</span>
                    </div>
                    @if($pesanan->potongan_diskon > 0)
                    <div class="flex justify-between items-center text-sm font-bold text-emerald-600">
                        <span class="uppercase tracking-widest">Potongan Diskon</span>
                        <span>- Rp{{ number_format($pesanan->potongan_diskon, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center pt-6 mt-6 border-t border-slate-200">
                        <span class="text-xl font-black text-slate-900 uppercase tracking-tight">Total Nilai Transaksi</span>
                        <span class="text-4xl font-black text-indigo-600 tracking-tighter">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Kontrol Logistik (Full Section) -->
            <div class="bg-white rounded-[50px] shadow-sm border border-indigo-50 p-10 space-y-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-cyan-600 flex items-center justify-center text-white shadow-lg">
                            <i class="fa-solid fa-truck-ramp-box"></i>
                        </div>
                        <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest">Manajemen Pengiriman</h3>
                    </div>
                    @if($pesanan->status_pesanan == 'diproses' && !$modeInputResi)
                        <button wire:click="aktifkanModeResi" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-indigo-500/20 transition-all">AKTIFKAN FORM RESI</button>
                    @endif
                </div>

                @if($modeInputResi)
                    <div class="bg-indigo-50 p-10 rounded-[40px] border-2 border-indigo-100 space-y-8 animate-in slide-in-from-top-4 duration-500">
                        <div class="space-y-2">
                            <h4 class="text-lg font-black text-indigo-900 uppercase tracking-tight">Registrasi Nomor Resi (AWB)</h4>
                            <p class="text-xs font-bold text-indigo-600 opacity-80 uppercase tracking-widest">Status pesanan akan berubah menjadi 'DIKIRIM' secara otomatis.</p>
                        </div>
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="flex-1">
                                <input wire:model="resiInput" type="text" class="w-full bg-white border-none rounded-2xl px-8 py-5 text-xl font-black text-slate-800 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-200 font-mono uppercase" placeholder="Cth: JNE123456789">
                                @error('resiInput') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest mt-2 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex gap-3">
                                <button wire:click="batalResi" class="px-8 py-5 bg-white text-slate-400 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all">BATAL</button>
                                <button wire:click="updateResi" class="px-10 py-5 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 transition-all">SIMPAN & KIRIM</button>
                            </div>
                        </div>
                    </div>
                @else
                    @if($pesanan->resi_pengiriman)
                        <div class="bg-emerald-50 p-8 rounded-[40px] border border-emerald-100 flex flex-col md:flex-row justify-between items-center gap-6">
                            <div class="space-y-1 text-center md:text-left">
                                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em]">Paket Telah Diberangkatkan</p>
                                <p class="text-3xl font-black text-emerald-900 tracking-tighter font-mono uppercase">{{ $pesanan->resi_pengiriman }}</p>
                            </div>
                            <button class="px-8 py-4 bg-white text-emerald-600 rounded-2xl text-xs font-black uppercase tracking-widest border border-emerald-100 hover:bg-emerald-600 hover:text-white transition-all shadow-sm">LACAK POSISI PAKET</button>
                        </div>
                    @else
                        <div class="py-10 text-center space-y-4">
                            <i class="fa-solid fa-box-open text-5xl text-slate-100"></i>
                            <p class="text-xs font-black text-slate-300 uppercase tracking-[0.3em]">Belum Ada Resi Terdaftar</p>
                        </div>
                    @endif
                @endif
            </div>

        </div>

        <!-- KOLOM KANAN: PELANGGAN & STATUS PEMBAYARAN -->
        <div class="space-y-10">
            
            <!-- Identitas Pelanggan (Enterprise Profile) -->
            <div class="bg-white rounded-[50px] shadow-sm border border-indigo-50 p-10 text-center space-y-6">
                <div class="relative inline-block">
                    <div class="w-28 h-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-[35px] flex items-center justify-center text-3xl font-black text-white shadow-2xl shadow-indigo-500/30">
                        {{ substr($pesanan->pengguna->nama, 0, 1) }}
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-emerald-400 border-4 border-white rounded-2xl flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-check text-xs"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none">{{ $pesanan->pengguna->nama }}</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-3">Mitra Pelanggan Setia</p>
                </div>
                
                <div class="pt-6 border-t border-slate-50 flex flex-col gap-4 text-left">
                    <div class="flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-600 truncate">{{ $pesanan->pengguna->email }}</p>
                    </div>
                    <div class="flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-600">{{ $pesanan->pengguna->nomor_telepon ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Panel Verifikasi Pembayaran -->
            <div class="bg-white rounded-[50px] shadow-sm border border-indigo-50 p-10 space-y-8">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center text-white shadow-lg shadow-amber-500/20">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest">Otoritas Bayar</h3>
                </div>

                <div class="space-y-6">
                    @if($pesanan->bukti_bayar)
                        <div class="relative aspect-[3/4] bg-slate-100 rounded-[40px] overflow-hidden border-4 border-slate-50 group cursor-pointer" onclick="window.open('{{ asset('storage/'.$pesanan->bukti_bayar) }}', '_blank')">
                            <img src="{{ asset('storage/'.$pesanan->bukti_bayar) }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-indigo-900/60 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center">
                                <p class="text-[10px] font-black text-white uppercase tracking-widest">Lihat Bukti Asli</p>
                            </div>
                        </div>
                    @else
                        <div class="aspect-video bg-slate-50 rounded-[40px] flex flex-col items-center justify-center text-slate-200 border border-dashed border-slate-100">
                            <i class="fa-solid fa-file-circle-exclamation text-4xl mb-3"></i>
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-300">Belum Ada Bukti Bayar</p>
                        </div>
                    @endif

                    @if($pesanan->status_pembayaran == 'menunggu_verifikasi')
                        <div class="grid grid-cols-1 gap-4 pt-4">
                            <button wire:click="verifikasiPembayaran" wire:confirm="Terima pembayaran ini?" class="w-full py-5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-3xl text-xs font-black uppercase tracking-[0.2em] shadow-xl shadow-emerald-500/20 transition-all active:scale-95">VERIFIKASI VALID</button>
                            <button wire:click="tolakPembayaran" wire:confirm="Tolak bukti bayar ini?" class="w-full py-5 bg-white text-rose-500 rounded-3xl text-xs font-black uppercase tracking-[0.2em] border-2 border-rose-100 hover:bg-rose-50 transition-all active:scale-95">TOLAK & BATAL</button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action: Selesaikan Order -->
            @if($pesanan->status_pesanan == 'dikirim')
                <button wire:click="selesaikanPesanan" wire:confirm="Pastikan dana sudah cair dan barang diterima. Tutup transaksi?" class="w-full py-10 bg-gradient-to-br from-indigo-600 to-indigo-800 text-white rounded-[50px] shadow-2xl shadow-indigo-500/30 flex flex-col items-center justify-center gap-4 hover:scale-105 transition-all group">
                    <div class="w-16 h-16 bg-white/20 rounded-[25px] flex items-center justify-center text-2xl group-hover:rotate-12 transition-transform">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                    <div class="text-center">
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-70">Konfirmasi Akhir</p>
                        <p class="text-xl font-black uppercase tracking-tighter">Selesaikan Pesanan</p>
                    </div>
                </button>
            @endif

        </div>
    </div>

</div>
