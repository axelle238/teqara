<div class="bg-slate-50 min-h-screen py-12 relative overflow-hidden font-sans antialiased">
    <!-- Background Decor -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-4xl h-96 bg-indigo-500/10 blur-[120px] -z-0"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-[2rem] bg-white text-indigo-600 mb-6 shadow-2xl shadow-indigo-500/20 border border-indigo-50 animate-bounce">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h1 class="text-4xl font-black text-slate-900 uppercase tracking-tighter mb-2">Otorisasi <span class="text-indigo-600">Pembayaran</span></h1>
            <p class="text-slate-500 font-bold uppercase tracking-[0.2em] text-xs">Menunggu Validasi Digital: #{{ $pesanan->nomor_faktur }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Left Column: Order Summary (Detail) -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
                    <div class="bg-slate-900 px-8 py-10 text-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>
                        <div class="relative z-10">
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mb-2">Total Tagihan</p>
                            <div class="flex items-center justify-center gap-3">
                                <div class="text-4xl font-black text-white tracking-tighter">
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                </div>
                                <button onclick="navigator.clipboard.writeText('{{ $pesanan->total_harga }}'); alert('Nominal disalin! Pastikan transfer tepat hingga digit terakhir.');" class="p-2 bg-white/10 rounded-lg hover:bg-white/20 transition-colors text-white/70 hover:text-white" title="Salin Nominal">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </button>
                            </div>
                            <div class="mt-4 inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 rounded-full border border-white/10 text-white text-[9px] font-black uppercase tracking-widest backdrop-blur-md">
                                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                Expires In: <span class="text-indigo-300">23:59:59</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4 border-b border-slate-100 pb-2">Rincian Belanja</h3>
                        <ul class="space-y-3 mb-6">
                            @foreach($pesanan->detailPesanan as $item)
                            <li class="flex justify-between items-start text-xs">
                                <span class="text-slate-600 font-bold w-2/3 truncate">{{ $item->produk->nama }} (x{{ $item->jumlah }})</span>
                                <span class="text-slate-900 font-black">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="space-y-2 border-t border-slate-100 pt-4 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Subtotal</span>
                                <span class="font-bold text-slate-900">Rp {{ number_format($pesanan->total_harga - $pesanan->biaya_pengiriman + $pesanan->potongan_diskon, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Biaya Pengiriman</span>
                                <span class="font-bold text-slate-900">Rp {{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</span>
                            </div>
                            @if($pesanan->potongan_diskon > 0)
                            <div class="flex justify-between text-emerald-600">
                                <span class="font-bold">Diskon / Voucher</span>
                                <span class="font-black">- Rp {{ number_format($pesanan->potongan_diskon, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="bg-indigo-50 rounded-[2rem] p-6 border border-indigo-100 flex items-start gap-4">
                    <div class="text-2xl">🛡️</div>
                    <div>
                        <h4 class="text-xs font-black text-indigo-900 uppercase tracking-wide mb-1">Pembayaran Aman</h4>
                        <p class="text-[10px] text-indigo-600 leading-relaxed">Transaksi Anda dilindungi enkripsi SSL 256-bit dan diverifikasi otomatis oleh sistem gateway kami.</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Payment Interaction -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[3rem] border border-white shadow-2xl shadow-slate-200/50 overflow-hidden">
                    <div class="p-10 md:p-12">
                        @if(!$transaksiAktif)
                            <div class="flex items-center justify-between mb-8">
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Pilih Saluran Pembayaran</h3>
                                <span class="text-[10px] font-bold text-slate-400 uppercase bg-slate-50 px-3 py-1 rounded-lg">Auto Verification</span>
                            </div>
                            
                            <div class="space-y-6">
                                @foreach($availableMethods as $gatewayKey => $gateway)
                                    <div>
                                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">{{ $gateway['name'] }}</h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            @foreach($gateway['channels'] as $channel)
                                            <button wire:click="pilihMetode('{{ $gatewayKey }}', '{{ $channel }}')" class="relative flex items-center p-5 rounded-[2rem] border-2 transition-all group text-left {{ $metodeTerpilih === $gatewayKey && $providerTerpilih === $channel ? 'border-indigo-600 bg-indigo-50/30 ring-1 ring-indigo-600' : 'border-slate-100 bg-white hover:border-slate-300 hover:shadow-lg' }}">
                                                <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-[10px] uppercase shadow-md mr-4 group-hover:scale-110 transition-transform">
                                                    {{ substr($channel, 0, 3) }}
                                                </div>
                                                <div class="flex-1">
                                                    <span class="block text-xs font-black text-slate-900 uppercase">{{ str_replace('_', ' ', $channel) }}</span>
                                                    <span class="block text-[9px] text-slate-400 font-bold uppercase tracking-wide mt-0.5">
                                                        {{ $gatewayKey === 'manual' ? 'Cek Manual' : 'Instan' }}
                                                    </span>
                                                </div>
                                                @if($metodeTerpilih === $gatewayKey && $providerTerpilih === $channel)
                                                    <div class="absolute top-4 right-4 w-3 h-3 rounded-full bg-indigo-600 shadow-lg shadow-indigo-500/50 animate-ping"></div>
                                                @endif
                                            </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-12 pt-8 border-t border-slate-50">
                                <button wire:click="buatPembayaran" wire:loading.attr="disabled" class="w-full py-5 bg-slate-900 text-white rounded-[2rem] text-xs font-black uppercase tracking-[0.3em] hover:bg-indigo-600 transition-all shadow-2xl shadow-indigo-500/30 group disabled:opacity-50 disabled:cursor-not-allowed relative overflow-hidden">
                                    <span class="relative z-10 flex items-center justify-center gap-3">
                                        <span wire:loading.remove>Generate Kode Bayar</span>
                                        <span wire:loading>Memproses...</span>
                                        <svg wire:loading.remove class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </span>
                                </button>
                            </div>

                        @else
                            <!-- Active Transaction View -->
                            <div class="text-center space-y-8 animate-in fade-in slide-in-from-bottom-8 duration-700">
                                
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">
                                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                                    Menunggu Pembayaran
                                </div>

                                <!-- Midtrans Snap Integration -->
                                @if($transaksiAktif->provider == 'midtrans' && isset($transaksiAktif->payload_gateway['token']))
                                    <div class="bg-indigo-50 rounded-[2.5rem] p-10 border border-indigo-100 text-center relative overflow-hidden">
                                        <!-- Decor -->
                                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-200/50 rounded-full blur-2xl"></div>
                                        
                                        <div class="mb-6 relative z-10">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Midtrans.png/320px-Midtrans.png" class="h-8 mx-auto opacity-80 mix-blend-multiply">
                                        </div>
                                        <p class="text-xs font-bold text-indigo-800 mb-8 max-w-xs mx-auto leading-relaxed">Selesaikan pembayaran Anda dengan aman melalui popup Midtrans.</p>
                                        
                                        <button id="pay-button" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/30 active:scale-95 flex items-center justify-center gap-2">
                                            <span>Buka Pembayaran</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </button>
                                    </div>

                                    <!-- Snap Script -->
                                    <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
                                    <script>
                                        document.getElementById('pay-button').onclick = function(){
                                            snap.pay('{{ $transaksiAktif->payload_gateway['token'] }}', {
                                                onSuccess: function(result){
                                                    @this.call('simulasiBayarSukses'); 
                                                },
                                                onPending: function(result){
                                                    alert("Menunggu pembayaran!");
                                                },
                                                onError: function(result){
                                                    alert("Pembayaran gagal!");
                                                },
                                                onClose: function(){
                                                    // Optional: Do nothing
                                                }
                                            })
                                        };
                                    </script>

                                @elseif($transaksiAktif->metode_pembayaran == 'bank_transfer' || $transaksiAktif->provider == 'manual')
                                    <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-200 relative overflow-hidden">
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Nomor Rekening / VA</p>
                                        <div class="flex flex-col items-center gap-6">
                                            <span class="text-4xl md:text-5xl font-black text-slate-900 tracking-widest font-mono">{{ $transaksiAktif->kode_pembayaran }}</span>
                                            <button onclick="navigator.clipboard.writeText('{{ $transaksiAktif->kode_pembayaran }}'); alert('Berhasil disalin!');" class="px-8 py-3 bg-white rounded-xl text-xs font-black uppercase text-indigo-600 shadow-lg border border-indigo-100 hover:bg-indigo-600 hover:text-white transition-all transform hover:-translate-y-1">
                                                Salin Kode
                                            </button>
                                        </div>
                                    </div>
                                @elseif($transaksiAktif->metode_pembayaran == 'qris')
                                    <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-2xl inline-block relative group">
                                        <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500/20 to-purple-500/20 blur-xl opacity-0 group-hover:opacity-100 transition-opacity rounded-[3rem]"></div>
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ $transaksiAktif->kode_pembayaran }}" alt="QRIS Code" class="w-64 h-64 mx-auto rounded-2xl relative z-10 mix-blend-multiply">
                                        <p class="text-xs font-black text-slate-900 mt-6 uppercase tracking-widest">Scan untuk Bayar</p>
                                    </div>
                                @endif

                                <!-- How to Pay Accordion -->
                                <div class="text-left mt-8 bg-slate-50 rounded-[2rem] p-6 border border-slate-100" x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center justify-between w-full text-xs font-black text-slate-700 uppercase tracking-widest">
                                        <span>Panduan Pembayaran {{ $transaksiAktif->metode_pembayaran == 'qris' ? 'QRIS' : 'Virtual Account' }}</span>
                                        <svg class="w-4 h-4 transition-transform duration-300" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" x-collapse class="mt-4 text-xs text-slate-500 leading-relaxed space-y-3">
                                        @if($transaksiAktif->metode_pembayaran == 'qris')
                                            <p>1. Buka aplikasi E-Wallet (Gopay, OVO, Dana) atau Mobile Banking Anda.</p>
                                            <p>2. Pilih menu <strong>Scan / Bayar</strong>.</p>
                                            <p>3. Arahkan kamera ke kode QRIS di atas.</p>
                                            <p>4. Periksa nama merchant <strong>TEQARA ENTERPRISE</strong> dan nominal <strong>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>.</p>
                                            <p>5. Masukkan PIN Anda untuk menyelesaikan transaksi.</p>
                                        @else
                                            <p>1. Buka aplikasi Mobile Banking atau ATM {{ strtoupper($transaksiAktif->provider) }}.</p>
                                            <p>2. Pilih menu <strong>Transfer</strong> > <strong>Virtual Account</strong>.</p>
                                            <p>3. Masukkan Nomor VA: <strong class="text-slate-900">{{ $transaksiAktif->kode_pembayaran }}</strong></p>
                                            <p>4. Pastikan nama tagihan sesuai dan nominal <strong>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>.</p>
                                            <p>5. Konfirmasi pembayaran.</p>
                                        @endif
                                        <div class="p-3 bg-indigo-50 rounded-xl text-[10px] text-indigo-700 font-bold mt-2">
                                            Tips: Pembayaran akan diverifikasi otomatis dalam 1-5 menit setelah sukses.
                                        </div>
                                    </div>
                                </div>

                                <!-- Simulation Box (Sandbox) -->
                                <div class="bg-amber-50 rounded-[2rem] p-8 text-center border border-amber-100 relative mt-8">
                                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 px-4 py-1 bg-amber-500 text-white text-[9px] font-black uppercase rounded-full shadow-lg">Mode Sandbox</span>
                                    <p class="text-[10px] text-amber-800 font-bold leading-relaxed mb-6 max-w-sm mx-auto">Sistem mendeteksi lingkungan demonstrasi. Gunakan tombol di bawah untuk simulasi verifikasi instan dari gateway.</p>
                                    
                                    <button wire:click="simulasiBayarSukses" class="w-full py-4 bg-emerald-500 text-white rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-emerald-600 transition-all shadow-xl shadow-emerald-500/30 active:scale-95">
                                        Verifikasi Pembayaran (Simulasi)
                                    </button>
                                </div>

                                 <button type="button" wire:click="batalTransaksi" wire:confirm="Yakin ingin membatalkan transaksi ini dan memilih metode lain?" class="w-full py-4 mt-4 bg-white border border-slate-200 text-slate-500 rounded-xl text-[10px] font-black uppercase tracking-widest hover:text-rose-600 hover:border-rose-200 transition-all shadow-sm">
                                    Batal & Ganti Metode
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>