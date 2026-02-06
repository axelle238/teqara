<div class="space-y-10 animate-in fade-in zoom-in duration-700 pb-20">
    
    <!-- Bagian 1: Ucapan Selamat Datang & Status Global -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-8 rounded-[40px] text-white shadow-2xl shadow-indigo-500/20">
        <div class="space-y-2">
            <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight">
                Pusat Komando <span class="opacity-80">Teqara</span>
            </h1>
            <p class="text-indigo-100 font-bold text-lg">
                Monitoring ekosistem bisnis terintegrasi — Status: <span class="bg-emerald-400 px-2 py-0.5 rounded text-indigo-900 text-xs font-black uppercase tracking-widest animate-pulse">Optimal</span>
            </p>
        </div>
        <div class="bg-white/20 backdrop-blur-xl p-4 rounded-3xl border border-white/30 flex items-center gap-4">
            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-lg">
                <i class="fa-solid fa-clock text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-black uppercase tracking-widest opacity-70">Waktu Sistem</p>
                <p class="text-xl font-black">{{ now()->translatedFormat('H:i') }} <span class="text-xs opacity-80">WIB</span></p>
            </div>
        </div>
    </div>

    <!-- Bagian 2: Metrik Agregat 12 Pilar (Grid Enterprise) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        
        <!-- Kartu Keuangan -->
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50 hover:shadow-xl transition-all group relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-amber-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10 space-y-4">
                <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 shadow-sm">
                    <i class="fa-solid fa-wallet text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pendapatan Hari Ini</p>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tighter">Rp {{ number_format($keuangan['pendapatan_hari_ini'], 0, ',', '.') }}</h3>
                </div>
                <div class="flex items-center gap-2 text-xs font-bold text-amber-600">
                    <span class="px-2 py-0.5 bg-amber-50 rounded-lg">Verifikasi: {{ $keuangan['verifikasi_tertunda'] }}</span>
                </div>
            </div>
        </div>

        <!-- Kartu Produk -->
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50 hover:shadow-xl transition-all group relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10 space-y-4">
                <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 shadow-sm">
                    <i class="fa-solid fa-boxes-stacked text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Inventaris Produk</p>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tighter">{{ $produk['total_unit'] }} <span class="text-xs text-slate-400">UNIT</span></h3>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 {{ $produk['stok_kritis'] > 0 ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }} rounded-lg text-xs font-bold">
                        Stok Kritis: {{ $produk['stok_kritis'] }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Kartu Pesanan -->
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50 hover:shadow-xl transition-all group relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-blue-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10 space-y-4">
                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pesanan Masuk</p>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tighter">{{ $pesanan['hari_ini'] }} <span class="text-xs text-slate-400">FAKTUR</span></h3>
                </div>
                <div class="flex items-center gap-2 text-xs font-bold text-blue-600">
                    <span class="px-2 py-0.5 bg-blue-50 rounded-lg">Antrean: {{ $pesanan['perlu_diproses'] }}</span>
                </div>
            </div>
        </div>

        <!-- Kartu Pelanggan -->
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50 hover:shadow-xl transition-all group relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-teal-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10 space-y-4">
                <div class="w-14 h-14 bg-teal-100 rounded-2xl flex items-center justify-center text-teal-600 shadow-sm">
                    <i class="fa-solid fa-users text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Basis Pelanggan</p>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tighter">{{ $pelanggan['total_member'] }} <span class="text-xs text-slate-400">JIWA</span></h3>
                </div>
                <div class="flex items-center gap-2 text-xs font-bold text-teal-600">
                    <span class="px-2 py-0.5 bg-teal-50 rounded-lg">+{{ $pelanggan['member_baru'] }} Bulan Ini</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Bagian 3: Visualisasi Data & Status Operasional -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Tren Penjualan (Grafik) -->
        <div class="lg:col-span-2 bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50">
            <div class="flex justify-between items-center mb-10">
                <div class="space-y-1">
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">Analisis Tren Penjualan</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Akumulasi pendapatan 7 hari terakhir</p>
                </div>
                <div class="bg-indigo-50 px-4 py-2 rounded-2xl text-indigo-600 text-xs font-black uppercase tracking-widest">Real-time</div>
            </div>
            
            <div class="h-72 flex items-end justify-between gap-4 px-2">
                @php $max = max($grafik['data']) ?: 1; @endphp
                @foreach($grafik['data'] as $idx => $nilai)
                    <div class="flex-1 flex flex-col items-center group relative h-full justify-end">
                        <div class="w-full bg-indigo-100 rounded-2xl transition-all duration-500 group-hover:bg-indigo-500 group-hover:shadow-lg group-hover:shadow-indigo-500/30" 
                             style="height: {{ ($nilai / $max) * 80 }}%">
                            <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] font-black px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                Rp {{ number_format($nilai/1000, 0) }}k
                            </div>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 mt-4 group-hover:text-indigo-600 transition-colors uppercase tracking-tighter">{{ $grafik['label'][$idx] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Status Cepat Operasional -->
        <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
            <h3 class="text-xl font-black text-slate-800 tracking-tight border-b border-slate-50 pb-4">Radar Operasional</h3>
            
            <div class="space-y-6">
                <!-- Logistik -->
                <div class="flex items-center justify-between group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 transition-transform group-hover:scale-110">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800">Logistik</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $logistik['pengiriman_aktif'] }} Paket Aktif</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-slate-200 group-hover:text-indigo-500 transition-colors"></i>
                </div>

                <!-- CS -->
                <div class="flex items-center justify-between group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-pink-100 rounded-2xl flex items-center justify-center text-pink-600 transition-transform group-hover:scale-110">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800">Layanan</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $cs['tiket_terbuka'] }} Tiket Terbuka</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-slate-200 group-hover:text-indigo-500 transition-colors"></i>
                </div>

                <!-- HRD -->
                <div class="flex items-center justify-between group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-sky-100 rounded-2xl flex items-center justify-center text-sky-600 transition-transform group-hover:scale-110">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800">Pegawai</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $hrd['staf_aktif'] }} Staf Aktif</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-slate-200 group-hover:text-indigo-500 transition-colors"></i>
                </div>

                <!-- Keamanan -->
                <div class="flex items-center justify-between group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-rose-100 rounded-2xl flex items-center justify-center text-rose-600 transition-transform group-hover:scale-110">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800">Keamanan</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $keamanan['aksi_kritis'] }} Aksi Kritis</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-slate-200 group-hover:text-indigo-500 transition-colors"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Bagian 4: Jejak Audit (Log Aktivitas Dinamis) -->
    <div class="bg-white rounded-[50px] shadow-sm border border-indigo-50 overflow-hidden">
        <div class="p-10 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-fingerprint text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight leading-none uppercase">Jejak Audit Enterprise</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">Log Aktivitas Real-time</p>
                </div>
            </div>
            <a href="{{ route('admin.pengaturan.log') }}" wire:navigate class="px-6 py-3 bg-white border border-indigo-100 rounded-2xl text-xs font-black text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">LIHAT SELURUH LOG</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 border-b border-slate-50">
                    <tr>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Waktu</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Otoritas</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Aksi & Narasi</th>
                        <th class="px-10 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($aktivitas as $log)
                    <tr class="group hover:bg-indigo-50/30 transition-all">
                        <td class="px-10 py-6 whitespace-nowrap">
                            <p class="text-xs font-black text-slate-800">{{ $log->waktu->translatedFormat('d M Y') }}</p>
                            <p class="text-[10px] font-bold text-slate-400">{{ $log->waktu->translatedFormat('H:i:s') }} WIB</p>
                        </td>
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-[10px] font-black text-indigo-600 uppercase border border-indigo-200">
                                    {{ substr($log->pengguna->nama ?? 'S', 0, 1) }}
                                </div>
                                <p class="text-xs font-black text-slate-700">{{ $log->pengguna->nama ?? 'Sistem' }}</p>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <span class="inline-block px-2 py-0.5 rounded-lg bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase tracking-widest mb-1 border border-indigo-100">{{ $log->aksi }}</span>
                            <p class="text-xs font-bold text-slate-500 leading-relaxed">{{ $log->pesan_naratif }}</p>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <button class="text-indigo-400 hover:text-indigo-600 transition-colors">
                                <i class="fa-solid fa-circle-info text-xl"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
