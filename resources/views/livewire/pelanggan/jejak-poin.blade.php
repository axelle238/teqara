<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-10 flex flex-col md:flex-row items-end justify-between gap-6 animate-fade-in-down">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Jejak <span class="text-indigo-600">Poin</span></h1>
                <p class="text-slate-500 font-medium text-sm mt-2">Pantau perolehan reward dari setiap transaksi Anda.</p>
            </div>
            
            <!-- Summary Cards -->
            <div class="flex gap-4">
                <div class="bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm text-center">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Masuk</p>
                    <p class="text-lg font-black text-emerald-500">+{{ number_format($this->statistik['total_diperoleh']) }}</p>
                </div>
                <div class="bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm text-center">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Keluar</p>
                    <p class="text-lg font-black text-rose-500">-{{ number_format($this->statistik['total_ditukar']) }}</p>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8 items-start">
            
            <!-- Left Column: Status Card -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Main Card -->
                <div class="relative w-full aspect-square rounded-[2.5rem] overflow-hidden bg-gradient-to-br from-indigo-600 to-purple-700 shadow-2xl shadow-indigo-600/30 p-8 flex flex-col justify-between group animate-fade-in-up">
                    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-2">
                            <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-2xl">💎</div>
                            <span class="px-3 py-1 bg-white/20 backdrop-blur rounded-lg text-[10px] font-black text-white uppercase tracking-widest">Active</span>
                        </div>
                        <p class="text-indigo-200 text-xs font-bold uppercase tracking-widest">Saldo Saat Ini</p>
                        <h2 class="text-5xl font-black text-white tracking-tighter mt-1">{{ number_format(auth()->user()->poin_loyalitas ?? 0) }}</h2>
                    </div>

                    <div class="relative z-10">
                        <p class="text-xs text-indigo-100 font-medium leading-relaxed mb-4">
                            Tukarkan poin dengan voucher belanja eksklusif atau potongan harga langsung di halaman checkout.
                        </p>
                        <a href="{{ route('katalog') }}" class="inline-block w-full py-3 bg-white text-indigo-600 rounded-xl text-center text-xs font-black uppercase tracking-widest hover:bg-indigo-50 transition-colors shadow-lg">
                            Belanja Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column: History List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden min-h-[500px] animate-fade-in-up delay-100">
                    <!-- Toolbar -->
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Riwayat Aktivitas</h3>
                        <div class="flex bg-slate-50 p-1 rounded-xl">
                            <button wire:click="setFilter('semua')" class="px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $filter === 'semua' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">Semua</button>
                            <button wire:click="setFilter('masuk')" class="px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $filter === 'masuk' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">Masuk</button>
                            <button wire:click="setFilter('keluar')" class="px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $filter === 'keluar' ? 'bg-white text-rose-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">Keluar</button>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="divide-y divide-slate-50">
                        @forelse($this->riwayat as $log)
                        <div class="p-6 md:px-8 hover:bg-slate-50 transition-colors flex items-center justify-between gap-4 group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shadow-sm {{ $log->jumlah > 0 ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500' }}">
                                    {{ $log->jumlah > 0 ? '↗' : '↙' }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm mb-1">{{ $log->keterangan }}</h4>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $log->dibuat_pada->format('d M Y • H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="block text-lg font-black {{ $log->jumlah > 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                                    {{ $log->jumlah > 0 ? '+' : '' }}{{ number_format($log->jumlah) }}
                                </span>
                                @if($log->referensi_id)
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider font-mono">REF: {{ $log->referensi_id }}</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="py-24 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl opacity-50">🕸️</div>
                            <p class="text-sm font-bold text-slate-400">Belum ada riwayat poin.</p>
                        </div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    @if($this->riwayat->hasPages())
                    <div class="p-6 border-t border-slate-50">
                        {{ $this->riwayat->links() }}
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
