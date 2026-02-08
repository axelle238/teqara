<div class="space-y-10 animate-in fade-in zoom-in duration-700 pb-20" wire:poll.30s>
    
    <!-- HEADER EXECUTIF -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="relative z-10 space-y-2">
            <h1 class="text-4xl font-black text-slate-900 tracking-tight uppercase leading-none">Command <span class="text-indigo-600">Center</span></h1>
            <p class="text-slate-500 font-medium tracking-wide italic">Monitoring Real-time 15 Pilar Bisnis Teqara Enterprise.</p>
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

    <!-- UTAMA: 5 KPI PILAR (GRID KARTU COLORFUL) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        
        <!-- KEUANGAN (TEAL) -->
        <div class="bg-gradient-to-br from-teal-500 to-emerald-600 p-6 rounded-[32px] text-white shadow-xl shadow-emerald-500/20 group hover:scale-105 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-xl backdrop-blur-md"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                <span class="text-[9px] font-black opacity-60 uppercase">Finansial</span>
            </div>
            <h3 class="text-2xl font-black mb-1 italic">Rp {{ number_format($this->statistik['pendapatan_hari_ini'], 0, ',', '.') }}</h3>
            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest">Omzet Hari Ini</p>
        </div>

        <!-- PRODUK (INDIGO) -->
        <div class="bg-gradient-to-br from-indigo-500 to-blue-600 p-6 rounded-[32px] text-white shadow-xl shadow-indigo-500/20 group hover:scale-105 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-xl backdrop-blur-md"><i class="fa-solid fa-laptop-code"></i></div>
                <span class="text-[9px] font-black opacity-60 uppercase">Inventaris</span>
            </div>
            <h3 class="text-3xl font-black mb-1 italic">{{ $this->statistik['total_produk'] }}</h3>
            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest">SKU Aktif</p>
        </div>

        <!-- PESANAN (AMBER) -->
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 p-6 rounded-[32px] text-white shadow-xl shadow-amber-500/20 group hover:scale-105 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-xl backdrop-blur-md"><i class="fa-solid fa-cart-shopping"></i></div>
                <span class="text-[9px] font-black opacity-60 uppercase">Pesanan</span>
            </div>
            <h3 class="text-3xl font-black mb-1 italic">{{ $this->statistik['pesanan_baru'] }}</h3>
            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest">Antrian Masuk</p>
        </div>

        <!-- LAYANAN (VIOLET) -->
        <div class="bg-gradient-to-br from-violet-500 to-purple-600 p-6 rounded-[32px] text-white shadow-xl shadow-purple-500/20 group hover:scale-105 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-xl backdrop-blur-md"><i class="fa-solid fa-headset"></i></div>
                <span class="text-[9px] font-black opacity-60 uppercase">Helpdesk</span>
            </div>
            <h3 class="text-3xl font-black mb-1 italic">{{ $this->statistik['tiket_aktif'] }}</h3>
            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest">Tiket Aktif</p>
        </div>

        <!-- KEAMANAN (ROSE) -->
        <div class="bg-gradient-to-br from-rose-500 to-pink-600 p-6 rounded-[32px] text-white shadow-xl shadow-rose-500/20 group hover:scale-105 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-xl backdrop-blur-md"><i class="fa-solid fa-shield-halved"></i></div>
                <span class="text-[9px] font-black opacity-60 uppercase">Keamanan</span>
            </div>
            <h3 class="text-3xl font-black mb-1 italic">{{ $this->statistik['skor_keamanan'] }}%</h3>
            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest">Health Index</p>
        </div>

    </div>

    <!-- AREA ANALITIK & AKTIVITAS -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
        
        <!-- KOLOM KIRI: GRAFIK PERFORMA (APEXCHARTS) -->
        <div class="xl:col-span-2 bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Tren Performa 7 Hari</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Analisa komprehensif Omzet & Pesanan</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-slate-50 text-slate-500 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 transition-all">Laporan PDF</button>
                </div>
            </div>
            
            <div id="grafik-performa" class="w-full min-h-[400px]"></div>
        </div>

        <!-- KOLOM KANAN: AUDIT TRAIL NARATIF (DARK THEME) -->
        <div class="bg-slate-900 rounded-[50px] shadow-2xl p-10 relative overflow-hidden flex flex-col">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10 mix-blend-soft-light"></div>
            
            <div class="relative z-10 space-y-8 flex-1">
                <div class="flex items-center justify-between border-b border-white/10 pb-6">
                    <h3 class="text-xl font-black text-white uppercase tracking-tight italic">Audit <span class="text-indigo-400">Trail</span></h3>
                    <i class="fa-solid fa-fingerprint text-indigo-500 text-2xl animate-pulse"></i>
                </div>

                <div class="space-y-6 max-h-[500px] overflow-y-auto pr-4 custom-scrollbar-dark">
                    @foreach($this->logAktivitas as $log)
                    <div class="flex gap-4 group">
                        <div class="flex flex-col items-center">
                            <div class="w-2 h-2 bg-indigo-500 rounded-full group-hover:scale-150 transition-transform"></div>
                            <div class="w-px h-full bg-white/10 my-1"></div>
                        </div>
                        <div class="flex-1 space-y-1 pb-4">
                            <p class="text-[9px] font-black text-indigo-400 uppercase tracking-[0.2em]">{{ $log->waktu->diffForHumans() }}</p>
                            <p class="text-xs font-bold text-slate-300 leading-relaxed italic">"{{ $log->pesan_naratif }}"</p>
                            <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Oleh: {{ $log->pengguna->nama ?? 'Sistem' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('pengelola.pengaturan.log') }}" wire:navigate class="relative z-10 mt-6 block w-full py-4 bg-white/5 hover:bg-indigo-600 border border-white/10 rounded-2xl text-center text-[10px] font-black text-white uppercase tracking-[0.2em] transition-all">Monitor Seluruh Aktivitas</a>
        </div>

    </div>

    <!-- AREA OPERASIONAL: PESANAN TERBARU -->
    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner"><i class="fa-solid fa-receipt"></i></div>
                <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Antrian Transaksi <span class="text-amber-500">Real-time</span></h3>
            </div>
            <a href="{{ route('pengelola.pesanan.daftar') }}" wire:navigate class="px-6 py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all">Lihat Semua</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="py-6 px-4">Invoice</th>
                        <th class="py-6 px-4">Pelanggan</th>
                        <th class="py-6 px-4">Nilai</th>
                        <th class="py-6 px-4">Status Alur</th>
                        <th class="py-6 px-4">Waktu</th>
                        <th class="py-6 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($this->pesananTerbaru as $order)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="py-6 px-4">
                            <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black tracking-widest group-hover:bg-indigo-600 group-hover:text-white transition-all italic border border-slate-200">#{{ $order->nomor_faktur }}</span>
                        </td>
                        <td class="py-6 px-4">
                            <p class="text-sm font-black text-slate-800">{{ $order->pengguna->nama }}</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $order->pengguna->email }}</p>
                        </td>
                        <td class="py-6 px-4">
                            <p class="text-sm font-black text-slate-900 italic">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                        </td>
                        <td class="py-6 px-4">
                            @php
                                $warnaStatus = match($order->status_pesanan) {
                                    'menunggu' => 'bg-amber-100 text-amber-600 border-amber-200',
                                    'diproses' => 'bg-blue-100 text-blue-600 border-blue-200',
                                    'dikirim' => 'bg-purple-100 text-purple-600 border-purple-200',
                                    'selesai' => 'bg-emerald-100 text-emerald-600 border-emerald-200',
                                    'batal' => 'bg-rose-100 text-rose-600 border-rose-200',
                                    default => 'bg-slate-100 text-slate-600 border-slate-200'
                                };
                            @endphp
                            <span class="px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $warnaStatus }}">{{ $order->status_pesanan }}</span>
                        </td>
                        <td class="py-6 px-4 text-xs font-bold text-slate-500">
                            {{ $log->waktu->diffForHumans() }}
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
    <script>
        function inisialisasiDasbor() {
            // 1. Jam Real-time
            function updateJam() {
                const el = document.getElementById('jam-realtime');
                if (el) el.textContent = new Date().toLocaleTimeString('id-ID', { hour12: false });
            }
            setInterval(updateJam, 1000);
            updateJam();

            // 2. ApexCharts: Performa Bisnis
            if (document.querySelector("#grafik-performa")) {
                const opsi = {
                    chart: {
                        type: 'area', height: 400, fontFamily: 'Plus Jakarta Sans, sans-serif',
                        toolbar: { show: false }, zoom: { enabled: false }
                    },
                    series: [
                        { name: 'Omzet', data: @json($this->dataGrafik['omzet']) },
                        { name: 'Pesanan', data: @json($this->dataGrafik['pesanan']) }
                    ],
                    colors: ['#4f46e5', '#10b981'],
                    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [20, 100] } },
                    stroke: { curve: 'smooth', width: 4 },
                    xaxis: {
                        categories: @json($this->dataGrafik['label']),
                        labels: { style: { colors: '#94a3b8', fontWeight: 700, fontSize: '10px' } }
                    },
                    yaxis: { labels: { style: { colors: '#94a3b8', fontWeight: 700, fontSize: '10px' } } },
                    grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                    dataLabels: { enabled: false },
                    tooltip: { theme: 'dark', x: { show: true } },
                    legend: { position: 'top', horizontalAlign: 'right', fontWeight: 800, fontSize: '10px', markers: { radius: 12 } }
                };
                new ApexCharts(document.querySelector("#grafik-performa"), opsi).render();
            }
        }

        document.addEventListener('livewire:navigated', inisialisasiDasbor);
        inisialisasiDasbor();
    </script>

</div>