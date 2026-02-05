<!-- 
    Nama File: resources/views/livewire/admin/laporan/daftar-laporan.blade.php
    Tujuan: Pusat analitik bisnis untuk meninjau performa penjualan dan tren produk.
    Gaya: High-Tech Enterprise, Data-Driven, No Modal.
-->
<div class="p-6 lg:p-10 space-y-10 pb-20">
    
    <!-- Header & Filter Global -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
        <div class="space-y-2">
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">PUSAT <span class="text-indigo-600">ANALITIK</span></h1>
            <p class="text-slate-500 font-medium">Laporan performa unit dan perputaran modal usaha.</p>
        </div>
        
        <div class="flex flex-col md:flex-row items-center gap-4">
            <div class="grid grid-cols-2 gap-3 w-full md:w-auto">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-2">Mulai</label>
                    <input wire:model.live="tanggalMulai" type="date" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-2">Selesai</label>
                    <input wire:model.live="tanggalSelesai" type="date" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <button 
                wire:click="eksporExcel" 
                class="w-full md:w-auto px-8 py-3 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all flex items-center justify-center gap-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Ekspor Data
            </button>
        </div>
    </div>

    <!-- Ringkasan Eksekutif -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-gradient-to-br from-slate-900 to-indigo-900 p-10 rounded-[48px] text-white shadow-2xl relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-4">Total Omzet Bruto</p>
                <h3 class="text-5xl font-black tracking-tighter mb-2">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h3>
                <div class="flex items-center gap-3 mt-8">
                    <div class="px-4 py-2 bg-white/10 rounded-xl border border-white/10 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span class="text-xs font-black uppercase tracking-widest">{{ $totalPesanan }} Transaksi Berhasil</span>
                    </div>
                </div>
            </div>
            <!-- Glow -->
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/20 rounded-full blur-[120px]"></div>
        </div>

        <div class="bg-white p-10 rounded-[48px] shadow-sm border border-slate-100 flex flex-col justify-between">
            <div>
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">Distribusi Omzet Kategori</h4>
                <div class="space-y-4">
                    @foreach($omzetPerKategori as $nama => $nilai)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                            <span class="text-sm font-bold text-slate-700">{{ $nama }}</span>
                        </div>
                        <span class="text-sm font-black text-slate-900">Rp {{ number_format($nilai, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Tabel Rincian Transaksi -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Jurnal Penjualan Detail</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Invoice</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Item</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($pesanan as $p)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-5">
                                    <p class="font-black text-slate-900 text-sm">#{{ $p->nomor_invoice }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $p->created_at->format('d/m/Y') }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-1">
                                        @foreach($p->detailPesanan->take(2) as $d)
                                        <span class="text-xs font-bold text-slate-600 truncate max-w-[200px]">{{ $d->produk->nama }}</span>
                                        @endforeach
                                        @if($p->detailPesanan->count() > 2)
                                        <span class="text-[10px] text-indigo-500 font-black">+{{ $p->detailPesanan->count() - 2 }} Item lainnya</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right font-black text-slate-900 text-sm">
                                    Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-slate-50/30">
                    {{ $pesanan->links() }}
                </div>
            </div>
        </div>

        <!-- Leaderboard Produk Terlaris -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden h-full">
                <div class="px-8 py-6 border-b border-slate-50 bg-indigo-50/30">
                    <h3 class="font-black text-indigo-900 uppercase tracking-widest text-xs">Top Performer Units</h3>
                </div>
                <div class="p-8 space-y-8">
                    @foreach($produkTerlaris as $index => $item)
                    <div class="flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white font-black text-xs shrink-0">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-black text-slate-900 truncate tracking-tight group-hover:text-indigo-600 transition-colors">{{ $item->produk->nama }}</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $item->total_terjual }} Unit Terjual</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>