<div class="space-y-10 pb-20">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">Audit <span class="text-emerald-600">Inventaris</span></h1>
            <p class="text-slate-500 font-medium">Manajemen pergerakan barang lintas gudang dan pelacakan SKU.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative">
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari SKU atau Nama..." class="w-64 pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                <svg class="w-5 h-5 absolute left-3 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-slate-800 transition shadow-lg">Laporan Stok</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI: DAFTAR STOK REAL-TIME -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Status Unit Global</h3>
                    <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-2 py-1 rounded">Update Instan</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Perangkat</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Tersedia</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Ditahan</th>
                                <th class="px-8 py-4 text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($stokGlobal as $s)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <p class="font-bold text-slate-900 leading-tight">{{ $s->nama }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $s->sku }} • {{ $s->kategori_nama }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full {{ $s->stok > 5 ? 'bg-emerald-500' : 'bg-amber-500 animate-pulse' }}"></div>
                                        <span class="text-sm font-black text-slate-900">{{ $s->stok }} <span class="text-[10px] text-slate-400">Unit</span></span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-sm font-bold text-slate-500">{{ $s->stok_ditahan }}</span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <button wire:click="bukaMutasi({{ $s->id }})" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-slate-50/30 border-t border-slate-50">
                    {{ $stokGlobal->links() }}
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: LOG MUTASI NARATIF -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-slate-900 rounded-[32px] p-8 text-white shadow-2xl relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-black uppercase tracking-[0.2em] text-[10px] text-emerald-400 mb-6">Jejak Mutasi Barang</h3>
                    <div class="space-y-8">
                        @foreach($mutasiTerbaru as $m)
                        <div class="relative pl-6 border-l border-white/10 pb-2 last:border-none">
                            <div class="absolute -left-[5px] top-0 w-2 h-2 rounded-full bg-emerald-500"></div>
                            <p class="text-[10px] font-black text-white/40 uppercase tracking-tighter mb-1">{{ \Carbon\Carbon::parse($m->created_at)->diffForHumans() }}</p>
                            <p class="text-xs leading-relaxed text-white/80">
                                <span class="font-bold text-white">{{ $m->aktor ?? 'Sistem' }}</span> 
                                {{ $m->keterangan }} 
                                <span class="text-emerald-400 font-black">[{{ $m->produk_nama }}]</span>
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Dekorasi -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full -translate-y-16 translate-x-16 blur-3xl"></div>
            </div>
        </div>
    </div>

    <!-- Panel Mutasi (Slide-over) -->
    <x-ui.slide-over id="panel-mutasi" title="Pindahkan Stok Unit">
        <div class="space-y-8 p-4">
            <div class="p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                <p class="text-xs font-black text-emerald-700 uppercase tracking-widest mb-2">Informasi Produk</p>
                <h4 class="text-xl font-black text-slate-900 leading-tight">Laptop ASUS ROG Zephyrus G14</h4>
                <p class="text-sm text-emerald-600 font-bold mt-1">Total Stok Global: 24 Unit</p>
            </div>

            <form class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase mb-2">Dari Gudang</label>
                        <select class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500">
                            <option>Gudang Pusat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase mb-2">Ke Gudang</label>
                        <select class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500">
                            <option>Toko Utama (Retail)</option>
                            <option>Service Center</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2">Jumlah Unit</label>
                    <input type="number" class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 font-black text-lg">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2">Catatan Mutasi</label>
                    <textarea rows="3" class="w-full rounded-xl border-slate-200 text-sm placeholder:text-slate-300" placeholder="Contoh: Re-stock untuk display depan toko..."></textarea>
                </div>
                <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-emerald-700 transition shadow-xl shadow-emerald-600/20">
                    Eksekusi Perpindahan
                </button>
            </form>
        </div>
    </x-ui.slide-over>

</div>
