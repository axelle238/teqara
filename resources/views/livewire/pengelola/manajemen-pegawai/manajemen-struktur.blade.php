<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Struktur <span class="text-sky-600">Organisasi</span></h1>
            <p class="text-slate-500 font-medium">Pemetaan hirarki perusahaan dan manajemen jabatan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Kolom Kiri: Input Data -->
        <div class="space-y-8">
            <!-- Form Departemen -->
            <div class="bg-white p-8 rounded-[30px] border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-sky-50 rounded-full blur-2xl -mr-8 -mt-8"></div>
                
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6 relative z-10">Tambah Departemen</h3>
                <form wire:submit.prevent="simpanDept" class="space-y-4 relative z-10">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase">Nama Departemen</label>
                        <input type="text" wire:model="inputNamaDept" placeholder="e.g. Logistik & Gudang" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-sky-500">
                        @error('inputNamaDept') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase">Kode Dept</label>
                        <input type="text" wire:model="inputKodeDept" placeholder="LOG" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-sky-500 uppercase">
                        @error('inputKodeDept') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="w-full py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-sky-600 transition-all shadow-lg shadow-slate-900/20">
                        Simpan Dept
                    </button>
                </form>
            </div>

            <!-- Form Jabatan -->
            <div class="bg-white p-8 rounded-[30px] border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-full blur-2xl -mr-8 -mt-8"></div>

                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6 relative z-10">Tambah Jabatan</h3>
                <form wire:submit.prevent="simpanJabatan" class="space-y-4 relative z-10">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase">Departemen Induk</label>
                        <select wire:model="inputDeptId" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                            <option value="">Pilih Dept...</option>
                            @foreach($semua_dept as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                        @error('inputDeptId') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase">Nama Jabatan</label>
                        <input type="text" wire:model="inputNamaJabatan" placeholder="e.g. Kepala Gudang" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500">
                        @error('inputNamaJabatan') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase">Gaji Pokok (Estimasi)</label>
                        <input type="number" wire:model="inputGaji" placeholder="0" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500">
                        @error('inputGaji') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="w-full py-3 bg-emerald-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">
                        Simpan Jabatan
                    </button>
                </form>
            </div>
        </div>

        <!-- Kolom Kanan: Visualisasi Struktur -->
        <div class="lg:col-span-2 space-y-6">
            @forelse($daftar_dept as $dept)
            <div class="bg-white rounded-[30px] border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center text-sky-700 font-black text-sm border border-sky-200">{{ $dept->kode }}</span>
                        <h3 class="font-black text-slate-900 text-lg">{{ $dept->nama }}</h3>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $dept->jabatan->count() }} Posisi</span>
                </div>
                
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($dept->jabatan as $jab)
                    <div class="flex items-center justify-between p-4 rounded-2xl border border-slate-100 hover:border-sky-200 hover:bg-sky-50/30 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $jab->nama }}</p>
                                <p class="text-[10px] text-slate-400 font-mono">ID: {{ $jab->id }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-black text-slate-900 opacity-0 group-hover:opacity-100 transition-opacity">
                            Rp {{ number_format($jab->gaji_pokok/1000000, 1) }}Jt
                        </span>
                    </div>
                    @endforeach
                    @if($dept->jabatan->isEmpty())
                        <div class="col-span-full text-center py-4 text-slate-400 text-xs italic">Belum ada jabatan di departemen ini.</div>
                    @endif
                </div>
            </div>
            @empty
            <div class="py-20 text-center bg-white rounded-[40px] border border-dashed border-slate-200">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl text-slate-300">
                    <i class="fa-solid fa-sitemap"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 uppercase">Struktur Kosong</h3>
                <p class="text-slate-400 font-medium text-sm mt-2">Mulai dengan menambahkan departemen pertama Anda.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>
