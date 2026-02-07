<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Katalog <span class="text-emerald-600">Produk</span></h1>
            <p class="text-slate-500 font-medium">Manajemen inventaris unit dagang secara terpusat.</p>
        </div>
        
        <a href="{{ route('pengelola.produk.tambah') }}" wire:navigate class="flex items-center gap-3 px-6 py-3 bg-emerald-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 active:scale-95">
            <i class="fa-solid fa-plus"></i> Tambah Produk
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex flex-col lg:flex-row gap-4 items-center justify-between">
        <!-- Search -->
        <div class="relative w-full lg:w-96">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-search"></i>
            </div>
            <input wire:model.live.debounce.300ms="cari" type="text" class="w-full pl-11 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 transition-all" placeholder="Cari nama produk atau SKU...">
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap gap-3 w-full lg:w-auto">
            <select wire:model.live="filterKategori" class="px-4 py-3 bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach($kategori_list as $k)
                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterMerek" class="px-4 py-3 bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                <option value="">Semua Merek</option>
                @foreach($merek_list as $m)
                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterStatus" class="px-4 py-3 bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
                <option value="arsip">Arsip</option>
            </select>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden relative min-h-[400px]">
        <div wire:loading class="absolute inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center">
            <div class="flex flex-col items-center gap-3">
                <div class="w-10 h-10 border-4 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
                <span class="text-xs font-black text-emerald-600 uppercase tracking-widest">Memuat Data...</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="px-8 py-6 w-20">Gambar</th>
                        <th class="px-8 py-6 cursor-pointer hover:text-emerald-600 transition-colors" wire:click="sortBy('nama')">
                            Info Produk <i class="fa-solid fa-sort ml-1"></i>
                        </th>
                        <th class="px-8 py-6 cursor-pointer hover:text-emerald-600 transition-colors" wire:click="sortBy('stok')">
                            Stok <i class="fa-solid fa-sort ml-1"></i>
                        </th>
                        <th class="px-8 py-6 cursor-pointer hover:text-emerald-600 transition-colors" wire:click="sortBy('harga_jual')">
                            Harga <i class="fa-solid fa-sort ml-1"></i>
                        </th>
                        <th class="px-8 py-6 text-center">Status</th>
                        <th class="px-8 py-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($data_produk as $p)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-4">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-100 p-1 shadow-sm">
                                <img src="{{ $p->gambar_utama_url ?? 'https://via.placeholder.com/150' }}" class="w-full h-full object-contain rounded-lg">
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex flex-col">
                                <span class="font-black text-slate-800 text-sm mb-1 group-hover:text-emerald-600 transition-colors">{{ $p->nama }}</span>
                                <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-wide">
                                    <span class="bg-slate-100 px-2 py-0.5 rounded text-slate-500">{{ $p->kode_unit }}</span>
                                    <span>•</span>
                                    <span>{{ $p->kategori->nama ?? 'Tanpa Kategori' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            @if($p->stok < 5)
                                <div class="inline-flex flex-col items-start">
                                    <span class="text-rose-600 font-black text-sm">{{ $p->stok }} Unit</span>
                                    <span class="text-[9px] font-bold text-rose-400 uppercase tracking-tighter">Stok Kritis</span>
                                </div>
                            @else
                                <span class="text-slate-700 font-bold text-sm">{{ $p->stok }} Unit</span>
                            @endif
                        </td>
                        <td class="px-8 py-4">
                            <span class="font-mono font-bold text-slate-600">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <button wire:click="toggleStatus({{ $p->id }})" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none {{ $p->status === 'aktif' ? 'bg-emerald-500' : 'bg-slate-200' }}">
                                <span class="translate-x-1 inline-block h-4 w-4 transform rounded-full bg-white transition {{ $p->status === 'aktif' ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('pengelola.produk.edit', $p->id) }}" wire:navigate class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <button wire:confirm="Hapus produk {{ $p->nama }}?" wire:click="hapus({{ $p->id }})" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-rose-500 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all shadow-sm" title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-3xl text-slate-300 mb-4">
                                    <i class="fa-solid fa-box-open"></i>
                                </div>
                                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Tidak Ada Produk</h3>
                                <p class="text-slate-400 text-sm font-medium mt-1">Coba sesuaikan filter atau tambahkan produk baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-8 py-6 border-t border-slate-50">
            {{ $data_produk->links() }}
        </div>
    </div>
</div>
