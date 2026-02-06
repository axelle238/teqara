<div class="space-y-12 pb-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <div class="space-y-3">
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">{{ $pembelianId ? 'EDIT' : 'BUAT' }} <span class="text-indigo-600">ORDER</span></h1>
            <p class="text-slate-500 font-medium text-lg">Input detail pembelian barang dari pemasok.</p>
        </div>
        <div class="flex gap-3">
            <button wire:click="simpan(false)" class="px-8 py-4 bg-white border border-indigo-100 text-indigo-600 rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-indigo-50 transition-all">Simpan Draft</button>
            <button wire:click="simpan(true)" wire:confirm="Finalisasi akan menambah stok produk secara permanen. Lanjutkan?" class="px-8 py-4 bg-indigo-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20">Finalisasi Stok</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Form Utama -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50 space-y-6 sticky top-10">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Pemasok / Vendor</label>
                    <div class="flex gap-2">
                        <select wire:model="pemasok_id" class="w-full rounded-2xl border-none bg-slate-50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10">
                            <option value="">Pilih Pemasok</option>
                            @foreach($daftarPemasok as $p) <option value="{{ $p->id }}">{{ $p->nama_perusahaan }}</option> @endforeach
                        </select>
                        <button class="p-4 bg-indigo-100 text-indigo-600 rounded-2xl hover:bg-indigo-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                    @error('pemasok_id') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tanggal Transaksi</label>
                    <input wire:model="tgl_beli" type="date" class="w-full rounded-2xl border-none bg-slate-50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10">
                    @error('tgl_beli') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-6 border-t border-slate-50">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Estimasi</p>
                    <p class="text-3xl font-black text-indigo-600 tracking-tighter">Rp {{ number_format(collect($items)->sum('subtotal'), 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Item List -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Search -->
            <div class="bg-white p-6 rounded-[32px] shadow-sm border border-indigo-50 relative z-20">
                <input 
                    wire:model.live.debounce.300ms="cariProduk" 
                    type="text" 
                    placeholder="Cari Produk untuk ditambahkan..." 
                    class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-4 focus:ring-indigo-500/10"
                >
                @if(count($hasilPencarian) > 0)
                <div class="absolute top-full left-0 w-full mt-2 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-30">
                    @foreach($hasilPencarian as $p)
                    <button 
                        wire:click="tambahItem({{ $p->id }})" 
                        class="w-full text-left p-4 hover:bg-indigo-50 transition-colors flex items-center justify-between border-b border-slate-50 last:border-0"
                    >
                        <span class="font-bold text-slate-900 text-sm uppercase">{{ $p->nama }}</span>
                        <span class="text-[10px] font-bold text-indigo-600">TAMBAH +</span>
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Table Items -->
            <div class="bg-white rounded-[40px] shadow-sm border border-indigo-50 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-8 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Item</th>
                            <th class="px-4 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Harga Beli</th>
                            <th class="px-4 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Qty</th>
                            <th class="px-4 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Subtotal</th>
                            <th class="px-4 py-5"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($items as $index => $item)
                        <tr>
                            <td class="px-8 py-4">
                                <p class="text-sm font-black text-slate-900 uppercase">{{ $item['nama'] }}</p>
                                <p class="text-[9px] font-mono text-slate-400 uppercase tracking-widest">{{ $item['kode_unit'] }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <input 
                                    type="number" 
                                    wire:model="items.{{ $index }}.harga_beli" 
                                    wire:change="hitungSubtotal({{ $index }})"
                                    class="w-32 rounded-xl border-slate-200 bg-slate-50 text-sm font-bold focus:ring-indigo-500"
                                >
                            </td>
                            <td class="px-4 py-4">
                                <input 
                                    type="number" 
                                    wire:model="items.{{ $index }}.jumlah" 
                                    wire:change="hitungSubtotal({{ $index }})"
                                    class="w-20 rounded-xl border-slate-200 bg-slate-50 text-sm font-bold text-center focus:ring-indigo-500"
                                >
                            </td>
                            <td class="px-4 py-4">
                                <span class="text-sm font-black text-slate-900">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <button wire:click="hapusItem({{ $index }})" class="p-2 text-rose-400 hover:bg-rose-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @if(empty($items))
                        <tr><td colspan="5" class="px-8 py-16 text-center text-slate-400 font-medium italic">Belum ada item ditambahkan.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
