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
        <div class="relative z-10 w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center text-orange-600 text-4xl shadow-inner">
            <i class="fa-solid fa-truck-ramp-box"></i>
        </div>
        
        <!-- Deco -->
        <div class="absolute -left-10 -bottom-10 w-64 h-64 bg-orange-100 rounded-full blur-3xl opacity-50"></div>
    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Ready to Ship -->
        <div class="bg-white p-10 rounded-[3rem] border border-slate-200 shadow-sm flex flex-col items-center justify-center text-center group hover:border-indigo-200 transition-colors">
            <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-2xl mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <h3 class="text-5xl font-black text-slate-900 tracking-tighter mb-2">{{ $siap_dikirim }}</h3>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Siap Dikirim</p>
        </div>

        <!-- In Transit -->
        <div class="bg-gradient-to-br from-orange-500 to-amber-600 p-10 rounded-[3rem] shadow-xl text-white flex flex-col items-center justify-center text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/diagonal-stripes.png')] opacity-10"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 backdrop-blur-md">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <h3 class="text-5xl font-black tracking-tighter mb-2">{{ $sedang_dikirim }}</h3>
                <p class="text-xs font-black text-orange-100 uppercase tracking-widest">Dalam Perjalanan</p>
            </div>
        </div>

        <!-- Delivered -->
        <div class="bg-white p-10 rounded-[3rem] border border-slate-200 shadow-sm flex flex-col items-center justify-center text-center group hover:border-emerald-200 transition-colors">
            <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-house-chimney"></i>
            </div>
            <h3 class="text-5xl font-black text-slate-900 tracking-tighter">{{ $sampai_tujuan }}</h3>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Terkirim Sukses</p>
        </div>
    </div>
</div>