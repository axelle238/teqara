<div class="space-y-6 bg-[#0a0f1d] -m-6 p-6 min-h-screen font-sans text-slate-300">
    
    <!-- Honeypot Header -->
    <div class="bg-[#0f172a] rounded-3xl p-8 border border-slate-800 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500/5 blur-[120px] rounded-full -mr-32 -mt-32"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div>
                <h1 class="text-4xl font-black text-white tracking-tighter uppercase flex items-center gap-4">
                    <span class="p-3 bg-purple-600 rounded-2xl shadow-xl shadow-purple-500/20">
                        <i class="fa-solid fa-spider"></i>
                    </span>
                    HONEYPOT <span class="text-purple-500">TRAPS</span>
                </h1>
                <p class="text-slate-500 mt-2 font-bold tracking-widest text-xs uppercase">Decoy System Monitoring & Bot Trap Analysis</p>
            </div>
            
            <div class="flex items-center gap-4 bg-slate-900/50 p-4 rounded-2xl border border-slate-800">
                <div class="text-center px-4 border-r border-slate-800">
                    <p class="text-[9px] font-black text-slate-500 uppercase mb-1">Traps Active</p>
                    <p class="text-xl font-black text-white">12</p>
                </div>
                <div class="text-center px-4">
                    <p class="text-[9px] font-black text-slate-500 uppercase mb-1">Bots Caught</p>
                    <p class="text-xl font-black text-purple-400">1.4k</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Trap Visualization -->
    <div class="bg-[#0f172a] rounded-3xl border border-slate-800 p-8 relative overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
            @php
                $traps = [
                    ['name' => '/admin/wp-login.php', 'type' => 'Auth Trap', 'hits' => 450, 'status' => 'ACTIVE'],
                    ['name' => '/phpmyadmin', 'type' => 'DB Trap', 'hits' => 320, 'status' => 'ACTIVE'],
                    ['name' => '/.env', 'type' => 'Config Trap', 'hits' => 680, 'status' => 'ACTIVE'],
                ];
            @endphp
            @foreach($traps as $trap)
            <div class="p-6 bg-slate-900/50 rounded-2xl border border-slate-800 group hover:border-purple-500/50 transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center">
                        <i class="fa-solid fa-link"></i>
                    </div>
                    <span class="text-[9px] font-black text-emerald-500 bg-emerald-500/10 px-2 py-0.5 rounded">{{ $trap['status'] }}</span>
                </div>
                <h4 class="text-sm font-black text-white mb-1">{{ $trap['name'] }}</h4>
                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">{{ $trap['type'] }}</p>
                <div class="mt-4 pt-4 border-t border-slate-800 flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-400">Total Hits:</span>
                    <span class="text-sm font-black text-purple-400 font-mono">{{ $trap['hits'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Trap Logs -->
    <div class="bg-[#0f172a] rounded-3xl border border-slate-800 shadow-2xl overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-800 flex justify-between items-center">
            <h3 class="font-black text-white text-xs uppercase tracking-widest">Bot Activity Forensic Log</h3>
            <div class="flex gap-2">
                <button class="px-4 py-1.5 bg-slate-800 hover:bg-slate-700 rounded-lg text-[10px] font-black uppercase transition-colors">Flush Logs</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-900/50 text-slate-500 font-black uppercase text-[9px] tracking-[0.2em]">
                    <tr>
                        <th class="px-8 py-4">IP Address</th>
                        <th class="px-8 py-4">Target Decoy</th>
                        <th class="px-8 py-4">User Agent / Fingerprint</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50 font-mono text-[10px]">
                    @foreach($logs as $log)
                    <tr class="hover:bg-purple-500/5 transition-colors group">
                        <td class="px-8 py-4">
                            <div class="flex flex-col">
                                <span class="text-purple-400 font-bold">{{ $log['ip'] }}</span>
                                <span class="text-slate-600 text-[9px] uppercase">{{ $log['lokasi'] }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <span class="text-white font-bold">{{ $log['target'] }}</span>
                            <span class="text-slate-600 ml-2">[{{ $log['metode'] }}]</span>
                        </td>
                        <td class="px-8 py-4">
                            <span class="text-slate-500 truncate max-w-xs block">{{ $log['user_agent'] }}</span>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <button wire:click="blokirPermanen('{{ $log['ip'] }}')" class="px-3 py-1.5 bg-rose-500/10 text-rose-500 border border-rose-500/20 rounded-lg hover:bg-rose-500 hover:text-white transition-all font-black uppercase text-[8px]">
                                <i class="fa-solid fa-ban"></i> Block
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

