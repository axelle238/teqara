<div class="space-y-12 pb-32">
    <!-- Header: Vibrant & Professional -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pink-50 border border-pink-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-pink-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-pink-600 uppercase tracking-widest">Antrian Bantuan Teknis</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">TIKET <span class="text-pink-600">BANTUAN</span></h1>
            <p class="text-slate-500 font-medium text-lg">Kelola manifest keluhan dan permintaan asistensi pelanggan.</p>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="$set('filterStatus', 'terbuka')" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterStatus === 'terbuka' ? 'bg-pink-600 text-white shadow-lg' : 'bg-slate-50 text-slate-400 hover:bg-slate-100' }}">Terbuka</button>
            <button wire:click="$set('filterStatus', 'selesai')" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterStatus === 'selesai' ? 'bg-emerald-600 text-white shadow-lg' : 'bg-slate-50 text-slate-400 hover:bg-slate-100' }}">Selesai</button>
        </div>
    </div>

    <!-- Tiket Table: No Dark Policy -->
    <div class="bg-white rounded-[56px] border border-indigo-50 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-indigo-50">
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Manifest ID</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Pelanggan</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Subjek & Keluhan</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Otoritas</th>
                        <th class="px-10 py-6 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-50">
                    @forelse($tiket as $t)
                    <tr class="group hover:bg-indigo-50/20 transition-all duration-300">
                        <td class="px-10 py-6">
                            <p class="text-sm font-black text-slate-900 tracking-tight uppercase">#{{ $t->nomor_tiket }}</p>
                            <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase">{{ $t->created_at->format('d/m/Y H:i') }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-[14px] bg-white border border-indigo-50 flex items-center justify-center font-black text-indigo-600 shadow-sm group-hover:scale-110 transition-transform">
                                    {{ substr($t->pengguna->nama, 0, 1) }}
                                </div>
                                <span class="text-xs font-black text-slate-700 uppercase">{{ $t->pengguna->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-sm font-black text-slate-900 tracking-tight uppercase group-hover:text-indigo-600 transition-colors">{{ $t->subjek }}</p>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed truncate max-w-xs mt-1">{{ $t->pesan }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $t->status === 'terbuka' ? 'bg-amber-50 text-amber-600 border border-amber-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                                {{ $t->status }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            @if($t->status === 'terbuka')
                            <button wire:click="tutupTiket({{ $t->id }})" class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-[9px] font-black uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-slate-900/10 active:scale-95">
                                SELESAIKAN
                            </button>
                            @else
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">ARSIP TERKUNCI</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-32 text-center">
                            <div class="text-6xl mb-6">📩</div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tighter uppercase mb-2">Manifest Bersih</h3>
                            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Tidak ada tiket bantuan yang memerlukan atensi radar saat ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-10 bg-slate-50/30 border-t border-slate-50 flex justify-center">
            {{ $tiket->links() }}
        </div>
    </div>
</div>
