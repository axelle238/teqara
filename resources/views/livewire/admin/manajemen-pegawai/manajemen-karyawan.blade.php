<div class="space-y-12 pb-32">
    <!-- Header: Vibrant & Professional -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 border border-rose-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-rose-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Database Personel Enterprise</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">DATA <span class="text-rose-600">PEGAWAI</span></h1>
            <p class="text-slate-500 font-medium text-lg">Direktori lengkap profil profesional dan status ketenagakerjaan internal.</p>
        </div>
        <div class="flex items-center gap-3">
            <button 
                wire:click="tambahBaru" 
                class="flex items-center gap-3 px-8 py-4 bg-slate-900 text-white rounded-3xl font-black text-xs uppercase tracking-widest shadow-2xl hover:bg-rose-600 transition-all group"
            >
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"></path></svg>
                REGISTRASI PEGAWAI
            </button>
        </div>
    </div>

    <!-- Karyawan Grid Card -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($karyawan as $k)
        <div class="group bg-white rounded-[40px] border border-slate-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-bl-[40px] -mr-8 -mt-8 transition-colors group-hover:bg-indigo-50"></div>
            
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-20 h-20 rounded-[24px] bg-indigo-50 flex items-center justify-center text-2xl font-black text-indigo-600 shadow-inner group-hover:scale-110 transition-transform duration-500">
                        {{ substr($k->pengguna->nama, 0, 1) }}
                    </div>
                    <span class="px-3 py-1 bg-white border border-slate-100 rounded-full text-[9px] font-black uppercase tracking-widest text-slate-400">
                        {{ $k->nip }}
                    </span>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-xl font-black text-slate-900 leading-tight mb-1 group-hover:text-indigo-600 transition-colors">{{ $k->pengguna->nama }}</h3>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">{{ $k->jabatan->nama }}</p>
                    <p class="text-xs text-indigo-400 font-bold mt-1">{{ $k->jabatan->departemen->nama }}</p>
                </div>
                
                <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                    <div>
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $k->status_kerja === 'tetap' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                            {{ $k->status_kerja }}
                        </span>
                    </div>
                    <button class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <div class="text-6xl mb-6">🤝</div>
            <h3 class="text-2xl font-black text-slate-900 tracking-tighter uppercase mb-2">Data Kosong</h3>
            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Belum ada pegawai yang terdaftar dalam manifest radar.</p>
        </div>
        @endforelse
    </div>
    
    <div class="mt-10">
        {{ $karyawan->links() }}
    </div>

    <!-- Panel Form Pegawai (Vibrant Slide-over) -->
    <x-ui.panel-geser id="form-karyawan" judul="REGISTRASI PEGAWAI ENTERPRISE">
        <form wire:submit.prevent="simpan" class="space-y-10 p-2">
            <!-- Data Otoritas -->
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-1 bg-rose-600 rounded-full"></span>
                    <p class="text-[10px] font-black text-rose-600 uppercase tracking-[0.3em]">Otoritas & Identitas</p>
                </div>
                <div class="grid grid-cols-1 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Pilih Pengguna Sistem</label>
                        <select wire:model="pengguna_id" class="w-full rounded-2xl border-none bg-rose-50/50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-rose-500 transition-all">
                            <option value="">Pilih Member</option>
                            @foreach($list_pengguna as $u) <option value="{{ $u->id }}">{{ $u->nama }} ({{ $u->email }})</option> @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nomor Induk Pegawai (NIP)</label>
                        <input wire:model="nip" type="text" class="w-full rounded-2xl border-none bg-rose-50/50 px-6 py-4 text-sm font-black text-rose-600 focus:ring-2 focus:ring-rose-500 placeholder:text-slate-300 transition-all uppercase" placeholder="TEQ-NIP-001">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Posisi Jabatan</label>
                        <select wire:model="jabatan_id" class="w-full rounded-2xl border-none bg-rose-50/50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-rose-500 transition-all">
                            <option value="">Pilih Jabatan</option>
                            @foreach($list_jabatan as $j) <option value="{{ $j->id }}">{{ $j->nama }} - {{ $j->departemen->nama }}</option> @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Kontrak Kerja -->
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-1 bg-indigo-600 rounded-full"></span>
                    <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em]">Detail Penugasan</p>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tanggal Bergabung</label>
                        <input wire:model="tanggal_bergabung" type="date" class="w-full rounded-2xl border-none bg-indigo-50/50 px-6 py-4 text-sm font-black text-slate-900 focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Status Kepegawaian</label>
                        <select wire:model="status_kerja" class="w-full rounded-2xl border-none bg-indigo-50/50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 transition-all">
                            <option value="tetap">Pegawai Tetap</option>
                            <option value="kontrak">Kontrak Project</option>
                            <option value="magang">Magang / Intern</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Action Command -->
            <div class="pt-10 border-t-2 border-dashed border-slate-100 flex gap-4">
                <button type="submit" class="flex-1 bg-slate-900 text-white py-5 rounded-[28px] font-black text-xs uppercase tracking-[0.2em] hover:bg-rose-600 hover:scale-[1.02] active:scale-95 transition-all shadow-2xl shadow-rose-500/20 group">
                    SAHKAN DATA PEGAWAI
                </button>
                <button type="button" @click="$dispatch('close-panel-form-karyawan')" class="px-10 py-5 bg-slate-100 text-slate-400 rounded-[28px] font-black text-xs uppercase tracking-[0.2em] hover:bg-red-50 hover:text-red-500 transition-all">BATAL</button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>
