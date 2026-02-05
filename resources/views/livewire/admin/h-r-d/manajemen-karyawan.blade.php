<div class="space-y-10 p-6 lg:p-10">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">Sumber Daya <span class="text-pink-600">Manusia</span></h1>
            <p class="text-slate-500 font-medium">Manajemen talenta dan struktur organisasi perusahaan.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative">
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Karyawan..." class="w-64 pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-pink-500 focus:border-pink-500 shadow-sm">
                <svg class="w-5 h-5 absolute left-3 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-slate-800 transition shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Rekrut
            </button>
        </div>
    </div>

    <!-- Grid Karyawan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($karyawan as $k)
        <div class="bg-white rounded-[32px] p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-pink-500/10 transition-all group relative overflow-hidden">
            <!-- Badge Status -->
            <div class="absolute top-6 right-6">
                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $k->status_kerja == 'tetap' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                    {{ $k->status_kerja }}
                </span>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 rounded-full border-4 border-slate-50 overflow-hidden mb-4 group-hover:scale-110 transition-transform duration-500">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($k->nama) }}&background=db2777&color=fff" class="w-full h-full object-cover">
                </div>
                
                <h3 class="text-lg font-black text-slate-900 mb-1">{{ $k->nama }}</h3>
                <p class="text-sm font-bold text-slate-500">{{ $k->jabatan }}</p>
                <p class="text-xs font-medium text-pink-600 uppercase tracking-widest mt-2">{{ $k->departemen }}</p>

                <div class="mt-6 w-full pt-6 border-t border-slate-50 flex justify-between items-center text-xs font-bold text-slate-400">
                    <span>NIP: {{ $k->nip }}</span>
                    <span>Bergabung: {{ \Carbon\Carbon::parse($k->tanggal_bergabung)->format('M Y') }}</span>
                </div>
            </div>
            
            <!-- Hover Action -->
            <div class="absolute inset-x-0 bottom-0 h-1 bg-pink-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-slate-50 rounded-[32px] border border-dashed border-slate-200">
            <p class="text-slate-400 font-medium">Belum ada data karyawan.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div>
        {{ $karyawan->links() }}
    </div>
</div>
