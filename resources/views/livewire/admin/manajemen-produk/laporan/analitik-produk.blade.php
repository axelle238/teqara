<div class="space-y-12 pb-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-purple-50 border border-purple-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-purple-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-purple-600 uppercase tracking-[0.3em]">Business Intelligence</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">ANALITIK <span class="text-purple-600">PRODUK</span></h1>
            <p class="text-slate-500 font-medium text-lg">Wawasan mendalam performa inventaris, profitabilitas, dan pergerakan stok.</p>
        </div>
        <div class="flex bg-slate-100 p-1 rounded-2xl">
            <button wire:click="$set('periode', 'minggu_ini')" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $periode === 'minggu_ini' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-400 hover:text-slate-600' }}">Minggu Ini</button>
            <button wire:click="$set('periode', 'bulan_ini')" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $periode === 'bulan_ini' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-400 hover:text-slate-600' }}">Bulan Ini</button>
            <button wire:click="$set('periode', 'tahun_ini')" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $periode === 'tahun_ini' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-400 hover:text-slate-600' }}">Tahun Ini</button>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Top Sales Volume -->
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-[40px] p-8 text-white relative overflow-hidden group hover:scale-[1.02] transition-transform duration-500 shadow-xl shadow-indigo-500/20">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <p class="text-[10px] font-black uppercase tracking-widest text-indigo-200 mb-4">Volume Terjual (Top 5)</p>
            <h3 class="text-4xl font-black tracking-tighter">{{ number_format($topProduk->sum('total_terjual')) }} <span class="text-base font-bold text-indigo-200">Unit</span></h3>
            <p class="text-xs font-medium mt-2 text-indigo-100">Produk paling diminati pasar</p>
        </div>

        <!-- Profit Estimate -->
        <div class="bg-white rounded-[40px] p-8 border border-slate-100 shadow-sm relative overflow-hidden group hover:border-emerald-200 transition-all">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-emerald-500/5 rounded-full blur-2xl"></div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Estimasi Margin (Top 5)</p>
            <h3 class="text-4xl font-black tracking-tighter text-emerald-600">Rp {{ number_format($topMargin->sum('total_margin') / 1000000, 1) }} <span class="text-base font-bold text-slate-400">Juta</span></h3>
            <p class="text-xs font-medium mt-2 text-slate-400">Profitabilitas produk unggulan</p>
        </div>

        <!-- Inventory Movement -->
        <div class="bg-white rounded-[40px] p-8 border border-slate-100 shadow-sm relative overflow-hidden group hover:border-blue-200 transition-all">
            <div class="absolute -left-6 -top-6 w-32 h-32 bg-blue-500/5 rounded-full blur-2xl"></div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Pergerakan Stok</p>
            <div class="flex items-end gap-4">
                <div>
                    <span class="text-xs font-bold text-emerald-500 block">Masuk</span>
                    <span class="text-xl font-black text-slate-900">+{{ number_format($mutasi['masuk']) }}</span>
                </div>
                <div class="h-8 w-px bg-slate-100"></div>
                <div>
                    <span class="text-xs font-bold text-rose-500 block">Keluar</span>
                    <span class="text-xl font-black text-slate-900">-{{ number_format($mutasi['keluar']) }}</span>
                </div>
            </div>
        </div>

        <!-- Dead Stock Alert -->
        <div class="bg-white rounded-[40px] p-8 border border-rose-100 shadow-sm relative overflow-hidden group hover:shadow-lg hover:shadow-rose-500/5 transition-all">
            <p class="text-[10px] font-black uppercase tracking-widest text-rose-400 mb-4">Peringatan Stok Mati</p>
            <h3 class="text-4xl font-black tracking-tighter text-rose-600">{{ $slowMoving->count() }} <span class="text-base font-bold text-slate-400">SKU</span></h3>
            <p class="text-xs font-medium mt-2 text-slate-400">Tidak bergerak > 30 hari</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Top Selling Products -->
        <div class="bg-white rounded-[48px] shadow-sm border border-indigo-50 overflow-hidden">
            <div class="p-8 border-b border-indigo-50 bg-slate-50/30 flex justify-between items-center">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Peringkat Penjualan</h3>
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-lg">By Volume</span>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($topProduk as $index => $item)
                <div class="p-6 flex items-center gap-6 group hover:bg-slate-50 transition-all">
                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black text-sm shadow-lg">
                        {{ $index + 1 }}
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-white border border-slate-100 p-2 shrink-0">
                        <img src="{{ $item->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-900 text-sm truncate uppercase">{{ $item->produk->nama }}</h4>
                        <p class="text-[10px] font-mono text-slate-400 uppercase tracking-widest">{{ $item->produk->kode_unit }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-black text-indigo-600 tracking-tighter">{{ number_format($item->total_terjual) }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Terjual</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Margin Products -->
        <div class="bg-white rounded-[48px] shadow-sm border border-emerald-50 overflow-hidden">
            <div class="p-8 border-b border-emerald-50 bg-emerald-50/10 flex justify-between items-center">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Kontributor Profit</h3>
                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-lg">By Margin</span>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($topMargin as $index => $item)
                <div class="p-6 flex items-center gap-6 group hover:bg-emerald-50/10 transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-white border border-slate-100 p-2 shrink-0">
                        <img src="{{ $item->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-900 text-sm truncate uppercase">{{ $item->produk->nama }}</h4>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">High Value Item</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-black text-emerald-600 tracking-tighter">Rp {{ number_format($item->total_margin, 0, ',', '.') }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Total Margin</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
