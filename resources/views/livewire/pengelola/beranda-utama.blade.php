<div class="space-y-8 pb-20 animate-in fade-in zoom-in duration-500">
    
    <!-- Hero Welcome -->
    <div class="relative bg-gradient-to-r from-slate-900 to-indigo-900 rounded-[2.5rem] p-10 overflow-hidden shadow-2xl shadow-indigo-900/20 text-white">
        <!-- Decor -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px] translate-y-1/2 -translate-x-1/2"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-4xl shadow-inner">
                    👋
                </div>
                <div>
                    <p class="text-indigo-300 font-black text-xs uppercase tracking-[0.2em] mb-1">Selamat Datang Kembali</p>
                    <h1 class="text-4xl font-black tracking-tight">{{ auth()->user()->nama }}</h1>
                    <p class="text-slate-400 text-sm mt-2 font-medium">Berikut adalah ringkasan kinerja bisnis Anda hari ini.</p>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('pengelola.laporan.pusat') }}" wire:navigate class="px-6 py-3 bg-white text-indigo-900 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-50 transition-all shadow-lg">
                    Lihat Laporan Lengkap
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Revenue -->
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:border-emerald-100 transition-all duration-300 group">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-widest">+12%</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Pendapatan Bulan Ini</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tighter">Rp {{ number_format($this->stats['pendapatan_bulan_ini']/1000000, 1, ',', '.') }}Jt</h3>
        </div>

        <!-- Orders -->
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-100 transition-all duration-300 group">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 text-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                @if($this->stats['pesanan_baru'] > 0)
                    <span class="px-3 py-1 bg-rose-50 text-rose-600 rounded-lg text-[10px] font-black uppercase tracking-widest animate-pulse">Action Needed</span>
                @endif
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Pesanan Baru</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ $this->stats['pesanan_baru'] }} Order</h3>
        </div>

        <!-- Products -->
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:border-cyan-100 transition-all duration-300 group">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-cyan-50 flex items-center justify-center text-cyan-600 text-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <span class="px-3 py-1 bg-cyan-50 text-cyan-600 rounded-lg text-[10px] font-black uppercase tracking-widest">Aktif</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Total SKU Produk</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ $this->stats['produk_aktif'] }} Unit</h3>
        </div>

        <!-- Customers -->
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:border-purple-100 transition-all duration-300 group">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 text-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users"></i>
                </div>
                <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-lg text-[10px] font-black uppercase tracking-widest">New</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Pelanggan Baru</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tighter">+{{ $this->stats['pelanggan_baru'] }}</h3>
        </div>
    </div>

    <!-- Main Content Split -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Live Transaction Feed -->
        <div class="lg:col-span-2 bg-white rounded-[3rem] border border-slate-100 shadow-xl shadow-slate-200/50 p-8 flex flex-col">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Transaksi Terkini</h3>
                    <p class="text-xs text-slate-500 font-medium">Real-time data masuk.</p>
                </div>
                <a href="{{ route('pengelola.pesanan.daftar') }}" class="px-5 py-2 bg-slate-50 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-100 transition-colors">
                    Lihat Semua
                </a>
            </div>

            <div class="flex-1 space-y-4">
                @forelse($this->pesananTerbaru as $p)
                <div class="group flex items-center gap-4 p-4 rounded-[2rem] hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-all cursor-default">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-sm shadow-sm group-hover:scale-110 transition-transform">
                        {{ substr($p->pengguna->nama, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="text-sm font-bold text-slate-900 truncate">{{ $p->pengguna->nama }}</h4>
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[9px] font-black uppercase tracking-widest">#{{ $p->nomor_faktur }}</span>
                        </div>
                        <p class="text-xs text-slate-400">{{ $p->dibuat_pada->diffForHumans() }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-slate-900">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</p>
                        <span class="text-[9px] font-bold uppercase tracking-widest {{ $p->status_pesanan == 'selesai' ? 'text-emerald-500' : ($p->status_pesanan == 'dibatalkan' ? 'text-rose-500' : 'text-amber-500') }}">
                            {{ $p->status_pesanan }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                    <i class="fa-solid fa-clipboard-list text-4xl mb-4 opacity-30"></i>
                    <p class="text-xs font-bold uppercase tracking-widest">Belum ada data transaksi.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Action Center -->
        <div class="bg-slate-900 rounded-[3rem] p-8 text-white relative overflow-hidden flex flex-col shadow-2xl shadow-indigo-900/30">
            <!-- Background -->
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10 mix-blend-soft-light"></div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-indigo-500 rounded-full blur-[80px] opacity-50"></div>

            <div class="relative z-10 mb-8">
                <h3 class="text-xl font-black uppercase tracking-tight mb-2">Aksi Cepat</h3>
                <p class="text-slate-400 text-xs font-medium">Jalan pintas operasional harian.</p>
            </div>

            <div class="relative z-10 grid gap-4">
                <a href="{{ route('pengelola.produk.tambah') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/5 transition-all group backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-plus text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">Tambah Produk</h4>
                        <p class="text-[10px] text-slate-400">Update katalog inventaris</p>
                    </div>
                </a>

                <a href="{{ route('pengelola.produk.stok') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/5 transition-all group backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-boxes-stacked text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">Update Stok</h4>
                        <p class="text-[10px] text-slate-400">Mutasi barang masuk/keluar</p>
                    </div>
                </a>

                <a href="{{ route('pengelola.toko.berita') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/5 transition-all group backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-orange-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-pen-nib text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">Tulis Berita</h4>
                        <p class="text-[10px] text-slate-400">Publikasi konten baru</p>
                    </div>
                </a>
            </div>

            <div class="mt-auto pt-8 relative z-10">
                <div class="p-4 rounded-2xl bg-indigo-600/50 border border-indigo-500/30 backdrop-blur-md">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fa-solid fa-server text-indigo-300"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest text-indigo-200">Status Server</span>
                    </div>
                    <div class="w-full bg-slate-900/50 rounded-full h-1.5 mb-2 overflow-hidden">
                        <div class="bg-emerald-400 h-full rounded-full animate-pulse" style="width: 98%"></div>
                    </div>
                    <div class="flex justify-between text-[9px] font-bold text-indigo-300">
                        <span>Uptime: 99.9%</span>
                        <span>Load: Low</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>