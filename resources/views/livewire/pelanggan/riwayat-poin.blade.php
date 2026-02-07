<div class="bg-slate-50 min-h-screen py-10 font-sans antialiased text-slate-900">
    <!-- Background Decor -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-amber-500/5 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-500/5 blur-[150px] rounded-full"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Jejak <span class="text-amber-500">Loyalitas</span></h1>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-2">Pantau pertumbuhan aset loyalitas & reward Anda</p>
            </div>
            
            <div class="flex gap-4">
                <a href="{{ route('pelanggan.tukar-poin') }}" class="px-8 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-amber-500 hover:shadow-lg hover:shadow-amber-500/30 transition-all">
                    Tukar Poin
                </a>
            </div>
        </div>

        <!-- Main Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Active Points Card -->
            <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-amber-500/20 relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6 opacity-90">
                        <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-black uppercase tracking-widest">Saldo Poin Aktif</span>
                    </div>
                    
                    <h2 class="text-5xl font-black tracking-tighter mb-2">{{ number_format(auth()->user()->poin_loyalitas) }}</h2>
                    <p class="text-amber-100 text-xs font-medium">Setara ± Rp {{ number_format(auth()->user()->poin_loyalitas * 50, 0, ',', '.') }} (Nilai Estimasi)</p>
                </div>
            </div>

            <!-- Stats Detail -->
            <div class="md:col-span-2 grid grid-cols-2 gap-6">
                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/50">
                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-2xl mb-4 text-emerald-500">📥</div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Diperoleh</p>
                    <h3 class="text-2xl font-black text-slate-900">+{{ number_format($this->statistik['total_diperoleh']) }}</h3>
                </div>
                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/50">
                    <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-2xl mb-4 text-rose-500">📤</div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Ditukar</p>
                    <h3 class="text-2xl font-black text-slate-900">-{{ number_format($this->statistik['total_ditukar']) }}</h3>
                </div>
            </div>
        </div>

        <!-- History Section -->
        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-xl overflow-hidden">
            <!-- Filter Bar -->
            <div class="p-8 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-6">
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Riwayat Transaksi</h3>
                
                <div class="flex p-1 bg-slate-100 rounded-xl">
                    <button wire:click="setFilter('semua')" class="px-6 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $filter === 'semua' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                        Semua
                    </button>
                    <button wire:click="setFilter('masuk')" class="px-6 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $filter === 'masuk' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                        Masuk
                    </button>
                    <button wire:click="setFilter('keluar')" class="px-6 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $filter === 'keluar' ? 'bg-white text-rose-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                        Keluar
                    </button>
                </div>
            </div>
            
            <!-- List -->
            <div class="divide-y divide-slate-50">
                @forelse($this->riwayat as $log)
                <div class="p-6 md:px-10 hover:bg-slate-50/80 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-6 group animate-fade-in">
                    <div class="flex items-center gap-6">
                        <div class="relative">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl transition-transform group-hover:scale-110 shadow-sm {{ $log->jumlah > 0 ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500' }}">
                                {{ $log->jumlah > 0 ? '🎁' : '🏷️' }}
                            </div>
                            <!-- Connector Line (Visual only) -->
                            <div class="absolute top-14 left-7 w-px h-10 bg-slate-100 md:hidden"></div>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm mb-1">{{ $log->keterangan }}</h4>
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-100 px-2 py-0.5 rounded-md">
                                    {{ $log->dibuat_pada->format('d M Y') }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">
                                    {{ $log->dibuat_pada->format('H:i') }} WIB
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between md:justify-end gap-8 pl-20 md:pl-0">
                        @if($log->referensi_id)
                        <div class="text-right hidden sm:block">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Referensi</span>
                            <span class="text-xs font-bold text-indigo-500 font-mono">#{{ $log->referensi_id }}</span>
                        </div>
                        @endif

                        <div class="text-right min-w-[100px]">
                            <span class="text-lg font-black {{ $log->jumlah > 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                                {{ $log->jumlah > 0 ? '+' : '' }}{{ number_format($log->jumlah) }}
                            </span>
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Poin</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-24 text-center">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl opacity-50 animate-bounce">✨</div>
                    <h3 class="text-slate-900 font-black text-lg mb-2">Belum Ada Aktivitas</h3>
                    <p class="text-sm font-bold text-slate-400 max-w-xs mx-auto">Riwayat perolehan dan penukaran poin Anda akan muncul di sini.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($this->riwayat->hasPages())
            <div class="p-8 border-t border-slate-50 bg-slate-50/30">
                {{ $this->riwayat->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
