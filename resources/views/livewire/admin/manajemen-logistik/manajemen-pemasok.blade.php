<div class="animate-in fade-in duration-500 pb-20">
    
    @if(!$tampilkanForm)
        <!-- TAMPILAN 1: DIREKTORI VENDOR (FULL PAGE LIST) -->
        <div class="space-y-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="space-y-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                        <span class="text-[9px] font-black text-orange-600 uppercase tracking-widest">Hulu Rantai Pasok</span>
                    </div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Manajemen Pemasok</h1>
                    <p class="text-slate-500 font-medium">Otoritas kendali mitra vendor dan ketersediaan aset teknologi.</p>
                </div>
                <button wire:click="tambahBaru" class="flex items-center gap-3 px-8 py-4 bg-orange-600 hover:bg-orange-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-orange-600/20 transition-all active:scale-95">
                    <i class="fa-solid fa-handshake-angle text-lg"></i> AKTIVASI VENDOR BARU
                </button>
            </div>

            <!-- Toolbar Search -->
            <div class="bg-white p-4 rounded-[30px] border border-indigo-50 flex items-center px-6 gap-4 shadow-sm">
                <i class="fa-solid fa-magnifying-glass text-slate-300"></i>
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari nama instansi atau perusahaan..." class="flex-1 bg-transparent border-none text-sm font-bold text-slate-700 focus:ring-0 placeholder:text-slate-300">
            </div>

            <!-- Vendor Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($daftar_pemasok as $vendor)
                <div class="group bg-white rounded-[45px] p-8 border border-slate-100 shadow-sm hover:shadow-2xl hover:border-orange-200 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-32 h-32 bg-orange-50 rounded-full opacity-0 group-hover:opacity-100 transition-all group-hover:scale-110"></div>
                    
                    <div class="relative z-10 flex flex-col h-full justify-between space-y-6">
                        <div class="flex justify-between items-start">
                            <div class="w-16 h-16 rounded-3xl bg-slate-50 flex items-center justify-center text-2xl font-black text-slate-300 border border-slate-100 group-hover:bg-orange-100 group-hover:text-orange-600 transition-colors">
                                {{ substr($vendor->nama_perusahaan, 0, 1) }}
                            </div>
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $vendor->status === 'aktif' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-rose-50 text-rose-600 border-rose-100' }}">
                                {{ $vendor->status }}
                            </span>
                        </div>

                        <div>
                            <h3 class="font-black text-xl text-slate-800 tracking-tight leading-tight group-hover:text-orange-600 transition-colors">{{ $vendor->nama_perusahaan }}</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">{{ $vendor->kode_pemasok }}</p>
                        </div>

                        <div class="space-y-3 pt-6 border-t border-slate-50">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-user-tie text-slate-300 text-xs w-4"></i>
                                <span class="text-xs font-bold text-slate-600">{{ $vendor->penanggung_jawab }} (PIC)</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-phone-volume text-slate-300 text-xs w-4"></i>
                                <span class="text-xs font-bold text-slate-600">{{ $vendor->telepon }}</span>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button wire:click="edit({{ $vendor->id }})" class="flex-1 py-3 bg-slate-50 text-slate-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-600 hover:text-white transition-all shadow-sm">PROFIL LENGKAP</button>
                            <button wire:click="hapus({{ $vendor->id }})" wire:confirm="Putuskan kemitraan dengan vendor ini?" class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center bg-white rounded-[50px] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-building-circle-exclamation text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Belum Ada Vendor</h3>
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Segera registrasikan mitra pemasok untuk memperkuat inventaris Anda.</p>
                </div>
                @endforelse
            </div>

            <div class="pt-10">
                {{ $daftar_pemasok->links() }}
            </div>
        </div>
    @else
        <!-- TAMPILAN 2: PROFIL EDITOR VENDOR (FULL PAGE FORM) -->
        <div class="space-y-8 animate-in slide-in-from-right-8 duration-500">
            <!-- Header Editor -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="flex items-center gap-6">
                    <button wire:click="batal" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                    </button>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">{{ $pemasok_id ? 'Pembaruan Data Vendor' : 'Registrasi Vendor Baru' }}</h1>
                        <p class="text-slate-500 font-medium text-[10px] uppercase tracking-widest">Sistem Administrasi Rantai Pasok v16.0</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-3xl text-sm font-black hover:bg-slate-100 transition-all">BATAL</button>
                    <button wire:click="simpan" class="px-10 py-4 bg-orange-600 hover:bg-orange-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-orange-600/20 transition-all active:scale-95">SIMPAN KEMITRAAN</button>
                </div>
            </div>

            <!-- Editor Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kolom Kiri: Data Administrasi -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10">
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Nama Instansi / Perusahaan</label>
                                <input wire:model="nama_perusahaan" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-orange-500/10 placeholder:text-slate-300" placeholder="Masukkan nama resmi perusahaan...">
                                @error('nama_perusahaan') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Kode Vendor (Unik)</label>
                                    <input wire:model="kode_pemasok" type="text" class="w-full bg-slate-100 border-none rounded-2xl px-6 py-4 text-sm font-black text-orange-600 focus:ring-0 uppercase font-mono" readonly>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Status Kerjasama</label>
                                    <select wire:model="status" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-orange-500/10">
                                        <option value="aktif">🟢 AKTIF BEROPERASI</option>
                                        <option value="nonaktif">❌ DINONAKTIFKAN</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 pt-8 border-t border-slate-50">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Alamat Kantor Pusat</label>
                            <textarea wire:model="alamat" rows="4" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-6 text-sm font-bold text-slate-600 focus:ring-4 focus:ring-orange-500/10 placeholder:text-slate-300" placeholder="Tuliskan alamat lengkap untuk keperluan pengiriman..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Kontak & PIC -->
                <div class="space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Penanggung Jawab (PIC)</label>
                                <input wire:model="penanggung_jawab" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-orange-500/10" placeholder="Nama lengkap PIC...">
                                @error('penanggung_jawab') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Telepon / WhatsApp</label>
                                <input wire:model="telepon" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-orange-500/10" placeholder="+62...">
                                @error('telepon') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Email Korespondensi</label>
                                <input wire:model="email" type="email" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-orange-500/10" placeholder="vendor@email.com">
                                @error('email') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Peringatan Kepatuhan -->
                    <div class="bg-orange-500 p-10 rounded-[50px] text-white shadow-2xl shadow-orange-500/30 space-y-4 relative overflow-hidden group">
                        <i class="fa-solid fa-shield-halved text-4xl opacity-20 absolute -right-4 -top-4 group-hover:scale-150 transition-transform duration-1000"></i>
                        <h4 class="text-lg font-black uppercase tracking-tight">Kepatuhan Vendor</h4>
                        <p class="text-xs font-bold text-orange-50 leading-relaxed opacity-90">
                            "Seluruh data vendor harus diverifikasi secara periodik untuk memastikan validitas dokumen legalitas perusahaan."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
