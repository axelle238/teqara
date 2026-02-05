<div class="space-y-10">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">TIKET <span class="text-pink-600">BANTUAN</span></h1>
            <p class="text-slate-500 font-medium">Resolusi kendala pelanggan dan manajemen antrian dukungan TI.</p>
        </div>
    </div>

    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex items-center gap-2 bg-slate-50/30">
            <button wire:click="$set('filterStatus', 'terbuka')" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $filterStatus === 'terbuka' ? 'bg-pink-500 text-white' : 'bg-white text-slate-500 hover:bg-slate-100' }}">TERBUKA</button>
            <button wire:click="$set('filterStatus', 'selesai')" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $filterStatus === 'selesai' ? 'bg-emerald-500 text-white' : 'bg-white text-slate-500 hover:bg-slate-100' }}">SELESAI</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tiket</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Subjek & Pesan</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelanggan</th>
                        <th class="px-8 py-5 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($tiket as $t)
                    <tr class="group hover:bg-slate-50/50 transition">
                        <td class="px-8 py-5">
                            <p class="text-sm font-black text-slate-900 tracking-tight">#{{ $t->nomor_tiket }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $t->created_at->diffForHumans() }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs font-black text-indigo-600 uppercase mb-1">{{ $t->subjek }}</p>
                            <p class="text-sm text-slate-600 leading-relaxed truncate max-w-md">{{ $t->pesan }}</p>
                        </td>
                        <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $t->pengguna->nama }}</td>
                        <td class="px-8 py-5 text-right">
                            @if($t->status === 'terbuka')
                            <button wire:click="tutupTiket({{ $t->id }})" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 transition">Selesaikan</button>
                            @else
                            <span class="text-[10px] font-black text-emerald-600 uppercase">Archive</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold">Tidak ada antrian tiket bantuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tiket instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="p-6 bg-slate-50/30">{{ $tiket->links() }}</div>
        @endif
    </div>
</div>
