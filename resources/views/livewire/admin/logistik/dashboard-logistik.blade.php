<div class="space-y-10">
    <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">LOGISTIK <span class="text-emerald-600">PENGIRIMAN</span></h1>
        <p class="text-slate-500 font-medium">Manajemen armada, tracking resi, dan optimalisasi rantai distribusi.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Siap Packing</p>
            <h3 class="text-3xl font-black text-slate-900">{{ $siap_dikirim }} Unit</h3>
        </div>
        <div class="bg-emerald-50 p-8 rounded-[40px] border border-emerald-100">
            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2">Dalam Perjalanan</p>
            <h3 class="text-3xl font-black text-emerald-700">{{ $sedang_dikirim }} Unit</h3>
        </div>
        <div class="bg-indigo-50 p-8 rounded-[40px] border border-indigo-100">
            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-2">Terantar Berhasil</p>
            <h3 class="text-3xl font-black text-indigo-700">{{ $sampai_tujuan }} Unit</h3>
        </div>
    </div>

    <div class="bg-slate-900 rounded-[48px] p-10 text-white shadow-2xl relative overflow-hidden">
        <div class="relative z-10">
            <h3 class="text-xl font-black mb-2 tracking-tight">Otomasi Kurir</h3>
            <p class="text-sm text-slate-400 mb-8 max-w-md">Integrasi API dengan JNE, Sicepat, dan J&T untuk pembaharuan resi otomatis.</p>
            <button class="px-8 py-3 bg-white text-slate-900 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-400 transition-all">Konfigurasi API Kurir</button>
        </div>
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-emerald-500/10 blur-[100px]"></div>
    </div>
</div>
