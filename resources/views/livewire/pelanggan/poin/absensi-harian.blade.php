<div class="bg-slate-50 min-h-screen py-12 flex items-center justify-center">
    <div class="max-w-md w-full px-4">
        
        <div class="bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-slate-100 relative">
            <!-- Background Elements -->
            <div class="absolute top-0 left-0 w-full h-40 bg-gradient-to-br from-indigo-600 to-purple-600"></div>
            <div class="absolute top-10 left-1/2 -translate-x-1/2 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative z-10 p-8 text-center">
                <h1 class="text-white text-2xl font-black uppercase tracking-widest mb-1">Check-in Harian</h1>
                <p class="text-indigo-100 text-xs font-bold mb-8">Kumpulkan poin gratis setiap hari!</p>

                <div class="bg-white rounded-[2.5rem] p-8 shadow-lg border border-slate-100 mb-8">
                    <div class="text-6xl mb-4 animate-bounce">🎁</div>
                    
                    @if($this->sudahAbsen)
                        <h3 class="text-slate-900 font-black text-lg mb-2">Sudah Check-in!</h3>
                        <p class="text-slate-500 text-sm mb-6">Kembali lagi besok untuk poin lebih banyak.</p>
                        <button disabled class="w-full py-4 bg-slate-100 text-slate-400 rounded-2xl font-black text-xs uppercase tracking-[0.2em] cursor-not-allowed">
                            Selesai
                        </button>
                    @else
                        <h3 class="text-slate-900 font-black text-lg mb-2">Siap Diklaim</h3>
                        <p class="text-slate-500 text-sm mb-6">Tap tombol di bawah untuk ambil poin hari ini.</p>
                        <button wire:click="klaimPoin" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/30 active:scale-95">
                            Klaim Sekarang
                        </button>
                    @endif
                </div>

                <div class="flex items-center justify-center gap-2 text-slate-400 text-xs font-bold uppercase tracking-widest">
                    <span class="text-amber-500 text-lg">🔥</span>
                    Streak: {{ $this->streak }} Hari
                </div>
            </div>
        </div>

    </div>
</div>
