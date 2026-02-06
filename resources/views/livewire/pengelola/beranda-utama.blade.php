<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-10">
    
    <!-- Bagian 1: Header Dashboard & Aksi Cepat -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-gradient-to-r from-slate-900 to-slate-800 rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl border border-slate-700">
            <div class="absolute top-0 right-0 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
            
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <h1 class="text-4xl md:text-5xl font-black tracking-tighter mb-4">Pusat Komando <span class="text-cyan-400">TEQARA</span></h1>
                    <p class="text-slate-400 text-lg font-medium max-w-xl leading-relaxed">
                        Pantau seluruh ekosistem bisnis Anda dalam satu layar. Status sistem: <span class="bg-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest border border-emerald-500/30 animate-pulse">Optimal</span>
                    </p>
                </div>
                
                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('pengelola.produk.tambah') }}" wire:navigate class="flex items-center gap-3 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl text-sm font-black transition-all shadow-lg shadow-indigo-500/30 group">
                        <i class="fa-solid fa-plus group-hover:rotate-90 transition-transform"></i> UNIT BARU
                    </a>
                    <a href="{{ route('pengelola.pesanan.daftar') }}" wire:navigate class="flex items-center gap-3 px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-2xl text-sm font-black transition-all border border-slate-600">
                        <i class="fa-solid fa-list-check"></i> PROSES PESANAN
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200 shadow-sm flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-40 h-40 bg-indigo-50 rounded-bl-[100px] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <span class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest border border-slate-200">
                        Waktu Lokal
                    </span>
                    <i class="fa-solid fa-clock text-slate-300 text-2xl"></i>
                </div>
                <div class="space-y-2">
                    <p class="text-6xl font-black text-slate-800 tracking-tighter" id="jam-realtime">{{ now()->format('H:i') }}</p>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-[0.2em]">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-100 relative z-10 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-500">
                    <i class="fa-solid fa-shield-virus text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-800 uppercase tracking-widest">{{ $keamanan['log_aktivitas_hari_ini'] }} LOG HARI INI</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">KEAMANAN: TERJAMIN</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian 2: Metrik Utama (4 Pilar Utama) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Omzet -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group overflow-hidden relative">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full opacity-50 group-hover:scale-125 transition-transform"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-600 mb-6 shadow-sm">
                    <i class="fa-solid fa-sack-dollar text-2xl"></i>
                </div>
                <p class="text-slate-400 text-xs font-black uppercase tracking-[0.2em] mb-2">Omzet Lunas</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter">Rp {{ number_format($keuangan['omzet_hari_ini'], 0, ',', '.') }}</h3>
                <div class="mt-4 flex items-center gap-2 text-[10px] font-black text-amber-600 bg-amber-50 w-fit px-3 py-1 rounded-full border border-amber-100">
                    PENDING: {{ $keuangan['pembayaran_pending'] }}
                </div>
            </div>
        </div>

        <!-- Inventaris -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group overflow-hidden relative">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-125 transition-transform"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600 mb-6 shadow-sm">
                    <i class="fa-solid fa-boxes-stacked text-2xl"></i>
                </div>
                <p class="text-slate-400 text-xs font-black uppercase tracking-[0.2em] mb-2">Total Unit</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter">{{ number_format($produk['total_unit']) }} <span class="text-xs text-slate-400">SKU</span></h3>
                <div class="mt-4 flex items-center gap-2 text-[10px] font-black {{ $produk['stok_kritis'] > 0 ? 'text-rose-600 bg-rose-50 border-rose-100' : 'text-emerald-600 bg-emerald-50 border-emerald-100' }} w-fit px-3 py-1 rounded-full border">
                    STOK KRITIS: {{ $produk['stok_kritis'] }}
                </div>
            </div>
        </div>

        <!-- Pesanan -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group overflow-hidden relative">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-125 transition-transform"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 mb-6 shadow-sm">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                </div>
                <p class="text-slate-400 text-xs font-black uppercase tracking-[0.2em] mb-2">Faktur Baru</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter">{{ $pesanan['masuk_hari_ini'] }} <span class="text-xs text-slate-400">INV</span></h3>
                <div class="mt-4 flex items-center gap-2 text-[10px] font-black text-blue-600 bg-blue-50 w-fit px-3 py-1 rounded-full border border-blue-100 uppercase">
                    Antrean: {{ $pesanan['perlu_proses'] }}
                </div>
            </div>
        </div>

        <!-- CRM -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group overflow-hidden relative">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-50 rounded-full opacity-50 group-hover:scale-125 transition-transform"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 mb-6 shadow-sm">
                    <i class="fa-solid fa-users text-2xl"></i>
                </div>
                <p class="text-slate-400 text-xs font-black uppercase tracking-[0.2em] mb-2">Basis Pelanggan</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter">{{ number_format($pelanggan['total_member']) }} <span class="text-xs text-slate-400">JIWA</span></h3>
                <div class="mt-4 flex items-center gap-2 text-[10px] font-black text-purple-600 bg-purple-50 w-fit px-3 py-1 rounded-full border border-purple-100">
                    BARU: +{{ $pelanggan['member_baru_bulan_ini'] }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian 3: Visualisasi & Status Operasional (Hulu ke Hilir) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Grafik Penjualan -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] p-10 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight uppercase">Analitik Tren Penjualan</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Akumulasi pendapatan 7 hari terakhir</p>
                </div>
                <div class="bg-indigo-50 px-4 py-2 rounded-2xl text-indigo-600 text-[10px] font-black uppercase tracking-widest border border-indigo-100">Real-time</div>
            </div>
            
            <div id="grafikPendapatan" class="w-full h-80"></div>
        </div>

        <!-- Radar Operasional -->
        <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200 shadow-sm flex flex-col">
            <h3 class="text-xl font-black text-slate-800 tracking-tight uppercase mb-8 border-b border-slate-50 pb-4">Radar Operasional</h3>
            
            <div class="space-y-8 flex-1">
                <!-- Logistik -->
                <div class="flex items-center gap-5 group cursor-pointer">
                    <div class="w-14 h-14 rounded-[1.25rem] bg-orange-100 text-orange-600 flex items-center justify-center transition-all group-hover:bg-orange-600 group-hover:text-white shadow-sm">
                        <i class="fa-solid fa-truck-fast text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-black text-slate-700 uppercase tracking-tight">Logistik</span>
                            <span class="text-[10px] font-black text-orange-600 bg-orange-50 px-2 py-0.5 rounded">{{ $logistik['dalam_pengiriman'] }} AKTIF</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full transition-all duration-1000" style="width: {{ min(($logistik['dalam_pengiriman'] * 10), 100) }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- CS / Layanan -->
                <div class="flex items-center gap-5 group cursor-pointer">
                    <div class="w-14 h-14 rounded-[1.25rem] bg-pink-100 text-pink-600 flex items-center justify-center transition-all group-hover:bg-pink-600 group-hover:text-white shadow-sm">
                        <i class="fa-solid fa-headset text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-black text-slate-700 uppercase tracking-tight">Layanan</span>
                            <span class="text-[10px] font-black text-pink-600 bg-pink-50 px-2 py-0.5 rounded">{{ $layanan['tiket_terbuka'] }} TIKET</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-pink-500 h-2 rounded-full transition-all duration-1000" style="width: {{ min(($layanan['tiket_terbuka'] * 20), 100) }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Vendor -->
                <div class="flex items-center gap-5 group cursor-pointer">
                    <div class="w-14 h-14 rounded-[1.25rem] bg-cyan-100 text-cyan-600 flex items-center justify-center transition-all group-hover:bg-cyan-600 group-hover:text-white shadow-sm">
                        <i class="fa-solid fa-handshake-angle text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-black text-slate-700 uppercase tracking-tight">Mitra/Vendor</span>
                            <span class="text-[10px] font-black text-cyan-600 bg-cyan-50 px-2 py-0.5 rounded">{{ $vendor['mitra_aktif'] }} AKTIF</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-cyan-500 h-2 rounded-full transition-all duration-1000" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('pengelola.laporan.pusat') }}" wire:navigate class="mt-10 w-full py-4 rounded-2xl bg-slate-50 border border-slate-200 text-slate-600 font-black text-xs text-center hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all uppercase tracking-widest shadow-sm">
                ANALISIS MENYELURUH
            </a>
        </div>
    </div>

    <!-- Bagian 4: Jejak Audit Sistem (Integrasi Log) -->
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-10 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center bg-slate-50/30 gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-[1.5rem] bg-indigo-600 text-white flex items-center justify-center shadow-2xl shadow-indigo-500/40">
                    <i class="fa-solid fa-fingerprint text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight uppercase">Jejak Audit Enterprise</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Log aktivitas terbaru dari seluruh pilar manajemen</p>
                </div>
            </div>
            <a href="{{ route('pengelola.pengaturan.log') }}" wire:navigate class="px-8 py-3 bg-white border border-slate-200 rounded-2xl text-[10px] font-black text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all shadow-sm uppercase tracking-widest">
                LIHAT SEMUA AKTIVITAS
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                        <th class="px-10 py-6">Waktu & Otoritas</th>
                        <th class="px-10 py-6">Jenis Aksi</th>
                        <th class="px-10 py-6">Pesan Naratif</th>
                        <th class="px-10 py-6 text-right">Target</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($aktivitas as $log)
                    <tr class="group hover:bg-slate-50 transition-colors">
                        <td class="px-10 py-6 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-xs font-black text-indigo-600 border border-slate-200">
                                    {{ substr($log->pengguna->nama ?? 'S', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-xs font-black text-slate-800 uppercase tracking-tight">{{ $log->pengguna->nama ?? 'Sistem Otomatis' }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $log->waktu->translatedFormat('d M Y - H:i') }} WIB</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ in_array($log->aksi, ['hapus', 'akses_ilegal']) ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-indigo-50 text-indigo-600 border border-indigo-100' }}">
                                {{ $log->aksi }}
                            </span>
                        </td>
                        <td class="px-10 py-6">
                            <p class="text-sm text-slate-600 font-medium leading-relaxed max-w-md">{{ $log->pesan_naratif }}</p>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <span class="text-xs font-bold text-slate-400 bg-slate-50 px-3 py-1 rounded-lg border border-slate-100">{{ $log->target }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script Chart & Real-time Jam -->
    <script>
        function updateJam() {
            const sekarang = new Date();
            const jam = String(sekarang.getHours()).padStart(2, '0');
            const menit = String(sekarang.getMinutes()).padStart(2, '0');
            const el = document.getElementById('jam-realtime');
            if (el) el.textContent = `${jam}:${menit}`;
        }
        setInterval(updateJam, 1000);

        document.addEventListener('livewire:navigated', () => {
            renderUIGrafik();
        });

        renderUIGrafik();

        function renderUIGrafik() {
            const dataGrafik = @json($grafik['data']);
            const labelGrafik = @json($grafik['label']);
            
            const opsi = {
                series: [{
                    name: 'Omzet Terverifikasi',
                    data: dataGrafik
                }],
                chart: {
                    type: 'area',
                    height: 320,
                    fontFamily: 'Plus Jakarta Sans, sans-serif',
                    toolbar: { show: false },
                    zoom: { enabled: false },
                    animations: { enabled: true, easing: 'easeinout', speed: 800 }
                },
                colors: ['#4f46e5'],
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 4 },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                xaxis: {
                    categories: labelGrafik,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { colors: '#94a3b8', fontSize: '11px', fontWeight: 700 } }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#94a3b8', fontSize: '11px', fontWeight: 700 },
                        formatter: (val) => { return 'Rp ' + (val / 1000).toFixed(0) + 'k' }
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 6,
                    yaxis: { lines: { show: true } }
                },
                tooltip: {
                    theme: 'dark',
                    y: { formatter: (val) => "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }
                }
            };

            const container = document.querySelector("#grafikPendapatan");
            if(container) {
                container.innerHTML = '';
                const chart = new ApexCharts(container, opsi);
                chart.render();
            }
        }
    </script>
</div>