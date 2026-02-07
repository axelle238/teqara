<div class="space-y-8 animate-fade-in pb-20">
    <!-- Header Dasbor -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-slate-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Dasbor <span class="text-indigo-600">Eksekutif</span></h1>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-[0.2em] mt-2">Pusat Kendali Business Enterprise TEQARA</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="px-6 py-3 bg-emerald-50 rounded-2xl border border-emerald-100 flex items-center gap-3">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <span class="text-[10px] font-black text-emerald-700 uppercase tracking-widest">Sistem Sinkron</span>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ now()->translatedFormat('l, d F Y') }}</p>
                    <p id="jam-realtime" class="text-lg font-black text-slate-900 tracking-tight">00:00:00</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan 13 Pilar Manajemen -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- 1. Transaksi & Keuangan -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-indigo-500/5 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Keuangan</span>
            </div>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($this->statistik['pendapatan_hari_ini'], 0, ',', '.') }}</h3>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wide mt-1">Pendapatan Hari Ini</p>
        </div>

        <!-- 2. Produk & Inventaris -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-rose-500/5 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-laptop-code"></i>
                </div>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Inventaris</span>
            </div>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $this->statistik['total_produk'] }} Unit</h3>
            <p class="text-[10px] font-bold text-rose-500 uppercase tracking-wide mt-1">{{ $this->statistik['stok_kritis'] }} Stok Kritis</p>
        </div>

        <!-- 3. Pesanan & POS -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-500/5 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Pesanan</span>
            </div>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $this->statistik['pesanan_baru'] }} Baru</h3>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wide mt-1">{{ $this->statistik['pesanan_proses'] }} Sedang Diproses</p>
        </div>

        <!-- 4. Keamanan Siber -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-red-500/5 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Keamanan</span>
            </div>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $this->statistik['skor_keamanan'] }}%</h3>
            <p class="text-[10px] font-bold text-red-500 uppercase tracking-wide mt-1">{{ $this->statistik['insiden_keamanan_24j'] }} Insiden 24 Jam</p>
        </div>
    </div>

    <!-- Statistik Detail Modul -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Pesanan Terbaru & Log -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight">Pesanan Terbaru</h2>
                    </div>
                    <a href="{{ route('pengelola.pesanan.daftar') }}" wire:navigate class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline">Lihat Semua</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                                <th class="pb-4 px-2">ID Faktur</th>
                                <th class="pb-4 px-2">Pelanggan</th>
                                <th class="pb-4 px-2">Total</th>
                                <th class="pb-4 px-2 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($this->pesananTerbaru as $order)
                            <tr class="group hover:bg-slate-50 transition-colors">
                                <td class="py-4 px-2 font-mono text-xs font-bold text-slate-700">#{{ $order->nomor_faktur }}</td>
                                <td class="py-4 px-2">
                                    <p class="text-xs font-bold text-slate-900">{{ $order->pengguna->nama }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $order->dibuat_pada->diffForHumans() }}</p>
                                </td>
                                <td class="py-4 px-2 text-xs font-black text-slate-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td class="py-4 px-2 text-right">
                                    <span class="px-3 py-1 bg-slate-100 rounded-lg text-[9px] font-black uppercase tracking-widest">{{ $order->status_pesanan }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Status Modul Terintegrasi -->
        <div class="space-y-6">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
                <h2 class="text-white font-black uppercase tracking-widest text-xs mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-circle-nodes text-indigo-400"></i> Integrasi Modul
                </h2>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-user-tie text-lime-400 text-sm"></i>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wide">SDM (Human Capital)</span>
                        </div>
                        <span class="text-xs font-black text-white">{{ $this->statistik['total_staf'] }} Staf</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-industry text-blue-400 text-sm"></i>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wide">Vendor & Rantai Pasok</span>
                        </div>
                        <span class="text-xs font-black text-white">{{ $this->statistik['total_mitra_vendor'] }} Mitra</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-network-wired text-cyan-400 text-sm"></i>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wide">API & Integrasi</span>
                        </div>
                        <span class="text-xs font-black text-white">{{ $this->statistik['total_kunci_api'] }} Kunci</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-headset text-violet-400 text-sm"></i>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wide">Layanan Bantuan</span>
                        </div>
                        <span class="text-xs font-black text-white">{{ $this->statistik['tiket_aktif'] }} Tiket</span>
                    </div>
                </div>
            </div>

            <!-- Audit Trail Singkat -->
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 flex items-center justify-between">
                    <span>Audit Trail Terkini</span>
                    <i class="fa-solid fa-fingerprint text-indigo-500"></i>
                </h3>
                <div class="space-y-4">
                    @foreach($this->logAktivitas as $log)
                    <div class="flex gap-3 items-start group">
                        <div class="w-1 bg-indigo-100 group-hover:bg-indigo-500 h-8 rounded-full transition-colors"></div>
                        <div>
                            <p class="text-[11px] font-bold text-slate-700 leading-tight">{{ $log->pesan_naratif }}</p>
                            <p class="text-[9px] text-slate-400 mt-1 uppercase font-black tracking-widest">{{ $log->waktu->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateJam() {
            const el = document.getElementById('jam-realtime');
            if (el) {
                el.textContent = new Date().toLocaleTimeString('id-ID', { hour12: false });
            }
        }
        setInterval(updateJam, 1000);
        updateJam();
    </script>
</div>
