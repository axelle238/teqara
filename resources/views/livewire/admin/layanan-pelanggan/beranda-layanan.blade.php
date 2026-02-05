<div class="space-y-12 pb-32">
    <!-- Header: Vibrant & Modern -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pink-50 border border-pink-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-pink-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-pink-600 uppercase tracking-widest">Hub Bantuan Pelanggan</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">BERANDA <span class="text-pink-600">LAYANAN</span></h1>
            <p class="text-slate-500 font-medium text-lg">Pusat kendali dukungan dan moderasi kepuasan mitra teknologi.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="px-6 py-3 bg-white border-2 border-indigo-50 rounded-2xl">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Respon Rata-rata</p>
                <p class="text-lg font-black text-indigo-600 tracking-tighter">14 MENIT</p>
            </div>
        </div>
    </div>

    <!-- Statistik Pilar: Colorful Helpdesk Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-14 h-14 rounded-[20px] bg-indigo-50 flex items-center justify-center text-indigo-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Log Tiket Masuk</p>
                <h3 class="text-5xl font-black text-slate-900 tracking-tighter">{{ number_format($total_tiket) }} <span class="text-sm text-slate-400 font-bold uppercase ml-1">Pesan</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-pink-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-14 h-14 rounded-[20px] bg-pink-50 flex items-center justify-center text-pink-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Tiket Dalam Antrian</p>
                <h3 class="text-5xl font-black text-pink-600 tracking-tighter">{{ number_format($tiket_terbuka) }} <span class="text-sm text-slate-400 font-bold uppercase ml-1">Aktif</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-pink-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50 relative overflow-hidden group hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-500">
            <div class="relative z-10 space-y-4">
                <div class="w-14 h-14 rounded-[20px] bg-amber-50 flex items-center justify-center text-amber-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.783.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Total Log Ulasan</p>
                <h3 class="text-5xl font-black text-slate-900 tracking-tighter">{{ number_format($total_ulasan) }} <span class="text-sm text-slate-400 font-bold uppercase ml-1">Poin</span></h3>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-amber-500/5 rounded-full blur-3xl"></div>
        </div>
    </div>

    <!-- Aktivitas Terbaru: No Dark Policy -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Feed Ulasan -->
        <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
            <div class="px-10 py-8 border-b border-indigo-50 bg-slate-50/30">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Aktivitas Kepuasan Terbaru</h3>
            </div>
            <div class="divide-y divide-indigo-50">
                @forelse($ulasan_terbaru as $u)
                <div class="px-10 py-8 flex items-start gap-6 group hover:bg-indigo-50/20 transition-all">
                    <div class="w-12 h-12 rounded-[18px] bg-indigo-100 flex items-center justify-center font-black text-indigo-600 shadow-inner group-hover:scale-110 transition-transform">
                        {{ substr($u->pengguna->nama, 0, 1) }}
                    </div>
                    <div class="flex-1 space-y-2">
                        <div class="flex items-center justify-between">
                            <p class="font-black text-slate-900 uppercase tracking-tight">{{ $u->pengguna->nama }}</p>
                            <div class="flex text-amber-400">
                                @for($i=0; $i<$u->rating; $i++) <span class="text-xs">⭐</span> @endfor
                            </div>
                        </div>
                        <p class="text-sm font-medium text-slate-500 leading-relaxed italic">"{{ $u->komentar }}"</p>
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">{{ $u->produk->nama }}</p>
                    </div>
                </div>
                @empty
                <div class="p-20 text-center text-slate-300 font-black uppercase tracking-widest">Belum Ada Feedback</div>
                @endforelse
            </div>
        </div>

        <!-- Shortcut Kontrol -->
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-[56px] p-12 text-white shadow-2xl relative overflow-hidden">
            <div class="relative z-10 space-y-10">
                <div>
                    <h2 class="text-3xl font-black tracking-tighter uppercase mb-4">KONTROL <br> HELP DESK</h2>
                    <p class="text-indigo-100 font-medium text-lg opacity-80">Tangani keluhan dan masukan pelanggan dengan prioritas enterprise.</p>
                </div>
                
                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('admin.cs.tiket') }}" wire:navigate class="flex items-center justify-between p-6 bg-white/10 hover:bg-white/20 border border-white/10 rounded-[32px] transition-all group">
                        <span class="font-black uppercase tracking-widest text-sm">Kelola Tiket Bantuan</span>
                        <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                    <a href="{{ route('admin.pelanggan.ulasan') }}" wire:navigate class="flex items-center justify-between p-6 bg-white/10 hover:bg-white/20 border border-white/10 rounded-[32px] transition-all group">
                        <span class="font-black uppercase tracking-widest text-sm">Moderasi Seluruh Ulasan</span>
                        <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-cyan-400/10 rounded-full blur-[80px]"></div>
        </div>
    </div>
</div>
