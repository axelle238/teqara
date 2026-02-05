<div>
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 shadow-xl mb-8">
        <div class="relative z-10">
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Selamat Datang, {{ auth()->user()->nama }}! 👋</h1>
            <p class="mt-2 text-slate-300 max-w-xl">Ini adalah pusat kendali TEQARA Enterprise. Pantau performa penjualan dan inventaris Anda secara real-time hari ini.</p>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-cyan-500/20 to-transparent"></div>
        <div class="absolute -right-10 -bottom-10 h-64 w-64 rounded-full bg-cyan-500/10 blur-3xl"></div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Revenue -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ 'Rp ' . number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-emerald-600 font-bold flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    +12.5%
                </span>
                <span class="text-slate-400 ml-2">dari bulan lalu</span>
            </div>
        </div>

        <!-- Orders -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pesanan Baru</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $pesananBaru }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-slate-500">Perlu diproses segera</span>
            </div>
        </div>

        <!-- Products -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Stok Menipis</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stokMenipis }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <a href="/admin/produk" class="text-orange-600 font-bold hover:underline">Lihat Detail &rarr;</a>
            </div>
        </div>

        <!-- Customers (Placeholder logic) -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Pelanggan</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">1,240</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-purple-600 font-bold">+5</span>
                <span class="text-slate-400 ml-2">hari ini</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Chart Section -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-900 mb-6">Tren Penjualan (7 Hari)</h3>
                <div id="grafik-penjualan" class="w-full" style="min-height: 350px;"></div>
            </div>

            <!-- Recent Orders Table -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Transaksi Terakhir</h3>
                    <a href="/admin/pesanan" class="text-xs font-black text-cyan-600 uppercase tracking-widest hover:underline">Semua Pesanan &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Invoice</th>
                                <th class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelanggan</th>
                                <th class="px-4 py-3 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($pesananTerbaru as $p)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-4 text-sm font-bold text-slate-900">{{ $p->nomor_invoice }}</td>
                                <td class="px-4 py-4 text-sm text-slate-500 font-medium">{{ $p->pengguna->nama }}</td>
                                <td class="px-4 py-4 text-sm font-black text-slate-900 text-right">{{ 'Rp ' . number_format($p->total_harga/1000, 0) . 'k' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Activity Log Stream -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col h-full">
                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse"></span>
                    Log Aktivitas Naratif
                </h3>
                <div class="flex-1 space-y-6">
                    @foreach($logTerbaru as $log)
                    <div class="relative pl-6 pb-6 border-l border-slate-100 last:border-none">
                        <div class="absolute -left-[5px] top-1 w-2 h-2 rounded-full bg-slate-200"></div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-tighter mb-1">{{ $log->waktu->diffForHumans() }}</p>
                        <p class="text-sm font-medium text-slate-600 leading-relaxed">
                            <span class="font-black text-slate-900">{{ $log->pengguna->nama ?? 'Sistem' }}</span>
                            {{ $log->pesan_naratif }}
                        </p>
                    </div>
                    @endforeach
                </div>
                <a href="/admin/log" class="mt-6 block w-full py-3 text-center bg-slate-50 rounded-xl text-xs font-black text-slate-500 hover:text-cyan-600 hover:bg-cyan-50 transition-all uppercase tracking-widest">Buka Audit Trail Lengkap</a>
            </div>
        </div>
    </div>

    <!-- Script Chart -->
    <script>
        document.addEventListener('livewire:navigated', () => {
            const options = {
                series: [{
                    name: 'Omzet',
                    data: @json($dataTren)
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    fontFamily: 'Plus Jakarta Sans, sans-serif',
                    toolbar: { show: false },
                    animations: { enabled: true }
                },
                colors: ['#06b6d4'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                xaxis: {
                    categories: @json($labelTren),
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        formatter: (val) => { return val >= 1000000 ? (val/1000000).toFixed(1) + ' Jt' : val }
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                },
                tooltip: {
                    y: { formatter: (val) => { return "Rp " + val.toLocaleString('id-ID') } }
                }
            };

            if(document.querySelector("#grafik-penjualan")) {
                const chart = new ApexCharts(document.querySelector("#grafik-penjualan"), options);
                chart.render();
            }
        });
    </script>
</div>
