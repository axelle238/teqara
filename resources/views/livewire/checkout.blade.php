<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex text-xs font-bold text-slate-400 uppercase tracking-widest gap-2 mb-8">
            <a href="/keranjang" class="hover:text-indigo-600 transition-colors">Keranjang</a>
            <span>/</span>
            <span class="text-slate-900">Checkout</span>
        </nav>

        <div class="lg:grid lg:grid-cols-12 lg:gap-12 lg:items-start">
            
            <!-- Left Column: Data Pengiriman -->
            <div class="lg:col-span-7 space-y-8">
                
                <!-- Alamat Pengiriman -->
                <div class="bg-white rounded-[32px] p-8 border border-slate-100 shadow-sm">
                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-sm">1</span>
                        Alamat Pengiriman
                    </h2>

                    @if($this->daftarAlamat->count() > 0 && !$alamat_baru)
                        <div class="grid gap-4 mb-6">
                            @foreach($this->daftarAlamat as $alamat)
                            <label class="relative flex cursor-pointer rounded-2xl border p-4 shadow-sm focus:outline-none {{ $alamatTerpilihId == $alamat->id ? 'border-indigo-600 ring-2 ring-indigo-600 ring-opacity-10 bg-indigo-50/10' : 'border-slate-200 bg-white hover:bg-slate-50' }}">
                                <input type="radio" wire:model.live="alamatTerpilihId" value="{{ $alamat->id }}" class="sr-only" wire:click="pilihAlamat({{ $alamat->id }})">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-bold text-slate-900">{{ $alamat->label_alamat }} ({{ $alamat->penerima }})</span>
                                        <span class="mt-1 flex items-center text-sm text-slate-500">{{ $alamat->alamat_lengkap }}</span>
                                        <span class="mt-1 text-xs font-medium text-slate-500">{{ $alamat->kota }}, {{ $alamat->kode_pos }}</span>
                                    </span>
                                </span>
                                <span class="{{ $alamatTerpilihId == $alamat->id ? 'text-indigo-600' : 'text-transparent' }}" aria-hidden="true">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                </span>
                            </label>
                            @endforeach
                        </div>
                        <button wire:click="$set('alamat_baru', true)" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-2">
                            + Tambah Alamat Baru
                        </button>
                    @else
                        <!-- Form Alamat Manual -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Alamat Lengkap</label>
                                <textarea wire:model="alamat_pengiriman" rows="3" class="w-full rounded-2xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="Jalan, Nomor Rumah, RT/RW, Kelurahan..."></textarea>
                                @error('alamat_pengiriman') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                            @if($this->daftarAlamat->count() > 0)
                            <button wire:click="$set('alamat_baru', false)" class="text-xs font-bold text-slate-500 hover:text-slate-700">
                                < Kembali ke Daftar Alamat
                            </button>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Metode Pengiriman -->
                <div class="bg-white rounded-[32px] p-8 border border-slate-100 shadow-sm">
                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-sm">2</span>
                        Metode Pengiriman
                    </h2>
                    
                    <div class="grid gap-4 sm:grid-cols-3">
                        <button wire:click="setMetodePengiriman('standar')" class="relative rounded-2xl border p-4 text-left shadow-sm hover:bg-slate-50 transition-all {{ $metodePengiriman == 'standar' ? 'border-indigo-600 ring-2 ring-indigo-600 ring-opacity-10' : 'border-slate-200' }}">
                            <span class="block text-sm font-bold text-slate-900">Standar</span>
                            <span class="mt-1 block text-xs text-slate-500">3-5 Hari</span>
                            <span class="mt-2 block text-sm font-black text-indigo-600">Rp 15.000</span>
                        </button>

                        <button wire:click="setMetodePengiriman('ekspres')" class="relative rounded-2xl border p-4 text-left shadow-sm hover:bg-slate-50 transition-all {{ $metodePengiriman == 'ekspres' ? 'border-indigo-600 ring-2 ring-indigo-600 ring-opacity-10' : 'border-slate-200' }}">
                            <span class="block text-sm font-bold text-slate-900">Ekspres</span>
                            <span class="mt-1 block text-xs text-slate-500">1-2 Hari</span>
                            <span class="mt-2 block text-sm font-black text-indigo-600">Rp 35.000</span>
                        </button>

                        <button wire:click="setMetodePengiriman('prioritas')" class="relative rounded-2xl border p-4 text-left shadow-sm hover:bg-slate-50 transition-all {{ $metodePengiriman == 'prioritas' ? 'border-indigo-600 ring-2 ring-indigo-600 ring-opacity-10' : 'border-slate-200' }}">
                            <span class="block text-sm font-bold text-slate-900">Prioritas</span>
                            <span class="mt-1 block text-xs text-slate-500">Besok Sampai</span>
                            <span class="mt-2 block text-sm font-black text-indigo-600">Rp 75.000</span>
                        </button>
                    </div>
                </div>

                <!-- Catatan -->
                <div class="bg-white rounded-[32px] p-8 border border-slate-100 shadow-sm">
                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-4">Catatan Pesanan (Opsional)</h2>
                    <textarea wire:model="catatan" rows="2" class="w-full rounded-2xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="Instruksi khusus untuk kurir atau penjual..."></textarea>
                </div>

            </div>

            <!-- Right Column: Ringkasan & Pembayaran -->
            <div class="lg:col-span-5 mt-8 lg:mt-0 space-y-8">
                <div class="bg-white rounded-[32px] border border-slate-100 shadow-lg shadow-indigo-500/5 p-8 sticky top-32">
                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6">Ringkasan Pesanan</h2>

                    <!-- Item List (Compact) -->
                    <ul class="mb-6 space-y-4 max-h-60 overflow-y-auto pr-2 scrollbar-thin">
                        @foreach($this->items as $item)
                        <li class="flex items-start gap-4">
                            <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-xl border border-slate-100 bg-slate-50 p-1 flex items-center justify-center">
                                <img src="{{ $item->produk->gambar_utama_url }}" class="h-full w-full object-contain mix-blend-multiply">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-slate-900 line-clamp-1">{{ $item->produk->nama }}</h3>
                                <p class="text-xs text-slate-500">{{ $item->varian ? $item->varian->nama_varian : 'Standar' }}</p>
                                <div class="flex justify-between mt-1">
                                    <span class="text-xs text-slate-500">x{{ $item->jumlah }}</span>
                                    <span class="text-xs font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <div class="h-px bg-slate-100 my-6"></div>

                    <!-- Voucher & Poin -->
                    <div class="space-y-4 mb-6">
                        <!-- Voucher -->
                        <div class="flex gap-2">
                            <input wire:model="kodeVoucherInput" type="text" placeholder="Kode Voucher" class="flex-1 rounded-xl border-slate-200 text-sm py-2 px-4 uppercase font-bold focus:ring-indigo-500">
                            @if($voucherTerpakai)
                                <button wire:click="hapusVoucher" class="bg-rose-100 text-rose-600 px-4 rounded-xl font-bold text-xs hover:bg-rose-200">Hapus</button>
                            @else
                                <button wire:click="terapkanVoucher" class="bg-slate-900 text-white px-4 rounded-xl font-bold text-xs hover:bg-indigo-600">Pakai</button>
                            @endif
                        </div>
                        @error('kodeVoucherInput') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                        @if($voucherTerpakai)
                            <div class="bg-emerald-50 text-emerald-700 px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Voucher diterapkan!
                            </div>
                        @endif

                        <!-- Poin -->
                        @auth
                        <div class="flex items-center justify-between bg-amber-50 p-4 rounded-xl border border-amber-100">
                            <div>
                                <p class="text-xs font-bold text-amber-800 uppercase tracking-wide">Tukar Poin</p>
                                <p class="text-[10px] text-amber-600">Anda punya {{ auth()->user()->poin_loyalitas ?? 0 }} Poin</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:click="togglePoin" wire:model="gunakanPoin" class="sr-only peer">
                                <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-amber-500"></div>
                            </label>
                        </div>
                        @endauth
                    </div>

                    <!-- Totals -->
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="font-medium text-slate-500">Subtotal Produk</dt>
                            <dd class="font-bold text-slate-900">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-slate-500">Biaya Pengiriman</dt>
                            <dd class="font-bold text-slate-900">Rp {{ number_format($this->biayaPengiriman, 0, ',', '.') }}</dd>
                        </div>
                        @if($nilaiPotonganVoucher > 0)
                        <div class="flex justify-between text-emerald-600">
                            <dt class="font-bold">Diskon Voucher</dt>
                            <dd class="font-bold">- Rp {{ number_format($nilaiPotonganVoucher, 0, ',', '.') }}</dd>
                        </div>
                        @endif
                        @if($nilaiPotonganPoin > 0)
                        <div class="flex justify-between text-amber-600">
                            <dt class="font-bold">Potongan Poin</dt>
                            <dd class="font-bold">- Rp {{ number_format($nilaiPotonganPoin, 0, ',', '.') }}</dd>
                        </div>
                        @endif
                        <div class="flex justify-between border-t border-slate-100 pt-4 mt-4">
                            <dt class="text-lg font-black text-slate-900 uppercase tracking-tight">Total Bayar</dt>
                            <dd class="text-2xl font-black text-indigo-600">Rp {{ number_format($this->totalBayar, 0, ',', '.') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-8">
                        <button wire:click="buatPesanan" wire:loading.attr="disabled" class="w-full flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-4 text-sm font-black text-white shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 hover:scale-[1.02] transition-all uppercase tracking-[0.2em] disabled:opacity-70 disabled:cursor-wait">
                            <span wire:loading.remove>Buat Pesanan</span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses...
                            </span>
                        </button>
                        <p class="text-center text-xs text-slate-400 mt-4">
                            Dengan membuat pesanan, Anda menyetujui <a href="#" class="text-indigo-600 hover:underline">Syarat & Ketentuan</a> kami.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
