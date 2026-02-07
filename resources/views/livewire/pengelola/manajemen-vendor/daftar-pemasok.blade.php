<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Direktori <span class="text-yellow-500">Mitra</span></h1>
            <p class="text-slate-500 font-medium">Jaringan pemasok dan vendor teknologi terverifikasi.</p>
        </div>
        
        @if(!$tampilkanForm)
        <button wire:click="tambahBaru" class="flex items-center gap-3 px-6 py-3 bg-yellow-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-yellow-600 transition-all shadow-lg shadow-yellow-500/20 active:scale-95">
            <i class="fa-solid fa-plus"></i> Tambah Mitra
        </button>
        @endif
    </div>

    @if($tampilkanForm)
    <!-- INLINE FORM -->
    <div class="bg-white rounded-[40px] p-8 md:p-10 border border-indigo-50 shadow-xl shadow-indigo-500/5 animate-in slide-in-from-top-4 duration-500 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-50 rounded-full blur-3xl -mr-20 -mt-20 opacity-50"></div>
        
        <div class="relative z-10">
            <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-8">{{ $pemasokId ? 'Sunting Data Mitra' : 'Registrasi Mitra Baru' }}</h2>
            
            <form wire:submit.prevent="simpan" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama Perusahaan</label>
                        <input wire:model.live="nama_perusahaan" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-yellow-500/10 transition-all" placeholder="Cth: PT. Teknologi Indonesia">
                        @error('nama_perusahaan') <span class="text-[10px] font-bold text-rose-500 mt-1 block px-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Kode Vendor</label>
                            <input wire:model="kode_pemasok" type="text" class="w-full bg-slate-100 border-none rounded-2xl px-6 py-4 text-sm font-mono text-slate-500 focus:ring-4 focus:ring-yellow-500/10 transition-all uppercase">
                            @error('kode_pemasok') <span class="text-[10px] font-bold text-rose-500 mt-1 block px-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Status Kemitraan</label>
                            <select wire:model="status" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-yellow-500/10 transition-all cursor-pointer">
                                <option value="aktif">AKTIF</option>
                                <option value="nonaktif">NONAKTIF</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Alamat Kantor</label>
                        <textarea wire:model="alamat" rows="3" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-medium text-slate-600 focus:ring-4 focus:ring-yellow-500/10 transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Person in Charge (PIC)</label>
                        <input wire:model="penanggung_jawab" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-yellow-500/10 transition-all" placeholder="Nama lengkap penanggung jawab">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nomor Telepon</label>
                            <input wire:model="telepon" type="tel" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-yellow-500/10 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Alamat Email</label>
                            <input wire:model="email" type="email" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-yellow-500/10 transition-all">
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 flex justify-end gap-4 mt-4">
                    <button type="button" wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-100 transition-all">Batal</button>
                    <button type="submit" class="px-10 py-4 bg-yellow-500 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-yellow-600/20 hover:bg-yellow-600 transition-all active:scale-95">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Mitra
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Filter Bar -->
    <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm">
        <div class="relative w-full md:w-96">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-search"></i>
            </div>
            <input wire:model.live.debounce.300ms="cari" type="text" class="w-full pl-11 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-yellow-500 transition-all" placeholder="Cari Perusahaan / Kode Vendor...">
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden relative min-h-[400px]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="px-8 py-6">Profil Perusahaan</th>
                        <th class="px-8 py-6">Kontak PIC</th>
                        <th class="px-8 py-6">Lokasi</th>
                        <th class="px-8 py-6 text-center">Status</th>
                        <th class="px-8 py-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($daftar_pemasok as $p)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center text-yellow-600 font-black text-xl shadow-sm">
                                    {{ substr($p->nama_perusahaan, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">{{ $p->nama_perusahaan }}</h4>
                                    <span class="font-mono text-[10px] text-slate-400 bg-slate-100 px-2 py-0.5 rounded">{{ $p->kode_pemasok }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-xs">
                                <p class="font-bold text-slate-700 mb-1">{{ $p->penanggung_jawab }}</p>
                                <p class="text-slate-500"><i class="fa-solid fa-phone w-4 text-slate-300"></i> {{ $p->telepon }}</p>
                                <p class="text-slate-500"><i class="fa-solid fa-envelope w-4 text-slate-300"></i> {{ $p->email }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-xs text-slate-600 font-medium max-w-xs line-clamp-2" title="{{ $p->alamat }}">
                                {{ $p->alamat }}
                            </p>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $p->status == 'aktif' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-rose-50 text-rose-600 border-rose-100' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $p->status == 'aktif' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <button wire:click="edit({{ $p->id }})" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button wire:confirm="Hapus mitra ini? Data terkait mungkin akan hilang." wire:click="hapus({{ $p->id }})" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-3xl text-slate-300 mb-4">
                                    <i class="fa-solid fa-building-circle-xmark"></i>
                                </div>
                                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Belum Ada Mitra</h3>
                                <p class="text-slate-400 text-sm font-medium mt-1">Tambahkan pemasok pertama untuk memulai rantai pasok.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 border-t border-slate-50">
            {{ $daftar_pemasok->links() }}
        </div>
    </div>
</div>
