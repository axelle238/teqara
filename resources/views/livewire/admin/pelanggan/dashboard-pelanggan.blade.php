<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">MANAJEMEN <span class="text-pink-600">PELANGGAN</span></h1>
            <p class="text-slate-500 font-medium">Analisis pertumbuhan member dan loyalitas pelanggan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm flex items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-pink-50 flex items-center justify-center text-pink-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Pelanggan Aktif</p>
                <p class="text-4xl font-black text-slate-900">{{ number_format($total_pelanggan) }}</p>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm flex items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Bergabung Bulan Ini</p>
                <p class="text-4xl font-black text-emerald-600">+{{ number_format($pelanggan_baru_bulan_ini) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Pelanggan Terbaru</h3>
        </div>
        <div class="divide-y divide-slate-50">
            @foreach($pelanggan_terbaru as $u)
            <div class="px-8 py-4 flex items-center gap-4 hover:bg-slate-50 transition">
                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500">{{ substr($u->nama, 0, 1) }}</div>
                <div>
                    <p class="font-bold text-slate-900 text-sm">{{ $u->nama }}</p>
                    <p class="text-xs text-slate-400">{{ $u->email }} • Bergabung {{ $u->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
