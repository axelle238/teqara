<div class="space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-[2.5rem] p-10 relative overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <h1 class="text-3xl font-black text-white uppercase tracking-tight">Sistem <span class="text-indigo-400">Terpusat</span></h1>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-[0.2em] mt-2">Jantung Konfigurasi & Kesehatan Server Teqara</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('pengelola.sistem.pusat') }}" wire:navigate class="px-6 py-3 bg-white text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 transition-all shadow-lg flex items-center gap-2">
                    <i class="fa-solid fa-sliders"></i> Konfigurasi Global
                </a>
                <a href="{{ route('pengelola.sistem.kesehatan') }}" wire:navigate class="px-6 py-3 bg-slate-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-600 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-heart-pulse"></i> Cek Kesehatan
                </a>
            </div>
        </div>
    </div>

    <!-- Status Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Status Operasional -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl {{ $statistik['mode_pemeliharaan'] ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }}">
                    <i class="fa-solid {{ $statistik['mode_pemeliharaan'] ? 'fa-triangle-exclamation' : 'fa-check-circle' }}"></i>
                </div>
                <div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Status Operasional</span>
                    <span class="text-sm font-black {{ $statistik['mode_pemeliharaan'] ? 'text-amber-600' : 'text-emerald-600' }}">
                        {{ $statistik['mode_pemeliharaan'] ? 'Mode Perbaikan' : 'Sistem Online' }}
                    </span>
                </div>
            </div>
            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                <div class="h-full {{ $statistik['mode_pemeliharaan'] ? 'bg-amber-500 w-1/2' : 'bg-emerald-500 w-full animate-pulse' }}"></div>
            </div>
        </div>

        <!-- Database -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-database"></i>
                </div>
                <div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Database Utama</span>
                    <span class="text-sm font-black text-slate-900">{{ $statistik['status_database'] }}</span>
                </div>
            </div>
            <p class="text-[10px] font-bold text-slate-500 text-right">{{ $statistik['ukuran_database'] }}</p>
        </div>

        <!-- Environment -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-violet-50 text-violet-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-brands fa-php"></i>
                </div>
                <div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Lingkungan</span>
                    <span class="text-sm font-black text-slate-900">PHP {{ $statistik['versi_php'] }}</span>
                </div>
            </div>
            <p class="text-[10px] font-bold text-slate-500 text-right">Laravel v{{ $statistik['versi_laravel'] }}</p>
        </div>

        <!-- Integrasi -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-key"></i>
                </div>
                <div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Konektivitas</span>
                    <span class="text-sm font-black text-slate-900">{{ $statistik['kunci_api_aktif'] }} Kunci API</span>
                </div>
            </div>
            <p class="text-[10px] font-bold text-slate-500 text-right">Gateway Aktif</p>
        </div>
    </div>

    <!-- Quick Tools -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6">Utilitas Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('pengelola.voucher') }}" wire:navigate class="p-4 rounded-2xl bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 transition-all text-center group">
                    <i class="fa-solid fa-ticket text-2xl mb-2 text-slate-400 group-hover:text-indigo-500"></i>
                    <span class="block text-[10px] font-bold uppercase tracking-wide">Buat Voucher</span>
                </a>
                <button disabled class="p-4 rounded-2xl bg-slate-50 opacity-50 cursor-not-allowed text-center">
                    <i class="fa-solid fa-broom text-2xl mb-2 text-slate-400"></i>
                    <span class="block text-[10px] font-bold uppercase tracking-wide">Bersihkan Cache</span>
                </button>
            </div>
        </div>

        <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-sm font-black text-white uppercase tracking-widest mb-4">Pesan Sistem</h3>
                <div class="space-y-4">
                    <div class="flex gap-3 text-xs">
                        <span class="text-emerald-400">●</span>
                        <span class="text-slate-300">Sistem berjalan optimal. Tidak ada antrian job yang macet.</span>
                    </div>
                    <div class="flex gap-3 text-xs">
                        <span class="text-emerald-400">●</span>
                        <span class="text-slate-300">Pencadangan database otomatis terakhir: 2 jam lalu.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
