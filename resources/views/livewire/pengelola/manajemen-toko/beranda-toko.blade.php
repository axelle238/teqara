<div class="space-y-10 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Section: High-Tech Visual Control -->
    <div class="relative bg-white rounded-[3rem] p-10 overflow-hidden shadow-sm border border-slate-100">
        <!-- Abstract Background -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-50 rounded-full blur-3xl -mr-20 -mt-20 opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-indigo-50 rounded-full blur-3xl -ml-10 -mb-10 opacity-60 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100">
                    <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                    <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Sistem Manajemen Konten (CMS)</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase">
                    Pusat Kendali <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">Visual</span>
                </h1>
                <p class="text-slate-500 font-medium text-lg max-w-2xl leading-relaxed">
                    Kelola etalase digital Anda secara real-time. Pastikan setiap piksel halaman depan merepresentasikan kualitas enterprise Teqara.
                </p>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('beranda') }}" target="_blank" class="group flex items-center gap-3 px-8 py-4 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg hover:border-purple-200 transition-all duration-300">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pratinjau</p>
                        <p class="text-xs font-black text-purple-700 uppercase tracking-widest">Lihat Toko Live</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Spanduk Utama -->
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 p-1 rounded-[2.5rem] shadow-xl shadow-indigo-500/20 group hover:-translate-y-1 transition-transform duration-300">
            <div class="bg-white h-full rounded-[2.4rem] p-8 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-indigo-50 rounded-full blur-2xl group-hover:bg-indigo-100 transition-colors"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mb-6 shadow-sm group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-panorama"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Spanduk Utama</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6">Kelola gambar besar (Hero Section) yang muncul pertama kali saat pelanggan berkunjung.</p>
                </div>

                <div class="relative z-10 flex items-center justify-between mt-auto">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Aset</p>
                        <p class="text-2xl font-black text-indigo-600">{{ $konten['hero_aktif'] }} <span class="text-xs text-slate-400 font-bold">/ {{ $konten['total_hero'] }}</span></p>
                    </div>
                    <a href="{{ route('pengelola.toko.konten') }}" wire:navigate class="w-12 h-12 rounded-full bg-indigo-600 text-white flex items-center justify-center hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/30">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: Berita & Artikel -->
        <div class="bg-gradient-to-br from-pink-500 to-rose-600 p-1 rounded-[2.5rem] shadow-xl shadow-rose-500/20 group hover:-translate-y-1 transition-transform duration-300">
            <div class="bg-white h-full rounded-[2.4rem] p-8 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-rose-50 rounded-full blur-2xl group-hover:bg-rose-100 transition-colors"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mb-6 shadow-sm group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Kabar & Artikel</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6">Publikasikan berita terbaru, tips teknologi, atau pengumuman penting untuk pelanggan.</p>
                </div>

                <div class="relative z-10 flex items-center justify-between mt-auto">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Baca</p>
                        <p class="text-2xl font-black text-rose-600">{{ number_format($berita['total_baca']) }} <span class="text-xs text-slate-400 font-bold">Kali</span></p>
                    </div>
                    <a href="{{ route('pengelola.toko.berita') }}" wire:navigate class="w-12 h-12 rounded-full bg-rose-600 text-white flex items-center justify-center hover:bg-rose-700 transition-colors shadow-lg shadow-rose-500/30">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3: Promo & Fitur -->
        <div class="bg-gradient-to-br from-cyan-500 to-blue-600 p-1 rounded-[2.5rem] shadow-xl shadow-cyan-500/20 group hover:-translate-y-1 transition-transform duration-300">
            <div class="bg-white h-full rounded-[2.4rem] p-8 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute right-[-20px] top-[-20px] w-32 h-32 bg-cyan-50 rounded-full blur-2xl group-hover:bg-cyan-100 transition-colors"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-2xl mb-6 shadow-sm group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Promo & Fitur</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6">Atur banner promosi kecil dan sorotan fitur unggulan produk di halaman beranda.</p>
                </div>

                <div class="relative z-10 flex items-center justify-between mt-auto">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kampanye Aktif</p>
                        <p class="text-2xl font-black text-cyan-600">{{ $konten['total_promo'] + $konten['fitur_unggulan'] }} <span class="text-xs text-slate-400 font-bold">Unit</span></p>
                    </div>
                    <a href="{{ route('pengelola.toko.konten') }}" wire:navigate class="w-12 h-12 rounded-full bg-cyan-600 text-white flex items-center justify-center hover:bg-cyan-700 transition-colors shadow-lg shadow-cyan-500/30">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Feed Aktivitas Visual -->
    <div class="bg-white rounded-[3rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-10 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-slate-50/50">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-xl shadow-lg">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Linimasa Perubahan</h3>
                    <p class="text-sm text-slate-500 font-medium">Jejak modifikasi terakhir pada elemen visual toko.</p>
                </div>
            </div>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($feed as $item)
            <div class="group p-8 flex items-center gap-6 hover:bg-slate-50 transition-colors cursor-default">
                <!-- Thumbnail -->
                <div class="w-24 h-16 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200 shadow-sm">
                    @if($item['gambar'])
                        <img src="{{ asset('storage/'.$item['gambar']) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <i class="fa-regular fa-image text-xl"></i>
                        </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-1">
                        <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase tracking-widest border border-indigo-100">{{ $item['bagian'] }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1">
                            <i class="fa-regular fa-clock"></i> {{ $item['waktu'] ? $item['waktu']->diffForHumans() : 'Baru saja' }}
                        </span>
                    </div>
                    <h4 class="text-base font-black text-slate-800 truncate">{{ $item['judul'] }}</h4>
                </div>

                <!-- Status -->
                <div class="hidden md:block">
                    @if($item['status'] == 'Aktif')
                        <span class="flex items-center gap-2 text-emerald-600 font-black text-[10px] uppercase tracking-widest bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tayang
                        </span>
                    @else
                        <span class="flex items-center gap-2 text-slate-500 font-black text-[10px] uppercase tracking-widest bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Draft
                        </span>
                    @endif
                </div>
            </div>
            @empty
            <div class="p-20 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300 text-3xl">
                    <i class="fa-solid fa-wind"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Belum Ada Aktivitas</h3>
                <p class="text-slate-400 text-sm font-medium mt-2">Mulai kelola konten visual Anda sekarang.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>