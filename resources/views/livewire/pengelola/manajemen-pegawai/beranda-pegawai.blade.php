<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">HR Command Center</h1>
            <p class="text-slate-500 text-sm mt-1">Manajemen Sumber Daya Manusia dan Struktur Organisasi.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('pengelola.pengguna.hrd') }}" wire:navigate class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
                <i class="fa-solid fa-users-gear mr-2"></i> Direktori Pegawai
            </a>
        </div>
    </div>

    <!-- HR Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Headcount -->
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-10">
                <i class="fa-solid fa-id-card text-6xl text-indigo-500"></i>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Karyawan</p>
            <h3 class="text-3xl font-black text-slate-900 mt-2">{{ $statistik['headcount'] }}</h3>
            <p class="text-[10px] text-slate-400 mt-1">Personil Aktif</p>
        </div>

        <!-- Kehadiran -->
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-10">
                <i class="fa-solid fa-business-time text-6xl text-emerald-500"></i>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Kehadiran Hari Ini</p>
            <h3 class="text-3xl font-black text-emerald-600 mt-2">{{ $statistik['hadir'] }}</h3>
            <p class="text-[10px] text-slate-400 mt-1">{{ $statistik['izin'] }} Izin/Cuti</p>
        </div>

        <!-- Payroll -->
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-10">
                <i class="fa-solid fa-money-check-dollar text-6xl text-amber-500"></i>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Estimasi Payroll</p>
            <h3 class="text-2xl font-black text-slate-900 mt-2">Rp {{ number_format($statistik['payroll']/1000000, 1) }}Jt</h3>
            <p class="text-[10px] text-slate-400 mt-1">Bulan Berjalan</p>
        </div>

        <!-- Performance -->
        <div class="bg-slate-900 p-6 rounded-[24px] text-white relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-10">
                <i class="fa-solid fa-chart-simple text-6xl text-cyan-500"></i>
            </div>
            <p class="text-xs font-black text-indigo-300 uppercase tracking-widest">Indeks Kinerja</p>
            <h3 class="text-3xl font-black mt-2">98.5%</h3>
            <p class="text-[10px] text-slate-400 mt-1">Rata-rata Organisasi</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Organization Structure (Visual) -->
        <div class="lg:col-span-2 bg-white rounded-[24px] border border-slate-100 shadow-sm p-8">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Struktur Organisasi</h3>
            
            <div class="relative min-h-[200px] flex items-center justify-center">
                <!-- CEO Node -->
                <div class="flex flex-col items-center gap-8 w-full">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-2xl bg-slate-900 border-4 border-white shadow-xl flex items-center justify-center text-white text-2xl font-black z-10">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <div class="bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm -mt-4 pt-6 text-center">
                            <p class="text-xs font-bold text-slate-900">Direktur Utama</p>
                        </div>
                    </div>

                    <!-- Departments -->
                    <div class="flex flex-wrap justify-center gap-4 w-full relative">
                        <!-- Connector Line -->
                        <div class="absolute top-0 left-10 right-10 h-px bg-slate-200 -mt-4"></div>
                        
                        @foreach($komposisi as $dept => $count)
                        <div class="flex flex-col items-center relative">
                            <div class="w-px h-4 bg-slate-200 -mt-4 mb-2"></div>
                            <div class="bg-indigo-50 border border-indigo-100 px-4 py-3 rounded-xl text-center w-32 group hover:bg-indigo-100 transition-colors cursor-default">
                                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">{{ $dept }}</p>
                                <p class="text-xl font-bold text-indigo-900">{{ $count }}</p>
                                <p class="text-[9px] text-indigo-400">Personil</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Hires -->
        <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm p-6">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Personil Terbaru</h3>
            <div class="space-y-4">
                @foreach($karyawanTerbaru as $k)
                <div class="flex items-center gap-4 p-3 hover:bg-slate-50 rounded-xl transition-colors">
                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-500">
                        {{ substr($k->nama_lengkap, 0, 1) }}
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-bold text-slate-900 truncate">{{ $k->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ $k->jabatan->nama ?? '-' }}</p>
                    </div>
                    <span class="text-[10px] bg-slate-100 px-2 py-1 rounded text-slate-600 font-bold">
                        {{ $k->tanggal_bergabung->diffForHumans() }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
