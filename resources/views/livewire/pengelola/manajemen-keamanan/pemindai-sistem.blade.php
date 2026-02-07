<div class="space-y-6 bg-[#0a0f1d] -m-6 p-6 min-h-screen font-sans text-slate-300">
    
    <!-- Scanner Header -->
    <div class="bg-[#0f172a] rounded-3xl p-8 border border-slate-800 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-500/5 blur-[120px] rounded-full -mr-32 -mt-32"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div>
                <h1 class="text-4xl font-black text-white tracking-tighter uppercase flex items-center gap-4">
                    <span class="p-3 bg-red-600 rounded-2xl shadow-xl shadow-red-500/20">
                        <i class="fa-solid fa-radar"></i>
                    </span>
                    VULNERABILITY <span class="text-red-500">SCANNER</span>
                </h1>
                <p class="text-slate-500 mt-2 font-bold tracking-widest text-xs uppercase">Automated System Audit & Exploit Detection</p>
            </div>
            
            <button wire:click="startScan" 
                    wire:loading.attr="disabled"
                    class="px-8 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black uppercase tracking-widest transition-all shadow-xl shadow-red-900/40 flex items-center gap-3 group">
                <span wire:loading.remove class="flex items-center gap-2">
                    <i class="fa-solid fa-shield-virus group-hover:scale-110 transition-transform"></i> Initiate Audit
                </span>
                <span wire:loading class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-notch fa-spin"></i> Analyzing Infrastructure...
                </span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Dasbor / Status -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Score Radial -->
            <div class="bg-[#0f172a] rounded-3xl p-10 border border-slate-800 shadow-xl flex flex-col items-center justify-center text-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-5 bg-[url('https://grainy-gradients.vercel.app/noise.svg')]"></div>
                
                <h3 class="font-black text-slate-500 text-[10px] uppercase tracking-[0.3em] mb-8 relative z-10">Cyber Hygiene Score</h3>
                
                <div class="relative w-48 h-48 flex items-center justify-center mb-8 relative z-10">
                    <svg class="w-full h-full transform -rotate-90">
                        <circle cx="96" cy="96" r="88" stroke="currentColor" stroke-width="8" fill="transparent" class="text-slate-800" />
                        <circle cx="96" cy="96" r="88" stroke="currentColor" stroke-width="8" fill="transparent" 
                                class="{{ $score >= 80 ? 'text-emerald-500' : ($score >= 50 ? 'text-amber-500' : 'text-rose-500') }} transition-all duration-1000 ease-out" 
                                stroke-dasharray="552" 
                                stroke-dashoffset="{{ 552 - (552 * $score / 100) }}" />
                    </svg>
                    <div class="absolute flex flex-col items-center">
                        <span class="text-6xl font-black text-white">{{ $score }}%</span>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1">Status: {{ $score >= 80 ? 'SECURE' : 'THREAT' }}</span>
                    </div>
                </div>

                <div class="w-full bg-slate-900/50 p-4 rounded-2xl border border-slate-800 relative z-10">
                    <div class="flex items-center gap-3 text-left">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-slate-400">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-500 uppercase">Audit Engine</p>
                            <p class="text-xs font-bold text-white uppercase">Teqara Defense v4.2</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Health Indicators -->
            <div class="bg-[#0f172a] rounded-3xl p-6 border border-slate-800 shadow-xl space-y-4">
                <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Engine Modules</h4>
                <div class="flex items-center justify-between p-3 bg-slate-900 rounded-xl border border-slate-800/50">
                    <span class="text-xs font-bold text-slate-400 uppercase">Configuration Audit</span>
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                </div>
                <div class="flex items-center justify-between p-3 bg-slate-900 rounded-xl border border-slate-800/50">
                    <span class="text-xs font-bold text-slate-400 uppercase">Privilege Analysis</span>
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                </div>
                <div class="flex items-center justify-between p-3 bg-slate-900 rounded-xl border border-slate-800/50">
                    <span class="text-xs font-bold text-slate-400 uppercase">Data Leak Scan</span>
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                </div>
            </div>
        </div>

        <!-- Audit Findings -->
        <div class="lg:col-span-8 bg-[#0f172a] rounded-3xl border border-slate-800 shadow-2xl relative overflow-hidden min-h-[500px]">
            <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: radial-gradient(#ef4444 1px, transparent 1px); background-size: 40px 40px;"></div>
            
            <div class="px-8 py-6 border-b border-slate-800 bg-slate-900/30 flex justify-between items-center relative z-10">
                <h3 class="font-black text-white text-xs uppercase tracking-[0.2em] flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span> Forensic Findings
                </h3>
                <span class="font-mono text-[10px] text-slate-500 uppercase">Buffer: SECURE_AUDIT_LOG</span>
            </div>

            <div class="p-8 relative z-10">
                @if($scanning)
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 border-4 border-slate-800 border-t-red-500 rounded-full animate-spin mb-6 shadow-[0_0_20px_rgba(239,68,68,0.3)]"></div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-widest">Running Global Scan...</h3>
                    <p class="text-slate-500 font-mono text-xs mt-2">EXECUTING: SYSTEM_INTEGRITY_CHECK_{{ rand(100,999) }}</p>
                </div>
                @elseif(empty($scanResults))
                <div class="flex flex-col items-center justify-center py-32 opacity-20 text-center">
                    <i class="fa-solid fa-radar text-8xl text-slate-400 mb-6"></i>
                    <p class="font-black uppercase tracking-[0.3em] text-sm">Awaiting Instruction</p>
                </div>
                @else
                <div class="space-y-4 animate-in slide-in-from-bottom-4 duration-500">
                    @foreach($scanResults as $result)
                    <div class="flex items-start gap-4 p-5 rounded-2xl border transition-all duration-300 {{ $result['passed'] ? 'bg-emerald-500/5 border-emerald-500/20 group hover:bg-emerald-500/10' : 'bg-rose-500/5 border-rose-500/20 group hover:bg-rose-500/10 shadow-[0_0_15px_rgba(244,63,94,0.05)]' }}">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 border {{ $result['passed'] ? 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' : 'bg-rose-500/10 text-rose-500 border-rose-500/20 animate-pulse' }}">
                            <i class="fa-solid {{ $result['passed'] ? 'fa-shield-check' : 'fa-skull-crossbones' }} text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="font-black text-xs text-white uppercase tracking-wider">{{ $result['test'] }}</h4>
                                <span class="text-[9px] font-black uppercase px-3 py-1 rounded border {{ $result['severity'] === 'critical' ? 'bg-rose-600 text-white border-rose-400' : ($result['severity'] === 'high' ? 'bg-orange-500/20 text-orange-400 border-orange-500/30' : 'bg-slate-800 text-slate-400 border-slate-700') }}">
                                    {{ $result['severity'] }}
                                </span>
                            </div>
                            <p class="text-[11px] font-bold {{ $result['passed'] ? 'text-emerald-400/80' : 'text-rose-400/80' }} font-mono">{{ $result['message'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Security Advisories -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 bg-slate-900/50 rounded-2xl border border-slate-800 text-slate-500 text-[10px] leading-relaxed">
            <i class="fa-solid fa-circle-info text-indigo-500 mr-2"></i>
            Audit scan results are saved in forensic logs for compliance reporting. This scanner checks for standard OWASP Top 10 vulnerabilities and misconfigurations.
        </div>
        <div class="p-6 bg-slate-900/50 rounded-2xl border border-slate-800 text-slate-500 text-[10px] leading-relaxed">
            <i class="fa-solid fa-lock text-rose-500 mr-2"></i>
            Detected vulnerabilities should be patched immediately. Critical issues may lead to automated system lockdown.
        </div>
        <div class="p-6 bg-slate-900/50 rounded-2xl border border-slate-800 text-slate-500 text-[10px] leading-relaxed font-mono">
            ENGINE_VERSION: 16.0.4<br>
            SIGNATURE_DB: 2026.02.08<br>
            SCAN_MODE: DEEP_ENTERPRISE
        </div>
    </div>
</div>
