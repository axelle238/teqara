<div class="space-y-8 animate-in fade-in zoom-in duration-500">
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl font-black text-slate-800 tracking-tight">Manajemen Vendor</h1>
        <p class="text-slate-500 font-medium">Pusat kendali relasi mitra dan pemasok rantai pasok.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition-all group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-handshake text-xl"></i>
                </div>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Mitra</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $stats['total_vendor'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition-all group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-check-circle text-xl"></i>
                </div>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Mitra Aktif</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $stats['vendor_aktif'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition-all group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-file-invoice text-xl"></i>
                </div>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total PO</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $stats['total_po'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition-all group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">PO Menunggu</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $stats['po_menunggu'] }}</h3>
            </div>
        </div>
    </div>
</div>
