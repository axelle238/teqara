<div class="space-y-12 pb-32">
    <!-- Header Ledger -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">BUKU BESAR <span class="text-indigo-600">KEUANGAN</span></h1>
            <p class="text-slate-500 font-medium text-lg">Rekonsiliasi arus kas masuk dan keluar secara real-time.</p>
        </div>
        <div class="flex gap-2">
            <button wire:click="$set('filterWaktu', 'minggu_ini')" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterWaktu === 'minggu_ini' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-slate-50 text-slate-400 hover:bg-slate-100' }}">Minggu Ini</button>
            <button wire:click="$set('filterWaktu', 'bulan_ini')" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterWaktu === 'bulan_ini' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-slate-50 text-slate-400 hover:bg-slate-100' }}">Bulan Ini</button>
        </div>
    </div>

    <!-- Ringkasan Saldo -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-emerald-50 p-8 rounded-[40px] border border-emerald-100">
            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2">Total Pemasukan (Debit)</p>
            <h3 class="text-3xl font-black text-emerald-700 tracking-tighter">+ Rp {{ number_format($ringkasan['masuk'], 0, ',', '.') }}</h3>
        </div>
        <div class="bg-rose-50 p-8 rounded-[40px] border border-rose-100">
            <p class="text-[10px] font-black text-rose-600 uppercase tracking-widest mb-2">Estimasi Pengeluaran (Kredit)</p>
            <h3 class="text-3xl font-black text-rose-700 tracking-tighter">- Rp {{ number_format($ringkasan['keluar'], 0, ',', '.') }}</h3>
        </div>
        <div class="bg-indigo-900 p-8 rounded-[40px] shadow-xl shadow-indigo-900/20 text-white relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-2">Saldo Kas Bersih</p>
                <h3 class="text-4xl font-black tracking-tighter">Rp {{ number_format($ringkasan['saldo'], 0, ',', '.') }}</h3>
            </div>
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-[60px]"></div>
        </div>
    </div>

    <!-- Tabel Ledger -->
    <div class="bg-white rounded-[48px] border border-indigo-50 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 border-b border-indigo-50">
                    <tr>
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Tanggal Transaksi</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Referensi & Keterangan</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] text-right">Debit (Masuk)</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] text-right">Kredit (Keluar)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transaksi as $t)
                    <tr class="group hover:bg-slate-50 transition-all">
                        <td class="px-10 py-5">
                            <p class="text-xs font-bold text-slate-900 font-mono">{{ $t->created_at->format('d/m/Y') }}</p>
                            <p class="text-[10px] text-slate-400 font-black uppercase">{{ $t->created_at->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm font-black text-slate-900 uppercase tracking-tight">Pembayaran Pesanan #{{ $t->nomor_faktur }}</p>
                            <p class="text-[10px] text-slate-500 font-bold mt-0.5">Pelanggan: {{ $t->pengguna->nama }}</p>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <span class="text-sm font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100">
                                + Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <span class="text-xs font-bold text-slate-300">-</span>
                        </td>
                    </tr>
                    <!-- Simulasi Pengeluaran Otomatis (HPP) untuk tampilan Ledger -->
                    <tr class="bg-rose-50/10">
                        <td class="px-10 py-3 pl-16 border-l-4 border-rose-100">
                            <p class="text-[10px] text-slate-400 font-mono">{{ $t->created_at->format('d/m/Y') }}</p>
                        </td>
                        <td class="px-6 py-3">
                            <p class="text-xs font-bold text-rose-800 uppercase">Beban Pokok Penjualan (COGS)</p>
                            <p class="text-[9px] text-rose-400 mt-0.5">Estimasi HPP (30%) Ref #{{ $t->nomor_faktur }}</p>
                        </td>
                        <td class="px-6 py-3 text-right"><span class="text-xs font-bold text-slate-300">-</span></td>
                        <td class="px-6 py-3 text-right">
                            <span class="text-xs font-bold text-rose-600">
                                - Rp {{ number_format($t->total_harga * 0.3, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-10 py-20 text-center text-slate-400 font-bold uppercase text-xs tracking-widest">Belum ada transaksi tercatat periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-slate-50 bg-slate-50/30">{{ $transaksi->links() }}</div>
    </div>
</div>
