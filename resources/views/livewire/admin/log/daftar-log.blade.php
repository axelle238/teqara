<div class="space-y-10">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">JEJAK <span class="text-slate-500">AUDIT</span></h1>
            <p class="text-slate-500 font-medium">Rekaman forensik seluruh aktivitas pengguna dalam sistem.</p>
        </div>
        <div class="relative w-72">
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari ID, Aktor, atau Aktivitas..." class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-slate-500 shadow-sm">
            <svg class="w-5 h-5 absolute left-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>

    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden" wire:poll.5s>
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <div class="flex items-center gap-3">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Live Monitoring</span>
            </div>
            <span class="text-[10px] font-bold text-slate-400">Pembaruan Otomatis (5s)</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu Kejadian</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aktor</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aktivitas</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Target</th>
                        <th class="px-8 py-5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($logs as $log)
                    <tr class="group hover:bg-slate-50/50 transition cursor-pointer" wire:click="lihatDetail({{ $log->id }})">
                        <td class="px-8 py-4">
                            <p class="text-xs font-bold text-slate-900">{{ $log->waktu->format('d M Y H:i:s') }}</p>
                            <p class="text-[10px] text-slate-400">{{ $log->waktu->diffForHumans() }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-black text-slate-600 border-2 border-white shadow-sm">
                                    {{ substr($log->pengguna->nama ?? 'S', 0, 1) }}
                                </div>
                                <span class="text-xs font-bold text-slate-700">{{ $log->pengguna->nama ?? 'Sistem Otomatis' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2 py-1 bg-slate-100 text-slate-600 rounded text-[10px] font-mono font-bold uppercase mb-1">{{ $log->aksi }}</span>
                            <p class="text-xs text-slate-600 leading-snug truncate max-w-md">{{ $log->pesan_naratif }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-slate-500 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">{{ $log->target ?? '-' }}</span>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <svg class="w-5 h-5 text-slate-300 group-hover:text-slate-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold">Tidak ada catatan aktivitas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-slate-50/30 border-t border-slate-50">
            {{ $logs->links() }}
        </div>
    </div>

    <!-- Panel Detail Log -->
    <x-ui.slide-over id="detail-log" title="Bukti Digital">
        @if($logTerpilih)
        <div class="space-y-8 p-2">
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pesan Naratif</p>
                <p class="text-sm font-medium text-slate-800 leading-relaxed">{{ $logTerpilih->pesan_naratif }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Waktu Kejadian</p>
                    <p class="text-xs font-bold text-slate-900">{{ $logTerpilih->waktu->format('d F Y H:i:s') }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">IP Address</p>
                    <p class="text-xs font-bold text-slate-900">127.0.0.1 (Lokal)</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Aktor</p>
                    <p class="text-xs font-bold text-slate-900">{{ $logTerpilih->pengguna->nama ?? 'Sistem' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Target Objek</p>
                    <p class="text-xs font-bold text-slate-900">{{ $logTerpilih->target }}</p>
                </div>
            </div>

            @if(!empty($logTerpilih->meta_data))
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Metadata Teknis (JSON)</p>
                <div class="bg-slate-900 text-green-400 p-4 rounded-xl text-[10px] font-mono overflow-x-auto">
                    <pre>{{ json_encode($logTerpilih->meta_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            </div>
            @endif
        </div>
        @endif
    </x-ui.slide-over>
</div>
