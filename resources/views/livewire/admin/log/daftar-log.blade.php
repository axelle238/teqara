<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Jejak Audit Digital</h1>
            <p class="text-slate-500 text-sm mt-1">Rekaman forensik aktivitas seluruh pengguna sistem.</p>
        </div>
        <div class="relative w-full sm:w-64">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Aksi, Target, atau Pesan..." class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
        </div>
    </div>

    <!-- Timeline Table -->
    <div class="bg-white border border-slate-100 rounded-[24px] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-black tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Waktu Kejadian</th>
                        <th class="px-6 py-4">Aktor</th>
                        <th class="px-6 py-4">Aktivitas</th>
                        <th class="px-6 py-4">Target Data</th>
                        <th class="px-6 py-4 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 transition-colors cursor-pointer group" wire:click="lihatDetail({{ $log->id }})">
                        <td class="px-6 py-4 text-xs text-slate-500 font-mono">
                            {{ $log->waktu->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-xs font-bold text-indigo-600">
                                    {{ substr($log->pengguna->nama ?? 'S', 0, 1) }}
                                </div>
                                <span class="font-bold text-slate-700 text-xs">{{ $log->pengguna->nama ?? 'Sistem Otomatis' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $color = match(true) {
                                    str_contains($log->aksi, 'hapus') => 'text-rose-600 bg-rose-50 border-rose-100',
                                    str_contains($log->aksi, 'buat') || str_contains($log->aksi, 'create') => 'text-emerald-600 bg-emerald-50 border-emerald-100',
                                    str_contains($log->aksi, 'login') => 'text-indigo-600 bg-indigo-50 border-indigo-100',
                                    default => 'text-slate-600 bg-slate-50 border-slate-100'
                                };
                            @endphp
                            <span class="inline-flex px-2 py-1 rounded border text-[10px] font-black uppercase tracking-widest {{ $color }}">
                                {{ $log->aksi }}
                            </span>
                            <p class="text-xs text-slate-500 mt-1 truncate max-w-xs">{{ $log->pesan_naratif }}</p>
                        </td>
                        <td class="px-6 py-4 font-mono text-xs font-bold text-slate-600">
                            {{ $log->target }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-slate-400 group-hover:text-indigo-600 transition-colors">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            Tidak ada aktivitas tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $logs->links() }}
        </div>
    </div>

    <!-- Detail Slide Over -->
    <x-ui.panel-geser id="detail-log" judul="Detail Forensik">
        @if($logTerpilih)
        <div class="space-y-6">
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Aktor</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-500">
                        {{ substr($logTerpilih->pengguna->nama ?? 'S', 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-900">{{ $logTerpilih->pengguna->nama ?? 'Sistem Otomatis' }}</p>
                        <p class="text-xs text-slate-500">{{ $logTerpilih->pengguna->email ?? 'System' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Metadata</p>
                <div class="bg-slate-900 text-slate-300 p-4 rounded-xl font-mono text-xs overflow-x-auto">
                    <div class="grid grid-cols-[100px_1fr] gap-2 mb-2">
                        <span class="text-slate-500">ID Log:</span>
                        <span>#LOG-{{ str_pad($logTerpilih->id, 8, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="grid grid-cols-[100px_1fr] gap-2 mb-2">
                        <span class="text-slate-500">Timestamp:</span>
                        <span>{{ $logTerpilih->waktu->format('Y-m-d H:i:s.u') }}</span>
                    </div>
                    <div class="grid grid-cols-[100px_1fr] gap-2 mb-2">
                        <span class="text-slate-500">Aksi:</span>
                        <span class="text-white font-bold">{{ $logTerpilih->aksi }}</span>
                    </div>
                    <div class="grid grid-cols-[100px_1fr] gap-2">
                        <span class="text-slate-500">Target:</span>
                        <span class="text-white font-bold">{{ $logTerpilih->target }}</span>
                    </div>
                </div>
            </div>

            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Pesan Naratif</p>
                <div class="p-4 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 leading-relaxed">
                    {{ $logTerpilih->pesan_naratif }}
                </div>
            </div>

            @if($logTerpilih->meta_data)
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Perubahan Data (JSON)</p>
                <pre class="bg-slate-50 border border-slate-200 p-4 rounded-xl text-[10px] text-slate-600 overflow-x-auto font-mono leading-relaxed">{{ json_encode(json_decode($logTerpilih->meta_data), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
            </div>
            @endif
        </div>
        @endif
    </x-ui.panel-geser>
</div>