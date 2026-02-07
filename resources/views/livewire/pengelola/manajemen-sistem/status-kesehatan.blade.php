<div class="space-y-8 pb-20 animate-in fade-in zoom-in duration-500">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-teal-100 text-teal-600 rounded-xl">
                    <i class="fa-solid fa-heart-pulse text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Kesehatan <span class="text-teal-600">Sistem</span></h1>
                    <p class="text-slate-500 font-medium text-sm">Pemantauan performa server, database, dan antrian job secara real-time.</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <button wire:click="unduhLaporan" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-slate-50 transition-colors">
                <i class="fa-solid fa-download mr-2"></i> Unduh Laporan
            </button>
            <button wire:poll.5s class="px-5 py-2.5 bg-teal-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-teal-700 transition-colors shadow-lg shadow-teal-500/30 flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                </span>
                Live Monitoring
            </button>
        </div>
    </div>

    <!-- MAIN METRICS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- CPU Usage -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm relative overflow-hidden group hover:border-teal-300 transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-teal-50 text-teal-600 rounded-2xl group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-microchip text-xl"></i>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-2 py-1 rounded-lg">4 Cores (Est)</span>
            </div>
            <h3 class="text-4xl font-black text-slate-800 mb-1">{{ $cpu_usage }}%</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">CPU Usage</p>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-4">
                <div class="bg-teal-500 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $cpu_usage }}%"></div>
            </div>
        </div>

        <!-- RAM Usage -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm relative overflow-hidden group hover:border-indigo-300 transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-memory text-xl"></i>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-2 py-1 rounded-lg">{{ $ram_total }} Limit</span>
            </div>
            <h3 class="text-4xl font-black text-slate-800 mb-1">{{ $ram_usage }}%</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">App Memory Usage</p>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-4">
                <div class="bg-indigo-500 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $ram_usage }}%"></div>
            </div>
        </div>

        <!-- Disk Usage -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm relative overflow-hidden group hover:border-rose-300 transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl group-hover:bg-rose-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-hard-drive text-xl"></i>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-2 py-1 rounded-lg">{{ $disk_total_gb }} GB</span>
            </div>
            <h3 class="text-4xl font-black text-slate-800 mb-1">{{ $disk_usage }}%</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Storage Used</p>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-4">
                <div class="bg-rose-500 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $disk_usage }}%"></div>
            </div>
        </div>

        <!-- Database Load -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm relative overflow-hidden group hover:border-amber-300 transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-database text-xl"></i>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-2 py-1 rounded-lg">MySQL</span>
            </div>
            <h3 class="text-3xl font-black {{ $db_status == 'Connected' ? 'text-emerald-500' : 'text-rose-500' }} mb-1">{{ $db_latency }} ms</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Latency ({{ $db_status }})</p>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-4">
                <div class="{{ $db_status == 'Connected' ? 'bg-amber-500' : 'bg-rose-500' }} h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <!-- DETAILED METRICS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Environment Info -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 relative overflow-hidden">
            <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest mb-6 pb-4 border-b border-slate-100">Informasi Lingkungan</h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 bg-slate-50 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <i class="fa-brands fa-php text-2xl text-indigo-500"></i>
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase">Versi PHP</p>
                            <p class="text-sm font-black text-slate-800">{{ phpversion() }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase">Supported</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-slate-50 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <i class="fa-brands fa-laravel text-2xl text-red-500"></i>
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase">Framework</p>
                            <p class="text-sm font-black text-slate-800">Laravel v{{ app()->version() }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase">Latest</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-slate-50 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-server text-2xl text-slate-500"></i>
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase">Web Server</p>
                            <p class="text-sm font-black text-slate-800">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Queue & Jobs -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 relative overflow-hidden">
            <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest mb-6 pb-4 border-b border-slate-100">Antrian & Proses Latar Belakang</h3>
            
            <div class="space-y-6">
                <!-- Queue Worker Status -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 animate-pulse">
                        <i class="fa-solid fa-gears text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">Worker Engine</h4>
                        <p class="text-xs text-slate-500">Database Driver</p>
                    </div>
                    <div class="ml-auto">
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase">Active</span>
                    </div>
                </div>

                <!-- Job Lists -->
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-bold text-slate-600"><i class="fa-solid fa-envelope mr-2 text-indigo-500"></i> Kirim Email (queue:emails)</span>
                        <span class="font-mono text-slate-400">{{ $queue_email }} jobs pending</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5">
                        <div class="bg-indigo-500 h-1.5 rounded-full transition-all duration-1000" style="width: {{ min($queue_email * 10, 100) }}%"></div>
                    </div>

                    <div class="flex justify-between items-center text-xs pt-2">
                        <span class="font-bold text-slate-600"><i class="fa-solid fa-layer-group mr-2 text-rose-500"></i> Job Standar (queue:default)</span>
                        <span class="font-mono text-slate-400">{{ $queue_default }} jobs pending</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5">
                        <div class="bg-rose-500 h-1.5 rounded-full transition-all duration-1000" style="width: {{ min($queue_default * 10, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>