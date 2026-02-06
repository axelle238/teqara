<div class="animate-in fade-in duration-500 pb-20">
    
    @if(!$tampilkanDetail)
        <!-- TAMPILAN 1: PUSAT LOG AKTIVITAS (FULL PAGE LIST) -->
        <div class="space-y-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="space-y-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                        <span class="text-[9px] font-black text-rose-600 uppercase tracking-widest">Keamanan & Audit</span>
                    </div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Jejak Audit Digital</h1>
                    <p class="text-slate-500 font-medium">Monitoring forensik seluruh aktivitas administratif dalam ekosistem Teqara.</p>
                </div>
            </div>

            <!-- Toolbar Search -->
            <div class="bg-white p-4 rounded-[30px] border border-indigo-50 flex items-center px-6 gap-4 shadow-sm">
                <i class="fa-solid fa-magnifying-glass text-slate-300"></i>
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari aksi, target, atau pesan naratif..." class="flex-1 bg-transparent border-none text-sm font-bold text-slate-700 focus:ring-0 placeholder:text-slate-300">
            </div>

            <!-- Table Log -->
            <div class="bg-white rounded-[45px] shadow-sm border border-indigo-50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Waktu & Otoritas</th>
                                <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kategori Aksi</th>
                                <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pesan Naratif</th>
                                <th class="px-10 py-6 text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($logs as $log)
                            <tr class="group hover:bg-slate-50 transition-all">
                                <td class="px-10 py-6 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-2xl bg-slate-50 flex items-center justify-center text-[10px] font-black text-slate-400 border border-slate-100 group-hover:bg-white group-hover:text-indigo-600 transition-colors">
                                            {{ substr($log->pengguna->nama ?? 'S', 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-black text-slate-800 uppercase">{{ $log->pengguna->nama ?? 'Sistem' }}</span>
                                            <span class="text-[9px] font-bold text-slate-400 uppercase">{{ $log->waktu->translatedFormat('d M Y • H:i') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border bg-white border-slate-200 text-slate-500 group-hover:border-indigo-200 group-hover:text-indigo-600 transition-colors">
                                        {{ str_replace('_', ' ', $log->aksi) }}
                                    </span>
                                </td>
                                <td class="px-6 py-6">
                                    <p class="text-xs font-bold text-slate-500 leading-relaxed line-clamp-1 italic">"{{ $log->pesan_naratif }}"</p>
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <button wire:click="lihatDetail({{ $log->id }})" class="px-6 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all shadow-sm">ANALISIS DATA</button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-10 py-20 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">Belum ada rekaman aktivitas digital.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-10 border-t border-slate-50">{{ $logs->links() }}</div>
            </div>
        </div>
    @else
        <!-- TAMPILAN 2: ANALISIS FORENSIK (FULL PAGE FORM) -->
        <div class="space-y-8 animate-in slide-in-from-right-8 duration-500">
            <!-- Header Analisis -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="flex items-center gap-6">
                    <button wire:click="kembali" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                    </button>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Rincian Forensik Log</h1>
                        <p class="text-slate-500 font-medium">Analisis metadata aktivitas digital ID: #{{ $logTerpilih->id }}</p>
                    </div>
                </div>
                <div class="flex gap-3 text-xs font-black text-slate-400 uppercase tracking-widest">
                    {{ $logTerpilih->waktu->translatedFormat('l, d F Y H:i:s') }} WIB
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Narasi & Objek -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10">
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Narasi Aktivitas</label>
                            <div class="bg-slate-50 p-8 rounded-[35px] border border-slate-100">
                                <p class="text-lg font-black text-slate-700 leading-relaxed italic">"{{ $logTerpilih->pesan_naratif }}"</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Kategori Aksi</label>
                                <div class="bg-white border-2 border-indigo-50 px-6 py-4 rounded-2xl text-sm font-black text-indigo-600 uppercase tracking-widest">{{ $logTerpilih->aksi }}</div>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Target Objek</label>
                                <div class="bg-white border-2 border-slate-50 px-6 py-4 rounded-2xl text-sm font-black text-slate-800 uppercase tracking-widest">{{ $logTerpilih->target }}</div>
                            </div>
                        </div>

                        <div class="space-y-4 pt-8 border-t border-slate-50">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Metadata Teknis (Snapshot)</label>
                            <div class="bg-slate-900 p-8 rounded-[35px] shadow-inner overflow-x-auto">
                                <pre class="text-xs text-emerald-400 font-mono leading-relaxed">{{ json_encode($logTerpilih->meta_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Aktor -->
                <div class="space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8 text-center">
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Otoritas Eksekutor</label>
                            <div class="relative inline-block">
                                <div class="w-24 h-24 rounded-[35px] bg-indigo-600 flex items-center justify-center text-3xl font-black text-white shadow-2xl shadow-indigo-500/30">
                                    {{ substr($logTerpilih->pengguna->nama ?? 'S', 0, 1) }}
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">{{ $logTerpilih->pengguna->nama ?? 'Sistem Otomatis' }}</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">{{ $logTerpilih->pengguna->peran ?? 'Sistem' }}</p>
                            </div>
                        </div>

                        <div class="pt-8 border-t border-slate-50 space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Jejak Koneksi</label>
                            <div class="bg-slate-50 p-6 rounded-[35px] border border-slate-100 text-left space-y-4">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-network-wired text-indigo-400 text-xs w-4 text-center"></i>
                                    <span class="text-[10px] font-black text-slate-600 font-mono tracking-widest">{{ $logTerpilih->meta_data['ip_address'] ?? '0.0.0.0' }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-laptop-code text-indigo-400 text-xs w-4 text-center"></i>
                                    <span class="text-[10px] font-black text-slate-600 truncate">{{ $logTerpilih->meta_data['user_agent'] ?? 'Unknown Agent' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Integritas Data -->
                    <div class="bg-rose-500 p-10 rounded-[50px] text-white shadow-2xl shadow-rose-500/30 space-y-4 relative overflow-hidden group">
                        <i class="fa-solid fa-shield-virus text-4xl opacity-20 absolute -right-4 -top-4 group-hover:scale-150 transition-transform duration-1000"></i>
                        <h4 class="text-lg font-black uppercase tracking-tight">Kepatuhan Audit</h4>
                        <p class="text-xs font-bold text-rose-50 leading-relaxed opacity-90">
                            "Rekaman log aktivitas bersifat permanen dan tidak dapat dimanipulasi untuk menjaga integritas data dan keamanan perusahaan."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
