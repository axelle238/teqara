<div class="space-y-12 pb-32">
    <!-- Header: Vibrant & Professional -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-50 border border-slate-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-slate-400 animate-pulse"></span>
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Hirarki Organisasi Terpusat</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">STRUKTUR <span class="text-slate-500">KERJA</span></h1>
            <p class="text-slate-500 font-medium text-lg">Konfigurasi unit departemen dan otoritas jabatan dalam ekosistem perusahaan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        
        <!-- Form Konfigurasi: No Dark Policy -->
        <div class="space-y-10">
            <!-- Tambah Departemen -->
            <div class="bg-white rounded-[48px] shadow-sm border border-indigo-50 p-10">
                <h3 class="text-xl font-black text-slate-900 mb-8 uppercase tracking-tighter flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    Registrasi Departemen
                </h3>
                <form wire:submit.prevent="simpanDept" class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Unit Departemen</label>
                        <input wire:model="inputNamaDept" type="text" class="w-full rounded-2xl border-none bg-indigo-50/50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="Contoh: Logistik & Distribusi">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kode Identitas (Unique)</label>
                        <input wire:model="inputKodeDept" type="text" class="w-full rounded-2xl border-none bg-indigo-50/50 px-6 py-4 text-sm font-black text-indigo-600 focus:ring-2 focus:ring-indigo-500 uppercase" placeholder="DEPT-LOG">
                    </div>
                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[24px] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/10">SAHKAN DEPARTEMEN</button>
                </form>
            </div>

            <!-- Tambah Jabatan -->
            <div class="bg-white rounded-[48px] shadow-sm border border-indigo-50 p-10">
                <h3 class="text-xl font-black text-slate-900 mb-8 uppercase tracking-tighter flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    Definisi Jabatan Baru
                </h3>
                <form wire:submit.prevent="simpanJabatan" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Jabatan</label>
                            <input wire:model="inputNamaJabatan" type="text" class="w-full rounded-2xl border-none bg-rose-50/50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-rose-500 transition-all" placeholder="Contoh: Senior Analyst">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Unit Departemen</label>
                            <select wire:model="inputDeptId" class="w-full rounded-2xl border-none bg-rose-50/50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-rose-500 transition-all">
                                <option value="">Pilih Departemen</option>
                                @foreach($semua_dept as $d) <option value="{{ $d->id }}">{{ $d->nama }}</option> @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Alokasi Gaji Pokok (Rp)</label>
                        <input wire:model="inputGaji" type="number" class="w-full rounded-2xl border-none bg-rose-50/50 px-6 py-4 text-sm font-black text-slate-900 focus:ring-2 focus:ring-rose-500">
                    </div>
                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[24px] font-black text-xs uppercase tracking-[0.2em] hover:bg-rose-600 transition-all shadow-xl shadow-slate-900/10">SAHKAN JABATAN</button>
                </form>
            </div>
        </div>

        <!-- Visualisasi Hirarki -->
        <div class="bg-indigo-50/30 rounded-[56px] border border-indigo-100 p-10 overflow-hidden relative shadow-inner">
            <h3 class="text-xl font-black text-slate-900 mb-10 uppercase tracking-tighter border-b border-indigo-100 pb-4">Peta Struktural Enterprise</h3>
            
            <div class="space-y-8 max-h-[800px] overflow-y-auto custom-scrollbar pr-4">
                @foreach($daftar_dept as $dept)
                <div class="bg-white rounded-[32px] p-8 border border-white shadow-sm group hover:border-indigo-300 transition-all">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black text-xs shadow-lg">{{ $dept->kode }}</div>
                            <h4 class="font-black text-slate-900 text-lg tracking-tight uppercase">{{ $dept->nama }}</h4>
                        </div>
                        <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">{{ $dept->jabatan->count() }} POSISI</span>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($dept->jabatan as $j)
                        <div class="flex items-center justify-between p-4 bg-slate-50/50 rounded-2xl border border-transparent hover:border-indigo-100 hover:bg-white transition-all">
                            <span class="text-xs font-black text-slate-600 uppercase tracking-tight">{{ $j->nama }}</span>
                            <span class="text-[10px] font-bold text-indigo-400 tracking-tighter">Rp {{ number_format($j->gaji_pokok/1000000, 1) }}JT</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Background Deco -->
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-[80px]"></div>
        </div>
    </div>
</div>
