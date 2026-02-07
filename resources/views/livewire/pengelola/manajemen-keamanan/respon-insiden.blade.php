<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="bg-rose-900 rounded-[3rem] p-10 overflow-hidden shadow-2xl border border-rose-800 flex flex-col md:flex-row justify-between items-center gap-8 relative">
        <div class="relative z-10 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-2">
                <i class="fa-solid fa-fire-extinguisher text-rose-300"></i>
                <span class="text-[10px] font-black text-rose-100 uppercase tracking-widest">Incident Response Platform</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase leading-none">RESPON <span class="text-rose-400">INSIDEN</span></h1>
            <p class="text-rose-200 font-medium text-lg">Orkestrasi penanganan ancaman otomatis dan manajemen kasus forensik.</p>
        </div>
        
        <div class="relative z-10 flex gap-4">
            <div class="text-center px-6 py-3 bg-rose-800/50 rounded-2xl border border-rose-700/50 backdrop-blur-sm">
                <p class="text-[10px] font-black text-rose-300 uppercase tracking-widest">MTTR (Mean Time to Resolve)</p>
                <p class="text-3xl font-black text-white">12m</p>
            </div>
        </div>

        <!-- Background Effect -->
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay"></div>
    </div>

    <!-- Active Cases -->
    <div class="grid grid-cols-1 gap-6">
        @foreach($kasus as $k)
        <div class="bg-white rounded-[30px] p-6 border border-slate-100 shadow-sm hover:shadow-lg transition-all relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-1 h-full {{ $k['severitas'] == 'tinggi' ? 'bg-rose-500' : 'bg-amber-500' }}"></div>
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 pl-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="font-mono text-xs font-black text-slate-400 bg-slate-100 px-2 py-0.5 rounded">{{ $k['id'] }}</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded {{ $k['status'] == 'investigasi' ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700' }}">
                            {{ $k['status'] }}
                        </span>
                    </div>
                    <h3 class="text-xl font-black text-slate-900">{{ $k['judul'] }}</h3>
                    <div class="flex items-center gap-4 mt-2 text-xs text-slate-500 font-medium">
                        <span class="flex items-center gap-1"><i class="fa-solid fa-user-shield"></i> {{ $k['analis'] }}</span>
                        <span class="flex items-center gap-1"><i class="fa-regular fa-clock"></i> {{ $k['dibuat']->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button wire:click="jalankanPlaybook('{{ $k['id'] }}', 'Block IP & Terminate Session')" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 transition-colors shadow-lg shadow-slate-900/10 flex items-center gap-2">
                        <i class="fa-solid fa-play"></i> Block IP
                    </button>
                    <button wire:click="jalankanPlaybook('{{ $k['id'] }}', 'Reset User Password')" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-key"></i> Reset Pass
                    </button>
                    <button class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i> Forensik
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Playbook Library -->
    <div class="bg-slate-50 rounded-[40px] p-8 border border-slate-200">
        <h3 class="font-black text-slate-800 text-lg uppercase mb-6 flex items-center gap-3">
            <i class="fa-solid fa-book-skull text-rose-500"></i> Pustaka Playbook Otomatis
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 hover:border-indigo-300 transition-colors cursor-pointer group">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-ban"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-sm">Brute Force Mitigation</h4>
                <p class="text-xs text-slate-500 mt-1">Auto-ban IP setelah 5x gagal login dalam 1 menit.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 hover:border-indigo-300 transition-colors cursor-pointer group">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-virus-slash"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-sm">Malware Containment</h4>
                <p class="text-xs text-slate-500 mt-1">Isolasi host yang terinfeksi dari jaringan internal.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 hover:border-indigo-300 transition-colors cursor-pointer group">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-sm">Phishing Alert</h4>
                <p class="text-xs text-slate-500 mt-1">Hapus email berbahaya dari inbox user secara massal.</p>
            </div>
        </div>
    </div>

</div>
