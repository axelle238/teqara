<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 animate-in fade-in zoom-in duration-700 space-y-10">
    
    <!-- HEADER HUB: IDENTITAS PELANGGAN -->
    <div class="relative overflow-hidden rounded-[4rem] bg-slate-900 border border-white/5 shadow-2xl p-10 sm:p-16 text-white group">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/20 via-transparent to-rose-600/10"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px] group-hover:scale-110 transition-transform duration-1000"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-12">
            <div class="flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
                <div class="w-28 h-24 rounded-[3rem] bg-gradient-to-tr from-indigo-500 to-purple-500 p-1 shadow-2xl shadow-indigo-500/40 transform -rotate-3 group-hover:rotate-0 transition-transform duration-500">
                    <div class="w-full h-full bg-slate-900 rounded-[2.8rem] flex items-center justify-center text-5xl font-black italic">
                        {{ substr($this->stats['nama'], 0, 1) }}
                    </div>
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-500/20 rounded-full border border-indigo-500/30 mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-[9px] font-black text-indigo-200 uppercase tracking-widest">{{ $this->stats['level'] }} Member Access</span>
                    </div>
                    <h2 class="text-4xl sm:text-5xl font-black tracking-tighter leading-none italic">Pusat Kendali <br> <span class="text-indigo-400">{{ explode(' ', $this->stats['nama'])[0] }}</span></h2>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 w-full lg:w-auto">
                <div class="bg-white/5 backdrop-blur-md rounded-[2.5rem] p-6 border border-white/10 text-center min-w-[160px]">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Pesanan Aktif</p>
                    <p class="text-3xl font-black text-white italic">{{ $this->stats['pesanan_aktif'] }}</p>
                </div>
                <div class="bg-indigo-600 rounded-[2.5rem] p-6 shadow-xl shadow-indigo-500/20 text-center min-w-[160px]">
                    <p class="text-[10px] font-black text-indigo-200 uppercase tracking-widest mb-1">Loyalitas Poin</p>
                    <p class="text-3xl font-black text-white italic">{{ number_format($this->stats['poin']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN GRID: TIMELINE & ANALYTICS -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
        
        <!-- TIMELINE PESANAN BERJALAN -->
        <div class="xl:col-span-2 bg-white rounded-[50px] shadow-sm border border-slate-100 p-10 space-y-8">
            <div class="flex items-center justify-between border-b border-slate-50 pb-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shadow-inner"><i class="fa-solid fa-truck-fast"></i></div>
                    <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tighter italic">Alur Pesanan <span class="text-emerald-500">Terkini</span></h3>
                </div>
                @if($this->pesananBerjalan)
                    <span class="px-4 py-1.5 bg-slate-900 text-white rounded-xl text-[10px] font-black tracking-widest italic">#{{ $this->pesananBerjalan->nomor_faktur }}</span>
                @endif
            </div>

            @if($this->pesananBerjalan)
            <div class="relative py-10">
                <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-100 -translate-y-1/2 rounded-full overflow-hidden">
                    @php
                        $progres = match($this->pesananBerjalan->status_pesanan) {
                            'menunggu' => 20,
                            'diproses' => 50,
                            'dikirim' => 80,
                            'selesai' => 100,
                            default => 0
                        };
                    @endphp
                    <div class="h-full bg-gradient-to-r from-indigo-500 to-emerald-500 transition-all duration-1000 shadow-lg shadow-emerald-500/40" style="width: {{ $progres }}%"></div>
                </div>
                <div class="relative z-10 flex justify-between px-2 sm:px-10">
                    @foreach(['menunggu', 'diproses', 'dikirim', 'selesai'] as $step)
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-xl transition-all duration-500 {{ $this->pesananBerjalan->status_pesanan == $step ? 'bg-indigo-600 text-white scale-110 shadow-xl shadow-indigo-500/40 rotate-12' : ($progres >= match($step){'menunggu'=>20,'diproses'=>50,'dikirim'=>80,'selesai'=>100} ? 'bg-emerald-500 text-white' : 'bg-white border-4 border-slate-100 text-slate-300') }}">
                            <i class="fa-solid fa-{{ match($step){'menunggu'=>'clock','diproses'=>'gears','dikirim'=>'truck-fast','selesai'=>'circle-check'} }}"></i>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest {{ $this->pesananBerjalan->status_pesanan == $step ? 'text-indigo-600' : 'text-slate-400' }}">{{ $step }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-indigo-50/50 rounded-3xl p-6 border border-indigo-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                <p class="text-sm font-bold text-indigo-900 leading-relaxed italic text-center sm:text-left">"Pesanan Anda saat ini sedang dalam tahap <span class="text-indigo-600 uppercase">{{ $this->pesananBerjalan->status_pesanan }}</span>. Tim kami sedang mengoptimalkan pengiriman aset Anda."</p>
                <a href="{{ route('pesanan.lacak', $this->pesananBerjalan->nomor_faktur) }}" class="px-8 py-4 bg-white text-indigo-600 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-sm hover:shadow-xl transition-all whitespace-nowrap">Lacak Unit Sekarang</a>
            </div>
            @else
            <div class="py-20 text-center bg-slate-50 rounded-[40px] border-2 border-dashed border-slate-200">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 text-3xl text-slate-300 shadow-sm"><i class="fa-solid fa-box-open"></i></div>
                <h4 class="text-xl font-black text-slate-900 uppercase italic">Belum Ada Pesanan Aktif</h4>
                <p class="text-slate-400 font-medium text-sm mt-2 max-w-sm mx-auto">Seluruh aset teknologi pesanan Anda telah terselesaikan. Mari eksplorasi inovasi terbaru di katalog kami!</p>
                <a href="/katalog" class="mt-8 inline-block px-10 py-5 bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-500/20 hover:scale-105 transition-all">Mulai Belanja</a>
            </div>
            @endif
        </div>

        <!-- SIDEBAR HUB: LOYALITAS & LAYANAN -->
        <div class="space-y-10">
            <!-- PROGRES LOYALITAS -->
            <div class="bg-white rounded-[50px] shadow-sm border border-slate-100 p-8 space-y-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full blur-3xl -mr-16 -mt-16 opacity-50"></div>
                <div class="flex items-center justify-between relative z-10 border-b border-slate-50 pb-4">
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight italic">Status <span class="text-indigo-600">Loyalitas</span></h3>
                    <i class="fa-solid fa-crown text-amber-400 text-xl group-hover:rotate-12 transition-transform"></i>
                </div>
                <div class="space-y-4 relative z-10">
                    <div class="flex justify-between items-end">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Target Gold Member</p>
                        <p class="text-xs font-black text-indigo-600">{{ round($this->stats['progres_level']) }}%</p>
                    </div>
                    <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden shadow-inner p-0.5">
                        <div class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-600 rounded-full transition-all duration-1000 shadow-lg" style="width: {{ $this->stats['progres_level'] }}%"></div>
                    </div>
                    <p class="text-[10px] text-slate-400 font-medium leading-relaxed italic">Kumpulkan <span class="text-indigo-600 font-black">2.450 poin</span> lagi untuk membuka benefit exclusive Gold Member.</p>
                </div>
            </div>

            <!-- AKSES CEPAT LAYANAN -->
            <div class="grid grid-cols-2 gap-6">
                <a href="{{ route('pelanggan.voucher') }}" class="p-6 bg-rose-50 rounded-[3rem] border border-rose-100 hover:scale-105 transition-all group shadow-sm hover:shadow-xl hover:shadow-rose-500/10">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-xl text-rose-500 mb-4 shadow-sm group-hover:bg-rose-500 group-hover:text-white transition-all"><i class="fa-solid fa-ticket"></i></div>
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest italic">{{ $this->stats['voucher_tersedia'] }} Voucher</h4>
                    <p class="text-[9px] font-bold text-rose-400 uppercase tracking-widest mt-1 italic">Siap Digunakan</p>
                </a>
                <a href="/bantuan" class="p-6 bg-indigo-50 rounded-[3rem] border border-indigo-100 hover:scale-105 transition-all group shadow-sm hover:shadow-xl hover:shadow-indigo-500/10">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-xl text-indigo-500 mb-4 shadow-sm group-hover:bg-indigo-500 group-hover:text-white transition-all"><i class="fa-solid fa-headset"></i></div>
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest italic">{{ $this->stats['tiket_terbuka'] }} Bantuan</h4>
                    <p class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest mt-1 italic">Butuh Solusi?</p>
                </a>
            </div>
        </div>

    </div>

    <!-- AREA TRANSAKSI: RIWAYAT TERAKHIR -->
    <div class="bg-white rounded-[50px] shadow-sm border border-slate-100 p-10 space-y-10">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center text-xl shadow-2xl italic">T</div>
                <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tighter italic">Arsip Belanja <span class="text-indigo-600">Terakhir</span></h3>
            </div>
            <a href="{{ route('pesanan.riwayat') }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline">Monitor Seluruh Riwayat</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="py-6 px-4">Invoice</th>
                        <th class="py-6 px-4">Data Aset</th>
                        <th class="py-6 px-4 text-right">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($this->pesananTerakhir as $pesanan)
                    <tr class="group hover:bg-slate-50 transition-colors">
                        <td class="py-6 px-4">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black tracking-widest group-hover:bg-indigo-600 group-hover:text-white transition-colors italic">#{{ $pesanan->nomor_faktur }}</span>
                        </td>
                        <td class="py-6 px-4">
                            <p class="text-sm font-bold text-slate-800 italic">{{ $pesanan->items_count ?? ($pesanan->detailPesanan ? $pesanan->detailPesanan->count() : 0) }} Unit Perangkat</p>
                            <p class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">{{ $pesanan->dibuat_pada->translatedFormat('d M Y, H:i') }} WIB</p>
                        </td>
                        <td class="py-6 px-4 text-right">
                            <a href="{{ route('pesanan.lacak', $pesanan->nomor_faktur) }}" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-200 text-slate-400 rounded-xl hover:text-indigo-600 hover:border-indigo-200 hover:shadow-lg transition-all"><i class="fa-solid fa-arrow-right-long"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
