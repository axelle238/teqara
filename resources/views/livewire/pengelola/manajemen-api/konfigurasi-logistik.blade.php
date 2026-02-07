<div class="space-y-8 pb-20 animate-in slide-in-from-bottom-4 duration-500">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-orange-100 text-orange-600 rounded-xl">
                    <i class="fa-solid fa-truck-fast text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">API <span class="text-orange-600">Logistik & Kurir</span></h1>
                    <p class="text-slate-500 font-medium text-sm">Kelola integrasi cek ongkir otomatis dan pelacakan resi.</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
             <a href="https://rajaongkir.com/dokumentasi" target="_blank" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-slate-50 transition-colors">
                <i class="fa-solid fa-book mr-2"></i> Dokumen API
            </a>
            <button wire:click="cekStatusServer" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/30">
                <i class="fa-solid fa-rotate mr-2"></i> Cek Status Server
            </button>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- SIDEBAR STATUS -->
        <div class="space-y-6">
            <!-- RajaOngkir Status -->
            <div class="bg-gradient-to-br from-orange-600 to-amber-600 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <i class="fa-solid fa-truck-ramp-box text-9xl"></i>
                </div>
                <div class="relative z-10">
                    <span class="inline-block px-3 py-1 bg-white/20 text-white rounded-full text-[10px] font-black uppercase tracking-widest border border-white/30 mb-4">
                        Provider Utama
                    </span>
                    <h3 class="text-3xl font-black mb-1">RajaOngkir</h3>
                    <p class="text-orange-100 font-mono text-sm mb-6 uppercase">{{ $rajaongkir_type }} Account</p>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-xs mb-1 text-orange-100 font-bold uppercase">
                                <span>Kuota Request</span>
                                <span class="text-white">Unlimited (Pro)</span>
                            </div>
                            <div class="w-full bg-orange-800/50 rounded-full h-1.5">
                                <div class="bg-white h-1.5 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Supported Couriers -->
            <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm">
                <h4 class="font-bold text-slate-800 flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-boxes-packing text-slate-400"></i> Kurir Didukung
                </h4>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold border border-slate-200">JNE</span>
                    <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold border border-slate-200">POS</span>
                    <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold border border-slate-200">TIKI</span>
                    <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold border border-slate-200">J&T</span>
                    <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold border border-slate-200">SiCepat</span>
                </div>
                <p class="text-[10px] text-slate-400 mt-4 italic">Daftar kurir menyesuaikan dengan tipe akun RajaOngkir yang digunakan.</p>
            </div>
        </div>

        <!-- CONFIGURATION FORMS -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- RAJAONGKIR CONFIG -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 md:p-10 relative overflow-hidden group hover:border-orange-200 transition-all">
                <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i class="fa-solid fa-crown text-6xl"></i>
                </div>

                <div class="flex items-center gap-4 mb-8 border-b border-slate-100 pb-6">
                    <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 shadow-sm">
                        <i class="fa-solid fa-key text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-800">Kunci API RajaOngkir</h2>
                        <p class="text-slate-500 text-xs mt-1">Digunakan untuk menghitung ongkos kirim real-time di checkout.</p>
                    </div>
                </div>

                <form wire:submit.prevent="simpanRajaOngkir" class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest px-1">API Key</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors"><i class="fa-solid fa-lock"></i></span>
                            <input type="text" wire:model="rajaongkir_key" class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-orange-500/10 placeholder:text-slate-300 transition-all font-mono text-sm" placeholder="Paste API Key RajaOngkir...">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest px-1">Tipe Akun</label>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" wire:model="rajaongkir_type" value="starter" class="peer sr-only">
                                <div class="px-4 py-3 bg-slate-50 rounded-xl border border-transparent peer-checked:bg-orange-50 peer-checked:border-orange-200 peer-checked:text-orange-700 font-bold text-sm text-center transition-all hover:bg-slate-100">
                                    Starter
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" wire:model="rajaongkir_type" value="basic" class="peer sr-only">
                                <div class="px-4 py-3 bg-slate-50 rounded-xl border border-transparent peer-checked:bg-orange-50 peer-checked:border-orange-200 peer-checked:text-orange-700 font-bold text-sm text-center transition-all hover:bg-slate-100">
                                    Basic
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" wire:model="rajaongkir_type" value="pro" class="peer sr-only">
                                <div class="px-4 py-3 bg-slate-50 rounded-xl border border-transparent peer-checked:bg-orange-50 peer-checked:border-orange-200 peer-checked:text-orange-700 font-bold text-sm text-center transition-all hover:bg-slate-100">
                                    PRO
                                </div>
                            </label>
                        </div>
                        <p class="text-[10px] text-slate-400 px-1 mt-2">* Tipe akun menentukan kurir yang tersedia dan akurasi hitungan (kecamatan/kelurahan).</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-slate-50 rounded-3xl border border-slate-100">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest px-1">Provinsi Asal</label>
                            <select wire:model.live="selectedProvince" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl font-bold text-sm text-slate-800 focus:ring-4 focus:ring-orange-500/10 transition-all">
                                <option value="">Pilih Provinsi...</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest px-1">Kota Asal (Origin)</label>
                            <select wire:model="rajaongkir_origin_id" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl font-bold text-sm text-slate-800 focus:ring-4 focus:ring-orange-500/10 transition-all">
                                <option value="">Pilih Kota...</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city['city_id'] }}">{{ $city['type'] }} {{ $city['city_name'] }}</option>
                                @endforeach
                            </select>
                            @if($rajaongkir_origin_id)
                                <p class="text-[10px] text-emerald-600 font-bold mt-1 uppercase tracking-widest">ID Kota Terpilih: {{ $rajaongkir_origin_id }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/20 active:scale-95 flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan RajaOngkir
                        </button>
                    </div>
                </form>
            </div>

            <!-- DHL/FEDEX CONFIG (Placeholder for Enterprise) -->
            <div class="bg-slate-50 rounded-[2.5rem] border border-slate-200 border-dashed p-8 md:p-10 opacity-75 hover:opacity-100 transition-all">
                <div class="flex items-center gap-4 mb-6">
                     <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 shadow-sm">
                        <i class="fa-solid fa-plane-departure text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-600">Integrasi Logistik Internasional</h2>
                        <p class="text-slate-400 text-xs mt-1">Konfigurasi untuk DHL Express, FedEx, dan UPS.</p>
                    </div>
                    <span class="ml-auto px-3 py-1 bg-slate-200 text-slate-500 rounded-lg text-[10px] font-black uppercase">Enterprise Only</span>
                </div>
                 <form wire:submit.prevent="simpanDHL" class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest px-1">DHL Account Number</label>
                        <input type="text" wire:model="dhl_account" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl font-bold text-sm text-slate-600 focus:outline-none focus:border-indigo-300" placeholder="Optional...">
                    </div>
                     <div class="flex justify-end">
                         <button type="submit" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Simpan Draft</button>
                     </div>
                 </form>
            </div>

        </div>
    </div>
</div>