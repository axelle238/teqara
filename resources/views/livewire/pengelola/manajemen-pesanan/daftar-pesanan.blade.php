<div class="space-y-10 animate-in fade-in duration-500 pb-32">
    
    <!-- 1. HEADER & KPI STATUS -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-4 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50 relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
            <div class="relative z-10 space-y-2">
                <h1 class="text-4xl font-black text-slate-900 tracking-tight uppercase leading-none">Pusat <span class="text-amber-600">Pesanan</span></h1>
                <p class="text-slate-500 font-medium tracking-wide italic">Monitor arus transaksi dan alur logistik real-time.</p>
            </div>
            <div class="flex flex-wrap items-center gap-4 relative z-10">
                <div class="px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Pesanan</p>
                    <p class="text-xl font-black text-slate-900">{{ $this->statistik['total'] }}</p>
                </div>
                <div class="px-6 py-4 bg-amber-50 rounded-2xl border border-amber-100 text-center">
                    <p class="text-[9px] font-black text-amber-600 uppercase tracking-widest mb-1">Menunggu</p>
                    <p class="text-xl font-black text-amber-700">{{ $this->statistik['menunggu'] }}</p>
                </div>
                <div class="px-6 py-4 bg-blue-50 rounded-2xl border border-blue-100 text-center">
                    <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest mb-1">Diproses</p>
                    <p class="text-xl font-black text-blue-700">{{ $this->statistik['diproses'] }}</p>
                </div>
                <div class="px-6 py-4 bg-emerald-50 rounded-2xl border border-emerald-100 text-center">
                    <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-1">Selesai</p>
                    <p class="text-xl font-black text-emerald-700">{{ $this->statistik['selesai'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TOOLBAR FILTER & CARI -->
    <div class="bg-white p-6 rounded-[35px] border border-indigo-50 flex flex-col xl:flex-row gap-6 justify-between items-center shadow-sm">
        <div class="flex flex-wrap gap-3 w-full xl:w-auto">
            @php
                $statusTabs = [
                    'semua' => ['label' => 'SEMUA PESANAN', 'color' => 'bg-slate-900'],
                    'menunggu' => ['label' => 'MENUNGGU', 'color' => 'bg-amber-500'],
                    'diproses' => ['label' => 'DIPROSES', 'color' => 'bg-blue-500'],
                    'dikirim' => ['label' => 'DIKIRIM', 'color' => 'bg-purple-500'],
                    'selesai' => ['label' => 'SELESAI', 'color' => 'bg-emerald-500'],
                    'batal' => ['label' => 'DIBATALKAN', 'color' => 'bg-rose-500'],
                ];
            @endphp
            @foreach($statusTabs as $key => $tab)
            <button wire:click="setStatus('{{ $key }}')" class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterStatus === $key ? $tab['color'].' text-white shadow-lg' : 'bg-slate-50 text-slate-400 hover:bg-slate-100' }}">
                {{ $tab['label'] }}
            </button>
            @endforeach
        </div>

        <div class="relative w-full xl:w-96">
            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari No. Faktur atau Nama Pelanggan..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-amber-500/10 placeholder:text-slate-300">
        </div>
    </div>

    <!-- 3. DAFTAR PESANAN (REAL-TIME LIST) -->
    <div class="space-y-6">
        @forelse($pesanan as $order)
        <div class="bg-white rounded-[40px] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-500 group relative overflow-hidden">
            <!-- Order Decor -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-bl-[100px] -mr-10 -mt-10 group-hover:bg-amber-50 transition-colors"></div>
            
            <div class="flex flex-col lg:flex-row gap-10 relative z-10">
                <!-- Info Utama -->
                <div class="flex-1 space-y-6">
                    <div class="flex items-start justify-between">
                        <div class="space-y-1">
                            <span class="px-3 py-1 bg-slate-900 text-white rounded-lg text-[10px] font-black tracking-widest uppercase italic">#{{ $order->nomor_faktur }}</span>
                            <h3 class="text-xl font-black text-slate-900 mt-2">{{ $order->pengguna->nama }}</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $order->pengguna->email }} | {{ $order->pengguna->nomor_telepon ?? '-' }}</p>
                        </div>
                        <div class="text-right">
                            @php
                                $statusStyle = match($order->status_pesanan) {
                                    'menunggu' => 'bg-amber-100 text-amber-600 border-amber-200',
                                    'diproses' => 'bg-blue-100 text-blue-600 border-blue-200',
                                    'dikirim' => 'bg-purple-100 text-purple-600 border-purple-200',
                                    'selesai' => 'bg-emerald-100 text-emerald-600 border-emerald-200',
                                    'batal' => 'bg-rose-100 text-rose-600 border-rose-200',
                                    default => 'bg-slate-100 text-slate-600 border-slate-200'
                                };
                            @endphp
                            <span class="px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $statusStyle }}">
                                {{ strtoupper($order->status_pesanan) }}
                            </span>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-3">{{ $order->dibuat_pada->translatedFormat('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>

                    <!-- Ringkasan Produk -->
                    <div class="flex flex-wrap gap-4">
                        @foreach($order->detailPesanan->take(3) as $detail)
                        <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-2xl border border-slate-100 shadow-inner">
                            <div class="w-10 h-10 rounded-xl bg-white overflow-hidden flex-shrink-0 border border-slate-200">
                                <img src="{{ $detail->produk->gambar_utama }}" class="w-full h-full object-cover">
                            </div>
                            <div class="leading-none">
                                <p class="text-[10px] font-black text-slate-800 line-clamp-1 italic">{{ $detail->produk->nama }}</p>
                                <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase">{{ $detail->jumlah }} Unit x Rp{{ number_format($detail->harga_saat_ini, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                        @if($order->detailPesanan->count() > 3)
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-[10px] font-black text-amber-600 border border-amber-100">
                            +{{ $order->detailPesanan->count() - 3 }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Finansial & Aksi -->
                <div class="w-full lg:w-80 flex flex-col justify-between border-l border-slate-50 lg:pl-10">
                    <div class="space-y-1 text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Total Transaksi</p>
                        <p class="text-3xl font-black text-slate-900 tracking-tighter italic">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                        <p class="text-[9px] font-bold {{ $order->status_pembayaran === 'dibayar' ? 'text-emerald-500' : 'text-rose-500' }} uppercase tracking-widest">
                            <i class="fa-solid {{ $order->status_pembayaran === 'dibayar' ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-1"></i>
                            {{ $order->status_pembayaran === 'dibayar' ? 'Pembayaran Berhasil' : 'Menunggu Pembayaran' }}
                        </p>
                    </div>

                    <div class="mt-8 space-y-4">
                        @if($order->status_pesanan === 'menunggu')
                            <button wire:click="prosesPesanan({{ $order->id }})" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-blue-600/30 transition-all active:scale-95">PROSES PESANAN SEKARANG</button>
                        @elseif($order->status_pesanan === 'diproses')
                            <div class="space-y-3">
                                <input type="text" wire:model="inputResi.{{ $order->id }}" placeholder="Input Nomor Resi..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest shadow-inner focus:ring-2 focus:ring-purple-500/20">
                                <button wire:click="kirimPesanan({{ $order->id }})" class="w-full py-4 bg-purple-600 hover:bg-purple-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-purple-600/30 transition-all">KONFIRMASI PENGIRIMAN</button>
                            </div>
                        @endif
                        
                        <div class="flex gap-3">
                            <a href="{{ route('pengelola.pesanan.detail', $order->id) }}" wire:navigate class="flex-1 py-3 bg-slate-50 text-slate-600 hover:bg-slate-900 hover:text-white rounded-xl text-[9px] font-black uppercase tracking-widest transition-all text-center">DETAIL LENGKAP</a>
                            @if(in_array($order->status_pesanan, ['menunggu', 'diproses']))
                            <button wire:click="batalkanPesanan({{ $order->id }})" wire:confirm="Yakin membatalkan pesanan ini?" class="w-12 h-12 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl flex items-center justify-center transition-all shadow-sm"><i class="fa-solid fa-ban"></i></button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="py-32 text-center bg-white rounded-[50px] border-2 border-dashed border-slate-100">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner text-4xl grayscale opacity-30">📦</div>
            <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Tidak Ada Pesanan</h3>
            <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Belum ada transaksi masuk untuk filter ini.</p>
        </div>
        @endforelse
    </div>

    <!-- 4. PAGINASI -->
    <div class="pt-10">
        {{ $pesanan->links() }}
    </div>

</div>