<div class="space-y-10 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Section -->
    <div class="relative bg-white rounded-[3rem] p-10 overflow-hidden shadow-sm border border-slate-100">
        <!-- Abstract Background -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-50 rounded-full blur-3xl -mr-20 -mt-20 opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-teal-50 rounded-full blur-3xl -ml-10 -mb-10 opacity-60 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 border border-emerald-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Sistem Inventaris Cerdas</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase">
                    Manajemen <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Produk</span>
                </h1>
                <p class="text-slate-500 font-medium text-lg max-w-2xl leading-relaxed">
                    Pusat kendali stok dan katalog. Pantau pergerakan unit dan performa penjualan secara real-time.
                </p>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('pengelola.produk.tambah') }}" wire:navigate class="group flex items-center gap-3 px-8 py-4 bg-emerald-600 text-white rounded-2xl shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 hover:scale-105 transition-all duration-300">
                    <i class="fa-solid fa-plus text-sm group-hover:rotate-90 transition-transform"></i>
                    <span class="font-black text-xs uppercase tracking-widest">Tambah Unit</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Key Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total SKU -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-indigo-50 rounded-full blur-2xl group-hover:bg-indigo-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-cubes"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Varian (SKU)</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($stats['total_sku']) }}</h3>
            </div>
        </div>

        <!-- Total Fisik -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-cyan-50 rounded-full blur-2xl group-hover:bg-cyan-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Stok Fisik Total</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($stats['total_stok_fisik']) }}</h3>
            </div>
        </div>

        <!-- Stok Kritis -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-rose-50 rounded-full blur-2xl group-hover:bg-rose-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Stok Menipis</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($stats['stok_kritis']) }}</h3>
            </div>
        </div>

        <!-- Kategori & Merek -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div class="text-center">
                    <p class="text-2xl font-black text-slate-900">{{ $stats['total_kategori'] }}</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Kategori</p>
                </div>
                <div class="h-8 w-px bg-slate-200"></div>
                <div class="text-center">
                    <p class="text-2xl font-black text-slate-900">{{ $stats['total_merek'] }}</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Merek</p>
                </div>
            </div>
            <a href="{{ route('pengelola.kategori') }}" wire:navigate class="w-full py-3 bg-slate-50 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest text-center hover:bg-slate-800 hover:text-white transition-colors">
                Kelola Master Data
            </a>
        </div>
    </div>

    <!-- Analytics & Insights -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Chart Distribusi -->
        <div class="lg:col-span-2 bg-white rounded-[3rem] p-10 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Sebaran Katalog</h3>
                    <p class="text-xs font-bold text-slate-400 mt-1">Jumlah SKU per Kategori Utama</p>
                </div>
                <button class="p-2 bg-slate-50 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors">
                    <i class="fa-solid fa-chart-pie"></i>
                </button>
            </div>
            <div id="chartDistribusi" class="w-full h-80"></div>
        </div>

        <!-- Top Selling -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-[3rem] p-10 text-white shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px]"></div>
            
            <h3 class="text-xl font-black uppercase tracking-tight mb-8 relative z-10">Unit Terlaris <span class="text-emerald-400">Top 5</span></h3>
            
            <div class="space-y-6 relative z-10">
                @forelse($terlaris as $index => $item)
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 flex-shrink-0 flex items-center justify-center font-black text-sm bg-white/10 rounded-lg">
                        #{{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-sm truncate">{{ $item->produk->nama ?? 'Produk Dihapus' }}</p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">{{ $item->total_terjual }} Unit Terjual</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-10 text-slate-500 text-sm">Belum ada data penjualan.</div>
                @endforelse
            </div>

            <a href="{{ route('pengelola.laporan.pusat') }}" wire:navigate class="mt-8 block w-full py-4 rounded-2xl bg-white/5 border border-white/10 text-center text-xs font-black uppercase tracking-widest hover:bg-white/10 transition-all">
                Analisis Lengkap
            </a>
        </div>
    </div>

    <!-- Low Stock Alert Feed -->
    <div class="bg-white rounded-[3rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-10 border-b border-slate-100 flex justify-between items-center bg-rose-50/30">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-sm">Peringatan Stok</h3>
                    <p class="text-[10px] font-bold text-rose-500 uppercase tracking-widest">Perlu Restock Segera</p>
                </div>
            </div>
            <a href="{{ route('pengelola.produk.stok') }}" wire:navigate class="text-xs font-black text-slate-500 hover:text-rose-600 uppercase tracking-widest flex items-center gap-2">
                Manajemen Stok <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($stok_feed as $p)
            <div class="p-6 px-10 flex items-center justify-between hover:bg-slate-50 transition-colors">
                <div class="flex items-center gap-6">
                    <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden">
                        <!-- Placeholder Image if null -->
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <i class="fa-solid fa-box"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">{{ $p->nama }}</h4>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">SKU: {{ $p->kode_unit }}</span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xl font-black text-rose-600">{{ $p->stok }}</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Sisa Unit</p>
                </div>
            </div>
            @empty
            <div class="p-10 text-center text-slate-400 font-medium text-sm">
                Aman! Tidak ada produk dengan stok menipis.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Chart Script -->
    <script>
        document.addEventListener('livewire:navigated', () => {
            const chartData = @json($chart);
            
            if(document.querySelector("#chartDistribusi")) {
                const options = {
                    series: [{
                        name: 'Jumlah Produk',
                        data: chartData.data
                    }],
                    chart: {
                        type: 'bar',
                        height: 320,
                        fontFamily: 'Plus Jakarta Sans, sans-serif',
                        toolbar: { show: false }
                    },
                    colors: ['#10b981', '#14b8a6', '#06b6d4', '#3b82f6'],
                    plotOptions: {
                        bar: {
                            borderRadius: 8,
                            columnWidth: '50%',
                            distributed: true,
                        }
                    },
                    dataLabels: { enabled: false },
                    legend: { show: false },
                    xaxis: {
                        categories: chartData.labels,
                        labels: {
                            style: { colors: '#64748b', fontSize: '11px', fontWeight: 700 }
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    grid: {
                        borderColor: '#f1f5f9',
                        strokeDashArray: 4,
                    },
                    tooltip: {
                        theme: 'dark'
                    }
                };

                const chart = new ApexCharts(document.querySelector("#chartDistribusi"), options);
                chart.render();
            }
        });
    </script>
</div>
