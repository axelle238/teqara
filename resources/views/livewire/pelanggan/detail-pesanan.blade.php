<div class="bg-slate-50 min-h-screen py-12">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <a href="/pesanan/riwayat" wire:navigate class="text-sm font-bold text-cyan-600 hover:text-cyan-700 flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Riwayat
                </a>
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Lacak Pesanan <span class="text-cyan-600">#{{ $pesanan->nomor_invoice }}</span></h1>
            </div>
            <div class="flex gap-2">
                <a href="/pesanan/faktur/{{ $pesanan->nomor_invoice }}" target="_blank" class="px-6 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-50 transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Invoice
                </a>
                <button class="px-6 py-2.5 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20">Bantuan CS</button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Kolom Kiri: Detail Produk & Alamat -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Status Bar Ringkas -->
                <div class="bg-gradient-to-r from-cyan-600 to-indigo-600 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-cyan-100 text-xs font-black uppercase tracking-[0.2em] mb-2">Estimasi Tiba</p>
                        <h3 class="text-2xl font-black mb-4">Dalam Pengiriman (2-3 Hari)</h3>
                        <div class="flex items-center gap-4">
                            <div class="px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/20 text-xs font-bold">
                                JNE Reguler
                            </div>
                            <div class="text-xs font-bold text-cyan-50">Resi: {{ $pesanan->resi_pengiriman ?? 'Sedang Disiapkan' }}</div>
                        </div>
                    </div>
                    <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12 translate-x-10"></div>
                </div>

                <!-- Daftar Item -->
                <div class="bg-white rounded-[32px] shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Rincian Perangkat</h3>
                        <span class="text-xs font-bold text-slate-400">{{ $pesanan->detailPesanan->count() }} Item</span>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @foreach($pesanan->detailPesanan as $detail)
                        <div class="p-8 flex items-center gap-6 group hover:bg-slate-50/50 transition-colors">
                            <div class="w-20 h-20 rounded-2xl bg-slate-50 border border-slate-100 flex-shrink-0 overflow-hidden p-2 group-hover:scale-105 transition-transform">
                                <img src="{{ $detail->produk->gambar_utama_url }}" class="w-full h-full object-contain">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-lg font-bold text-slate-900 leading-snug truncate">{{ $detail->produk->nama }}</h4>
                                <p class="text-sm text-slate-500 font-medium">{{ $detail->jumlah }} x {{ 'Rp ' . number_format($detail->harga_saat_ini, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-slate-900 tracking-tighter">{{ 'Rp ' . number_format($detail->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="bg-slate-50 px-8 py-6 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500 font-bold">Subtotal</span>
                            <span class="text-slate-900 font-black">{{ 'Rp ' . number_format($pesanan->total_harga + $pesanan->potongan_diskon, 0, ',', '.') }}</span>
                        </div>
                        @if($pesanan->potongan_diskon > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-emerald-600 font-bold">Diskon Voucher ({{ $pesanan->kode_voucher }})</span>
                            <span class="text-emerald-600 font-black">- {{ 'Rp ' . number_format($pesanan->potongan_diskon, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between pt-4 border-t border-slate-200">
                            <span class="text-lg font-black text-slate-900">Total Pembayaran</span>
                            <span class="text-2xl font-black text-cyan-600 tracking-tighter">{{ 'Rp ' . number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Info Pengiriman -->
                <div class="bg-white rounded-[32px] shadow-sm border border-slate-200 p-8">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Informasi Pengiriman</h3>
                    <div class="flex gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-cyan-50 flex items-center justify-center text-cyan-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-black text-slate-900 mb-1">{{ $pesanan->pengguna->nama }}</p>
                            <p class="text-slate-500 text-sm leading-relaxed">{{ $pesanan->alamat_pengiriman }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Timeline Visual -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[32px] shadow-sm border border-slate-200 p-8 sticky top-24">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-8">Timeline Proses</h3>
                    
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <!-- 1. Pesanan Dibuat -->
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-emerald-200" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-emerald-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm font-black text-slate-900">Pesanan Dibuat</p>
                                                <p class="text-xs text-slate-500">Sistem memverifikasi pembayaran Anda.</p>
                                            </div>
                                            <div class="text-right text-xs text-slate-400 font-bold whitespace-nowrap">
                                                {{ $pesanan->created_at->format('H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <!-- 2. Diproses -->
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 {{ $this->cekStatus('diproses') == 'aktif' ? 'bg-emerald-200' : 'bg-slate-200' }}" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full {{ $this->cekStatus('diproses') == 'aktif' ? 'bg-emerald-500' : 'bg-slate-200' }} flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm font-black {{ $this->cekStatus('diproses') == 'aktif' ? 'text-slate-900' : 'text-slate-400' }}">Sedang Dikemas</p>
                                                <p class="text-xs text-slate-500">Staf gudang menyiapkan perangkat Anda.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <!-- 3. Dikirim -->
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 {{ $this->cekStatus('dikirim') == 'aktif' ? 'bg-emerald-200' : 'bg-slate-200' }}" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full {{ $this->cekStatus('dikirim') == 'aktif' ? 'bg-emerald-500' : 'bg-slate-200' }} flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm font-black {{ $this->cekStatus('dikirim') == 'aktif' ? 'text-slate-900' : 'text-slate-400' }}">Dalam Perjalanan</p>
                                                <p class="text-xs text-slate-500">Pesanan telah diserahkan ke kurir.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <!-- 4. Selesai -->
                            <li>
                                <div class="relative">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full {{ $this->cekStatus('selesai') == 'aktif' ? 'bg-emerald-500' : 'bg-slate-200' }} flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm font-black {{ $this->cekStatus('selesai') == 'aktif' ? 'text-slate-900' : 'text-slate-400' }}">Pesanan Selesai</p>
                                                <p class="text-xs text-slate-500">Paket telah diterima dengan baik.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
