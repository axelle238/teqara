<div class="animate-in fade-in duration-500 pb-20">
    
    @if(!$tampilkanForm)
        <!-- TAMPILAN 1: DIREKTORI PEGAWAI (FULL PAGE LIST) -->
        <div class="space-y-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="space-y-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                        <span class="text-[9px] font-black text-sky-600 uppercase tracking-widest">Manajemen SDM Enterprise</span>
                    </div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Direktori Pegawai</h1>
                    <p class="text-slate-500 font-medium text-sm uppercase tracking-widest">Otoritas kendali personil dan struktur organisasi Teqara.</p>
                </div>
                <button wire:click="tambahBaru" class="flex items-center gap-3 px-8 py-4 bg-sky-600 hover:bg-sky-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-sky-600/20 transition-all active:scale-95">
                    <i class="fa-solid fa-user-plus text-lg"></i> ONBOARDING STAF
                </button>
            </div>

            <!-- Toolbar & Search -->
            <div class="bg-white p-6 rounded-[35px] border border-indigo-50 flex flex-col md:flex-row gap-6 justify-between items-center shadow-sm">
                <div class="flex gap-4 w-full md:w-auto">
                    <div class="relative flex-1 md:w-80">
                        <i class="fa-solid fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Nama atau NIP..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-sky-500/10 placeholder:text-slate-300">
                    </div>
                    <select wire:model.live="filter_departemen" class="bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-600 focus:ring-4 focus:ring-sky-500/10 cursor-pointer">
                        <option value="">SEMUA DEPARTEMEN</option>
                        @foreach($departemen as $dept)
                            <option value="{{ $dept->id }}">{{ strtoupper($dept->nama) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Grid Pegawai -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">
                @forelse($karyawan as $k)
                <div class="group bg-white rounded-[45px] p-8 border border-slate-100 shadow-sm hover:shadow-2xl hover:border-sky-200 transition-all duration-500 relative text-center">
                    <div class="absolute top-6 right-6 flex flex-col gap-2">
                        <button wire:click="edit({{ $k->id }})" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-sky-100 hover:text-sky-600 flex items-center justify-center transition-all shadow-sm">
                            <i class="fa-solid fa-user-pen text-sm"></i>
                        </button>
                    </div>

                    <div class="relative inline-block mb-6">
                        <div class="w-24 h-24 rounded-[35px] bg-slate-50 border-4 border-white shadow-lg overflow-hidden mx-auto flex items-center justify-center text-3xl font-black text-slate-300 group-hover:bg-sky-50 group-hover:text-sky-600 transition-all duration-500">
                            @if($k->foto)
                                <img src="{{ asset($k->foto) }}" class="w-full h-full object-cover">
                            @else
                                {{ substr($k->nama_lengkap, 0, 1) }}
                            @endif
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-8 h-8 rounded-2xl border-4 border-white shadow-md {{ $k->status === 'aktif' ? 'bg-emerald-400' : 'bg-rose-400' }}"></div>
                    </div>

                    <div class="space-y-2">
                        <h3 class="font-black text-lg text-slate-800 leading-tight line-clamp-1 group-hover:text-sky-600 transition-colors uppercase">{{ $k->nama_lengkap }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">{{ $k->nip }}</p>
                    </div>

                    <div class="mt-6 pt-6 border-t border-slate-50 space-y-4">
                        <span class="inline-block px-4 py-1.5 rounded-xl bg-sky-50 text-sky-700 text-[10px] font-black uppercase tracking-widest border border-sky-100">
                            {{ $k->jabatan->nama ?? 'Staff' }}
                        </span>
                        <div class="flex justify-center gap-3">
                            <a href="mailto:{{ $k->email }}" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 flex items-center justify-center transition-all">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                            <a href="tel:{{ $k->telepon }}" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 flex items-center justify-center transition-all">
                                <i class="fa-solid fa-phone"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center bg-white rounded-[50px] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-users-slash text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Direktori Kosong</h3>
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Belum ada personil yang terdaftar dalam basis data perusahaan.</p>
                </div>
                @endforelse
            </div>

            <div class="pt-10">
                {{ $karyawan->links() }}
            </div>
        </div>
    @else
        <!-- TAMPILAN 2: EDITOR PROFIL PEGAWAI (FULL PAGE FORM) -->
        <div class="space-y-8 animate-in slide-in-from-right-8 duration-500">
            <!-- Header Editor -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="flex items-center gap-6">
                    <button wire:click="batal" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                    </button>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">{{ $karyawan_id ? 'Sunting Profil Staf' : 'Onboarding Personil' }}</h1>
                        <p class="text-slate-500 font-medium uppercase tracking-widest text-[10px]">Administrasi Sumber Daya Manusia Teqara</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-3xl text-sm font-black hover:bg-slate-100 transition-all">BATAL</button>
                    <button wire:click="simpan" class="px-10 py-4 bg-sky-600 hover:bg-sky-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-sky-600/20 transition-all active:scale-95">SIMPAN PROFIL</button>
                </div>
            </div>

            <!-- Form Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kolom Kiri: Data Profesional -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Nama Lengkap Sesuai Identitas</label>
                                <input wire:model="nama_lengkap" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-sky-500/10 placeholder:text-slate-300" placeholder="Masukkan nama tanpa gelar...">
                                @error('nama_lengkap') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Nomor Induk Pegawai (NIP)</label>
                                <input wire:model="nip" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-sky-600 focus:ring-4 focus:ring-sky-500/10 uppercase font-mono" placeholder="TEQ-2024-XXX">
                                @error('nip') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-slate-50">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Posisi Jabatan Korporat</label>
                                <select wire:model="jabatan_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-sky-500/10">
                                    <option value="">PILIH POSISI</option>
                                    @foreach($departemen as $dept)
                                        <optgroup label="{{ strtoupper($dept->nama) }}">
                                            @foreach($dept->jabatan as $jab)
                                                <option value="{{ $jab->id }}">{{ strtoupper($jab->nama) }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('jabatan_id') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Tanggal Mulai Bergabung</label>
                                <input wire:model="tanggal_bergabung" type="date" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-sky-500/10">
                            </div>
                        </div>

                        <div class="space-y-2 pt-8 border-t border-slate-50">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Alamat Domisili Resmi</label>
                            <textarea wire:model="alamat" rows="4" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-6 text-sm font-bold text-slate-600 focus:ring-4 focus:ring-sky-500/10 placeholder:text-slate-300" placeholder="Tuliskan alamat lengkap sesuai KTP/Domisili..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Kontak & Akses -->
                <div class="space-y-8">
                    <!-- Kartu Kontak -->
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Email Korporat</label>
                                <input wire:model="email" type="email" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-sky-500/10" placeholder="nama@teqara.com">
                                @error('email') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Telepon / WhatsApp</label>
                                <input wire:model="telepon" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-sky-500/10" placeholder="+62...">
                            </div>
                        </div>

                        <div class="space-y-4 pt-8 border-t border-slate-50">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Status Kepegawaian</label>
                            <select wire:model="status" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-sky-500/10">
                                <option value="aktif">🟢 AKTIF BERKERJA</option>
                                <option value="cuti">🟡 SEDANG CUTI</option>
                                <option value="nonaktif">🔴 NON-AKTIF / RESIGN</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kartu Akses Sistem -->
                    @if(!$karyawan_id)
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-6">
                        <label class="flex items-start gap-4 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" wire:model="buat_akun_pengguna" class="peer sr-only">
                                <div class="w-12 h-6 bg-slate-200 rounded-full transition-all peer-checked:bg-sky-500"></div>
                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-6"></div>
                            </div>
                            <div class="flex-1">
                                <span class="block text-xs font-black text-slate-800 uppercase tracking-widest">Aktivasi Akun Sistem</span>
                                <span class="block text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Berikan akses Login Dashboard</span>
                            </div>
                        </label>
                        @if($buat_akun_pengguna)
                            <div class="bg-sky-50 p-6 rounded-3xl border border-sky-100 animate-in zoom-in duration-300">
                                <p class="text-[10px] font-black text-sky-600 uppercase tracking-[0.2em] mb-2">Password Default</p>
                                <p class="text-lg font-black text-sky-900 font-mono tracking-wider">{{ $password_default }}</p>
                            </div>
                        @endif
                    </div>
                    @endif

                    <!-- Peringatan Keamanan -->
                    <div class="bg-sky-600 p-10 rounded-[50px] text-white shadow-2xl shadow-sky-600/30 space-y-4 relative overflow-hidden group">
                        <i class="fa-solid fa-fingerprint text-4xl opacity-20 absolute -right-4 -top-4 group-hover:scale-150 transition-transform duration-1000"></i>
                        <h4 class="text-lg font-black uppercase tracking-tight">Otoritas SDM</h4>
                        <p class="text-xs font-bold text-sky-50 leading-relaxed opacity-90">
                            "Setiap perubahan data profil staf akan dicatat dalam Jejak Audit sistem untuk transparansi operasional perusahaan."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
