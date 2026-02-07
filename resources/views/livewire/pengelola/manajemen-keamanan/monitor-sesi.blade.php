<div class="space-y-8 pb-20 animate-in fade-in zoom-in duration-500">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-violet-100 text-violet-600 rounded-xl">
                    <i class="fa-solid fa-users-viewfinder text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Monitor <span class="text-violet-600">Sesi Aktif</span></h1>
                    <p class="text-slate-500 font-medium text-sm">Pantau dan kelola pengguna yang sedang login ke sistem.</p>
                </div>
            </div>
        </div>
        <div>
            <button wire:click="hapusSemua" wire:confirm="⚠️ PERINGATAN: Ini akan memaksa KELUAR semua pengguna (termasuk Anda). Lanjutkan?" class="px-6 py-3 bg-rose-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-rose-700 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fa-solid fa-bomb"></i> Hapus Semua Sesi
            </button>
        </div>
    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                <i class="fa-solid fa-signal text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Sesi</p>
                <h3 class="text-2xl font-black text-slate-800">{{ count($sessions) }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                <i class="fa-brands fa-windows text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Platform Dominan</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $sessions->where('platform', 'Windows')->count() > $sessions->where('platform', '!=', 'Windows')->count() ? 'Windows' : 'Mobile/Mac' }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center text-amber-600">
                <i class="fa-solid fa-user-shield text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Administrator</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $sessions->where('peran', 'admin')->count() }}</h3>
            </div>
        </div>
    </div>

    <!-- SESSION LIST -->
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengguna</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Perangkat & IP</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aktivitas Terakhir</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sessions as $session)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center overflow-hidden border border-slate-200">
                                    @if($session->pengguna_id)
                                        <span class="font-bold text-slate-500">{{ substr($session->nama, 0, 1) }}</span>
                                    @else
                                        <i class="fa-solid fa-user-secret text-slate-300"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-slate-800">{{ $session->nama ?? 'Tamu (Guest)' }}</h4>
                                    <p class="text-[10px] text-slate-400">{{ $session->email ?? 'Tidak login' }}</p>
                                    @if($session->peran == 'admin')
                                        <span class="inline-block mt-1 px-2 py-0.5 bg-indigo-100 text-indigo-600 rounded text-[9px] font-black uppercase tracking-wide">Admin</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2 text-xs font-bold text-slate-700">
                                    @if($session->platform == 'Windows') <i class="fa-brands fa-windows text-blue-500"></i>
                                    @elseif($session->platform == 'MacOS') <i class="fa-brands fa-apple text-slate-800"></i>
                                    @elseif($session->platform == 'Linux') <i class="fa-brands fa-linux text-orange-500"></i>
                                    @else <i class="fa-solid fa-mobile-screen text-slate-400"></i>
                                    @endif
                                    <span>{{ $session->platform }}</span>
                                    <span class="text-slate-300">•</span>
                                    <span>{{ $session->browser }}</span>
                                </div>
                                <span class="font-mono text-[10px] text-slate-400 mt-1 bg-slate-50 w-fit px-1.5 rounded">{{ $session->alamat_ip }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-600">{{ $session->aktivitas_terakhir->diffForHumans() }}</span>
                                <span class="text-[10px] text-slate-400">{{ $session->aktivitas_terakhir->format('d M Y, H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($session->id === session()->getId())
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-wide">Sesi Anda</span>
                            @else
                                <button wire:click="hapusSesi('{{ $session->id }}')" class="px-3 py-1.5 bg-white border border-slate-200 text-slate-500 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 rounded-lg text-[10px] font-bold uppercase tracking-wide transition-all shadow-sm">
                                    <i class="fa-solid fa-ban mr-1"></i> Kill
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center text-slate-400">
                            Tidak ada sesi aktif ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
