<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">VALIDASI <span class="text-amber-600">PEMBAYARAN</span></h1>
            <p class="text-slate-500 font-medium">Verifikasi arus kas masuk untuk aktivasi proses logistik.</p>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        
        <!-- Filter Tabs -->
        <div class="p-6 border-b border-slate-50 flex items-center gap-2 overflow-x-auto">
            <button wire:click="$set('filterStatus', 'menunggu')" 
                class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $filterStatus === 'menunggu' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/30' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">
                MENUNGGU
            </button>
            <button wire:click="$set('filterStatus', 'sukses')" 
                class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $filterStatus === 'sukses' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">
                BERHASIL
            </button>
            <button wire:click="$set('filterStatus', 'gagal')" 
                class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $filterStatus === 'gagal' ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/30' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">
                DITOLAK
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Faktur & Waktu</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pelanggan</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Metode</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Nominal</th>
                        <th class="px-8 py-5 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pembayaran as $p)
                    <tr class="group hover:bg-amber-50/30 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-900 tracking-tight">#{{ $p->pesanan->nomor_faktur ?? 'N/A' }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $p->created_at->format('d M Y • H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-black text-slate-500 border border-slate-200 uppercase">
                                    {{ substr($p->pesanan->pengguna->nama ?? 'U', 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-slate-700">{{ $p->pesanan->pengguna->nama ?? 'Pengguna Dihapus' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-slate-800 uppercase">{{ str_replace('_', ' ', $p->metode_pembayaran) }}</span>
                                <span class="text-[10px] text-slate-400 font-bold">{{ $p->provider }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-sm font-black text-slate-900">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            @if($p->status === 'menunggu')
                                <div class="flex justify-end gap-2">
                                    <button 
                                        wire:click="tolak({{ $p->id }})" 
                                        wire:confirm="Yakin ingin menolak pembayaran ini?"
                                        class="px-4 py-2 bg-white border border-rose-100 text-rose-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-50 transition"
                                    >
                                        Tolak
                                    </button>
                                    <button 
                                        wire:click="verifikasi({{ $p->id }})" 
                                        wire:confirm="Pastikan dana sudah masuk. Verifikasi sekarang?"
                                        class="px-4 py-2 bg-emerald-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 transition shadow-lg shadow-emerald-500/30"
                                    >
                                        Verifikasi
                                    </button>
                                </div>
                            @else
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest 
                                    {{ $p->status === 'sukses' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                                    {{ $p->status }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="text-slate-400 font-bold text-sm tracking-tight">Tidak ada data transaksi pada status ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-6 bg-slate-50/30 border-t border-slate-50">
            {{ $pembayaran->links() }}
        </div>
    </div>
</div>