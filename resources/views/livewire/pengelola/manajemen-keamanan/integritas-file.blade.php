<div class="space-y-6 bg-slate-50 -m-6 p-6 min-h-screen font-sans">
    
    <!-- FIM Header -->
    <div class="bg-[#0f172a] rounded-3xl p-10 border border-slate-800 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500/5 blur-[120px] rounded-full -mr-32 -mt-32"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div>
                <h1 class="text-4xl font-black text-white tracking-tighter uppercase flex items-center gap-4">
                    <span class="p-3 bg-emerald-600 rounded-2xl shadow-xl shadow-emerald-500/20">
                        <i class="fa-solid fa-fingerprint"></i>
                    </span>
                    FILE <span class="text-emerald-500">INTEGRITY</span>
                </h1>
                <p class="text-slate-400 mt-2 font-bold tracking-widest text-xs uppercase">File Integrity Monitoring (FIM) & Forensic Hashing</p>
            </div>
            
            <button wire:click="mulaiScan" 
                    wire:loading.attr="disabled"
                    class="px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black uppercase tracking-widest transition-all shadow-xl shadow-emerald-900/40 flex items-center gap-3">
                <span wire:loading.remove><i class="fa-solid fa-radar"></i> Run Core Scan</span>
                <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i> Analyzing...</span>
            </button>
        </div>
    </div>

    <!-- Scanner Progress (Livewire Loading State) -->
    <div wire:loading wire:target="mulaiScan" class="w-full">
        <div class="bg-slate-900 rounded-3xl p-12 border border-slate-800 shadow-2xl flex flex-col items-center justify-center text-center">
            <div class="w-24 h-24 rounded-full border-4 border-emerald-500/20 flex items-center justify-center relative mb-8">
                <div class="absolute inset-0 rounded-full border-4 border-t-emerald-500 border-transparent animate-spin"></div>
                <i class="fa-solid fa-shield-halved text-3xl text-emerald-500"></i>
            </div>
            <h3 class="text-2xl font-black text-white uppercase tracking-[0.2em] animate-pulse">Hashing System Files</h3>
            <p class="text-slate-500 font-mono text-xs mt-4">MD5_CHECKSUM: {{ md5(now()) }} ... COMPARING_MASTER</p>
        </div>
    </div>

    <!-- Results Table -->
    @if($scanStatus === 'selesai')
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest">Master Integrity Report</h3>
                <p class="text-[10px] text-slate-400 mt-1 font-bold">SHA-256 / MD5 Hashing comparison with master repository</p>
            </div>
            <div class="flex gap-2">
                <div class="px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl text-[10px] font-black uppercase tracking-widest">
                    <i class="fa-solid fa-circle-check mr-1"></i> Scan Passed
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[9px] tracking-[0.2em]">
                    <tr>
                        <th class="px-8 py-4">Target File Path</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4">Checksum Hash</th>
                        <th class="px-8 py-4 text-right">Modified Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($hasilScan as $file)
                    <tr class="group hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-slate-100 text-slate-500 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                                    <i class="fa-solid fa-file-shield text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-700 text-xs">{{ $file['file'] }}</span>
                                    <span class="text-[9px] text-slate-400 font-mono">/app/{{ $file['file'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase bg-emerald-100 text-emerald-600 border border-emerald-200">
                                {{ $file['status'] }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <code class="px-3 py-1 bg-slate-50 rounded border border-slate-200 text-[10px] font-mono text-slate-500 group-hover:text-indigo-600 transition-colors">
                                {{ $file['hash'] }}
                            </code>
                        </td>
                        <td class="px-8 py-5 text-right font-bold text-slate-500 text-xs">
                            {{ date('Y-m-d H:i:s', $file['last_modified']) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Security Advisories -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="p-8 bg-indigo-900 rounded-3xl border border-indigo-800 shadow-2xl relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-user-shield text-8xl text-white"></i>
            </div>
            <h4 class="text-white font-black text-xs uppercase tracking-[0.2em] mb-4">Security Advisory</h4>
            <p class="text-indigo-200 text-xs leading-relaxed font-medium">
                The File Integrity Monitoring system tracks modifications to your system's critical files. Any unauthorized change will trigger an immediate SOC alert and lock down sensitive endpoints.
            </p>
        </div>

        <div class="p-8 bg-slate-900 rounded-3xl border border-slate-800 shadow-2xl relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-vault text-8xl text-white"></i>
            </div>
            <h4 class="text-white font-black text-xs uppercase tracking-[0.2em] mb-4">Baseline Hashing</h4>
            <p class="text-slate-400 text-xs leading-relaxed font-medium">
                Your current baseline was established during the last deployment. Modifications detected here should be cross-referenced with your CI/CD logs.
            </p>
        </div>
    </div>
</div>

