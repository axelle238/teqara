<div class="space-y-10 pb-20">
    <!-- Header: Vibrant & Modern -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-50 border border-slate-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-slate-400 animate-pulse"></span>
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Digital Forensic Records</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">JEJAK <span class="text-indigo-600">AUDIT</span></h1>
            <p class="text-slate-500 font-medium text-lg">Rekaman seluruh aktivitas digital dalam ekosistem sistem secara presisi.</p>
        </div>
        <div class="relative group">
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Aktor atau Aktivitas..." class="w-80 pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 shadow-sm transition-all">
            <svg class="w-5 h-5 absolute left-4 top-4 text-slate-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>

    <!-- Live Monitoring Table -->
    <div class="bg-white rounded-[56px] border border-indigo-50 shadow-sm overflow-hidden" wire:poll.5s>
        <div class="px-10 py-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <div class="flex items-center gap-4">
                <div class="flex h-3 w-3 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 shadow-lg shadow-emerald-500/50"></span>
                </div>
                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em]">Monitoring Aktif</span>
            </div>
            <div class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                <span>Sinkronisasi Otomatis</span>
                <span class="px-2 py-0.5 bg-white border border-slate-100 rounded-md">5s</span>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white border-b border-slate-50">
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Kejadian Digital</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Aktor Sistem</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Aktivitas Narasi</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Objek Target</th>
                        <th class="px-10 py-6"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($logs as $log)
                    <tr class="group hover:bg-indigo-50/20 transition-all duration-300 cursor-pointer" wire:click="lihatDetail({{ $log->id }})">
                        <td class="px-10 py-6">
                            <p class="text-sm font-black text-slate-900 tracking-tighter">{{ $log->waktu->format('H:i:s') }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">{{ $log->waktu->translatedFormat('d M Y') }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-[14px] bg-indigo-50 flex items-center justify-center text-[10px] font-black text-indigo-600 border border-indigo-100 shadow-inner group-hover:scale-110 transition-transform">
                                    {{ substr($log->pengguna->nama ?? 'S', 0, 1) }}
                                </div>
                                <span class="text-xs font-black text-slate-700 uppercase tracking-tight">{{ $log->pengguna->nama ?? 'SYSTEM CORE' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <span class="inline-flex px-3 py-1 bg-white border border-indigo-100 text-indigo-600 rounded-lg text-[9px] font-black uppercase tracking-widest mb-2 shadow-sm">{{ $log->aksi }}</span>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed truncate max-w-sm">{{ $log->pesan_naratif }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <span class="text-[10px] font-black text-slate-400 border border-slate-100 px-3 py-1.5 rounded-xl bg-slate-50 uppercase">{{ $log->target ?? 'UNIVERSAL' }}</span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-slate-300 group-hover:bg-indigo-600 group-hover:text-white transition-all transform group-hover:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-32 text-center">
                            <div class="text-6xl mb-6">📂</div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tighter uppercase mb-2">Log Kosong</h3>
                            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Belum ada aktivitas yang terekam pada radar.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-10 bg-slate-50/30 border-t border-slate-50 flex justify-center">
            {{ $logs->links() }}
        </div>
    </div>

    <!-- Panel Detail Log: Forensic Analysis -->
    <x-ui.slide-over id="detail-log" title="ANALISIS FORENSIK DIGITAL">
        @if($logTerpilih)
        <div class="space-y-10 p-2">
            <!-- Header Insight -->
            <div class="bg-indigo-600 p-8 rounded-[40px] text-white shadow-2xl shadow-indigo-500/30 relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-indigo-200 uppercase tracking-[0.3em] mb-4">Narasi Peristiwa</p>
                    <p class="text-lg font-black leading-relaxed tracking-tight">{{ $logTerpilih->pesan_naratif }}</p>
                </div>
                <!-- Background Deco -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl translate-x-10 -translate-y-10"></div>
            </div>

            <!-- Forensic Grid -->
            <div class="grid grid-cols-2 gap-6">
                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 shadow-inner">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Source IP</p>
                    <p class="text-sm font-black text-slate-900 tracking-tight">{{ $logTerpilih->meta_data['ip_address'] ?? '127.0.0.1' }}</p>
                </div>
                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 shadow-inner">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Protocol</p>
                    <p class="text-sm font-black text-indigo-600 uppercase">{{ $logTerpilih->meta_data['metode'] ?? 'INTERNAL' }}</p>
                </div>
                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 shadow-inner">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Precise Time</p>
                    <p class="text-sm font-black text-slate-900">{{ $logTerpilih->waktu->format('H:i:s.u') }}</p>
                </div>
                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 shadow-inner">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Authority</p>
                    <p class="text-sm font-black text-slate-900 uppercase">{{ $logTerpilih->pengguna->nama ?? 'KERNEL' }}</p>
                </div>
            </div>

            <!-- User Agent Visualizer -->
            <div class="p-8 bg-slate-50 rounded-[32px] border border-slate-100">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-4">Device Fingerprint (User Agent)</p>
                <p class="text-xs font-medium text-slate-600 leading-relaxed font-mono break-all">{{ $logTerpilih->meta_data['user_agent'] ?? 'Unidentified Entity' }}</p>
            </div>

            <!-- Snapshot Code Viewer: Vibrant Code View -->
            @if(!empty($logTerpilih->meta_data['snapshot']))
            <div class="space-y-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Snapshot State (JSON)</p>
                <div class="bg-indigo-50 text-indigo-900 p-8 rounded-[48px] border-2 border-white shadow-inner overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-1 bg-indigo-200"></div>
                    <pre class="text-[10px] font-mono overflow-x-auto custom-scrollbar leading-relaxed"><code>{{ json_encode($logTerpilih->meta_data['snapshot'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                </div>
            </div>
            @endif
        </div>
        @endif
    </x-ui.slide-over>
</div>
