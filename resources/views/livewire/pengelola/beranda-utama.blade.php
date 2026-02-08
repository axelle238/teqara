<div class="space-y-8 animate-in fade-in duration-700 pb-20" wire:poll.30s>
    
    <!-- HEADER: WELCOME & EXECUTIVE SUMMARY -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Main Card -->
        <div class="lg:col-span-3 bg-slate-900 rounded-[3rem] p-8 text-white relative overflow-hidden flex flex-col justify-between min-h-[200px] shadow-2xl group">
            <div class="absolute top-0 right-0 w-80 h-80 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-full blur-[80px] group-hover:bg-indigo-500/30 transition-all duration-1000"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div class="space-y-1">
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full border border-white/10 backdrop-blur-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-[9px] font-black text-emerald-200 uppercase tracking-widest">Sistem Berjalan Normal</span>
                    </span>
                    <h2 class="text-3xl font-black tracking-tight mt-4">Halo, {{ explode(' ', auth()->user()->nama)[0] }}!</h2>
                    <p class="text-slate-400 font-medium text-sm max-w-lg">Ini adalah laporan kinerja eksekutif terkonsolidasi dari seluruh operasional Teqara Enterprise hari ini.</p>
                </div>
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center border border-white/10 text-xl shadow-lg">
                    <i class="fa-solid fa-rocket text-indigo-300"></i>
                </div>
            </div>
            
            <div class="relative z-10 grid grid-cols-3 gap-6 mt-8">
                <div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Pendapatan Hari Ini</p>
                    <p class="text-2xl font-black text-white italic">Rp{{ number_format($this->statistik['pendapatan_hari_ini'], 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Pesanan Baru</p>
                    <p class="text-2xl font-black text-white italic">{{ $this->statistik['pesanan_baru'] }} <span class="text-xs font-normal text-slate-500">Invoice</span></p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Produk Aktif</p>
                    <p class="text-2xl font-black text-white italic">{{ $this->statistik['total_produk'] }} <span class="text-xs font-normal text-slate-500">SKU</span></p>
                </div>
            </div>
        </div>

        <!-- Security Card -->
        <div class="bg-white rounded-[3rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden flex flex-col justify-center gap-4 group">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-sm group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">Security Score</h4>
                    <p class="text-[9px] text-slate-400 uppercase tracking-widest">Kesehatan Sistem</p>
                </div>
            </div>
            <div class="relative flex items-center justify-center py-4">
                <svg class="w-32 h-32 transform -rotate-90">
                    <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="12" fill="transparent" class="text-slate-100" />
                    <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="12" fill="transparent" :stroke-dasharray="351.858" :stroke-dashoffset="351.858 - (351.858 * {{ $this->statistik['skor_keamanan'] }} / 100)" class="text-emerald-500 transition-all duration-1000 ease-out" />
                </svg>
                <div class="absolute inset-0 flex items-center justify-center flex-col">
                    <span class="text-3xl font-black text-slate-900">{{ $this->statistik['skor_keamanan'] }}</span>
                    <span class="text-[8px] font-black uppercase text-emerald-600">Sangat Aman</span>
                </div>
            </div>
            <div class="flex justify-between text-[9px] font-bold text-slate-400 border-t border-slate-50 pt-3">
                <span>Insiden 24J: <span class="text-rose-500">{{ $this->statistik['insiden_keamanan_24j'] }}</span></span>
                <span>API Keys: {{ $this->statistik['total_kunci_api'] }}</span>
            </div>
        </div>
    </div>

    <!-- 15 PILAR MANAJEMEN GRID (Colorful Cards) -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @php
            $pillars = [
                ['title' => 'Toko & Konten', 'count' => $this->statistik['total_konten_halaman'].' Item', 'icon' => 'fa-store', 'color' => 'indigo', 'route' => 'pengelola.toko.beranda'],
                ['title' => 'Produk & Stok', 'count' => $this->statistik['stok_kritis'].' Kritis', 'icon' => 'fa-boxes-stacked', 'color' => 'cyan', 'route' => 'pengelola.produk.beranda'],
                ['title' => 'Pesanan', 'count' => $this->statistik['pesanan_proses'].' Proses', 'icon' => 'fa-cart-shopping', 'color' => 'emerald', 'route' => 'pengelola.pesanan.beranda'],
                ['title' => 'Transaksi', 'count' => $this->statistik['total_transaksi_bulan_ini'].' Bulan Ini', 'icon' => 'fa-file-invoice-dollar', 'color' => 'violet', 'route' => 'pengelola.transaksi.beranda'],
                ['title' => 'Customer Service', 'count' => $this->statistik['tiket_aktif'].' Aktif', 'icon' => 'fa-headset', 'color' => 'rose', 'route' => 'pengelola.cs.beranda'],
                ['title' => 'Logistik', 'count' => $this->statistik['pengiriman_berjalan'].' Kurir', 'icon' => 'fa-truck-fast', 'color' => 'amber', 'route' => 'pengelola.logistik.beranda'],
                ['title' => 'Pelanggan', 'count' => $this->statistik['total_pelanggan'].' Akun', 'icon' => 'fa-users', 'color' => 'blue', 'route' => 'pengelola.pelanggan.beranda'],
                ['title' => 'Vendor', 'count' => $this->statistik['total_mitra_vendor'].' Mitra', 'icon' => 'fa-handshake', 'color' => 'teal', 'route' => 'pengelola.vendor.beranda'],
                ['title' => 'SDM & HRD', 'count' => $this->statistik['total_staf'].' Staf', 'icon' => 'fa-id-card', 'color' => 'fuchsia', 'route' => 'pengelola.hrd.beranda'],
                ['title' => 'Laporan', 'count' => 'Analitik', 'icon' => 'fa-chart-pie', 'color' => 'slate', 'route' => 'pengelola.laporan.beranda'],
                ['title' => 'Sistem', 'count' => 'Stabil', 'icon' => 'fa-server', 'color' => 'sky', 'route' => 'pengelola.sistem.beranda'],
                ['title' => 'API', 'count' => 'Aktif', 'icon' => 'fa-code', 'color' => 'lime', 'route' => 'pengelola.api.pusat'],
                ['title' => 'Keamanan', 'count' => 'Shield', 'icon' => 'fa-lock', 'color' => 'red', 'route' => 'pengelola.keamanan.beranda'],
            ];
        @endphp

        @foreach($pillars as $p)
        <a href="{{ Route::has($p['route']) ? route($p['route']) : '#' }}" class="group bg-white p-5 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-{{ $p['color'] }}-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10 flex flex-col h-full justify-between gap-3">
                <div class="w-10 h-10 rounded-xl bg-{{ $p['color'] }}-100 flex items-center justify-center text-{{ $p['color'] }}-600 shadow-sm group-hover:bg-{{ $p['color'] }}-600 group-hover:text-white transition-colors">
                    <i class="fa-solid {{ $p['icon'] }}"></i>
                </div>
                <div>
                    <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $p['title'] }}</h5>
                    <p class="text-sm font-black text-slate-800 group-hover:text-{{ $p['color'] }}-600 transition-colors">{{ $p['count'] }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <!-- MAIN CONTENT: GRAFIK & DATA (2 Kolom) -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI: GRAFIK & PESANAN (2/3) -->
        <div class="xl:col-span-2 space-y-8">
            <!-- Grafik Analitik -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-black text-lg text-slate-900 uppercase italic tracking-tight">Tren Pendapatan & Order</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">7 Hari Terakhir</p>
                    </div>
                    <button class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:text-indigo-600 flex items-center justify-center"><i class="fa-solid fa-ellipsis"></i></button>
                </div>
                <div id="chart-revenue" class="h-64 w-full"></div>
            </div>

            <!-- Pesanan Terbaru -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-black text-lg text-slate-900 uppercase italic tracking-tight">Pesanan Masuk</h3>
                    <a href="{{ route('pengelola.pesanan.daftar') }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @foreach($this->pesananTerbaru as $order)
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100 group hover:border-indigo-100 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 font-black text-xs shadow-sm">
                                #{{ substr($order->nomor_faktur, -4) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">{{ $order->pengguna->nama }}</h4>
                                <p class="text-[10px] text-slate-400 uppercase tracking-wide">{{ $order->dibuat_pada->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-black text-slate-900 text-sm">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            <span class="text-[9px] font-bold uppercase tracking-widest {{ $order->status_pesanan == 'menunggu' ? 'text-amber-500' : 'text-indigo-500' }}">{{ $order->status_pesanan }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: AUDIT LOG & STATUS (1/3) -->
        <div class="space-y-8">
            <!-- Audit Trail -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 h-full">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="font-black text-lg text-slate-900 uppercase italic tracking-tight">Jejak Audit</h3>
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                </div>
                
                <div class="relative pl-4 border-l border-slate-100 space-y-8">
                    @foreach($this->logAktivitas as $log)
                    <div class="relative group">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-white border-2 border-slate-200 group-hover:border-indigo-500 transition-colors"></div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $log->waktu->format('H:i') }} • {{ $log->pengguna->nama ?? 'Sistem' }}</p>
                            <p class="text-xs font-bold text-slate-800 leading-relaxed">{{ $log->pesan_naratif }}</p>
                            <p class="text-[9px] font-mono text-slate-400 bg-slate-50 inline-block px-1 rounded">{{ $log->aksi }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

@script
<script>
    Livewire.on('refresh-charts', () => {
        initCharts();
    });

    function initCharts() {
        const data = @json($this->dataGrafik);
        
        const options = {
            series: [{
                name: 'Omzet',
                data: data.omzet
            }, {
                name: 'Pesanan',
                data: data.pesanan
            }],
            chart: {
                height: 300,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            xaxis: {
                categories: data.label,
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            colors: ['#6366f1', '#10b981'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
            }
        };

        const chart = new ApexCharts(document.querySelector("#chart-revenue"), options);
        chart.render();
    }

    initCharts();
</script>
@endscript
