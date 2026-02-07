<div class="space-y-12 pb-32 animate-in fade-in duration-500">
    
    @if(!$tampilkanForm)
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
        <button wire:click="buatKlaimBaru" class="px-8 py-4 bg-amber-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-amber-700 transition-all shadow-xl shadow-amber-500/20 flex items-center gap-3 active:scale-95">
            <i class="fa-solid fa-file-medical"></i> Buat Tiket RMA
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 flex justify-between items-center group hover:shadow-lg transition-all">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Menunggu Unit</p>
                <h3 class="text-3xl font-black text-slate-900">{{ $stats['menunggu'] }}</h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 text-2xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-box-open"></i>
            </div>
        </div>
        <div class="bg-indigo-50 p-8 rounded-[40px] border border-indigo-100 flex justify-between items-center group hover:shadow-lg transition-all">
            <div>
                <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-2">Sedang Diproses</p>
                <h3 class="text-3xl font-black text-indigo-700">{{ $stats['proses'] }}</h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-600 text-2xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-screwdriver-wrench"></i>
            </div>
        </div>
        <div class="bg-emerald-50 p-8 rounded-[40px] border border-emerald-100 flex justify-between items-center group hover:shadow-lg transition-all">
            <div>
                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2">Kasus Selesai</p>
                <h3 class="text-3xl font-black text-emerald-700">{{ $stats['selesai'] }}</h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600 text-2xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
        <div class="p-8 border-b border-indigo-50 bg-slate-50/30 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="relative w-full md:w-96">
                <i class="fa-solid fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Kode RMA..." class="w-full pl-12 pr-4 py-4 bg-white border-none rounded-2xl text-sm font-bold shadow-sm focus:ring-4 focus:ring-amber-500/10">
            </div>
            
            <div class="flex gap-2 bg-white p-1 rounded-2xl shadow-sm border border-slate-100">
                <button wire:click="$set('filterStatus', 'all')" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterStatus === 'all' ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">Semua</button>
                <button wire:click="$set('filterStatus', 'proses_servis')" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterStatus === 'proses_servis' ? 'bg-amber-600 text-white shadow-md' : 'text-slate-500 hover:bg-amber-50' }}">Servis</button>
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
                        <th class="px-10 py-6 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($daftarKlaim as $k)
                    <tr class="group hover:bg-amber-50/10 transition-all">
                        <td class="px-10 py-6">
                            <p class="text-sm font-black text-slate-900 font-mono tracking-tight">{{ $k->kode_klaim }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $k->tgl_masuk->translatedFormat('d M Y') }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-xs font-black text-slate-700 uppercase leading-tight">{{ $k->seri->produk->nama ?? 'Unit Terhapus' }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[9px] font-mono text-indigo-500 font-bold bg-indigo-50 px-1.5 py-0.5 rounded">SN: {{ $k->seri->nomor_seri ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest bg-slate-100 px-2 py-1 rounded-lg">{{ str_replace('_', ' ', $k->jenis_klaim) }}</span>
                        </td>
                        <td class="px-6 py-6">
                            @php
                                $statusColor = match($k->status) {
                                    'selesai' => 'emerald',
                                    'ditolak' => 'rose',
                                    'menunggu_unit' => 'slate',
                                    default => 'amber'
                                };
                            @endphp
                            <span class="px-3 py-1.5 bg-{{ $statusColor }}-50 text-{{ $statusColor }}-600 rounded-xl text-[9px] font-black uppercase tracking-widest border border-{{ $statusColor }}-100 flex items-center gap-2 w-fit">
                                <span class="w-1.5 h-1.5 rounded-full bg-{{ $statusColor }}-500 {{ $k->status !== 'selesai' ? 'animate-pulse' : '' }}"></span>
                                {{ str_replace('_', ' ', $k->status) }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <button wire:click="prosesKlaim({{ $k->id }})" class="px-6 py-2.5 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm">
                                ANALISIS
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-10 py-24 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">Tidak ada klaim aktif yang ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-slate-50 bg-slate-50/30">
            {{ $daftarKlaim->links() }}
        </div>
    </div>
    @else
    <!-- FULL PAGE EDITOR -->
    <div class="animate-in slide-in-from-right-8 duration-500">
        <!-- Header Editor -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50 mb-8 sticky top-24 z-30">
            <div class="flex items-center gap-6">
                <button wire:click="batal" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xl"></i>
                </button>
                <div class="space-y-1">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">
                        {{ $mode === 'buat' ? 'Buka Tiket RMA' : 'Pemrosesan Klaim' }}
                    </h1>
                    <p class="text-slate-500 font-medium uppercase tracking-widest text-[10px]">Layanan Purna Jual Teqara</p>
                </div>
            </div>
            <div class="flex gap-4">
                <button wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-3xl text-sm font-black hover:bg-slate-100 transition-all">BATAL</button>
                @if($mode === 'buat')
                    <button wire:click="simpanKlaim" class="px-10 py-4 bg-amber-600 hover:bg-amber-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-amber-600/20 transition-all active:scale-95 flex items-center gap-3">
                        <i class="fa-solid fa-file-medical"></i> TERBITKAN TIKET
                    </button>
                @else
                    <button wire:click="updateStatusKlaim" class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-indigo-600/20 transition-all active:scale-95 flex items-center gap-3">
                        <i class="fa-solid fa-save"></i> PERBARUI STATUS
                    </button>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @if($mode === 'buat')
                <!-- CREATE FORM -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Nomor Seri / IMEI</label>
                            <div class="relative">
                                <i class="fa-solid fa-barcode absolute left-5 top-1/2 -translate-y-1/2 text-amber-400"></i>
                                <input wire:model.live.debounce.500ms="inputSeri" type="text" class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-amber-500/10 placeholder:text-slate-300" placeholder="Scan atau ketik SN...">
                            </div>
                            @error('inputSeri') <span class="text-rose-500 text-[10px] font-bold px-1 block mt-2">{{ $message }}</span> @enderror
                        </div>

                        @if($hasilPencarianSeri)
                        <div class="bg-emerald-50 p-6 rounded-[35px] border border-emerald-100 animate-in zoom-in duration-300">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shadow-sm"><i class="fa-solid fa-check"></i></div>
                                <div>
                                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Unit Terdeteksi</p>
                                    <h4 class="font-black text-emerald-900 text-sm leading-tight">{{ $hasilPencarianSeri->produk->nama }}</h4>
                                    <p class="text-[9px] font-bold text-emerald-500 uppercase mt-1">Garansi Terverifikasi</p>
                                </div>
                            </div>
                        </div>
                        @elseif(strlen($inputSeri) > 3)
                        <div class="bg-rose-50 p-6 rounded-[35px] border border-rose-100">
                            <p class="text-xs font-bold text-rose-600 text-center">Data unit tidak ditemukan.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Kategori Klaim</label>
                                <select wire:model="jenis_klaim" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-amber-500/10 cursor-pointer">
                                    <option value="perbaikan">SERVIS / PERBAIKAN</option>
                                    <option value="tukar_unit">TUKAR UNIT BARU (REPLACEMENT)</option>
                                    <option value="refund">PENGEMBALIAN DANA (REFUND)</option>
                                    <option value="pengecekan">PENGECEKAN FUNGSIONAL</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Keluhan Utama Pelanggan</label>
                            <textarea wire:model="keluhan" rows="8" class="w-full bg-slate-50 border-none rounded-[35px] px-8 py-6 text-sm font-medium text-slate-700 focus:ring-4 focus:ring-amber-500/10 placeholder:text-slate-300 leading-relaxed resize-none" placeholder="Deskripsikan secara detail kendala yang dialami..."></textarea>
                            @error('keluhan') <span class="text-rose-500 text-[10px] font-bold px-1 block mt-2">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            @else
                <!-- PROCESS FORM -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-slate-900 p-10 rounded-[50px] text-white shadow-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl -mr-10 -mt-10"></div>
                        <h3 class="text-xs font-black text-indigo-300 uppercase tracking-[0.3em] mb-6 border-b border-white/10 pb-4">Unit dalam Penanganan</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase">Serial Number</p>
                                <p class="text-lg font-black font-mono tracking-wider">{{ $inputSeri }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase">Status Audit</p>
                                <p class="text-xs font-black text-emerald-400 uppercase tracking-widest">In Database</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Update Status Proses</label>
                            <select wire:model="status_proses" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-indigo-500/10 cursor-pointer">
                                <option value="menunggu_unit">MENUNGGU UNIT FISIK</option>
                                <option value="cek_fisik">PENGECEKAN TEKNISI</option>
                                <option value="proses_servis">DALAM PENGERJAAN</option>
                                <option value="siap_ambil">SIAP DIAMBIL / KIRIM</option>
                                <option value="selesai">KASUS SELESAI (DITUTUP)</option>
                                <option value="ditolak">KLAIM DITOLAK (VOID)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10">
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Diagnosa & Catatan Teknisi</label>
                            <textarea wire:model="catatan_teknisi" rows="5" class="w-full bg-slate-50 border-none rounded-3xl px-8 py-6 text-sm font-medium text-slate-700 focus:ring-4 focus:ring-indigo-500/10" placeholder="Input hasil pengecekan hardware/software..."></textarea>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Solusi & Tindakan Akhir</label>
                            <textarea wire:model="solusi" rows="5" class="w-full bg-slate-50 border-none rounded-3xl px-8 py-6 text-sm font-medium text-slate-700 focus:ring-4 focus:ring-indigo-500/10" placeholder="Tindakan final yang diambil..."></textarea>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif

</div>