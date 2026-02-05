<div class="space-y-12 pb-32">
    <!-- Header: Vibrant & Professional -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 border border-rose-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-rose-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Manajemen SDM Terintegrasi</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">BERANDA <span class="text-rose-600">PEGAWAI</span></h1>
            <p class="text-slate-500 font-medium text-lg">Kelola otoritas, struktur organisasi, dan profil profesional internal.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.hrd.karyawan') }}" wire:navigate class="px-8 py-4 bg-indigo-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20">ATUR STRUKTUR</a>
        </div>
    </div>

    <!-- Statistik Pilar: Colorful HRD Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-14 h-14 rounded-[20px] bg-indigo-50 flex items-center justify-center text-indigo-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Administrator Sistem</p>
                <h3 class="text-5xl font-black text-slate-900 tracking-tighter">{{ number_format($total_admin) }} <span class="text-sm text-slate-400 font-bold uppercase ml-1">Aktor</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-rose-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-14 h-14 rounded-[20px] bg-rose-50 flex items-center justify-center text-rose-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Staf & Operator</p>
                <h3 class="text-5xl font-black text-rose-600 tracking-tighter">{{ number_format($total_staff) }} <span class="text-sm text-slate-400 font-bold uppercase ml-1">Personel</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-rose-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-gradient-to-br from-rose-600 to-indigo-700 p-10 rounded-[48px] text-white shadow-2xl relative overflow-hidden group">
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <h3 class="text-2xl font-black mb-3 tracking-tight">KENDALI SDM</h3>
                    <p class="text-sm font-medium text-rose-100 leading-relaxed mb-10 opacity-80">Registrasi karyawan baru dan verifikasi otoritas akses unit.</p>
                </div>
                <a href="{{ route('admin.pengguna.hrd') }}" wire:navigate class="w-full py-4 bg-white text-rose-600 rounded-2xl text-xs font-black uppercase tracking-[0.2em] text-center hover:scale-105 transition-all shadow-xl">MANAJEMEN KARYAWAN</a>
            </div>
        </div>
    </div>

    <!-- Daftar Akses Internal: No Dark Policy -->
    <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
        <div class="px-10 py-8 border-b border-indigo-50 bg-slate-50/30 flex items-center justify-between">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Personel Otoritas Aktif</h3>
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Real-time Directory</span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-0 divide-x divide-indigo-50">
            @foreach($daftar_admin as $a)
            <div class="p-10 hover:bg-indigo-50/20 transition-all duration-300 group">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 rounded-[24px] bg-white border-2 border-indigo-50 flex items-center justify-center text-xl font-black text-indigo-600 shadow-sm group-hover:scale-110 transition-transform">
                        {{ substr($a->nama, 0, 1) }}
                    </div>
                    <div class="space-y-1">
                        <p class="font-black text-slate-900 text-lg tracking-tight uppercase">{{ $a->nama }}</p>
                        <span class="inline-flex px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $a->peran == 'admin' ? 'bg-rose-100 text-rose-600 border border-rose-200' : 'bg-indigo-50 text-indigo-600 border border-indigo-100' }}">
                            Otoritas: {{ $a->peran }}
                        </span>
                    </div>
                </div>
                <div class="mt-8 flex items-center justify-between text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    <span>Email: {{ $a->email }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
