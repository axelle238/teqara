<div class="space-y-10 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-50 border border-purple-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-purple-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-purple-600 uppercase tracking-widest">Customer Relationship Management</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">
                DATABASE <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-500">PELANGGAN</span>
            </h1>
            <p class="text-slate-500 font-medium text-lg max-w-2xl leading-relaxed">
                Analisis loyalitas, segmentasi pasar, dan pertumbuhan basis pengguna.
            </p>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="{{ route('pengelola.pelanggan.daftar') }}" wire:navigate class="group flex items-center gap-3 px-8 py-4 bg-purple-600 text-white rounded-2xl shadow-lg shadow-purple-500/30 hover:bg-purple-700 hover:scale-105 transition-all duration-300">
                <i class="fa-solid fa-users-viewfinder text-lg group-hover:scale-110 transition-transform"></i>
                <span class="font-black text-xs uppercase tracking-widest">Direktori Member</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Pelanggan -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-purple-50 rounded-full blur-2xl group-hover:bg-purple-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Total Basis Data</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($stats['total']) }}</h3>
            </div>
        </div>

        <!-- Pelanggan Baru -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-pink-50 rounded-full blur-2xl group-hover:bg-pink-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Akuisisi Baru</p>
                <h3 class="text-4xl font-black text-pink-600 tracking-tighter">+{{ number_format($stats['baru']) }} <span class="text-xs text-slate-400 font-bold uppercase ml-1">Bulan Ini</span></h3>
            </div>
        </div>

        <!-- Aktif -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-signal"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Member Aktif</p>
                <h3 class="text-4xl font-black text-emerald-600 tracking-tighter">{{ number_format($stats['aktif']) }}</h3>
                <p class="text-xs text-slate-400 mt-2 font-bold">Belanja 30 Hari Terakhir</p>
            </div>
        </div>

        <!-- LTV -->
        <div class="bg-gradient-to-br from-slate-900 to-purple-900 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-purple-500/20 rounded-full blur-3xl group-hover:bg-purple-500/30 transition-colors"></div>
            <div class="relative z-10 text-white">
                <div class="w-14 h-14 rounded-2xl bg-white/10 text-purple-300 flex items-center justify-center text-2xl mb-6 backdrop-blur-sm">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <p class="text-[10px] font-black text-purple-200 uppercase tracking-[0.3em] mb-1">Rata-rata LTV</p>
                <h3 class="text-3xl font-black tracking-tighter">Rp {{ number_format($stats['avg_ltv'] / 1000, 0, ',', '.') }}K</h3>
                <p class="text-xs text-slate-400 mt-2 font-medium">Nilai seumur hidup / user.</p>
            </div>
        </div>
    </div>

    <!-- Top Spenders List -->
    <div class="bg-white rounded-[3rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-10 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Pelanggan VIP (Top Spenders)</h3>
            <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-amber-100">Tier Sultan</span>
        </div>
        
        <div class="divide-y divide-slate-50">
            @foreach($topSpenders as $index => $user)
            <div class="p-6 px-10 flex items-center justify-between hover:bg-slate-50 transition-colors group">
                <div class="flex items-center gap-6">
                    <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center font-black text-lg {{ $index == 0 ? 'bg-amber-100 text-amber-600' : ($index == 1 ? 'bg-slate-200 text-slate-600' : ($index == 2 ? 'bg-orange-100 text-orange-700' : 'bg-slate-100 text-slate-400')) }} rounded-2xl">
                        #{{ $index + 1 }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">{{ $user->nama }}</h4>
                        <p class="text-[10px] text-slate-400 font-mono">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-black text-slate-900 tracking-tight">Rp {{ number_format($user->pesanan_sum_total_harga, 0, ',', '.') }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Belanja</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
