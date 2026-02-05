<div class="space-y-10">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">JARINGAN <span class="text-cyan-600">SUPLAI</span></h1>
            <p class="text-slate-500 font-medium">Database mitra bisnis dan penyedia stok barang.</p>
        </div>
        <button wire:click="tambahBaru" class="px-6 py-3 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition shadow-lg">
            Tambah Mitra
        </button>
    </div>

    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex items-center gap-4">
            <div class="relative flex-1 max-w-md">
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari nama perusahaan..." class="w-full pl-10 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-cyan-500">
                <svg class="w-5 h-5 absolute left-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas Perusahaan</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kontak Person</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Kerjasama</th>
                        <th class="px-8 py-5 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($daftar_pemasok as $p)
                    <tr class="group hover:bg-slate-50/50 transition">
                        <td class="px-8 py-5">
                            <p class="font-bold text-slate-900 text-sm">{{ $p->nama_perusahaan }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $p->kode_pemasok }} • {{ $p->alamat }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs font-bold text-slate-700">{{ $p->penanggung_jawab }}</p>
                            <p class="text-[10px] text-slate-400">{{ $p->telepon }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $p->status === 'aktif' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button wire:click="edit({{ $p->id }})" class="text-slate-400 hover:text-cyan-600 font-bold text-xs uppercase tracking-widest transition">Edit</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold">Belum ada mitra terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-slate-50/30">{{ $daftar_pemasok->links() }}</div>
    </div>

    <!-- Panel Form -->
    <x-ui.slide-over id="form-pemasok" title="Data Mitra Bisnis">
        <form wire:submit.prevent="simpan" class="space-y-6 p-2">
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Kode Vendor</label>
                <input wire:model="kode_pemasok" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 font-bold uppercase">
                @error('kode_pemasok') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Perusahaan</label>
                <input wire:model="nama_perusahaan" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 font-bold">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">PIC (Kontak)</label>
                    <input wire:model="penanggung_jawab" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Telepon</label>
                    <input wire:model="telepon" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Email Bisnis</label>
                <input wire:model="email" type="email" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 text-sm">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Alamat Lengkap</label>
                <textarea wire:model="alamat" rows="3" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 text-sm"></textarea>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Status Kerjasama</label>
                <select wire:model="status" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 text-sm font-bold">
                    <option value="aktif">AKTIF - REKANAN RESMI</option>
                    <option value="nonaktif">NONAKTIF / DIBEKUKAN</option>
                </select>
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-cyan-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-cyan-700 transition">Simpan Data Mitra</button>
            </div>
        </form>
    </x-ui.slide-over>
</div>