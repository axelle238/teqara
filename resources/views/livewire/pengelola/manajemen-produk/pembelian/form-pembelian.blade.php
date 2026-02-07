<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Purchase <span class="text-amber-500">Order</span></h1>
            <p class="text-slate-500 font-medium text-sm mt-1">Buat pesanan stok baru ke pemasok mitra.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('pengelola.produk.pembelian.riwayat') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition-all">
                Batal
            </a>
            <button wire:click="simpan" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20">
                <i class="fa-solid fa-paper-plane mr-2"></i> Simpan PO
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Kolom Kiri: Info PO -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-8 rounded-[30px] border border-slate-200 shadow-sm space-y-6">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs border-b border-slate-100 pb-4">Informasi Dokumen</h3>
                
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Pilih Pemasok</label>
                    <select wire:model="pemasok_id" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-amber-500">
                        <option value="">-- Cari Vendor --</option>
                        @foreach($pemasokList as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                    @error('pemasok_id') <span class="text-rose-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nomor Referensi (Opsional)</label>
                    <input type="text" wire:model="nomor_referensi" placeholder="No. Invoice Vendor" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tanggal Transaksi</label>
                    <input type="date" wire:model="tanggal" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Status Dokumen</label>
                    <select wire:model="status" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-amber-500">
                        <option value="draft">Draft (Rancangan)</option>
                        <option value="dipesan">Dipesan (Sent to Vendor)</option>
                        <option value="selesai">Selesai (Barang Masuk)</option>
                    </select>
                    @if($status == 'selesai')
                        <p class="text-[10px] text-emerald-600 font-bold bg-emerald-50 p-2 rounded-lg mt-2">
                            <i class="fa-solid fa-info-circle"></i> Stok produk akan otomatis bertambah saat disimpan.
                        </p>
                    @endif
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Catatan Internal</label>
                    <textarea wire:model="catatan" rows="3" class="w-full bg-slate-50 border-none rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-amber-500 resize-none"></textarea>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Item Barang -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Search Product -->
            <div class="bg-white p-4 rounded-[24px] border border-slate-200 shadow-sm relative z-20">
                <div class="relative">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input wire:model.live.debounce.300ms="cariProduk" type="text" placeholder="Ketik nama produk untuk ditambahkan..." class="w-full pl-10 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                    
                    @if(!empty($hasilPencarian))
                    <div class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-30">
                        @foreach($hasilPencarian as $p)
                        <button wire:click="tambahItem({{ $p->id }})" class="w-full text-left px-6 py-3 hover:bg-slate-50 border-b border-slate-50 last:border-0 flex justify-between items-center group transition-colors">
                            <div>
                                <span class="block font-bold text-slate-800 text-sm group-hover:text-indigo-600">{{ $p->nama }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $p->kode_unit }}</span>
                            </div>
                            <span class="text-indigo-600 font-black text-xs uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">Pilih</span>
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Table Items -->
            <div class="bg-white rounded-[30px] border border-slate-200 shadow-sm overflow-hidden min-h-[400px] flex flex-col">
                <div class="flex-1 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Produk</th>
                                <th class="px-4 py-4 w-32">Harga Beli</th>
                                <th class="px-4 py-4 w-24 text-center">Qty</th>
                                <th class="px-6 py-4 text-right w-40">Subtotal</th>
                                <th class="px-4 py-4 w-10"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($items as $index => $item)
                            <tr class="group hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-slate-900 text-sm">{{ $item['nama'] }}</p>
                                    <p class="text-[10px] font-mono text-slate-400">{{ $item['kode'] }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <input type="number" wire:model="items.{{ $index }}.harga_beli" wire:change="hitungSubtotal({{ $index }})" class="w-full bg-slate-50 border-none rounded-lg py-1 px-2 text-xs font-bold text-slate-700 text-right focus:ring-2 focus:ring-indigo-500">
                                </td>
                                <td class="px-4 py-4">
                                    <input type="number" wire:model="items.{{ $index }}.jumlah" wire:change="hitungSubtotal({{ $index }})" class="w-full bg-slate-50 border-none rounded-lg py-1 px-2 text-xs font-bold text-slate-700 text-center focus:ring-2 focus:ring-indigo-500">
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="font-black text-slate-900 text-sm">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button wire:click="hapusItem({{ $index }})" class="text-slate-300 hover:text-rose-500 transition-colors">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-20 text-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl text-slate-300">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </div>
                                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Keranjang PO Kosong</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Total -->
                <div class="bg-slate-900 text-white p-8 mt-auto flex justify-between items-center">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Unit</p>
                        <p class="font-bold">{{ array_sum(array_column($items, 'jumlah')) }} Item</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Estimasi Biaya</p>
                        <h3 class="text-3xl font-black text-amber-400 tracking-tighter">Rp {{ number_format($this->total, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>