<div class="space-y-12 pb-32" wire:poll.10s>
    <!-- Header Inbox -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">INBOX <span class="text-indigo-600">SISTEM</span></h1>
            <p class="text-slate-500 font-medium text-lg">Pusat peringatan dini dan notifikasi operasional.</p>
        </div>
        <div class="flex gap-2 bg-slate-100 p-1.5 rounded-2xl">
            <button wire:click="$set('filterTipe', 'semua')" class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterTipe === 'semua' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">Semua Pesan</button>
            <button wire:click="$set('filterTipe', 'penting')" class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterTipe === 'penting' ? 'bg-rose-600 text-white shadow-lg shadow-rose-500/30' : 'text-slate-500 hover:text-rose-600' }}">Alert Penting</button>
        </div>
    </div>

    <!-- Daftar Notifikasi -->
    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-10 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Aktivitas Terkini</h3>
            <button wire:click="hapusSemua" class="text-[10px] font-bold text-slate-400 hover:text-rose-500 uppercase tracking-widest transition-colors">Bersihkan Inbox</button>
        </div>
        
        <div class="divide-y divide-slate-50">
            @forelse($notifikasi as $n)
            <div class="p-8 hover:bg-indigo-50/10 transition-colors group flex gap-6 items-start {{ $n->dibaca_pada ? 'opacity-60' : 'bg-indigo-50/5' }}">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 shadow-sm 
                    {{ $n->tipe === 'bahaya' ? 'bg-rose-100 text-rose-600' : 
                      ($n->tipe === 'peringatan' ? 'bg-amber-100 text-amber-600' : 
                      ($n->tipe === 'sukses' ? 'bg-emerald-100 text-emerald-600' : 'bg-indigo-100 text-indigo-600')) }}">
                    <i class="fa-solid 
                        {{ $n->tipe === 'bahaya' ? 'fa-triangle-exclamation animate-pulse' : 
                          ($n->tipe === 'peringatan' ? 'fa-circle-exclamation' : 
                          ($n->tipe === 'sukses' ? 'fa-circle-check' : 'fa-info-circle')) }} text-xl"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <div class="flex items-center gap-3">
                            <h4 class="text-sm font-black text-slate-900 uppercase tracking-tight">{{ $n->judul }}</h4>
                            @if(!$n->dibaca_pada)
                            <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                            @endif
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $n->dibuat_pada->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $n->pesan }}</p>
                    @if($n->tautan)
                    <a href="{{ $n->tautan }}" wire:navigate class="inline-flex items-center gap-2 mt-3 text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-700 transition-colors">
                        Lihat Detail <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                    @endif
                </div>
                @if(!$n->dibaca_pada)
                <button wire:click="markAsRead({{ $n->id }})" class="opacity-0 group-hover:opacity-100 p-2 text-slate-300 hover:text-indigo-600 transition-all" title="Tandai sudah dibaca">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
                @endif
            </div>
            @empty
            <div class="py-32 text-center">
                <div class="text-6xl mb-4 grayscale opacity-30">📭</div>
                <p class="text-slate-400 font-bold uppercase text-xs tracking-widest">Tidak ada notifikasi baru.</p>
            </div>
            @endforelse
        </div>
        
        <div class="p-8 border-t border-slate-50 bg-slate-50/30">
            {{ $notifikasi->links() }}
        </div>
    </div>
</div>
