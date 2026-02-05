<div class="space-y-10">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">MANAJEMEN <span class="text-indigo-600">TRANSAKSI</span></h1>
            <p class="text-slate-500 font-medium">Pemantauan arus kas, verifikasi gerbang pembayaran, dan rekonsiliasi bank.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Omzet Bruto</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tighter">Rp {{ number_format($total_omzet) }}</h3>
        </div>
        <div class="bg-amber-50 p-8 rounded-[40px] border border-amber-100">
            <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-2">Pending Verifikasi</p>
            <h3 class="text-3xl font-black text-amber-700 tracking-tighter">{{ number_format($pending_verifikasi) }} Transaksi</h3>
        </div>
        <div class="bg-red-50 p-8 rounded-[40px] border border-red-100">
            <p class="text-[10px] font-black text-red-600 uppercase tracking-widest mb-2">Pembayaran Gagal</p>
            <h3 class="text-3xl font-black text-red-700 tracking-tighter">{{ number_format($gagal_bayar) }} Unit</h3>
        </div>
    </div>

    <div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Aktivitas Gerbang Pembayaran</h3>
            <a href="{{ route('admin.pesanan.verifikasi') }}" wire:navigate class="text-xs font-black text-indigo-600 hover:underline uppercase tracking-widest">Buka Validasi</a>
        </div>
        <div class="divide-y divide-slate-50">
            @foreach($transaksi_terbaru as $t)
            <div class="px-8 py-5 flex items-center justify-between hover:bg-slate-50 transition">
                <div>
                    <p class="font-bold text-slate-900 text-sm">Inv: #{{ $t->nomor_faktur }}</p>
                    <p class="text-xs text-slate-400">{{ $t->pengguna->nama }} • {{ $t->created_at->diffForHumans() }}</p>
                </div>
                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $t->status_pembayaran == 'lunas' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-600' }}">
                    {{ str_replace('_', ' ', $t->status_pembayaran) }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>
