<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">MANAJEMEN <span class="text-emerald-600">PRODUK</span></h1>
            <p class="text-slate-500 font-medium">Pusat kendali inventaris dan katalog produk.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total SKU</p>
            <p class="text-3xl font-black text-slate-900">{{ number_format($total_produk) }}</p>
        </div>
        <div class="bg-amber-50 p-6 rounded-[32px] border border-amber-100">
            <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-2">Stok Menipis</p>
            <p class="text-3xl font-black text-amber-700">{{ number_format($stok_menipis) }}</p>
        </div>
        <div class="bg-blue-50 p-6 rounded-[32px] border border-blue-100">
            <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-2">Kategori</p>
            <p class="text-3xl font-black text-blue-700">{{ number_format($total_kategori) }}</p>
        </div>
        <div class="bg-purple-50 p-6 rounded-[32px] border border-purple-100">
            <p class="text-[10px] font-black text-purple-600 uppercase tracking-widest mb-2">Merek</p>
            <p class="text-3xl font-black text-purple-700">{{ number_format($total_merek) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm p-8">
        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Produk Baru Ditambahkan</h3>
        <div class="space-y-4">
            @foreach($produk_terbaru as $p)
            <div class="flex items-center gap-4 border-b border-slate-50 pb-4 last:border-0 last:pb-0">
                <img src="{{ $p->gambar_utama }}" class="w-12 h-12 rounded-lg object-contain bg-slate-50 border border-slate-100">
                <div>
                    <p class="text-sm font-bold text-slate-900">{{ $p->nama }}</p>
                    <p class="text-xs text-slate-500">Stok: {{ $p->stok }} Unit • Rp {{ number_format($p->harga_jual) }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
