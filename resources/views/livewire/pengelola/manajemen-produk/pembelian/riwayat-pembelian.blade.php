<div class="space-y-12 pb-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em]">Procurement System</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">PEMBELIAN <span class="text-indigo-600">STOK</span></h1>
            <p class="text-slate-500 font-medium text-lg">Manajemen pengadaan barang masuk (Inbound) dari mitra pemasok.</p>
        </div>
        <a href="{{ route('pengelola.produk.pembelian.baru') }}" wire:navigate class="px-8 py-4 bg-indigo-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Order Pembelian
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Transaksi</p>
            <h3 class="text-3xl font-black text-slate-900">{{ number_format($stats['total_transaksi']) }}</h3>
        </div>
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Pengeluaran</p>
            <h3 class="text-3xl font-black text-slate-900">Rp {{ number_format($stats['total_pengeluaran'], 0, ',', '.') }}</h3>
        </div>
        <div class="bg-amber-50 p-8 rounded-[40px] border border-amber-100">
            <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-2">Menunggu Finalisasi</p>
            <h3 class="text-3xl font-black text-amber-700">{{ number_format($stats['draft']) }} <span class="text-xs">Draft</span></h3>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">No Faktur</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Pemasok</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Total Biaya</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Status</th>
                        <th class="px-10 py-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($riwayat as $r)
                    <tr class="group hover:bg-slate-50 transition-all">
                        <td class="px-10 py-6">
                            <p class="text-sm font-black text-slate-900 font-mono">{{ $r->no_faktur }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $r->created_at->format('d M Y') }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <span class="text-xs font-bold text-slate-700 uppercase">{{ $r->pemasok->nama_perusahaan ?? 'Umum' }}</span>
                        </td>
                        <td class="px-6 py-6">
                            <span class="text-sm font-black text-slate-900">Rp {{ number_format($r->total_biaya, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-6">
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $r->status === 'selesai' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                {{ $r->status }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <a href="{{ route('pengelola.produk.pembelian.detail', $r->id) }}" wire:navigate class="px-6 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                Kelola
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-10 py-20 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">Belum ada data pembelian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-10 border-t border-slate-50">{{ $riwayat->links() }}</div>
    </div>
</div>
