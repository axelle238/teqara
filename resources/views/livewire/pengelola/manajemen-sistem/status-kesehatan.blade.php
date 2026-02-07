<div class="space-y-8 animate-fade-in pb-20">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Status <span class="text-emerald-600">Kesehatan</span></h1>
            <p class="text-slate-500 font-bold text-[10px] uppercase tracking-[0.2em] mt-1">Diagnostik Real-time Infrastruktur</p>
        </div>
        <button wire:click="$refresh" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">
            <i class="fa-solid fa-rotate mr-2"></i> Segarkan
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Database -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50 rounded-bl-[2.5rem] flex items-center justify-center text-3xl text-indigo-200">
                <i class="fa-solid fa-database"></i>
            </div>
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4">Database</h3>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-3 h-3 rounded-full {{ $this->diagnostik['database']['status'] ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                <span class="text-lg font-black {{ $this->diagnostik['database']['status'] ? 'text-emerald-600' : 'text-rose-600' }}">
                    {{ $this->diagnostik['database']['status'] ? 'Terhubung' : 'Gagal' }}
                </span>
            </div>
            <p class="text-xs text-slate-500 font-mono">Latensi: {{ $this->diagnostik['database']['latency'] }}</p>
        </div>

        <!-- Cache -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-[2.5rem] flex items-center justify-center text-3xl text-amber-200">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4">Cache Driver</h3>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-3 h-3 rounded-full {{ $this->diagnostik['cache']['status'] ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                <span class="text-lg font-black text-slate-700 uppercase">
                    {{ $this->diagnostik['cache']['driver'] }}
                </span>
            </div>
            <p class="text-xs text-slate-500 font-mono">Write Test: {{ $this->diagnostik['cache']['status'] ? 'OK' : 'FAIL' }}</p>
        </div>

        <!-- Storage & Logs -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-rose-50 rounded-bl-[2.5rem] flex items-center justify-center text-3xl text-rose-200">
                <i class="fa-solid fa-hard-drive"></i>
            </div>
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4">File System</h3>
            <div class="mb-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Ukuran Log Laravel</p>
                <p class="text-lg font-black text-slate-800">{{ $this->diagnostik['storage']['log_size'] }}</p>
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-xl">
        <h3 class="text-sm font-black text-white uppercase tracking-widest mb-6 border-b border-white/10 pb-4">Lingkungan Server</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Versi PHP</p>
                <p class="text-xl font-mono text-indigo-300">{{ $this->diagnostik['php'] }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Waktu Server</p>
                <p class="text-xl font-mono text-emerald-300">{{ $this->diagnostik['server_time'] }}</p>
            </div>
            <div class="col-span-2 text-right">
                <button wire:click="bersihkanCache" class="px-6 py-3 bg-rose-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-700 transition-all shadow-lg shadow-rose-900/50">
                    <i class="fa-solid fa-trash mr-2"></i> Paksa Bersihkan Cache
                </button>
            </div>
        </div>
    </div>
</div>