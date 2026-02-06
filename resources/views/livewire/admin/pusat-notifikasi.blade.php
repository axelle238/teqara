<div class="space-y-12 pb-32">
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
            <div class="p-8 hover:bg-indigo-50/10 transition-colors group flex gap-6 items-start">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 shadow-sm {{ in_array($n->aksi, ['stok_kritis', 'system_lock']) ? 'bg-rose-100 text-rose-600' : 'bg-indigo-50 text-indigo-600' }}">
                    @if(in_array($n->aksi, ['stok_kritis', 'system_lock']))
                        <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    @endif
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-tight">{{ str_replace('_', ' ', $n->aksi) }}</h4>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $n->waktu->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $n->pesan_naratif }}</p>
                    <p class="text-[10px] text-slate-400 mt-2 font-mono">Target: {{ $n->target }}</p>
                </div>
                <button wire:click="markAsRead({{ $n->id }})" class="opacity-0 group-hover:opacity-100 p-2 text-slate-300 hover:text-indigo-600 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
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
