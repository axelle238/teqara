<div class="bg-slate-50 min-h-screen py-10 font-sans antialiased text-slate-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-10 flex flex-col sm:flex-row justify-between items-end gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Dompet <span class="text-indigo-600">Digital</span></h1>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-2">Kelola saldo & transaksi finansial Anda</p>
            </div>
            <div class="flex gap-3">
                <button wire:click="topUp" class="px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 hover:shadow-lg hover:shadow-indigo-500/30 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Top Up Saldo
                </button>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8 items-start">
            
            <!-- Left Column: Virtual Card & Quick Stats -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Virtual Card -->
                <div class="relative w-full aspect-[1.586/1] rounded-[2rem] overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900 shadow-2xl shadow-indigo-900/40 p-8 flex flex-col justify-between group transform hover:scale-[1.02] transition-transform duration-500">
                    <!-- Decor -->
                    <div class="absolute inset-0 opacity-30 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500 rounded-full blur-[80px] opacity-40 group-hover:opacity-60 transition-opacity"></div>
                    <div class="absolute bottom-[-20%] left-[-20%] w-40 h-40 bg-cyan-500 rounded-full blur-[60px] opacity-30"></div>

                    <!-- Top Row -->
                    <div class="relative z-10 flex justify-between items-start">
                        <div class="text-white/80 font-black italic tracking-tighter text-lg">TEQARA<span class="text-cyan-400">PAY</span></div>
                        <div class="w-10 h-6 rounded bg-white/20 backdrop-blur-md border border-white/10 flex items-center justify-center">
                            <div class="w-6 h-4 border border-white/50 rounded-sm flex items-center justify-center">
                                <div class="w-4 h-2 bg-amber-400/80 rounded-[1px]"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Middle (Chip) -->
                    <div class="relative z-10">
                         <img src="https://img.icons8.com/color/48/000000/sim-card-chip.png" class="w-12 opacity-80" alt="Chip"/>
                    </div>

                    <!-- Bottom Row (Balance & Info) -->
                    <div class="relative z-10">
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-[10px] text-white/60 font-black uppercase tracking-widest mb-1">Total Saldo Aktif</p>
                                <div class="flex items-center gap-3">
                                    <h2 class="text-2xl font-black text-white tracking-tight">
                                        @if($showBalance)
                                            Rp {{ number_format($this->saldo, 0, ',', '.') }}
                                        @else
                                            Rp ••••••••
                                        @endif
                                    </h2>
                                    <button wire:click="toggleBalance" class="text-white/50 hover:text-white transition-colors">
                                        @if($showBalance)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features -->
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Fitur Cepat</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="p-4 bg-slate-50 rounded-2xl hover:bg-indigo-50 hover:text-indigo-600 transition-colors group text-left">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">🔒</div>
                            <span class="text-[10px] font-black uppercase tracking-widest block">Ganti PIN</span>
                        </button>
                        <button class="p-4 bg-slate-50 rounded-2xl hover:bg-indigo-50 hover:text-indigo-600 transition-colors group text-left">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">💳</div>
                            <span class="text-[10px] font-black uppercase tracking-widest block">Rekening</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Column: Transactions -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-xl overflow-hidden min-h-[500px]">
                    <!-- Toolbar -->
                    <div class="p-8 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-6">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Riwayat Transaksi</h3>
                        <div class="flex p-1 bg-slate-100 rounded-xl">
                            <button wire:click="setFilter('semua')" class="px-6 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $filter === 'semua' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">Semua</button>
                            <button wire:click="setFilter('masuk')" class="px-6 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $filter === 'masuk' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">Uang Masuk</button>
                            <button wire:click="setFilter('keluar')" class="px-6 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $filter === 'keluar' ? 'bg-white text-rose-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">Uang Keluar</button>
                        </div>
                    </div>

                    <!-- List -->
                    <div class="divide-y divide-slate-50">
                        @forelse($transaksi as $log)
                        <div class="p-6 md:px-10 hover:bg-slate-50 transition-colors flex flex-col sm:flex-row items-center justify-between gap-6 group">
                            <div class="flex items-center gap-6 w-full sm:w-auto">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shadow-sm flex-shrink-0 {{ $log['tipe'] == 'masuk' ? 'bg-emerald-50 text-emerald-500' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $log['tipe'] == 'masuk' ? '📥' : '💸' }}
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="font-bold text-slate-900 text-sm truncate">{{ $log['keterangan'] }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $log['tanggal']->format('d M Y • H:i') }}</span>
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-widest {{ $log['status'] == 'berhasil' ? 'text-emerald-500' : 'text-amber-500' }}">{{ $log['status'] }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-right w-full sm:w-auto flex justify-between sm:block">
                                <span class="text-lg font-black block {{ $log['tipe'] == 'masuk' ? 'text-emerald-500' : 'text-slate-900' }}">
                                    {{ $log['tipe'] == 'masuk' ? '+' : '-' }} Rp {{ number_format($log['jumlah'], 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest font-mono">ID: {{ $log['id'] }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="py-24 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl opacity-50">📉</div>
                            <p class="text-sm font-bold text-slate-400">Tidak ada transaksi ditemukan.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
