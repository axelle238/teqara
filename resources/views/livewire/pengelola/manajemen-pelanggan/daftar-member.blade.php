<div class="animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Stats CRM -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-indigo-600 rounded-[30px] p-8 text-white relative overflow-hidden shadow-xl shadow-indigo-500/30">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <p class="text-xs font-black uppercase tracking-widest text-indigo-200 mb-2">Total Pelanggan</p>
            <h3 class="text-4xl font-black">{{ \App\Models\Pengguna::where('peran', 'pelanggan')->count() }}</h3>
        </div>
        <div class="bg-white rounded-[30px] p-8 border border-slate-100 shadow-sm relative overflow-hidden">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Member Baru (Bulan Ini)</p>
            <h3 class="text-4xl font-black text-slate-900">{{ \App\Models\Pengguna::where('peran', 'pelanggan')->whereMonth('dibuat_pada', now()->month)->count() }}</h3>
        </div>
        <div class="bg-white rounded-[30px] p-8 border border-slate-100 shadow-sm relative overflow-hidden">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Pelanggan Aktif</p>
            <h3 class="text-4xl font-black text-emerald-600">
                {{ \App\Models\Pengguna::where('peran', 'pelanggan')->has('pesanan')->count() }}
            </h3>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="bg-white p-6 rounded-[30px] border border-slate-100 shadow-sm mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="relative w-full md:w-96">
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Nama atau Email..." class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-indigo-500">
            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
        </div>
        
        <select wire:model.live="filterLevel" class="bg-slate-50 border-none rounded-2xl px-6 py-3 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-indigo-500 cursor-pointer">
            <option value="">Semua Level</option>
            <option value="Classic">Classic</option>
            <option value="Silver">Silver</option>
            <option value="Gold">Gold</option>
            <option value="Platinum">Platinum</option>
        </select>
    </div>

    <!-- Customer Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($this->pelanggan as $user)
        <div class="group bg-white rounded-[35px] p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-100 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <!-- Level Badge -->
            <div class="absolute top-0 right-0 px-4 py-2 bg-slate-100 rounded-bl-2xl text-[9px] font-black uppercase tracking-widest text-slate-500">
                {{ $user->level_member ?? 'Classic' }}
            </div>

            <div class="flex flex-col items-center text-center mb-6 pt-4">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-slate-100 to-white border-4 border-white shadow-lg flex items-center justify-center text-2xl font-black text-slate-300 mb-4 overflow-hidden relative">
                    @if($user->foto_profil)
                        <img src="{{ asset($user->foto_profil) }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($user->nama, 0, 1) }}
                    @endif
                </div>
                <h3 class="font-black text-slate-900 text-lg leading-tight mb-1">{{ $user->nama }}</h3>
                <p class="text-xs text-slate-400 font-medium">{{ $user->email }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4 border-t border-slate-50 pt-6">
                <div class="text-center">
                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1">Total Belanja</p>
                    <p class="text-sm font-black text-indigo-600">Rp {{ number_format($user->total_belanja/1000, 0) }}K</p>
                </div>
                <div class="text-center border-l border-slate-50">
                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1">Pesanan</p>
                    <p class="text-sm font-black text-slate-900">{{ $user->pesanan_count }}</p>
                </div>
            </div>

            <div class="mt-6 flex gap-2">
                <button class="flex-1 py-2.5 bg-slate-50 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-100 transition-all">
                    Detail
                </button>
                <a href="mailto:{{ $user->email }}" class="w-10 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-all">
                    <i class="fa-solid fa-envelope"></i>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-white rounded-[40px] border border-dashed border-slate-200">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl text-slate-300">
                <i class="fa-solid fa-users-slash"></i>
            </div>
            <h3 class="text-xl font-black text-slate-900 uppercase">Tidak Ditemukan</h3>
            <p class="text-slate-500 font-medium text-sm mt-2">Belum ada data pelanggan yang sesuai kriteria.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $this->pelanggan->links() }}
    </div>
</div>
