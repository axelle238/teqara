<div class="space-y-10">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">STRUKTUR <span class="text-slate-500">ORGANISASI</span></h1>
            <p class="text-slate-500 font-medium">Manajemen departemen dan otoritas jabatan tim internal.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        
        <!-- Sisi Kiri: Form Input -->
        <div class="space-y-8">
            <!-- Form Departemen -->
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                <h3 class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">Tambah Departemen Baru</h3>
                <form wire:submit.prevent="simpanDept" class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Unit</label>
                            <input wire:model="inputNamaDept" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-indigo-500 font-bold" placeholder="Contoh: Logistik">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Kode Dept</label>
                            <input wire:model="inputKodeDept" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-indigo-500 font-bold" placeholder="LOG">
                        </div>
                    </div>
                    <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition">Simpan Unit</button>
                </form>
            </div>

            <!-- Form Jabatan -->
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                <h3 class="text-xs font-black text-emerald-600 uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">Tambah Otoritas Jabatan</h3>
                <form wire:submit.prevent="simpanJabatan" class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Posisi</label>
                        <input wire:model="inputNamaJabatan" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-indigo-500 font-bold" placeholder="Contoh: Manajer Gudang">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Departemen</label>
                            <select wire:model="inputDeptId" class="w-full rounded-2xl border-slate-200 focus:ring-indigo-500 text-sm font-bold">
                                <option value="">Pilih Dept</option>
                                @foreach($semua_dept as $d) <option value="{{ $d->id }}">{{ $d->nama }}</option> @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Estimasi Gaji (Rp)</label>
                            <input wire:model="inputGaji" type="number" class="w-full rounded-2xl border-slate-200 focus:ring-indigo-500 font-bold">
                        </div>
                    </div>
                    <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition">Sahkan Jabatan</button>
                </form>
            </div>
        </div>

        <!-- Sisi Kanan: Visualisasi Struktur -->
        <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Peta Struktural Perusahaan</h3>
            </div>
            <div class="p-8 space-y-8">
                @forelse($daftar_dept as $dept)
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="px-3 py-1 bg-indigo-600 text-white text-[10px] font-black rounded-lg uppercase">{{ $dept->kode }}</div>
                        <h4 class="font-black text-slate-900 text-lg tracking-tight">{{ $dept->nama }}</h4>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pl-10">
                        @foreach($dept->jabatan as $j)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 group hover:border-indigo-300 transition-colors">
                            <p class="text-xs font-black text-slate-900 uppercase tracking-tight">{{ $j->nama }}</p>
                            <p class="text-[10px] font-bold text-slate-400 mt-1">Gaji: Rp {{ number_format($j->gaji_pokok) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="py-20 text-center text-slate-400 font-bold">Belum ada data struktur.</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
