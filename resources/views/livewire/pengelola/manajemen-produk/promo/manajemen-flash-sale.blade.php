<div class="space-y-12 pb-32 animate-in fade-in duration-500">
    
    @if(!$tampilkanForm)
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rose-50 border border-rose-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-rose-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-rose-600 uppercase tracking-[0.3em]">Marketing Engine</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">FLASH <span class="text-rose-600">SALE</span></h1>
            <p class="text-slate-500 font-medium text-lg">Manajemen kampanye diskon berbatas waktu untuk mendongkrak penjualan.</p>
        </div>
        <button wire:click="tambahCampaign" class="px-8 py-4 bg-rose-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-rose-700 shadow-xl shadow-rose-500/20 flex items-center gap-3">
            <i class="fa-solid fa-bolt-lightning"></i> Buat Kampanye Baru
        </button>
    </div>

    <!-- Active Campaigns List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($campaigns as $c)
        <div class="bg-white rounded-[40px] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden group relative">
            <div class="absolute top-0 right-0 w-64 h-64 bg-rose-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            
            <div class="p-8 relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $c->aktif && $c->selesai > now() ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                        {{ $c->aktif && $c->selesai > now() ? 'Sedang Berjalan' : 'Selesai / Non-Aktif' }}
                    </span>
                    <button wire:click="edit({{ $c->id }})" class="p-2 bg-slate-50 text-slate-400 hover:text-indigo-600 rounded-xl transition">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </div>
                
                <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-2 uppercase">{{ $c->nama_campaign }}</h3>
                
                <div class="flex items-center gap-4 text-[10px] font-bold text-slate-500 mb-6 uppercase tracking-widest">
                    <span class="flex items-center gap-2">
                        <i class="fa-regular fa-calendar-check text-indigo-500"></i>
                        {{ $c->mulai->format('d M H:i') }}
                    </span>
                    <span class="text-slate-300">➜</span>
                    <span class="flex items-center gap-2">
                        <i class="fa-regular fa-calendar-xmark text-rose-500"></i>
                        {{ $c->selesai->format('d M H:i') }}
                    </span>
                </div>

                <div class="flex items-center justify-between border-t border-slate-50 pt-6">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Produk</p>
                        <p class="text-xl font-black text-slate-900">{{ $c->detail_produk_count }} <span class="text-xs text-slate-400">Unit</span></p>
                    </div>
                    <div class="flex -space-x-2">
                        @foreach($c->detailProduk->take(3) as $d)
                            <img src="{{ $d->produk->gambar_utama_url }}" class="w-10 h-10 rounded-full border-2 border-white bg-slate-50 object-contain shadow-sm">
                        @endforeach
                        @if($c->detail_produk_count > 3)
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500 shadow-sm">
                                +{{ $c->detail_produk_count - 3 }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-white rounded-[40px] border border-dashed border-slate-200">
            <p class="text-slate-400 font-black uppercase tracking-widest text-xs">Belum ada kampanye Flash Sale.</p>
        </div>
        @endforelse
    </div>
    @else
    <!-- Full Page Editor -->
    <div class="space-y-8 animate-in slide-in-from-right-8 duration-500">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50 sticky top-24 z-30">
            <div class="flex items-center gap-6">
                <button wire:click="batal" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xl"></i>
                </button>
                <div class="space-y-1">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">{{ $campaignId ? 'Sunting Kampanye' : 'Buat Kampanye Baru' }}</h1>
                    <p class="text-slate-500 font-medium uppercase tracking-widest text-[10px]">Konfigurasi Flash Sale Enterprise</p>
                </div>
            </div>
            <div class="flex gap-4">
                <button wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-3xl text-sm font-black hover:bg-slate-100 transition-all">BATAL</button>
                <button wire:click="simpan" class="px-10 py-4 bg-rose-600 hover:bg-rose-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-rose-600/20 transition-all active:scale-95 flex items-center gap-2">
                    <i class="fa-solid fa-bolt"></i> JADWALKAN
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Config -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Nama Kampanye</label>
                        <input wire:model="nama_campaign" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-rose-500/10 placeholder:text-slate-300" placeholder="Contoh: Flash Sale Akhir Tahun">
                        @error('nama_campaign') <span class="text-rose-500 text-[10px] font-bold px-1 block mt-2">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-6 pt-6 border-t border-slate-50">
                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Waktu Mulai</label>
                            <input wire:model="mulai" type="datetime-local" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-rose-500/10">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Waktu Selesai</label>
                            <input wire:model="selesai" type="datetime-local" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-rose-500/10">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="aktif" class="w-6 h-6 rounded-lg text-rose-600 focus:ring-rose-500 border-slate-200">
                            <span class="text-sm font-black text-slate-700 uppercase tracking-widest">Aktifkan Sekarang</span>
                        </label>
                    </div>
                </div>

                <!-- Banner Media -->
                <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-4">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Banner Kampanye</label>
                    <div class="relative aspect-[2/1] bg-slate-50 rounded-3xl border-4 border-dashed border-slate-100 flex items-center justify-center overflow-hidden group hover:border-rose-200 transition-all cursor-pointer">
                        @if($banner)
                            <img src="{{ $banner->temporaryUrl() }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-center space-y-2">
                                <i class="fa-solid fa-image text-3xl text-slate-200"></i>
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Upload Banner</p>
                            </div>
                        @endif
                        <input type="file" wire:model="banner" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>
            </div>

            <!-- Right: Product Table -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-6 rounded-[40px] border border-indigo-50 shadow-sm relative z-20">
                    <div class="relative">
                        <i class="fa-solid fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input wire:model.live.debounce.300ms="cariProduk" type="text" placeholder="Cari unit produk untuk diskon..." class="w-full pl-14 pr-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold focus:ring-4 focus:ring-rose-500/10">
                        
                        @if(!empty($hasilPencarian))
                        <div class="absolute top-full left-0 right-0 mt-2 bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-30">
                            @foreach($hasilPencarian as $p)
                            <button type="button" wire:click="tambahItem({{ $p->id }})" class="w-full text-left px-8 py-4 hover:bg-rose-50 transition-colors border-b border-slate-50 last:border-0 flex justify-between items-center group">
                                <div>
                                    <span class="block font-black text-slate-800 text-sm group-hover:text-rose-600">{{ $p->nama }}</span>
                                    <span class="text-xs text-slate-400 font-mono">{{ $p->kode_unit }}</span>
                                </div>
                                <span class="px-4 py-1.5 bg-rose-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest">+ PILIH</span>
                            </button>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-[50px] border border-indigo-50 shadow-sm overflow-hidden min-h-[500px]">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    <th class="px-10 py-6">Produk Unit</th>
                                    <th class="px-6 py-6 w-48">Harga Diskon</th>
                                    <th class="px-6 py-6 w-32 text-center">Kuota Stok</th>
                                    <th class="px-10 py-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($items as $index => $item)
                                <tr class="group hover:bg-slate-50/50 transition-all">
                                    <td class="px-10 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center p-1 border border-slate-200">
                                                <i class="fa-solid fa-tag text-slate-300"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-black text-slate-800 text-sm mb-1">{{ $item['nama'] }}</h4>
                                                <p class="text-[10px] font-bold text-slate-400 line-through">Rp{{ number_format($item['harga_asli'], 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] font-black text-rose-300">Rp</span>
                                            <input type="number" wire:model="items.{{ $index }}.harga_diskon" class="w-full pl-8 pr-3 py-2 bg-rose-50/50 border-none rounded-xl text-sm font-black text-rose-600 focus:ring-2 focus:ring-rose-500">
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <input type="number" wire:model="items.{{ $index }}.kuota_stok" class="w-20 px-2 py-2 bg-slate-50 border-none rounded-xl text-sm font-black text-slate-800 text-center focus:ring-2 focus:ring-indigo-500">
                                    </td>
                                    <td class="px-10 py-6 text-right">
                                        <button type="button" wire:click="hapusItem({{ $index }})" class="w-10 h-10 rounded-xl bg-rose-50 text-rose-400 hover:bg-rose-600 hover:text-white transition-all">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-24 text-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl text-slate-200">
                                            <i class="fa-solid fa-layer-group"></i>
                                        </div>
                                        <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Keranjang Kampanye Kosong</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>