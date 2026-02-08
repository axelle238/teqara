<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 animate-in fade-in zoom-in duration-700">
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
        
        <!-- SIDEBAR NAVIGASI (Sticky) -->
        <div class="hidden lg:block lg:col-span-1">
            <div class="sticky top-32">
                <x-pelanggan.sidebar-nav />
            </div>
        </div>

        <!-- KONTEN UTAMA -->
        <div class="lg:col-span-3 space-y-10">

            <!-- HEADER HUB: IDENTITAS PELANGGAN -->
            <div class="relative overflow-hidden rounded-[3rem] bg-slate-900 border border-white/5 shadow-2xl p-10 text-white group">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/20 via-transparent to-rose-600/10"></div>
                <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px] group-hover:scale-110 transition-transform duration-1000"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-500/20 rounded-full border border-indigo-500/30 mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-[9px] font-black text-indigo-200 uppercase tracking-widest">{{ $this->stats['level'] }} Member Access</span>
                        </div>
                        <h2 class="text-4xl font-black tracking-tighter leading-none italic">Pusat Kendali <br> <span class="text-indigo-400">{{ explode(' ', $this->stats['nama'])[0] }}</span></h2>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 w-full md:w-auto">
                        <div class="bg-white/5 backdrop-blur-md rounded-[2rem] p-5 border border-white/10 text-center min-w-[140px]">
                            <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Pesanan Aktif</p>
                            <p class="text-3xl font-black text-white italic">{{ $this->stats['pesanan_aktif'] }}</p>
                        </div>
                        <div class="bg-indigo-600 rounded-[2rem] p-5 shadow-xl shadow-indigo-500/20 text-center min-w-[140px]">
                            <p class="text-[9px] font-black text-indigo-200 uppercase tracking-widest mb-1">Loyalitas Poin</p>
                            <p class="text-3xl font-black text-white italic">{{ number_format($this->stats['poin']) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TIMELINE PESANAN BERJALAN -->
            <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 p-8" wire:poll.10s>
                <div class="flex items-center justify-between border-b border-slate-50 pb-6 mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shadow-inner"><i class="fa-solid fa-truck-fast"></i></div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tighter italic">Status Pengiriman</h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Realtime Update</p>
                        </div>
                    </div>
                    @if($this->pesananBerjalan)
                        <span class="px-4 py-1.5 bg-slate-900 text-white rounded-xl text-[10px] font-black tracking-widest italic animate-pulse">#{{ $this->pesananBerjalan->nomor_faktur }}</span>
                    @endif
                </div>

                @if($this->pesananBerjalan)
                <div class="relative py-6">
                    <!-- Progress Bar Background -->
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
                    
                    <!-- Steps -->
                    <div class="relative z-10 flex justify-between px-2">
                        @foreach(['menunggu', 'diproses', 'dikirim', 'selesai'] as $step)
                        <div class="flex flex-col items-center gap-4 group">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-lg transition-all duration-500 {{ $this->pesananBerjalan->status_pesanan == $step ? 'bg-indigo-600 text-white scale-110 shadow-xl shadow-indigo-500/40 rotate-6' : ($progres >= match($step){'menunggu'=>20,'diproses'=>50,'dikirim'=>80,'selesai'=>100} ? 'bg-emerald-500 text-white' : 'bg-white border-2 border-slate-100 text-slate-300') }}">
                                <i class="fa-solid fa-{{ match($step){'menunggu'=>'clock','diproses'=>'gears','dikirim'=>'truck-fast','selesai'=>'circle-check'} }}"></i>
                            </div>
                            <span class="hidden sm:block text-[8px] font-black uppercase tracking-widest {{ $this->pesananBerjalan->status_pesanan == $step ? 'text-indigo-600' : 'text-slate-400' }}">{{ $step }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="mt-8 bg-indigo-50/50 rounded-2xl p-6 border border-indigo-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <p class="text-xs font-bold text-indigo-900 leading-relaxed italic text-center sm:text-left">
                        <i class="fa-solid fa-circle-info mr-2 text-indigo-500"></i>
                        Estimasi tiba: <span class="text-indigo-600 font-black">2-3 Hari Kerja</span>. Kurir sedang dalam perjalanan menuju hub sortir.
                    </p>
                    <a href="{{ route('pesanan.lacak', $this->pesananBerjalan->nomor_faktur) }}" class="px-6 py-3 bg-white text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm hover:shadow-xl transition-all whitespace-nowrap border border-indigo-100 hover:border-indigo-300">
                        Detail Pelacakan
                    </a>
                </div>
                @else
                <div class="py-16 text-center bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl text-slate-300 shadow-sm"><i class="fa-solid fa-box-open"></i></div>
                    <h4 class="text-sm font-black text-slate-900 uppercase italic">Belum Ada Pesanan Aktif</h4>
                    <a href="/katalog" class="mt-6 inline-block px-8 py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg hover:bg-indigo-600 transition-all">Mulai Belanja</a>
                </div>
                @endif
            </div>

            <!-- GRID INFO & REKOMENDASI -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                
                <!-- REKOMENDASI CERDAS -->
                <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 p-8 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight italic">Pilihan <span class="text-indigo-600">Untuk Anda</span></h3>
                        <button class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition-colors flex items-center justify-center">
                            <i class="fa-solid fa-rotate text-xs"></i>
                        </button>
                    </div>
                    <div class="space-y-4">
                        @foreach($this->rekomendasi as $item)
                        <div class="flex items-center gap-4 group cursor-pointer hover:bg-slate-50 p-2 rounded-2xl transition-colors">
                            <div class="w-16 h-16 rounded-xl bg-slate-100 overflow-hidden relative shrink-0">
                                <img src="{{ $item->gambar_utama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-slate-900 truncate group-hover:text-indigo-600 transition-colors">{{ $item->nama }}</h4>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">{{ $item->kategori->nama ?? 'Umum' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-black text-slate-900">Rp{{ number_format($item->harga_jual, 0, ',', '.') }}</p>
                                <button wire:click="$dispatch('addToCart', {id: {{ $item->id }}})" class="mt-1 w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-colors flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- RIWAYAT RINGKAS -->
                <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 p-8 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight italic">Riwayat <span class="text-indigo-600">Terbaru</span></h3>
                        <a href="{{ route('pesanan.riwayat') }}" class="text-[9px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600">Lihat Semua</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($this->pesananTerakhir as $pesanan)
                        <div class="flex items-center justify-between p-4 bg-slate-50/50 rounded-2xl border border-slate-50 hover:border-indigo-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 shadow-sm">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-900">#{{ $pesanan->nomor_faktur }}</p>
                                    <p class="text-[9px] text-slate-400 uppercase tracking-wide font-bold">{{ $pesanan->dibuat_pada->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-{{ $pesanan->status_pesanan == 'selesai' ? 'emerald' : 'amber' }}-100 text-{{ $pesanan->status_pesanan == 'selesai' ? 'emerald' : 'amber' }}-600 rounded-lg text-[8px] font-black uppercase tracking-widest">
                                {{ $pesanan->status_pesanan }}
                            </span>
                        </div>
                        @empty
                        <div class="text-center py-10 text-slate-400 text-xs">Belum ada riwayat pesanan.</div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
