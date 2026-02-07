<div class="animate-in fade-in zoom-in duration-500 pb-20">
    
    @if(!$tampilkanDetail)
        <!-- LIST VIEW -->
        <div class="space-y-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Negosiasi <span class="text-amber-500">B2B</span></h1>
                    <p class="text-slate-500 font-medium">Pusat pemrosesan Permintaan Penawaran (RFQ) dari pelanggan korporat.</p>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="bg-white p-6 rounded-[35px] border border-slate-100 shadow-sm flex flex-col md:flex-row gap-6 justify-between items-center">
                <div class="flex gap-4 w-full md:w-auto flex-1">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari ID RFQ atau Nama Pelanggan..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-amber-500/10 transition-all">
                    </div>
                    <select wire:model.live="filterStatus" class="bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-600 focus:ring-4 focus:ring-amber-500/10 cursor-pointer w-48">
                        <option value="semua">SEMUA STATUS</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="dibalas">Dibalas</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-[45px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">ID & Tanggal</th>
                                <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelanggan</th>
                                <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Nilai Pengajuan</th>
                                <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                                <th class="px-8 py-6 text-right">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($daftar_penawaran as $rfq)
                            <tr class="group hover:bg-slate-50 transition-all">
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <span class="block font-black text-slate-800 text-sm font-mono tracking-tighter text-indigo-600">#RFQ-{{ str_pad($rfq->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">{{ $rfq->dibuat_pada->translatedFormat('d M Y') }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-xs font-black text-slate-400">
                                            {{ substr($rfq->pengguna->nama ?? 'T', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 leading-tight">{{ $rfq->pengguna->nama ?? 'Tamu' }}</p>
                                            <p class="text-[10px] text-indigo-500 font-bold uppercase">{{ $rfq->pengguna->level_member ?? 'Classic' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <span class="font-black text-slate-900 text-sm">Rp {{ number_format($rfq->total_pengajuan, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $statusColor = match($rfq->status) {
                                            'menunggu' => 'bg-amber-100 text-amber-700',
                                            'dibalas' => 'bg-blue-100 text-blue-700',
                                            'disetujui' => 'bg-emerald-100 text-emerald-700',
                                            'ditolak' => 'bg-rose-100 text-rose-700',
                                            default => 'bg-slate-100 text-slate-600'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $statusColor }}">
                                        {{ $rfq->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <button wire:click="lihatDetail({{ $rfq->id }})" class="px-6 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all shadow-sm">RESPON</button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">Tidak ada permintaan penawaran saat ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-8 border-t border-slate-50">{{ $daftar_penawaran->links() }}</div>
            </div>
        </div>
    @else
        <!-- DETAIL VIEW -->
        <div class="animate-in slide-in-from-right-8 duration-500">
            <!-- Header Detail -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50 mb-8 sticky top-24 z-30">
                <div class="flex items-center gap-6">
                    <button wire:click="batal" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                    </button>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">RESPON RFQ <span class="text-indigo-600 font-mono">#{{ str_pad($penawaranTerpilih->id, 5, '0', STR_PAD_LEFT) }}</span></h1>
                        <p class="text-slate-500 font-medium uppercase tracking-widest text-[10px]">Analisis & Penyesuaian Harga B2B</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-3xl text-sm font-black hover:bg-slate-100 transition-all">BATAL</button>
                    @if($penawaranTerpilih->status == 'menunggu')
                    <button wire:click="kirimPenawaran" class="px-10 py-4 bg-amber-500 hover:bg-amber-600 text-white rounded-3xl text-sm font-black shadow-xl shadow-amber-500/20 transition-all active:scale-95 flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> KIRIM TAWARAN
                    </button>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <!-- Data Pelanggan -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 text-center">
                        <div class="w-24 h-24 rounded-full bg-indigo-50 flex items-center justify-center text-3xl font-black text-indigo-600 mx-auto mb-6 border-4 border-white shadow-xl">
                            {{ substr($penawaranTerpilih->pengguna->nama ?? 'T', 0, 1) }}
                        </div>
                        <h3 class="text-xl font-black text-slate-900 leading-tight uppercase">{{ $penawaranTerpilih->pengguna->nama ?? 'Tamu' }}</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-2">{{ $penawaranTerpilih->pengguna->email ?? '-' }}</p>
                        
                        <div class="mt-8 pt-8 border-t border-slate-50 grid grid-cols-2 gap-4">
                            <div class="text-left">
                                <p class="text-[9px] font-black text-slate-300 uppercase">Status Member</p>
                                <p class="text-sm font-black text-indigo-600">{{ $penawaranTerpilih->pengguna->level_member ?? 'Classic' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] font-black text-slate-300 uppercase">Poin Loyalitas</p>
                                <p class="text-sm font-black text-slate-800">{{ number_format($penawaranTerpilih->pengguna->poin_loyalitas ?? 0) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-indigo-900 rounded-[40px] p-8 text-white relative overflow-hidden shadow-2xl">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl -mr-10 -mt-10"></div>
                        <h3 class="text-xs font-black uppercase tracking-widest text-indigo-300 mb-6">Pesan Pelanggan</h3>
                        <p class="text-sm leading-relaxed italic text-indigo-100 font-medium">"{{ $penawaranTerpilih->pesan_user ?? 'Tidak ada pesan khusus.' }}"</p>
                    </div>
                </div>

                <!-- Item Pricing Table -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[50px] border border-indigo-50 shadow-sm overflow-hidden">
                        <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/30">
                            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Penyesuaian Harga per Item</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/50">
                                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                        <th class="px-10 py-6">Unit Produk</th>
                                        <th class="px-6 py-6 text-center">Jumlah (Qty)</th>
                                        <th class="px-6 py-6">Harga Normal</th>
                                        <th class="px-10 py-6 w-64">Harga Penawaran</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($penawaranTerpilih->items as $item)
                                    <tr class="group hover:bg-slate-50 transition-all">
                                        <td class="px-10 py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-xl bg-white border border-slate-100 p-1 shrink-0 overflow-hidden">
                                                    <img src="{{ $item->produk->gambar_utama_url }}" class="w-full h-full object-contain">
                                                </div>
                                                <div>
                                                    <h4 class="font-black text-slate-800 text-sm leading-tight">{{ $item->produk->nama }}</h4>
                                                    <p class="text-[9px] font-mono text-slate-400 mt-1 uppercase">{{ $item->produk->kode_unit }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 text-center">
                                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-black">{{ $item->jumlah }} Unit</span>
                                        </td>
                                        <td class="px-6 py-6">
                                            <span class="text-xs font-bold text-slate-400 line-through">Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-10 py-6">
                                            <div class="relative">
                                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300">Rp</span>
                                                <input type="number" wire:model="hargaTawar.{{ $item->id }}" class="w-full pl-10 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-black text-emerald-600 focus:ring-4 focus:ring-emerald-500/10 transition-all" {{ $penawaranTerpilih->status != 'menunggu' ? 'readonly' : '' }}>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Admin Response -->
                    <div class="bg-white p-10 rounded-[50px] border border-indigo-50 shadow-sm space-y-6">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Balasan Resmi Admin</label>
                        <textarea wire:model="pesanAdmin" rows="6" class="w-full bg-slate-50 border-none rounded-[35px] px-8 py-6 text-sm font-medium text-slate-700 focus:ring-4 focus:ring-amber-500/10 placeholder:text-slate-300 leading-relaxed resize-none transition-all" placeholder="Tulis rincian syarat, bonus, atau alasan pemberian harga khusus ini..." {{ $penawaranTerpilih->status != 'menunggu' ? 'readonly' : '' }}></textarea>
                        @error('pesanAdmin') <span class="text-rose-500 text-[10px] font-bold px-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
