<div class="space-y-8 animate-fade-in pb-20">
    <!-- Header Integrasi -->
    <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-cyan-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 bg-cyan-50 text-cyan-600 rounded-[2rem] flex items-center justify-center text-3xl shadow-inner">
                    <i class="fa-solid fa-network-wired"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Hub <span class="text-cyan-600">Integrasi</span></h1>
                    <p class="text-slate-500 font-bold text-xs uppercase tracking-[0.2em] mt-2">Manajemen Gerbang Pembayaran, Logistik & Komunikasi</p>
                </div>
            </div>
            <button wire:click="segarkanStatus" class="px-8 py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-cyan-600 transition-all flex items-center gap-3">
                <i class="fa-solid fa-sync"></i> Uji Koneksi Global
            </button>
        </div>
    </div>

    <!-- Monitoring Real-time Gateway -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($statusIntegrasi as $key => $status)
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="flex justify-between items-start mb-6">
                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[8px] font-black uppercase tracking-widest">{{ $key }}</span>
                <div class="flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-[9px] font-black text-emerald-600 uppercase">{{ $status['status'] }}</span>
                </div>
            </div>
            <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-2">{{ Str::title($key) }} Gateway</h3>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Latensi: {{ $status['latensi'] }}</p>
            
            <a href="{{ route('pengelola.api.' . $key) }}" wire:navigate class="w-full py-3 bg-slate-50 text-slate-600 rounded-xl text-[9px] font-black uppercase tracking-widest text-center block group-hover:bg-cyan-600 group-hover:text-white transition-all">Konfigurasi</a>
        </div>
        @endforeach
    </div>

    <!-- Konfigurasi Detail (Inline Form) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Statistik API -->
        <div class="lg:col-span-2 bg-slate-900 rounded-[2.5rem] p-10 text-white relative overflow-hidden">
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-cyan-500/10 rounded-full blur-3xl"></div>
            <h3 class="text-sm font-black text-white uppercase tracking-widest mb-8 flex items-center gap-3">
                <i class="fa-solid fa-chart-line text-cyan-400"></i> Lalu Lintas API (24 Jam)
            </h3>
            <div class="h-64 flex items-end justify-between gap-2">
                @for($i = 0; $i < 24; $i++)
                <div class="flex-1 bg-cyan-500/20 rounded-t-lg group relative" style="height: {{ rand(20, 100) }}%">
                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-white text-slate-900 text-[8px] font-black rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap uppercase tracking-widest">
                        {{ rand(100, 999) }} Req
                    </div>
                </div>
                @endfor
            </div>
            <div class="flex justify-between mt-4 text-[8px] font-black text-slate-500 uppercase tracking-widest">
                <span>00:00</span>
                <span>06:00</span>
                <span>12:00</span>
                <span>18:00</span>
                <span>23:59</span>
            </div>
        </div>

        <!-- Logs Cepat -->
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center justify-between">
                <span>Aktivitas Integrasi</span>
                <i class="fa-solid fa-bolt text-amber-500"></i>
            </h3>
            <div class="space-y-6">
                <div class="flex gap-4 items-start">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-800 leading-tight">Callback Midtrans Sukses</p>
                        <p class="text-[9px] text-slate-400 mt-1 uppercase font-black tracking-widest">INV-9902 • 2 MENIT LALU</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-800 leading-tight">Cek Ongkir RajaOngkir Berhasil</p>
                        <p class="text-[9px] text-slate-400 mt-1 uppercase font-black tracking-widest">IP: 182.22.x.x • 5 MENIT LALU</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>