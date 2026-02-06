<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header & Stats -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Sirkulasi Pesanan</h1>
            <p class="text-slate-500 text-sm mt-1">Pusat kendali transaksi dan pemenuhan order pelanggan.</p>
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition-colors">
                <i class="fa-solid fa-file-export mr-2"></i> Ekspor Laporan
            </button>
        </div>
    </div>

    <!-- Smart Tabs Filters -->
    <div class="border-b border-slate-200 overflow-x-auto">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            @php
                $tabs = [
                    'semua' => ['label' => 'Semua Order', 'icon' => 'fa-list'],
                    'menunggu' => ['label' => 'Perlu Verifikasi', 'icon' => 'fa-clock'],
                    'diproses' => ['label' => 'Sedang Dikemas', 'icon' => 'fa-box-open'],
                    'dikirim' => ['label' => 'Dalam Pengiriman', 'icon' => 'fa-truck-fast'],
                    'selesai' => ['label' => 'Selesai', 'icon' => 'fa-check-circle'],
                    'batal' => ['label' => 'Dibatalkan', 'icon' => 'fa-ban'],
                ];
            @endphp

            @foreach($tabs as $key => $tab)
                <button 
                    wire:click="$set('status_pesanan', '{{ $key }}')"
                    class="{{ $status_pesanan === $key ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} 
                           whitespace-nowrap border-b-2 py-4 px-1 text-sm font-bold flex items-center gap-2 transition-colors"
                >
                    <i class="fa-solid {{ $tab['icon'] }}"></i>
                    {{ $tab['label'] }}
                    <span class="ml-2 py-0.5 px-2.5 rounded-full text-xs {{ $status_pesanan === $key ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-600' }}">
                        {{ $stats[$key] }}
                    </span>
                </button>
            @endforeach
        </nav>
    </div>

    <!-- Advanced Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <!-- Search -->
        <div class="relative flex-1 w-full md:max-w-md">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari No. Faktur, Nama Pelanggan..." class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all">
        </div>

        <!-- Filter Pembayaran -->
        <select wire:model.live="status_pembayaran" class="bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-600 py-2.5 px-4 focus:ring-2 focus:ring-indigo-500 cursor-pointer">
            <option value="">Semua Status Bayar</option>
            <option value="lunas">Lunas</option>
            <option value="belum_dibayar">Belum Dibayar</option>
            <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
        </select>

        <!-- Bulk Actions -->
        @if(count($selectedPesanan) > 0)
        <div class="flex items-center gap-2 animate-in fade-in zoom-in duration-200">
            <span class="text-xs font-bold text-slate-500">{{ count($selectedPesanan) }} terpilih</span>
            <button wire:click="bulkProcess" wire:confirm="Proses pesanan terpilih ke tahap pengemasan?" class="px-3 py-2 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold hover:bg-indigo-200 transition-colors">
                <i class="fa-solid fa-boxes-packing mr-1"></i> Proses Masal
            </button>
        </div>
        @endif
    </div>

    <!-- Enterprise Order Table -->
    <div class="bg-white border border-slate-100 rounded-[24px] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-black tracking-wider">
                    <tr>
                        <th class="px-6 py-4 w-10 text-center">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                        </th>
                        <th class="px-6 py-4">Faktur & Waktu</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Total & Item</th>
                        <th class="px-6 py-4 text-center">Pembayaran</th>
                        <th class="px-6 py-4 text-center">Status Order</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pesanan as $p)
                    <tr class="hover:bg-indigo-50/30 transition-colors group">
                        <td class="px-6 py-4 text-center">
                            <input type="checkbox" wire:model.live="selectedPesanan" value="{{ $p->id }}" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <a href="{{ route('admin.pesanan.detail', $p->id) }}" wire:navigate class="text-sm font-bold text-indigo-600 hover:text-indigo-800 font-mono">
                                    {{ $p->nomor_faktur }}
                                </a>
                                <span class="text-[10px] text-slate-400 font-medium mt-1">
                                    {{ $p->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 uppercase">
                                    {{ substr($p->pengguna->nama ?? 'Guest', 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 text-xs">{{ $p->pengguna->nama ?? 'Guest' }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $p->pengguna->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-black text-slate-900">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">{{ $p->detailPesanan->sum('jumlah') }} Barang</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $bayarClass = match($p->status_pembayaran) {
                                    'lunas' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    'menunggu_verifikasi' => 'bg-amber-100 text-amber-700 border-amber-200 animate-pulse',
                                    'gagal' => 'bg-rose-100 text-rose-700 border-rose-200',
                                    default => 'bg-slate-100 text-slate-600 border-slate-200'
                                };
                                $bayarLabel = match($p->status_pembayaran) {
                                    'lunas' => 'Lunas',
                                    'menunggu_verifikasi' => 'Cek Bukti',
                                    'gagal' => 'Gagal',
                                    default => 'Belum Bayar'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $bayarClass }}">
                                {{ $bayarLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClass = match($p->status_pesanan) {
                                    'menunggu' => 'bg-slate-100 text-slate-600',
                                    'diproses' => 'bg-indigo-100 text-indigo-700',
                                    'dikirim' => 'bg-cyan-100 text-cyan-700',
                                    'selesai' => 'bg-emerald-100 text-emerald-700',
                                    'batal' => 'bg-rose-50 text-rose-400 line-through',
                                    default => 'bg-slate-100 text-slate-600'
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold {{ $statusClass }}">
                                @if($p->status_pesanan == 'diproses') <i class="fa-solid fa-circle-notch fa-spin text-[10px]"></i> @endif
                                {{ ucfirst($p->status_pesanan) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.pesanan.detail', $p->id) }}" wire:navigate class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-600 hover:shadow-md transition-all" title="Kelola Pesanan">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-clipboard-list text-4xl mb-4 text-slate-200"></i>
                                <p class="font-medium">Tidak ada pesanan ditemukan pada filter ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $pesanan->links() }}
        </div>
    </div>
</div>