<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 text-indigo-600 mb-4 animate-bounce">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Selesaikan Pembayaran</h1>
            <p class="text-slate-500 mt-2">Invoice <span class="font-bold text-slate-900">{{ $pesanan->nomor_faktur }}</span></p>
        </div>

        <div class="bg-white rounded-[40px] border border-slate-100 shadow-2xl shadow-indigo-500/10 overflow-hidden">
            <!-- Order Amount -->
            <div class="bg-slate-900 px-8 py-10 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>
                <div class="relative z-10">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Total Tagihan</p>
                    <div class="text-4xl sm:text-5xl font-black text-white tracking-tighter">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </div>
                    <div class="mt-4 inline-block px-4 py-2 bg-indigo-500/20 rounded-full border border-indigo-500/30 text-indigo-300 text-xs font-bold">
                        Batas Waktu: <span class="text-white">23 Jam 59 Menit</span>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="p-8">
                @if(!$transaksiAktif)
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6">Pilih Metode Pembayaran</h3>
                    
                    <div class="grid gap-4">
                        <!-- Transfer Bank -->
                        <div class="space-y-3">
                            <label class="relative flex items-center p-4 rounded-2xl border cursor-pointer hover:bg-slate-50 transition-all {{ $metodeTerpilih === 'bank_transfer' && $providerTerpilih === 'bca' ? 'border-indigo-600 bg-indigo-50/50 ring-1 ring-indigo-600' : 'border-slate-200' }}">
                                <input type="radio" name="payment_method" wire:click="pilihMetode('bank_transfer', 'bca')" class="sr-only">
                                <div class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center text-white font-black italic mr-4">BCA</div>
                                <div class="flex-1">
                                    <span class="block text-sm font-bold text-slate-900">Bank Central Asia</span>
                                    <span class="block text-xs text-slate-500">Cek Otomatis</span>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 border-slate-300 flex items-center justify-center {{ $metodeTerpilih === 'bank_transfer' && $providerTerpilih === 'bca' ? 'border-indigo-600 bg-indigo-600' : '' }}">
                                    @if($metodeTerpilih === 'bank_transfer' && $providerTerpilih === 'bca')
                                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    @endif
                                </div>
                            </label>

                            <label class="relative flex items-center p-4 rounded-2xl border cursor-pointer hover:bg-slate-50 transition-all {{ $metodeTerpilih === 'bank_transfer' && $providerTerpilih === 'mandiri' ? 'border-indigo-600 bg-indigo-50/50 ring-1 ring-indigo-600' : 'border-slate-200' }}">
                                <input type="radio" name="payment_method" wire:click="pilihMetode('bank_transfer', 'mandiri')" class="sr-only">
                                <div class="w-12 h-12 rounded-xl bg-yellow-400 flex items-center justify-center text-slate-900 font-black italic mr-4">MDR</div>
                                <div class="flex-1">
                                    <span class="block text-sm font-bold text-slate-900">Bank Mandiri</span>
                                    <span class="block text-xs text-slate-500">Cek Otomatis</span>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 border-slate-300 flex items-center justify-center {{ $metodeTerpilih === 'bank_transfer' && $providerTerpilih === 'mandiri' ? 'border-indigo-600 bg-indigo-600' : '' }}">
                                    @if($metodeTerpilih === 'bank_transfer' && $providerTerpilih === 'mandiri')
                                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    @endif
                                </div>
                            </label>
                        </div>

                        <!-- QRIS -->
                        <label class="relative flex items-center p-4 rounded-2xl border cursor-pointer hover:bg-slate-50 transition-all {{ $metodeTerpilih === 'qris' ? 'border-indigo-600 bg-indigo-50/50 ring-1 ring-indigo-600' : 'border-slate-200' }}">
                            <input type="radio" name="payment_method" wire:click="pilihMetode('qris', 'gopay')" class="sr-only">
                            <div class="w-12 h-12 rounded-xl bg-slate-900 flex items-center justify-center text-white font-black text-xs mr-4">QRIS</div>
                            <div class="flex-1">
                                <span class="block text-sm font-bold text-slate-900">QRIS (Gopay/OVO/Dana)</span>
                                <span class="block text-xs text-slate-500">Scan & Bayar Instan</span>
                            </div>
                            <div class="w-6 h-6 rounded-full border-2 border-slate-300 flex items-center justify-center {{ $metodeTerpilih === 'qris' ? 'border-indigo-600 bg-indigo-600' : '' }}">
                                @if($metodeTerpilih === 'qris')
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                @endif
                            </div>
                        </label>
                    </div>

                    <div class="mt-8">
                        <button wire:click="buatPembayaran" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl hover:shadow-indigo-500/30 disabled:opacity-50 disabled:cursor-not-allowed" @if(!$metodeTerpilih) disabled @endif>
                            Bayar Sekarang
                        </button>
                    </div>

                @else
                    <!-- Payment Instructions (VA / QRIS) -->
                    <div class="text-center space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
                        @if($transaksiAktif->metode_pembayaran == 'bank_transfer')
                            <div class="bg-indigo-50 rounded-2xl p-6 border border-indigo-100">
                                <p class="text-xs font-bold text-indigo-500 uppercase tracking-widest mb-2">Nomor Virtual Account</p>
                                <div class="flex items-center justify-center gap-3">
                                    <span class="text-2xl font-black text-slate-900 tracking-wider">{{ $transaksiAktif->kode_pembayaran }}</span>
                                    <button onclick="navigator.clipboard.writeText('{{ $transaksiAktif->kode_pembayaran }}')" class="text-slate-400 hover:text-indigo-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </button>
                                </div>
                                <p class="text-xs text-slate-500 mt-2">Transfer sesuai nominal tepat hingga 3 digit terakhir.</p>
                            </div>
                        @else
                            <div class="bg-white p-4 rounded-2xl border border-slate-200 inline-block">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $transaksiAktif->kode_pembayaran }}" alt="QRIS Code" class="w-48 h-48 mx-auto">
                            </div>
                            <p class="text-sm font-bold text-slate-900 mt-2">Scan QRIS di atas dengan E-Wallet Anda</p>
                        @endif

                        <div class="bg-yellow-50 rounded-xl p-4 text-xs text-yellow-800 border border-yellow-100">
                            <span class="font-bold">Mode Simulasi:</span> Karena ini sistem demo, Anda dapat mensimulasikan pembayaran sukses tanpa transfer asli.
                        </div>

                        <button wire:click="simulasiBayarSukses" class="w-full py-4 bg-emerald-500 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl hover:shadow-emerald-500/30">
                            Simulasi Pembayaran Sukses
                        </button>

                         <button wire:click="$set('transaksiAktif', null)" class="w-full py-4 text-slate-400 font-bold text-xs uppercase tracking-widest hover:text-slate-600">
                            Ganti Metode Pembayaran
                        </button>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="mt-8 text-center">
            <a href="/" class="text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>