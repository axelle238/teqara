<div class="space-y-8 animate-in fade-in zoom-in duration-500">
    
    <!-- Bagian 1: Ringkasan Eksekutif (Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Pendapatan -->
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-coins text-6xl text-emerald-500"></i>
            </div>
            <div class="relative z-10">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Total Pendapatan</p>
                <h3 class="text-2xl font-black text-slate-900">Rp {{ number_format($metrik['pendapatan'], 0, ',', '.') }}</h3>
                <div class="flex items-center gap-2 mt-2">
                    <span class="px-2 py-0.5 rounded-lg bg-emerald-50 text-emerald-600 text-xs font-bold flex items-center gap-1">
                        <i class="fa-solid fa-arrow-trend-up"></i> {{ number_format($metrik['pertumbuhan'], 1) }}%
                    </span>
                    <span class="text-[10px] text-slate-400 font-medium">Bulan Ini</span>
                </div>
            </div>
            <div class="h-1 w-full bg-slate-100 mt-4 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ min(100, $metrik['target_pencapaian']) }}%"></div>
            </div>
        </div>

        <!-- Pesanan -->
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-cart-shopping text-6xl text-indigo-500"></i>
            </div>
            <div class="relative z-10">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Total Pesanan</p>
                <h3 class="text-2xl font-black text-slate-900">{{ number_format($metrik['pesanan']) }}</h3>
                <div class="flex items-center gap-2 mt-2">
                    <span class="px-2 py-0.5 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-bold">
                        {{ number_format($metrik['rasio_sukses'], 1) }}% Sukses
                    </span>
                    <span class="text-[10px] text-slate-400 font-medium">Rasio Penyelesaian</span>
                </div>
            </div>
        </div>

        <!-- Produk Aktif -->
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-box text-6xl text-cyan-500"></i>
            </div>
            <div class="relative z-10">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Inventaris Aktif</p>
                <h3 class="text-2xl font-black text-slate-900">{{ number_format($metrik['produk']) }} <span class="text-sm font-medium text-slate-400">Unit</span></h3>
                <div class="flex items-center gap-2 mt-2">
                    @if($statsManajemen['stok_menipis'] > 0)
                        <span class="px-2 py-0.5 rounded-lg bg-rose-50 text-rose-600 text-xs font-bold animate-pulse">
                            <i class="fa-solid fa-triangle-exclamation"></i> {{ $statsManajemen['stok_menipis'] }} Menipis
                        </span>
                    @else
                         <span class="px-2 py-0.5 rounded-lg bg-slate-50 text-slate-500 text-xs font-bold">
                            Stok Aman
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pelanggan -->
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-users text-6xl text-amber-500"></i>
            </div>
            <div class="relative z-10">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Basis Pelanggan</p>
                <h3 class="text-2xl font-black text-slate-900">{{ number_format($metrik['pelanggan']) }}</h3>
                <div class="flex items-center gap-2 mt-2">
                    <span class="px-2 py-0.5 rounded-lg bg-amber-50 text-amber-600 text-xs font-bold">
                        CRM Aktif
                    </span>
                    <span class="text-[10px] text-slate-400 font-medium">Terverifikasi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian 2: Chart & Analisis -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Grafik Utama -->
        <div class="lg:col-span-2 bg-white rounded-[32px] p-8 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-black text-slate-900">Performa Penjualan</h3>
                    <p class="text-sm text-slate-500">Pendapatan kotor 7 hari terakhir.</p>
                </div>
                <select class="text-xs font-bold border-none bg-slate-50 rounded-lg py-2 pl-3 pr-8 focus:ring-0 cursor-pointer">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                </select>
            </div>
            
            <!-- Simple Bar Chart Visualization (CSS Only for lightweight) -->
            <div class="h-64 flex items-end justify-between gap-2 mt-8">
                @php $max = max($grafik['tren_data']) ?: 1; @endphp
                @foreach($grafik['tren_data'] as $index => $data)
                    <div class="flex-1 flex flex-col items-center group relative">
                        <div class="w-full bg-indigo-50 rounded-t-xl relative overflow-hidden transition-all duration-500 hover:bg-indigo-100" style="height: {{ ($data / $max) * 100 }}%">
                            <div class="absolute bottom-0 inset-x-0 bg-indigo-500 h-0 transition-all duration-700 group-hover:h-full opacity-80"></div>
                            <!-- Tooltip -->
                            <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] font-bold py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                Rp {{ number_format($data/1000, 0) }}k
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 mt-2">{{ $grafik['tren_label'][$index] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Status Operasional -->
        <div class="bg-slate-900 rounded-[32px] p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500 rounded-full blur-[80px] opacity-20 -translate-y-1/2 translate-x-1/2"></div>
            
            <h3 class="text-lg font-black mb-6 relative z-10">Status Operasional</h3>
            
            <div class="space-y-6 relative z-10">
                <!-- Task 1 -->
                <div class="flex items-center justify-between p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center text-indigo-400">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold">Verifikasi Pembayaran</p>
                            <p class="text-xs text-slate-400">Perlu tindakan</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-indigo-500 text-white text-xs font-black">{{ $statsManajemen['menunggu_bayar'] }}</span>
                </div>

                <!-- Task 2 -->
                <div class="flex items-center justify-between p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-cyan-500/20 flex items-center justify-center text-cyan-400">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold">Siap Dikirim</p>
                            <p class="text-xs text-slate-400">Logistik Hilir</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-cyan-500 text-white text-xs font-black">{{ $statsManajemen['perlu_dikirim'] }}</span>
                </div>

                <!-- Task 3 -->
                <div class="flex items-center justify-between p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-rose-500/20 flex items-center justify-center text-rose-400">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold">Stok Kritis</p>
                            <p class="text-xs text-slate-400">Manajemen Hulu</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-rose-500 text-white text-xs font-black">{{ $statsManajemen['stok_menipis'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian 3: Tabel Data Terbaru (Pesanan & Log) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pesanan Masuk -->
        <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Pesanan Terbaru</h3>
                <a href="{{ route('admin.pesanan.daftar') }}" wire:navigate class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold">
                        <tr>
                            <th class="px-6 py-3">ID Faktur</th>
                            <th class="px-6 py-3">Pelanggan</th>
                            <th class="px-6 py-3">Total</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($pesananTerbaru as $p)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-900">
                                <a href="#" class="hover:text-indigo-600">{{ $p->nomor_faktur }}</a>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $p->pengguna->nama }}</td>
                            <td class="px-6 py-4 font-bold text-slate-900">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-[10px] font-black uppercase tracking-widest
                                    @if($p->status_pembayaran == 'lunas') bg-emerald-100 text-emerald-700
                                    @elseif($p->status_pembayaran == 'menunggu_verifikasi') bg-amber-100 text-amber-700
                                    @else bg-slate-100 text-slate-600 @endif">
                                    {{ $p->status_pembayaran }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Audit Log -->
        <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Log Aktivitas (Audit Trail)</h3>
                <a href="{{ route('admin.pengaturan.log') }}" wire:navigate class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Lihat Semua</a>
            </div>
            <div class="p-6 space-y-6">
                @foreach($logTerbaru as $log)
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 shrink-0 text-xs">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">{{ $log->pesan_naratif }}</p>
                        <p class="text-xs text-slate-400 mt-1">
                            <span class="text-indigo-500 font-bold">{{ $log->pengguna->nama ?? 'Sistem' }}</span> • {{ $log->waktu->diffForHumans() }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>