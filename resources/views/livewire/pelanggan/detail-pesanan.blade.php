<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6 animate-fade-in-down">
            <div>
                <a href="{{ route('pesanan.riwayat') }}" wire:navigate class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-indigo-600 flex items-center gap-2 mb-3 transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Riwayat
                </a>
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">Lacak <span class="text-indigo-600">Pesanan</span></h1>
                <div class="flex items-center gap-3 mt-2">
                    <span class="px-3 py-1 bg-slate-200 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-widest font-mono">
                        #{{ $pesanan->nomor_faktur }}
                    </span>
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wide">
                        {{ $pesanan->dibuat_pada->format('d M Y, H:i') }}
                    </span>
                </div>
            </div>
            
            <div class="flex gap-3">
                @if($pesanan->status_pesanan == 'menunggu')
                    <a href="{{ route('pesanan.bayar', $pesanan->nomor_faktur) }}" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30">
                        Bayar Sekarang
                    </a>
                    <a href="{{ route('pesanan.batal', $pesanan->id) }}" class="px-6 py-3 bg-white border border-rose-200 text-rose-500 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-rose-50 transition-all">
                        Batalkan
                    </a>
                @elseif($pesanan->status_pesanan == 'selesai')
                    <a href="{{ route('ulasan.buat', ['pesananId' => $pesanan->id, 'produkId' => $pesanan->detailPesanan->first()->produk_id]) }}" class="px-6 py-3 bg-amber-500 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-amber-600 transition-all shadow-lg shadow-amber-500/20">
                        Beri Ulasan
                    </a>
                    <a href="{{ route('pesanan.faktur', $pesanan->nomor_faktur) }}" target="_blank" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Invoice
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start animate-fade-in-up">
            
            <!-- Kolom Kiri: Detail -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Status Banner -->
                <div class="relative overflow-hidden rounded-[2.5rem] p-10 shadow-2xl 
                    {{ $pesanan->status_pesanan == 'batal' ? 'bg-gradient-to-br from-rose-500 to-red-600 shadow-rose-500/30' : 
                       ($pesanan->status_pesanan == 'selesai' ? 'bg-gradient-to-br from-emerald-500 to-teal-600 shadow-emerald-500/30' : 
                       'bg-gradient-to-br from-indigo-600 to-purple-700 shadow-indigo-500/30') }}">
                    
                    <!-- BG Pattern -->
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
                    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

                    <div class="relative z-10 text-white">
                        <p class="text-white/60 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Status Terkini</p>
                        <h2 class="text-3xl md:text-4xl font-black tracking-tight mb-4 uppercase italic">
                            {{ str_replace('_', ' ', $pesanan->status_pesanan) }}
                        </h2>
                        
                        @if($pesanan->status_pesanan == 'dikirim')
                        <div class="inline-flex items-center gap-4 bg-white/10 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/10">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl">🚚</div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-white/60">Nomor Resi</p>
                                <p class="text-sm font-black text-white tracking-wider font-mono">{{ $pesanan->resi_pengiriman ?? 'MENUNGGU UPDATE' }}</p>
                            </div>
                        </div>
                        @elseif($pesanan->status_pesanan == 'menunggu')
                        <p class="text-sm font-medium text-white/80 max-w-md leading-relaxed">
                            Mohon selesaikan pembayaran sebelum <span class="font-black text-white">{{ $pesanan->dibuat_pada->addDay()->format('d M Y H:i') }}</span> agar pesanan tidak dibatalkan otomatis.
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Daftar Produk -->
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Item Pesanan</h3>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-white px-3 py-1 rounded-lg border border-slate-100">{{ $pesanan->detailPesanan->count() }} Produk</span>
                    </div>
                    
                    <div class="divide-y divide-slate-50">
                        @foreach($pesanan->detailPesanan as $detail)
                        <div class="p-8 flex flex-col sm:flex-row items-center gap-6 group hover:bg-slate-50 transition-colors">
                            <div class="relative w-24 h-24 rounded-2xl bg-white border border-slate-100 p-2 flex-shrink-0">
                                <img src="{{ $detail->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-500">
                            </div>
                            
                            <div class="flex-1 text-center sm:text-left">
                                <h4 class="font-black text-slate-900 text-sm uppercase tracking-wide leading-tight mb-1">{{ $detail->produk->nama }}</h4>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">
                                    {{ $detail->jumlah }} x Rp {{ number_format($detail->harga_saat_ini, 0, ',', '.') }}
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <span class="block text-lg font-black text-slate-900 tracking-tight">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Ringkasan Harga -->
                    <div class="bg-slate-50/50 p-8 space-y-3 border-t border-slate-100">
                        <div class="flex justify-between text-xs font-bold text-slate-500">
                            <span>Subtotal Produk</span>
                            <span class="text-slate-900">Rp {{ number_format($pesanan->total_harga + $pesanan->potongan_diskon, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs font-bold text-slate-500">
                            <span>Biaya Pengiriman</span>
                            <span class="text-slate-900">Gratis (Promo)</span>
                        </div>
                        @if($pesanan->potongan_diskon > 0)
                        <div class="flex justify-between text-xs font-bold text-emerald-600">
                            <span>Diskon Voucher</span>
                            <span>- Rp {{ number_format($pesanan->potongan_diskon, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        <div class="pt-4 mt-2 border-t border-slate-200 flex justify-between items-center">
                            <span class="text-sm font-black text-slate-900 uppercase tracking-widest">Total Bayar</span>
                            <span class="text-3xl font-black text-indigo-600 tracking-tighter">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Info Pengiriman -->
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl p-8 flex flex-col sm:flex-row gap-8">
                    <div class="flex-1">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Dikirim Ke</h4>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-lg">📍</div>
                            <div>
                                <p class="font-black text-slate-900 text-sm mb-1">{{ $pesanan->pengguna->nama }}</p>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed">{{ $pesanan->alamat_pengiriman }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-px bg-slate-100 hidden sm:block"></div>
                    <div class="flex-1">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Metode Pembayaran</h4>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-lg">💳</div>
                            <div>
                                <p class="font-black text-slate-900 text-sm mb-1 uppercase">{{ $pesanan->metode_pembayaran ?? 'Manual Transfer' }}</p>
                                <p class="text-[10px] font-bold uppercase tracking-widest {{ $pesanan->status_pembayaran == 'lunas' ? 'text-emerald-600' : 'text-amber-500' }}">
                                    Status: {{ $pesanan->status_pembayaran }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Timeline -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl p-8 sticky top-28">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-8 border-b border-slate-50 pb-4">Jejak Pesanan</h3>
                    
                    <div class="relative pl-4 border-l-2 border-slate-100 space-y-10">
                        @php
                            $steps = [
                                'menunggu' => ['label' => 'Pesanan Dibuat', 'desc' => 'Menunggu pembayaran diverifikasi.'],
                                'diproses' => ['label' => 'Diproses Gudang', 'desc' => 'Barang sedang disiapkan & dikemas.'],
                                'dikirim' => ['label' => 'Dalam Pengiriman', 'desc' => 'Paket diserahkan ke kurir logistik.'],
                                'selesai' => ['label' => 'Pesanan Selesai', 'desc' => 'Paket telah diterima pelanggan.'],
                            ];
                            $currentStatus = $pesanan->status_pesanan;
                        @endphp

                        @foreach($steps as $key => $step)
                            @php
                                $status = $this->cekStatus($key);
                                $isActive = $status == 'aktif';
                                $isCurrent = $key == $currentStatus;
                            @endphp
                            <div class="relative {{ $isActive ? '' : 'opacity-40 grayscale' }}">
                                <span class="absolute -left-[21px] top-1 w-4 h-4 rounded-full border-2 {{ $isActive ? 'bg-indigo-600 border-indigo-600' : 'bg-white border-slate-300' }}"></span>
                                <h4 class="text-sm font-black {{ $isActive ? 'text-indigo-900' : 'text-slate-50' }} uppercase tracking-wide">{{ $step['label'] }}</h4>
                                <p class="text-xs text-slate-500 font-medium mt-1 leading-relaxed">{{ $step['desc'] }}</p>
                                @if($isCurrent)
                                    <span class="inline-block mt-2 px-2 py-0.5 bg-indigo-100 text-indigo-700 text-[9px] font-black uppercase tracking-widest rounded">Posisi Saat Ini</span>
                                @endif
                            </div>
                        @endforeach
                        
                        @if($pesanan->status_pesanan == 'batal')
                             <div class="relative">
                                <span class="absolute -left-[21px] top-1 w-4 h-4 rounded-full bg-rose-500 border-2 border-rose-500"></span>
                                <h4 class="text-sm font-black text-rose-600 uppercase tracking-wide">Dibatalkan</h4>
                                <p class="text-xs text-rose-500 font-medium mt-1">Pesanan telah dibatalkan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
