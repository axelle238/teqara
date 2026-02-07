<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-[3rem] p-10 overflow-hidden shadow-2xl relative">
        <div class="relative z-10 flex justify-between items-end">
            <div class="space-y-2 text-white">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-black/20 border border-white/20 mb-2 backdrop-blur-md">
                    <i class="fa-solid fa-bug text-amber-200"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest">Active Deception</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-black tracking-tighter uppercase leading-none">JEBAKAN <span class="text-amber-900">HONEYPOT</span></h1>
                <p class="font-medium text-amber-100 text-lg max-w-xl">
                    Sistem umpan untuk mendeteksi dan menjebak bot berbahaya yang mencoba memindai celah keamanan.
                </p>
            </div>
            <div class="hidden md:block text-right">
                <p class="text-6xl font-black text-amber-900 opacity-50">{{ $logs->count() }}</p>
                <p class="text-xs font-bold text-amber-100 uppercase tracking-widest">Tangkapan Hari Ini</p>
            </div>
        </div>
        
        <!-- Beehive Pattern -->
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/hexellence.png')] mix-blend-multiply"></div>
        <div class="absolute -right-10 -bottom-20 text-9xl text-black opacity-10 rotate-12">
            <i class="fa-brands fa-hive"></i>
        </div>
    </div>

    <!-- Honeypot Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[30px] border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 text-2xl">
                <i class="fa-solid fa-fingerprint"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black text-slate-900">42</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Unik IP Terjebak</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[30px] border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-600 text-2xl">
                <i class="fa-solid fa-robot"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black text-slate-900">85%</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Bot Terdeteksi</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[30px] border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 text-2xl">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black text-slate-900">12</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Auto-Banned</p>
            </div>
        </div>
    </div>

    <!-- Log Table -->
    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <h3 class="font-black text-slate-800 text-lg uppercase">Log Aktivitas Jebakan</h3>
            
            <div class="flex gap-2">
                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg text-[10px] font-bold uppercase border border-amber-100">
                    <i class="fa-solid fa-circle-dot mr-1 animate-pulse"></i> Monitoring Aktif
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu & IP</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Target URL</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">User Agent</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($logs as $log)
                    <tr class="group hover:bg-amber-50/30 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="font-mono text-xs font-black text-slate-800">{{ $log['ip'] }}</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase">{{ $log['lokasi'] }}</span>
                                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                    <span class="text-[9px] text-slate-400">{{ $log['waktu']->diffForHumans() }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 rounded bg-slate-100 border border-slate-200 text-[10px] font-black text-slate-500 uppercase">{{ $log['metode'] }}</span>
                                <span class="font-mono text-xs text-rose-600 font-bold">{{ $log['target'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-[10px] text-slate-500 font-mono truncate max-w-[200px]" title="{{ $log['user_agent'] }}">
                                {{ $log['user_agent'] }}
                            </p>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button wire:click="blokirPermanen('{{ $log['ip'] }}')" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 transition-colors shadow-lg shadow-slate-900/10">
                                <i class="fa-solid fa-gavel mr-1"></i> Ban IP
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
