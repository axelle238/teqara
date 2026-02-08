<div class="space-y-8 animate-in fade-in duration-500 pb-32" x-data="{ modeTampilan: 'grid' }">
    
    <!-- HEADER & TOOLBAR -->
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Direktori <span class="text-orange-600">Mitra</span></h1>
            <p class="text-slate-500 font-bold text-[10px] uppercase tracking-widest mt-1">Database Pemasok & Vendor Terverifikasi</p>
        </div>
        <div class="flex flex-wrap gap-3 w-full xl:w-auto">
            <div class="relative flex-1 xl:flex-none">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Nama atau Kode..." class="w-full xl:w-72 pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-xs font-bold focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all shadow-sm">
            </div>
            <button wire:click="tambahBaru" class="px-6 py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-600 transition-all shadow-lg flex items-center gap-2">
                <i class="fa-solid fa-plus-circle"></i> Tambah Mitra
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- KOLOM KIRI: DAFTAR VENDOR -->
        <div class="lg:col-span-2 space-y-6">
            @forelse($daftar_pemasok as $vendor)
            <div wire:click="edit({{ $vendor->id }})" class="group bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:border-orange-200 transition-all cursor-pointer relative overflow-hidden {{ $pemasokId === $vendor->id ? 'ring-4 ring-orange-500/10 border-orange-500' : '' }}">
                <div class="absolute top-0 right-0 w-24 h-24 bg-slate-50 rounded-bl-[3rem] -mr-4 -mt-4 transition-colors group-hover:bg-orange-50"></div>
                
                <div class="flex items-start gap-6 relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 text-slate-500 flex items-center justify-center text-2xl shadow-inner group-hover:from-orange-500 group-hover:to-red-500 group-hover:text-white transition-all">
                        {{ substr($vendor->nama_perusahaan, 0, 1) }}
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="px-2 py-1 rounded text-[8px] font-black uppercase tracking-widest bg-slate-100 text-slate-500 mb-2 inline-block">
                                    {{ $vendor->kode_pemasok }}
                                </span>
                                <h3 class="text-lg font-black text-slate-900 truncate group-hover:text-orange-600 transition-colors">{{ $vendor->nama_perusahaan }}</h3>
                                <p class="text-xs text-slate-500 font-medium truncate mt-1">PIC: {{ $vendor->penanggung_jawab ?? '-' }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $vendor->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $vendor->status }}
                            </span>
                        </div>

                        <div class="flex items-center gap-4 mt-4 pt-4 border-t border-slate-50">
                            @if($vendor->telepon)
                            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 group-hover:text-slate-600">
                                <i class="fa-solid fa-phone text-orange-400"></i> {{ $vendor->telepon }}
                            </div>
                            @endif
                            @if($vendor->email)
                            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 group-hover:text-slate-600">
                                <i class="fa-solid fa-envelope text-orange-400"></i> {{ $vendor->email }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="py-20 text-center bg-white border-2 border-dashed border-slate-200 rounded-[3rem]">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-2xl"><i class="fa-solid fa-building-circle-xmark"></i></div>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Tidak ada mitra ditemukan.</p>
            </div>
            @endforelse

            <div class="pt-4">
                {{ $daftar_pemasok->links() }}
            </div>
        </div>

        <!-- KOLOM KANAN: FORM EDITOR (STICKY) -->
        <div class="lg:col-span-1 relative">
            @if($tampilkanForm)
            <div class="sticky top-24 bg-white rounded-[2.5rem] border border-orange-100 shadow-2xl p-8 animate-in slide-in-from-right duration-500 relative overflow-hidden">
                <!-- Decor -->
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-orange-500 to-red-500"></div>
                
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">{{ $pemasokId ? 'Edit Mitra' : 'Mitra Baru' }}</h3>
                    <button wire:click="batal" class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-500 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="space-y-5">
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Kode Vendor</label>
                        <input type="text" wire:model="kode_pemasok" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-black text-slate-700 uppercase tracking-widest focus:ring-2 focus:ring-orange-500/20" placeholder="AUTO-GEN">
                        @error('kode_pemasok') <span class="text-rose-500 text-[9px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Nama Perusahaan</label>
                        <input type="text" wire:model="nama_perusahaan" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-orange-500/20" placeholder="PT. Teknologi Maju">
                        @error('nama_perusahaan') <span class="text-rose-500 text-[9px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">PIC</label>
                            <input type="text" wire:model="penanggung_jawab" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-orange-500/20" placeholder="Nama Kontak">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Telepon</label>
                            <input type="text" wire:model="telepon" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-orange-500/20" placeholder="0812...">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Email Bisnis</label>
                        <input type="email" wire:model="email" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-orange-500/20" placeholder="contact@vendor.com">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Alamat Lengkap</label>
                        <textarea wire:model="alamat" rows="3" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-medium focus:ring-2 focus:ring-orange-500/20" placeholder="Alamat kantor..."></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Status Kerjasama</label>
                        <select wire:model="status" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-orange-500/20 cursor-pointer">
                            <option value="aktif">🟢 AKTIF - BISA ORDER</option>
                            <option value="nonaktif">🔴 NONAKTIF - DIBEKUKAN</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex gap-3">
                        @if($pemasokId)
                        <button wire:click="hapus({{ $pemasokId }})" wire:confirm="Hapus permanen data vendor ini?" class="px-4 py-3 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        @endif
                        <button wire:click="simpan" class="flex-1 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-orange-600 shadow-lg transition-all">
                            <i class="fa-solid fa-save mr-2"></i> Simpan Data
                        </button>
                    </div>
                </div>
            </div>
            @else
            <div class="sticky top-24 bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200 p-10 text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-3xl text-slate-300">
                    <i class="fa-solid fa-hand-pointer"></i>
                </div>
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">Pilih Mitra</h3>
                <p class="text-xs text-slate-400 mt-1">Klik pada kartu di kiri untuk melihat detail atau mengedit.</p>
            </div>
            @endif
        </div>

    </div>
</div>