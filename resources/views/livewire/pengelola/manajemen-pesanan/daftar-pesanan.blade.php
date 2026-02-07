<div class="animate-in fade-in duration-500 pb-20">
    
    <!-- Header Stats -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        @php
            $stats = [
                ['label' => 'Semua Order', 'val' => $this->statistik['total'], 'color' => 'slate', 'icon' => 'fa-list'],
                ['label' => 'Menunggu', 'val' => $this->statistik['menunggu'], 'color' => 'amber', 'icon' => 'fa-clock'],
                ['label' => 'Diproses', 'val' => $this->statistik['diproses'], 'color' => 'indigo', 'icon' => 'fa-boxes-packing'],
                ['label' => 'Dikirim', 'val' => $this->statistik['dikirim'], 'color' => 'blue', 'icon' => 'fa-truck-fast'],
                ['label' => 'Selesai', 'val' => $this->statistik['selesai'], 'color' => 'emerald', 'icon' => 'fa-check-circle'],
            ];
        @endphp

        @foreach($stats as $s)
        <button wire:click="setStatus('{{ strtolower(str_replace(' ', '', $s['label'] == 'Semua Order' ? 'semua' : $s['label'])) }}')" 
                class="relative bg-white p-6 rounded-[30px] border border-slate-100 shadow-sm hover:shadow-lg transition-all text-left group overflow-hidden {{ $filterStatus == strtolower(str_replace(' ', '', $s['label'] == 'Semua Order' ? 'semua' : $s['label'])) ? 'ring-2 ring-'.$s['color'].'-500 bg-'.$s['color'].'-50' : '' }}">
            <div class="relative z-10">
                <i class="fa-solid {{ $s['icon'] }} text-2xl text-{{ $s['color'] }}-500 mb-3 group-hover:scale-110 transition-transform"></i>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $s['label'] }}</p>
                <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $s['val'] }}</h3>
            </div>
            <!-- Decor -->
            <div class="absolute -right-4 -bottom-4 text-8xl text-slate-50 opacity-50 group-hover:opacity-100 transition-opacity">
                <i class="fa-solid {{ $s['icon'] }}"></i>
            </div>
        </button>
        @endforeach
    </div>

    <!-- Toolbar -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8 bg-white p-4 rounded-[30px] shadow-sm border border-slate-100">
        <div class="relative w-full md:w-96">
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Invoice atau Pelanggan..." class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
        </div>
        
        <div class="flex gap-2">
            <button class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-50">
                <i class="fa-solid fa-filter mr-2"></i> Filter
            </button>
            <button class="px-6 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-500/20">
                <i class="fa-solid fa-file-export mr-2"></i> Ekspor
            </button>
        </div>
    </div>

    <!-- Order List -->
    <div class="space-y-6">
        @forelse($pesanan as $p)
        <div class="bg-white rounded-[40px] p-2 shadow-sm border border-slate-100 hover:shadow-xl hover:border-indigo-100 transition-all duration-300 group">
            <div class="flex flex-col lg:flex-row gap-6 p-6">
                <!-- Info Utama -->
                <div class="flex-1 space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-black tracking-widest font-mono">
                            #{{ $p->nomor_faktur }}
                        </div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">
                            {{ $p->dibuat_pada->format('d M Y • H:i') }}
                        </span>
                        
                        @php
                            $badgeColor = match($p->status_pesanan) {
                                'menunggu' => 'amber',
                                'diproses' => 'indigo',
                                'dikirim' => 'blue',
                                'selesai' => 'emerald',
                                'dibatalkan' => 'rose',
                                default => 'slate'
                            };
                        @endphp
                        <span class="px-3 py-1 bg-{{ $badgeColor }}-100 text-{{ $badgeColor }}-700 rounded-lg text-[10px] font-black uppercase tracking-widest border border-{{ $badgeColor }}-200">
                            {{ $p->status_pesanan }}
                        </span>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500">
                            {{ substr($p->pengguna->nama, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-black text-slate-900 text-lg">{{ $p->pengguna->nama }}</h4>
                            <p class="text-xs text-slate-500 font-medium">{{ $p->alamat_pengiriman }}</p>
                        </div>
                    </div>

                    <!-- Item Preview -->
                    <div class="flex items-center gap-2 mt-4 overflow-x-auto pb-2 scrollbar-hide">
                        @foreach($p->detailPesanan->take(4) as $item)
                        <div class="w-16 h-16 rounded-xl bg-slate-50 border border-slate-100 p-2 flex-shrink-0" title="{{ $item->produk->nama }}">
                            <img src="{{ $item->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply">
                        </div>
                        @endforeach
                        @if($p->detailPesanan->count() > 4)
                        <div class="w-16 h-16 rounded-xl bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500">
                            +{{ $p->detailPesanan->count() - 4 }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Finansial & Aksi -->
                <div class="lg:w-80 flex flex-col justify-between border-l border-slate-100 pl-0 lg:pl-8 pt-6 lg:pt-0">
                    <div class="text-right mb-6">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Transaksi</p>
                        <h3 class="text-2xl font-black text-indigo-600 tracking-tighter">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</h3>
                        <p class="text-xs font-bold text-slate-500 mt-1 uppercase">{{ $p->metode_pembayaran }}</p>
                    </div>

                    <!-- Action Panel (Dynamic based on Status) -->
                    <div class="bg-slate-50 rounded-2xl p-4 space-y-3">
                        @if($p->status_pesanan == 'menunggu')
                            <button wire:click="prosesPesanan({{ $p->id }})" class="w-full py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20">
                                Proses Pesanan
                            </button>
                            <button wire:click="batalkanPesanan({{ $p->id }})" wire:confirm="Yakin batalkan pesanan ini?" class="w-full py-3 bg-white border border-rose-200 text-rose-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-rose-50 transition-all">
                                Batalkan
                            </button>
                        @elseif($p->status_pesanan == 'diproses')
                            <div class="flex gap-2">
                                <input wire:model="inputResi.{{ $p->id }}" type="text" placeholder="Input No. Resi" class="flex-1 bg-white border-none rounded-xl text-xs font-bold shadow-sm focus:ring-2 focus:ring-indigo-500">
                                <button wire:click="kirimPesanan({{ $p->id }})" class="px-4 bg-indigo-600 text-white rounded-xl text-xs hover:bg-indigo-700">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
                        @elseif($p->status_pesanan == 'dikirim')
                            <div class="text-center py-2 bg-white rounded-xl border border-dashed border-indigo-200">
                                <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Resi Pengiriman</p>
                                <p class="text-sm font-black text-slate-800 font-mono select-all">{{ $p->resi_pengiriman }}</p>
                            </div>
                        @endif
                        
                        <a href="{{ route('pengelola.pesanan.detail', $p->id) }}" class="block w-full py-3 text-center text-slate-500 text-xs font-black uppercase tracking-widest hover:text-indigo-600 hover:underline">
                            Lihat Detail Lengkap
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="py-20 text-center bg-white rounded-[40px] border border-dashed border-slate-200">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl text-slate-300">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>
            <h3 class="text-xl font-black text-slate-900 uppercase">Belum Ada Pesanan</h3>
            <p class="text-slate-500 font-medium text-sm mt-2">Filter saat ini tidak menampilkan hasil apapun.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $pesanan->links() }}
    </div>
</div>
