<div class="space-y-12 pb-20" x-data="{ jam: '' }" x-init="setInterval(() => jam = new Date().toLocaleTimeString(), 1000)">
    
    <!-- Top Header & Welcome -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Sistem Operasi Aktif</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">SELAMAT DATANG, <span class="text-indigo-600">{{ explode(' ', auth()->user()->nama)[0] }}</span></h1>
            <p class="text-slate-500 font-medium text-lg">Pantauan kinerja ekosistem TEQARA dalam satu dasbor terpadu.</p>
        </div>
        <div class="flex items-center gap-4 bg-white p-4 rounded-[32px] shadow-sm border border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode Laporan</p>
                <p class="text-sm font-bold text-slate-900 uppercase">{{ now()->translatedFormat('F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Metrik Utama (Futuristic Glow Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        
        <!-- Pendapatan -->
        <div class="bg-white p-8 rounded-[48px] border border-slate-100 shadow-sm relative overflow-hidden group transition-all duration-500 hover:shadow-2xl hover:shadow-indigo-500/10">
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 mb-6 group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Omzet Bersih</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter mb-4">Rp {{ number_format($metrik['pendapatan'], 0, ',', '.') }}</h3>
                <div class="flex items-center gap-2">
                    <span class="flex items-center text-[10px] font-black {{ $metrik['pertumbuhan'] >= 0 ? 'text-emerald-600' : 'text-red-600' }} px-2 py-1 bg-slate-50 rounded-lg">
                        {{ $metrik['pertumbuhan'] >= 0 ? '↑' : '↓' }} {{ number_format(abs($metrik['pertumbuhan']), 1) }}%
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Growth</span>
                </div>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-colors"></div>
        </div>

        <!-- Stok Kritis -->
        <div class="bg-white p-8 rounded-[48px] border border-slate-100 shadow-sm relative overflow-hidden group transition-all duration-500 hover:shadow-2xl hover:shadow-emerald-500/10">
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Unit SKU</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter mb-4">{{ number_format($metrik['produk']) }} <span class="text-sm text-slate-400 uppercase">Item</span></h3>
                <div class="flex items-center gap-2">
                    <span class="flex items-center text-[10px] font-black {{ $statsManajemen['stok_menipis'] > 0 ? 'text-red-600 bg-red-50' : 'text-emerald-600 bg-emerald-50' }} px-2 py-1 rounded-lg">
                        {{ $statsManajemen['stok_menipis'] }} Kritis
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Inventory</span>
                </div>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/5 rounded-full blur-3xl"></div>
        </div>

        <!-- Logistik -->
        <div class="bg-white p-8 rounded-[48px] border border-slate-100 shadow-sm relative overflow-hidden group transition-all duration-500 hover:shadow-2xl hover:shadow-amber-500/10">
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 mb-6 group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Antrian Kirim</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter mb-4">{{ number_format($statsManajemen['perlu_dikirim']) }} <span class="text-sm text-slate-400 uppercase">Resi</span></h3>
                <div class="flex items-center gap-2">
                    <span class="flex items-center text-[10px] font-black text-amber-600 px-2 py-1 bg-amber-50 rounded-lg">
                        {{ $statsManajemen['menunggu_bayar'] }} Pending
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Logistics</span>
                </div>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-amber-500/5 rounded-full blur-3xl"></div>
        </div>

        <!-- Pelanggan -->
        <div class="bg-white p-8 rounded-[48px] border border-slate-100 shadow-sm relative overflow-hidden group transition-all duration-500 hover:shadow-2xl hover:shadow-rose-500/10">
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 mb-6 group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Basis Member</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter mb-4">{{ number_format($metrik['pelanggan']) }} <span class="text-sm text-slate-400 uppercase">User</span></h3>
                <div class="flex items-center gap-2">
                    <span class="flex items-center text-[10px] font-black text-rose-600 px-2 py-1 bg-rose-50 rounded-lg">
                        Active Now
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Governance</span>
                </div>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-rose-500/5 rounded-full blur-3xl"></div>
        </div>
    </div>

    <!-- Charts & Analytics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Revenue Trend -->
        <div class="lg:col-span-2 bg-white p-10 rounded-[56px] border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Tren Performa Finansial</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">7 Hari Terakhir • Real-time Data</p>
                </div>
                <div class="flex gap-2">
                    <span class="px-4 py-2 bg-slate-50 rounded-xl text-[10px] font-black text-slate-500 uppercase tracking-widest">Ekspor Laporan</span>
                </div>
            </div>
            <div id="chart-pendapatan" class="w-full h-80"></div>
        </div>

        <!-- Category Dominance -->
        <div class="lg:col-span-1 bg-gradient-to-br from-indigo-600 to-indigo-800 p-10 rounded-[56px] text-white shadow-2xl shadow-indigo-500/40 relative overflow-hidden">
            <h3 class="text-xl font-black mb-2 tracking-tight relative z-10 uppercase">DOMINASI UNIT</h3>
            <p class="text-[10px] font-bold text-indigo-200 uppercase tracking-widest mb-10 relative z-10">Distribusi Penjualan Global</p>
            
            <div id="chart-kategori" class="w-full h-64 flex items-center justify-center relative z-10"></div>
            
            <div class="mt-8 space-y-4 relative z-10">
                @foreach($grafik['kategori_label'] as $index => $label)
                <div class="flex justify-between items-center group cursor-default">
                    <div class="flex items-center gap-3">
                        <span class="w-2.5 h-2.5 rounded-full shadow-lg border border-white/20" style="background-color: {{ ['#6366f1', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'][$index] ?? '#ccc' }}"></span>
                        <span class="text-[10px] font-black text-indigo-100 group-hover:text-white transition-colors uppercase tracking-widest">{{ $label }}</span>
                    </div>
                    <span class="text-[10px] font-black text-indigo-200 tracking-widest">Rp {{ number_format($grafik['kategori_data'][$index]/1000000, 1) }}M</span>
                </div>
                @endforeach
            </div>

            <!-- Background Tech Ornament -->
            <div class="absolute bottom-0 right-0 w-full h-1/2 bg-gradient-to-t from-indigo-500/10 to-transparent"></div>
        </div>
    </div>

    <!-- Activity & Recent Transactions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Live Activity Feed -->
        <div class="lg:col-span-1 bg-white rounded-[56px] border border-slate-100 shadow-sm p-10" wire:poll.10s>
            <div class="flex items-center justify-between mb-10">
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Audit Log Real-time</h3>
                <span class="flex h-3 w-3 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 shadow-sm shadow-emerald-500/50"></span>
                </span>
            </div>
            
            <div class="space-y-8 relative">
                <div class="absolute left-[15px] top-2 bottom-2 w-0.5 bg-slate-50"></div>
                @foreach($logTerbaru as $log)
                <div class="relative pl-10 animate-in fade-in slide-in-from-left-4 duration-700">
                    <div class="absolute left-0 top-1 w-8 h-8 bg-white border-2 border-slate-100 rounded-2xl flex items-center justify-center z-10 shadow-sm">
                        <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $log->waktu->diffForHumans() }}</p>
                        <p class="text-sm font-bold text-slate-800 leading-snug">
                            {{ $log->pengguna->nama ?? 'Sistem' }}
                            <span class="text-slate-500 font-medium text-xs block mt-1 leading-relaxed">{{ $log->pesan_naratif }}</span>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-10 pt-8 border-t border-slate-50">
                <a href="{{ route('admin.pengaturan.log') }}" wire:navigate class="block text-center py-4 bg-slate-50 hover:bg-slate-100 rounded-2xl text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] transition-all">Lihat Forensik Lengkap</a>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="lg:col-span-2 bg-white rounded-[56px] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Antrian Transaksi</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pesanan Masuk Terbaru</p>
                </div>
                <a href="{{ route('admin.pesanan.daftar') }}" wire:navigate class="px-6 py-2.5 bg-white border border-slate-200 rounded-2xl text-[10px] font-black text-slate-600 uppercase tracking-widest hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all shadow-sm">Buka Jurnal</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-white">
                            <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Identitas</th>
                            <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Otoritas</th>
                            <th class="px-10 py-6 text-right text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($pesananTerbaru as $p)
                        <tr class="group hover:bg-slate-50/50 transition-colors duration-300">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-xs font-black text-slate-500 group-hover:bg-white transition-colors">
                                        {{ substr($p->pengguna->nama ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="block text-sm font-black text-slate-900 tracking-tight">#{{ $p->nomor_invoice }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $p->pengguna->nama ?? 'Member' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $p->status_pembayaran == 'lunas' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                                    {{ $p->status_pembayaran }}
                                </span>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <span class="text-sm font-black text-slate-900 tracking-tighter">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ApexCharts Configuration -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Trend Chart
            var optionsTren = {
                series: [{ name: 'Pendapatan', data: @json($grafik['tren_data']) }],
                chart: { type: 'area', height: 320, toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans, sans-serif' },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 4, colors: ['#6366f1'] },
                xaxis: { categories: @json($grafik['tren_label']), axisBorder: { show: false }, axisTicks: { show: false } },
                yaxis: { labels: { formatter: (value) => { return "Rp " + (value / 1000000).toFixed(1) + "M" } } },
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
                colors: ['#6366f1'],
                grid: { borderColor: '#f8fafc', strokeDashArray: 4 }
            };
            new ApexCharts(document.querySelector("#chart-pendapatan"), optionsTren).render();

            // Category Chart
            var optionsKategori = {
                series: @json($grafik['kategori_data']),
                labels: @json($grafik['kategori_label']),
                chart: { type: 'donut', height: 280, fontFamily: 'Plus Jakarta Sans, sans-serif' },
                colors: ['#6366f1', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'],
                legend: { show: false },
                dataLabels: { enabled: false },
                stroke: { width: 0 },
                plotOptions: { pie: { donut: { size: '80%', labels: { show: true, total: { show: true, label: 'TOTAL', color: '#94a3b8', fontSize: '10px', fontWeight: '900', formatter: function (w) { return "Rp " + (w.globals.seriesTotals.reduce((a, b) => a + b, 0) / 1000000).toFixed(1) + "M" } } } } } }
            };
            new ApexCharts(document.querySelector("#chart-kategori"), optionsKategori).render();
        });
    </script>
</div>
