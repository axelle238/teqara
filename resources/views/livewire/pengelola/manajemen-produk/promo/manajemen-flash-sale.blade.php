<div class="space-y-12 pb-32">
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
        <button wire:click="tambahCampaign" class="px-8 py-4 bg-rose-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-rose-700 transition-all shadow-xl shadow-rose-500/20 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Buat Kampanye Baru
        </button>
    </div>

    <!-- Active Campaigns List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($campaigns as $c)
        <div class="bg-white rounded-[40px] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden group relative">
            <!-- Banner Overlay -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-rose-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            
            <div class="p-8 relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $c->aktif && $c->selesai > now() ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                        {{ $c->aktif && $c->selesai > now() ? 'Sedang Berjalan' : 'Selesai / Non-Aktif' }}
                    </span>
                    <button wire:click="edit({{ $c->id }})" class="p-2 bg-slate-50 text-slate-400 hover:text-indigo-600 rounded-xl transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                </div>
                
                <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-2 uppercase">{{ $c->nama_campaign }}</h3>
                
                <div class="flex items-center gap-4 text-xs font-bold text-slate-500 mb-6">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $c->mulai->format('d M H:i') }}
                    </span>
                    <span class="text-slate-300">➜</span>
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                            <img src="{{ $d->produk->gambar_utama_url }}" class="w-10 h-10 rounded-full border-2 border-white bg-slate-50 object-contain">
                        @endforeach
                        @if($c->detail_produk_count > 3)
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500">
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

    <!-- Panel Form Flash Sale -->
    <x-ui.panel-geser id="form-flash-sale" judul="KONFIGURASI KAMPANYE">
        <form wire:submit.prevent="simpan" class="space-y-8 p-2">
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Kampanye</label>
                <input wire:model="nama_campaign" type="text" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-rose-500/10" placeholder="Contoh: Flash Sale 12.12">
                @error('nama_campaign') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Waktu Mulai</label>
                    <input wire:model="mulai" type="datetime-local" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-rose-500/10">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Waktu Selesai</label>
                    <input wire:model="selesai" type="datetime-local" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-rose-500/10">
                </div>
            </div>

            <!-- Product Selection -->
            <div class="space-y-4 pt-4 border-t border-slate-50">
                <h4 class="text-sm font-black text-slate-900 uppercase tracking-tight">Pilih Produk Diskon</h4>
                
                <div class="relative">
                    <input 
                        wire:model.live.debounce.300ms="cariProduk" 
                        type="text" 
                        placeholder="Cari Produk..." 
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-xs font-bold focus:ring-4 focus:ring-rose-500/10"
                    >
                    @if(count($hasilPencarian) > 0)
                    <div class="absolute top-full left-0 w-full mt-2 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-20">
                        @foreach($hasilPencarian as $p)
                        <button type="button" wire:click="tambahItem({{ $p->id }})" class="w-full text-left p-3 hover:bg-rose-50 text-xs font-bold text-slate-700 border-b border-slate-50 last:border-0 flex justify-between">
                            <span>{{ $p->nama }}</span>
                            <span class="text-rose-500">+ Tambah</span>
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Items List -->
                <div class="space-y-3 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($items as $index => $item)
                    <div class="bg-white border border-slate-100 p-4 rounded-2xl flex flex-col gap-3 relative group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-black text-slate-900 uppercase line-clamp-1">{{ $item['nama'] }}</p>
                                <p class="text-[9px] font-bold text-slate-400 line-through">Rp {{ number_format($item['harga_asli'], 0, ',', '.') }}</p>
                            </div>
                            <button type="button" wire:click="hapusItem({{ $index }})" class="text-rose-400 hover:text-rose-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase">Harga Diskon</label>
                                <input type="number" wire:model="items.{{ $index }}.harga_diskon" class="w-full rounded-xl border-slate-200 bg-slate-50 text-xs font-bold focus:ring-rose-500 p-2 text-rose-600">
                            </div>
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase">Kuota Stok</label>
                                <input type="number" wire:model="items.{{ $index }}.kuota_stok" class="w-full rounded-xl border-slate-200 bg-slate-50 text-xs font-bold focus:ring-rose-500 p-2">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-rose-600 transition-all shadow-xl shadow-rose-500/20">
                    Jadwalkan Kampanye
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>
