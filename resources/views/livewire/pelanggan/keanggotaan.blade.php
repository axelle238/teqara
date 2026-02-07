<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <!-- Background Decor -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-indigo-500/5 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-500/5 blur-[150px] rounded-full"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header -->
        <div class="text-center mb-16 animate-fade-in-down">
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase mb-2">Status <span class="text-indigo-600">Keanggotaan</span></h1>
            <p class="text-slate-500 font-bold text-sm uppercase tracking-widest">Eksklusivitas Tanpa Batas untuk Pelanggan Setia</p>
        </div>

        <!-- Current Status Card (Main Hero) -->
        <div class="relative w-full rounded-[3rem] overflow-hidden bg-gradient-to-br from-slate-900 via-[#1a1c2e] to-slate-900 shadow-2xl shadow-indigo-900/40 mb-20 group animate-fade-in-up">
            <!-- Animated Background -->
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/20 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2 group-hover:bg-indigo-500/30 transition-all duration-1000"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-600/10 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2"></div>
            
            <div class="relative z-10 p-10 md:p-16 flex flex-col md:flex-row items-center justify-between gap-12">
                <!-- Left: Tier Info -->
                <div class="text-center md:text-left flex-1">
                    <div class="inline-block px-4 py-1.5 rounded-full bg-indigo-500/20 border border-indigo-400/30 backdrop-blur-md text-indigo-300 text-[10px] font-black uppercase tracking-[0.2em] mb-6">
                        Status Saat Ini
                    </div>
                    <h2 class="text-6xl md:text-8xl font-black italic tracking-tighter text-transparent bg-clip-text bg-gradient-to-b from-white to-slate-400 mb-6 drop-shadow-2xl">
                        {{ $currentLevel }}
                    </h2>
                    <div class="flex flex-col md:flex-row items-center gap-4">
                        <div class="flex items-center gap-3 bg-white/5 px-6 py-3 rounded-2xl border border-white/10 backdrop-blur-md">
                            <span class="text-2xl animate-pulse">💎</span>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Poin Aktif</p>
                                <p class="text-xl font-black text-white">{{ number_format($user->poin_loyalitas) }}</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 max-w-xs leading-relaxed">
                            Terima kasih telah menjadi bagian dari ekosistem Teqara. Tingkatkan transaksi untuk benefit lebih.
                        </p>
                    </div>
                </div>

                <!-- Right: Progress Circle -->
                <div class="w-full md:w-auto flex-shrink-0">
                    <div class="bg-white/5 rounded-[2.5rem] p-8 border border-white/10 backdrop-blur-md w-full md:w-[22rem]">
                        @if($nextLevel)
                            @php
                                $percent = min(100, ($user->poin_loyalitas / $levels[$nextLevel]['min']) * 100);
                            @endphp
                            <div class="flex justify-between items-end mb-4">
                                <div>
                                    <p class="text-[10px] font-bold text-indigo-300 uppercase tracking-widest mb-1">Target Selanjutnya</p>
                                    <h3 class="text-2xl font-black text-white uppercase italic">{{ $nextLevel }}</h3>
                                </div>
                                <h3 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">{{ number_format($percent, 0) }}%</h3>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="relative h-4 bg-slate-800 rounded-full overflow-hidden mb-6 shadow-inner">
                                <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-indigo-600 via-purple-500 to-cyan-400 transition-all duration-1000 ease-out rounded-full" style="width: {{ $percent }}%">
                                    <div class="absolute top-0 right-0 h-full w-full bg-gradient-to-b from-white/20 to-transparent"></div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-xs text-slate-300 bg-slate-900/50 p-4 rounded-xl border border-white/5">
                                <span class="p-1.5 bg-indigo-500 rounded-lg shrink-0">🚀</span>
                                <span>Butuh <span class="text-white font-black">{{ number_format($levels[$nextLevel]['min'] - $user->poin_loyalitas) }} poin</span> lagi.</span>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-20 h-20 bg-gradient-to-br from-amber-300 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4 text-4xl shadow-lg shadow-amber-500/20">👑</div>
                                <h3 class="text-white font-black uppercase tracking-wide">Legenda Teqara</h3>
                                <p class="text-xs text-amber-200 mt-2">Anda telah mencapai puncak tertinggi.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Tier Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            @foreach($levels as $lvlName => $data)
            <div class="group relative bg-white rounded-[2.5rem] p-8 border transition-all duration-300 overflow-hidden {{ $currentLevel == $lvlName ? 'border-indigo-500 ring-4 ring-indigo-500/5 shadow-2xl shadow-indigo-500/10 -translate-y-2' : 'border-slate-100 hover:border-indigo-200 hover:shadow-xl hover:-translate-y-1 opacity-80 hover:opacity-100 grayscale hover:grayscale-0' }}">
                
                <!-- Active Indicator -->
                @if($currentLevel == $lvlName)
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 bg-indigo-600 text-white text-[9px] font-black uppercase tracking-[0.2em] px-4 py-1.5 rounded-b-xl shadow-lg shadow-indigo-500/30">
                        Status Anda
                    </div>
                @endif

                <div class="mb-8 mt-2 text-center">
                    <div class="w-14 h-14 mx-auto rounded-2xl flex items-center justify-center text-2xl mb-4 transition-transform group-hover:scale-110 {{ $currentLevel == $lvlName ? 'bg-indigo-50 text-indigo-600' : 'bg-slate-50 text-slate-400' }}">
                        {{ $lvlName == 'Classic' ? '🥉' : ($lvlName == 'Silver' ? '🥈' : ($lvlName == 'Gold' ? '🥇' : '💎')) }}
                    </div>
                    <h4 class="text-lg font-black uppercase italic tracking-tighter text-slate-900">{{ $lvlName }}</h4>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                        {{ number_format($data['min']) }} - {{ $data['max'] > 900000 ? '∞' : number_format($data['max']) }} Poin
                    </p>
                </div>
                
                <div class="space-y-4">
                    @foreach($data['benefits'] as $benefit)
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 p-0.5 rounded-full {{ $currentLevel == $lvlName ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-300' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-xs font-bold leading-tight {{ $currentLevel == $lvlName ? 'text-slate-700' : 'text-slate-500' }}">{{ $benefit }}</span>
                    </div>
                    @endforeach
                </div>

                @if($user->poin_loyalitas < $data['min'])
                    <div class="mt-8 pt-6 border-t border-slate-50 text-center">
                         <div class="flex items-center justify-center gap-2 text-[10px] font-black text-slate-300 uppercase tracking-widest">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Terkunci
                        </div>
                    </div>
                @endif
            </div>
            @endforeach
        </div>

    </div>
</div>
