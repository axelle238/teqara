<div class="p-6 space-y-8 bg-[#f8fafc] min-h-screen font-sans">
    <!-- HEADER EXECUTIVE -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-chart-pie text-indigo-600"></i>
                Dasbor Eksekutif
            </h1>
            <p class="text-slate-500 font-medium mt-1">Pantau seluruh pilar bisnis Teqara dalam satu kendali terpusat.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-white px-4 py-2 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Sistem Optimal</span>
            </div>
            <button wire:click="$refresh" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                <i class="fa-solid fa-rotate"></i> Perbarui Data
            </button>
        </div>
    </div>

    <!-- UTAMA: KEUANGAN & TRANSAKSI -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- PENDAPATAN -->
        <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-3xl p-6 text-white shadow-xl shadow-indigo-100 relative overflow-hidden group">
            <i class="fa-solid fa-money-bill-trend-up absolute -right-4 -bottom-4 text-8xl text-white/10 group-hover:scale-110 transition-transform duration-500"></i>
            <div class="relative z-10">
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-100">Pendapatan Hari Ini</span>
                <h2 class="text-3xl font-black mt-2">Rp {{ number_format($statistik['pendapatan_hari_ini'], 0, ',', '.') }}</h2>
                <div class="mt-4 flex items-center gap-2 text-xs bg-white/10 w-fit px-3 py-1 rounded-full border border-white/20">
                    <span class="font-bold">Bulan Ini: Rp {{ number_format($statistik['pendapatan_bulan_ini'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- PESANAN -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50 px-2 py-1 rounded-lg">Real-time</span>
            </div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pesanan Menunggu</span>
            <h2 class="text-3xl font-black text-slate-800 mt-1">{{ $statistik['pesanan_menunggu'] }}</h2>
            <div class="mt-4 text-[10px] font-bold text-slate-500 flex items-center gap-2">
                <i class="fa-solid fa-spinner animate-spin"></i>
                <span>{{ $statistik['pesanan_proses'] }} Pesanan sedang diproses</span>
            </div>
        </div>

        <!-- PRODUK -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <span class="text-[10px] font-black text-amber-500 uppercase tracking-widest bg-amber-50 px-2 py-1 rounded-lg">Inventaris</span>
            </div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Produk</span>
            <h2 class="text-3xl font-black text-slate-800 mt-1">{{ $statistik['total_produk'] }}</h2>
            <div class="mt-4 text-[10px] font-bold text-rose-500 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>{{ $statistik['stok_menipis'] }} Produk stok kritis</span>
            </div>
        </div>

        <!-- KEAMANAN -->
        <div class="bg-slate-900 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-rose-500/20 rounded-2xl flex items-center justify-center text-rose-500 text-xl group-hover:scale-110 transition-transform border border-rose-500/30">
                    <i class="fa-solid fa-shield-virus"></i>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[10px] font-black text-rose-400 uppercase tracking-widest">Skor Risiko</span>
                    <span class="text-lg font-black {{ $statistik['skor_risiko'] > 50 ? 'text-rose-500' : 'text-emerald-500' }}">{{ $statistik['skor_risiko'] }}/100</span>
                </div>
            </div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Insiden Aktif</span>
            <h2 class="text-3xl font-black mt-1">{{ $statistik['insiden_keamanan'] }}</h2>
            <div class="mt-4 text-[10px] font-bold text-slate-400 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                <span>WAF & IDS aktif melindungi sistem</span>
            </div>
        </div>
    </div>

    <!-- GRID MENENGAH: LOGISTIK, CS, CRM, HRD -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- LOGISTIK -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4 group">
            <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 text-2xl group-hover:rotate-12 transition-transform">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Logistik Aktif</h4>
                <div class="text-xl font-black text-slate-800">{{ $statistik['pengiriman_berjalan'] }} <span class="text-xs font-bold text-slate-400">Pengiriman</span></div>
            </div>
        </div>

        <!-- CUSTOMER SERVICE -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4 group">
            <div class="w-14 h-14 bg-violet-100 rounded-2xl flex items-center justify-center text-violet-600 text-2xl group-hover:rotate-12 transition-transform">
                <i class="fa-solid fa-headset"></i>
            </div>
            <div>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tiket Support</h4>
                <div class="text-xl font-black text-slate-800">{{ $statistik['tiket_terbuka'] }} <span class="text-xs font-bold text-slate-400">Terbuka</span></div>
            </div>
        </div>

        <!-- CRM / PELANGGAN -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4 group">
            <div class="w-14 h-14 bg-sky-100 rounded-2xl flex items-center justify-center text-sky-600 text-2xl group-hover:rotate-12 transition-transform">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Member</h4>
                <div class="text-xl font-black text-slate-800">{{ number_format($statistik['total_pelanggan'], 0, ',', '.') }} <span class="text-xs font-bold text-emerald-500">+{{ $statistik['pelanggan_baru_minggu_ini'] }}</span></div>
            </div>
        </div>

        <!-- SDM / HRD -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4 group">
            <div class="w-14 h-14 bg-lime-100 rounded-2xl flex items-center justify-center text-lime-600 text-2xl group-hover:rotate-12 transition-transform">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Karyawan</h4>
                <div class="text-xl font-black text-slate-800">{{ $statistik['total_karyawan'] }} <span class="text-xs font-bold text-slate-400">Aktif</span></div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- TABEL PESANAN TERBARU -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-black text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-indigo-500"></i>
                    Aktivitas Pesanan Terkini
                </h3>
                <a href="{{ route('pengelola.pesanan.daftar') }}" wire:navigate class="text-xs font-bold text-indigo-600 hover:text-indigo-700 uppercase tracking-wider">Lihat Semua</a>
            </div>
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">ID Pesanan</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Pelanggan</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Total</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pesananTerbaru as $item)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="font-black text-slate-700 text-xs">#{{ $item->nomor_pesanan }}</span>
                                <div class="text-[9px] text-slate-400 font-bold mt-0.5">{{ $item->dibuat_pada->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center text-[10px] font-bold text-indigo-600">
                                        {{ substr($item->pengguna->nama ?? 'P', 0, 1) }}
                                    </div>
                                    <span class="text-xs font-bold text-slate-600">{{ $item->pengguna->nama ?? 'Pelanggan Umum' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-black text-xs text-slate-800">
                                Rp {{ number_format($item->total_akhir, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $warna = match($item->status_pesanan) {
                                        'menunggu' => 'bg-amber-100 text-amber-600',
                                        'diproses' => 'bg-blue-100 text-blue-600',
                                        'dikirim' => 'bg-orange-100 text-orange-600',
                                        'selesai' => 'bg-emerald-100 text-emerald-600',
                                        default => 'bg-slate-100 text-slate-600'
                                    };
                                @endphp
                                <span class="{{ $warna }} px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest">
                                    {{ $item->status_pesanan }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-bold text-sm italic">Belum ada pesanan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- LOG AKTIVITAS TERBARU -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-black text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-fingerprint text-rose-500"></i>
                    Audit Trail
                </h3>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 px-2 py-1 rounded-lg">Real-time</span>
            </div>
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-2">
                <div class="space-y-1">
                    @forelse($logTerbaru as $log)
                    <div class="flex items-start gap-3 p-3 rounded-2xl hover:bg-slate-50 transition-all group">
                        <div class="mt-1">
                            @php
                                $ikonLog = match(true) {
                                    str_contains($log->aksi, 'tambah') => 'fa-plus text-emerald-500 bg-emerald-50',
                                    str_contains($log->aksi, 'hapus') => 'fa-trash text-rose-500 bg-rose-50',
                                    str_contains($log->aksi, 'edit') || str_contains($log->aksi, 'ubah') => 'fa-pen text-amber-500 bg-amber-50',
                                    str_contains($log->aksi, 'login') => 'fa-right-to-bracket text-blue-500 bg-blue-50',
                                    default => 'fa-circle-dot text-slate-400 bg-slate-50'
                                };
                            @endphp
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs {{ $ikonLog }}">
                                <i class="fa-solid {{ explode(' ', $ikonLog)[0] }}"></i>
                            </div>
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <p class="text-[11px] font-bold text-slate-700 leading-relaxed">{{ $log->pesan_naratif }}</p>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $log->waktu->diffForHumans() }}</span>
                                <span class="text-[9px] font-bold text-indigo-500 group-hover:underline cursor-pointer">Detail</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-12 text-center text-slate-400 font-bold text-sm italic">Belum ada aktivitas tercatat.</div>
                    @endforelse
                </div>
            </div>
            
            <!-- TOMBOL CEPAT -->
            <div class="bg-gradient-to-br from-indigo-900 to-slate-900 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="text-sm font-black uppercase tracking-widest text-indigo-400 mb-4">Aksi Cepat</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('pengelola.produk.tambah') }}" wire:navigate class="bg-white/10 hover:bg-white/20 border border-white/10 p-3 rounded-2xl flex flex-col items-center gap-2 transition-all">
                            <i class="fa-solid fa-plus text-indigo-400"></i>
                            <span class="text-[9px] font-black uppercase tracking-widest">Tambah Produk</span>
                        </a>
                        <a href="{{ route('pengelola.keamanan.pemindai') }}" wire:navigate class="bg-white/10 hover:bg-white/20 border border-white/10 p-3 rounded-2xl flex flex-col items-center gap-2 transition-all">
                            <i class="fa-solid fa-shield-check text-emerald-400"></i>
                            <span class="text-[9px] font-black uppercase tracking-widest">Audit Sistem</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
