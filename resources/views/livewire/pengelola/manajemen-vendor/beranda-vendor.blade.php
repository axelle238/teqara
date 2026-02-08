<div class="space-y-10 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Vendor -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 border border-orange-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                <span class="text-[10px] font-black text-orange-600 uppercase tracking-widest">Supply Chain Hub</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">
                MITRA & <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-amber-500">PEMASOK</span>
            </h1>
            <p class="text-slate-500 font-medium text-lg max-w-2xl leading-relaxed">
                Pusat kendali ekosistem rantai pasok, pengadaan stok, dan evaluasi kinerja vendor.
            </p>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="{{ route('pengelola.vendor.daftar') }}" wire:navigate class="group flex items-center gap-3 px-8 py-4 bg-slate-900 text-white rounded-2xl shadow-lg shadow-slate-900/30 hover:bg-orange-600 hover:shadow-orange-500/30 transition-all duration-300">
                <i class="fa-solid fa-address-book text-lg group-hover:scale-110 transition-transform"></i>
                <span class="font-black text-xs uppercase tracking-widest">Direktori Vendor</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid (Colorful & Detail) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Vendor -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-white/5 rounded-full blur-3xl"></div>
            <div class="relative z-10 text-white">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-2xl backdrop-blur-sm">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <span class="px-3 py-1 bg-white/10 rounded-lg text-[10px] font-black uppercase tracking-widest backdrop-blur-sm">Mitra</span>
                </div>
                <h3 class="text-4xl font-black tracking-tighter">{{ $stats['total_vendor'] }}</h3>
                <p class="text-xs text-slate-400 mt-2 font-medium">Total Terdaftar</p>
            </div>
        </div>

        <!-- Vendor Aktif -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-widest">Aktif</span>
                </div>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $stats['vendor_aktif'] }}</h3>
                <p class="text-xs text-slate-400 mt-2 font-medium">Siap Suplai</p>
            </div>
        </div>

        <!-- PO Pending -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-amber-50 rounded-full blur-2xl group-hover:bg-amber-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg text-[10px] font-black uppercase tracking-widest">Pending</span>
                </div>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $stats['po_menunggu'] }}</h3>
                <p class="text-xs text-slate-400 mt-2 font-medium">PO Perlu Tindakan</p>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-blue-50 rounded-full blur-2xl group-hover:bg-blue-100 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-widest">Total</span>
                </div>
                <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $stats['total_po'] }}</h3>
                <p class="text-xs text-slate-400 mt-2 font-medium">Purchase Order</p>
            </div>
        </div>
    </div>

    <!-- PO Terbaru & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent PO Table -->
        <div class="lg:col-span-2 bg-white rounded-[3rem] border border-slate-200 shadow-sm p-10 relative overflow-hidden">
            <div class="flex items-center justify-between mb-8 border-b border-slate-50 pb-6">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Purchase Order Terkini</h3>
                <a href="{{ route('pengelola.produk.pembelian.riwayat') }}" wire:navigate class="text-[10px] font-black text-orange-600 uppercase tracking-widest hover:underline">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            <th class="py-4">No. PO</th>
                            <th class="py-4">Vendor</th>
                            <th class="py-4">Status</th>
                            <th class="py-4 text-right">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse(\App\Models\PembelianStok::with('pemasok')->latest()->take(5)->get() as $po)
                        <tr class="group hover:bg-slate-50 transition-colors">
                            <td class="py-4">
                                <span class="font-black text-xs text-slate-700 bg-slate-100 px-2 py-1 rounded-lg">#{{ $po->nomor_po }}</span>
                            </td>
                            <td class="py-4">
                                <p class="text-xs font-bold text-slate-900">{{ $po->pemasok->nama_perusahaan ?? '-' }}</p>
                            </td>
                            <td class="py-4">
                                @php
                                    $statusColor = match($po->status) {
                                        'selesai' => 'bg-emerald-100 text-emerald-700',
                                        'menunggu_persetujuan' => 'bg-amber-100 text-amber-700',
                                        'batal' => 'bg-rose-100 text-rose-700',
                                        default => 'bg-slate-100 text-slate-600'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $statusColor }}">{{ str_replace('_', ' ', $po->status) }}</span>
                            </td>
                            <td class="py-4 text-right">
                                <span class="font-black text-xs text-slate-900">Rp{{ number_format($po->total_biaya, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-xs text-slate-400 font-bold uppercase tracking-widest">Belum ada data PO</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Access -->
        <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-[3rem] p-10 text-white relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
            
            <div class="relative z-10 space-y-6">
                <h3 class="text-xl font-black uppercase tracking-tight text-white border-b border-white/20 pb-4">Aksi Cepat</h3>
                
                <a href="{{ route('pengelola.produk.pembelian.baru') }}" wire:navigate class="flex items-center gap-4 group p-4 rounded-2xl bg-white/10 hover:bg-white/20 transition-all border border-white/10 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-xl bg-white text-orange-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Buat PO Baru</p>
                        <p class="text-[9px] text-orange-100">Restock Barang</p>
                    </div>
                </a>

                <a href="#" class="flex items-center gap-4 group p-4 rounded-2xl bg-white/10 hover:bg-white/20 transition-all border border-white/10 backdrop-blur-sm opacity-60 cursor-not-allowed">
                    <div class="w-10 h-10 rounded-xl bg-white text-orange-600 flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Laporan Vendor</p>
                        <p class="text-[9px] text-orange-100">Analisa Performa</p>
                    </div>
                </a>
            </div>

            <div class="relative z-10 pt-8 border-t border-white/20 text-center">
                <p class="text-[9px] text-white/60 font-mono">B2B Module v1.0</p>
            </div>
        </div>
    </div>
</div>