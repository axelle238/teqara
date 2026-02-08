<div class="space-y-12 pb-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <div class="flex items-center gap-6">
            <a href="{{ route('pengelola.produk.katalog') }}" wire:navigate class="w-16 h-16 rounded-[24px] bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-indigo-600 hover:text-white transition-all shadow-inner group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div class="space-y-1">
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase leading-none">CETAK <span class="text-indigo-600">LABEL</span></h1>
                @if($produk)
                    <p class="text-slate-500 font-medium text-lg">Generator Barcode & QR Code untuk Unit: <span class="font-black text-slate-900">{{ $produk->nama }}</span></p>
                @else
                    <p class="text-slate-500 font-medium text-lg">Pilih unit produk terlebih dahulu untuk mencetak label.</p>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-3">
            @if($produk)
                <button onclick="window.print()" class="px-8 py-4 bg-slate-900 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/20 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Dokumen
                </button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 print:block print:w-full">
        <!-- Configuration Panel (Hidden on Print) -->
        <div class="lg:col-span-4 print:hidden space-y-8">
            <div class="bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-6">Konfigurasi Label</h3>
                
                <div class="space-y-6">
                    <!-- Pencarian Produk -->
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Cari Produk (SKU/Nama)</label>
                        <div class="relative">
                            <input wire:model.live.debounce.300ms="cariProduk" type="text" placeholder="Ketik minimal 3 karakter..." class="w-full rounded-2xl border-none bg-slate-50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            @if(count($hasilPencarian) > 0)
                                <div class="absolute top-full left-0 w-full bg-white rounded-2xl shadow-2xl border border-slate-100 z-50 mt-2 overflow-hidden animate-in slide-in-from-top-2">
                                    @foreach($hasilPencarian as $item)
                                        <button wire:click="pilihProduk({{ $item->id }})" class="w-full px-6 py-4 text-left hover:bg-indigo-50 transition-colors flex items-center justify-between border-b border-slate-50 last:border-0">
                                            <div>
                                                <p class="text-xs font-black text-slate-900 uppercase">{{ $item->nama }}</p>
                                                <p class="text-[10px] font-mono text-indigo-500">{{ $item->kode_unit }}</p>
                                            </div>
                                            <i class="fa-solid fa-chevron-right text-xs text-slate-300"></i>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($produk)
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tipe Label</label>
                        <select wire:model.live="tipeLabel" class="w-full rounded-2xl border-none bg-slate-50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                            <option value="barcode_1">Barcode (Code 128) - Standar</option>
                            <option value="qr_1">QR Code - Link Produk</option>
                            <option value="price_tag">Price Tag (Rak Toko)</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Jumlah Salinan</label>
                        <input wire:model.live="jumlahCetak" type="number" min="1" max="100" class="w-full rounded-2xl border-none bg-slate-50 px-6 py-4 text-sm font-black text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                    </div>
                    @endif
                </div>
            </div>

            @if($produk)
            <div class="bg-indigo-600 p-8 rounded-[40px] text-white shadow-2xl relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="font-black uppercase tracking-widest text-xs mb-2 text-indigo-200">Unit Terpilih</h4>
                    <p class="text-2xl font-black leading-tight mb-4 italic">{{ $produk->kode_unit }}</p>
                    <p class="text-sm font-medium opacity-80">{{ $produk->nama }}</p>
                </div>
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            </div>
            @endif
        </div>

        <!-- Preview Area (Printed Area) -->
        <div class="lg:col-span-8 print:w-full">
            @if($produk)
                <div class="bg-white p-12 rounded-[56px] shadow-sm border border-indigo-50 min-h-[600px] print:shadow-none print:border-none print:p-0 animate-in fade-in duration-700">
                    <div class="flex flex-wrap gap-4 justify-center print:justify-start">
                        @for($i = 0; $i < $jumlahCetak; $i++)
                            @if($tipeLabel === 'barcode_1')
                                <div class="w-[300px] h-[150px] border border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center text-center bg-white print:break-inside-avoid">
                                    <p class="text-xs font-bold text-slate-900 truncate w-full mb-2 uppercase">{{ $produk->nama }}</p>
                                    <!-- Dummy Barcode Visual -->
                                    <div class="h-12 w-full bg-slate-900 mb-1" style="mask-image: repeating-linear-gradient(90deg, black, black 2px, transparent 2px, transparent 4px);"></div>
                                    <p class="text-sm font-mono font-black text-slate-600 tracking-widest italic">{{ $produk->kode_unit }}</p>
                                </div>
                            @elseif($tipeLabel === 'qr_1')
                                <div class="w-[150px] h-[180px] border border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center text-center bg-white print:break-inside-avoid">
                                    <div class="w-24 h-24 bg-slate-900 mb-2 rounded-lg flex items-center justify-center">
                                        <!-- Dummy QR -->
                                        <div class="w-20 h-20 border-4 border-white bg-white">
                                            <div class="w-full h-full bg-slate-900" style="mask-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMCAxMCI+PHBhdGggZD0iTTAgMGgzdjNIMHptNCAwaDN2M0g0em00IDBoM3YzSDh6TTAgNGgzdjNIMHptNCA0aDN2M0g0em00IDBoM3YzSDh6IiBmaWxsPSIjMDAwIi8+PC9zdmc+'); mask-size: cover;"></div>
                                        </div>
                                    </div>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase">Scan Info</p>
                                </div>
                            @elseif($tipeLabel === 'price_tag')
                                <div class="w-[240px] h-[120px] border-2 border-slate-900 rounded-lg p-4 flex flex-col justify-between bg-white print:break-inside-avoid relative overflow-hidden">
                                    <div class="absolute top-0 right-0 bg-slate-900 text-white text-[10px] font-black px-2 py-1 rounded-bl-lg uppercase tracking-widest italic">Teqara Official</div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">{{ $produk->kategori->nama ?? 'Unit' }}</p>
                                        <p class="text-sm font-black text-slate-900 leading-tight line-clamp-2 uppercase italic">{{ $produk->nama }}</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-black text-slate-900 tracking-tighter italic">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                                        <p class="text-[9px] font-mono text-slate-400">{{ $produk->kode_unit }}</p>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>
            @else
                <div class="bg-white p-12 rounded-[56px] shadow-sm border border-indigo-50 min-h-[600px] flex flex-col items-center justify-center text-center opacity-60">
                    <div class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center text-5xl text-slate-300 mb-6">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 uppercase">Belum Ada Unit</h3>
                    <p class="text-slate-500 max-w-xs mx-auto mt-2">Gunakan panel pencarian di samping kiri untuk memilih produk yang ingin dicetak labelnya.</p>
                </div>
            @endif
        </div>
    </div>
    
    <style>
        @media print {
            body * { visibility: hidden; }
            .print\:block, .print\:block * { visibility: visible; }
            .print\:hidden { display: none !important; }
            .print\:w-full { width: 100% !important; }
            header, aside, footer { display: none !important; }
            .bg-slate-50 { background: white !important; }
        }
    </style>
</div>
