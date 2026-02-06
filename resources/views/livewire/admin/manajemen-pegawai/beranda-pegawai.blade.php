<div class="space-y-12 pb-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">HUMAN <span class="text-rose-600">CAPITAL</span></h1>
            <p class="text-slate-500 font-medium text-lg">Pusat komando manajemen sumber daya manusia dan talenta.</p>
        </div>
        <a href="{{ route('admin.pengguna.hrd') }}" wire:navigate class="px-8 py-4 bg-slate-900 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-rose-600 transition-all shadow-xl">
            DIREKTORI KARYAWAN
        </a>
    </div>

    <!-- HR Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 flex flex-col justify-between h-full group hover:shadow-xl transition-all">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Total Headcount</p>
            <div class="flex items-end justify-between">
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $statistik['headcount'] }}</h3>
                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-emerald-50 p-8 rounded-[40px] border border-emerald-100 flex flex-col justify-between h-full">
            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-4">Kehadiran (Simulasi)</p>
            <div class="flex items-end gap-2">
                <h3 class="text-4xl font-black text-emerald-700 tracking-tighter">{{ $statistik['hadir'] }}</h3>
                <span class="text-xs font-bold text-emerald-600 mb-2 uppercase">On-Site</span>
            </div>
        </div>

        <div class="bg-amber-50 p-8 rounded-[40px] border border-amber-100 flex flex-col justify-between h-full">
            <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-4">Absen / Cuti</p>
            <div class="flex items-end gap-2">
                <h3 class="text-4xl font-black text-amber-700 tracking-tighter">{{ $statistik['izin'] }}</h3>
                <span class="text-xs font-bold text-amber-600 mb-2 uppercase">Personel</span>
            </div>
        </div>

        <div class="bg-rose-50 p-8 rounded-[40px] border border-rose-100 flex flex-col justify-between h-full relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-rose-600 uppercase tracking-widest mb-4">Estimasi Payroll</p>
                <h3 class="text-3xl font-black text-rose-700 tracking-tighter">Rp {{ number_format($statistik['payroll'] / 1000000, 1) }}M</h3>
                <p class="text-[9px] font-bold text-rose-400 mt-1 uppercase tracking-widest">Beban Gaji Bulanan</p>
            </div>
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-rose-200/50 rounded-full blur-2xl"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Departemen Composition -->
        <div class="lg:col-span-1 bg-white p-10 rounded-[48px] shadow-sm border border-slate-100">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-8">Distribusi Departemen</h3>
            <div class="space-y-6">
                @foreach($komposisi as $dept => $count)
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">{{ $dept }}</span>
                        <span class="text-xs font-black text-indigo-600">{{ $count }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ ($count / $statistik['headcount']) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Hires -->
        <div class="lg:col-span-2 bg-white rounded-[48px] shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Perekrutan Terbaru</h3>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">5 Karyawan Terakhir</span>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($karyawanTerbaru as $k)
                <div class="px-10 py-6 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-[16px] bg-indigo-50 flex items-center justify-center font-black text-indigo-600">
                            {{ substr($k->pengguna->nama, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm uppercase">{{ $k->pengguna->nama }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $k->jabatan->nama }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-slate-100 rounded-lg text-[9px] font-black uppercase tracking-widest text-slate-500">
                        {{ $k->tanggal_bergabung->diffForHumans() }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

