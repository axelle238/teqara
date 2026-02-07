<div class="space-y-8 pb-20 animate-in fade-in zoom-in duration-500">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-slate-800 text-white rounded-xl">
                    <i class="fa-solid fa-clock-rotate-left text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Log <span class="text-slate-500">Akses API</span></h1>
                    <p class="text-slate-500 font-medium text-sm">Monitor request masuk dari aplikasi pihak ketiga dan mobile apps.</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" wire:model.live.debounce.300ms="cari" class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl font-bold text-xs focus:ring-2 focus:ring-slate-800/20 w-64" placeholder="Cari endpoint...">
            </div>
            <select wire:model.live="filterMetode" class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl font-bold text-xs text-slate-600 focus:ring-2 focus:ring-slate-800/20">
                <option value="">Semua Metode</option>
                <option value="GET">GET</option>
                <option value="POST">POST</option>
                <option value="PUT">PUT</option>
                <option value="DELETE">DELETE</option>
            </select>
            <select wire:model.live="filterStatus" class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl font-bold text-xs text-slate-600 focus:ring-2 focus:ring-slate-800/20">
                <option value="">Semua Status</option>
                <option value="success">Sukses (2xx)</option>
                <option value="error">Error (4xx/5xx)</option>
            </select>
        </div>
    </div>

    <!-- MAIN TABLE -->
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kunci / Client</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Request</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">IP Asal</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Respons</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-700 font-mono">{{ $log->dibuat_pada->format('H:i:s.u') }}</span>
                                <span class="text-[10px] text-slate-400">{{ $log->dibuat_pada->format('d M Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500">
                                    <i class="fa-solid fa-key"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-700">{{ $log->kunciApi->nama_token ?? 'Unknown/Public' }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $log->kunciApi->pengguna->nama ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                @php
                                    $methodColor = match($log->metode) {
                                        'GET' => 'text-blue-600 bg-blue-50',
                                        'POST' => 'text-emerald-600 bg-emerald-50',
                                        'PUT' => 'text-amber-600 bg-amber-50',
                                        'DELETE' => 'text-rose-600 bg-rose-50',
                                        default => 'text-slate-600 bg-slate-100'
                                    };
                                @endphp
                                <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wide {{ $methodColor }}">
                                    {{ $log->metode }}
                                </span>
                                <span class="font-mono text-xs text-slate-600 truncate max-w-[200px]" title="{{ $log->endpoint }}">
                                    {{ Str::limit($log->endpoint, 40) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-[10px] text-slate-500 bg-slate-50 px-2 py-1 rounded border border-slate-100">
                                {{ $log->ip_address }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                             @php
                                $statusColor = match(true) {
                                    $log->respons_kode >= 200 && $log->respons_kode < 300 => 'text-emerald-600 bg-emerald-50',
                                    $log->respons_kode >= 400 && $log->respons_kode < 500 => 'text-amber-600 bg-amber-50',
                                    $log->respons_kode >= 500 => 'text-rose-600 bg-rose-50',
                                    default => 'text-slate-600 bg-slate-100'
                                };
                            @endphp
                            <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide {{ $statusColor }}">
                                {{ $log->respons_kode }} {{ $log->respons_waktu }}ms
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-400">
                            <i class="fa-solid fa-server text-4xl mb-3 opacity-20"></i>
                            <p class="text-sm font-bold">Belum ada aktivitas API.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-8 py-5 border-t border-slate-100">
            {{ $logs->links() }}
        </div>
    </div>
</div>