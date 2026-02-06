<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Mitra Pemasok</h1>
            <p class="text-slate-500 text-sm mt-1">Database vendor dan distributor teknologi.</p>
        </div>
        <button wire:click="tambahBaru" class="flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
            <i class="fa-solid fa-handshake"></i> Registrasi Pemasok
        </button>
    </div>

    <!-- Search Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
        <div class="relative w-full max-w-md">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Nama Perusahaan atau Kode..." class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all">
        </div>
        <div class="flex gap-2">
            <button class="p-2.5 bg-slate-50 text-slate-500 rounded-xl hover:bg-slate-100 transition-colors" title="Unduh CSV">
                <i class="fa-solid fa-file-csv"></i>
            </button>
        </div>
    </div>

    <!-- Supplier Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($daftar_pemasok as $pemasok)
        <div class="group bg-white rounded-[24px] border border-slate-100 p-6 hover:shadow-xl hover:border-indigo-100 transition-all duration-300 relative overflow-hidden">
            <!-- Decorative BG -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-slate-50 to-indigo-50 rounded-bl-[100px] -z-0 opacity-50 group-hover:scale-110 transition-transform"></div>
            
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 rounded-xl bg-white border border-slate-100 shadow-sm flex items-center justify-center font-black text-lg text-indigo-600">
                        {{ substr($pemasok->nama_perusahaan, 0, 1) }}
                    </div>
                    <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $pemasok->status == 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                        {{ $pemasok->status }}
                    </span>
                </div>

                <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $pemasok->nama_perusahaan }}</h3>
                <p class="text-xs font-mono text-slate-400 mb-4">{{ $pemasok->kode_pemasok }}</p>

                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm text-slate-600">
                        <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Kontak Person</p>
                            <p class="font-bold">{{ $pemasok->penanggung_jawab }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-slate-600">
                        <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Telepon</p>
                            <p class="font-mono">{{ $pemasok->telepon }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100 flex gap-2">
                    <button wire:click="edit({{ $pemasok->id }})" class="flex-1 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-indigo-600 transition-colors">
                        Edit Detail
                    </button>
                    <button class="w-10 rounded-xl bg-slate-50 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors flex items-center justify-center">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Slide Over Form -->
    <x-ui.panel-geser id="panel-form-pemasok" :judul="$pemasok_id ? 'Edit Data Mitra' : 'Registrasi Mitra Baru'">
        <form wire:submit="simpan" class="space-y-6">
            
            <div class="p-4 bg-indigo-50 rounded-xl border border-indigo-100 flex gap-4 items-start">
                <i class="fa-solid fa-circle-info text-indigo-500 mt-1"></i>
                <div class="text-xs text-indigo-800 leading-relaxed">
                    <strong class="block mb-1">Informasi Penting</strong>
                    Pastikan data kontak dan email valid untuk keperluan Purchase Order (PO) otomatis di masa mendatang.
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Nama Perusahaan</label>
                    <input wire:model="nama_perusahaan" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold" placeholder="PT Teknologi Nusantara">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Kode Vendor</label>
                    <input wire:model="kode_pemasok" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-mono uppercase" placeholder="VND-001">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Status Kerjasama</label>
                    <select wire:model="status" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-Aktif</option>
                        <option value="blacklist">Blacklist</option>
                    </select>
                </div>

                <div class="col-span-2 h-px bg-slate-100 my-2"></div>

                <div class="col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Penanggung Jawab (PIC)</label>
                    <input wire:model="penanggung_jawab" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500" placeholder="Budi Santoso">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Email Bisnis</label>
                    <input wire:model="email" type="email" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500" placeholder="procurement@vendor.com">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Telepon / WhatsApp</label>
                    <input wire:model="telepon" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500" placeholder="0812...">
                </div>

                <div class="col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Alamat Kantor/Gudang</label>
                    <textarea wire:model="alamat" rows="3" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500" placeholder="Alamat lengkap pengiriman retur..."></textarea>
                </div>
            </div>

            <div class="fixed bottom-0 right-0 w-full md:w-[480px] bg-white border-t border-slate-200 p-6 z-50">
                <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
                    Simpan Data Mitra
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>