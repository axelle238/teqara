<div class="space-y-10">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">SUMBER DAYA <span class="text-rose-600">MANUSIA</span></h1>
            <p class="text-slate-500 font-medium">Database kepegawaian dan struktur organisasi internal.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.hrd.karyawan') }}" wire:navigate class="px-6 py-3 bg-white text-slate-600 border border-slate-200 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition">Struktur Organisasi</a>
            <button wire:click="tambahBaru" class="px-6 py-3 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition shadow-lg">
                Rekrut Karyawan
            </button>
        </div>
    </div>

    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari NIP atau Nama..." class="w-full max-w-md pl-4 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-rose-500">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Profil Pegawai</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jabatan & Unit</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($karyawan as $k)
                    <tr class="group hover:bg-slate-50/50 transition">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-500 border-2 border-white shadow-sm">{{ substr($k->pengguna->nama, 0, 1) }}</div>
                                <div>
                                    <p class="font-bold text-slate-900 text-sm">{{ $k->pengguna->nama }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">NIP: {{ $k->nip }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs font-black text-indigo-600 uppercase mb-1">{{ $k->jabatan->nama }}</p>
                            <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded text-[9px] font-bold uppercase">{{ $k->jabatan->departemen->kode }} - {{ $k->jabatan->departemen->nama }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $k->status_kerja === 'tetap' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                {{ strtoupper($k->status_kerja) }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button class="text-slate-400 hover:text-rose-600 font-bold text-xs uppercase tracking-widest transition">Detail</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold">Belum ada data karyawan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-slate-50/30">{{ $karyawan->links() }}</div>
    </div>

    <!-- Panel Form -->
    <x-ui.slide-over id="form-karyawan" title="Data Kepegawaian">
        <form wire:submit.prevent="simpan" class="space-y-6 p-2">
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Pilih Akun Pengguna</label>
                <select wire:model="pengguna_id" class="w-full rounded-2xl border-slate-200 focus:ring-rose-500 text-sm font-bold">
                    <option value="">-- Pilih User --</option>
                    @foreach($list_pengguna as $u) <option value="{{ $u->id }}">{{ $u->nama }} ({{ $u->email }})</option> @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Posisi Jabatan</label>
                <select wire:model="jabatan_id" class="w-full rounded-2xl border-slate-200 focus:ring-rose-500 text-sm">
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach($list_jabatan as $j) <option value="{{ $j->id }}">{{ $j->nama }} ({{ $j->departemen->kode }})</option> @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">NIP</label>
                    <input wire:model="nip" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-rose-500 font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tanggal Masuk</label>
                    <input wire:model="tanggal_bergabung" type="date" class="w-full rounded-2xl border-slate-200 focus:ring-rose-500 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Status Kontrak</label>
                <select wire:model="status_kerja" class="w-full rounded-2xl border-slate-200 focus:ring-rose-500 text-sm font-bold">
                    <option value="">-- Pilih Status --</option>
                    <option value="tetap">PEGAWAI TETAP</option>
                    <option value="kontrak">KONTRAK (PKWT)</option>
                    <option value="magang">MAGANG / INTERN</option>
                </select>
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-rose-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rose-700 transition">Simpan Data Karyawan</button>
            </div>
        </form>
    </x-ui.slide-over>
</div>