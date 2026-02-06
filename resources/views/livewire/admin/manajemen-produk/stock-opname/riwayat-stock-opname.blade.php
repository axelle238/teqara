<div class="space-y-12 pb-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em]">Inventory Audit System</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">STOCK <span class="text-blue-600">OPNAME</span></h1>
            <p class="text-slate-500 font-medium text-lg">Validasi integritas data sistem dengan penghitungan fisik gudang.</p>
        </div>
        <button wire:click="mulaiSesiBaru" class="px-8 py-4 bg-blue-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Sesi Audit Baru
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Sesi Audit</p>
                <h3 class="text-3xl font-black text-slate-900">{{ number_format($stats['total']) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
        </div>
        <div class="bg-amber-50 p-8 rounded-[40px] border border-amber-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-2">Sedang Berlangsung</p>
                <h3 class="text-3xl font-black text-amber-700">{{ number_format($stats['proses']) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="bg-emerald-50 p-8 rounded-[40px] border border-emerald-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2">Selesai Final</p>
                <h3 class="text-3xl font-black text-emerald-700">{{ number_format($stats['selesai']) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>
    </div>

    <!-- History Table -->
    <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Kode & Tanggal</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Auditor</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Status</th>
                        <th class="px-10 py-6 text-right">Otoritas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($riwayat as $r)
                    <tr class="group hover:bg-slate-50 transition-all">
                        <td class="px-10 py-6">
                            <p class="text-sm font-black text-slate-900 font-mono">{{ $r->kode_so }}</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $r->created_at->translatedFormat('d F Y') }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xs font-black">
                                    {{ substr($r->petugas->nama ?? 'S', 0, 1) }}
                                </div>
                                <span class="text-xs font-bold text-slate-700 uppercase">{{ $r->petugas->nama ?? 'System' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border 
                                {{ $r->status === 'selesai' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 
                                   ($r->status === 'proses' ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-slate-50 text-slate-500 border-slate-200') }}">
                                {{ $r->status }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <a href="{{ route('admin.produk.so.detail', $r->id) }}" wire:navigate class="px-6 py-2 bg-white border border-indigo-100 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                                Detail Audit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-10 py-20 text-center text-slate-400 font-black uppercase tracking-widest text-xs">Belum ada sesi stock opname.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-10 border-t border-slate-50 bg-slate-50/30">{{ $riwayat->links() }}</div>
    </div>
</div>
