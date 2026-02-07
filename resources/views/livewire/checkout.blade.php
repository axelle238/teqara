<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex text-xs font-bold text-slate-400 uppercase tracking-widest gap-2 mb-8">
            <a href="/keranjang" class="hover:text-indigo-600 transition-colors">Keranjang</a>
            <span>/</span>
            <span class="text-slate-900">Checkout & Pembayaran</span>
        </nav>

        <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tighter mb-8 flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            Konfirmasi <span class="text-emerald-600">Pesanan</span>
        </h1>

        <div class="lg:grid lg:grid-cols-12 lg:gap-12 lg:items-start">
            
            <!-- Left Column: Data Pengiriman & Opsi -->
            <div class="lg:col-span-7 space-y-8">
                
                <!-- Alamat Pengiriman -->
                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group hover:border-emerald-200 transition-all">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full blur-3xl opacity-50 -z-0"></div>
                    
                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6 flex items-center gap-3 relative z-10">
                        <span class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-black">1</span>
                        Alamat Pengiriman
                    </h2>

                    @if($this->daftarAlamat->count() > 0 && !$alamat_baru)
                        <div class="grid gap-4 mb-6 relative z-10">
                            @foreach($this->daftarAlamat as $alamat)
                            <label class="relative flex cursor-pointer rounded-2xl border p-5 shadow-sm focus:outline-none transition-all duration-200 {{ $alamatTerpilihId == $alamat->id ? 'border-emerald-500 ring-2 ring-emerald-500 ring-opacity-10 bg-emerald-50/20' : 'border-slate-200 bg-white hover:bg-slate-50' }}">
                                <input type="radio" wire:model.live="alamatTerpilihId" value="{{ $alamat->id }}" class="sr-only" wire:click="pilihAlamat({{ $alamat->id }})">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-bold text-slate-900 uppercase tracking-wide mb-1">{{ $alamat->label_alamat }} <span class="text-slate-400 font-medium normal-case">({{ $alamat->penerima }})</span></span>
                                        <span class="flex items-center text-sm text-slate-600 font-medium leading-relaxed">{{ $alamat->alamat_lengkap }}</span>
                                        <span class="mt-2 text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-lg w-fit">{{ $alamat->kota }}, {{ $alamat->kode_pos }}</span>
                                    </span>
                                </span>
                                <span class="{{ $alamatTerpilihId == $alamat->id ? 'text-emerald-600' : 'text-transparent' }}" aria-hidden="true">
                                    <div class="w-6 h-6 rounded-full border-2 border-current flex items-center justify-center">
                                        <div class="w-3 h-3 rounded-full bg-current"></div>
                                    </div>
                                </span>
                            </label>
                            @endforeach
                        </div>
                        <button wire:click="$set('alamat_baru', true)" class="text-xs font-black text-indigo-600 hover:text-indigo-700 flex items-center gap-2 uppercase tracking-widest relative z-10 hover:gap-3 transition-all">
                            + Tambah Alamat Baru
                        </button>
                    @else
                        <!-- Form Alamat Manual -->
                        <div class="space-y-4 relative z-10">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Lengkap</label>
                                <textarea wire:model="alamat_pengiriman" rows="3" class="w-full rounded-2xl border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-slate-50" placeholder="Jalan, Nomor Rumah, RT/RW, Kelurahan..."></textarea>
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

                <!-- Dropship Toggle -->
                <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-sm flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Kirim sebagai Dropshipper</h3>
                                <p class="text-[10px] text-slate-500 font-medium">Sembunyikan identitas toko kami pada resi.</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="dropship" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>

                    @if($dropship)
                    <div class="grid grid-cols-2 gap-4 animate-in slide-in-from-top-2 duration-300 pt-4 border-t border-slate-50">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama Pengirim</label>
                            <input wire:model="dropship_nama" type="text" class="w-full bg-slate-50 border-none rounded-xl text-xs font-bold p-3 focus:ring-2 focus:ring-purple-500">
                            @error('dropship_nama') <span class="text-[9px] text-rose-500 font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nomor Telepon</label>
                            <input wire:model="dropship_telepon" type="tel" class="w-full bg-slate-50 border-none rounded-xl text-xs font-bold p-3 focus:ring-2 focus:ring-purple-500">
                            @error('dropship_telepon') <span class="text-[9px] text-rose-500 font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Metode Pengiriman (Dynamic API) -->
                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group hover:border-indigo-200 transition-all">
                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-black">2</span>
                        Metode Pengiriman
                    </h2>
                    
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($this->availableShippingMethods as $code => $service)
                        <button wire:click="setMetodePengiriman('{{ $code }}')" class="relative rounded-2xl border p-4 text-left shadow-sm hover:bg-slate-50 transition-all group {{ $metodePengiriman == $code ? 'border-indigo-600 bg-indigo-50/20 ring-1 ring-indigo-600' : 'border-slate-200' }}">
                            <div class="flex justify-between items-start mb-3">
                                @if(isset($service['logo']))
                                    <img src="{{ $service['logo'] }}" class="h-6 object-contain" alt="{{ $service['name'] }}">
                                @else
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                                        {{ $code == 'tiki' || $code == 'prioritas' ? '⚡' : '🚚' }}
                                    </div>
                                @endif
                                @if($metodePengiriman == $code)
                                    <div class="w-4 h-4 rounded-full bg-indigo-600 flex items-center justify-center">
                                        <svg class="w-2 h-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <span class="block text-xs font-black text-slate-900 uppercase tracking-wide line-clamp-1">{{ $service['name'] }}</span>
                            <span class="mt-1 block text-[10px] font-bold text-slate-400 uppercase tracking-wide">Estimasi: {{ $service['etd'] }}</span>
                            <span class="mt-3 block text-sm font-black text-indigo-600">Rp {{ number_format($service['cost'], 0, ',', '.') }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Asuransi & Catatan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-sm flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Asuransi Paket</h3>
                                <p class="text-[10px] text-slate-500 font-medium">Lindungi dari kerusakan/hilang.</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="asuransi" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>

                    <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-sm">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block px-1">Catatan Tambahan</label>
                        <input wire:model="catatan" type="text" class="w-full border-none bg-slate-50 rounded-xl text-xs font-bold p-3 focus:ring-2 focus:ring-indigo-500" placeholder="Pesan untuk penjual...">
                    </div>
                </div>

            </div>

            <!-- Right Column: Ringkasan & Pembayaran -->
            <div class="lg:col-span-5 mt-8 lg:mt-0 space-y-8">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-emerald-500/5 p-8 sticky top-32 relative overflow-hidden">
                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6">Rincian Pembayaran</h2>

                    <!-- Item List (Compact) -->
                    <ul class="mb-6 space-y-4 max-h-60 overflow-y-auto pr-2 scrollbar-thin">
                        @foreach($this->items as $item)
                        <li class="flex items-start gap-4 p-3 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                            <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-xl border border-slate-100 bg-white p-1 flex items-center justify-center">
                                <img src="{{ $item->produk->gambar_utama_url }}" class="h-full w-full object-contain mix-blend-multiply">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xs font-bold text-slate-900 line-clamp-1 uppercase">{{ $item->produk->nama }}</h3>
                                <p class="text-[10px] text-slate-500 font-bold">{{ $item->varian ? $item->varian->nama_varian : 'Standar' }}</p>
                                <div class="flex justify-between mt-1">
                                    <span class="text-[10px] text-slate-400 font-mono">x{{ $item->jumlah }} • {{ $item->produk->berat_gram ?? 500 }}g</span>
                                    <span class="text-xs font-black text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
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
                            <input wire:model="kodeVoucherInput" type="text" placeholder="KODE VOUCHER" class="flex-1 rounded-xl border-slate-200 text-xs py-3 px-4 uppercase font-black focus:ring-emerald-500 bg-slate-50">
                            @if($voucherTerpakai)
                                <button wire:click="hapusVoucher" class="bg-rose-100 text-rose-600 px-4 rounded-xl font-bold text-xs hover:bg-rose-200 uppercase tracking-wider">Hapus</button>
                            @else
                                <button wire:click="terapkanVoucher" class="bg-slate-900 text-white px-4 rounded-xl font-bold text-xs hover:bg-emerald-600 uppercase tracking-wider transition-colors">Pakai</button>
                            @endif
                        </div>
                        @error('kodeVoucherInput') <span class="text-xs text-rose-500 font-bold block">{{ $message }}</span> @enderror
                        @if($voucherTerpakai)
                            <div class="bg-emerald-50 text-emerald-700 px-4 py-2 rounded-xl text-[10px] font-black flex items-center gap-2 uppercase tracking-wide border border-emerald-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Voucher diterapkan!
                            </div>
                        @endif

                        <!-- Poin -->
                        @auth
                        <div class="flex items-center justify-between bg-amber-50 p-4 rounded-2xl border border-amber-100">
                            <div>
                                <p class="text-[10px] font-black text-amber-800 uppercase tracking-widest flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    Tukar Poin
                                </p>
                                <p class="text-[10px] text-amber-600 font-medium mt-1">Saldo: {{ auth()->user()->poin_loyalitas ?? 0 }} Poin</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:click="togglePoin" wire:model="gunakanPoin" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500 shadow-inner"></div>
                            </label>
                        </div>
                        @endauth
                    </div>

                    <!-- Totals -->
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="font-bold text-slate-500 text-xs uppercase tracking-wide">Total Berat</dt>
                            <dd class="font-bold text-slate-700">{{ number_format($this->totalBerat / 1000, 2, ',', '.') }} kg</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-bold text-slate-500 text-xs uppercase tracking-wide">Subtotal Produk</dt>
                            <dd class="font-bold text-slate-900">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-bold text-slate-500 text-xs uppercase tracking-wide">Biaya Pengiriman</dt>
                            <dd class="font-bold text-slate-900">Rp {{ number_format($this->biayaPengiriman, 0, ',', '.') }}</dd>
                        </div>
                        @if($this->biayaAsuransi > 0)
                        <div class="flex justify-between">
                            <dt class="font-bold text-emerald-600 text-xs uppercase tracking-wide">Biaya Asuransi</dt>
                            <dd class="font-bold text-emerald-600">Rp {{ number_format($this->biayaAsuransi, 0, ',', '.') }}</dd>
                        </div>
                        @endif
                        @if($nilaiPotonganVoucher > 0)
                        <div class="flex justify-between text-emerald-600">
                            <dt class="font-black text-xs uppercase tracking-wide">Diskon Voucher</dt>
                            <dd class="font-black">- Rp {{ number_format($nilaiPotonganVoucher, 0, ',', '.') }}</dd>
                        </div>
                        @endif
                        @if($nilaiPotonganPoin > 0)
                        <div class="flex justify-between text-amber-600">
                            <dt class="font-black text-xs uppercase tracking-wide">Potongan Poin</dt>
                            <dd class="font-black">- Rp {{ number_format($nilaiPotonganPoin, 0, ',', '.') }}</dd>
                        </div>
                        @endif
                        
                        <div class="bg-slate-50 p-4 rounded-2xl flex justify-between items-center mt-6 border border-slate-100">
                            <dt class="text-xs font-black text-slate-500 uppercase tracking-widest">Total Bayar</dt>
                            <dd class="text-2xl font-black text-emerald-600 tracking-tighter">Rp {{ number_format($this->totalBayar, 0, ',', '.') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-8">
                        <button wire:click="buatPesanan" wire:loading.attr="disabled" class="w-full flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-5 text-xs font-black text-white shadow-xl shadow-slate-900/20 hover:bg-emerald-600 hover:shadow-emerald-600/30 transition-all uppercase tracking-[0.2em] disabled:opacity-70 disabled:cursor-wait group relative overflow-hidden">
                            <span class="relative z-10 flex items-center gap-3">
                                <span wire:loading.remove>Konfirmasi Pesanan</span>
                                <svg wire:loading.remove class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                
                                <span wire:loading class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Memproses Transaksi...
                                </span>
                            </span>
                        </button>
                        <p class="text-center text-[10px] text-slate-400 mt-4 font-medium">
                            Enkripsi SSL 256-bit. Data Anda aman bersama kami.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
