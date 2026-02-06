<div class="space-y-12 pb-32">
    <!-- Header Logistik -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">AUDIT <span class="text-indigo-600">INVENTARIS</span></h1>
            <p class="text-slate-500 font-medium text-lg">Pusat kendali stok, valuasi aset, dan pergerakan barang.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-indigo-50 px-6 py-3 rounded-2xl border border-indigo-100">
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">Total Valuasi Aset</p>
                <p class="text-2xl font-black text-indigo-900 tracking-tighter">Rp {{ number_format($analitik['valuasi'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Analitik Kartu -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Unit Fisik</p>
                <h3 class="text-3xl font-black text-slate-900">{{ number_format($analitik['total_unit']) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>
        <div class="bg-amber-50 p-8 rounded-[40px] border border-amber-100 flex items-center justify-center relative overflow-hidden group">
            <div class="text-center relative z-10">
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-2">Stok Menipis (Reorder)</p>
                <h3 class="text-4xl font-black text-amber-700">{{ number_format($analitik['kritis']) }}</h3>
                <p class="text-xs font-bold text-amber-600/60 mt-1 uppercase tracking-wider">Perlu Restock Segera</p>
            </div>
            <div class="absolute inset-0 bg-amber-100/50 scale-0 group-hover:scale-100 transition-transform duration-500 rounded-[40px]"></div>
        </div>
        <div class="bg-emerald-50 p-8 rounded-[40px] border border-emerald-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2">Overstock (>100)</p>
                <h3 class="text-3xl font-black text-emerald-700">{{ number_format($analitik['overstock']) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
    </div>

    <!-- Tabel Stok & Audit Trail -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Tabel Stok Utama -->
        <div class="lg:col-span-2 bg-white rounded-[48px] border border-indigo-50 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-indigo-50 flex justify-between items-center bg-slate-50/30">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Posisi Stok Terkini</h3>
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Filter SKU / Nama..." class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-xs font-bold w-64 focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white border-b border-indigo-50">
                        <tr>
                            <th class="px-8 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Item</th>
                            <th class="px-6 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">SKU</th>
                            <th class="px-6 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Fisik</th>
                            <th class="px-6 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Valuasi</th>
                            <th class="px-8 py-5 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($stokGlobal as $p)
                        <tr class="group hover:bg-indigo-50/20 transition-all">
                            <td class="px-8 py-5">
                                <p class="text-sm font-black text-slate-900 truncate max-w-[200px]">{{ $p->nama }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $p->kategori->nama ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-5 text-xs font-mono font-bold text-slate-500">{{ $p->kode_unit }}</td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-black {{ $p->stok <= 5 ? 'text-rose-600' : 'text-slate-900' }}">{{ $p->stok }}</span>
                                    @if($p->stok <= 5)
                                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse" title="Perlu Reorder"></span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5 text-xs font-bold text-slate-700">Rp {{ number_format($p->stok * $p->harga_modal, 0, ',', '.') }}</td>
                            <td class="px-8 py-5 text-right">
                                <button wire:click="bukaMutasi({{ $p->id }})" class="px-4 py-2 bg-slate-100 hover:bg-indigo-600 hover:text-white rounded-xl text-[9px] font-black uppercase tracking-widest transition-all">Audit</button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-8 py-10 text-center text-slate-400 text-xs font-bold uppercase">Data tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-slate-50">{{ $stokGlobal->links() }}</div>
        </div>

        <!-- Audit Trail Feed -->
        <div class="lg:col-span-1 bg-slate-900 rounded-[48px] p-8 text-white shadow-2xl relative overflow-hidden">
            <h3 class="text-lg font-black uppercase tracking-tight mb-8 relative z-10">Log Mutasi Terakhir</h3>
            <div class="space-y-6 relative z-10">
                @foreach($mutasiTerbaru as $m)
                <div class="flex gap-4 group">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0 border border-white/10 group-hover:bg-indigo-500 transition-colors">
                        <span class="text-xs font-black">{{ $m->jumlah > 0 ? '+' : '' }}{{ $m->jumlah }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-white truncate">{{ $m->produk->nama ?? 'Unknown Item' }}</p>
                        <p class="text-[10px] text-slate-400 leading-snug mt-1">{{ $m->keterangan }}</p>
                        <p class="text-[9px] text-slate-500 font-mono mt-1 uppercase tracking-widest">{{ $m->created_at->diffForHumans() }} oleh {{ $m->pengguna->nama ?? 'System' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Decor -->
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-indigo-500/20 blur-[80px] rounded-full"></div>
        </div>
    </div>

    <!-- Panel Mutasi Manual -->
    <x-ui.panel-geser id="panel-mutasi" judul="PENYESUAIAN STOK MANUAL">
        <form wire:submit.prevent="eksekusiMutasi" class="space-y-8 p-2">
            <div class="bg-amber-50 p-6 rounded-2xl border border-amber-100">
                <p class="text-xs text-amber-800 font-medium leading-relaxed">
                    <span class="font-black uppercase tracking-widest block mb-1">Peringatan Audit</span>
                    Setiap perubahan stok manual akan dicatat dalam Log Audit Sistem dan mempengaruhi valuasi aset perusahaan. Pastikan data fisik sesuai.
                </p>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Jumlah Penyesuaian (Minus untuk Pengurangan)</label>
                <input wire:model="jumlahMutasi" type="number" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-lg font-black text-slate-900 focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: 5 atau -3">
                @error('jumlahMutasi') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Alasan Penyesuaian</label>
                <textarea wire:model="keteranganMutasi" rows="4" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: Barang rusak saat pengiriman, Selisih Stock Opname, dll."></textarea>
                @error('keteranganMutasi') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl">
                    EKSEKUSI AUDIT
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>
