<div class="animate-in fade-in duration-500 pb-20">
    
    @if(!$tampilkanForm)
        <!-- TAMPILAN 1: PUSAT PELACAKAN SERI (FULL PAGE LIST) -->
        <div class="space-y-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="space-y-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        <span class="text-[9px] font-black text-indigo-600 uppercase tracking-widest">Identitas Unit</span>
                    </div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Pelacakan IMEI & Seri</h1>
                    <p class="text-slate-500 font-medium">Manajemen nomor seri unik untuk garansi dan audit stok.</p>
                </div>
                <button wire:click="bukaPanelRegistrasi" class="flex items-center gap-3 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-indigo-600/20 transition-all active:scale-95">
                    <i class="fa-solid fa-barcode text-lg"></i> REGISTRASI SERI BARU
                </button>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-[30px] border border-slate-50 shadow-sm">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Terdaftar</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($statistik['total']) }}</h3>
                </div>
                <div class="bg-emerald-50 p-6 rounded-[30px] border border-emerald-100 shadow-sm">
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Siap Jual</p>
                    <h3 class="text-3xl font-black text-emerald-700 mt-1">{{ number_format($statistik['tersedia']) }}</h3>
                </div>
                <div class="bg-indigo-50 p-6 rounded-[30px] border border-indigo-100 shadow-sm">
                    <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Terjual</p>
                    <h3 class="text-3xl font-black text-indigo-700 mt-1">{{ number_format($statistik['terjual']) }}</h3>
                </div>
                <div class="bg-rose-50 p-6 rounded-[30px] border border-rose-100 shadow-sm">
                    <p class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Masalah / Retur</p>
                    <h3 class="text-3xl font-black text-rose-700 mt-1">{{ number_format($statistik['masalah']) }}</h3>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white p-6 rounded-[35px] border border-indigo-50 flex flex-col md:flex-row gap-6 justify-between items-center shadow-sm">
                <div class="flex gap-4 w-full md:w-auto flex-1">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Nomor Seri / IMEI..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300">
                    </div>
                    <select wire:model.live="filterProduk" class="bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-600 focus:ring-4 focus:ring-indigo-500/10 cursor-pointer w-64">
                        <option value="">SEMUA PRODUK</option>
                        @foreach($semuaProduk as $p)
                            <option value="{{ $p->id }}">{{ Str::limit($p->nama, 25) }}</option>
                        @endforeach
                    </select>
                    <select wire:model.live="filterStatus" class="bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-600 focus:ring-4 focus:ring-indigo-500/10 cursor-pointer w-48">
                        <option value="">SEMUA STATUS</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="terjual">Terjual</option>
                        <option value="rusak">Rusak</option>
                        <option value="retur">Retur</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-[45px] shadow-sm border border-indigo-50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas Unit (SN/IMEI)</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Produk</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($daftarSeri as $seri)
                            <tr class="group hover:bg-slate-50 transition-all">
                                <td class="px-8 py-5">
                                    <span class="font-mono font-black text-slate-800 text-sm bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">
                                        {{ $seri->nomor_seri }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                                            <i class="fa-solid fa-box text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-700">{{ $seri->produk->nama }}</p>
                                            <p class="text-[9px] font-bold text-slate-400 uppercase">{{ $seri->produk->kode_unit }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $statusColors = [
                                            'tersedia' => 'bg-emerald-100 text-emerald-700',
                                            'terjual' => 'bg-indigo-100 text-indigo-700',
                                            'rusak' => 'bg-rose-100 text-rose-700',
                                            'retur' => 'bg-amber-100 text-amber-700',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $statusColors[$seri->status] ?? 'bg-slate-100' }}">
                                        {{ $seri->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        @if($seri->status === 'tersedia')
                                            <button wire:click="ubahStatus({{ $seri->id }}, 'rusak')" class="p-2 bg-rose-50 text-rose-500 rounded-lg hover:bg-rose-100 transition-colors" title="Tandai Rusak">
                                                <i class="fa-solid fa-triangle-exclamation"></i>
                                            </button>
                                        @endif
                                        <button wire:click="hapus({{ $seri->id }})" wire:confirm="Hapus nomor seri ini?" class="p-2 bg-slate-50 text-slate-400 hover:bg-slate-200 hover:text-slate-600 rounded-lg transition-colors">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">Tidak ada data seri ditemukan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6 border-t border-slate-50">{{ $daftarSeri->links() }}</div>
            </div>
        </div>
    @else
        <!-- TAMPILAN 2: REGISTRASI MASSAL (FULL PAGE FORM) -->
        <div class="space-y-8 animate-in slide-in-from-right-8 duration-500">
            <!-- Header Editor -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="flex items-center gap-6">
                    <button wire:click="batal" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                    </button>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Registrasi Unit Massal</h1>
                        <p class="text-slate-500 font-medium">Input cepat nomor seri atau IMEI untuk stok baru.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-3xl text-sm font-black hover:bg-slate-100 transition-all">BATAL</button>
                    <button wire:click="registrasiSeri" class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-indigo-600/20 transition-all active:scale-95">SIMPAN DATA</button>
                </div>
            </div>

            <!-- Form Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kolom Kiri: Target Produk -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-6">
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Pilih Produk Target</label>
                            <div class="relative">
                                <i class="fa-solid fa-box absolute left-5 top-1/2 -translate-y-1/2 text-indigo-400"></i>
                                <select wire:model="produkTerpilihId" class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10 cursor-pointer">
                                    <option value="">-- Pilih Unit --</option>
                                    @foreach($semuaProduk as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->kode_unit }})</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('produkTerpilihId') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                        </div>

                        <div class="bg-indigo-50 p-6 rounded-3xl border border-indigo-100">
                            <div class="flex gap-3">
                                <i class="fa-solid fa-circle-info text-indigo-600 mt-1"></i>
                                <p class="text-xs font-bold text-indigo-800 leading-relaxed">
                                    Stok fisik produk akan otomatis bertambah sesuai jumlah nomor seri yang berhasil diregistrasi di sini.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Input Area -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-6">
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Input Nomor Seri / IMEI</label>
                            <textarea wire:model="inputSeriMassal" rows="15" class="w-full bg-slate-50 border-none rounded-3xl px-8 py-6 text-sm font-mono font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300 leading-relaxed" placeholder="Masukkan satu nomor seri per baris...
SN1234567890
SN0987654321
IMEI35467809123456"></textarea>
                            @error('inputSeriMassal') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>