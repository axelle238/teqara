<div class="space-y-8 pb-20 animate-fade-in">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-slate-900 text-white rounded-2xl shadow-lg shadow-slate-200">
                    <i class="fa-solid fa-list-check text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Audit <span class="text-indigo-600">Log Aktivitas</span></h1>
                    <p class="text-slate-500 font-bold text-[10px] uppercase tracking-widest mt-1">Transparansi Keamanan & Jejak Operasional Sistem</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
             <div class="relative group">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                <input type="text" wire:model.live.debounce.300ms="cari" class="pl-10 pr-4 py-3 bg-white border border-slate-100 rounded-2xl font-bold text-xs focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 w-64 shadow-sm transition-all" placeholder="Cari aktivitas atau aktor...">
            </div>
            <button class="px-6 py-3 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg shadow-slate-900/20 flex items-center gap-2">
                <i class="fa-solid fa-file-export"></i> Ekspor Jejak
            </button>
        </div>
    </div>

    <!-- MAIN TABLE -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu Kejadian</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aktor Utama</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jenis Aksi</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Objek Target</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Narasi Aktivitas</th>
                        <th class="px-8 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($this->log as $item)
                    <tr class="group hover:bg-indigo-50/20 transition-all duration-300">
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-slate-700 tracking-tight">{{ $item->waktu ? $item->waktu->format('H:i:s') : '-' }}</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $item->waktu ? $item->waktu->format('d M Y') : '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-slate-100 to-slate-50 border border-slate-200 flex items-center justify-center text-xs font-black text-slate-600 shadow-sm group-hover:scale-110 transition-transform">
                                    {{ substr($item->pengguna->nama ?? 'S', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-800 uppercase tracking-wide">{{ $item->pengguna->nama ?? 'Sistem Otomatis' }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.15em]">{{ $item->pengguna->peran ?? 'Root' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest bg-slate-100 text-slate-600 border border-slate-200 group-hover:bg-indigo-600 group-hover:text-white group-hover:border-indigo-500 transition-all">
                                {{ str_replace('_', ' ', $item->aksi) }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="font-mono text-[10px] font-bold text-slate-500 px-3 py-1 bg-slate-50 rounded-lg border border-slate-100 group-hover:border-indigo-100 transition-all">
                                {{ $item->target ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs text-slate-500 font-medium leading-relaxed max-w-[250px] truncate group-hover:text-slate-700 transition-colors" title="{{ $item->pesan_naratif }}">
                                {{ $item->pesan_naratif }}
                            </p>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <a href="{{ route('pengelola.log.detail', $item->id) }}" wire:navigate class="inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl hover:text-indigo-600 hover:border-indigo-100 hover:shadow-lg hover:shadow-indigo-100 transition-all">
                                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl opacity-20 grayscale">📋</div>
                            <h3 class="text-slate-900 font-black uppercase tracking-tight">Log Aktivitas Kosong</h3>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Belum ada rekam jejak yang tercatat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($this->log->hasPages())
        <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30">
            {{ $this->log->links() }}
        </div>
        @endif
    </div>
</div>