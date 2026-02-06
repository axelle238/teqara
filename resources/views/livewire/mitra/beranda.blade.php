<div class="space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Selamat Datang, {{ auth()->user()->nama }}!</h1>
            <p class="text-slate-500 font-medium mt-1">Ini adalah pusat kendali bisnis B2B Anda di Teqara.</p>
        </div>
        <div class="flex gap-3">
            <button class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-bold text-sm shadow hover:bg-emerald-700 transition">
                <i class="fa-solid fa-plus mr-2"></i> Ajukan Produk Baru
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <div class="relative">
                <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Total Penjualan</p>
                <h3 class="text-3xl font-black text-slate-900 mt-2">Rp 0</h3>
                <p class="text-emerald-600 text-xs font-bold mt-2 flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> 0% bulan ini
                </p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-blue-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <div class="relative">
                <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Produk Aktif</p>
                <h3 class="text-3xl font-black text-slate-900 mt-2">0</h3>
                <p class="text-slate-400 text-xs font-bold mt-2">SKU Terdaftar</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-amber-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <div class="relative">
                <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Pesanan Baru</p>
                <h3 class="text-3xl font-black text-slate-900 mt-2">0</h3>
                <p class="text-amber-600 text-xs font-bold mt-2">Perlu Diproses</p>
            </div>
        </div>
    </div>

    <!-- Content Placeholder -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 text-center py-20">
        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
            <i class="fa-solid fa-store text-4xl"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-900">Belum Ada Aktivitas</h3>
        <p class="text-slate-500 max-w-md mx-auto mt-2 mb-8">Anda belum memiliki produk yang terdaftar atau transaksi aktif. Mulai dengan mengajukan produk Anda untuk katalog B2B.</p>
    </div>
</div>
