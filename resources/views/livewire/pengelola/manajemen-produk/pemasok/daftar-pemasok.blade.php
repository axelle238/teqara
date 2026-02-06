<div class="space-y-12 pb-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-cyan-50 border border-cyan-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-cyan-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-cyan-600 uppercase tracking-[0.3em]">Vendor Relationship</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">MITRA <span class="text-cyan-600">PEMASOK</span></h1>
            <p class="text-slate-500 font-medium text-lg">Kelola basis data vendor, kontrak, dan informasi kontak pemasok utama.</p>
        </div>
        <button onclick="window.location.href='{{ route('pengelola.logistik.pemasok.tambah') }}'" class="px-8 py-4 bg-cyan-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-cyan-700 transition-all shadow-xl shadow-cyan-500/20 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Registrasi Vendor
        </button>
    </div>

    <!-- Table & Filters -->
    <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
        <div class="p-8 border-b border-indigo-50 bg-slate-50/30 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="relative w-full md:w-96 group">
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Nama Perusahaan / Kontak..." class="w-full pl-12 pr-4 py-4 bg-white border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-cyan-500/10 shadow-sm transition-all">
                <svg class="w-5 h-5 absolute left-4 top-4 text-slate-300 group-focus-within:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            
            <div class="flex items-center gap-2 bg-white p-1.5 rounded-2xl border border-indigo-50 shadow-inner">
                <button wire:click="$set('filterStatus', '')" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterStatus === '' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-400 hover:text-cyan-600' }}">Semua</button>
                <button wire:click="$set('filterStatus', 'aktif')" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterStatus === 'aktif' ? 'bg-emerald-500 text-white shadow-lg' : 'text-slate-400 hover:text-emerald-600' }}">Aktif</button>
                <button wire:click="$set('filterStatus', 'nonaktif')" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterStatus === 'nonaktif' ? 'bg-slate-500 text-white shadow-lg' : 'text-slate-400 hover:text-slate-600' }}">Nonaktif</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Identitas Vendor</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Kontak Personal</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Status Kerjasama</th>
                        <th class="px-10 py-6 text-right">Otoritas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pemasok as $p)
                    <tr class="group hover:bg-cyan-50/10 transition-all">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-500 font-black text-lg">
                                    {{ substr($p->nama_perusahaan, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-black text-slate-900 uppercase text-sm">{{ $p->nama_perusahaan }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $p->kode_pemasok }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-sm font-bold text-slate-700">{{ $p->penanggung_jawab }}</p>
                            <p class="text-[10px] text-slate-400 mt-1">{{ $p->telepon }}</p>
                            <p class="text-[10px] text-cyan-600 mt-0.5">{{ $p->email }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $p->status === 'aktif' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <a href="{{ route('pengelola.logistik.pemasok.edit', $p->id) }}" wire:navigate class="inline-block px-6 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                                Kelola Profil
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-10 py-20 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">Database vendor kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-10 border-t border-slate-50">{{ $pemasok->links() }}</div>
    </div>
</div>

