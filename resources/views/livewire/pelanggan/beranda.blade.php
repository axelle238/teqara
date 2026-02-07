<div class="bg-slate-50 min-h-screen py-12 relative overflow-hidden font-sans antialiased text-slate-900">
    <!-- Background Decor -->
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none -z-0">
        <div class="absolute top-[-10%] left-[-5%] w-[40%] h-[40%] bg-indigo-500/5 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[30%] h-[30%] bg-cyan-500/5 blur-[100px] rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header & Welcome -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-12">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-[2rem] bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white text-3xl font-black shadow-2xl shadow-indigo-500/20">
                    {{ substr(auth()->user()->nama, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-black tracking-tight uppercase leading-none mb-2">Pusat <span class="text-indigo-600">Otoritas</span></h1>
                    <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Selamat Datang, {{ auth()->user()->nama }}</p>
                </div>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('katalog') }}" class="px-6 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">Katalog Toko</a>
                <a href="{{ route('pelanggan.profil') }}" class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg shadow-slate-900/20">Edit Profil</a>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-white rounded-[2.5rem] p-8 border border-white shadow-xl shadow-slate-200/50 group hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">💎</div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Poin Loyalitas</p>
                <h3 class="text-2xl font-black text-slate-900">{{ number_format($this->stats['poin']) }}</h3>
            </div>
            <div class="bg-white rounded-[2.5rem] p-8 border border-white shadow-xl shadow-slate-200/50 group hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">🏆</div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Level Member</p>
                <h3 class="text-2xl font-black text-indigo-600 uppercase italic">{{ $this->stats['level'] }}</h3>
            </div>
            <div class="bg-white rounded-[2.5rem] p-8 border border-white shadow-xl shadow-slate-200/50 group hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">📦</div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Pesanan Aktif</p>
                <h3 class="text-2xl font-black text-slate-900">{{ $this->stats['pesanan_aktif'] }} Unit</h3>
            </div>
            <div class="bg-white rounded-[2.5rem] p-8 border border-white shadow-xl shadow-slate-200/50 group hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">🎫</div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tiket Terbuka</p>
                <h3 class="text-2xl font-black text-slate-900">{{ $this->stats['tiket_terbuka'] }} Aktif</h3>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-10">
            <!-- Kolom Kiri: Pesanan Terbaru & Rekomendasi -->
            <div class="lg:col-span-2 space-y-12">
                <div class="bg-white rounded-[3rem] border border-white shadow-2xl shadow-slate-200/50 overflow-hidden">
                    <div class="px-10 py-8 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Pesanan Terbaru</h3>
                        <a href="{{ route('pesanan.riwayat') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Lihat Semua</a>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @forelse($this->pesananTerakhir as $pesanan)
                        <div class="px-10 py-8 flex flex-col sm:flex-row sm:items-center justify-between gap-6 hover:bg-slate-50/50 transition-colors">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-2xl">🚛</div>
                                <div>
                                    <h4 class="font-black text-slate-900">#{{ $pesanan->nomor_faktur }}</h4>
                                    <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1">{{ $pesanan->dibuat_pada->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-6 justify-between sm:justify-end">
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest 
                                    {{ $pesanan->status_pesanan == 'selesai' ? 'bg-emerald-100 text-emerald-600' : 
                                       ($pesanan->status_pesanan == 'dibatalkan' ? 'bg-rose-100 text-rose-600' : 'bg-amber-100 text-amber-600') }}">
                                    {{ $pesanan->status_pesanan }}
                                </span>
                                <div class="text-right">
                                    <p class="text-sm font-black text-slate-900">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                                    <a href="{{ route('pesanan.lacak', $pesanan->nomor_faktur) }}" class="text-[10px] font-bold text-indigo-600 hover:underline uppercase tracking-widest">Detail</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="px-10 py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">Belum ada pesanan terbaru.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Grid Menu Utama (Replacement for sidebar grid) -->
                <div>
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-8 ml-2">Modul Portal</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                        @php
                            $modules = [
                                ['icon' => '📦', 'label' => 'Riwayat Belanja', 'route' => 'pesanan.riwayat', 'color' => 'bg-blue-50'],
                                ['icon' => '📝', 'label' => 'Daftar Belanja', 'route' => 'customer.wishlist.index', 'color' => 'bg-indigo-50'],
                                ['icon' => '🎁', 'label' => 'Tukar Poin', 'route' => 'pelanggan.tukar-poin', 'color' => 'bg-amber-50'],
                                ['icon' => '💳', 'label' => 'Dompet Digital', 'route' => 'pelanggan.dompet', 'color' => 'bg-emerald-50'],
                                ['icon' => '🎫', 'label' => 'Voucher Saya', 'route' => 'pelanggan.voucher', 'color' => 'bg-purple-50'],
                                ['icon' => '📊', 'label' => 'Laporan Belanja', 'route' => 'pelanggan.laporan', 'color' => 'bg-cyan-50'],
                                ['icon' => '🏢', 'label' => 'Profil Bisnis', 'route' => 'pelanggan.profil-bisnis', 'color' => 'bg-slate-50'],
                                ['icon' => '🤝', 'label' => 'Referral', 'route' => 'pelanggan.referral', 'color' => 'bg-orange-50'],
                                ['icon' => '📍', 'label' => 'Buku Alamat', 'route' => 'pelanggan.alamat', 'color' => 'bg-rose-50'],
                                ['icon' => '🔐', 'label' => 'Keamanan', 'route' => 'pelanggan.keamanan', 'color' => 'bg-slate-50'],
                                ['icon' => '💾', 'label' => 'Unduhan', 'route' => 'pelanggan.unduhan', 'color' => 'bg-indigo-50'],
                                ['icon' => '🔔', 'label' => 'Notifikasi', 'route' => 'pelanggan.notifikasi', 'color' => 'bg-yellow-50'],
                            ];
                        @endphp
                        @foreach($modules as $mod)
                        <a href="{{ route($mod['route']) }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group">
                            <span class="text-3xl mb-3 group-hover:scale-110 transition-transform">{{ $mod['icon'] }}</span>
                            <span class="text-[10px] font-black uppercase text-slate-900 tracking-wider text-center leading-tight">{{ $mod['label'] }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Akses Cepat & CS -->
            <div class="space-y-8">
                <!-- Promo / Highlight Card -->
                <div class="bg-indigo-600 rounded-[3rem] p-10 text-white shadow-2xl shadow-indigo-500/30 relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                    <h3 class="text-xl font-black uppercase tracking-tight mb-4 leading-none">AKSES <br><span class="text-indigo-200">PRIORITAS</span></h3>
                    <p class="text-indigo-100 text-xs font-medium mb-8 leading-relaxed">Gunakan poin Anda untuk menukar voucher diskon hingga 50% khusus bulan ini.</p>
                    <a href="{{ route('pelanggan.tukar-poin') }}" class="inline-block px-6 py-3 bg-white text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 transition-all shadow-lg">Tukar Poin Sekarang</a>
                </div>

                <!-- Support Ticket Summary -->
                <div class="bg-white rounded-[3rem] p-10 border border-white shadow-xl shadow-slate-200/50">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6">Dukungan Pelanggan</h3>
                    <div class="space-y-4">
                        <a href="{{ route('bantuan') }}" class="flex items-center justify-between p-4 bg-slate-50 hover:bg-slate-100 rounded-2xl transition-colors group">
                            <span class="text-xs font-bold text-slate-600">Pusat Bantuan</span>
                            <span class="text-indigo-600 group-hover:translate-x-1 transition-transform">→</span>
                        </a>
                        <a href="{{ route('pelanggan.retur') }}" class="flex items-center justify-between p-4 bg-rose-50 hover:bg-rose-100 rounded-2xl transition-colors group">
                            <span class="text-xs font-bold text-rose-600">Ajukan Retur</span>
                            <span class="text-rose-600 group-hover:translate-x-1 transition-transform">→</span>
                        </a>
                    </div>
                </div>

                <!-- Security Log Access -->
                <div class="bg-white rounded-[3rem] p-10 border border-white shadow-xl shadow-slate-200/50">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4">Jejak Aktivitas</h3>
                    <p class="text-xs text-slate-500 mb-6">Pastikan akses otoritas Anda selalu dalam kendali penuh.</p>
                    <a href="{{ route('pelanggan.keamanan.log') }}" class="text-xs font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-widest">Lihat Log Login →</a>
                </div>
            </div>
        </div>
    </div>
</div>
