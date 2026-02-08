<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-10 animate-fade-in-down">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Pusat <span class="text-indigo-600">Informasi</span></h1>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-2">Pembaruan Real-time Aktivitas Anda</p>
            </div>
            @if($notifikasi->whereNull('dibaca_pada')->count() > 0)
            <button wire:click="tandaiSemuaDibaca" class="group flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm">
                <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Tandai Semua Dibaca
            </button>
            @endif
        </div>

        <!-- Filter Tabs -->
        <div class="flex gap-4 mb-10 overflow-x-auto pb-2 scrollbar-hide animate-fade-in-left">
            @php
                $filters = [
                    'semua' => 'Semua',
                    'transaksi' => 'Transaksi',
                    'promo' => 'Promo',
                    'info' => 'Info Sistem'
                ];
            @endphp
            @foreach($filters as $key => $label)
            <button wire:click="$set('filter', '{{ $key }}')" class="relative px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap overflow-hidden group {{ $filter === $key ? 'bg-slate-900 text-white shadow-xl shadow-slate-900/20' : 'bg-white text-slate-400 hover:text-slate-600 hover:bg-slate-50' }}">
                <span class="relative z-10">{{ $label }}</span>
                @if($filter === $key)
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                @endif
            </button>
            @endforeach
        </div>

        <!-- Notification List -->
        <div class="space-y-6">
            @forelse($notifikasi as $notif)
            <div wire:key="notif-{{ $notif->id }}" 
                 @if(!$notif->dibaca_pada) wire:click="tandaiDibaca({{ $notif->id }})" @endif
                 class="group relative bg-white rounded-[2rem] p-6 border transition-all duration-300 hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-1 animate-fade-in-up cursor-pointer {{ $notif->dibaca_pada ? 'border-slate-100 opacity-70' : 'border-indigo-100 ring-4 ring-indigo-500/5 z-10' }}">
                
                @if(!$notif->dibaca_pada)
                    <div class="absolute top-6 right-6 flex items-center gap-2">
                         <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                        </span>
                        <span class="text-[9px] font-black text-rose-500 uppercase tracking-widest">Baru</span>
                    </div>
                @endif
                
                <div class="flex items-start gap-6">
                    <!-- Dynamic Icon Box -->
                    @php
                        $config = match($notif->tipe) {
                            'transaksi' => ['icon' => '📦', 'color' => 'bg-blue-50 text-blue-500 group-hover:bg-blue-100'],
                            'promo' => ['icon' => '⚡', 'color' => 'bg-amber-50 text-amber-500 group-hover:bg-amber-100'],
                            'info' => ['icon' => '📢', 'color' => 'bg-indigo-50 text-indigo-500 group-hover:bg-indigo-100'],
                            default => ['icon' => '🔔', 'color' => 'bg-slate-50 text-slate-500 group-hover:bg-slate-100'],
                        };
                    @endphp
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl shadow-sm shrink-0 transition-transform group-hover:scale-110 {{ $config['color'] }}">
                        {{ $config['icon'] }}
                    </div>

                    <div class="flex-1 min-w-0 pt-1">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2 gap-2">
                            <h3 class="font-black text-slate-900 text-sm tracking-wide group-hover:text-indigo-600 transition-colors">{{ $notif->judul }}</h3>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest shrink-0 bg-slate-50 px-2 py-1 rounded-lg">
                                {{ $notif->dibuat_pada->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed max-w-2xl">{{ $notif->pesan }}</p>
                        
                        @if($notif->tautan)
                            <a href="{{ $notif->tautan }}" class="inline-block mt-4 text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline">
                                Lihat Detail <i class="fa-solid fa-arrow-right ml-1"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-32 bg-white rounded-[3rem] border border-dashed border-slate-200 animate-fade-in-up">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6 text-4xl opacity-50 shadow-inner">📭</div>
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Hening...</h3>
                <p class="text-slate-400 text-sm font-medium">Tidak ada notifikasi baru untuk saat ini.</p>
            </div>
            @endforelse

            <div class="mt-10">
                {{ $notifikasi->links() }}
            </div>
        </div>

    </div>
</div>