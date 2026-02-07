<div x-data="{ open: false }" class="relative">
    <!-- Bell Icon -->
    <button @click="open = !open" class="relative p-2.5 rounded-xl bg-slate-50 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition-all active:scale-95 group border border-slate-100 shadow-sm">
        <i class="fa-solid fa-bell text-lg"></i>
        @if($this->unreadCount > 0)
        <span class="absolute -top-1 -right-1 flex h-5 w-5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-5 w-5 bg-rose-600 border-2 border-white text-[9px] font-black text-white items-center justify-center">
                {{ $this->unreadCount > 9 ? '9+' : $this->unreadCount }}
            </span>
        </span>
        @endif
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="absolute right-0 mt-4 w-96 bg-white rounded-[2rem] shadow-2xl border border-slate-100 z-50 overflow-hidden ring-4 ring-slate-900/5">
        
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Pusat Notifikasi</h3>
            <button wire:click="markAllAsRead" class="text-[9px] font-black text-indigo-600 hover:text-indigo-700 uppercase tracking-widest">Baca Semua</button>
        </div>

        <div class="max-h-[400px] overflow-y-auto custom-scrollbar">
            @forelse($this->notifikasi as $n)
            <div wire:click="markAsRead({{ $n->id }})" class="p-5 hover:bg-slate-50 transition-all cursor-pointer border-b border-slate-50 last:border-0 group">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-sm 
                        {{ $n->tipe === 'bahaya' ? 'bg-rose-100 text-rose-600' : 
                          ($n->tipe === 'peringatan' ? 'bg-amber-100 text-amber-600' : 
                          ($n->tipe === 'sukses' ? 'bg-emerald-100 text-emerald-600' : 'bg-indigo-100 text-indigo-600')) }}">
                        <i class="fa-solid 
                            {{ $n->tipe === 'bahaya' ? 'fa-triangle-exclamation' : 
                              ($n->tipe === 'peringatan' ? 'fa-circle-exclamation' : 
                              ($n->tipe === 'sukses' ? 'fa-circle-check' : 'fa-info-circle')) }} text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-0.5">
                            <h4 class="text-xs font-black text-slate-900 uppercase tracking-tight line-clamp-1">{{ $n->judul }}</h4>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $n->dibuat_pada->diffForHumans() }}</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-tight line-clamp-2">{{ $n->pesan }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="py-16 text-center">
                <div class="text-4xl mb-3 grayscale opacity-30">📭</div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tidak ada pesan baru</p>
            </div>
            @endforelse
        </div>

        <a href="{{ route('pengelola.notifikasi.index') }}" class="block p-4 bg-slate-900 text-white text-center text-[10px] font-black uppercase tracking-[0.2em] hover:bg-indigo-600 transition-colors">
            Lihat Semua Inbox
        </a>
    </div>
</div>