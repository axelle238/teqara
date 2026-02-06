<div class="space-y-12 pb-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-50 border border-amber-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-amber-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em]">After Sales Service</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">GARANSI <span class="text-amber-600">(RMA)</span></h1>
            <p class="text-slate-500 font-medium text-lg">Pusat penanganan retur, servis, dan klaim garansi unit pelanggan.</p>
        </div>
        <button wire:click="buatKlaimBaru" class="px-8 py-4 bg-amber-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-amber-700 transition-all shadow-xl shadow-amber-500/20 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Tiket RMA
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 flex justify-between items-center">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Menunggu Unit</p>
                <h3 class="text-3xl font-black text-slate-900">{{ $stats['menunggu'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">📦</div>
        </div>
        <div class="bg-indigo-50 p-8 rounded-[40px] border border-indigo-100 flex justify-between items-center">
            <div>
                <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-2">Sedang Diproses</p>
                <h3 class="text-3xl font-black text-indigo-700">{{ $stats['proses'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-600">⚙️</div>
        </div>
        <div class="bg-emerald-50 p-8 rounded-[40px] border border-emerald-100 flex justify-between items-center">
            <div>
                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2">Kasus Selesai</p>
                <h3 class="text-3xl font-black text-emerald-700">{{ $stats['selesai'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600">✅</div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
        <div class="p-8 border-b border-indigo-50 bg-slate-50/30 flex justify-between items-center">
            <div class="relative w-72">
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Kode RMA..." class="w-full pl-12 pr-4 py-3 bg-white border-none rounded-2xl text-sm font-bold shadow-sm focus:ring-4 focus:ring-amber-500/10">
                <svg class="w-5 h-5 absolute left-4 top-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            
            <div class="flex gap-2">
                <button wire:click="$set('filterStatus', 'all')" class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $filterStatus === 'all' ? 'bg-slate-900 text-white' : 'bg-white text-slate-500 hover:bg-slate-50' }}">Semua</button>
                <button wire:click="$set('filterStatus', 'proses_servis')" class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $filterStatus === 'proses_servis' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-500 hover:bg-indigo-50' }}">Servis</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Tiket RMA</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Unit Perangkat</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Jenis Klaim</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Status</th>
                        <th class="px-10 py-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($daftarKlaim as $k)
                    <tr class="group hover:bg-amber-50/10 transition-all">
                        <td class="px-10 py-6">
                            <p class="text-sm font-black text-slate-900 font-mono">{{ $k->kode_klaim }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $k->tgl_masuk->format('d M Y') }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-xs font-bold text-slate-700 uppercase">{{ $k->seri->produk->nama ?? 'Unknown' }}</p>
                            <p class="text-[9px] font-mono text-slate-400 uppercase tracking-widest mt-0.5">SN: {{ $k->seri->nomor_seri ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <span class="text-xs font-black text-slate-600 uppercase">{{ str_replace('_', ' ', $k->jenis_klaim) }}</span>
                        </td>
                        <td class="px-6 py-6">
                            @php
                                $statusColor = match($k->status) {
                                    'selesai' => 'emerald',
                                    'ditolak' => 'rose',
                                    'menunggu_unit' => 'slate',
                                    default => 'indigo'
                                };
                            @endphp
                            <span class="px-3 py-1 bg-{{ $statusColor }}-50 text-{{ $statusColor }}-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-{{ $statusColor }}-100">
                                {{ str_replace('_', ' ', $k->status) }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <button wire:click="prosesKlaim({{ $k->id }})" class="px-6 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                                Proses
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-10 py-20 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">Tidak ada klaim aktif.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Panel Buat Baru -->
    <x-ui.panel-geser id="form-klaim" judul="BUAT TIKET RMA BARU">
        <form wire:submit.prevent="simpanKlaim" class="space-y-8 p-2">
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Identitas Unit (Serial Number)</label>
                <div class="relative">
                    <input wire:model.live.debounce.500ms="inputSeri" type="text" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-amber-500/10 uppercase" placeholder="Scan atau ketik SN...">
                    
                    @if($hasilPencarianSeri)
                    <div class="absolute top-full left-0 w-full mt-2 bg-emerald-50 border border-emerald-100 p-4 rounded-2xl z-10 flex items-center gap-4">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold">✓</div>
                        <div>
                            <p class="text-xs font-black text-emerald-800 uppercase">{{ $hasilPencarianSeri->produk->nama }}</p>
                            <p class="text-[10px] text-emerald-600 font-bold">Garansi Aktif</p>
                        </div>
                    </div>
                    @elseif(strlen($inputSeri) > 3)
                    <div class="absolute top-full left-0 w-full mt-2 bg-rose-50 border border-rose-100 p-4 rounded-2xl z-10">
                        <p class="text-xs font-bold text-rose-600">Unit tidak ditemukan dalam database.</p>
                    </div>
                    @endif
                </div>
                @error('inputSeri') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Jenis Tindakan</label>
                <select wire:model="jenis_klaim" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-amber-500/10">
                    <option value="perbaikan">Servis / Perbaikan</option>
                    <option value="tukar_unit">Tukar Unit Baru (Replacement)</option>
                    <option value="refund">Pengembalian Dana</option>
                    <option value="pengecekan">Cek Kerusakan</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Keluhan Pelanggan</label>
                <textarea wire:model="keluhan" rows="4" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium text-slate-900 focus:ring-4 focus:ring-amber-500/10" placeholder="Deskripsikan masalah unit..."></textarea>
                @error('keluhan') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-amber-600 transition-all shadow-xl shadow-amber-500/20">
                    BUKA TIKET
                </button>
            </div>
        </form>
    </x-ui.panel-geser>

    <!-- Panel Proses Klaim -->
    <x-ui.panel-geser id="proses-klaim" judul="PROSES TIKET RMA">
        <form wire:submit.prevent="updateStatusKlaim" class="space-y-8 p-2">
            <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Unit dalam Penanganan</p>
                <p class="text-lg font-black text-slate-900 font-mono">{{ $inputSeri }}</p>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Status Pengerjaan</label>
                <select wire:model="status_proses" class="w-full bg-white border-2 border-slate-100 rounded-2xl p-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10">
                    <option value="menunggu_unit">Menunggu Unit Fisik</option>
                    <option value="cek_fisik">Pengecekan Teknisi</option>
                    <option value="proses_servis">Dalam Pengerjaan</option>
                    <option value="siap_ambil">Selesai (Siap Ambil)</option>
                    <option value="selesai">Selesai (Ditutup)</option>
                    <option value="ditolak">Ditolak (Void)</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Catatan Teknisi</label>
                <textarea wire:model="catatan_teknisi" rows="3" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium text-slate-900" placeholder="Hasil diagnosa..."></textarea>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Solusi Akhir</label>
                <textarea wire:model="solusi" rows="3" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium text-slate-900" placeholder="Tindakan yang diambil..."></textarea>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all shadow-xl">
                    UPDATE STATUS
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>
