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

    <!-- Karyawan Table: No Dark Policy -->
    <div class="bg-white rounded-[56px] border border-indigo-50 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-indigo-50 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-slate-50/30">
            <div class="relative w-full md:w-96 group">
                <input 
                    wire:model.live.debounce.300ms="cari" 
                    type="text" 
                    placeholder="Cari NIP atau Nama..." 
                    class="w-full pl-12 pr-4 py-4 bg-white border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-rose-500 shadow-sm transition-all"
                >
                <svg class="w-5 h-5 absolute left-4 top-4 text-slate-300 group-focus-within:text-rose-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white border-b border-slate-50">
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Identitas (NIP)</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Profil Pegawai</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Penugasan</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Status Kerja</th>
                        <th class="px-10 py-6 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-50">
                    @forelse($karyawan as $k)
                    <tr class="group hover:bg-rose-50/20 transition-all duration-300">
                        <td class="px-10 py-6">
                            <span class="text-sm font-black text-rose-600 tracking-widest uppercase">{{ $k->nip }}</span>
                            <p class="text-[9px] text-slate-400 font-bold mt-1 uppercase">Gabung: {{ $k->tanggal_bergabung->format('d M Y') }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-[16px] bg-indigo-50 flex items-center justify-center font-black text-indigo-600 shadow-sm group-hover:scale-110 transition-transform">
                                    {{ substr($k->pengguna->nama, 0, 1) }}
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-sm font-black text-slate-900 uppercase">{{ $k->pengguna->nama }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 lowercase">{{ $k->pengguna->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-sm font-black text-slate-900 uppercase tracking-tight">{{ $k->jabatan->nama }}</p>
                            <p class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest mt-1">{{ $k->jabatan->departemen->nama }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $k->status_kerja === 'tetap' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                                {{ $k->status_kerja }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <button class="p-3 bg-white border border-indigo-50 text-indigo-400 hover:text-white hover:bg-indigo-600 rounded-2xl transition-all shadow-sm opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-32 text-center">
                            <div class="text-6xl mb-6">🤝</div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tighter uppercase mb-2">Data Kosong</h3>
                            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Belum ada pegawai yang terdaftar dalam manifest radar.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-10 bg-slate-50/30 border-t border-slate-50 flex justify-center">
            {{ $karyawan->links() }}
        </div>
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
