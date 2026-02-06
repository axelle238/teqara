<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-10">
    
    <!-- Top Section: Welcome & Quick Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Welcome Banner -->
        <div class="lg:col-span-2 bg-gradient-to-r from-slate-900 to-slate-800 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-slate-900/10 border border-slate-700">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-cyan-500/10 rounded-full blur-3xl -ml-10 -mb-10 pointer-events-none"></div>

            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight mb-2">Selamat Datang, {{ auth()->user()->nama ?? 'Administrator' }}</h1>
                    <p class="text-slate-400 text-sm md:text-base font-medium max-w-xl">
                        Sistem berjalan optimal. Anda memiliki <span class="text-white font-bold underline decoration-indigo-500 underline-offset-4">{{ $pesanan['perlu_diproses'] }} pesanan baru</span> yang membutuhkan perhatian segera.
                    </p>
                </div>
                
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('admin.produk.tambah') }}" wire:navigate class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-500/30">
                        <i class="fa-solid fa-plus"></i> Produk Baru
                    </a>
                    <a href="{{ route('admin.pesanan.daftar') }}" wire:navigate class="flex items-center gap-2 px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl text-sm font-bold transition-all border border-slate-600">
                        <i class="fa-solid fa-list-check"></i> Kelola Pesanan
                    </a>
                    <a href="{{ route('admin.laporan.pusat') }}" wire:navigate class="flex items-center gap-2 px-5 py-2.5 bg-transparent hover:bg-white/5 text-slate-300 hover:text-white rounded-xl text-sm font-bold transition-all border border-slate-600">
                        <i class="fa-solid fa-file-pdf"></i> Unduh Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Realtime Clock & Status -->
        <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-indigo-50 rounded-bl-[100px] -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-6">
                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest border border-emerald-200">
                        System Online
                    </span>
                    <i class="fa-solid fa-server text-slate-300 text-xl"></i>
                </div>
                <div class="space-y-1">
                    <p class="text-4xl font-black text-slate-800 tracking-tighter" id="clock-widget">{{ now()->format('H:i') }}</p>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-slate-100 relative z-10">
                <div class="flex items-center gap-3">
                    <div class="flex -space-x-2">
                        @foreach($aktivitas->take(3) as $a)
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-[10px] text-slate-600 font-bold" title="{{ $a->pengguna->nama ?? 'System' }}">
                            {{ substr($a->pengguna->nama ?? 'S', 0, 1) }}
                        </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-slate-500 font-medium">
                        <span class="font-bold text-slate-800">{{ $keamanan['log_hari_ini'] }} aktivitas</span> tercatat hari ini.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition-all group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-sack-dollar text-xl"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase bg-slate-50 px-2 py-1 rounded border border-slate-100">Hari Ini</span>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Pendapatan Bersih</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($keuangan['pendapatan_hari_ini'], 0, ',', '.') }}</h3>
            </div>
             <div class="mt-4 flex items-center gap-2 text-xs font-bold text-amber-600 bg-amber-50 w-fit px-2 py-1 rounded-lg">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Verifikasi: {{ $keuangan['verifikasi_tertunda'] }}</span>
            </div>
        </div>

        <!-- Products Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition-all group">
             <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-box-open text-xl"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase bg-slate-50 px-2 py-1 rounded border border-slate-100">Inventaris</span>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Produk</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($produk['total_unit']) }} <span class="text-sm text-slate-400 font-bold">Unit</span></h3>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs font-bold {{ $produk['stok_kritis'] > 0 ? 'text-rose-600 bg-rose-50' : 'text-emerald-600 bg-emerald-50' }} w-fit px-2 py-1 rounded-lg">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>Stok Kritis: {{ $produk['stok_kritis'] }}</span>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition-all group">
             <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-cart-shopping text-xl"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase bg-slate-50 px-2 py-1 rounded border border-slate-100">Transaksi</span>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Pesanan Masuk</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $pesanan['hari_ini'] }} <span class="text-sm text-slate-400 font-bold">Faktur</span></h3>
            </div>
             <div class="mt-4 flex items-center gap-2 text-xs font-bold text-blue-600 bg-blue-50 w-fit px-2 py-1 rounded-lg">
                <i class="fa-solid fa-spinner"></i>
                <span>Perlu Proses: {{ $pesanan['perlu_diproses'] }}</span>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition-all group">
             <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase bg-slate-50 px-2 py-1 rounded border border-slate-100">Pelanggan</span>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Member</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($pelanggan['total_member']) }} <span class="text-sm text-slate-400 font-bold">Orang</span></h3>
            </div>
             <div class="mt-4 flex items-center gap-2 text-xs font-bold text-purple-600 bg-purple-50 w-fit px-2 py-1 rounded-lg">
                <i class="fa-solid fa-user-plus"></i>
                <span>Baru: +{{ $pelanggan['member_baru'] }}</span>
            </div>
        </div>
    </div>

    <!-- Charts & Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sales Chart -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Analitik Pendapatan</h3>
                    <p class="text-sm text-slate-400 font-medium">Tren penjualan 7 hari terakhir</p>
                </div>
                <button class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                    <i class="fa-solid fa-ellipsis"></i>
                </button>
            </div>
            
            <div id="revenueChart" class="w-full h-80"></div>
        </div>

        <!-- Operational Radar -->
        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm flex flex-col">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Status Operasional</h3>
            
            <div class="space-y-6 flex-1">
                <!-- Logistic Item -->
                <div class="flex items-center gap-4 group cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center transition-colors group-hover:bg-orange-600 group-hover:text-white">
                        <i class="fa-solid fa-truck-fast text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-bold text-slate-700">Logistik</span>
                            <span class="text-xs font-bold text-orange-600">{{ $logistik['pengiriman_aktif'] }} Dikirim</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5">
                            <div class="bg-orange-500 h-1.5 rounded-full" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

                <!-- CS Item -->
                <div class="flex items-center gap-4 group cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center transition-colors group-hover:bg-pink-600 group-hover:text-white">
                        <i class="fa-solid fa-headset text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-bold text-slate-700">Support</span>
                            <span class="text-xs font-bold text-pink-600">{{ $cs['tiket_terbuka'] }} Menunggu</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5">
                            <div class="bg-pink-500 h-1.5 rounded-full" style="width: 30%"></div>
                        </div>
                    </div>
                </div>

                <!-- HRD Item -->
                <div class="flex items-center gap-4 group cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center transition-colors group-hover:bg-sky-600 group-hover:text-white">
                        <i class="fa-solid fa-users-gear text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-bold text-slate-700">HRD</span>
                            <span class="text-xs font-bold text-sky-600">{{ $hrd['staf_aktif'] }} Aktif</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5">
                            <div class="bg-sky-500 h-1.5 rounded-full" style="width: 90%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.laporan.pusat') }}" class="mt-6 w-full py-3 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm text-center hover:bg-slate-50 transition-colors">
                Lihat Laporan Lengkap
            </a>
        </div>
    </div>

    <!-- Recent Activity Log (Enterprise Table) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Jejak Audit</h3>
                <p class="text-sm text-slate-400 font-medium">Log aktivitas sistem terbaru</p>
            </div>
            <a href="{{ route('admin.pengaturan.log') }}" wire:navigate class="text-indigo-600 hover:text-indigo-800 text-sm font-bold flex items-center gap-2">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="px-8 py-4 font-black">Waktu</th>
                        <th class="px-8 py-4 font-black">Pengguna</th>
                        <th class="px-8 py-4 font-black">Aktivitas</th>
                        <th class="px-8 py-4 text-right font-black">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($aktivitas as $log)
                    <tr class="hover:bg-indigo-50/30 transition-colors">
                        <td class="px-8 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-slate-700">{{ $log->waktu->translatedFormat('d M Y') }}</div>
                            <div class="text-xs text-slate-400 font-medium">{{ $log->waktu->translatedFormat('H:i') }} WIB</div>
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold border border-indigo-200">
                                    {{ substr($log->pengguna->nama ?? 'S', 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-slate-700">{{ $log->pengguna->nama ?? 'Sistem' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <p class="text-sm text-slate-600 font-medium truncate max-w-xs" title="{{ $log->pesan_naratif }}">{{ $log->pesan_naratif }}</p>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500 uppercase">
                                {{ $log->aksi }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script for Clock & Chart -->
    <script>
        // Clock
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('clock-widget').textContent = `${hours}:${minutes}`;
        }
        setInterval(updateClock, 1000);

        // ApexCharts
        document.addEventListener('livewire:navigated', () => {
            renderCharts();
        });

        // Initial Load
        renderCharts();

        function renderCharts() {
            const chartData = @json($grafik['data']);
            const chartLabels = @json($grafik['label']);
            
            const options = {
                series: [{
                    name: 'Pendapatan',
                    data: chartData
                }],
                chart: {
                    type: 'area',
                    height: 320,
                    fontFamily: 'Plus Jakarta Sans, sans-serif',
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                colors: ['#6366f1'],
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                xaxis: {
                    categories: chartLabels,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { colors: '#94a3b8', fontSize: '12px', fontWeight: 600 } }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#94a3b8', fontSize: '12px', fontWeight: 600 },
                        formatter: (value) => { return 'Rp ' + (value / 1000).toFixed(0) + 'k' }
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } }
                },
                tooltip: {
                    theme: 'dark',
                    y: { formatter: function (val) { return "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); } }
                }
            };

            if(document.querySelector("#revenueChart")) {
                const chart = new ApexCharts(document.querySelector("#revenueChart"), options);
                chart.render();
            }
        }
    </script>
</div>