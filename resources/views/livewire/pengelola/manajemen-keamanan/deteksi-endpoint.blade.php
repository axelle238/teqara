<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="bg-cyan-900 rounded-[3rem] p-10 overflow-hidden shadow-2xl border border-cyan-800 flex flex-col md:flex-row justify-between items-center gap-8 relative">
        <div class="relative z-10 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-2">
                <i class="fa-solid fa-server text-cyan-300"></i>
                <span class="text-[10px] font-black text-cyan-100 uppercase tracking-widest">Endpoint Detection & Response</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase leading-none">DETEKSI <span class="text-cyan-400">ENDPOINT</span></h1>
            <p class="text-cyan-200 font-medium text-lg">Telemetri real-time dan kontrol jarak jauh untuk seluruh aset terhubung.</p>
        </div>
        
        <div class="relative z-10 flex gap-4">
            <div class="text-center px-6 py-3 bg-cyan-800/50 rounded-2xl border border-cyan-700/50 backdrop-blur-sm">
                <p class="text-[10px] font-black text-cyan-300 uppercase tracking-widest">Agen Aktif</p>
                <p class="text-3xl font-black text-white">{{ count($endpoints) }}</p>
            </div>
        </div>

        <!-- Background Effect -->
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Fleet Overview -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="font-black text-slate-800 text-lg uppercase">Armada Endpoint</h3>
                    <p class="text-xs text-slate-500 mt-1">Status konektivitas agen.</p>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach($endpoints as $ep)
                    <div class="p-5 flex items-center justify-between hover:bg-cyan-50/30 transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                    <i class="fa-brands {{ Str::contains($ep['os'], 'Windows') ? 'fa-windows' : 'fa-linux' }}"></i>
                                </div>
                                @if($ep['status'] == 'online')
                                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white"></div>
                                @elseif($ep['status'] == 'warning')
                                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-amber-500 rounded-full border-2 border-white animate-pulse"></div>
                                @else
                                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-rose-500 rounded-full border-2 border-white"></div>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-xs">{{ $ep['id'] }}</h4>
                                <p class="text-[10px] text-slate-400 font-mono">{{ $ep['ip'] }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            @if($ep['status'] != 'isolated')
                                <button wire:click="isolateHost('{{ $ep['id'] }}')" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white flex items-center justify-center transition-colors" title="Isolasi Host">
                                    <i class="fa-solid fa-network-wired"></i>
                                </button>
                            @else
                                <span class="text-[9px] font-black uppercase text-rose-600 bg-rose-100 px-2 py-1 rounded">Isolasi</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Live Process Monitor -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-black text-slate-800 text-lg uppercase">Analisis Proses</h3>
                    <span class="px-3 py-1 bg-cyan-50 text-cyan-600 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-cyan-100 animate-pulse">
                        Live Telemetry
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">PID & Nama</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">User</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Resource</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($processes as $proc)
                            <tr class="hover:bg-slate-50 transition-colors {{ $proc['status'] == 'suspicious' ? 'bg-rose-50/30' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono text-xs font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded">{{ $proc['pid'] }}</span>
                                        <span class="text-sm font-bold text-slate-800 {{ $proc['status'] == 'suspicious' ? 'text-rose-600' : '' }}">{{ $proc['name'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-bold text-slate-600">{{ $proc['user'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-[10px] font-mono font-bold text-slate-500">
                                        CPU: {{ $proc['cpu'] }} | MEM: {{ $proc['mem'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button wire:click="killProcess({{ $proc['pid'] }})" class="px-3 py-1.5 bg-rose-100 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition-colors">
                                        Kill
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
