<div class="bg-slate-50 min-h-screen py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-6">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-slate-900 uppercase">Riwayat <span class="text-indigo-600">Pesanan</span></h1>
                <p class="text-slate-500 font-medium text-sm mt-1">Kelola dan lacak semua transaksi Anda di satu tempat.</p>
            </div>
            
            <!-- Filters -->
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                <div class="relative flex-1 md:w-64">
                    <input wire:model.live.debounce.300ms="cariInvoice" type="text" placeholder="Cari No. Invoice..." class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
                    <svg class="w-5 h-5 absolute left-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <select wire:model.live="filterStatus" class="bg-white border border-slate-200 rounded-xl py-3 px-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-indigo-500 shadow-sm cursor-pointer">
                    <option value="semua">Semua Status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="dikirim">Dikirim</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>
        </div>

        @if($this->pesanan->count() > 0)
        <div class="space-y-6">
            @foreach($this->pesanan as $p)
            <div class="bg-white rounded-[2rem] border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-indigo-500/5 transition-all duration-300 group">
                <!-- Header -->
                <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-x-8 gap-y-2">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor Faktur</p>
                            <p class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">#{{ $p->nomor_faktur }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal</p>
                            <p class="text-sm font-bold text-slate-700">{{ $p->dibuat_pada->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total</p>
                            <p class="text-sm font-black text-indigo-600">{{ 'Rp ' . number_format($p->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest ring-1 ring-inset {{ $p->status_pembayaran === 'lunas' ? 'bg-emerald-50 text-emerald-600 ring-emerald-200' : 'bg-amber-50 text-amber-600 ring-amber-200' }}">
                            {{ str_replace('_', ' ', $p->status_pembayaran) }}
                        </span>
                         <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest ring-1 ring-inset {{ $p->status_pesanan === 'selesai' ? 'bg-indigo-50 text-indigo-600 ring-indigo-200' : ($p->status_pesanan === 'dibatalkan' ? 'bg-rose-50 text-rose-600 ring-rose-200' : 'bg-slate-50 text-slate-600 ring-slate-200') }}">
                            {{ $p->status_pesanan }}
                        </span>
                    </div>
                </div>

                <!-- Items -->
                <div class="p-8">
                    <div class="space-y-6">
                        @foreach($p->detailPesanan as $detail)
                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 bg-slate-50 rounded-xl overflow-hidden flex items-center justify-center p-2 border border-slate-100">
                                <img src="{{ $detail->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-slate-900 mb-1 truncate">{{ $detail->produk->nama }}</h4>
                                <p class="text-xs text-slate-500 font-medium mb-2">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_saat_ini, 0, ',', '.') }}</p>
                                 @if($p->status_pesanan === 'selesai')
                                    <a href="{{ route('ulasan.buat', ['pesananId' => $p->id, 'produkId' => $detail->produk->id]) }}" class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-500 hover:text-amber-600 uppercase tracking-wider transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                        Beri Ulasan
                                    </a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 flex flex-wrap justify-end gap-3">
                    <a href="{{ route('pesanan.lacak', $p->nomor_faktur) }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:border-indigo-600 hover:text-indigo-600 transition-all">
                        Lacak
                    </a>
                    <a href="{{ route('pesanan.faktur', $p->nomor_faktur) }}" target="_blank" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:border-indigo-600 hover:text-indigo-600 transition-all">
                        Faktur
                    </a>
                    @if(in_array($p->status_pesanan, ['menunggu', 'diproses']))
                        <a href="{{ route('pesanan.batal', $p->id) }}" class="px-4 py-2 bg-white border border-rose-200 text-rose-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-50 hover:border-rose-300 transition-all">
                            Batalkan
                        </a>
                    @endif
                    @if($p->status_pembayaran === 'belum_dibayar')
                        <a href="{{ route('pesanan.bayar', $p->nomor_faktur) }}" class="px-6 py-2 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-500/20 transition-all">
                            Bayar Sekarang
                        </a>
                    @endif
                </div>
            </div>
            @endforeach

            <div class="mt-8">
                {{ $this->pesanan->links() }}
            </div>
        </div>
        @else
        <div class="flex flex-col items-center justify-center py-24 bg-white rounded-[2.5rem] border border-dashed border-slate-200">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-6 animate-pulse">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-900 mb-2 tracking-tight">Tidak Ditemukan</h3>
            <p class="text-slate-500 max-w-sm mx-auto mb-8 font-medium text-sm">Tidak ada pesanan yang sesuai dengan filter pencarian Anda.</p>
            <div class="flex gap-4">
                <button wire:click="resetFilter" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all">
                    Reset Filter
                </button>
                <a href="{{ route('katalog') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg">
                    Ke Katalog
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
