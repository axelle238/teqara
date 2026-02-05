<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">MANAJEMEN <span class="text-indigo-600">PESANAN</span></h1>
            <p class="text-slate-500 font-medium">Pusat kendali transaksi dan logistik pengiriman.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Transaksi</p>
            <p class="text-3xl font-black text-slate-900">{{ number_format($total_pesanan) }}</p>
        </div>
        <div class="bg-amber-50 p-6 rounded-[32px] border border-amber-100">
            <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-2">Belum Dibayar</p>
            <p class="text-3xl font-black text-amber-700">{{ number_format($menunggu_bayar) }}</p>
        </div>
        <div class="bg-cyan-50 p-6 rounded-[32px] border border-cyan-100">
            <p class="text-[10px] font-black text-cyan-600 uppercase tracking-widest mb-2">Perlu Dikirim</p>
            <p class="text-3xl font-black text-cyan-700">{{ number_format($perlu_dikirim) }}</p>
        </div>
        <div class="bg-emerald-50 p-6 rounded-[32px] border border-emerald-100">
            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2">Selesai Bulan Ini</p>
            <p class="text-3xl font-black text-emerald-700">{{ number_format($selesai_bulan_ini) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm p-8">
        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Aktivitas Pesanan Terkini</h3>
        <div class="space-y-4">
            @foreach($pesanan_terbaru as $p)
            <div class="flex items-center justify-between border-b border-slate-50 pb-4 last:border-0 last:pb-0">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-xs font-black">{{ substr($p->pengguna->nama ?? 'U', 0, 1) }}</div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">#{{ $p->nomor_invoice }} - {{ $p->pengguna->nama ?? 'Tamu' }}</p>
                        <p class="text-xs text-slate-500">{{ $p->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $p->status_pesanan == 'selesai' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-600' }}">
                    {{ $p->status_pesanan }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>
