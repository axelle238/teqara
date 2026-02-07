<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Batalkan <span class="text-rose-600">Pesanan</span></h1>
            <p class="text-slate-500 font-medium text-sm mt-2">Invoice #{{ $pesanan->nomor_faktur }}</p>
        </div>

        <div class="bg-white rounded-[32px] p-8 border border-slate-100 shadow-xl">
            <div class="bg-rose-50 rounded-2xl p-4 border border-rose-100 mb-8 flex gap-4 items-start">
                <div class="text-2xl">⚠️</div>
                <p class="text-xs font-bold text-rose-800 leading-relaxed">
                    Pembatalan tidak dapat dibatalkan. Jika Anda menggunakan Voucher atau Poin, mereka mungkin tidak dapat dikembalikan sepenuhnya tergantung kebijakan.
                </p>
            </div>

            <form wire:submit.prevent="batalkan" class="space-y-8">
                
                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest px-1">Alasan Pembatalan</label>
                    <div class="space-y-3">
                        @foreach(['Ingin mengubah rincian pesanan', 'Harga terlalu mahal', 'Menemukan harga lebih murah', 'Lupa memasukkan voucher', 'Lainnya'] as $opsi)
                        <label class="flex items-center p-4 rounded-2xl border cursor-pointer hover:bg-slate-50 transition-all {{ $alasan == $opsi ? 'border-rose-500 bg-rose-50/50' : 'border-slate-200' }}">
                            <input type="radio" wire:model="alasan" value="{{ $opsi }}" class="w-4 h-4 text-rose-600 border-slate-300 focus:ring-rose-500">
                            <span class="ml-3 text-sm font-bold text-slate-700">{{ $opsi }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('alasan') <span class="text-rose-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest px-1">Keterangan Tambahan</label>
                    <textarea wire:model="keterangan" rows="3" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-rose-500/20" placeholder="Ceritakan lebih detail (opsional)..."></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex gap-4">
                    <a href="{{ route('pesanan.lacak', $pesanan->nomor_faktur) }}" class="flex-1 py-4 bg-white border border-slate-200 text-slate-600 rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-slate-50 text-center text-xs transition-all">
                        Kembali
                    </a>
                    <button type="submit" class="flex-1 py-4 bg-rose-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-rose-700 shadow-xl shadow-rose-600/20 transition-all">
                        Konfirmasi Batal
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
