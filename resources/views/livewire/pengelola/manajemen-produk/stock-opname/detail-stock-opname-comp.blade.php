<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('pengelola.produk.so.riwayat') }}" class="text-slate-400 hover:text-indigo-600 transition-colors">
                    <i class="fa-solid fa-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Audit <span class="text-indigo-600">Stok</span></h1>
            </div>
            <p class="text-slate-500 font-medium text-sm ml-8">Kode Sesi: <span class="font-mono font-bold text-slate-700">{{ $so->kode_so }}</span></p>
        </div>

        @if($so->status != 'selesai')
        <div class="flex gap-3">
            <button wire:click="simpanProgress" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Draft
            </button>
            <button wire:click="selesaiAudit" wire:confirm="Selesaikan audit ini? Stok sistem akan diperbarui sesuai hasil fisik." class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                <i class="fa-solid fa-check-double mr-2"></i> Finalisasi & Sesuaikan Stok
            </button>
        </div>
        @endif
    </div>

    <!-- Scanner / Search Bar -->
    @if($so->status != 'selesai')
    <div class="bg-white p-6 rounded-[30px] border border-indigo-100 shadow-sm relative z-20">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-400">
                <i class="fa-solid fa-barcode text-lg"></i>
            </div>
            <input wire:model.live.debounce.300ms="cariProduk" type="text" class="w-full pl-14 pr-4 py-4 bg-indigo-50/30 border-none rounded-2xl text-base font-bold text-slate-800 placeholder-slate-400 focus:ring-4 focus:ring-indigo-500/20 transition-all" placeholder="Scan Barcode atau Ketik Nama Produk untuk ditambahkan ke list audit...">
            
            @if(!empty($hasilPencarian))
            <div class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-30">
                @foreach($hasilPencarian as $p)
                <button wire:click="tambahProduk({{ $p->id }})" class="w-full text-left px-6 py-4 hover:bg-indigo-50 transition-colors border-b border-slate-50 last:border-0 flex items-center justify-between group">
                    <div>
                        <span class="block font-bold text-slate-800 text-sm group-hover:text-indigo-700">{{ $p->nama }}</span>
                        <span class="text-xs text-slate-400 font-mono">{{ $p->kode_unit }}</span>
                    </div>
                    <span class="text-indigo-600 font-black text-xs uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">+ Tambah</span>
                </button>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Audit Table -->
    <div class="bg-white rounded-[40px] border border-slate-200 shadow-sm overflow-hidden min-h-[500px]">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="px-8 py-6 w-16">#</th>
                        <th class="px-6 py-6">Produk / Unit</th>
                        <th class="px-6 py-6 text-center w-32">Stok Sistem</th>
                        <th class="px-6 py-6 text-center w-40">Fisik (Riil)</th>
                        <th class="px-6 py-6 text-center w-32">Selisih</th>
                        <th class="px-6 py-6 w-64">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($so->detail as $index => $item)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-4 text-center font-bold text-slate-300">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-xl border border-slate-100 p-1 flex-shrink-0">
                                    <img src="{{ $item->produk->gambar_utama_url }}" class="w-full h-full object-contain">
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">{{ $item->produk->nama }}</h4>
                                    <p class="text-[10px] font-mono text-slate-400">{{ $item->produk->kode_unit }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-slate-100 rounded-lg text-xs font-black text-slate-600">{{ $item->stok_sistem }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($so->status == 'selesai')
                                <span class="text-sm font-black text-slate-900">{{ $item->stok_fisik }}</span>
                            @else
                                <input type="number" wire:model="inputFisik.{{ $item->id }}" class="w-24 text-center bg-white border-2 border-indigo-100 rounded-xl px-2 py-2 text-sm font-bold focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $diff = ($inputFisik[$item->id] ?? $item->stok_fisik) - $item->stok_sistem;
                                $diffColor = $diff == 0 ? 'text-emerald-500' : ($diff < 0 ? 'text-rose-500' : 'text-blue-500');
                                $diffIcon = $diff == 0 ? 'fa-check' : ($diff < 0 ? 'fa-arrow-down' : 'fa-arrow-up');
                            @endphp
                            <span class="font-black text-sm {{ $diffColor }}">
                                {{ $diff > 0 ? '+' : '' }}{{ $diff }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($so->status == 'selesai')
                                <p class="text-xs text-slate-500 italic">{{ $item->catatan ?? '-' }}</p>
                            @else
                                <input type="text" wire:model="catatanItem.{{ $item->id }}" placeholder="Keterangan..." class="w-full bg-transparent border-none text-xs text-slate-600 placeholder-slate-300 focus:ring-0 border-b border-slate-200 focus:border-indigo-300 transition-all">
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-20 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl text-slate-300">
                                <i class="fa-solid fa-list-check"></i>
                            </div>
                            <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Belum ada item diaudit.</p>
                            <p class="text-slate-400 text-[10px] mt-1">Scan barcode produk untuk memulai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
