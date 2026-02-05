<div class="space-y-10 pb-20">
    
    <!-- Header: Vibrant & Clear -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Audit Inventaris Real-time</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">JEJAK <span class="text-emerald-600">DISTRIBUSI</span></h1>
            <p class="text-slate-500 font-medium text-lg">Manajemen pergerakan unit lintas gudang dan kontrol KODE UNIT hulu-hilir.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative group">
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari KODE UNIT atau Model..." class="w-72 pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-emerald-500 shadow-sm transition-all">
                <svg class="w-5 h-5 absolute left-4 top-4 text-slate-300 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <button class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-slate-900/10">Laporan Stok</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- KOLOM KIRI: DAFTAR STOK REAL-TIME -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[56px] border border-indigo-50 shadow-sm overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Status Unit Global</h3>
                    <div class="flex items-center gap-2 px-3 py-1 bg-emerald-500 text-white rounded-full text-[9px] font-black uppercase tracking-widest">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                        Live Update
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white">
                                <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-wider">Perangkat</th>
                                <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-wider">Tersedia</th>
                                <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-wider text-center">Reserver</th>
                                <th class="px-10 py-6 text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($stokGlobal as $s)
                            <tr class="group hover:bg-emerald-50/30 transition-colors duration-300">
                                <td class="px-10 py-6">
                                    <p class="font-black text-slate-900 text-base tracking-tight leading-tight">{{ $s->nama }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter mt-1">{{ `s->kode_unit }} • <span class="text-indigo-500">{{ $s->kategori?->nama }}</span></p>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2.5 h-2.5 rounded-full {{ $s->stok > 10 ? 'bg-emerald-500 shadow-lg shadow-emerald-500/50' : 'bg-amber-500 animate-pulse' }}"></div>
                                        <span class="text-sm font-black text-slate-900">{{ $s->stok }} <span class="text-[10px] text-slate-400 ml-0.5 font-bold">UNIT</span></span>
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-xl text-xs font-black">{{ $s->stok_ditahan }}</span>
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <button wire:click="bukaMutasi({{ $s->id }})" class="p-3 bg-white border border-indigo-50 text-indigo-400 hover:text-white hover:bg-indigo-600 rounded-[18px] transition-all shadow-sm opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-8 bg-slate-50/30 border-t border-slate-50 flex justify-center">
                    {{ $stokGlobal->links() }}
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: LOG MUTASI NARATIF -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-[56px] p-10 text-white shadow-2xl relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-black uppercase tracking-[0.3em] text-[10px] text-indigo-200 mb-10 border-b border-white/10 pb-4">Audit Distribusi</h3>
                    <div class="space-y-10">
                        @foreach($mutasiTerbaru as $m)
                        <div class="relative pl-8 border-l border-white/20 pb-2 last:border-none">
                            <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-cyan-400 shadow-lg shadow-cyan-400/50"></div>
                            <p class="text-[9px] font-black text-indigo-200 uppercase tracking-widest mb-2">{{ $m->created_at->diffForHumans() }}</p>
                            <p class="text-sm leading-relaxed font-medium text-white/90 italic">
                                "{{ $m->keterangan }}"
                            </p>
                            <div class="mt-3 flex items-center gap-2">
                                <span class="text-[10px] font-black text-cyan-200 uppercase tracking-tighter">{{ $m->produk?->nama }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Background Deco -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-[80px]"></div>
            </div>
        </div>
    </div>

    <!-- Panel Mutasi (Slide-over) -->
    <x-ui.slide-over id="panel-mutasi" title="EKSEKUSI MUTASI BARANG">
        <div class="space-y-10 p-2">
            <div class="p-8 bg-indigo-50 rounded-[40px] border border-indigo-100 shadow-inner relative overflow-hidden">
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-3 relative z-10">Unit Terpilih</p>
                <h4 class="text-2xl font-black text-slate-900 leading-tight relative z-10 uppercase tracking-tighter">
                    {{ \App\Models\Produk::find($produkTerpilihId)?->nama ?? 'Unit Radar' }}
                </h4>
                <div class="mt-6 flex items-center gap-4 relative z-10">
                    <div class="px-4 py-2 bg-white rounded-xl shadow-sm">
                        <span class="text-xs font-black text-emerald-600">{{ \App\Models\Produk::find($produkTerpilihId)?->stok ?? 0 }} UNIT READY</span>
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-full blur-2xl"></div>
            </div>

            <form wire:submit.prevent="eksekusiMutasi" class="space-y-8">
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Gudang Pengirim</label>
                        <select wire:model="dariGudang" class="w-full rounded-[24px] border-none bg-indigo-50/50 p-5 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Asal</option>
                            @foreach($daftarGudang as $g) <option value="{{ $g->id }}">{{ $g->nama }}</option> @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Gudang Penerima</label>
                        <select wire:model="keGudang" class="w-full rounded-[24px] border-none bg-indigo-50/50 p-5 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Tujuan</option>
                            @foreach($daftarGudang as $g) <option value="{{ $g->id }}">{{ $g->nama }}</option> @endforeach
                        </select>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Volume Unit</label>
                    <input wire:model="jumlahMutasi" type="number" class="w-full rounded-[24px] border-none bg-indigo-50/50 p-6 text-2xl font-black text-indigo-600 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Narasi Mutasi</label>
                    <textarea wire:model="keteranganMutasi" rows="3" class="w-full rounded-[24px] border-none bg-indigo-50/50 p-6 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 placeholder:text-slate-300" placeholder="Contoh: Pengalihan unit untuk pameran IT..."></textarea>
                </div>
                <div class="pt-6">
                    <button type="submit" class="w-full py-6 bg-slate-900 text-white rounded-[32px] font-black text-xs uppercase tracking-[0.3em] hover:bg-emerald-600 transition-all shadow-2xl shadow-indigo-500/20 active:scale-95">
                        KONFIRMASI PERPINDAHAN UNIT
                    </button>
                </div>
            </form>
        </div>
    </x-ui.slide-over>

</div>
