<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('pelanggan.langganan.indeks') }}" class="flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-indigo-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>
            <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest {{ $langganan->status == 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                {{ $langganan->status }}
            </span>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center gap-6">
                <div class="w-24 h-24 bg-slate-50 rounded-2xl flex items-center justify-center p-2 border border-slate-100">
                    <img src="{{ $langganan->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply">
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 mb-1">{{ $langganan->produk->nama }}</h1>
                    <p class="text-sm font-medium text-slate-500">Paket Langganan {{ $langganan->interval }} Hari</p>
                </div>
            </div>

            <div class="p-8 grid md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <h3 class="text-xs font-black text-indigo-600 uppercase tracking-widest border-b border-indigo-100 pb-2">Jadwal Pengiriman</h3>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Mulai Sejak</span>
                        <span class="font-bold text-slate-900">{{ $langganan->mulai_pada->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Tagihan Berikutnya</span>
                        <span class="font-bold text-slate-900">{{ $langganan->tagihan_berikutnya->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Berakhir Pada</span>
                        <span class="font-bold text-slate-900">{{ $langganan->berakhir_pada ? $langganan->berakhir_pada->format('d M Y') : 'Selamanya' }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-xs font-black text-indigo-600 uppercase tracking-widest border-b border-indigo-100 pb-2">Rincian Biaya</h3>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Harga per Unit</span>
                        <span class="font-bold text-slate-900">Rp {{ number_format($langganan->produk->harga_jual, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Jumlah Langganan</span>
                        <span class="font-bold text-slate-900">{{ $langganan->jumlah }} Unit</span>
                    </div>
                    <div class="flex justify-between text-base pt-2 border-t border-slate-50">
                        <span class="font-black text-slate-900">Total per Tagihan</span>
                        <span class="font-black text-indigo-600">Rp {{ number_format($langganan->produk->harga_jual * $langganan->jumlah, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-end">
                @if($langganan->status == 'aktif')
                    <button wire:click="batalkanLangganan" class="px-6 py-3 bg-white border border-rose-200 text-rose-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-rose-50 transition-all">
                        Batalkan Langganan
                    </button>
                @else
                    <button wire:click="aktifkanKembali" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg">
                        Aktifkan Kembali
                    </button>
                @endif
            </div>
        </div>

    </div>
</div>
