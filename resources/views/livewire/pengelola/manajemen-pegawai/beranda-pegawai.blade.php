<div class="space-y-10 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-sky-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-sky-600 uppercase tracking-widest">HR Command Center</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">
                MANAJEMEN <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-600 to-indigo-500">SDM</span>
            </h1>
            <p class="text-slate-500 font-medium text-lg max-w-2xl leading-relaxed">
                Pusat data karyawan, struktur organisasi, dan analisis kinerja tim.
            </p>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="{{ route('pengelola.pengguna.hrd') }}" wire:navigate class="group flex items-center gap-3 px-8 py-4 bg-sky-600 text-white rounded-2xl shadow-lg shadow-sky-500/30 hover:bg-sky-700 hover:scale-105 transition-all duration-300">
                <i class="fa-solid fa-users-gear text-lg group-hover:scale-110 transition-transform"></i>
                <span class="font-black text-xs uppercase tracking-widest">Direktori Pegawai</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Headcount -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-sky-50 rounded-full blur-2xl group-hover:bg-sky-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Total Personil</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $statistik['headcount'] }}</h3>
                <p class="text-xs text-slate-400 mt-2 font-medium">Karyawan Aktif</p>
            </div>
        </div>

        <!-- Kehadiran -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-business-time"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Kehadiran Hari Ini</p>
                <h3 class="text-4xl font-black text-emerald-600 tracking-tighter">{{ $statistik['hadir'] }}</h3>
                <p class="text-xs text-slate-400 mt-2 font-medium">{{ $statistik['izin'] }} Izin/Cuti</p>
            </div>
        </div>

        <!-- Payroll -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-amber-50 rounded-full blur-2xl group-hover:bg-amber-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-money-check-dollar"></i>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Estimasi Payroll</p>
                <h3 class="text-3xl font-black text-slate-900 tracking-tighter">Rp {{ number_format($statistik['payroll']/1000000, 1) }}Jt</h3>
                <p class="text-xs text-slate-400 mt-2 font-medium">Bulan Berjalan</p>
            </div>
        </div>

        <!-- KPI -->
        <div class="bg-gradient-to-br from-slate-900 to-sky-900 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-sky-500/20 rounded-full blur-3xl group-hover:bg-sky-500/30 transition-colors"></div>
            <div class="relative z-10 text-white">
                <div class="w-14 h-14 rounded-2xl bg-white/10 text-sky-300 flex items-center justify-center text-2xl mb-6 backdrop-blur-sm">
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
                <p class="text-[10px] font-black text-sky-200 uppercase tracking-[0.3em] mb-1">Indeks Kinerja</p>
                <h3 class="text-4xl font-black tracking-tighter">98.5%</h3>
                <p class="text-xs text-slate-400 mt-2 font-medium">Rata-rata Organisasi</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Visual Structure -->
        <div class="lg:col-span-2 bg-white rounded-[3rem] border border-slate-200 shadow-sm p-10 relative overflow-hidden">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-8 border-b border-slate-50 pb-4">Struktur Organisasi</h3>
            
            <div class="flex flex-col items-center justify-center py-10">
                <!-- CEO -->
                <div class="relative z-10 flex flex-col items-center mb-8 group cursor-pointer">
                    <div class="w-20 h-20 rounded-[2rem] bg-slate-900 border-4 border-white shadow-xl flex items-center justify-center text-white text-3xl transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div class="mt-4 bg-white border border-slate-200 px-6 py-2 rounded-xl shadow-sm text-center">
                        <p class="text-xs font-black text-slate-900 uppercase tracking-wider">Direktur Utama</p>
                    </div>
                </div>

                <!-- Connector -->
                <div class="w-full h-px bg-slate-200 max-w-lg mb-8 relative">
                    <div class="absolute left-1/2 top-0 h-8 w-px bg-slate-200 -translate-x-1/2 -translate-y-8"></div>
                    <div class="absolute left-10 top-0 h-8 w-px bg-slate-200"></div>
                    <div class="absolute right-10 top-0 h-8 w-px bg-slate-200"></div>
                    <div class="absolute left-1/2 top-0 h-8 w-px bg-slate-200"></div>
                </div>

                <!-- Departments -->
                <div class="flex flex-wrap justify-center gap-6">
                    @foreach($komposisi as $dept => $count)
                    <div class="bg-slate-50 border border-slate-100 p-6 rounded-[2rem] text-center min-w-[140px] hover:bg-sky-50 hover:border-sky-100 transition-colors group cursor-default">
                        <div class="mb-3 text-slate-300 group-hover:text-sky-500 transition-colors text-2xl">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $dept }}</p>
                        <p class="text-2xl font-black text-slate-900 group-hover:text-sky-700 transition-colors">{{ $count }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Hires -->
        <div class="bg-white rounded-[3rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-10 border-b border-slate-50 bg-slate-50/30">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Personil Terbaru</h3>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($karyawanTerbaru as $k)
                <div class="p-6 px-10 flex items-center gap-4 hover:bg-slate-50 transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-sky-50 flex items-center justify-center font-black text-sky-600">
                        {{ substr($k->nama_lengkap, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-900 truncate">{{ $k->nama_lengkap }}</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $k->jabatan->nama ?? 'Staff' }}</p>
                    </div>
                    <span class="text-[10px] font-medium text-slate-400">{{ $k->tanggal_bergabung->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>