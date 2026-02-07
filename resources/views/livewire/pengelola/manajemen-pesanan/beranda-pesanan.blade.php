<div class="space-y-10 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Section -->
    <div class="relative bg-white rounded-[3rem] p-10 overflow-hidden shadow-sm border border-slate-100">
        <!-- Abstract Background -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-amber-50 rounded-full blur-3xl -mr-20 -mt-20 opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-orange-50 rounded-full blur-3xl -ml-10 -mb-10 opacity-60 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-50 border border-amber-100">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Sentral Transaksi</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase">
                    Manajemen <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-orange-500">Pesanan</span>
                </h1>
                <p class="text-slate-500 font-medium text-lg max-w-2xl leading-relaxed">
                    Pantau arus kas masuk dan efisiensi pemenuhan pesanan pelanggan secara real-time.
                </p>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('pengelola.pesanan.verifikasi') }}" wire:navigate class="group flex items-center gap-3 px-8 py-4 bg-amber-500 text-white rounded-2xl shadow-lg shadow-amber-500/30 hover:bg-amber-600 hover:scale-105 transition-all duration-300">
                    <i class="fa-solid fa-money-check-dollar text-lg group-hover:rotate-12 transition-transform"></i>
                    <span class="font-black text-xs uppercase tracking-widest">Verifikasi Bayar</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Key Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Omzet -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-amber-500/20 rounded-full blur-3xl group-hover:bg-amber-500/30 transition-colors"></div>
            <div class="relative z-10 text-white">
                <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-amber-400 mb-6 backdrop-blur-sm">
                    <i class="fa-solid fa-sack-dollar text-2xl"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Total Omzet</p>
                <h3 class="text-3xl font-black tracking-tighter">Rp {{ number_format($stats['omzet_total'] / 1000000, 1, ',', '.') }}<span class="text-lg text-slate-500">JT</span></h3>
                <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-emerald-400 bg-emerald-500/10 w-fit px-3 py-1 rounded-full border border-emerald-500/20">
                    AVG: Rp {{ number_format($stats['rata_rata_order'] / 1000, 0) }}K
                </div>
            </div>
        </div>

        <!-- Menunggu Bayar -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-orange-50 rounded-full blur-2xl group-hover:bg-orange-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-2xl mb-6 shadow-sm">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Menunggu Bayar</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($stats['menunggu_bayar']) }} <span class="text-xs text-slate-400 font-bold uppercase ml-1">Unit</span></h3>
            </div>
        </div>

        <!-- Perlu Dikirim -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-blue-50 rounded-full blur-2xl group-hover:bg-blue-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mb-6 shadow-sm">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Siap Kirim</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($stats['perlu_dikirim']) }} <span class="text-xs text-slate-400 font-bold uppercase ml-1">Paket</span></h3>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-6 shadow-sm">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Selesai (Bulan Ini)</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($stats['selesai_bulan_ini']) }} <span class="text-xs text-slate-400 font-bold uppercase ml-1">Done</span></h3>
            </div>
        </div>
    </div>

    <!-- Analytics & Live Feed -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sales Chart -->
        <div class="lg:col-span-2 bg-white rounded-[3rem] p-10 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Tren Transaksi</h3>
                    <p class="text-xs font-bold text-slate-400 mt-1">Volume penjualan vs Pendapatan (7 Hari)</p>
                </div>
                <button class="p-2 bg-slate-50 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors">
                    <i class="fa-solid fa-chart-line"></i>
                </button>
            </div>
            <div id="chartPesanan" class="w-full h-80"></div>
        </div>

        <!-- Live Feed -->
        <div class="bg-white rounded-[3rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Pesanan Masuk</h3>
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
            </div>
            <div class="flex-1 overflow-y-auto custom-scrollbar p-2 space-y-2">
                @forelse($feed as $p)
                <div class="p-4 rounded-2xl hover:bg-slate-50 transition-colors group cursor-default border border-transparent hover:border-slate-100">
                    <div class="flex justify-between items-start mb-2">
                        <span class="font-mono text-xs font-bold text-slate-500">#{{ $p->nomor_faktur }}</span>
                        <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-md 
                            {{ $p->status_pembayaran == 'lunas' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                            {{ $p->status_pembayaran }}
                        </span>
                    </div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-xs font-black text-indigo-600">
                            {{ substr($p->pengguna->nama ?? 'U', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $p->pengguna->nama ?? 'Pelanggan Umum' }}</p>
                            <p class="text-[10px] text-slate-400 font-medium">{{ $p->dibuat_pada->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between items-end">
                        <p class="text-sm font-black text-slate-900">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</p>
                        <a href="{{ route('pengelola.pesanan.detail', $p->id) }}" wire:navigate class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm">
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-400 text-xs font-medium">Belum ada pesanan baru hari ini.</div>
                @endforelse
            </div>
            <div class="p-4 border-t border-slate-50">
                <a href="{{ route('pengelola.pesanan.daftar') }}" wire:navigate class="block w-full py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest text-center hover:bg-slate-800 transition-all">Lihat Semua</a>
            </div>
        </div>
    </div>

    <!-- Chart Script -->
    <script>
        document.addEventListener('livewire:navigated', () => {
            const chartData = @json($chart);
            
            if(document.querySelector("#chartPesanan")) {
                const options = {
                    series: [{
                        name: 'Pendapatan (Rp)',
                        type: 'area',
                        data: chartData.omzet
                    }, {
                        name: 'Jumlah Pesanan',
                        type: 'column',
                        data: chartData.pesanan
                    }],
                    chart: {
                        height: 320,
                        type: 'line',
                        fontFamily: 'Plus Jakarta Sans, sans-serif',
                        toolbar: { show: false }
                    },
                    stroke: { width: [3, 0], curve: 'smooth' },
                    plotOptions: {
                        bar: { columnWidth: '30%', borderRadius: 6 }
                    },
                    fill: {
                        opacity: [0.1, 1],
                        gradient: {
                            inverseColors: false,
                            shade: 'light',
                            type: "vertical",
                            opacityFrom: 0.5,
                            opacityTo: 0.1,
                            stops: [0, 100, 100, 100]
                        }
                    },
                    colors: ['#f59e0b', '#3b82f6'], // Amber & Blue
                    dataLabels: { enabled: false },
                    legend: { show: true },
                    xaxis: {
                        categories: chartData.labels,
                        labels: { style: { colors: '#64748b', fontSize: '11px', fontWeight: 700 } },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: [
                        {
                            title: { text: 'Pendapatan', style: { fontSize: '10px', fontWeight: 600, color: '#94a3b8' } },
                            labels: { formatter: (val) => { return (val/1000000).toFixed(1) + 'M' } }
                        },
                        {
                            opposite: true,
                            title: { text: 'Pesanan', style: { fontSize: '10px', fontWeight: 600, color: '#94a3b8' } }
                        }
                    ],
                    grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                    tooltip: { theme: 'dark' }
                };

                const chart = new ApexCharts(document.querySelector("#chartPesanan"), options);
                chart.render();
            }
        });
    </script>
</div>
