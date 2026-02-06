<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Business Intelligence</h1>
            <p class="text-slate-500 text-sm mt-1">Analitik mendalam performa penjualan dan profitabilitas.</p>
        </div>
        <button wire:click="eksporExcel" class="flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-600/20 transition-all active:scale-95">
            <i class="fa-solid fa-file-excel"></i> Ekspor Laporan
        </button>
    </div>

    <!-- Filter Control -->
    <div class="bg-white p-4 rounded-[24px] border border-slate-100 shadow-sm flex flex-col md:flex-row gap-4 items-end md:items-center">
        <div class="flex gap-2 items-center flex-1 w-full">
            <div class="bg-slate-50 p-2 rounded-xl border border-slate-200 flex items-center gap-2">
                <i class="fa-regular fa-calendar text-slate-400 text-xs ml-2"></i>
                <input wire:model.live="tanggalMulai" type="date" class="bg-transparent border-none text-xs font-bold text-slate-700 focus:ring-0 p-0">
                <span class="text-slate-300">-</span>
                <input wire:model.live="tanggalSelesai" type="date" class="bg-transparent border-none text-xs font-bold text-slate-700 focus:ring-0 p-0">
            </div>
            <select wire:model.live="statusFilter" class="bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 py-2.5 px-4 focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                <option value="lunas">Penjualan Lunas</option>
                <option value="menunggu_verifikasi">Pending Bayar</option>
                <option value="">Semua Transaksi</option>
            </select>
        </div>
    </div>

    <!-- KPI Cards (Financial) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Omzet -->
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-all">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-wallet text-6xl text-indigo-500"></i>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Omzet</p>
            <h3 class="text-2xl font-black text-slate-900 mt-2">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-slate-400 mt-1">Periode Terpilih</p>
        </div>

        <!-- Profit -->
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-all">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-money-bill-trend-up text-6xl text-emerald-500"></i>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Estimasi Profit</p>
            <h3 class="text-2xl font-black text-emerald-600 mt-2">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                <span class="text-emerald-500 font-bold bg-emerald-50 px-1 rounded">{{ number_format($marginProfit, 1) }}%</span> Margin
            </p>
        </div>

        <!-- Volume -->
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-all">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-boxes-packing text-6xl text-amber-500"></i>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Volume Transaksi</p>
            <h3 class="text-2xl font-black text-slate-900 mt-2">{{ number_format($totalPesanan) }}</h3>
            <p class="text-[10px] text-slate-400 mt-1">Invoice Terbit</p>
        </div>

        <!-- Forecasting -->
        <div class="bg-slate-900 p-6 rounded-[24px] text-white relative overflow-hidden group hover:-translate-y-1 transition-all">
            <div class="absolute right-0 top-0 p-4 opacity-10">
                <i class="fa-solid fa-crystal-ball text-6xl text-fuchsia-500"></i>
            </div>
            <p class="text-xs font-black text-indigo-300 uppercase tracking-widest">Proyeksi 30 Hari</p>
            <h3 class="text-2xl font-black mt-2">Rp {{ number_format($analitik['proyeksi'], 0, ',', '.') }}</h3>
            <p class="text-[10px] text-slate-400 mt-1">Berdasarkan rata-rata harian</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Sales Trend Chart (CSS Only) -->
        <div class="lg:col-span-2 bg-white rounded-[24px] border border-slate-100 shadow-sm p-8">
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Tren Penjualan Harian</h3>
                <span class="text-xs font-bold text-slate-400">Visualisasi Area</span>
            </div>
            
            <div class="h-64 flex items-end justify-between gap-1">
                @php 
                    $maxOmzet = $analitik['tren_chart']->max() ?: 1; 
                @endphp
                @foreach($analitik['tren_chart'] as $tgl => $omzet)
                    <div class="flex-1 flex flex-col items-center group relative h-full justify-end">
                        <div class="w-full bg-indigo-50 rounded-t-sm relative transition-all duration-500 group-hover:bg-indigo-200" style="height: {{ ($omzet / $maxOmzet) * 100 }}%">
                            <!-- Tooltip -->
                            <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[9px] font-bold py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-20">
                                {{ \Carbon\Carbon::parse($tgl)->format('d M') }}: Rp {{ number_format($omzet/1000, 0) }}k
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 flex justify-between text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                <span>{{ \Carbon\Carbon::parse($this->tanggalMulai)->format('d M') }}</span>
                <span>Periode Laporan</span>
                <span>{{ \Carbon\Carbon::parse($this->tanggalSelesai)->format('d M') }}</span>
            </div>
        </div>

        <!-- Top Categories -->
        <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm p-8">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Kontribusi Kategori</h3>
            <div class="space-y-4">
                @php $totalKategori = array_sum($omzetPerKategori) ?: 1; @endphp
                @foreach(array_slice($omzetPerKategori, 0, 5) as $kat => $val)
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1">
                        <span class="text-slate-700">{{ $kat }}</span>
                        <span class="text-slate-500">{{ number_format(($val / $totalKategori) * 100, 1) }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-fuchsia-500 h-full rounded-full" style="width: {{ ($val / $totalKategori) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Data Table Detail -->
    <div class="bg-white border border-slate-100 rounded-[24px] shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Rincian Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-black tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Faktur</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4 text-right">Nominal</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pesanan as $p)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-xs text-slate-500 font-mono">
                            {{ $p->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 font-bold text-indigo-600">
                            {{ $p->nomor_faktur }}
                        </td>
                        <td class="px-6 py-4 text-slate-700 font-medium">
                            {{ $p->pengguna->nama }}
                        </td>
                        <td class="px-6 py-4 text-right font-mono font-bold text-slate-900">
                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($p->status_pembayaran == 'lunas')
                                <span class="text-emerald-600 text-[10px] font-black uppercase"><i class="fa-solid fa-check"></i> Paid</span>
                            @else
                                <span class="text-amber-600 text-[10px] font-black uppercase"><i class="fa-solid fa-clock"></i> Pending</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            Tidak ada data transaksi pada periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $pesanan->links() }}
        </div>
    </div>
</div>