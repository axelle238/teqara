<div class="bg-slate-50 min-h-screen py-12">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <p class="text-slate-500 font-bold uppercase tracking-widest text-xs mb-2">Menunggu Pembayaran</p>
            <h1 class="text-3xl font-black text-slate-900">Selesaikan Pesanan #{{ $pesanan->nomor_faktur }}</h1>
            <div class="mt-4 inline-block bg-white px-6 py-2 rounded-full shadow-sm border border-slate-200">
                <span class="text-slate-500 font-bold text-sm">Total Tagihan:</span>
                <span class="ml-2 text-xl font-black text-cyan-600">{{ 'Rp ' . number_format($pesanan->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="bg-white rounded-[32px] shadow-xl border border-slate-200 overflow-hidden">
            
            @if(!$transaksiAktif)
            <!-- PILIH METODE -->
            <div class="p-8">
                <h3 class="text-lg font-bold text-slate-900 mb-6">Pilih Metode Pembayaran</h3>
                
                <div class="space-y-4">
                    <!-- Bank Transfer -->
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Virtual Account</p>
                        <div class="grid grid-cols-2 gap-4">
                            <button wire:click="pilihMetode('bank_transfer', 'bca')" class="flex items-center justify-between p-4 rounded-2xl border-2 transition-all {{ $providerTerpilih === 'bca' ? 'border-cyan-600 bg-cyan-50' : 'border-slate-100 hover:border-cyan-200' }}">
                                <span class="font-bold text-slate-700">BCA Virtual Account</span>
                                <div class="w-4 h-4 rounded-full border border-slate-300 {{ $providerTerpilih === 'bca' ? 'bg-cyan-600 border-cyan-600' : '' }}"></div>
                            </button>
                            <button wire:click="pilihMetode('bank_transfer', 'mandiri')" class="flex items-center justify-between p-4 rounded-2xl border-2 transition-all {{ $providerTerpilih === 'mandiri' ? 'border-cyan-600 bg-cyan-50' : 'border-slate-100 hover:border-cyan-200' }}">
                                <span class="font-bold text-slate-700">Mandiri Bill</span>
                                <div class="w-4 h-4 rounded-full border border-slate-300 {{ $providerTerpilih === 'mandiri' ? 'bg-cyan-600 border-cyan-600' : '' }}"></div>
                            </button>
                        </div>
                    </div>

                    <!-- E-Wallet -->
                    <div class="pt-4">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">E-Wallet / QRIS</p>
                        <div class="grid grid-cols-2 gap-4">
                            <button wire:click="pilihMetode('qris', 'gopay')" class="flex items-center justify-between p-4 rounded-2xl border-2 transition-all {{ $providerTerpilih === 'gopay' ? 'border-cyan-600 bg-cyan-50' : 'border-slate-100 hover:border-cyan-200' }}">
                                <span class="font-bold text-slate-700">GoPay / QRIS</span>
                                <div class="w-4 h-4 rounded-full border border-slate-300 {{ $providerTerpilih === 'gopay' ? 'bg-cyan-600 border-cyan-600' : '' }}"></div>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-slate-100">
                    <button wire:click="buatPembayaran" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold text-lg hover:bg-slate-800 transition shadow-lg disabled:opacity-50 disabled:cursor-not-allowed" {{ !$providerTerpilih ? 'disabled' : '' }}>
                        Lanjut Pembayaran
                    </button>
                </div>
            </div>

            @else
            <!-- INSTRUKSI PEMBAYARAN -->
            <div class="p-8 text-center">
                <div class="mb-8">
                    <div class="w-16 h-16 bg-cyan-100 rounded-full flex items-center justify-center mx-auto mb-4 text-cyan-600 animate-pulse">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900">Menunggu Pembayaran</h3>
                    <p class="text-slate-500 font-medium mt-1">Selesaikan dalam <span class="text-red-500 font-bold">23:59:59</span></p>
                </div>

                <div class="bg-slate-50 rounded-2xl p-6 mb-8 border border-slate-200">
                    @if($transaksiAktif->metode_pembayaran == 'bank_transfer')
                        <p class="text-sm font-bold text-slate-500 uppercase mb-2">Nomor Virtual Account ({{ strtoupper($transaksiAktif->provider) }})</p>
                        <div class="text-3xl font-mono font-black text-slate-900 tracking-wider select-all">{{ $transaksiAktif->kode_pembayaran }}</div>
                        <button class="text-cyan-600 text-sm font-bold mt-2 hover:underline">Salin Nomor</button>
                    @else
                        <p class="text-sm font-bold text-slate-500 uppercase mb-4">Scan QRIS Berikut</p>
                        <div class="w-48 h-48 bg-white mx-auto p-2 border border-slate-200 rounded-xl">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $transaksiAktif->kode_pembayaran }}" class="w-full h-full">
                        </div>
                    @endif
                </div>

                <div class="border-t border-slate-100 pt-8">
                    <p class="text-xs text-slate-400 font-bold mb-4 uppercase tracking-widest">Area Simulasi (Developer Mode)</p>
                    <button wire:click="simulasiBayarSukses" class="w-full py-3 bg-emerald-500 text-white rounded-xl font-bold hover:bg-emerald-600 transition shadow-lg shadow-emerald-500/20">
                        Simulasikan Pembayaran Sukses 🚀
                    </button>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
