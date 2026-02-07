<div class="bg-slate-50/50 min-h-screen py-12 animate-fade-in">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Profil & Saldo -->
        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-slate-100 mb-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-10">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 bg-gradient-to-tr from-indigo-600 to-purple-600 rounded-3xl flex items-center justify-center text-white text-3xl font-black shadow-xl shadow-indigo-200">
                        {{ substr($this->stats['nama'], 0, 1) }}
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">{{ $this->stats['nama'] }}</h1>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-[9px] font-black uppercase tracking-widest">{{ $this->stats['level'] }} Member</span>
                            <span class="text-slate-400 text-xs font-bold">{{ $this->stats['email'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4">
                    <!-- Dompet Digital -->
                    <div class="bg-slate-900 rounded-[2rem] p-6 text-white min-w-[240px] relative overflow-hidden group shadow-xl">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 transition-transform group-hover:scale-110"></div>
                        <p class="text-[9px] font-black text-white/50 uppercase tracking-[0.2em] mb-2">Saldo Digital</p>
                        <h3 class="text-2xl font-black tracking-tight">Rp {{ number_format($this->stats['saldo'], 0, ',', '.') }}</h3>
                        <div class="mt-4 flex items-center gap-2">
                            <a href="{{ route('pelanggan.dompet') }}" wire:navigate class="text-[10px] font-black text-indigo-400 uppercase tracking-widest hover:text-white transition-colors">Isi Saldo <i class="fa-solid fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>

                    <!-- Poin Loyalitas -->
                    <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm min-w-[200px] flex flex-col justify-center">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Poin Teqara</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($this->stats['poin'], 0, ',', '.') }}</h3>
                            <span class="text-xs font-bold text-indigo-600 mb-1">PTS</span>
                        </div>
                        <a href="{{ route('pelanggan.tukar-poin') }}" wire:navigate class="mt-3 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors">Tukar Poin</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Operasional -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
            <a href="{{ route('pesanan.riwayat') }}" wire:navigate class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group">
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h4 class="text-xl font-black text-slate-900">{{ $this->stats['pesanan_aktif'] }}</h4>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Pesanan Aktif</p>
            </a>

            <a href="{{ route('pelanggan.notifikasi') }}" wire:navigate class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group">
                <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center text-lg mb-4 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <h4 class="text-xl font-black text-slate-900">{{ auth()->user()->notifications()->count() }}</h4>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Notifikasi Baru</p>
            </a>

            <a href="{{ route('pelanggan.voucher') }}" wire:navigate class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group">
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-lg mb-4 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <h4 class="text-xl font-black text-slate-900">{{ $this->stats['voucher_tersedia'] }}</h4>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Voucher Saya</p>
            </a>

            <a href="{{ route('bantuan') }}" wire:navigate class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group">
                <div class="w-10 h-10 bg-violet-50 text-violet-600 rounded-xl flex items-center justify-center text-lg mb-4 group-hover:bg-violet-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h4 class="text-xl font-black text-slate-900">{{ $this->stats['tiket_terbuka'] }}</h4>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Tiket Bantuan</p>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Pesanan Terakhir -->
            <div class="lg:col-span-2 space-y-6">
                <div class="flex justify-between items-center px-4">
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Pesanan <span class="text-indigo-600">Terakhir</span></h3>
                    <a href="{{ route('pesanan.riwayat') }}" wire:navigate class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors">Lihat Semua</a>
                </div>

                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Faktur</th>
                                    <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                                    <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Bayar</th>
                                    <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($this->pesananTerakhir as $pesanan)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-5">
                                        <a href="{{ route('pesanan.lacak', $pesanan->nomor_faktur) }}" wire:navigate class="font-mono text-xs font-black text-indigo-600">#{{ $pesanan->nomor_faktur }}</a>
                                    </td>
                                    <td class="px-6 py-5 text-xs font-bold text-slate-600">{{ $pesanan->dibuat_pada->translatedFormat('d M Y') }}</td>
                                    <td class="px-6 py-5 text-xs font-black text-slate-900">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                    <td class="px-8 py-5 text-right">
                                        <span class="px-3 py-1 bg-slate-100 rounded-lg text-[9px] font-black uppercase tracking-widest">{{ $pesanan->status_pesanan }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-20 text-center text-slate-400">
                                        <i class="fa-solid fa-receipt text-4xl mb-4 opacity-20"></i>
                                        <p class="text-sm font-bold uppercase tracking-widest">Belum ada pesanan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Rekomendasi Produk -->
            <div class="space-y-6">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight px-4">Khusus <span class="text-indigo-600">Untuk Anda</span></h3>
                
                <div class="space-y-4">
                    @foreach($this->rekomendasi as $p)
                    <a href="{{ route('produk.detail', $p->slug) }}" wire:navigate class="flex items-center gap-4 bg-white p-4 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-100 transition-all group">
                        <div class="w-20 h-20 bg-slate-50 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-100 group-hover:scale-95 transition-transform">
                            <img src="{{ $p->gambarUtama?->url ?? 'https://placehold.co/200x200?text=Produk' }}" alt="{{ $p->nama }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <p class="text-[9px] font-black text-indigo-500 uppercase tracking-widest mb-1">{{ $p->kategori->nama }}</p>
                            <h4 class="text-xs font-black text-slate-900 uppercase leading-tight mb-2 line-clamp-2">{{ $p->nama }}</h4>
                            <p class="text-xs font-black text-slate-900 tracking-tight">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>

                <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl shadow-indigo-200">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <h4 class="text-lg font-black leading-tight mb-2 uppercase">Butuh Bantuan Teknisi?</h4>
                    <p class="text-[10px] font-bold text-white/70 uppercase tracking-widest leading-relaxed mb-6">Konsultasi gratis dengan pakar teknologi kami.</p>
                    <a href="{{ route('bantuan') }}" wire:navigate class="inline-block px-6 py-3 bg-white text-indigo-700 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-indigo-50 transition-colors">Buka Tiket</a>
                </div>
            </div>
        </div>

    </div>
</div>
