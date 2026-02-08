<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-[30px] p-6 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 text-xl">
                <i class="fa-solid fa-ticket"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Tiket</p>
                <h3 class="text-2xl font-black text-slate-900">{{ $stats['total'] }}</h3>
            </div>
        </div>
        <div class="bg-white rounded-[30px] p-6 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 text-xl">
                <i class="fa-regular fa-clock"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Perlu Respon</p>
                <h3 class="text-2xl font-black text-slate-900">{{ $stats['terbuka'] }}</h3>
            </div>
        </div>
        <div class="bg-white rounded-[30px] p-6 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 text-xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Prioritas Tinggi</p>
                <h3 class="text-2xl font-black text-slate-900">{{ $stats['tinggi'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white p-6 rounded-[30px] border border-slate-100 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-96">
            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input wire:model.live.debounce.300ms="cari" type="text" class="w-full pl-11 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-500" placeholder="Cari ID, Subjek, atau Nama User...">
        </div>
        
        <div class="flex gap-2 w-full md:w-auto">
            <select wire:model.live="filterStatus" class="bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-slate-600 focus:ring-2 focus:ring-indigo-500 cursor-pointer flex-1 md:flex-none">
                <option value="">Semua Status</option>
                <option value="terbuka">Terbuka</option>
                <option value="diproses">Diproses</option>
                <option value="selesai">Selesai</option>
            </select>
            <select wire:model.live="filterPrioritas" class="bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-slate-600 focus:ring-2 focus:ring-indigo-500 cursor-pointer flex-1 md:flex-none">
                <option value="">Semua Prioritas</option>
                <option value="rendah">Rendah</option>
                <option value="sedang">Sedang</option>
                <option value="tinggi">Tinggi</option>
            </select>
        </div>
    </div>

    <!-- Ticket List -->
    <div class="space-y-4">
        @forelse($tiket as $t)
        <div class="group bg-white rounded-[30px] p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-100 transition-all duration-300">
            <div class="flex flex-col md:flex-row gap-6 justify-between items-start md:items-center">
                
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center font-black text-slate-500 shrink-0">
                        {{ substr($t->pengguna->nama ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-mono font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">#{{ $t->id }}</span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $t->dibuat_pada->diffForHumans() }}</span>
                        </div>
                        <h4 class="text-lg font-black text-slate-900 group-hover:text-indigo-600 transition-colors mb-1">{{ $t->subjek }}</h4>
                        <p class="text-xs text-slate-500 font-medium">Oleh: {{ $t->pengguna->nama ?? 'Pengguna Terhapus' }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-end">
                    <div class="flex gap-2">
                        @php
                            $prioColor = match($t->prioritas) {
                                'tinggi' => 'bg-rose-100 text-rose-600',
                                'sedang' => 'bg-amber-100 text-amber-600',
                                default => 'bg-slate-100 text-slate-600'
                            };
                            $statusColor = match($t->status) {
                                'selesai' => 'bg-emerald-100 text-emerald-600',
                                'diproses' => 'bg-blue-100 text-blue-600',
                                default => 'bg-slate-100 text-slate-600'
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $prioColor }}">{{ $t->prioritas }}</span>
                        <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $statusColor }}">{{ $t->status }}</span>
                    </div>
                    
                    <a href="{{ route('pengelola.cs.tiket.detail', $t->id) }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-200 hover:shadow-md transition-all">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>

            </div>
        </div>
        @empty
        <div class="py-20 text-center bg-white rounded-[40px] border border-dashed border-slate-200">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl text-slate-300">
                <i class="fa-solid fa-inbox"></i>
            </div>
            <h3 class="text-xl font-black text-slate-900 uppercase">Tidak Ada Tiket</h3>
            <p class="text-slate-400 font-medium text-sm mt-2">Semua permintaan bantuan telah terselesaikan.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $tiket->links() }}
    </div>
</div>