<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Audit <span class="text-amber-500">Pembayaran</span></h1>
            <p class="text-slate-500 font-medium">Validasi bukti transfer manual dan rekonsiliasi transaksi.</p>
        </div>
        
        <div class="flex gap-2">
            <select wire:model.live="filterMetode" class="px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 focus:ring-2 focus:ring-amber-500 cursor-pointer shadow-sm">
                <option value="">Semua Saluran</option>
                <option value="bank_transfer">Transfer Bank (Manual)</option>
                <option value="qris">QRIS Otomatis</option>
            </select>

            <div class="bg-slate-100 p-1 rounded-xl flex">
                <button wire:click="$set('filterStatus', 'menunggu')" class="px-4 py-2 rounded-lg text-xs font-black uppercase tracking-widest transition-all {{ $filterStatus === 'menunggu' ? 'bg-white text-amber-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                    Antrian
                </button>
                <button wire:click="$set('filterStatus', 'sukses')" class="px-4 py-2 rounded-lg text-xs font-black uppercase tracking-widest transition-all {{ $filterStatus === 'sukses' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                    Selesai
                </button>
                <button wire:click="$set('filterStatus', 'gagal')" class="px-4 py-2 rounded-lg text-xs font-black uppercase tracking-widest transition-all {{ $filterStatus === 'gagal' ? 'bg-white text-rose-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                    Ditolak
                </button>
            </div>
        </div>
    </div>

    <!-- Verification Queue -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($pembayaran as $trx)
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col md:flex-row group hover:border-amber-200 transition-colors relative">
            
            @if($trx->status === 'menunggu')
                <div class="absolute left-0 top-0 bottom-0 w-2 bg-amber-400"></div>
            @elseif($trx->status === 'sukses')
                <div class="absolute left-0 top-0 bottom-0 w-2 bg-emerald-400"></div>
            @else
                <div class="absolute left-0 top-0 bottom-0 w-2 bg-slate-200"></div>
            @endif

            <!-- Left: Transaction Info -->
            <div class="p-8 md:w-1/3 border-b md:border-b-0 md:border-r border-slate-100 flex flex-col justify-between bg-slate-50/30">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="font-mono text-xs font-bold text-slate-400">#{{ $trx->kode_pembayaran }}</span>
                        <span class="px-2 py-1 rounded bg-white border border-slate-200 text-[10px] font-black uppercase tracking-widest text-slate-600">
                            {{ $trx->provider }}
                        </span>
                    </div>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tighter mb-1">
                        Rp {{ number_format($trx->jumlah_bayar, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">
                        {{ $trx->dibuat_pada->translatedFormat('d M Y, H:i') }} WIB
                    </p>
                </div>
                
                <div class="mt-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-black text-xs">
                            {{ substr($trx->pesanan->pengguna->nama ?? 'U', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $trx->pesanan->pengguna->nama ?? 'User Terhapus' }}</p>
                            <a href="{{ route('pengelola.pesanan.detail', $trx->pesanan_id) }}" wire:navigate class="text-[10px] font-bold text-indigo-500 hover:underline">
                                Faktur #{{ $trx->pesanan->nomor_faktur ?? 'NA' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Action Center -->
            <div class="p-8 md:w-2/3 flex flex-col justify-center">
                <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                    
                    <!-- Proof Preview (Mockup Logic if no file) -->
                    <div class="flex items-center gap-6 w-full md:w-auto">
                        <div class="w-20 h-20 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-300 relative overflow-hidden group/img cursor-pointer">
                            @if($trx->pesanan->bukti_bayar)
                                <img src="{{ asset('storage/'.$trx->pesanan->bukti_bayar) }}" class="w-full h-full object-cover">
                                <a href="{{ asset('storage/'.$trx->pesanan->bukti_bayar) }}" target="_blank" class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity">
                                    <i class="fa-solid fa-eye text-white"></i>
                                </a>
                            @else
                                <i class="fa-solid fa-image text-2xl"></i>
                                <span class="absolute bottom-1 text-[8px] font-bold uppercase">Nihil</span>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">Bukti Transfer</h4>
                            <p class="text-xs text-slate-500 mt-1 max-w-[200px]">
                                @if($trx->pesanan->bukti_bayar)
                                    Lampiran tersedia. Klik gambar untuk memperbesar.
                                @else
                                    Belum ada lampiran bukti pembayaran.
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if($trx->status === 'menunggu')
                    <div class="flex gap-3 w-full md:w-auto">
                        <button wire:click="tolak({{ $trx->id }})" wire:confirm="Tolak pembayaran ini? Pesanan akan tetap menunggu bayar." class="flex-1 md:flex-none px-6 py-3 bg-white border-2 border-slate-100 text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:border-rose-200 hover:text-rose-600 hover:bg-rose-50 transition-all">
                            Tolak
                        </button>
                        <button wire:click="verifikasi({{ $trx->id }})" wire:confirm="Verifikasi pembayaran valid? Stok akan dikurangi permanen." class="flex-1 md:flex-none px-8 py-3 bg-emerald-500 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
                            <i class="fa-solid fa-check mr-2"></i> Validasi
                        </button>
                    </div>
                    @else
                    <div class="px-6 py-2 rounded-xl bg-slate-50 border border-slate-100 text-slate-400 font-bold text-xs uppercase tracking-widest cursor-not-allowed">
                        {{ $trx->status === 'sukses' ? 'Telah Diverifikasi' : 'Telah Ditolak' }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
        @empty
        <div class="py-20 text-center">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300 text-4xl">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>
            <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase">Semua Bersih</h3>
            <p class="text-slate-400 font-medium mt-2">Tidak ada antrian verifikasi pembayaran saat ini.</p>
        </div>
        @endforelse
    </div>

    <div class="pt-6">
        {{ $pembayaran->links() }}
    </div>
</div>