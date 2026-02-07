<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    @if(!$tampilkanForm)
        <!-- HEADER -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Jaringan <span class="text-indigo-600">Gudang</span></h1>
                <p class="text-slate-500 font-medium text-sm mt-1">Manajemen lokasi fisik inventaris dan pusat distribusi.</p>
            </div>
            <button wire:click="tambahBaru" class="flex items-center gap-3 px-6 py-3 bg-indigo-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                <i class="fa-solid fa-warehouse"></i> Tambah Lokasi
            </button>
        </div>

        <!-- LIST VIEW -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($daftarGudang as $g)
            <div class="bg-white rounded-[2.5rem] border border-slate-200 p-6 shadow-sm hover:border-indigo-200 hover:shadow-xl transition-all group relative overflow-hidden">
                <!-- Status Badge -->
                <div class="absolute top-6 right-6">
                    <button wire:click="toggleStatus({{ $g->id }})" class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border transition-all {{ $g->aktif ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-slate-50 text-slate-400 border-slate-200' }}">
                        {{ $g->aktif ? 'AKTIF' : 'NON-AKTIF' }}
                    </button>
                </div>

                <div class="flex items-start gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 text-2xl group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-building-shield"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-lg leading-tight">{{ $g->nama }}</h3>
                        <p class="text-xs font-mono font-bold text-slate-400 mt-1 uppercase">{{ $g->kode_gudang }}</p>
                    </div>
                </div>

                <div class="space-y-3 mb-6 min-h-[80px]">
                    <p class="text-sm text-slate-600 font-medium leading-relaxed flex gap-2">
                        <i class="fa-solid fa-location-dot text-indigo-400 mt-1"></i>
                        <span>
                            {{ $g->alamat }}<br>
                            {{ $g->kota }}, {{ $g->provinsi }} {{ $g->kodepos }}
                        </span>
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <i class="fa-solid fa-boxes-stacked mr-1"></i> {{ $g->stok_gudang_count }} SKU
                    </span>
                    <button wire:click="edit({{ $g->id }})" class="w-10 h-10 rounded-xl bg-slate-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center bg-white rounded-[40px] border border-dashed border-slate-200">
                <i class="fa-solid fa-warehouse text-4xl text-slate-300 mb-4"></i>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Belum ada gudang terdaftar.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $daftarGudang->links() }}
        </div>

    @else
        <!-- FORM EDITOR -->
        <div class="max-w-4xl mx-auto py-12 animate-in slide-in-from-bottom-8 duration-500">
            <div class="bg-white rounded-[40px] p-10 border border-slate-200 shadow-xl relative overflow-hidden">
                <!-- Decor -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-full blur-3xl -mr-20 -mt-20"></div>

                <div class="flex justify-between items-center mb-8 relative z-10">
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">{{ $gudangId ? 'Edit Lokasi' : 'Registrasi Gudang' }}</h1>
                    <button wire:click="batal" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-colors">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form wire:submit="simpan" class="space-y-8 relative z-10">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Gudang / Cabang</label>
                            <input type="text" wire:model="nama" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-lg font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10 placeholder-slate-300" placeholder="Cth: Gudang Pusat Jakarta">
                            @error('nama') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kode Lokasi (Unik)</label>
                            <input type="text" wire:model="kode_gudang" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-mono text-sm font-bold text-indigo-600 focus:ring-4 focus:ring-indigo-500/10 uppercase" placeholder="JKT-WH-01">
                            @error('kode_gudang') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Alamat Lengkap</label>
                        <textarea wire:model="alamat" rows="3" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-medium text-slate-700 focus:ring-4 focus:ring-indigo-500/10 resize-none" placeholder="Jalan, Nomor, RT/RW..."></textarea>
                        @error('alamat') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kota / Kabupaten</label>
                            <input type="text" wire:model="kota" class="w-full px-5 py-3 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Provinsi</label>
                            <input type="text" wire:model="provinsi" class="w-full px-5 py-3 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kode Pos</label>
                            <input type="text" wire:model="kodepos" class="w-full px-5 py-3 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20 active:scale-95">
                            Simpan Lokasi
                        </button>
                    </div>

                </form>
            </div>
        </div>
    @endif

</div>
