<div class="space-y-10 animate-in fade-in zoom-in duration-700 pb-20" x-data="{ tabAktif: 'ringkasan' }" wire:poll.30s>
    
    <!-- HEADER EXECUTIF -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="relative z-10 space-y-2">
            <h1 class="text-4xl font-black text-slate-900 tracking-tight uppercase leading-none">Command <span class="text-indigo-600">Center</span></h1>
            <p class="text-slate-500 font-medium tracking-wide italic">Monitoring Real-time Pilar Bisnis Teqara Enterprise.</p>
        </div>
        <div class="flex items-center gap-4 relative z-10">
            <div class="px-6 py-3 bg-emerald-50 rounded-2xl border border-emerald-100 flex items-center gap-3">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-black text-emerald-700 uppercase tracking-widest">Sistem Sinkron</span>
            </div>
            <div class="text-right hidden sm:block">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ now()->translatedFormat('l, d F Y') }}</p>
                <p id="jam-realtime" class="text-lg font-black text-slate-900 tracking-tight italic">00:00:00</p>
            </div>
        </div>
    </div>

    <!-- UTAMA: 15 PILAR MANAJEMEN (GRID KARTU COLORFUL) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        
        <!-- PILAR 1: KEUANGAN -->
        <div class="bg-gradient-to-br from-teal-500 to-emerald-600 p-6 rounded-[32px] text-white shadow-xl shadow-emerald-500/20 group hover:scale-105 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-xl backdrop-blur-md"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                <span class="text-[10px] font-black opacity-60 uppercase">Keuangan</span>
            </div>
            <h3 class="text-2xl font-black mb-1 italic">Rp {{ number_format($this->statistik['pendapatan_hari_ini'], 0, ',', '.') }}</h3>
            <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Omzet Hari Ini</p>
        </div>

        <!-- PILAR 2: INVENTARIS -->
        <div class="bg-gradient-to-br from-indigo-500 to-blue-600 p-6 rounded-[32px] text-white shadow-xl shadow-indigo-500/20 group hover:scale-105 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-xl backdrop-blur-md"><i class="fa-solid fa-laptop-code"></i></div>
                <span class="text-[10px] font-black opacity-60 uppercase">Produk</span>
            </div>
            <h3 class="text-3xl font-black mb-1 italic">{{ $this->statistik['total_produk'] }}</h3>
            <p class="text-xs font-bold opacity-80 uppercase tracking-widest">SKU Terdaftar</p>
        </div>

        <!-- PILAR 3: PESANAN -->
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 p-6 rounded-[32px] text-white shadow-xl shadow-amber-500/20 group hover:scale-105 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-xl backdrop-blur-md"><i class="fa-solid fa-cart-shopping"></i></div>
                <span class="text-[10px] font-black opacity-60 uppercase">Pesanan</span>
            </div>
            <h3 class="text-3xl font-black mb-1 italic">{{ $this->statistik['pesanan_baru'] }}</h3>
            <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Baru Masuk</p>
        </div>

        <!-- PILAR 4: CS & LAYANAN -->
        <div class="bg-gradient-to-br from-violet-500 to-purple-600 p-6 rounded-[32px] text-white shadow-xl shadow-purple-500/20 group hover:scale-105 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-xl backdrop-blur-md"><i class="fa-solid fa-headset"></i></div>
                <span class="text-[10px] font-black opacity-60 uppercase">Layanan</span>
            </div>
            <h3 class="text-3xl font-black mb-1 italic">{{ $this->statistik['tiket_aktif'] }}</h3>
            <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Tiket Terbuka</p>
        </div>

        <!-- PILAR 5: KEAMANAN -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 rounded-[32px] text-white shadow-xl shadow-slate-900/20 group hover:scale-105 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-xl backdrop-blur-md text-red-400"><i class="fa-solid fa-shield-halved"></i></div>
                <span class="text-[10px] font-black opacity-60 uppercase">Cyber SOC</span>
            </div>
            <h3 class="text-3xl font-black mb-1 italic text-red-400">{{ $this->statistik['skor_keamanan'] }}%</h3>
            <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Health Index</p>
        </div>

    </div>

    <!-- AREA ANALITIK & AKTIVITAS -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
        
        <!-- KOLOM KIRI: GRAFIK TREN (APEXCHARTS) -->
        <div class="xl:col-span-2 bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Tren Performa Bisnis</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Laporan finansial dalam 7 hari terakhir</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-slate-50 text-slate-500 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 transition-all">Laporan PDF</button>
                </div>
            </div>
            
            <div id="grafik-pendapatan" class="w-full min-h-[400px]"></div>
        </div>

        <!-- KOLOM KANAN: AUDIT TRAIL NARATIF (DARK THEME) -->
        <div class="bg-slate-900 rounded-[50px] shadow-2xl p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-full h-full bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10 mix-blend-soft-light"></div>
            
            <div class="relative z-10 space-y-8">
                <div class="flex items-center justify-between border-b border-white/10 pb-6">
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">Audit <span class="text-indigo-400">Trail</span></h3>
                    <i class="fa-solid fa-fingerprint text-white/20 text-2xl"></i>
                </div>

                <div class="space-y-6 max-h-[500px] overflow-y-auto pr-4 custom-scrollbar-dark">
                    @foreach($this->logAktivitas as $log)
                    <div class="flex gap-4 group">
                        <div class="w-1 bg-indigo-500 rounded-full group-hover:scale-y-110 transition-transform"></div>
                        <div class="flex-1 space-y-1">
                            <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">{{ $log->waktu->diffForHumans() }}</p>
                            <p class="text-xs font-bold text-slate-300 leading-relaxed italic">"{{ $log->pesan_naratif }}"</p>
                            <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Oleh: {{ $log->pengguna->nama ?? 'Sistem' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('pengelola.pengaturan.log') }}" wire:navigate class="block w-full py-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl text-center text-[10px] font-black text-white uppercase tracking-[0.2em] transition-all">Monitor Seluruh Log</a>
            </div>
        </div>

    </div>

    <!-- AREA OPERASIONAL: PESANAN TERBARU -->
    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shadow-inner"><i class="fa-solid fa-receipt"></i></div>
                <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Antrian Pesanan <span class="text-emerald-500">Masuk</span></h3>
            </div>
            <a href="{{ route('pengelola.pesanan.daftar') }}" wire:navigate class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline">Lihat Detail</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="py-6 px-4">Invoice</th>
                        <th class="py-6 px-4">Identitas Pelanggan</th>
                        <th class="py-6 px-4">Nilai Transaksi</th>
                        <th class="py-6 px-4">Status Alur</th>
                        <th class="py-6 px-4">Waktu</th>
                        <th class="py-6 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($this->pesananTerbaru as $order)
                    <tr class="group hover:bg-slate-50 transition-colors">
                        <td class="py-6 px-4">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black tracking-widest group-hover:bg-indigo-600 group-hover:text-white transition-colors italic">#{{ $order->nomor_invoice ?? $order->nomor_faktur }}</span>
                        </td>
                        <td class="py-6 px-4">
                            <p class="text-sm font-black text-slate-800">{{ $order->pengguna->nama }}</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $order->pengguna->email }}</p>
                        </td>
                        <td class="py-6 px-4">
                            <p class="text-sm font-black text-slate-900">Rp {{ number_format($order->total_belanja ?? $order->total_harga, 0, ',', '.') }}</p>
                        </td>
                        <td class="py-6 px-4">
                            @php
                                $warnaStatus = match($order->status_pesanan) {
                                    'menunggu' => 'bg-amber-100 text-amber-600',
                                    'diproses' => 'bg-blue-100 text-blue-600',
                                    'dikirim' => 'bg-purple-100 text-purple-600',
                                    'selesai' => 'bg-emerald-100 text-emerald-600',
                                    'batal' => 'bg-rose-100 text-rose-600',
                                    default => 'bg-slate-100 text-slate-600'
                                };
                            @endphp
                            <span class="px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $warnaStatus }}">{{ $order->status_pesanan }}</span>
                        </td>
                        <td class="py-6 px-4 text-xs font-bold text-slate-500">
                            {{ $order->dibuat_pada->diffForHumans() }}
                        </td>
                        <td class="py-6 px-4 text-right">
                            <a href="{{ route('pengelola.pesanan.detail', $order->id) }}" wire:navigate class="inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-200 text-slate-400 rounded-xl hover:text-indigo-600 hover:border-indigo-200 hover:shadow-lg transition-all"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- SCRIPTS UNTUK GRAFIK & JAM -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        function initDashboard() {
            // Update Jam Real-time
            function updateJam() {
                const el = document.getElementById('jam-realtime');
                if (el) el.textContent = new Date().toLocaleTimeString('id-ID', { hour12: false });
            }
            setInterval(updateJam, 1000);
            updateJam();

            // Init ApexCharts
            if (document.querySelector("#grafik-pendapatan")) {
                const options = {
                    chart: {
                        type: 'area', height: 400, fontFamily: 'Plus Jakarta Sans, sans-serif',
                        toolbar: { show: false }, zoom: { enabled: false }
                    },
                    series: [{
                        name: 'Omzet',
                        data: [15000000, 22000000, 18000000, 35000000, 28000000, 45000000, 38000000]
                    }],
                    colors: ['#4f46e5'],
                    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.05, stops: [20, 100] } },
                    stroke: { curve: 'smooth', width: 4 },
                    xaxis: {
                        categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                        labels: { style: { colors: '#94a3b8', fontWeight: 700, fontSize: '10px' } }
                    },
                    yaxis: { labels: { style: { colors: '#94a3b8', fontWeight: 700, fontSize: '10px' } } },
                    grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                    dataLabels: { enabled: false },
                    tooltip: { theme: 'dark' }
                };
                new ApexCharts(document.querySelector("#grafik-pendapatan"), options).render();
            }
        }

        document.addEventListener('livewire:navigated', initDashboard);
        initDashboard();
    </script>

</div>

