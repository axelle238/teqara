<div class="animate-in fade-in slide-in-from-right-8 duration-500 pb-20">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Tim <span class="text-purple-600">Internal</span></h1>
            <p class="text-slate-500 font-medium text-sm mt-1">Kelola akses, peran, dan data personil perusahaan.</p>
        </div>
        
        @if(!$tambahMode)
        <button wire:click="$set('tambahMode', true)" class="px-8 py-4 bg-purple-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-purple-700 shadow-xl shadow-purple-500/30 transition-all active:scale-95">
            <i class="fa-solid fa-user-plus mr-2"></i> Tambah Staf
        </button>
        @endif
    </div>

    @if($tambahMode)
    <div class="bg-white rounded-[40px] p-10 border border-purple-50 shadow-xl mb-10 animate-in slide-in-from-top-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-purple-50 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest">Formulir Rekrutmen Digital</h3>
                <button wire:click="$set('tambahMode', false)" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form wire:submit.prevent="simpan" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Data Akun -->
                <div class="space-y-6">
                    <h4 class="text-xs font-black text-purple-600 uppercase tracking-widest border-b border-purple-100 pb-2">Akses Sistem</h4>
                    
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Lengkap</label>
                        <input wire:model="nama" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 placeholder:text-slate-300">
                        @error('nama') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Perusahaan</label>
                        <input wire:model="email" type="email" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 placeholder:text-slate-300">
                        @error('email') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Peran (Role)</label>
                            <select wire:model="peran" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 cursor-pointer">
                                <option value="admin">Administrator</option>
                                <option value="editor">Editor Konten</option>
                                <option value="cs">Customer Service</option>
                                <option value="gudang">Staf Logistik</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Password</label>
                            <input wire:model="password" type="password" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 placeholder:text-slate-300">
                            @error('password') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Kepegawaian -->
                <div class="space-y-6">
                    <h4 class="text-xs font-black text-purple-600 uppercase tracking-widest border-b border-purple-100 pb-2">Data Kepegawaian</h4>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">NIP (Nomor Induk)</label>
                            <input wire:model="nip" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-mono font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 uppercase">
                            @error('nip') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Status</label>
                            <select wire:model="status_karyawan" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 cursor-pointer">
                                <option value="tetap">Karyawan Tetap</option>
                                <option value="kontrak">Kontrak</option>
                                <option value="magang">Magang</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nomor Telepon</label>
                        <input wire:model="telepon" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Jabatan & Posisi</label>
                        <select wire:model="jabatan_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 cursor-pointer">
                            <option value="">Pilih Jabatan</option>
                            @foreach($daftarJabatan as $jabatan)
                                <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="md:col-span-2 pt-4 flex justify-end gap-4 border-t border-slate-50 mt-4">
                    <button type="button" wire:click="$set('tambahMode', false)" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-100 transition-all">Batal</button>
                    <button type="submit" class="px-10 py-4 bg-purple-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-purple-700 shadow-lg shadow-purple-500/20 transition-all active:scale-95">
                        Simpan Data Karyawan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Staff Grid (ID Card Style) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @foreach($karyawan as $staff)
        <div class="bg-white rounded-[40px] p-1 border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-500 group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-indigo-500/5 rounded-[40px] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            
            <div class="relative z-10 bg-white rounded-[36px] p-8 h-full flex flex-col">
                <!-- Header Card -->
                <div class="flex justify-between items-start mb-6">
                    <div class="w-20 h-20 rounded-[2rem] bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-2xl font-black text-slate-400 uppercase shadow-inner border border-white">
                        {{ substr($staff->nama_lengkap, 0, 2) }}
                    </div>
                    <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest border {{ $staff->status_karyawan == 'tetap' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100' }}">
                        {{ $staff->status_karyawan }}
                    </span>
                </div>

                <!-- Info -->
                <div class="space-y-1 mb-6">
                    <h4 class="text-xl font-black text-slate-900 group-hover:text-purple-600 transition-colors">{{ $staff->nama_lengkap }}</h4>
                    <p class="text-xs font-bold text-slate-500">{{ $staff->jabatan->nama_jabatan ?? 'Belum Ada Jabatan' }}</p>
                    <p class="text-[10px] font-mono text-slate-400 bg-slate-50 inline-block px-2 py-1 rounded-lg mt-2">NIP: {{ $staff->nip }}</p>
                </div>

                <!-- Details -->
                <div class="space-y-3 mt-auto pt-6 border-t border-slate-50">
                    <div class="flex items-center gap-3 text-xs font-medium text-slate-500">
                        <i class="fa-solid fa-envelope w-4 text-center text-purple-400"></i>
                        <span class="truncate">{{ $staff->pengguna->email }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs font-medium text-slate-500">
                        <i class="fa-solid fa-phone w-4 text-center text-purple-400"></i>
                        <span>{{ $staff->pengguna->nomor_telepon ?? '-' }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs font-medium text-slate-500">
                        <i class="fa-solid fa-calendar w-4 text-center text-purple-400"></i>
                        <span>Sejak {{ \Carbon\Carbon::parse($staff->tanggal_bergabung)->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- Actions (Hover Only) -->
                @if($staff->pengguna_id != auth()->id())
                <div class="absolute top-6 right-6 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0">
                    <button wire:click="hapus({{ $staff->pengguna_id }})" wire:confirm="Nonaktifkan akses karyawan ini?" class="w-10 h-10 rounded-full bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white flex items-center justify-center transition-all shadow-sm">
                        <i class="fa-solid fa-user-xmark"></i>
                    </button>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $karyawan->links() }}
    </div>
</div>
