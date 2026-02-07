<div class="space-y-6 bg-slate-50 -m-6 p-6 min-h-screen">
    
    <!-- SOC Header with Risk Score -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-[#0f172a] p-8 rounded-3xl shadow-2xl border border-slate-800 relative overflow-hidden mb-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 blur-[100px] rounded-full -mr-20 -mt-20"></div>
        <div class="relative z-10">
            <h1 class="text-3xl font-black text-white flex items-center gap-3">
                <span class="p-2 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-500/20">
                    <i class="fa-solid fa-shield-halved text-white text-2xl"></i>
                </span>
                SECURITY OPERATION CENTER <span class="text-indigo-500 text-sm font-bold tracking-[0.3em] ml-2">(SOC)</span>
            </h1>
            <p class="text-slate-400 mt-2 text-sm font-medium flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span> 
                Monitoring Real-time Teqara Global Defense Engine v16.0
            </p>
        </div>

        <div class="relative z-10 flex items-center gap-8 bg-slate-900/50 p-4 rounded-2xl border border-slate-800">
            <div class="text-center">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Health Score</p>
                <div class="text-4xl font-black {{ $skorRisiko > 80 ? 'text-emerald-500' : ($skorRisiko > 50 ? 'text-amber-500' : 'text-rose-500') }}">
                    {{ $skorRisiko }}%
                </div>
            </div>
            <div class="w-px h-12 bg-slate-800"></div>
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2">
                    <div class="w-20 bg-slate-800 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-indigo-500 h-full" style="width: {{ $ringkasan['api_uptime'] }}"></div>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400">API: {{ $ringkasan['api_uptime'] }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-20 bg-slate-800 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-purple-500 h-full" style="width: {{ $ringkasan['mfa_compliance'] }}"></div>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400">MFA: {{ $ringkasan['mfa_compliance'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Threat Detection Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Serangan 24j', 'val' => $ringkasan['total_insiden_24j'], 'icon' => 'fa-bolt', 'color' => 'rose'],
                ['label' => 'Active WAF Rules', 'val' => $ringkasan['total_blokir'], 'icon' => 'fa-fire-shield', 'color' => 'indigo'],
                ['label' => 'Critical Assets', 'val' => '1.2k', 'icon' => 'fa-vault', 'color' => 'amber'],
                ['label' => 'Encrypted Traffic', 'val' => '100%', 'icon' => 'fa-lock', 'color' => 'emerald'],
            ];
        @endphp
        
        @foreach($stats as $s)
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xl hover:shadow-2xl transition-all duration-300 group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $s['label'] }}</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-2">{{ $s['val'] }}</h3>
                </div>
                <div class="p-4 bg-{{ $s['color'] }}-50 rounded-2xl text-{{ $s['color'] }}-600 group-hover:scale-110 transition-transform">
                    <i class="fa-solid {{ $s['icon'] }} text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-emerald-600 bg-emerald-50 py-1 px-3 rounded-full w-fit">
                <i class="fa-solid fa-arrow-trend-up"></i> +{{ rand(2, 8) }}% vs Kemarin
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Live Threat Map (Visual Simulation) -->
        <div class="lg:col-span-8 bg-slate-900 rounded-3xl border border-slate-800 shadow-2xl p-6 overflow-hidden relative min-h-[400px]">
            <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(#6366f1 1px, transparent 1px); background-size: 30px 30px;"></div>
            
            <div class="flex justify-between items-center mb-6 relative z-10">
                <h3 class="text-white font-black text-sm uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span> Threat Distribution Analysis
                </h3>
                <div class="flex gap-2">
                    <button class="px-3 py-1 bg-slate-800 rounded-lg text-[10px] font-bold text-slate-300 border border-slate-700">Live Traffic</button>
                    <button class="px-3 py-1 bg-indigo-600 rounded-lg text-[10px] font-bold text-white shadow-lg shadow-indigo-500/20">Blocked Origin</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                <!-- Geo Distribution -->
                <div class="space-y-4">
                    @foreach($analisisGeo as $geo)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-6 bg-slate-800 rounded overflow-hidden flex items-center justify-center border border-slate-700">
                                <span class="text-[10px] font-bold text-slate-400">{{ substr($geo['negara'], 0, 2) }}</span>
                            </div>
                            <span class="text-xs font-bold text-slate-300">{{ $geo['negara'] }}</span>
                        </div>
                        <div class="flex items-center gap-4 flex-1 mx-4">
                            <div class="flex-1 bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-indigo-500 h-full group-hover:bg-indigo-400 transition-colors" style="width: {{ ($geo['total'] / 150) * 100 }}%"></div>
                            </div>
                            <span class="text-xs font-mono font-bold text-indigo-400 w-8 text-right">{{ $geo['total'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Automated Threat Detection -->
                <div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 p-4">
                    <h4 class="text-[10px] font-black text-rose-400 uppercase tracking-widest mb-4">Ancaman Terdeteksi (AI Engine)</h4>
                    <div class="space-y-3">
                        @forelse($ancamanTerdeteksi as $index => $ancaman)
                        <div class="p-3 bg-rose-500/10 border border-rose-500/20 rounded-xl flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-rose-300">{{ $ancaman['tipe'] }}</p>
                                <p class="text-[10px] font-mono text-slate-500 mt-1">{{ $ancaman['ip'] }}</p>
                            </div>
                            <button wire:click="autoRemediate({{ $index }})" class="p-2 bg-rose-600 hover:bg-rose-700 rounded-lg text-white transition-colors" title="Blokir & Amankan">
                                <i class="fa-solid fa-shield-virus"></i>
                            </button>
                        </div>
                        @empty
                        <div class="flex flex-col items-center justify-center py-8 opacity-40">
                            <i class="fa-solid fa-circle-check text-4xl text-emerald-400 mb-2"></i>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">No Critical Threats</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Fake Map Dots -->
            <div class="absolute bottom-4 right-4 flex gap-4 pointer-events-none">
                <div class="text-[9px] font-bold text-slate-600 uppercase tracking-tighter">
                    NODE_A: <span class="text-emerald-500">CONNECTED</span>
                </div>
                <div class="text-[9px] font-bold text-slate-600 uppercase tracking-tighter">
                    NODE_B: <span class="text-rose-500">BLOCKED_REQ</span>
                </div>
                <div class="text-[9px] font-bold text-slate-600 uppercase tracking-tighter">
                    UPTIME: <span class="text-slate-400">99.9%</span>
                </div>
            </div>
        </div>

        <!-- System Health Audit -->
        <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-100 shadow-xl p-6">
            <h3 class="text-slate-800 font-black text-xs uppercase tracking-widest mb-6 flex items-center gap-2">
                <i class="fa-solid fa-microchip text-indigo-500"></i> Infrastructure Health
            </h3>
            
            <div class="space-y-6">
                @php
                    $health = [
                        ['label' => 'CPU Load', 'val' => 12, 'color' => 'indigo'],
                        ['label' => 'Memory (RAM)', 'val' => 28, 'color' => 'purple'],
                        ['label' => 'Disk IOPS', 'val' => 15, 'color' => 'emerald'],
                        ['label' => 'Network Latency', 'val' => 8, 'color' => 'blue'],
                    ];
                @endphp

                @foreach($health as $h)
                <div>
                    <div class="flex justify-between text-[11px] mb-2 font-bold uppercase">
                        <span class="text-slate-500">{{ $h['label'] }}</span>
                        <span class="text-{{ $h['color'] }}-600 font-mono">{{ $h['val'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden p-0.5 border border-slate-200">
                        <div class="bg-{{ $h['color'] }}-500 h-full rounded-full shadow-[0_0_10px_rgba(99,102,241,0.3)] transition-all duration-500" style="width: {{ $h['val'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8 p-4 bg-slate-900 rounded-2xl relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-fingerprint text-6xl text-white"></i>
                </div>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Integrity Check</h4>
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-500/20 text-emerald-400 rounded-lg">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white">File Systems Secure</p>
                        <p class="text-[9px] text-slate-500">Last scanned: 2 mins ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Incidents Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden mt-6">
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest">Incident Activity Forensics</h3>
                <p class="text-[10px] text-slate-400 mt-1 font-bold">Comprehensive log of all security related events</p>
            </div>
            <div class="flex gap-2">
                <button class="p-2 bg-white border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">
                    <i class="fa-solid fa-download text-xs"></i>
                </button>
                <button class="px-4 py-2 bg-slate-800 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 transition-colors shadow-lg">View Full SIEM</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/80 text-slate-400 font-black uppercase text-[9px] tracking-[0.15em]">
                    <tr>
                        <th class="px-8 py-4">Forensic ID</th>
                        <th class="px-8 py-4">Threat Type</th>
                        <th class="px-8 py-4">Source Origin</th>
                        <th class="px-8 py-4">Risk Level</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($insidenTerbaru as $insiden)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-8 py-4 font-mono text-[10px] text-slate-400">#{{ substr($insiden->id, 0, 8) }}</td>
                        <td class="px-8 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-700 text-xs">{{ $insiden->jenis_insiden }}</span>
                                <span class="text-[9px] text-slate-400 truncate max-w-[200px]">{{ $insiden->deskripsi }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 bg-slate-100 rounded font-mono text-[10px] text-slate-600">{{ $insiden->alamat_ip }}</span>
                                <span class="text-[9px] text-slate-400 font-bold uppercase">IDN</span>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            @php
                                $levelColors = [
                                    'kritis' => 'bg-rose-100 text-rose-700 border-rose-200',
                                    'tinggi' => 'bg-orange-100 text-orange-700 border-orange-200',
                                    'sedang' => 'bg-amber-100 text-amber-700 border-amber-200',
                                    'rendah' => 'bg-sky-100 text-sky-700 border-sky-200',
                                ];
                                $color = $levelColors[$insiden->tingkat_keparahan] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                            @endphp
                            <span class="px-2.5 py-1 rounded-lg border text-[9px] font-black uppercase {{ $color }}">
                                {{ $insiden->tingkat_keparahan }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-xs font-bold">
                            @if($insiden->status == 'selesai')
                                <span class="text-emerald-500 flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-[8px]"></i> Resolved</span>
                            @else
                                <span class="text-amber-500 flex items-center gap-1.5"><i class="fa-solid fa-circle-dot text-[8px] animate-pulse"></i> Analyzing</span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-right">
                            <button class="p-2 text-slate-400 hover:text-indigo-600 transition-colors opacity-0 group-hover:opacity-100">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center text-slate-300">
                            <i class="fa-solid fa-shield-virus text-6xl mb-4 opacity-10"></i>
                            <p class="font-bold uppercase tracking-widest text-xs">No Recent Security Events</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>