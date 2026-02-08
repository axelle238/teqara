<div class="animate-in fade-in duration-500 pb-20">
    
    @if(!$tampilkanForm)
        <!-- TAMPILAN 1: Dasbor MONITORING STOK (FULL PAGE LIST) -->
        <div class="space-y-8">
            <div class="flex flex-col md:flex-row justify-between items-start sm:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="space-y-1">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Pusat Kendali Stok</h1>
                    <p class="text-slate-500 font-medium">Audit real-time inventaris fisik dan valuasi aset gudang.</p>
                </div>
                <div class="flex gap-4">
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Valuasi Aset</p>
                        <p class="text-xl font-black text-emerald-600">Rp {{ number_format($this->analitik['valuasi'], 0, ',', '.') }}</p>
                    </div>
                    <div class="w-px bg-slate-200"></div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Unit Fisik</p>
                        <p class="text-xl font-black text-indigo-600">{{ number_format($this->analitik['total_unit']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Health Status Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <button wire:click="$set('filterKesehatan', 'kritis')" class="p-6 rounded-[30px] border-2 transition-all text-left {{ $filterKesehatan === 'kritis' ? 'bg-rose-50 border-rose-500 shadow-lg' : 'bg-white border-slate-50 hover:border-rose-200' }}">
                    <p class="text-[10px] font-black uppercase tracking-widest text-rose-600 mb-1">Stok Kritis (≤5)</p>
                    <h3 class="text-3xl font-black text-rose-700">{{ $this->analitik['kritis'] }}</h3>
                </button>
                <button wire:click="$set('filterKesehatan', 'habis')" class="p-6 rounded-[30px] border-2 transition-all text-left {{ $filterKesehatan === 'habis' ? 'bg-slate-100 border-slate-500 shadow-lg' : 'bg-white border-slate-50 hover:border-slate-300' }}">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Stok Habis (0)</p>
                    <h3 class="text-3xl font-black text-slate-700">{{ $this->analitik['habis'] }}</h3>
                </button>
                <button wire:click="$set('filterKesehatan', 'aman')" class="p-6 rounded-[30px] border-2 transition-all text-left {{ $filterKesehatan === 'aman' ? 'bg-emerald-50 border-emerald-500 shadow-lg' : 'bg-white border-slate-50 hover:border-emerald-200' }}">
                    <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600 mb-1">Stok Sehat</p>
                    <h3 class="text-3xl font-black text-emerald-700">{{ $this->analitik['aman'] }}</h3>
                </button>
                <button wire:click="$set('filterKesehatan', 'berlebih')" class="p-6 rounded-[30px] border-2 transition-all text-left {{ $filterKesehatan === 'berlebih' ? 'bg-amber-50 border-amber-500 shadow-lg' : 'bg-white border-slate-50 hover:border-amber-200' }}">
                    <p class="text-[10px] font-black uppercase tracking-widest text-amber-600 mb-1">Overstock (>50)</p>
                    <h3 class="text-3xl font-black text-amber-700">{{ $this->analitik['berlebih'] }}</h3>
                </button>
            </div>

            <!-- Main Content Tabs -->
            <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden min-h-[500px]">
                <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                    <div class="flex gap-2 bg-slate-50 p-1 rounded-2xl">
                        <button wire:click="$set('tabAktif', 'posisi')" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $tabAktif === 'posisi' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-400 hover:text-slate-600' }}">Posisi Stok</button>
                        <button wire:click="$set('tabAktif', 'mutasi')" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $tabAktif === 'mutasi' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-400 hover:text-slate-600' }}">Jurnal Mutasi</button>
                    </div>
                    
                    @if($tabAktif === 'posisi')
                    <div class="relative w-64">
                        <i class="fa-solid fa-search absolute left-4 top-3 text-slate-300 text-xs"></i>
                        <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari SKU / Produk..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border-none rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500">
                    </div>
                    @endif
                </div>

                <div class="p-0">
                    @if($tabAktif === 'posisi')
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/50">
                                    <tr>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas Produk</th>
                                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">SKU & Kategori</th>
                                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Fisik Gudang</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi Cepat</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($stokGlobal as $p)
                                    <tr class="group hover:bg-slate-50 transition-all">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center shrink-0 overflow-hidden border border-slate-200">
                                                    @if($p->gambar_utama)
                                                        <img src="{{ asset($p->gambar_utama) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <i class="fa-solid fa-box text-slate-300"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-black text-slate-800">{{ $p->nama }}</h4>
                                                    <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $p->merek->nama ?? 'Tanpa Merek' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="block text-xs font-mono font-bold text-indigo-600">{{ $p->kode_unit }}</span>
                                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide">{{ $p->kategori->nama ?? '-' }}</span>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="px-4 py-1.5 rounded-lg text-sm font-black {{ $p->stok <= 5 ? 'bg-rose-100 text-rose-600' : 'bg-emerald-100 text-emerald-600' }}">
                                                {{ $p->stok }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button wire:click="bukaMutasi({{ $p->id }}, 'penerimaan')" class="px-3 py-2 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-emerald-100 transition-colors">
                                                    + Masuk
                                                </button>
                                                <button wire:click="bukaMutasi({{ $p->id }}, 'penyesuaian')" class="px-3 py-2 bg-amber-50 text-amber-600 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-amber-100 transition-colors">
                                                    Sesuaikan
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">Data inventaris tidak ditemukan.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-6 border-t border-slate-50">{{ $stokGlobal->links() }}</div>
                    
                    @elseif($tabAktif === 'mutasi')
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/50">
                                    <tr>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu</th>
                                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Produk</th>
                                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jenis Mutasi</th>
                                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Volume</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($jurnalMutasi as $m)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-8 py-5 whitespace-nowrap">
                                            <p class="text-xs font-bold text-slate-700">{{ $m->waktu->format('d M Y') }}</p>
                                            <p class="text-[10px] font-mono text-slate-400">{{ $m->waktu->format('H:i') }}</p>
                                        </td>
                                        <td class="px-6 py-5">
                                            <p class="text-xs font-bold text-slate-800">{{ $m->produk->nama }}</p>
                                            <p class="text-[10px] font-mono text-indigo-500">{{ $m->produk->kode_unit }}</p>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="inline-block px-2 py-1 rounded text-[10px] font-black uppercase tracking-widest border {{ $m->jumlah > 0 ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-rose-50 text-rose-600 border-rose-100' }}">
                                                {{ str_replace('_', ' ', $m->jenis_mutasi) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="text-sm font-black {{ $m->jumlah > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                                {{ $m->jumlah > 0 ? '+' : '' }}{{ $m->jumlah }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5">
                                            <p class="text-xs text-slate-500 italic truncate max-w-xs">{{ $m->keterangan }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase">Oleh: {{ $m->pengguna->nama ?? 'Sistem' }}</p>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">Belum ada catatan mutasi.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-6 border-t border-slate-50">{{ $jurnalMutasi->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- TAMPILAN 2: FORMULIR MUTASI STOK (FULL PAGE FORM) -->
        <div class="space-y-8 animate-in slide-in-from-right-8 duration-500">
            <!-- Header Editor -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="flex items-center gap-6">
                    <button wire:click="batal" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                    </button>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">
                            {{ $jenisAksi === 'penerimaan' ? 'Penerimaan Barang Masuk' : ($jenisAksi === 'transfer' ? 'Transfer Antar Gudang' : 'Penyesuaian Stok Manual') }}
                        </h1>
                        <p class="text-slate-500 font-medium text-sm">Dokumentasikan perubahan fisik inventaris untuk akurasi data.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-3xl text-sm font-black hover:bg-slate-100 transition-all">BATAL</button>
                    <button wire:click="eksekusiMutasi" class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-indigo-600/20 transition-all active:scale-95">KONFIRMASI MUTASI</button>
                </div>
            </div>

            <!-- Form Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Data Mutasi -->
                <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
                    <div class="bg-indigo-50 p-6 rounded-[30px] flex items-center gap-4">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm text-indigo-600 text-2xl">
                            <i class="fa-solid fa-box"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">Target Unit</p>
                            <h3 class="text-xl font-black text-indigo-900">{{ \App\Models\Produk::find($produkTerpilihId)->nama ?? 'Produk Tidak Ditemukan' }}</h3>
                            <p class="text-xs font-bold text-indigo-600 opacity-70 mt-1">Stok Saat Ini: {{ \App\Models\Produk::find($produkTerpilihId)->stok ?? 0 }} Unit</p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Volume Mutasi</label>
                        <div class="flex items-center gap-4">
                            <button type="button" @click="$wire.jumlahMutasi > 1 ? $wire.jumlahMutasi-- : 1" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-500 hover:bg-rose-100 hover:text-rose-600 flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-minus text-lg"></i>
                            </button>
                            <input wire:model="jumlahMutasi" type="number" class="flex-1 bg-slate-50 border-none rounded-3xl py-4 text-center text-2xl font-black text-slate-800 focus:ring-0">
                            <button type="button" @click="$wire.jumlahMutasi++" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-500 hover:bg-emerald-100 hover:text-emerald-600 flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-plus text-lg"></i>
                            </button>
                        </div>
                        @error('jumlahMutasi') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                    </div>

                    @if($jenisAksi === 'transfer')
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-50">
                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Dari Gudang</label>
                            <select wire:model="dariGudangId" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 text-sm font-bold text-slate-700">
                                <option value="">Pilih Asal</option>
                                @foreach($daftarGudang as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Ke Gudang</label>
                            <select wire:model="keGudangId" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 text-sm font-bold text-slate-700">
                                <option value="">Pilih Tujuan</option>
                                @foreach($daftarGudang as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="space-y-2 pt-4 border-t border-slate-50">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Memo / Keterangan</label>
                        <textarea wire:model="keteranganMutasi" rows="3" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-4 text-sm font-bold text-slate-600 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300" placeholder="Jelaskan alasan perubahan stok ini..."></textarea>
                        @error('keteranganMutasi') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest block mt-2">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Info Panduan -->
                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-10 rounded-[50px] text-white shadow-2xl relative overflow-hidden group">
                        <i class="fa-solid fa-clipboard-check text-6xl opacity-10 absolute -right-6 -bottom-6 group-hover:scale-150 transition-transform duration-1000"></i>
                        <h4 class="text-xl font-black uppercase tracking-tight mb-4">Protokol Gudang</h4>
                        <ul class="space-y-4 text-sm font-medium text-slate-300">
                            <li class="flex gap-3">
                                <i class="fa-solid fa-circle-check text-emerald-400 mt-1"></i>
                                <span>Pastikan fisik barang telah dihitung ganda sebelum input.</span>
                            </li>
                            <li class="flex gap-3">
                                <i class="fa-solid fa-circle-check text-emerald-400 mt-1"></i>
                                <span>Mutasi masuk otomatis mempengaruhi Nilai Aset perusahaan.</span>
                            </li>
                            <li class="flex gap-3">
                                <i class="fa-solid fa-circle-check text-emerald-400 mt-1"></i>
                                <span>Seluruh aktivitas tercatat permanen di Jurnal Audit.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
