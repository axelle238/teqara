<div class="bg-slate-50 min-h-screen pb-20 pt-10 font-sans" wire:poll.15s>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-10 items-start">
            
            <!-- Sidebar Pelanggan -->
            <x-layouts.pelanggan.sidebar />

            <!-- Konten Utama -->
            <div class="flex-1 w-full space-y-10 animate-fade-in-up">
                
                <!-- Dashboard Welcome & Loyalty Hub -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-gradient-to-r from-[#0f172a] to-[#1e293b] rounded-[3rem] p-10 text-white relative overflow-hidden shadow-2xl shadow-indigo-500/20">
                        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
                        <div class="relative z-10 flex flex-col justify-between h-full">
                            <div>
                                <p class="text-indigo-400 text-[10px] font-black uppercase tracking-[0.3em] mb-4">Command Center Pelanggan</p>
                                <h1 class="text-4xl font-black tracking-tight leading-none">Selamat Datang,<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">{{ explode(' ', $this->stats['nama'])[0] }}</span></h1>
                            </div>
                            
                            <div class="mt-12 bg-white/5 backdrop-blur-md rounded-3xl p-6 border border-white/10">
                                <div class="flex justify-between items-end mb-4">
                                    <div>
                                        <p class="text-[9px] font-black uppercase tracking-widest text-indigo-300">Level Keanggotaan</p>
                                        <h4 class="text-xl font-black uppercase">{{ $this->stats['level'] }}</h4>
                                    </div>
                                    <p class="text-xs font-bold text-white/50">{{ number_format($this->stats['poin']) }} / 10.000 XP</p>
                                </div>
                                <div class="w-full bg-white/10 h-2 rounded-full overflow-hidden">
                                    <div class="bg-gradient-to-r from-indigo-500 to-cyan-400 h-full transition-all duration-1000 shadow-[0_0_10px_rgba(99,102,241,0.5)]" style="width: {{ $this->stats['progres_level'] }}%"></div>
                                </div>
                                <p class="text-[9px] font-bold text-white/40 mt-3 uppercase tracking-widest text-center">Tingkatkan belanja Anda untuk meraih keunggulan Member Gold</p>
                            </div>
                        </div>
                    </div>

                    <!-- Digital Wallet Card -->
                    <div class="bg-indigo-600 rounded-[3rem] p-8 text-white relative overflow-hidden shadow-xl shadow-indigo-500/30 group">
                        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
                        <div class="relative z-10 flex flex-col justify-between h-full">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-indigo-200">Saldo Digital</span>
                                    <i class="fa-solid fa-bolt-lightning text-yellow-400 animate-pulse"></i>
                                </div>
                                <h3 class="text-3xl font-black tracking-tight">Rp{{ number_format($this->stats['saldo'], 0, ',', '.') }}</h3>
                            </div>

                            <div class="mt-8 space-y-4">
                                <p class="text-[9px] font-black uppercase tracking-widest text-indigo-200 border-b border-indigo-500/50 pb-2">Mutasi Terakhir</p>
                                @forelse($this->transaksiDompet as $trx)
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-bold text-indigo-100">Top Up Digital</span>
                                    <span class="text-[10px] font-black text-emerald-400">+{{ number_format($trx->jumlah_bayar, 0, ',', '.') }}</span>
                                </div>
                                @empty
                                <p class="text-[10px] italic text-indigo-300">Belum ada riwayat saldo</p>
                                @endforelse
                            </div>

                            <a href="{{ route('pelanggan.dompet') }}" wire:navigate class="mt-8 w-full py-4 bg-white text-indigo-600 rounded-2xl text-[10px] font-black uppercase tracking-widest text-center shadow-lg group-hover:scale-105 transition-transform">Kelola Saldo</a>
                        </div>
                    </div>
                </div>

                <!-- Live Order Timeline (Advanced Status) -->
                @if($this->pesananBerjalan)
                <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-2 h-full bg-indigo-600"></div>
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-ping"></span>
                                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Pelacakan Pesanan <span class="text-indigo-600">Aktif</span></h3>
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nomor Faktur: #{{ $this->pesananBerjalan->nomor_faktur }}</p>
                        </div>
                        <a href="{{ route('pesanan.lacak', $this->pesananBerjalan->nomor_faktur) }}" wire:navigate class="px-6 py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg shadow-slate-900/20">Lacak Kurir</a>
                    </div>

                    <div class="relative px-4">
                        <div class="absolute top-6 left-0 w-full h-1 bg-slate-100 rounded-full"></div>
                        <div class="absolute top-6 left-0 h-1 bg-indigo-600 rounded-full transition-all duration-1000" style="width: {{ 
                            match($this->pesananBerjalan->status_pesanan) {
                                'menunggu' => '12.5%',
                                'dibayar' => '37.5%',
                                'diproses' => '62.5%',
                                'dikirim' => '87.5%',
                                default => '0%'
                            }
                        }}%"></div>
                        
                        <div class="relative z-10 flex justify-between">
                            @foreach([['key' => 'menunggu', 'icon' => 'fa-wallet', 'label' => 'Menunggu'], ['key' => 'dibayar', 'icon' => 'fa-shield-check', 'label' => 'Diverifikasi'], ['key' => 'diproses', 'icon' => 'fa-box-open', 'label' => 'Dipacking'], ['key' => 'dikirim', 'icon' => 'fa-truck-fast', 'label' => 'Dalam Jalan']] as $step)
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-lg shadow-lg border-4 border-white transition-all duration-500 {{ $this->pesananBerjalan->status_pesanan == $step['key'] ? 'bg-indigo-600 text-white scale-125' : 'bg-slate-100 text-slate-400' }}">
                                    <i class="fa-solid {{ $step['icon'] }}"></i>
                                </div>
                                <span class="text-[9px] font-black uppercase tracking-widest mt-6 {{ $this->pesananBerjalan->status_pesanan == $step['key'] ? 'text-indigo-600' : 'text-slate-400' }}">{{ $step['label'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Statistik Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                    <a href="{{ route('pesanan.riwayat') }}" wire:navigate class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group">
                        <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg mb-3 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <h4 class="text-2xl font-black text-slate-900">{{ $this->stats['pesanan_aktif'] }}</h4>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Pesanan Aktif</p>
                    </a>

                    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center text-lg mb-3">
                            <i class="fa-solid fa-coins"></i>
                        </div>
                        <h4 class="text-2xl font-black text-slate-900">{{ number_format($this->stats['poin']) }}</h4>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Poin Reward</p>
                    </div>

                    <a href="{{ route('pelanggan.voucher') }}" wire:navigate class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group">
                        <div class="w-10 h-10 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center text-lg mb-3 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-ticket"></i>
                        </div>
                        <h4 class="text-2xl font-black text-slate-900">{{ $this->stats['voucher_tersedia'] }}</h4>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Voucher</p>
                    </a>

                    <a href="{{ route('bantuan') }}" wire:navigate class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group">
                        <div class="w-10 h-10 bg-violet-50 text-violet-500 rounded-xl flex items-center justify-center text-lg mb-3 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h4 class="text-2xl font-black text-slate-900">{{ $this->stats['tiket_terbuka'] }}</h4>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Tiket Support</p>
                    </a>
                </div>

                <!-- Pesanan Terakhir -->
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Pesanan <span class="text-indigo-600">Terbaru</span></h3>
                            <p class="text-xs font-bold text-slate-400 mt-1">Lacak status belanjaan Anda secara real-time.</p>
                        </div>
                        <a href="{{ route('pesanan.riwayat') }}" wire:navigate class="px-5 py-2 bg-slate-50 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            Lihat Semua
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th class="px-8 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest">ID Pesanan</th>
                                    <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                                    <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest">Total</th>
                                    <th class="px-8 py-4 text-right text-[9px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($this->pesananTerakhir as $pesanan)
                                <tr class="hover:bg-slate-50/50 transition-colors group cursor-pointer" onclick="window.location.href='{{ route('pesanan.lacak', $pesanan->nomor_faktur) }}'">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xs group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                                <i class="fa-solid fa-receipt"></i>
                                            </div>
                                            <span class="font-mono text-xs font-black text-indigo-600 group-hover:underline">#{{ $pesanan->nomor_faktur }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-xs font-bold text-slate-600">{{ $pesanan->dibuat_pada->translatedFormat('d M Y') }}</td>
                                    <td class="px-6 py-5 text-xs font-black text-slate-900">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                    <td class="px-8 py-5 text-right">
                                        @php
                                            $statusColor = match($pesanan->status_pesanan) {
                                                'menunggu' => 'bg-amber-100 text-amber-600',
                                                'dibayar' => 'bg-blue-100 text-blue-600',
                                                'diproses' => 'bg-indigo-100 text-indigo-600',
                                                'dikirim' => 'bg-purple-100 text-purple-600',
                                                'selesai' => 'bg-emerald-100 text-emerald-600',
                                                'dibatalkan' => 'bg-rose-100 text-rose-600',
                                                default => 'bg-slate-100 text-slate-600'
                                            };
                                        @endphp
                                        <span class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $statusColor }}">
                                            {{ $pesanan->status_pesanan }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-16 text-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fa-solid fa-cart-shopping text-slate-300 text-2xl"></i>
                                        </div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Belum ada riwayat pesanan.</p>
                                        <a href="/katalog" class="inline-block mt-4 text-xs font-black text-indigo-600 hover:underline">Mulai Belanja</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Rekomendasi Horizontal -->
                <div>
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6">Rekomendasi <span class="text-indigo-600">Spesial</span></h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($this->rekomendasi as $p)
                        <a href="{{ route('produk.detail', $p->slug) }}" wire:navigate class="flex items-center gap-4 bg-white p-4 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-100 transition-all group hover:-translate-y-1">
                            <div class="w-24 h-24 bg-slate-50 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-100 group-hover:scale-95 transition-transform relative">
                                <img src="{{ $p->gambarUtama?->url ?? 'https://placehold.co/200x200?text=Produk' }}" alt="{{ $p->nama }}" class="w-full h-full object-cover">
                                @if($p->harga_jual < $p->harga_modal)
                                    <span class="absolute top-2 left-2 px-2 py-0.5 bg-rose-500 text-white text-[8px] font-black rounded uppercase">Promo</span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[9px] font-black text-indigo-500 uppercase tracking-widest mb-1">{{ $p->kategori->nama }}</p>
                                <h4 class="text-xs font-black text-slate-900 uppercase leading-snug mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $p->nama }}</h4>
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-black text-slate-900 tracking-tight">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</p>
                                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                        <i class="fa-solid fa-arrow-right text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
