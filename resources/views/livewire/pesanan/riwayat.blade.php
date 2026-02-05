<div class="bg-slate-50 min-h-screen py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-slate-900 mb-8">Pesanan Saya</h1>

        @if($this->pesanan->count() > 0)
        <div class="space-y-6">
            @foreach($this->pesanan as $p)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <!-- Header Pesanan -->
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-6">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nomor Invoice</p>
                            <p class="text-sm font-bold text-slate-900">{{ $p->nomor_faktur }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal</p>
                            <p class="text-sm font-medium text-slate-600">{{ $p->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total</p>
                            <p class="text-sm font-bold text-cyan-600">{{ 'Rp ' . number_format($p->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <!-- Status Badge -->
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset {{ $p->status_pembayaran === 'lunas' ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/20' : 'bg-amber-50 text-amber-700 ring-amber-600/20' }}">
                            {{ str_replace('_', ' ', strtoupper($p->status_pembayaran)) }}
                        </span>
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset {{ $p->status_pesanan === 'selesai' ? 'bg-blue-50 text-blue-700 ring-blue-600/20' : 'bg-slate-50 text-slate-700 ring-slate-600/20' }}">
                            {{ strtoupper($p->status_pesanan) }}
                        </span>
                    </div>
                </div>

                <!-- Detail Produk -->
                <div class="p-6">
                    <div class="flex flex-col gap-4">
                        @foreach($p->detailPesanan as $detail)
                        <div class="flex items-center gap-4">
                            <img src="{{ $detail->produk->gambar_utama_url }}" class="h-12 w-12 rounded-lg object-cover border border-slate-100">
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-slate-900">{{ $detail->produk->nama }}</h4>
                                <p class="text-xs text-slate-500">{{ $detail->jumlah }} item x {{ 'Rp ' . number_format($detail->harga_saat_ini, 0, ',', '.') }}</p>
                            </div>
                            @if($p->status_pesanan === 'selesai')
                                <a href="/ulasan/{{ $p->id }}/{{ $detail->produk->id }}" wire:navigate class="px-3 py-1.5 bg-yellow-50 text-yellow-700 rounded-lg text-[10px] font-bold border border-yellow-200 hover:bg-yellow-100 transition">
                                    ⭐ Beri Ulasan
                                </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Footer Pesanan -->
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex justify-end gap-3">
                    <button class="text-xs font-bold text-cyan-600 hover:text-cyan-700 transition">Lihat Detail</button>
                    @if($p->status_pembayaran === 'belum_dibayar')
                        <button class="rounded-lg bg-cyan-600 px-4 py-2 text-xs font-bold text-white hover:bg-cyan-700 transition">Bayar Sekarang</button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-20 bg-white rounded-2xl border border-dashed border-slate-300">
            <h3 class="text-lg font-bold text-slate-900">Belum Ada Pesanan</h3>
            <p class="mt-2 text-slate-500 text-sm">Anda belum pernah melakukan transaksi di Teqara.</p>
            <a href="/katalog" wire:navigate class="mt-6 inline-flex items-center rounded-xl bg-cyan-600 px-6 py-3 text-sm font-bold text-white hover:bg-cyan-700 transition">
                Mulai Belanja Sekarang
            </a>
        </div>
        @endif
    </div>
</div>
