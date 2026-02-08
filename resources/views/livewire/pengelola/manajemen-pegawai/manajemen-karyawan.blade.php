<div class="space-y-8 animate-in fade-in duration-500 pb-32">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Direktori <span class="text-sky-600">Personil</span></h1>
            <p class="text-slate-500 font-bold text-[10px] uppercase tracking-widest mt-1">Kelola Akses & Data Karyawan</p>
        </div>
        <div class="flex flex-wrap gap-3 w-full md:w-auto">
            <div class="relative flex-1 md:flex-none">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Nama atau NIP..." class="w-full md:w-64 pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-xs font-bold focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all shadow-sm">
            </div>
            <button wire:click="tambahBaru" class="px-6 py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-sky-600 transition-all shadow-lg flex items-center gap-2">
                <i class="fa-solid fa-user-plus"></i> Tambah Baru
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- KOLOM KIRI: LIST KARYAWAN -->
        <div class="lg:col-span-2 space-y-4">
            @forelse($karyawan as $k)
            <div wire:click="edit({{ $k->id }})" class="group bg-white rounded-[2rem] p-5 border border-slate-100 shadow-sm hover:shadow-xl hover:border-sky-200 transition-all cursor-pointer relative overflow-hidden {{ $karyawanId === $k->id ? 'ring-4 ring-sky-500/10 border-sky-500' : '' }}">
                <div class="flex items-center gap-5">
                    <!-- Avatar -->
                    <div class="w-16 h-16 rounded-2xl bg-sky-50 flex items-center justify-center text-sky-600 text-2xl font-black shadow-inner flex-shrink-0 group-hover:scale-110 transition-transform">
                        {{ substr($k->nama_lengkap, 0, 1) }}
                    </div>
                    
                    <!-- Info Utama -->
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-base font-black text-slate-900 truncate">{{ $k->nama_lengkap }}</h3>
                                <p class="text-xs text-slate-500 font-medium truncate mt-0.5">
                                    {{ $k->jabatan->nama ?? 'Tanpa Jabatan' }} • <span class="text-sky-600">{{ $k->jabatan->departemen->nama ?? '-' }}</span>
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $k->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $k->status }}
                            </span>
                        </div>
                        
                        <!-- Detail Tambahan -->
                        <div class="flex items-center gap-4 mt-3 pt-3 border-t border-slate-50">
                            <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded">NIP: {{ $k->nip }}</span>
                            <span class="text-[10px] font-bold text-slate-400"><i class="fa-solid fa-phone text-sky-400 mr-1"></i> {{ $k->telepon ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="py-20 text-center bg-white border-2 border-dashed border-slate-200 rounded-[3rem]">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-2xl"><i class="fa-solid fa-users-slash"></i></div>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Tidak ada data karyawan.</p>
            </div>
            @endforelse

            <div class="pt-4">
                {{ $karyawan->links() }}
            </div>
        </div>

        <!-- KOLOM KANAN: FORM EDITOR -->
        <div class="lg:col-span-1 relative">
            @if($tampilkanForm)
            <div class="sticky top-24 bg-white rounded-[2.5rem] border border-sky-100 shadow-2xl p-8 animate-in slide-in-from-right duration-500 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-sky-500 to-indigo-500"></div>
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">{{ $karyawanId ? 'Edit Data' : 'Rekrutmen Baru' }}</h3>
                    <button wire:click="batal" class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-500 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="space-y-5 max-h-[70vh] overflow-y-auto custom-scrollbar pr-2">
                    <!-- Data Akun -->
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-4">
                        <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-200 pb-2">Informasi Login</h4>
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-slate-500 uppercase">Nama Lengkap</label>
                            <input type="text" wire:model="nama" class="w-full bg-white border-none rounded-xl px-3 py-2 text-xs font-bold focus:ring-2 focus:ring-sky-500/20">
                            @error('nama') <span class="text-rose-500 text-[9px] font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-slate-500 uppercase">Email Perusahaan</label>
                            <input type="email" wire:model="email" class="w-full bg-white border-none rounded-xl px-3 py-2 text-xs font-bold focus:ring-2 focus:ring-sky-500/20">
                            @error('email') <span class="text-rose-500 text-[9px] font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-500 uppercase">Role Akses</label>
                                <select wire:model="peran" class="w-full bg-white border-none rounded-xl px-3 py-2 text-xs font-bold focus:ring-2 focus:ring-sky-500/20 cursor-pointer">
                                    <option value="admin">Administrator</option>
                                    <option value="staf">Staff Gudang</option>
                                    <option value="kasir">Kasir Toko</option>
                                    <option value="manajer">Manajer</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-500 uppercase">Password</label>
                                <input type="password" wire:model="password" class="w-full bg-white border-none rounded-xl px-3 py-2 text-xs font-bold focus:ring-2 focus:ring-sky-500/20" placeholder="{{ $karyawanId ? '(Biarkan kosong)' : 'Min. 8 Karakter' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Data Kepegawaian -->
                    <div class="bg-white p-4 rounded-2xl border border-slate-100 space-y-4 shadow-sm">
                        <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2">Data Kepegawaian</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-500 uppercase">NIP</label>
                                <input type="text" wire:model="nip" class="w-full bg-slate-50 border-none rounded-xl px-3 py-2 text-xs font-bold focus:ring-2 focus:ring-sky-500/20">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-500 uppercase">Jabatan</label>
                                <select wire:model="jabatan_id" class="w-full bg-slate-50 border-none rounded-xl px-3 py-2 text-xs font-bold focus:ring-2 focus:ring-sky-500/20 cursor-pointer">
                                    <option value="">Pilih Jabatan</option>
                                    @foreach($daftarJabatan as $j)
                                        <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-slate-500 uppercase">Status & Kontrak</label>
                            <div class="flex gap-3">
                                <select wire:model="status_kerja" class="flex-1 bg-slate-50 border-none rounded-xl px-3 py-2 text-xs font-bold">
                                    <option value="tetap">Tetap</option>
                                    <option value="kontrak">Kontrak</option>
                                    <option value="magang">Magang</option>
                                </select>
                                <select wire:model="status_aktif" class="flex-1 bg-slate-50 border-none rounded-xl px-3 py-2 text-xs font-bold">
                                    <option value="aktif">Aktif</option>
                                    <option value="cuti">Cuti</option>
                                    <option value="keluar">Resign</option>
                                </select>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-slate-500 uppercase">Telepon & Kontak</label>
                            <input type="text" wire:model="telepon" class="w-full bg-slate-50 border-none rounded-xl px-3 py-2 text-xs font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-slate-500 uppercase">Alamat Domisili</label>
                            <textarea wire:model="alamat" rows="2" class="w-full bg-slate-50 border-none rounded-xl px-3 py-2 text-xs font-bold"></textarea>
                        </div>
                    </div>

                    <div class="pt-4 flex gap-3">
                        @if($karyawanId)
                        <button wire:click="hapus({{ $karyawanId }})" wire:confirm="Hapus permanen data karyawan beserta akun loginnya?" class="px-4 py-3 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        @endif
                        <button wire:click="simpan" class="flex-1 py-3 bg-sky-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-sky-700 shadow-lg transition-all">
                            Simpan Data
                        </button>
                    </div>
                </div>
            </div>
            @else
            <div class="sticky top-24 bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200 p-10 text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-3xl text-slate-300">
                    <i class="fa-solid fa-user-pen"></i>
                </div>
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">Detail Personil</h3>
                <p class="text-xs text-slate-400 mt-1">Pilih karyawan dari daftar untuk melihat atau mengubah data.</p>
            </div>
            @endif
        </div>

    </div>
</div>