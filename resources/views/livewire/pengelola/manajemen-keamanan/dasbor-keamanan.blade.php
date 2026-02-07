<div class="space-y-8 animate-fade-in pb-20">
    <!-- Header SOC -->
    <div class="bg-slate-900 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>
        <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-red-600/10 to-transparent"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 bg-red-600/20 text-red-500 rounded-[2rem] flex items-center justify-center text-4xl shadow-lg border border-red-500/20">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-white uppercase tracking-tight">SOC <span class="text-red-500">Enterprise</span></h1>
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-[0.2em] mt-2">Security Operations Center - Teqara Hub</p>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="px-6 py-3 bg-red-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-red-900/50 flex items-center gap-2">
                    <span class="w-2 h-2 bg-white rounded-full animate-ping"></span> Live Monitoring
                </div>
            </div>
        </div>
    </div>

    <!-- Status Keamanan Kritis -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm border-l-4 border-l-red-500">
            <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Insiden Kritis</h4>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $statistik['insiden_kritis'] }}</h3>
            <p class="text-[10px] font-bold text-red-500 uppercase tracking-wide mt-2">Memerlukan Respon Segera</p>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm border-l-4 border-l-amber-500">
            <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">IP Diblokir</h4>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $statistik['ip_diblokir'] }}</h3>
            <p class="text-[10px] font-bold text-amber-500 uppercase tracking-wide mt-2">Oleh Firewall WAF</p>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm border-l-4 border-l-indigo-500">
            <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Percobaan Login Gagal</h4>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $statistik['percobaan_login_gagal'] }}</h3>
            <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-wide mt-2">Terdeteksi 24 Jam</p>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm border-l-4 border-l-cyan-500">
            <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Ancaman Siber</h4>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $statistik['ancaman_terdeteksi'] }}</h3>
            <p class="text-[10px] font-bold text-cyan-500 uppercase tracking-wide mt-2">Scanning Log Real-time</p>
        </div>
    </div>

    <!-- Peta Ancaman & Log Forensik -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Visualisasi Serangan -->
        <div class="lg:col-span-2 bg-slate-900 rounded-[2.5rem] p-10 text-white relative h-[500px]">
            <h3 class="text-sm font-black text-white uppercase tracking-widest mb-8 flex items-center gap-3">
                <i class="fa-solid fa-map-location-dot text-red-500"></i> Sumber Serangan Terdeteksi
            </h3>
            <div class="relative h-full w-full bg-[url('https://upload.wikimedia.org/wikipedia/commons/e/ec/World_map_blank_without_borders.svg')] bg-contain bg-no-repeat bg-center opacity-20 invert"></div>
            
            <!-- Simulasi Titik Serangan -->
            <div class="absolute top-1/2 left-1/4 w-4 h-4 bg-red-500 rounded-full animate-ping shadow-[0_0_20px_rgba(239,68,68,0.8)]"></div>
            <div class="absolute top-1/3 right-1/4 w-3 h-3 bg-red-500 rounded-full animate-ping shadow-[0_0_15px_rgba(239,68,68,0.8)]"></div>
        </div>

        <!-- Forensik Terbaru -->
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center justify-between">
                <span>Log Forensik Siber</span>
                <i class="fa-solid fa-fingerprint text-red-500"></i>
            </h3>
            <div class="space-y-4">
                @forelse(range(1, 5) as $i)
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-red-200 transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[9px] font-black px-2 py-0.5 bg-red-100 text-red-600 rounded uppercase">Potensi SQLi</span>
                        <span class="text-[8px] font-bold text-slate-400 uppercase">Baru Saja</span>
                    </div>
                    <p class="text-[11px] font-mono text-slate-700 leading-relaxed">SELECT * FROM pengguna WHERE...</p>
                    <p class="text-[9px] font-black text-slate-400 mt-2 uppercase">IP: 192.168.1.{{ rand(1, 255) }}</p>
                </div>
                @empty
                <div class="text-center py-10">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Tidak ada ancaman aktif</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>