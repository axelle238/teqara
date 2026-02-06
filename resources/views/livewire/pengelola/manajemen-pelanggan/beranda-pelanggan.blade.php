<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Customer Relationship (CRM)</h1>
            <p class="text-slate-500 text-sm mt-1">Analisis basis pelanggan dan loyalitas.</p>
        </div>
        <a href="{{ route('pengelola.pelanggan.daftar') }}" wire:navigate class="px-5 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg hover:bg-indigo-700 transition-all">
            Kelola Data Pelanggan
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Pelanggan</p>
            <h3 class="text-3xl font-black text-slate-900 mt-2">{{ number_format($stats['total']) }}</h3>
        </div>
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Pelanggan Baru</p>
            <h3 class="text-3xl font-black text-indigo-600 mt-2">+{{ number_format($stats['baru']) }}</h3>
            <p class="text-xs text-slate-400 mt-1">Bulan Ini</p>
        </div>
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Pengguna Aktif</p>
            <h3 class="text-3xl font-black text-emerald-600 mt-2">{{ number_format($stats['aktif']) }}</h3>
            <p class="text-xs text-slate-400 mt-1">Belanja 30 Hari Terakhir</p>
        </div>
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Retensi</p>
            <h3 class="text-3xl font-black text-amber-500 mt-2">{{ number_format($stats['retention_rate'], 1) }}%</h3>
        </div>
    </div>

    <!-- Top Spenders -->
    <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm p-8">
        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Pelanggan Loyal (Top Spenders)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-black tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4 text-right">Total Belanja</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($topSpenders as $user)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-600">
                                    {{ substr($user->nama, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900">{{ $user->nama }}</p>
                                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right font-mono font-bold text-slate-900">
                            Rp {{ number_format($user->pesanan_sum_total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-black uppercase tracking-widest">
                                VIP
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
