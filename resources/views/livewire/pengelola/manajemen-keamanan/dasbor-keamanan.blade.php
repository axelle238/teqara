<div class="space-y-8 animate-in fade-in duration-700 pb-20" wire:poll.3s="segarkanStatistik">
    
    <!-- Header & DEFCON Status -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Header -->
        <div class="lg:col-span-2 bg-slate-900 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>
            <!-- Dynamic Gradient based on DEFCON -->
            <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br transition-colors duration-1000 
                {{ $defconLevel === 1 ? 'from-red-600/30' : ($defconLevel <= 3 ? 'from-amber-600/20' : 'from-emerald-600/10') }} to-transparent"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-[2rem] flex items-center justify-center text-4xl shadow-lg border backdrop-blur-md transition-colors duration-500
                        {{ $defconLevel === 1 ? 'bg-red-600/20 text-red-500 border-red-500/50' : 'bg-emerald-600/20 text-emerald-500 border-emerald-500/20' }}">
                        <i class="fa-solid fa-shield-halved {{ $defconLevel === 1 ? 'animate-pulse' : '' }}"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-white uppercase tracking-tight">SOC <span class="{{ $defconLevel === 1 ? 'text-red-500' : 'text-emerald-500' }}">Command Center</span></h1>
                        <p class="text-slate-400 font-bold text-xs uppercase tracking-[0.2em] mt-2">Security Operations Center - Teqara Hub</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="px-6 py-3 bg-slate-800/50 backdrop-blur border border-white/10 text-white rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-3">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $defconLevel === 1 ? 'bg-red-400' : 'bg-emerald-400' }} opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 {{ $defconLevel === 1 ? 'bg-red-500' : 'bg-emerald-500' }}"></span>
                        </span>
                        Live Monitoring
                    </div>
                </div>
            </div>
        </div>

        <!-- DEFCON Indicator -->
        <div class="bg-slate-900 rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden flex flex-col justify-center items-center text-center border border-white/5">
            <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Threat Level</h3>
            <div class="text-6xl font-black {{ $defconLevel === 1 ? 'text-red-600 animate-pulse' : ($defconLevel <= 3 ? 'text-amber-500' : 'text-emerald-500') }} tracking-tighter transition-all duration-500">
                DEFCON {{ $defconLevel }}
            </div>
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-2">
                @if($defconLevel === 1) CRITICAL THREAT @elseif($defconLevel === 5) SYSTEM SECURE @else ELEVATED RISK @endif
            </p>
        </div>
    </div>

    <!-- Live Attack Map -->
    <div class="bg-slate-900 rounded-[2.5rem] p-0 shadow-2xl relative overflow-hidden h-[500px] border border-white/5 group">
        <!-- Header Map -->
        <div class="absolute top-8 left-8 z-20">
            <h3 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-3">
                <i class="fa-solid fa-globe text-indigo-500"></i> Global Attack Map
            </h3>
            <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-1 ml-7">Real-time Threat Geolocation</p>
        </div>

        <!-- Background Map (Dark) -->
        <div class="absolute inset-0 bg-[#0b1120] opacity-90"></div>
        <div class="absolute inset-0 bg-[url('https://upload.wikimedia.org/wikipedia/commons/e/ec/World_map_blank_without_borders.svg')] bg-contain bg-no-repeat bg-center opacity-10 invert transition-opacity duration-1000"></div>
        
        <!-- Radar Scan Effect -->
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-emerald-500/5 to-transparent h-[10px] w-full animate-[scan_4s_linear_infinite]"></div>

        <!-- Attack Points (Dynamic from Backend) -->
        @foreach($seranganMap as $serangan)
        <div class="absolute w-4 h-4 rounded-full flex items-center justify-center transition-all duration-500"
             style="top: {{ $serangan['top'] }}; left: {{ $serangan['left'] }};">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-red-600"></span>
            
            <!-- Tooltip -->
            <div class="absolute -top-8 left-1/2 -translate-x-1/2 px-2 py-1 bg-red-600 text-white text-[8px] font-black uppercase rounded tracking-wider whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
                {{ $serangan['type'] }} DETECTED
            </div>
        </div>
        
        <!-- Connection Lines (Visual Flair) -->
        <div class="absolute h-px bg-gradient-to-r from-transparent via-red-500/20 to-transparent w-32 rotate-45 origin-left"
             style="top: {{ $serangan['top'] }}; left: {{ $serangan['left'] }};"></div>
        @endforeach

        <!-- Terminal Log Overlay (Bottom Right) -->
        <div class="absolute bottom-8 right-8 w-80 bg-black/80 backdrop-blur-md rounded-xl border border-emerald-500/30 p-4 font-mono text-[10px] text-emerald-400 shadow-2xl overflow-hidden">
            <div class="flex justify-between items-center mb-2 border-b border-emerald-500/20 pb-2">
                <span class="font-bold uppercase">System Terminal</span>
                <span class="animate-pulse">_</span>
            </div>
            <div class="space-y-1 max-h-32 overflow-hidden flex flex-col-reverse">
                @foreach($terminalLogs as $log)
                <div class="flex gap-2">
                    <span class="text-slate-500">[{{ $log['time'] }}]</span>
                    <span class="{{ $log['type'] === 'CRITICAL' ? 'text-red-500' : ($log['type'] === 'WARN' ? 'text-amber-500' : 'text-emerald-500') }} font-bold">{{ $log['type'] }}</span>
                    <span class="text-slate-300 truncate">{{ $log['msg'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:border-red-200 transition-all">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Critical Incidents</h4>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $statistik['insiden_kritis'] }}</h3>
                    <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded-full">LIVE</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:border-amber-200 transition-all">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Blocked IPs</h4>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $statistik['ip_diblokir'] }}</h3>
                    <span class="text-xs font-bold text-amber-500 bg-amber-50 px-2 py-0.5 rounded-full">WAF</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:border-indigo-200 transition-all">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Auth Failures</h4>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $statistik['percobaan_login_gagal'] }}</h3>
                    <span class="text-xs font-bold text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded-full">24H</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:border-cyan-200 transition-all">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-cyan-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Traffic Anomalies</h4>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $statistik['ancaman_terdeteksi'] }}</h3>
                    <span class="text-xs font-bold text-cyan-500 bg-cyan-50 px-2 py-0.5 rounded-full">AI SCAN</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes scan {
    0% { transform: translateY(0); opacity: 0; }
    50% { opacity: 1; }
    100% { transform: translateY(500px); opacity: 0; }
}
</style>
