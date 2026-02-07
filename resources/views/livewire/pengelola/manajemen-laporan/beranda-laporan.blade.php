<div class="animate-in fade-in zoom-in duration-500 pb-20 space-y-8">
    
    <!-- Filter Periode -->
    <div class="flex justify-between items-center bg-white p-4 rounded-[30px] border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4 px-4">
            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                <i class="fa-solid fa-chart-line text-lg"></i>
            </div>
            <div>
                <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest">Periode Laporan</h2>
                <p class="text-xs text-slate-500 font-medium">Data diupdate secara real-time.</p>
            </div>
        </div>
        
        <div class="flex bg-slate-100 p-1 rounded-2xl">
            @foreach(['hari_ini' => 'Hari Ini', 'minggu_ini' => 'Minggu Ini', 'bulan_ini' => 'Bulan Ini', 'tahun_ini' => 'Tahun Ini'] as $key => $label)
            <button wire:click="$set('periode', '{{ $key }}')" 
                    class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $periode === $key ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Main Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Revenue Chart -->
        <div class="bg-white rounded-[40px] p-8 border border-slate-100 shadow-lg shadow-indigo-500/5 relative overflow-hidden">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Tren Pendapatan</h3>
            <div id="chart-revenue" class="w-full h-80"></div>
        </div>

        <!-- Orders Chart -->
        <div class="bg-white rounded-[40px] p-8 border border-slate-100 shadow-lg shadow-indigo-500/5 relative overflow-hidden">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Volume Transaksi</h3>
            <div id="chart-orders" class="w-full h-80"></div>
        </div>

    </div>

    <!-- Top Products & Categories -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Top Products List -->
        <div class="lg:col-span-2 bg-white rounded-[40px] p-8 border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Produk Terlaris</h3>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-widest">Top 5</span>
            </div>
            
            <div class="space-y-6">
                @foreach($topProduk as $idx => $prod)
                <div class="flex items-center gap-6 group">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center font-black text-lg text-slate-300 border border-slate-100">
                        {{ $idx + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-900 truncate">{{ $prod->nama }}</h4>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full mt-2 overflow-hidden">
                            <div class="bg-indigo-600 h-full rounded-full" style="width: {{ rand(40, 100) }}%"></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-black text-slate-900">{{ number_format($prod->total_terjual) }} Unit</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Rp {{ number_format($prod->total_revenue/1000000, 1) }}Jt</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Categories Pie -->
        <div class="bg-indigo-900 rounded-[40px] p-8 text-white relative overflow-hidden shadow-xl shadow-indigo-900/30">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            
            <h3 class="text-xs font-black text-indigo-200 uppercase tracking-widest mb-8">Dominasi Kategori</h3>
            
            <div class="space-y-6 relative z-10">
                @foreach($topKategori as $kat)
                <div>
                    <div class="flex justify-between text-xs font-bold mb-2">
                        <span>{{ $kat->nama }}</span>
                        <span class="text-indigo-300">{{ $kat->frekuensi }} Transaksi</span>
                    </div>
                    <div class="w-full bg-white/10 rounded-full h-2">
                        <div class="bg-gradient-to-r from-cyan-400 to-indigo-400 h-full rounded-full shadow-[0_0_10px_rgba(34,211,238,0.5)]" style="width: {{ rand(20, 90) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8 pt-8 border-t border-white/10 text-center">
                <p class="text-[10px] text-indigo-300 font-medium">Data dianalisis dari perilaku pembelian pelanggan.</p>
            </div>
        </div>

    </div>

    <!-- Script Chart -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            const renderCharts = () => {
                // Revenue Chart
                new ApexCharts(document.querySelector("#chart-revenue"), {
                    series: [{ name: 'Pendapatan', data: @json($chartPendapatan['data']) }],
                    chart: { type: 'area', height: 320, toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans' },
                    colors: ['#4f46e5'],
                    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.1, stops: [0, 90, 100] } },
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 3 },
                    xaxis: { categories: @json($chartPendapatan['labels']), axisBorder: { show: false }, axisTicks: { show: false } },
                    yaxis: { labels: { formatter: (val) => 'Rp ' + (val/1000000).toFixed(1) + 'Jt' } },
                    grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                    tooltip: { theme: 'dark' }
                }).render();

                // Orders Chart
                new ApexCharts(document.querySelector("#chart-orders"), {
                    series: [{ name: 'Pesanan', data: @json($chartPesanan['data']) }],
                    chart: { type: 'bar', height: 320, toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans' },
                    colors: ['#10b981'],
                    plotOptions: { bar: { borderRadius: 8, columnWidth: '40%' } },
                    dataLabels: { enabled: false },
                    xaxis: { categories: @json($chartPesanan['labels']), axisBorder: { show: false }, axisTicks: { show: false } },
                    grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                    tooltip: { theme: 'dark' }
                }).render();
            };

            renderCharts();
            
            // Re-render on update
            Livewire.on('chart-updated', () => {
                // Idealnya update data series saja, tapi re-render full oke untuk MVP
                setTimeout(renderCharts, 500); 
            });
        });
    </script>
</div>
