<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="bg-fuchsia-900 rounded-[3rem] p-10 overflow-hidden shadow-2xl border border-fuchsia-800 flex flex-col md:flex-row justify-between items-center gap-8 relative">
        <div class="relative z-10 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-2">
                <i class="fa-solid fa-microscope text-fuchsia-300"></i>
                <span class="text-[10px] font-black text-fuchsia-100 uppercase tracking-widest">Digital Forensics Lab</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase leading-none">FORENSIK <span class="text-fuchsia-400">DIGITAL</span></h1>
            <p class="text-fuchsia-200 font-medium text-lg">Analisis malware mendalam dan manajemen barang bukti digital.</p>
        </div>
        
        <div class="relative z-10 flex gap-4">
            <div class="w-32 h-32 rounded-full border-4 border-fuchsia-500/30 flex flex-col items-center justify-center bg-fuchsia-800/50 shadow-xl backdrop-blur-sm">
                <i class="fa-solid fa-biohazard text-4xl text-fuchsia-300"></i>
            </div>
        </div>

        <!-- Background Effect -->
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Malware Sandbox -->
        <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-black text-slate-800 text-lg uppercase">Malware Sandbox</h3>
                <span class="px-3 py-1 bg-fuchsia-50 text-fuchsia-600 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-fuchsia-100">
                    Isolated Environment
                </span>
            </div>
            <div class="p-8 space-y-6">
                <form wire:submit.prevent="analyzeFile" class="relative border-2 border-dashed border-slate-300 rounded-2xl p-10 text-center hover:bg-slate-50 transition-colors">
                    <input type="file" wire:model="fileSample" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="space-y-2">
                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-slate-400"></i>
                        <p class="font-bold text-slate-600">Drag & Drop atau Klik untuk Upload Sampel</p>
                        <p class="text-xs text-slate-400">Mendukung EXE, PDF, DOCX, DLL (Max 10MB)</p>
                    </div>
                </form>

                @if($analyzing)
                    <div class="flex items-center gap-4 p-4 bg-fuchsia-50 rounded-xl border border-fuchsia-100">
                        <i class="fa-solid fa-circle-notch fa-spin text-fuchsia-600"></i>
                        <span class="text-sm font-bold text-fuchsia-700">Menganalisis perilaku file dalam container terisolasi...</span>
                    </div>
                @endif

                @if($analysisResult)
                    <div class="bg-rose-50 rounded-2xl p-6 border border-rose-100 space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="font-black text-rose-800 uppercase flex items-center gap-2">
                                <i class="fa-solid fa-triangle-exclamation"></i> Hasil Analisis
                            </h4>
                            <span class="bg-rose-200 text-rose-800 px-3 py-1 rounded-full text-xs font-black">{{ $analysisResult['score'] }}/100 Malicious</span>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-bold text-slate-700">Family: <span class="font-mono text-rose-600">{{ $analysisResult['family'] }}</span></p>
                            <ul class="text-xs text-slate-600 list-disc pl-4 space-y-1">
                                @foreach($analysisResult['indicators'] as $ind)
                                    <li>{{ $ind }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Chain of Custody -->
        <div class="bg-slate-900 rounded-[30px] shadow-xl border border-slate-800 overflow-hidden">
            <div class="p-8 border-b border-slate-800 flex justify-between items-center">
                <h3 class="font-black text-white text-lg uppercase">Chain of Custody</h3>
                <i class="fa-solid fa-link text-fuchsia-500"></i>
            </div>
            <div class="p-0">
                <table class="w-full text-left">
                    <thead class="bg-slate-800/50 text-slate-400">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest">ID Bukti</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest">Tipe & Hash</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest">Penanggung Jawab</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-300">
                        @foreach($evidence as $ev)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-fuchsia-400">{{ $ev['id'] }}</td>
                            <td class="px-6 py-4">
                                <span class="block font-bold">{{ $ev['type'] }}</span>
                                <span class="block text-[10px] font-mono text-slate-500 truncate w-32">{{ $ev['hash'] }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="block font-bold">{{ $ev['custodian'] }}</span>
                                <span class="block text-[10px] text-slate-500">{{ $ev['timestamp'] }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
