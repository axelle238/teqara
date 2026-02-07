<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Financial Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-[30px] p-8 text-white relative overflow-hidden shadow-xl shadow-emerald-600/30 md:col-span-2">
            <div class="absolute -right-10 -bottom-10 opacity-20">
                <i class="fa-solid fa-sack-dollar text-9xl"></i>
            </div>
            <p class="text-xs font-black uppercase tracking-widest text-emerald-200 mb-2">Total Pemasukan (Net)</p>
            <h3 class="text-5xl font-black tracking-tight mb-4">Rp {{ number_format($this->ringkasan['total_masuk'], 0, ',', '.') }}</h3>
            <div class="flex items-center gap-2 text-emerald-100 text-xs font-bold">
                <i class="fa-solid fa-arrow-trend-up"></i> Arus Kas Positif
            </div>
        </div>

        <div class="bg-white rounded-[30px] p-8 border border-slate-100 shadow-sm flex flex-col justify-center">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Volume Transaksi</p>
            <h3 class="text-4xl font-black text-slate-900">{{ $this->ringkasan['transaksi_sukses'] }} <span class="text-sm text-slate-400 font-bold">Sukses</span></h3>
            <p class="text-xs font-bold text-amber-500 mt-2">{{ $this->ringkasan['transaksi_pending'] }} Menunggu Verifikasi</p>
        </div>

        <div class="bg-white rounded-[30px] p-8 border border-slate-100 shadow-sm flex flex-col justify-center">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Rata-rata Order</p>
            <h3 class="text-2xl font-black text-indigo-600">Rp {{ number_format($this->ringkasan['rata_rata'], 0, ',', '.') }}</h3>
            <p class="text-[10px] text-slate-400 mt-2">Per Transaksi</p>
        </div>
    </div>

    <!-- Transaction List -->
    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden min-h-[500px]">
        <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Jurnal Transaksi Masuk</h3>
            
            <div class="flex gap-4">
                <div class="relative w-64">
                    <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Kode Bayar..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                </div>
                <select wire:model.live="filterMetode" class="bg-slate-50 border-none rounded-xl px-4 py-2.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                    <option value="">Semua Metode</option>
                    <option value="transfer_bank">Transfer Bank</option>
                    <option value="midtrans">Midtrans (Otomatis)</option>
                    <option value="cod">COD (Bayar Ditempat)</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu & Kode</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelanggan</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Metode</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Nominal</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transaksi as $trx)
                    <tr class="group hover:bg-slate-50 transition-all">
                        <td class="px-8 py-5">
                            <span class="block text-xs font-bold text-slate-500">{{ $trx->dibuat_pada->format('d M Y, H:i') }}</span>
                            <span class="font-mono text-xs font-black text-slate-800">{{ $trx->kode_pembayaran }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm font-bold text-slate-800">{{ $trx->pesanan->pengguna->nama ?? 'Guest' }}</p>
                            <p class="text-[10px] text-slate-400">Order #{{ $trx->pesanan->nomor_faktur ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-5">
                            @if($trx->metode_pembayaran == 'midtrans')
                                <span class="flex items-center gap-2 text-xs font-bold text-indigo-600"><i class="fa-solid fa-robot"></i> Gateway</span>
                            @elseif($trx->metode_pembayaran == 'transfer_bank')
                                <span class="flex items-center gap-2 text-xs font-bold text-slate-600"><i class="fa-solid fa-building-columns"></i> Manual</span>
                            @else
                                <span class="text-xs font-bold text-slate-600 uppercase">{{ $trx->metode_pembayaran }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right">
                            <span class="font-black text-slate-900 text-sm">Rp {{ number_format($trx->jumlah_bayar, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @php
                                $statusClass = match($trx->status) {
                                    'sukses' => 'bg-emerald-100 text-emerald-700',
                                    'menunggu' => 'bg-amber-100 text-amber-700 animate-pulse',
                                    'gagal' => 'bg-rose-100 text-rose-700',
                                    default => 'bg-slate-100 text-slate-600'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $statusClass }}">
                                {{ $trx->status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            @if($trx->status == 'menunggu' && $trx->metode_pembayaran == 'transfer_bank')
                                <button wire:click="verifikasiManual({{ $trx->id }})" wire:confirm="Konfirmasi pembayaran ini valid?" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-500/20 transition-all">
                                    <i class="fa-solid fa-check mr-1"></i> Terima
                                </button>
                            @else
                                <span class="text-slate-300 text-lg"><i class="fa-solid fa-lock"></i></span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">
                            Tidak ada data transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-8 border-t border-slate-50">
            {{ $transaksi->links() }}
        </div>
    </div>
</div>