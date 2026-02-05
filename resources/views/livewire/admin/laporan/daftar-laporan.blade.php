<div>
    <div class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
            <svg class="h-5 w-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Filter Laporan
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Dari Tanggal</label>
                <input wire:model.live="tanggalMulai" type="date" class="w-full rounded-lg border-slate-300 text-sm focus:ring-cyan-500 focus:border-cyan-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Sampai Tanggal</label>
                <input wire:model.live="tanggalSelesai" type="date" class="w-full rounded-lg border-slate-300 text-sm focus:ring-cyan-500 focus:border-cyan-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Status Bayar</label>
                <select wire:model.live="statusFilter" class="w-full rounded-lg border-slate-300 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                    <option value="lunas">Lunas</option>
                    <option value="belum_dibayar">Belum Bayar</option>
                    <option value="">Semua</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button wire:click="$refresh" class="flex-1 bg-slate-900 text-white py-2 rounded-lg font-bold text-sm hover:bg-slate-800 transition">Terapkan</button>
            </div>
        </div>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-cyan-600 p-6 rounded-2xl shadow-lg shadow-cyan-900/20 text-white">
            <p class="text-cyan-100 text-sm font-medium uppercase tracking-wider">Total Omzet Penjualan</p>
            <h3 class="text-3xl font-extrabold mt-1">{{ 'Rp ' . number_format($totalOmzet, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Jumlah Transaksi</p>
            <h3 class="text-3xl font-extrabold mt-1 text-slate-900">{{ $totalPesanan }} Pesanan</h3>
        </div>
    </div>

    <!-- Tabel Rincian -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-900">Rincian Transaksi</h3>
            <button class="text-sm font-bold text-cyan-600 hover:text-cyan-700">Cetak PDF (Segera)</button>
        </div>
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Invoice / Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($pesanan as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="text-sm font-bold text-slate-900">{{ $p->nomor_invoice }}</p>
                        <p class="text-xs text-slate-500">{{ $p->created_at->format('d/m/Y H:i') }}</p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                        {{ $p->pengguna->nama }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-slate-900">
                        {{ 'Rp ' . number_format($p->total_harga, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-10 text-center text-slate-500">Tidak ada transaksi dalam rentang tanggal ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $pesanan->links() }}
        </div>
    </div>
</div>
