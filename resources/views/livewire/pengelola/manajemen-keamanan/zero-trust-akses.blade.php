<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="bg-black rounded-[3rem] p-10 overflow-hidden shadow-2xl border border-slate-800 flex flex-col md:flex-row justify-between items-center gap-8 relative">
        <div class="relative z-10 space-y-2 text-white">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-900/50 border border-emerald-500/30 mb-2">
                <i class="fa-solid fa-user-lock text-emerald-400"></i>
                <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Identity Aware Proxy</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black tracking-tighter uppercase leading-none">ZERO TRUST <span class="text-slate-500">ACCESS</span></h1>
            <p class="text-slate-400 font-medium text-lg">"Never Trust, Always Verify". Validasi konteks akses berkelanjutan.</p>
        </div>
        
        <div class="relative z-10 flex gap-4">
            <div class="w-32 h-32 rounded-full border-4 border-slate-800 flex flex-col items-center justify-center bg-slate-900 shadow-xl">
                <span class="text-3xl font-black text-white">98<small class="text-xs">%</small></span>
                <span class="text-[9px] font-bold text-slate-500 uppercase">Trust Score</span>
            </div>
        </div>

        <!-- Grid Deco -->
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10"></div>
    </div>

    <!-- Active Sessions Matrix -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Contextual Access Policy -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="font-black text-slate-800 text-lg uppercase">Kebijakan Konteks</h3>
                    <p class="text-xs text-slate-500 mt-1">Syarat wajib akses resource kritis.</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Geo-Fencing</h4>
                                <p class="text-[10px] text-slate-400">Hanya IP Indonesia</p>
                            </div>
                        </div>
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <i class="fa-solid fa-laptop-code"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Device Fingerprint</h4>
                                <p class="text-[10px] text-slate-400">Perangkat Terdaftar</p>
                            </div>
                        </div>
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    </div>
                    <div class="flex items-center justify-between opacity-50">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Time Window</h4>
                                <p class="text-[10px] text-slate-400">08:00 - 17:00 WIB</p>
                            </div>
                        </div>
                        <i class="fa-regular fa-circle text-slate-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Sessions -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-black text-slate-800 text-lg uppercase">Sesi Terautentikasi</h3>
                    <span class="text-xs font-bold text-slate-400">Real-time update</span>
                </div>
                <div class="divide-y divide-slate-50">
                    @foreach($sesi as $s)
                    <div class="p-6 flex items-center justify-between group hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 border border-slate-200">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                @if($s['status'] == 'mencurigakan')
                                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-rose-500 rounded-full border-2 border-white animate-pulse"></div>
                                @else
                                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white"></div>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-sm">{{ $s['user'] }}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wide text-slate-500 bg-slate-100 px-2 py-0.5 rounded">{{ $s['lokasi'] }}</span>
                                    <span class="text-[10px] font-mono text-slate-400">{{ $s['ip'] }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="text-right hidden sm:block">
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Perangkat</p>
                                <p class="text-xs font-bold text-slate-700">{{ $s['perangkat'] }}</p>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Skor Risiko</p>
                                <div class="flex items-center gap-1 justify-end">
                                    <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $s['skor_risiko'] > 50 ? 'bg-rose-500' : 'bg-emerald-500' }}" style="width: {{ $s['skor_risiko'] }}%"></div>
                                    </div>
                                    <span class="text-xs font-black {{ $s['skor_risiko'] > 50 ? 'text-rose-600' : 'text-emerald-600' }}">{{ $s['skor_risiko'] }}%</span>
                                </div>
                            </div>

                            @if($s['skor_risiko'] > 50)
                                <button wire:click="paksaKeluar('{{ $s['ip'] }}')" class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Revoke Access">
                                    <i class="fa-solid fa-ban"></i>
                                </button>
                            @else
                                <div class="w-10 h-10"></div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
