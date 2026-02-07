<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="bg-indigo-900 rounded-[3rem] p-10 overflow-hidden shadow-2xl border border-indigo-800 flex flex-col md:flex-row justify-between items-center gap-8 relative">
        <div class="relative z-10 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-2">
                <i class="fa-solid fa-file-shield text-indigo-300"></i>
                <span class="text-[10px] font-black text-indigo-100 uppercase tracking-widest">Data Loss Prevention</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase leading-none">PENCEGAHAN <span class="text-indigo-400">KEBOCORAN</span></h1>
            <p class="text-indigo-200 font-medium text-lg">Monitoring dan pemblokiran otomatis terhadap transmisi data sensitif.</p>
        </div>
        
        <!-- Radar Animation -->
        <div class="relative z-10 w-24 h-24 flex items-center justify-center">
            <div class="absolute inset-0 bg-indigo-500 rounded-full opacity-20 animate-ping"></div>
            <div class="absolute inset-2 bg-indigo-500 rounded-full opacity-40 animate-ping delay-75"></div>
            <div class="relative bg-indigo-600 w-12 h-12 rounded-full flex items-center justify-center text-white text-2xl shadow-lg border border-indigo-400">
                <i class="fa-solid fa-lock"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Rules Config -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="font-black text-slate-800 text-lg uppercase">Aturan Deteksi</h3>
                    <p class="text-xs text-slate-500 mt-1">Pola Regex untuk scanning traffic keluar.</p>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach($aturanDlp as $index => $aturan)
                    <div class="p-5 flex items-center justify-between group hover:bg-indigo-50/30 transition-colors">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-bold text-slate-800 text-sm">{{ $aturan['nama'] }}</h4>
                                <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded border {{ $aturan['aksi'] == 'blokir' ? 'bg-rose-50 text-rose-600 border-rose-100' : 'bg-amber-50 text-amber-600 border-amber-100' }}">
                                    {{ $aturan['aksi'] }}
                                </span>
                            </div>
                            <code class="text-[10px] text-slate-400 bg-slate-100 px-1 py-0.5 rounded">{{ Str::limit($aturan['pola'], 20) }}</code>
                        </div>
                        <button wire:click="toggleAturan({{ $index }})" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $aturan['status'] == 'aktif' ? 'bg-indigo-600' : 'bg-slate-200' }}">
                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $aturan['status'] == 'aktif' ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>
                    @endforeach
                </div>
                <div class="p-4 bg-slate-50 text-center">
                    <button class="text-xs font-bold text-indigo-600 hover:text-indigo-700 uppercase tracking-widest flex items-center justify-center gap-2 w-full">
                        <i class="fa-solid fa-plus"></i> Tambah Aturan Baru
                    </button>
                </div>
            </div>
        </div>

        <!-- Incident Logs -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-black text-slate-800 text-lg uppercase">Insiden Terdeteksi</h3>
                    <span class="px-3 py-1 bg-rose-50 text-rose-600 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-rose-100 animate-pulse">
                        Live Monitoring
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengguna</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelanggaran</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($insiden as $log)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="text-xs font-bold text-slate-600">{{ $log['waktu']->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-bold text-slate-800">{{ $log['user'] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black text-rose-600">{{ $log['tipe'] }}</span>
                                        <span class="text-[10px] text-slate-400 font-mono truncate max-w-[150px]">{{ $log['konten'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($log['aksi_sistem'] == 'Diblokir')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-rose-100 text-rose-700 text-[10px] font-black uppercase">
                                            <i class="fa-solid fa-shield-halved"></i> Diblokir
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-amber-100 text-amber-700 text-[10px] font-black uppercase">
                                            <i class="fa-solid fa-triangle-exclamation"></i> Dicatat
                                        </span>
                                    @endif
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
