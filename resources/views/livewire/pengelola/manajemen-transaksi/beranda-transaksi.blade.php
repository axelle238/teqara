<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Kontrol Finansial</h1>
            <p class="text-slate-500 text-sm mt-1">Monitoring arus kas masuk dan verifikasi pembayaran digital.</p>
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition-colors">
                <i class="fa-solid fa-download mr-2"></i> Unduh Laporan Keuangan
            </button>
        </div>
    </div>

    <!-- Financial Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Revenue -->
        <div class="bg-slate-900 rounded-[24px] p-6 text-white relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-10">
                <i class="fa-solid fa-vault text-6xl"></i>
            </div>
            <p class="text-xs font-black text-indigo-300 uppercase tracking-widest mb-1">Total Kas Masuk</p>
            <h3 class="text-3xl font-black tracking-tight">Rp {{ number_format($stats['total_masuk'], 0, ',', '.') }}</h3>
            <p class="text-xs text-slate-400 mt-2 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Sistem Real-time
            </p>
        </div>

        <!-- Transaction Volume -->
        <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <i class="fa-solid fa-check-double"></i>
                </div>
                <span class="text-2xl font-black text-slate-900">{{ $stats['sukses'] }}</span>
            </div>
            <p class="text-sm font-bold text-slate-600">Transaksi Sukses</p>
            <p class="text-xs text-slate-400 mt-1">Pembayaran terverifikasi gateway.</p>
        </div>

        <!-- Pending Volume -->
        <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
                <span class="text-2xl font-black text-slate-900">{{ $stats['pending'] }}</span>
            </div>
            <p class="text-sm font-bold text-slate-600">Menunggu Pembayaran</p>
            <p class="text-xs text-slate-400 mt-1">Tagihan aktif belum dibayar.</p>
        </div>
    </div>

    <!-- Transaction List -->
    <div class="bg-white border border-slate-100 rounded-[24px] shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Riwayat Transaksi</h3>
            
            <div class="flex gap-2">
                <select wire:model.live="filterMetode" class="bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 py-2 px-4 focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                    <option value="">Semua Metode</option>
                    <option value="bank_transfer">Transfer Bank</option>
                    <option value="qris">QRIS</option>
                </select>
                <div class="relative">
                    <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Kode Transaksi..." class="pl-8 pr-4 py-2 bg-slate-50 border-none rounded-xl text-xs font-medium focus:ring-2 focus:ring-indigo-500 w-48">
                    <i class="fa-solid fa-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-black tracking-wider">
                    <tr>
                        <th class="px-6 py-4">ID Transaksi</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Metode</th>
                        <th class="px-6 py-4">Nominal</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transaksi as $trx)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-slate-900 text-xs block">{{ $trx->kode_pembayaran }}</span>
                            <a href="{{ route('pengelola.pesanan.detail', $trx->pesanan_id) }}" class="text-[10px] text-indigo-500 hover:underline">Ref: {{ $trx->pesanan->nomor_faktur ?? '-' }}</a>
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-xs">
                            {{ $trx->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 rounded bg-slate-100 text-slate-700 text-[10px] font-black uppercase tracking-wide">
                                    {{ $trx->provider }}
                                </span>
                                <span class="text-xs text-slate-500 capitalize">{{ str_replace('_', ' ', $trx->metode_pembayaran) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-mono font-bold text-slate-900">
                            Rp {{ number_format($trx->jumlah_bayar, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($trx->status == 'success')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-700">
                                    <i class="fa-solid fa-check-circle"></i> Berhasil
                                </span>
                            @elseif($trx->status == 'pending')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-amber-100 text-amber-700">
                                    <i class="fa-solid fa-clock"></i> Pending
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-rose-100 text-rose-700">
                                    <i class="fa-solid fa-times-circle"></i> Gagal
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            Belum ada data transaksi finansial.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $transaksi->links() }}
        </div>
    </div>
</div>
