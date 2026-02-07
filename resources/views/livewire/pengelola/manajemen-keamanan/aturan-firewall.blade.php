<div class="space-y-8 animate-fade-in pb-20">
    <!-- Header & Statistik -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-slate-900 rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>
            <div class="relative z-10 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-black uppercase tracking-tight text-white">Firewall <span class="text-red-500">WAF</span></h1>
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-[0.2em] mt-2">Web Application Firewall Manager</p>
                </div>
                <div class="w-16 h-16 bg-red-600/20 rounded-2xl flex items-center justify-center text-3xl border border-red-500/20 text-red-500 shadow-lg">
                    <i class="fa-solid fa-fire"></i>
                </div>
            </div>
            <div class="mt-8 flex gap-8">
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Total Blokir</p>
                    <p class="text-2xl font-black text-white">{{ $aturan->total() }} IP</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Status WAF</p>
                    <p class="text-2xl font-black text-emerald-400 flex items-center gap-2">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        AKTIF
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Blokir Cepat -->
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6 text-red-600">Blokir IP Manual</h3>
            <div class="space-y-4">
                <div>
                    <input type="text" wire:model="ipBaru" class="w-full bg-slate-50 border-none rounded-xl p-4 text-xs font-mono font-bold tracking-widest focus:ring-2 focus:ring-red-500" placeholder="IP Address (e.g. 192.168.1.1)">
                    @error('ipBaru') <span class="text-[9px] text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
                <div>
                    <input type="text" wire:model="alasanBaru" class="w-full bg-slate-50 border-none rounded-xl p-4 text-xs font-bold uppercase tracking-wide focus:ring-2 focus:ring-red-500" placeholder="Alasan Blokir">
                    @error('alasanBaru') <span class="text-[9px] text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
                <button wire:click="blokirManual" class="w-full py-4 bg-red-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-lg shadow-red-200">
                    <i class="fa-solid fa-ban mr-2"></i> Eksekusi Blokir
                </button>
            </div>
        </div>
    </div>

    <!-- Daftar IP Diblokir -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Daftar Hitam Aktif</h3>
            <div class="flex gap-2">
                <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
                <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-8 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest">Target IP</th>
                        <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest">Tipe</th>
                        <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest">Alasan</th>
                        <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest">Waktu</th>
                        <th class="px-8 py-4 text-right text-[9px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($aturan as $a)
                    <tr class="hover:bg-red-50/30 transition-colors group">
                        <td class="px-8 py-4">
                            <span class="font-mono text-xs font-black text-slate-700 bg-slate-100 px-2 py-1 rounded">{{ $a->target }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[9px] font-black uppercase tracking-widest px-2 py-1 rounded bg-slate-100 text-slate-500">{{ $a->tipe }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-red-600 uppercase">{{ $a->catatan }}</td>
                        <td class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase">{{ $a->dibuat_pada->diffForHumans() }}</td>
                        <td class="px-8 py-4 text-right">
                            <button wire:click="hapusAturan({{ $a->id }})" class="text-slate-300 hover:text-red-500 transition-colors"><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                                <i class="fa-solid fa-shield-check"></i>
                            </div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tidak ada ancaman terblokir saat ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-50">
            {{ $aturan->links() }}
        </div>
    </div>
</div>