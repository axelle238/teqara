<div class="space-y-8 pb-20 animate-in fade-in zoom-in duration-500">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-slate-800 text-white rounded-xl">
                    <i class="fa-solid fa-list-check text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Audit <span class="text-slate-500">Log Sistem</span></h1>
                    <p class="text-slate-500 font-medium text-sm">Rekam jejak aktivitas pengguna dan sistem untuk keamanan & transparansi.</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
             <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" wire:model.live.debounce.300ms="cari" class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl font-bold text-xs focus:ring-2 focus:ring-slate-800/20 w-64" placeholder="Cari aktivitas...">
            </div>
            <button class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-slate-50 transition-colors">
                <i class="fa-solid fa-filter mr-2"></i> Filter
            </button>
            <button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/30">
                <i class="fa-solid fa-file-export mr-2"></i> Ekspor CSV
            </button>
        </div>
    </div>

    <!-- MAIN TABLE -->
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aktor (Pengguna)</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Target</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($this->log as $item)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-700">{{ $item->waktu ? $item->waktu->format('H:i:s') : '-' }}</span>
                                <span class="text-[10px] text-slate-400">{{ $item->waktu ? $item->waktu->format('d M Y') : '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500">
                                    {{ substr($item->pengguna->nama ?? 'S', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-700">{{ $item->pengguna->nama ?? 'System' }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $item->pengguna->peran ?? 'Bot/Auto' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $color = match(true) {
                                    str_contains($item->aksi, 'hapus') || str_contains($item->aksi, 'delete') => 'text-rose-600 bg-rose-50',
                                    str_contains($item->aksi, 'tambah') || str_contains($item->aksi, 'create') => 'text-emerald-600 bg-emerald-50',
                                    str_contains($item->aksi, 'login') => 'text-indigo-600 bg-indigo-50',
                                    default => 'text-slate-600 bg-slate-100'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide {{ $color }}">
                                {{ $item->aksi }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs text-slate-600 bg-slate-50 px-2 py-1 rounded border border-slate-100">
                                {{ $item->target ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs text-slate-500 truncate max-w-[200px]" title="{{ $item->pesan_naratif }}">
                                {{ $item->pesan_naratif }}
                            </p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-400">
                            <i class="fa-solid fa-clipboard-list text-4xl mb-3 opacity-20"></i>
                            <p class="text-sm font-bold">Tidak ada log aktivitas ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-8 py-5 border-t border-slate-100">
            {{ $this->log->links() }}
        </div>
    </div>
</div>