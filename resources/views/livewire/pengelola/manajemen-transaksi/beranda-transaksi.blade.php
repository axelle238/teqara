<div class="space-y-10 animate-in fade-in duration-500 pb-32">
    
    <!-- HEADER & SUMMARY CARDS -->
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-slate-900 text-white p-10 rounded-[40px] shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-80 h-80 bg-gradient-to-br from-violet-600/30 to-fuchsia-600/30 rounded-full blur-[80px] -mr-20 -mt-20"></div>
            
            <div class="relative z-10 space-y-2">
                <h1 class="text-4xl font-black tracking-tight uppercase leading-none">Keuangan <span class="text-violet-400">Enterprise</span></h1>
                <p class="text-slate-400 font-medium tracking-wide">Pusat monitoring arus kas dan verifikasi pembayaran.</p>
            </div>

            <div class="relative z-10 flex gap-8 text-right">
                <div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Pendapatan</p>
                    <p class="text-3xl font-black text-emerald-400">Rp{{ number_format($this->ringkasan['total_masuk'], 0, ',', '.') }}</p>
                </div>
                <div class="hidden lg:block w-px bg-white/10"></div>
                <div class="hidden lg:block">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Rata-rata Basket Size</p>
                    <p class="text-xl font-black text-white">Rp{{ number_format($this->ringkasan['rata_rata'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Status Cards Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-[30px] border border-slate-100 shadow-sm flex items-center gap-4 group hover:border-violet-200 transition-colors">
                <div class="w-12 h-12 bg-violet-50 text-violet-600 rounded-2xl flex items-center justify-center text-xl shadow-inner group-hover:bg-violet-600 group-hover:text-white transition-all">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
                <div>
                    <h4 class="text-2xl font-black text-slate-900">{{ $this->ringkasan['transaksi_sukses'] }}</h4>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Transaksi Sukses</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[30px] border border-slate-100 shadow-sm flex items-center gap-4 group hover:border-amber-200 transition-colors">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-xl shadow-inner group-hover:bg-amber-600 group-hover:text-white transition-all">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <h4 class="text-2xl font-black text-slate-900">{{ $this->ringkasan['transaksi_pending'] }}</h4>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Menunggu Bayar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- TOOLBAR -->
    <div class="bg-white p-6 rounded-[35px] border border-indigo-50 flex flex-col md:flex-row gap-6 justify-between items-center shadow-sm">
        <div class="flex flex-wrap gap-4 w-full md:w-auto">
            <select wire:model.live="filterMetode" class="bg-slate-50 border-none rounded-2xl px-6 py-4 text-xs font-black text-slate-600 uppercase tracking-widest cursor-pointer focus:ring-4 focus:ring-violet-500/10">
                <option value="">Semua Kanal Bayar</option>
                <option value="bank_transfer">Transfer Bank (VA)</option>
                <option value="e_wallet">E-Wallet (QRIS)</option>
                <option value="credit_card">Kartu Kredit</option>
                <option value="manual">Transfer Manual</option>
            </select>
        </div>

        <div class="relative w-full md:w-96">
            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Kode Bayar / Invoice..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-violet-500/10 placeholder:text-slate-300">
        </div>
    </div>

    <!-- TRANSACTION LIST -->
    <div class="space-y-4">
        @forelse($transaksi as $trx)
        <div class="bg-white rounded-[35px] p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:border-violet-100 transition-all duration-300 group">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                <!-- Info Utama -->
                <div class="flex items-center gap-6 w-full lg:w-auto">
                    <div class="w-16 h-16 rounded-[20px] bg-slate-50 flex flex-col items-center justify-center border border-slate-100 shrink-0">
                        <span class="text-xs font-black text-slate-900">{{ $trx->dibuat_pada->format('d') }}</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase">{{ $trx->dibuat_pada->format('M') }}</span>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-black text-slate-900 tracking-tight">{{ $trx->kode_pembayaran }}</span>
                            <span class="px-2 py-0.5 rounded bg-slate-100 text-[8px] font-black text-slate-500 uppercase tracking-widest">
                                {{ str_replace('_', ' ', $trx->metode_pembayaran) }}
                            </span>
                        </div>
                        <p class="text-xs font-medium text-slate-500">
                            Inv: <span class="font-bold text-violet-600">#{{ $trx->pesanan->nomor_faktur ?? '-' }}</span> 
                            • Pelanggan: {{ $trx->pesanan->pengguna->nama ?? 'Guest' }}
                        </p>
                    </div>
                </div>

                <!-- Status & Nominal -->
                <div class="flex items-center gap-8 w-full lg:w-auto justify-between lg:justify-end">
                    <div class="text-right">
                        <p class="text-lg font-black text-slate-900">Rp{{ number_format($trx->jumlah_bayar, 0, ',', '.') }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $trx->dibuat_pada->format('H:i') }} WIB</p>
                    </div>

                    <div class="flex items-center gap-4">
                        @if($trx->status == 'sukses')
                            <span class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                                <i class="fa-solid fa-circle-check"></i> Lunas
                            </span>
                        @elseif($trx->status == 'menunggu')
                            <span class="flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-amber-100 animate-pulse">
                                <i class="fa-solid fa-clock"></i> Pending
                            </span>
                        @else
                            <span class="flex items-center gap-2 px-4 py-2 bg-rose-50 text-rose-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-rose-100">
                                <i class="fa-solid fa-circle-xmark"></i> Gagal
                            </span>
                        @endif

                        @if($trx->status == 'menunggu')
                        <button wire:click="verifikasiManual({{ $trx->id }})" wire:confirm="Verifikasi pembayaran ini secara manual? Status akan berubah menjadi Lunas." class="w-10 h-10 rounded-xl bg-violet-600 text-white flex items-center justify-center hover:bg-violet-700 shadow-lg shadow-violet-500/30 transition-all active:scale-95" title="Verifikasi Manual">
                            <i class="fa-solid fa-check"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="py-20 text-center bg-white rounded-[40px] border-2 border-dashed border-slate-100">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl grayscale opacity-30">💸</div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Tidak ada data transaksi.</p>
        </div>
        @endforelse
    </div>

    <div class="pt-6">
        {{ $transaksi->links() }}
    </div>
</div>