<div class="space-y-10 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="bg-white rounded-[3rem] p-10 overflow-hidden shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-8 relative">
        <div class="relative z-10 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 border border-orange-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-orange-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-orange-600 uppercase tracking-widest">Pusat Distribusi</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">BERANDA <span class="text-orange-600">LOGISTIK</span></h1>
            <p class="text-slate-500 font-medium text-lg">Pemantauan rantai pasok hilir dan status pengiriman real-time.</p>
        </div>
        <div class="relative z-10 flex gap-4">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Terkirim</p>
                <p class="text-3xl font-black text-slate-900">{{ $sampai_tujuan }} <span class="text-xs text-slate-400 font-normal">Paket</span></p>
            </div>
            <div class="w-px bg-slate-200"></div>
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">On Process</p>
                <p class="text-3xl font-black text-orange-600">{{ $sedang_dikirim + $siap_dikirim }} <span class="text-xs text-orange-400 font-normal">Paket</span></p>
            </div>
        </div>
        
        <!-- Deco -->
        <div class="absolute -left-10 -bottom-10 w-64 h-64 bg-orange-100 rounded-full blur-3xl opacity-50"></div>
    </div>

    <!-- Metrics & Visualization -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Status Cards (Stacked) -->
        <div class="space-y-6">
            <!-- Ready to Ship -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm flex items-center justify-between group hover:border-indigo-200 transition-colors">
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Siap Dikirim</p>
                    <h3 class="text-4xl font-black text-indigo-900">{{ $siap_dikirim }}</h3>
                </div>
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-box-open"></i>
                </div>
            </div>

            <!-- In Transit -->
            <div class="bg-gradient-to-br from-orange-500 to-amber-600 p-8 rounded-[2.5rem] shadow-xl text-white flex items-center justify-between relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-xs font-black text-orange-100 uppercase tracking-widest mb-1">Dalam Perjalanan</p>
                    <h3 class="text-4xl font-black">{{ $sedang_dikirim }}</h3>
                </div>
                <div class="relative z-10 w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-white text-xl backdrop-blur-md">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/diagonal-stripes.png')] opacity-10"></div>
            </div>

            <!-- Delivered -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm flex items-center justify-between group hover:border-emerald-200 transition-colors">
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Terkirim Sukses</p>
                    <h3 class="text-4xl font-black text-emerald-900">{{ $sampai_tujuan }}</h3>
                </div>
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-house-chimney"></i>
                </div>
            </div>
        </div>

        <!-- Shipment Map/Chart Placeholder -->
        <div class="lg:col-span-2 bg-slate-900 rounded-[3rem] p-10 relative overflow-hidden flex flex-col justify-between shadow-2xl">
            <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px]"></div>
            
            <div class="relative z-10 flex justify-between items-start mb-8">
                <div>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">Sebaran Pengiriman</h3>
                    <p class="text-slate-400 text-xs font-bold mt-1">Visualisasi Zona Distribusi</p>
                </div>
                <div class="flex gap-2">
                    <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                    <span class="w-3 h-3 rounded-full bg-indigo-500"></span>
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                </div>
            </div>

            <!-- Stylized Map Representation (CSS Only) -->
            <div class="relative flex-1 flex items-center justify-center min-h-[250px]">
                <div class="w-full max-w-md aspect-video border-2 border-dashed border-slate-700 rounded-3xl flex items-center justify-center relative">
                    <span class="text-slate-600 text-xs font-mono uppercase">Peta Distribusi Real-time</span>
                    
                    <!-- Nodes -->
                    <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-orange-500 rounded-full animate-ping"></div>
                    <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-orange-500 rounded-full"></div>
                    
                    <div class="absolute bottom-1/3 right-1/3 w-3 h-3 bg-indigo-500 rounded-full animate-pulse"></div>
                    
                    <div class="absolute top-1/2 right-1/4 w-3 h-3 bg-emerald-500 rounded-full"></div>
                    
                    <!-- Lines -->
                    <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-30">
                        <line x1="25%" y1="25%" x2="66%" y2="66%" stroke="white" stroke-width="1" stroke-dasharray="5,5" />
                        <line x1="25%" y1="25%" x2="75%" y2="50%" stroke="white" stroke-width="1" stroke-dasharray="5,5" />
                    </svg>
                </div>
            </div>

            <div class="relative z-10 mt-8 grid grid-cols-3 gap-4 text-center">
                <div class="bg-white/5 rounded-2xl p-3">
                    <p class="text-[9px] font-black text-slate-400 uppercase">Jawa</p>
                    <p class="text-lg font-bold text-white">65%</p>
                </div>
                <div class="bg-white/5 rounded-2xl p-3">
                    <p class="text-[9px] font-black text-slate-400 uppercase">Sumatera</p>
                    <p class="text-lg font-bold text-white">20%</p>
                </div>
                <div class="bg-white/5 rounded-2xl p-3">
                    <p class="text-[9px] font-black text-slate-400 uppercase">Lainnya</p>
                    <p class="text-lg font-bold text-white">15%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Shipments Table -->
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-sm">Aktivitas Pengiriman Terkini</h3>
            <a href="#" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Resi & Pesanan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tujuan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Update Terakhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pengiriman_terkini as $kirim)
                    <tr class="group hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-white group-hover:text-orange-500 group-hover:shadow-md transition-all">
                                    <i class="fa-solid fa-box"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900 font-mono">{{ $kirim->resi_pengiriman ?? 'PENDING' }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">INV: {{ $kirim->nomor_faktur }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-xs font-bold text-slate-800 line-clamp-1">{{ $kirim->pengguna->nama }}</p>
                            <p class="text-[10px] text-slate-400 truncate max-w-[200px]">{{ $kirim->alamat_pengiriman }}</p>
                        </td>
                        <td class="px-6 py-6">
                            @php
                                $badgeColor = match($kirim->status_pesanan) {
                                    'diproses' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                    'dikirim' => 'bg-orange-50 text-orange-600 border-orange-100',
                                    'selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    default => 'bg-slate-50 text-slate-600 border-slate-100'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $badgeColor }}">
                                {{ $kirim->status_pesanan }}
                            </span>
                        </td>
                        <td class="px-6 py-6 text-right">
                            <p class="text-xs font-bold text-slate-700">{{ $kirim->diperbarui_pada->diffForHumans() }}</p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-slate-400 font-medium text-xs">Belum ada aktivitas pengiriman terbaru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
