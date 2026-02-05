<div class="space-y-8 pb-20">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">Executive <span class="text-indigo-600">Overview</span></h1>
            <p class="text-slate-500 font-medium">Pantauan kinerja bisnis real-time dan analitik strategis.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-xs font-black uppercase tracking-widest">
                Periode: {{ now()->translatedFormat('F Y') }}
            </span>
        </div>
    </div>

    <!-- Metrik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Kartu Pendapatan -->
        <div class="bg-white p-6 rounded-[28px] border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="relative z-10">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total Pendapatan</p>
                <h3 class="text-3xl font-black text-slate-900 mb-1">{{ 'Rp ' . number_format($metrik['pendapatan'], 0, ',', '.') }}</h3>
                <div class="flex items-center gap-2">
                    <span class="flex items-center text-xs font-bold {{ $metrik['pertumbuhan'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $metrik['pertumbuhan'] >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}"></path></svg>
                        {{ number_format(abs($metrik['pertumbuhan']), 1) }}%
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold">vs bulan lalu</span>
                </div>
            </div>
            <div class="absolute right-0 top-0 w-32 h-32 bg-indigo-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
            <svg class="absolute right-6 top-6 w-8 h-8 text-indigo-200 z-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>

        <!-- Kartu Pesanan -->
        <div class="bg-white p-6 rounded-[28px] border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="relative z-10">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total Pesanan</p>
                <h3 class="text-3xl font-black text-slate-900 mb-1">{{ number_format($metrik['pesanan']) }}</h3>
                <p class="text-[10px] text-slate-400 font-bold">Transaksi berhasil</p>
            </div>
            <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
            <svg class="absolute right-6 top-6 w-8 h-8 text-emerald-200 z-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>

        <!-- Kartu Produk -->
        <div class="bg-white p-6 rounded-[28px] border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="relative z-10">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Inventaris</p>
                <h3 class="text-3xl font-black text-slate-900 mb-1">{{ number_format($metrik['produk']) }}</h3>
                <p class="text-[10px] text-slate-400 font-bold">SKU Terdaftar</p>
            </div>
            <div class="absolute right-0 top-0 w-32 h-32 bg-cyan-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
            <svg class="absolute right-6 top-6 w-8 h-8 text-cyan-200 z-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>

        <!-- Kartu Pelanggan -->
        <div class="bg-white p-6 rounded-[28px] border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="relative z-10">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Pelanggan</p>
                <h3 class="text-3xl font-black text-slate-900 mb-1">{{ number_format($metrik['pelanggan']) }}</h3>
                <p class="text-[10px] text-slate-400 font-bold">Akun Aktif</p>
            </div>
            <div class="absolute right-0 top-0 w-32 h-32 bg-amber-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
            <svg class="absolute right-6 top-6 w-8 h-8 text-amber-200 z-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
    </div>

    <!-- Area Grafik Analitik -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Grafik Tren Penjualan -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-lg font-black text-slate-900">Tren Pendapatan</h3>
                <span class="text-xs font-bold text-slate-400 bg-slate-50 px-3 py-1 rounded-full">7 Hari Terakhir</span>
            </div>
            <div id="chart-pendapatan" class="w-full h-80"></div>
        </div>

        <!-- Grafik Kategori -->
        <div class="lg:col-span-1 bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm">
            <h3 class="text-lg font-black text-slate-900 mb-8">Dominasi Kategori</h3>
            <div id="chart-kategori" class="w-full h-64 flex items-center justify-center"></div>
            <div class="mt-6 space-y-3">
                @foreach($grafik['kategori_label'] as $index => $label)
                <div class="flex justify-between items-center text-xs font-bold">
                    <span class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full" style="background-color: {{ ['#4f46e5', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'][$index] ?? '#ccc' }}"></span>
                        {{ $label }}
                    </span>
                    <span class="text-slate-500">Rp {{ number_format($grafik['kategori_data'][$index]/1000000, 1) }}Jt</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Tabel & Aktivitas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Tabel Pesanan Terbaru -->
        <div class="lg:col-span-2 bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-black text-slate-900">Pesanan Masuk</h3>
                <a href="/admin/pesanan" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-slate-50">
                        @foreach($pesananTerbaru as $p)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-4">
                                <span class="block text-sm font-bold text-slate-900">{{ $p->pengguna->nama }}</span>
                                <span class="text-xs text-slate-400">Inv: {{ $p->nomor_invoice }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $p->status_pembayaran == 'lunas' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                    {{ $p->status_pembayaran }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right">
                                <span class="text-sm font-black text-slate-900">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Log Aktivitas Stream -->
        <div class="lg:col-span-1 bg-white rounded-[32px] border border-slate-100 shadow-sm p-8">
            <h3 class="text-lg font-black text-slate-900 mb-6">Aktivitas Sistem</h3>
            <div class="space-y-6 relative">
                <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-slate-100"></div>
                @foreach($logTerbaru as $log)
                <div class="relative pl-8">
                    <div class="absolute left-0 top-1.5 w-6 h-6 bg-white border-2 border-indigo-100 rounded-full flex items-center justify-center z-10">
                        <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                    </div>
                    <p class="text-xs font-bold text-slate-400 mb-1">{{ $log->waktu->diffForHumans() }}</p>
                    <p class="text-sm font-bold text-slate-800 leading-snug">
                        {{ $log->pengguna->nama ?? 'Sistem' }}
                        <span class="text-slate-500 font-medium text-xs block mt-1">{{ $log->pesan_naratif }}</span>
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Script Grafik (ApexCharts) -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Grafik Tren
            var optionsTren = {
                series: [{
                    name: 'Pendapatan',
                    data: @json($grafik['tren_data'])
                }],
                chart: { type: 'area', height: 320, toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans, sans-serif' },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                xaxis: { categories: @json($grafik['tren_label']), axisBorder: { show: false }, axisTicks: { show: false } },
                yaxis: { labels: { formatter: (value) => { return (value / 1000000).toFixed(1) + "M" } } },
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.1, stops: [0, 90, 100] } },
                colors: ['#4f46e5'],
                grid: { borderColor: '#f1f5f9', strokeDashArray: 4 }
            };
            var chartTren = new ApexCharts(document.querySelector("#chart-pendapatan"), optionsTren);
            chartTren.render();

            // Grafik Kategori
            var optionsKategori = {
                series: @json($grafik['kategori_data']),
                labels: @json($grafik['kategori_label']),
                chart: { type: 'donut', height: 250, fontFamily: 'Plus Jakarta Sans, sans-serif' },
                colors: ['#4f46e5', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'],
                legend: { show: false },
                dataLabels: { enabled: false },
                plotOptions: { pie: { donut: { size: '75%', labels: { show: true, total: { show: true, label: 'Total', formatter: function (w) { return w.globals.seriesTotals.reduce((a, b) => { return a + b }, 0) > 1000000 ? (w.globals.seriesTotals.reduce((a, b) => { return a + b }, 0) / 1000000).toFixed(1) + "M" : w.globals.seriesTotals.reduce((a, b) => { return a + b }, 0) } } } } } }
            };
            var chartKategori = new ApexCharts(document.querySelector("#chart-kategori"), optionsKategori);
            chartKategori.render();
        });
    </script>
</div>