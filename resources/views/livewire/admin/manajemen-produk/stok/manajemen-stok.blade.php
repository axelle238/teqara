<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Control Tower Inventaris</h1>
            <p class="text-slate-500 text-sm mt-1">Pemantauan rantai pasok multi-gudang dan kesehatan stok.</p>
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-sm font-bold shadow-sm border border-indigo-100 hover:bg-indigo-100 transition-colors">
                <i class="fa-solid fa-file-pdf mr-2"></i> Laporan Opname
            </button>
        </div>
    </div>

    <!-- Inventory Health Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm relative overflow-hidden">
            <i class="fa-solid fa-layer-group text-6xl text-indigo-500 opacity-10 absolute right-0 top-0 p-4"></i>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Aset</p>
            <h3 class="text-2xl font-black text-slate-900 mt-2">{{ number_format($this->analitik['total_unit']) }} Unit</h3>
            <p class="text-[10px] text-slate-400 mt-1">Valuasi: Rp {{ number_format($this->analitik['valuasi']/1000000000, 2) }} Miliar</p>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer hover:border-emerald-200" wire:click="$set('filterKesehatan', 'aman')">
            <i class="fa-solid fa-shield-heart text-6xl text-emerald-500 opacity-10 absolute right-0 top-0 p-4"></i>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Stok Sehat</p>
            <h3 class="text-2xl font-black text-emerald-600 mt-2">{{ $this->analitik['aman'] }} SKU</h3>
            <p class="text-[10px] text-slate-400 mt-1">Perputaran Optimal</p>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer hover:border-amber-200" wire:click="$set('filterKesehatan', 'kritis')">
            <i class="fa-solid fa-triangle-exclamation text-6xl text-amber-500 opacity-10 absolute right-0 top-0 p-4"></i>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Kritis / Menipis</p>
            <h3 class="text-2xl font-black text-amber-500 mt-2">{{ $this->analitik['kritis'] }} SKU</h3>
            <p class="text-[10px] text-slate-400 mt-1">Perlu Restock Segera</p>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer hover:border-rose-200" wire:click="$set('filterKesehatan', 'habis')">
            <i class="fa-solid fa-ban text-6xl text-rose-500 opacity-10 absolute right-0 top-0 p-4"></i>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Stockout (Habis)</p>
            <h3 class="text-2xl font-black text-rose-500 mt-2">{{ $this->analitik['habis'] }} SKU</h3>
            <p class="text-[10px] text-slate-400 mt-1">Kehilangan Potensi Jual</p>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-slate-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button wire:click="$set('tabAktif', 'posisi')" class="{{ $tabAktif === 'posisi' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap border-b-2 py-4 px-1 text-sm font-bold flex items-center gap-2">
                <i class="fa-solid fa-cubes-stacked"></i> Posisi Stok Fisik
            </button>
            <button wire:click="$set('tabAktif', 'mutasi')" class="{{ $tabAktif === 'mutasi' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap border-b-2 py-4 px-1 text-sm font-bold flex items-center gap-2">
                <i class="fa-solid fa-right-left"></i> Jurnal Mutasi
            </button>
        </nav>
    </div>

    <!-- Tab Content: Posisi Stok -->
    @if($tabAktif === 'posisi')
    <div class="bg-white border border-slate-100 rounded-[24px] shadow-sm overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-4 border-b border-slate-100 flex justify-between items-center">
            <div class="relative w-64">
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari SKU / Nama Produk..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border-none rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500">
                <i class="fa-solid fa-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
            </div>
            @if($filterKesehatan)
                <button wire:click="$set('filterKesehatan', '')" class="text-xs font-bold text-rose-500 hover:underline">Hapus Filter</button>
            @endif
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-black tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Identitas Produk</th>
                        <th class="px-6 py-4">Lokasi & Kategori</th>
                        <th class="px-6 py-4 text-center">Stok Global</th>
                        <th class="px-6 py-4 text-center">Valuasi (HPP)</th>
                        <th class="px-6 py-4 text-right">Kontrol</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($stokGlobal as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0">
                                    @if($item->gambar_utama)
                                        <img src="{{ asset($item->gambar_utama) }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <i class="fa-solid fa-box text-slate-300"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 text-xs">{{ $item->nama }}</p>
                                    <p class="font-mono text-[10px] text-slate-400">{{ $item->kode_unit }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs font-bold text-slate-600">{{ $item->kategori->nama ?? '-' }}</p>
                            <p class="text-[10px] text-slate-400">Gudang Pusat (Default)</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item->stok <= 0)
                                <span class="px-3 py-1 rounded bg-rose-100 text-rose-700 text-[10px] font-black uppercase">Habis</span>
                            @elseif($item->stok <= 5)
                                <span class="px-3 py-1 rounded bg-amber-100 text-amber-700 text-[10px] font-black uppercase animate-pulse">{{ $item->stok }} Unit</span>
                            @else
                                <span class="px-3 py-1 rounded bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase">{{ $item->stok }} Unit</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center font-mono font-bold text-slate-700">
                            Rp {{ number_format($item->harga_modal * $item->stok, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button wire:click="bukaMutasi({{ $item->id }}, 'penerimaan')" class="p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition-colors" title="Terima Barang">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                                <button wire:click="bukaMutasi({{ $item->id }}, 'transfer')" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors" title="Transfer Gudang">
                                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                </button>
                                <button wire:click="bukaMutasi({{ $item->id }}, 'penyesuaian')" class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition-colors" title="Opname / Koreksi">
                                    <i class="fa-solid fa-pen-ruler"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            Data inventaris tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $stokGlobal->links() }}
        </div>
    </div>
    @endif

    <!-- Tab Content: Jurnal Mutasi -->
    @if($tabAktif === 'mutasi')
    <div class="bg-white border border-slate-100 rounded-[24px] shadow-sm overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-black tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Tipe Aksi</th>
                        <th class="px-6 py-4 text-right">Perubahan</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4">Oleh</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($jurnalMutasi as $log)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-xs font-mono text-slate-500">
                            {{ $log->waktu->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900 text-xs">
                            {{ $log->produk->nama ?? 'Produk Terhapus' }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $tipeStyle = match($log->jenis_mutasi) {
                                    'masuk', 'penerimaan' => 'bg-emerald-100 text-emerald-700',
                                    'keluar', 'penjualan' => 'bg-rose-100 text-rose-700',
                                    'transfer_gudang' => 'bg-indigo-100 text-indigo-700',
                                    default => 'bg-amber-100 text-amber-700'
                                };
                            @endphp
                            <span class="px-2 py-1 rounded text-[10px] font-black uppercase {{ $tipeStyle }}">
                                {{ str_replace('_', ' ', $log->jenis_mutasi) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-mono font-bold {{ $log->jumlah > 0 ? 'text-emerald-600' : ($log->jumlah < 0 ? 'text-rose-600' : 'text-slate-400') }}">
                            {{ $log->jumlah > 0 ? '+' : '' }}{{ $log->jumlah }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-600 max-w-xs truncate">
                            {{ $log->keterangan }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">
                            {{ $log->pengguna->nama ?? 'Sistem' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            Belum ada catatan mutasi stok.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $jurnalMutasi->links() }}
        </div>
    </div>
    @endif

    <!-- Slide Over: Form Mutasi -->
    <x-ui.panel-geser id="panel-mutasi" :judul="'Operasi Logistik: ' . ucfirst($jenisAksi)">
        <form wire:submit="eksekusiMutasi" class="space-y-6">
            
            <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 flex gap-4 items-center">
                <i class="fa-solid fa-circle-info text-indigo-600 text-lg"></i>
                <div class="text-xs text-indigo-800">
                    @if($jenisAksi == 'transfer')
                        Anda akan memindahkan stok fisik antar gudang. Total aset global tidak berubah.
                    @elseif($jenisAksi == 'penerimaan')
                        Mencatat barang masuk dari vendor atau retur. Stok akan bertambah.
                    @else
                        Koreksi manual untuk barang rusak/hilang (Opname). Stok akan berkurang.
                    @endif
                </div>
            </div>

            @if($jenisAksi == 'transfer')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Dari Gudang</label>
                    <select wire:model="dariGudangId" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold">
                        <option value="">Pilih Asal</option>
                        @foreach($daftarGudang as $g)
                            <option value="{{ $g->id }}">{{ $g->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Ke Gudang</label>
                    <select wire:model="keGudangId" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold">
                        <option value="">Pilih Tujuan</option>
                        @foreach($daftarGudang as $g)
                            <option value="{{ $g->id }}">{{ $g->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Jumlah Unit</label>
                <input wire:model="jumlahMutasi" type="number" min="1" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold text-lg" placeholder="0">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Keterangan / Memo</label>
                <textarea wire:model="keteranganMutasi" rows="3" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500" placeholder="Contoh: Barang rusak karena air, atau PO Vendor #123..."></textarea>
            </div>

            <div class="fixed bottom-0 right-0 w-full md:w-[480px] bg-white border-t border-slate-200 p-6 z-50">
                <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold shadow-lg transition-all active:scale-95">
                    Konfirmasi Eksekusi
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>