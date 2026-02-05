<div class="p-6 lg:p-10 space-y-8">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter">AUDIT <span class="text-indigo-600">TRAIL</span></h1>
            <p class="text-slate-500 font-medium">Rekaman jejak digital seluruh aktivitas sistem.</p>
        </div>
        <div class="relative w-full sm:w-72">
            <input 
                wire:model.live.debounce.300ms="cari" 
                type="text" 
                placeholder="Cari aktivitas, user, atau ID..." 
                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"
            >
            <svg class="w-5 h-5 absolute left-3 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>

    <!-- Timeline Log -->
    <div class="relative pl-8 border-l-2 border-slate-100 space-y-10">
        @forelse($logs as $log)
        <div class="relative group">
            <!-- Timeline Dot -->
            <div class="absolute -left-[41px] top-1 w-5 h-5 rounded-full border-4 border-white shadow-sm flex items-center justify-center 
                @if(str_contains($log->aksi, 'create') || str_contains($log->aksi, 'tambah')) bg-emerald-500
                @elseif(str_contains($log->aksi, 'update') || str_contains($log->aksi, 'edit')) bg-amber-500
                @elseif(str_contains($log->aksi, 'delete') || str_contains($log->aksi, 'hapus')) bg-red-500
                @else bg-indigo-500 @endif
            "></div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-2">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($log->pengguna->nama ?? 'Sistem') }}&background=f1f5f9&color=64748b" class="w-8 h-8 rounded-lg">
                        <div>
                            <p class="text-sm font-bold text-slate-900">
                                {{ $log->pengguna->nama ?? 'Sistem Otomatis' }}
                                <span class="text-slate-400 font-medium text-xs">melakukan</span>
                                <span class="uppercase tracking-wider text-[10px] font-black 
                                    @if(str_contains($log->aksi, 'create')) text-emerald-600
                                    @elseif(str_contains($log->aksi, 'delete')) text-red-600
                                    @else text-indigo-600 @endif
                                ">{{ $log->aksi }}</span>
                            </p>
                            <p class="text-xs text-slate-400">{{ $log->waktu->format('d M Y, H:i') }} • {{ $log->waktu->diffForHumans() }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-lg bg-slate-50 border border-slate-100 text-xs font-bold text-slate-600 font-mono">
                        {{ $log->target }}
                    </span>
                </div>
                
                <p class="text-slate-600 text-sm leading-relaxed border-l-4 border-slate-100 pl-4 py-1">
                    {{ $log->pesan_naratif }}
                </p>

                @if(!empty($log->meta_data))
                <div class="mt-4" x-data="{ open: false }">
                    <button @click="open = !open" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                        <span x-text="open ? 'Sembunyikan Detail Teknis' : 'Lihat Detail Teknis'"></span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" class="mt-2 p-4 bg-slate-900 rounded-xl overflow-x-auto">
                        <pre class="text-[10px] text-emerald-400 font-mono">{{ json_encode($log->meta_data, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Belum Ada Aktivitas</h3>
            <p class="text-slate-500 text-sm">Sistem belum mencatat kegiatan apapun.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-6">
        {{ $logs->links() }}
    </div>
</div>