<div class="space-y-8 p-6 lg:p-10">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">Mitra <span class="text-indigo-600">Logistik</span></h1>
            <p class="text-slate-500 font-medium">Kelola database pemasok dan principal resmi.</p>
        </div>
        <button wire:click="tambah" class="px-6 py-3 bg-slate-900 text-white rounded-2xl font-bold text-sm hover:bg-slate-800 transition shadow-xl shadow-slate-900/20 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Pemasok Baru
        </button>
    </div>

    <!-- Statistik Mini -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Mitra</p>
                <p class="text-2xl font-black text-slate-900">{{ $pemasok->total() }}</p>
            </div>
        </div>
    </div>

    <!-- Tabel Pemasok -->
    <div class="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari nama perusahaan..." class="w-full sm:w-96 pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all">
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Perusahaan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-8 py-4 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($pemasok as $p)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs">
                                    {{ substr($p->nama_perusahaan, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900">{{ $p->nama_perusahaan }}</p>
                                    <p class="text-xs text-slate-400 font-mono">{{ $p->kode_pemasok }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm font-bold text-slate-700">{{ $p->penanggung_jawab }}</p>
                            <p class="text-xs text-slate-500">{{ $p->telepon }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $p->status == 'aktif' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button wire:click="edit({{ $p->id }})" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 hover:underline">Kelola</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6">
            {{ $pemasok->links() }}
        </div>
    </div>

    <!-- Slide Over Form -->
    <x-ui.slide-over id="form-pemasok" title="Data Pemasok">
        <form wire:submit.prevent="simpan" class="space-y-6 p-1">
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-2">Nama Perusahaan</label>
                    <input wire:model="nama_perusahaan" type="text" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 font-bold">
                    @error('nama_perusahaan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase mb-2">PIC</label>
                        <input wire:model="penanggung_jawab" type="text" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase mb-2">Telepon</label>
                        <input wire:model="telepon" type="text" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-2">Email Bisnis</label>
                    <input wire:model="email" type="email" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-2">Alamat Lengkap</label>
                    <textarea wire:model="alamat" rows="3" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-2">Status Kerjasama</label>
                    <select wire:model="status" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 text-sm">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-aktif (Vakum)</option>
                        <option value="blacklist">Blacklist (Masalah)</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20">
                Simpan Data Mitra
            </button>
        </form>
    </x-ui.slide-over>
</div>
