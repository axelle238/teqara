<div class="space-y-10">
    <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">VALIDASI <span class="text-amber-600">PEMBAYARAN</span></h1>
        <p class="text-slate-500 font-medium">Verifikasi arus kas masuk untuk aktivasi proses logistik.</p>
    </div>

    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex items-center gap-2">
            <button wire:click="$set('filterStatus', 'menunggu_verifikasi')" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $filterStatus === 'menunggu_verifikasi' ? 'bg-amber-500 text-white' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">MENUNGGU ({{ \App\Models\Pesanan::where('status_pembayaran', 'menunggu_verifikasi')->count() }})</button>
            <button wire:click="$set('filterStatus', 'lunas')" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $filterStatus === 'lunas' ? 'bg-emerald-500 text-white' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">TERVERIFIKASI</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Transaksi</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelanggan</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nominal</th>
                        <th class="px-8 py-5 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pembayaran as $p)
                    <tr class="group hover:bg-slate-50/50 transition">
                        <td class="px-8 py-5">
                            <p class="text-sm font-black text-slate-900 tracking-tight">#{{ $p->nomor_invoice }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $p->created_at->format('d/m/Y H:i') }}</p>
                        </td>
                        <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $p->pengguna->nama }}</td>
                        <td class="px-6 py-5 text-sm font-black text-slate-900">Rp {{ number_format($p->total_harga) }}</td>
                        <td class="px-8 py-5 text-right">
                            @if($p->status_pembayaran === 'menunggu_verifikasi')
                            <button wire:click="verifikasi({{ $p->id }})" class="px-6 py-2 bg-emerald-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 transition shadow-lg shadow-emerald-600/20">Setujui</button>
                            @else
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold">Tidak ada antrian verifikasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-slate-50/30">{{ $pembayaran->links() }}</div>
    </div>
</div>
