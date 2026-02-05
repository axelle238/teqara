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
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Omzet Lunas</p>
                <h3 class="text-3xl font-black text-slate-900 mb-1">Rp {{ number_format($metrik['pendapatan'], 0, ',', '.') }}</h3>
                <div class="flex items-center gap-2">
                    <span class="flex items-center text-xs font-bold {{ $metrik['pertumbuhan'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $metrik['pertumbuhan'] >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}"></path></svg>
                        {{ number_format(abs($metrik['pertumbuhan']), 1) }}%
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold">vs bulan lalu</span>
                </div>
            </div>
            <div class="absolute right-0 top-0 w-32 h-32 bg-indigo-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
        </div>

        <!-- Ringkasan Stok -->
        <div class="bg-white p-6 rounded-[28px] border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="relative z-10">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Status Inventaris</p>
                <h3 class="text-3xl font-black text-slate-900 mb-1">{{ number_format($metrik['produk']) }} <span class="text-xs text-slate-400">SKU</span></h3>
                <p class="text-[10px] {{ $statsManajemen['stok_menipis'] > 0 ? 'text-red-500 animate-pulse' : 'text-slate-400' }} font-bold uppercase tracking-tighter">
                    {{ $statsManajemen['stok_menipis'] }} Perangkat Stok Kritis
                </p>
            </div>
            <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
        </div>

        <!-- Alur Pesanan -->
        <div class="bg-white p-6 rounded-[28px] border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="relative z-10">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Antrian Logistik</p>
                <h3 class="text-3xl font-black text-slate-900 mb-1">{{ number_format($statsManajemen['perlu_dikirim']) }} <span class="text-xs text-slate-400">UNIT</span></h3>
                <p class="text-[10px] text-amber-600 font-bold uppercase tracking-tighter">
                    {{ $statsManajemen['menunggu_bayar'] }} Menunggu Pembayaran
                </p>
            </div>
            <div class="absolute right-0 top-0 w-32 h-32 bg-amber-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
        </div>

        <!-- SDM & Keamanan -->
        <div class="bg-white p-6 rounded-[28px] border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="relative z-10">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">SDM & Keamanan</p>
                <h3 class="text-3xl font-black text-slate-900 mb-1">{{ number_format($statsManajemen['total_karyawan']) }} <span class="text-xs text-slate-400">STAFF</span></h3>
                <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-tighter">Sistem Terproteksi</p>
            </div>
            <div class="absolute right-0 top-0 w-32 h-32 bg-rose-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
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
        <div class="lg:col-span-1 bg-white rounded-[32px] border border-slate-100 shadow-sm p-8" wire:poll.10s>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-black text-slate-900">Aktivitas Sistem</h3>
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
            </div>
            <div class="space-y-6 relative">
                <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-slate-100"></div>
                @foreach($logTerbaru as $log)
                <div class="relative pl-8 animate-in fade-in slide-in-from-left-4 duration-500">
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