<div class="space-y-6 bg-[#0a0f1d] -m-6 p-6 min-h-screen font-sans text-slate-300">
    
    <!-- Cyber SIEM Header -->
    <div class="bg-[#0f172a] rounded-3xl p-8 border border-slate-800 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/5 blur-[120px] rounded-full -mr-32 -mt-32"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <h1 class="text-4xl font-black text-white tracking-tighter uppercase flex items-center gap-4">
                    <span class="p-3 bg-indigo-600 rounded-2xl shadow-xl shadow-indigo-500/20">
                        <i class="fa-solid fa-microchip"></i>
                    </span>
                    SIEM <span class="text-indigo-500">ENGINE</span> V16.4
                </h1>
                <p class="text-slate-500 mt-2 font-bold tracking-widest text-xs uppercase">Security Information & Event Management System</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="px-6 py-4 bg-slate-900/50 rounded-2xl border border-slate-800 text-center min-w-[120px]">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Log Throughput</p>
                    <p class="text-2xl font-black text-white">1.2k <span class="text-xs text-slate-600 font-bold">evt/s</span></p>
                </div>
                <div class="px-6 py-4 bg-slate-900/50 rounded-2xl border border-slate-800 text-center min-w-[120px]">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">AI Correlation</p>
                    <p class="text-2xl font-black text-emerald-500">ACTIVE</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Forensic Filters -->
    <div class="bg-[#0f172a] p-4 rounded-2xl border border-slate-800 flex flex-wrap items-center gap-4">
        <div class="flex items-center gap-2 bg-slate-900 px-4 py-2 rounded-xl border border-slate-800">
            <i class="fa-solid fa-filter text-slate-500 text-xs"></i>
            <select wire:model.live="filterTipe" class="bg-transparent border-none text-xs font-bold text-slate-300 focus:ring-0 cursor-pointer uppercase">
                <option value="semua">System Logs</option>
                <option value="api">API Access Logs</option>
            </select>
        </div>

        <div class="flex items-center gap-2 bg-slate-900 px-4 py-2 rounded-xl border border-slate-800">
            <i class="fa-solid fa-triangle-exclamation text-slate-500 text-xs"></i>
            <select wire:model.live="tingkatKeparahan" class="bg-transparent border-none text-xs font-bold text-slate-300 focus:ring-0 cursor-pointer uppercase">
                <option value="semua">All Severities</option>
                <option value="kritis">Critical Only</option>
                <option value="tinggi">High Priority</option>
                <option value="sedang">Medium</option>
                <option value="rendah">Low</option>
            </select>
        </div>

        <div class="flex-1 min-w-[200px] relative">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search IP, Action, or Endpoint..." class="w-full bg-slate-900 border border-slate-800 rounded-xl pl-10 pr-4 py-2 text-xs font-bold text-slate-300 focus:ring-1 focus:ring-indigo-500">
        </div>

        <button class="px-6 py-2 bg-slate-800 hover:bg-slate-700 rounded-xl text-xs font-black uppercase text-white transition-colors">
            Export Report
        </button>
    </div>

    <!-- Log Terminal -->
    <div class="bg-[#0f172a] rounded-3xl border border-slate-800 shadow-2xl overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-800 bg-slate-900/30 flex justify-between items-center">
            <h3 class="font-black text-white text-xs uppercase tracking-widest flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Raw Event Stream
            </h3>
            <span class="font-mono text-[10px] text-slate-500">BUFFER_STATUS: <span class="text-emerald-500">OPTIMAL</span></span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-900/50 text-slate-500 font-black uppercase text-[9px] tracking-[0.2em]">
                    <tr>
                        <th class="px-8 py-4">Timestamp (UTC)</th>
                        <th class="px-8 py-4">Source IP</th>
                        <th class="px-8 py-4">Action / Event</th>
                        <th class="px-8 py-4">Level</th>
                        <th class="px-8 py-4 text-right">Reference</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50 font-mono text-[10px]">
                    @forelse($logs as $log)
                    <tr class="hover:bg-indigo-500/5 transition-colors group">
                        <td class="px-8 py-4 text-slate-400">
                            @if($filterTipe === 'api')
                                {{ $log->dibuat_pada ? $log->dibuat_pada->format('Y-m-d H:i:s.v') : '-' }}
                            @else
                                {{ $log->waktu ? $log->waktu->format('Y-m-d H:i:s.v') : '-' }}
                            @endif
                        </td>
                        <td class="px-8 py-4">
                            @if($filterTipe === 'api')
                                <span class="text-indigo-400 font-bold">{{ $log->ip_address }}</span>
                            @else
                                <span class="text-indigo-400 font-bold">{{ $log->meta_data['alamat_ip'] ?? 'SYSTEM' }}</span>
                            @endif
                        </td>
                        <td class="px-8 py-4">
                            @if($filterTipe === 'api')
                                <div class="flex flex-col">
                                    <span class="text-white font-bold">{{ $log->metode }} {{ $log->endpoint }}</span>
                                    <span class="text-slate-500 text-[9px] truncate max-w-md">{{ $log->payload }}</span>
                                </div>
                            @else
                                <div class="flex flex-col">
                                    <span class="text-white font-bold">{{ $log->aksi }}</span>
                                    <span class="text-slate-500 text-[9px] truncate max-w-md">{{ $log->pesan_naratif }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-8 py-4">
                            @php
                                $level = $filterTipe === 'api' ? ($log->kode_respon >= 400 ? 'tinggi' : 'rendah') : ($log->tingkat ?? 'sedang');
                                $levelColors = [
                                    'kritis' => 'text-rose-500 bg-rose-500/10 border-rose-500/20',
                                    'tinggi' => 'text-orange-500 bg-orange-500/10 border-orange-500/20',
                                    'sedang' => 'text-amber-500 bg-amber-500/10 border-amber-500/20',
                                    'rendah' => 'text-sky-500 bg-sky-500/10 border-sky-500/20',
                                ];
                                $color = $levelColors[$level] ?? 'text-slate-500 bg-slate-500/10 border-slate-500/20';
                            @endphp
                            <span class="px-2 py-1 rounded border {{ $color }} font-black uppercase text-[8px]">
                                {{ $level }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <button class="p-2 text-slate-600 hover:text-white transition-colors">
                                <i class="fa-solid fa-code-merge text-xs"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center opacity-20">
                                <i class="fa-solid fa-database text-6xl mb-4"></i>
                                <p class="font-black uppercase tracking-widest text-sm">No Events Found In Current Buffer</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="p-8 bg-slate-900/30 border-t border-slate-800">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

    <!-- Legend -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 bg-slate-900 rounded-2xl border border-slate-800 shadow-xl">
            <h4 class="text-white font-black text-[10px] uppercase tracking-widest mb-4">Correlation Clusters</h4>
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1 bg-slate-800 rounded-full text-[9px] font-bold text-slate-400 border border-slate-700">WAF_FIREWALL</span>
                <span class="px-3 py-1 bg-slate-800 rounded-full text-[9px] font-bold text-slate-400 border border-slate-700">BRUTE_FORCE_PROTECT</span>
                <span class="px-3 py-1 bg-slate-800 rounded-full text-[9px] font-bold text-slate-400 border border-slate-700">SQL_INJECTION_SCAN</span>
            </div>
        </div>
    </div>
</div>

