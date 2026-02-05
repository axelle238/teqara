<div class="space-y-12 pb-32">
    <!-- Header: Vibrant & Professional -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 border border-amber-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-amber-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Radar Antrian Transaksi</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">BERANDA <span class="text-amber-600">PESANAN</span></h1>
            <p class="text-slate-500 font-medium text-lg">Pantau alur transaksi masuk, verifikasi pembayaran, dan efisiensi pemrosesan unit.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pesanan.daftar') }}" wire:navigate class="px-8 py-4 bg-amber-500 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-amber-600 transition-all shadow-xl shadow-amber-500/20">DAFTAR PESANAN</a>
        </div>
    </div>

    <!-- Statistik Pilar: Colorful Order Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="bg-white p-8 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-12 h-12 rounded-[18px] bg-indigo-50 flex items-center justify-center text-indigo-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Total Pesanan Sistem</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($total_pesanan) }} <span class="text-sm text-slate-400 font-bold uppercase ml-1">Faktur</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-white p-8 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-12 h-12 rounded-[18px] bg-amber-50 flex items-center justify-center text-amber-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Menunggu Pembayaran</p>
                <h3 class="text-4xl font-black text-amber-600 tracking-tighter">{{ number_format($menunggu_bayar) }} <span class="text-sm text-slate-400 font-bold uppercase ml-1">Unit</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-white p-8 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-12 h-12 rounded-[18px] bg-blue-50 flex items-center justify-center text-blue-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                </div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Perlu Dikirim</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($perlu_dikirim) }} <span class="text-sm text-slate-400 font-bold uppercase ml-1">Resi</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-white p-8 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-12 h-12 rounded-[18px] bg-emerald-50 flex items-center justify-center text-emerald-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Selesai Bulan Ini</p>
                <h3 class="text-4xl font-black text-emerald-600 tracking-tighter">{{ number_format($selesai_bulan_ini) }} <span class="text-sm text-slate-400 font-bold uppercase ml-1">Sukses</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-500/5 rounded-full blur-3xl"></div>
        </div>
    </div>

    <!-- Feed Transaksi: No Dark Policy -->
    <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
        <div class="px-10 py-8 border-b border-indigo-50 bg-slate-50/30 flex items-center justify-between">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Radar Transaksi Terbaru</h3>
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Live Feed</span>
        </div>
        <div class="divide-y divide-indigo-50">
            @foreach($pesanan_terbaru as $p)
            <div class="px-10 py-6 flex items-center gap-8 group hover:bg-indigo-50/20 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center font-black text-indigo-600 shadow-sm group-hover:scale-110 transition-transform">
                    {{ substr($p->pengguna->nama ?? 'T', 0, 1) }}
                </div>
                <div class="flex-1 space-y-1">
                    <p class="font-black text-slate-900 text-base tracking-tight uppercase group-hover:text-indigo-600 transition-colors">#{{ $p->nomor_faktur }}</p>
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $p->pengguna->nama ?? 'Tamu' }}</span>
                        <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                        <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest bg-amber-50 px-2 py-0.5 rounded-md border border-amber-100">{{ $p->status_pembayaran }}</span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-black text-slate-900 tracking-tighter">Rp {{ number_format($p->total_harga) }}</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $p->created_at->diffForHumans() }}</p>
                </div>
                <a href="{{ route('admin.pesanan.detail', $p->id) }}" wire:navigate class="p-3 bg-white border border-indigo-100 text-indigo-400 hover:text-white hover:bg-indigo-600 rounded-2xl transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
