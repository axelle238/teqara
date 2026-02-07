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
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-xl shadow-emerald-500/5 p-8 lg:p-10 sticky top-32 relative overflow-hidden group">
                    <!-- Tech Background Decor -->
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-emerald-50 rounded-full blur-3xl opacity-40 group-hover:opacity-100 transition-opacity"></div>
                    
                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-8 relative z-10 flex items-center justify-between">
                        Ringkasan Pesanan
                        <i class="fa-solid fa-receipt text-emerald-500 opacity-20"></i>
                    </h2>

                    <!-- Item List (Compact Scrollable) -->
                    <div class="relative z-10 mb-8">
                        <ul class="space-y-4 max-h-[280px] overflow-y-auto pr-4 scrollbar-thin scrollbar-thumb-slate-200">
                            @foreach($this->items as $item)
                            <li class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50/50 border border-slate-100 group/item hover:bg-white hover:shadow-md transition-all">
                                <div class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-xl border border-white bg-white p-1 shadow-sm">
                                    <img src="{{ $item->produk->gambar_utama_url }}" class="h-full w-full object-contain mix-blend-multiply group-hover/item:scale-110 transition-transform">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-xs font-black text-slate-900 truncate uppercase">{{ $item->produk->nama }}</h3>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase mt-0.5 tracking-wider">{{ $item->varian ? $item->varian->nama_varian : 'Unit Standar' }}</p>
                                    <div class="flex justify-between items-end mt-2">
                                        <span class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">x{{ $item->jumlah }}</span>
                                        <span class="text-xs font-black text-slate-900">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="h-px bg-gradient-to-r from-transparent via-slate-100 to-transparent my-8"></div>

                    <!-- Voucher & Loyalty Hub -->
                    <div class="space-y-5 mb-8 relative z-10">
                        <!-- Smart Voucher -->
                        <div class="relative">
                            <input wire:model="kodeVoucherInput" type="text" placeholder="KUNCI KODE PROMO" class="w-full rounded-2xl border-2 border-slate-100 text-xs py-4 px-6 uppercase font-black focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 transition-all placeholder:text-slate-300">
                            @if($voucherTerpakai)
                                <button wire:click="hapusVoucher" class="absolute right-3 top-1/2 -translate-y-1/2 bg-rose-100 text-rose-600 px-4 py-2 rounded-xl font-black text-[10px] hover:bg-rose-600 hover:text-white transition-all uppercase">Batal</button>
                            @else
                                <button wire:click="terapkanVoucher" class="absolute right-3 top-1/2 -translate-y-1/2 bg-slate-900 text-white px-5 py-2 rounded-xl font-black text-[10px] hover:bg-emerald-600 transition-all uppercase tracking-widest">Gunakan</button>
                            @endif
                        </div>
                        @error('kodeVoucherInput') <span class="text-[10px] text-rose-500 font-black uppercase tracking-widest px-2">{{ $message }}</span> @enderror
                        @if($voucherTerpakai)
                            <div class="bg-emerald-500 text-white px-5 py-3 rounded-2xl text-[10px] font-black flex items-center justify-between uppercase tracking-widest shadow-lg shadow-emerald-500/20 animate-in zoom-in duration-300">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-ticket"></i>
                                    Voucher '{{ $voucherTerpakai->kode }}' Aktif
                                </div>
                                <span>-Rp{{ number_format($nilaiPotonganVoucher, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <!-- Loyalty Points -->
                        @auth
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-5 rounded-3xl border border-amber-100 relative group/poin overflow-hidden transition-all hover:shadow-inner">
                            <div class="flex items-center justify-between relative z-10">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-lg shadow-amber-500/30">
                                        <i class="fa-solid fa-coins"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-amber-800 uppercase tracking-widest">Redeem Poin Teqara</p>
                                        <p class="text-[9px] text-amber-600 font-bold mt-0.5 uppercase tracking-tighter">Saldo: {{ number_format(auth()->user()->poin_loyalitas ?? 0) }} XP</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:click="togglePoin" wire:model="gunakanPoin" class="sr-only peer">
                                    <div class="w-12 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                                </label>
                            </div>
                        </div>
                        @endauth
                    </div>

                    <!-- Financial Breakdown -->
                    <div class="space-y-4 bg-slate-50/80 p-6 rounded-[2.5rem] border border-slate-100 relative z-10">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-slate-400 uppercase tracking-widest">Total Belanja</span>
                            <span class="text-slate-900">Rp{{ number_format($this->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-slate-400 uppercase tracking-widest">Ongkos Kirim ({{ ceil($this->totalBerat / 1000) }}kg)</span>
                            <span class="text-slate-900">Rp{{ number_format($this->biayaPengiriman, 0, ',', '.') }}</span>
                        </div>
                        @if($this->biayaAsuransi > 0)
                        <div class="flex justify-between text-xs font-bold text-emerald-600">
                            <span class="uppercase tracking-widest">Proteksi Asuransi</span>
                            <span>Rp{{ number_format($this->biayaAsuransi, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        @if($nilaiPotonganVoucher > 0 || $nilaiPotonganPoin > 0)
                        <div class="flex justify-between text-xs font-black text-rose-500">
                            <span class="uppercase tracking-widest">Total Penghematan</span>
                            <span>-Rp{{ number_format($nilaiPotonganVoucher + $nilaiPotonganPoin, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        <div class="h-px bg-slate-200 my-2"></div>
                        
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-sm font-black text-slate-900 uppercase tracking-tighter">Total Bayar</span>
                            <span class="text-3xl font-black text-indigo-600 tracking-tighter">Rp{{ number_format($this->totalBayar, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-10 relative z-10">
                        <button wire:click="buatPesanan" wire:loading.attr="disabled" class="w-full flex items-center justify-center rounded-[1.5rem] bg-[#0f172a] px-8 py-6 text-xs font-black text-white shadow-2xl shadow-indigo-900/20 hover:bg-indigo-600 hover:-translate-y-1 transition-all uppercase tracking-[0.3em] disabled:opacity-70 disabled:cursor-wait group">
                            <span wire:loading.remove class="flex items-center gap-3">
                                PROSES PESANAN SEKARANG
                                <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition-transform"></i>
                            </span>
                            <span wire:loading class="flex items-center gap-3 italic">
                                <svg class="animate-spin h-5 w-5 text-indigo-400" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Sinkronisasi Enkripsi...
                            </span>
                        </button>
                        <div class="flex items-center justify-center gap-4 mt-6 opacity-40 grayscale group-hover:opacity-100 transition-opacity">
                            <i class="fa-brands fa-cc-visa text-2xl"></i>
                            <i class="fa-brands fa-cc-mastercard text-2xl"></i>
                            <i class="fa-solid fa-shield-halved text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
