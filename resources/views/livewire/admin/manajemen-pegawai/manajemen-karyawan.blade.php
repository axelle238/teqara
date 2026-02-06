<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Direktori Pegawai</h1>
            <p class="text-slate-500 text-sm mt-1">Basis data seluruh personil perusahaan.</p>
        </div>
        <button wire:click="tambahBaru" class="flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
            <i class="fa-solid fa-user-plus"></i> Tambah Pegawai
        </button>
    </div>

    <!-- Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex gap-2 w-full md:w-auto">
            <div class="relative flex-1 md:w-64">
                <i class="fa-solid fa-search absolute left-3 top-3 text-slate-400 text-xs"></i>
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Nama atau NIP..." class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <select wire:model.live="filter_departemen" class="bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-600 py-2.5 px-4 focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                <option value="">Semua Departemen</option>
                @foreach($departemen as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Employee Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($karyawan as $k)
        <div class="bg-white rounded-[24px] border border-slate-100 p-6 hover:shadow-xl hover:border-indigo-100 transition-all duration-300 relative group">
            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                <button wire:click="edit({{ $k->id }})" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 rounded-full bg-slate-100 border-4 border-white shadow-sm flex items-center justify-center text-2xl font-bold text-slate-400 mb-4 overflow-hidden relative">
                    @if($k->foto)
                        <img src="{{ asset($k->foto) }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($k->nama_lengkap, 0, 1) }}
                    @endif
                    <div class="absolute bottom-1 right-1 w-4 h-4 rounded-full border-2 border-white {{ $k->status == 'aktif' ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                </div>
                
                <h3 class="font-bold text-slate-900 text-lg">{{ $k->nama_lengkap }}</h3>
                <p class="text-xs font-mono text-slate-400 mb-2">{{ $k->nip }}</p>
                <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest mb-4">
                    {{ $k->jabatan->nama ?? '-' }}
                </span>

                <div class="w-full border-t border-slate-100 pt-4 mt-2 grid grid-cols-2 gap-2">
                    <a href="mailto:{{ $k->email }}" class="flex items-center justify-center gap-2 py-2 rounded-xl bg-slate-50 text-slate-600 text-xs font-bold hover:bg-slate-100 transition-colors">
                        <i class="fa-solid fa-envelope"></i> Email
                    </a>
                    <a href="tel:{{ $k->telepon }}" class="flex items-center justify-center gap-2 py-2 rounded-xl bg-slate-50 text-slate-600 text-xs font-bold hover:bg-slate-100 transition-colors">
                        <i class="fa-solid fa-phone"></i> Kontak
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-6">
        {{ $karyawan->links() }}
    </div>

    <!-- Slide Over Form -->
    <x-ui.panel-geser id="panel-form-karyawan" :judul="$karyawan_id ? 'Edit Data Pegawai' : 'Onboarding Pegawai Baru'">
        <form wire:submit="simpan" class="space-y-6">
            
            <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 flex gap-4 items-start">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 shrink-0">
                    <i class="fa-solid fa-id-badge"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-indigo-900">Identitas Pegawai</h4>
                    <p class="text-xs text-indigo-700 mt-1">Pastikan NIP unik dan sesuai format perusahaan.</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Nama Lengkap</label>
                    <input wire:model="nama_lengkap" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold" placeholder="Nama sesuai KTP">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">NIP</label>
                    <input wire:model="nip" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-mono" placeholder="2024001">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Tanggal Bergabung</label>
                    <input wire:model="tanggal_bergabung" type="date" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500">
                </div>

                <div class="col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Jabatan & Posisi</label>
                    <select wire:model="jabatan_id" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold">
                        <option value="">Pilih Jabatan</option>
                        @foreach($departemen as $dept)
                            <optgroup label="{{ $dept->nama }}">
                                @foreach($dept->jabatan as $jab)
                                    <option value="{{ $jab->id }}">{{ $jab->nama }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Email Korporat</label>
                    <input wire:model="email" type="email" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Telepon</label>
                    <input wire:model="telepon" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500">
                </div>

                <div class="col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Alamat Domisili</label>
                    <textarea wire:model="alamat" rows="2" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500"></textarea>
                </div>
            </div>

            @if(!$karyawan_id)
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" wire:model="buat_akun_pengguna" class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <div>
                        <span class="block text-sm font-bold text-slate-900">Buat Akun Sistem</span>
                        <span class="text-xs text-slate-500">Login dengan password default: <strong>Teqara123</strong></span>
                    </div>
                </label>
            </div>
            @endif

            <div class="fixed bottom-0 right-0 w-full md:w-[480px] bg-white border-t border-slate-200 p-6 z-50">
                <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
                    Simpan Data Pegawai
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>