<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-16 animate-fade-in-down">
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase mb-2">Program <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Referral</span></h1>
            <p class="text-slate-500 font-bold text-sm uppercase tracking-widest">Bagikan Kebaikan, Dapatkan Keuntungan</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Left Column: Main Card & Stats (4 cols) -->
            <div class="lg:col-span-4 space-y-8 animate-fade-in-left">
                <!-- Hero Code Card -->
                <div class="relative overflow-hidden bg-slate-900 rounded-[3rem] p-10 text-white shadow-2xl shadow-slate-900/30 text-center group">
                    <!-- Dynamic BG -->
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-700 to-slate-900 opacity-90 group-hover:scale-110 transition-transform duration-1000"></div>
                    <div class="absolute top-[-50%] left-[-50%] w-full h-full bg-white/10 blur-[100px] rounded-full animate-pulse-slow"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6 shadow-inner border border-white/20">🎁</div>
                        <p class="text-indigo-200 text-[10px] font-black uppercase tracking-[0.2em] mb-4">Kode Referral Anda</p>
                        
                        <div class="bg-black/20 backdrop-blur-xl border border-white/10 rounded-2xl p-6 mb-6 relative group/code cursor-pointer" wire:click="salinLink">
                            <span class="text-3xl font-black tracking-widest font-mono text-white group-hover/code:text-indigo-300 transition-colors">{{ $this->kodeReferral }}</span>
                            <div class="absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 group-hover/code:opacity-100 transition-opacity rounded-2xl backdrop-blur-sm">
                                <span class="text-xs font-bold uppercase tracking-widest">Klik Salin</span>
                            </div>
                        </div>

                        <button wire:click="salinLink" class="w-full py-4 bg-white text-indigo-900 rounded-xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-50 transition-all shadow-lg hover:shadow-white/20 active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            Salin Link
                        </button>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/50">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">Performa Bulan Ini</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center p-4 bg-slate-50 rounded-2xl">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Undangan</p>
                            <h4 class="text-2xl font-black text-slate-900">{{ $this->statistik['total_undangan'] }}</h4>
                        </div>
                        <div class="text-center p-4 bg-emerald-50 rounded-2xl">
                            <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest mb-1">Sukses</p>
                            <h4 class="text-2xl font-black text-emerald-600">{{ $this->statistik['undangan_sukses'] }}</h4>
                        </div>
                    </div>
                    <div class="mt-6 pt-6 border-t border-slate-50">
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Komisi</p>
                                <p class="text-[9px] text-slate-400 mt-1">Siap dicairkan</p>
                            </div>
                            <h3 class="text-2xl font-black text-indigo-600">Rp {{ number_format($this->statistik['total_komisi']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Content & History (8 cols) -->
            <div class="lg:col-span-8 space-y-8 animate-fade-in-right">
                
                <!-- How It Works (Visual Steps) -->
                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden">
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-8 relative z-10">Langkah Mudah</h3>
                    
                    <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="relative">
                            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl mb-4 shadow-sm font-black">1</div>
                            <h4 class="font-bold text-slate-900 mb-2">Sebar Kode</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Bagikan kode unik Anda ke teman, keluarga, atau media sosial.</p>
                        </div>
                        <div class="relative">
                            <!-- Arrow Connector (Desktop) -->
                            <div class="hidden md:block absolute top-8 -left-1/2 w-full h-0.5 border-t-2 border-dashed border-slate-100 -z-10"></div>
                            
                            <div class="w-16 h-16 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mb-4 shadow-sm font-black">2</div>
                            <h4 class="font-bold text-slate-900 mb-2">Teman Belanja</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Teman mendaftar & belanja pertama kali menggunakan kodemu.</p>
                        </div>
                        <div class="relative">
                            <!-- Arrow Connector -->
                            <div class="hidden md:block absolute top-8 -left-1/2 w-full h-0.5 border-t-2 border-dashed border-slate-100 -z-10"></div>

                            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-4 shadow-sm font-black">3</div>
                            <h4 class="font-bold text-slate-900 mb-2">Cuan Datang</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Otomatis dapat komisi saldo atau poin loyalitas ke akunmu.</p>
                        </div>
                    </div>
                </div>

                <!-- History Table -->
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Jejak Undangan</h3>
                        <div class="flex gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Live Update</span>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-slate-50">
                        @forelse($this->riwayatUndangan as $item)
                        <div class="p-6 flex flex-col sm:flex-row items-center justify-between gap-4 hover:bg-slate-50 transition-colors group">
                            <div class="flex items-center gap-4 w-full sm:w-auto">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center font-black text-slate-500 shadow-inner">
                                    {{ substr($item['nama'], 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm mb-0.5">{{ $item['nama'] }}</h4>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">{{ $item['tanggal']->format('d F Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-6 w-full sm:w-auto justify-between sm:justify-end">
                                <div class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $item['status'] == 'Aktif' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                    {{ $item['status'] }}
                                </div>
                                <div class="text-right min-w-[80px]">
                                    @if($item['komisi'] > 0)
                                        <span class="block text-sm font-black text-indigo-600">+{{ number_format($item['komisi']/1000) }}K</span>
                                    @else
                                        <span class="block text-sm font-black text-slate-300">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="py-16 text-center">
                            <p class="text-sm font-bold text-slate-400">Belum ada teman yang bergabung.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
