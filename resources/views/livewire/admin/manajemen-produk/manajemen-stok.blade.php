<div class="space-y-12 pb-32">
    <!-- Header Command Center -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em]">Logistics Hub v2.0</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">AUDIT <span class="text-indigo-600">INVENTARIS</span></h1>
            <p class="text-slate-500 font-medium text-lg">Pusat kendali valuasi aset, manajemen mutasi, dan forecasting unit teknologi.</p>
        </div>
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <div class="bg-slate-900 p-6 rounded-[32px] text-white shadow-2xl relative overflow-hidden group min-w-[240px]">
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-1 relative z-10">Valuasi Aset Terikat</p>
                <p class="text-2xl font-black tracking-tighter relative z-10">Rp {{ number_format($this->analitik['valuasi'], 0, ',', '.') }}</p>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-indigo-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            </div>
        </div>
    </div>

    <!-- Analitik Kesehatan Stok (Interactive Cards) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $healthStats = [
                ['label' => 'Stok Sehat', 'val' => $this->analitik['aman'], 'color' => 'emerald', 'key' => 'aman', 'icon' => '🛡️'],
                ['label' => 'Kritis/Reorder', 'val' => $this->analitik['kritis'], 'color' => 'amber', 'key' => 'kritis', 'icon' => '⚠️'],
                ['label' => 'Out of Stock', 'val' => $this->analitik['habis'], 'color' => 'rose', 'key' => 'habis', 'icon' => '🚫'],
                ['label' => 'Overstock', 'val' => $this->analitik['overstock'], 'color' => 'indigo', 'key' => 'overstock', 'icon' => '📦'],
            ];
        @endphp

        @foreach($healthStats as $stat)
        <button 
            wire:click="$set('filterKesehatan', '{{ $stat['key'] }}')"
            class="bg-white p-8 rounded-[40px] border-2 transition-all duration-500 text-left group {{ $filterKesehatan === $stat['key'] ? 'border-'.$stat['color'].'-500 ring-4 ring-'.$stat['color'].'-50' : 'border-slate-50 hover:border-'.$stat['color'].'-200 hover:shadow-xl' }}"
        >
            <div class="flex justify-between items-start mb-4">
                <span class="text-2xl">{{ $stat['icon'] }}</span>
                @if($filterKesehatan === $stat['key'])
                    <div class="w-6 h-6 rounded-full bg-{{ $stat['color'] }}-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                @endif
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $stat['label'] }}</p>
            <p class="text-3xl font-black text-slate-900 group-hover:scale-110 transition-transform origin-left">{{ number_format($stat['val']) }} <span class="text-xs text-slate-300 font-bold uppercase tracking-widest">SKU</span></p>
        </button>
        @endforeach
    </div>

    <!-- Main Controller (Tabs) -->
    <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
        
        <!-- Tab Navigation -->
        <div class="p-8 border-b border-indigo-50 bg-slate-50/30 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="flex items-center gap-2 bg-white p-1.5 rounded-2xl border border-indigo-50 shadow-inner">
                <button wire:click="$set('tabAktif', 'posisi')" class="px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $tabAktif === 'posisi' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-400 hover:text-indigo-600' }}">Posisi Inventaris</button>
                <button wire:click="$set('tabAktif', 'mutasi')" class="px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $tabAktif === 'mutasi' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-400 hover:text-indigo-600' }}">Jurnal Mutasi</button>
            </div>

            @if($tabAktif === 'posisi')
            <div class="relative w-full md:w-96 group">
                <input 
                    wire:model.live.debounce.300ms="cari" 
                    type="text" 
                    placeholder="Identifikasi SKU / Model..." 
                    class="w-full pl-12 pr-4 py-4 bg-white border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10 shadow-sm transition-all"
                >
                <svg class="w-5 h-5 absolute left-4 top-4 text-slate-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            @endif
        </div>

        @if($tabAktif === 'posisi')
        <!-- Posisi Inventaris Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Spesimen Unit</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">SKU Kode</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Kesehatan</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Valuasi</th>
                        <th class="px-10 py-6 text-right">Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($stokGlobal as $p)
                    <tr class="group hover:bg-indigo-50/20 transition-all duration-300">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 rounded-2xl bg-white border border-indigo-50 flex-shrink-0 p-2 shadow-sm group-hover:scale-110 transition-transform">
                                    <img src="{{ $p->gambar_utama_url }}" class="w-full h-full object-contain">
                                </div>
                                <div class="space-y-1">
                                    <p class="font-black text-slate-900 tracking-tight leading-none uppercase">{{ $p->nama }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ $p->kategori->nama }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-xs font-mono font-bold text-slate-500 uppercase">{{ $p->kode_unit }}</td>
                        <td class="px-6 py-6">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between max-w-[120px]">
                                    <span class="text-sm font-black text-slate-900">{{ $p->stok }} <span class="text-[10px] text-slate-400 font-bold">U</span></span>
                                    @php
                                        $statusColor = $p->stok <= 0 ? 'rose' : ($p->stok <= 5 ? 'amber' : 'emerald');
                                    @endphp
                                    <span class="px-2 py-0.5 bg-{{ $statusColor }}-50 text-{{ $statusColor }}-600 rounded text-[8px] font-black uppercase tracking-widest border border-{{ $statusColor }}-100">
                                        {{ $p->stok <= 0 ? 'Empty' : ($p->stok <= 5 ? 'Critical' : 'Healthy') }}
                                    </span>
                                </div>
                                <div class="h-1.5 w-full max-w-[120px] bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-{{ $statusColor }}-500 transition-all duration-500" style="width: {{ min(100, ($p->stok / 50) * 100) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-sm font-black text-slate-900 tracking-tight leading-none">Rp {{ number_format($p->stok * $p->harga_modal, 0, ',', '.') }}</p>
                            <p class="text-[9px] text-slate-400 font-bold mt-1 uppercase">Estimasi Modal</p>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="bukaMutasi({{ $p->id }}, 'penerimaan')" class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"></path></svg>
                                    Terima
                                </button>
                                <button wire:click="bukaMutasi({{ $p->id }}, 'penyesuaian')" class="flex items-center gap-2 px-4 py-2 bg-slate-50 text-slate-500 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    Audit
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-10 py-20 text-center text-slate-400 font-black uppercase tracking-widest">Tidak ada record inventaris terdeteksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-10 bg-slate-50/30 border-t border-slate-50 flex justify-center">{{ $stokGlobal->links() }}</div>
        
        @else
        <!-- Jurnal Mutasi Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Waktu & Otoritas</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Subjek Unit</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Volume</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Klasifikasi Mutasi</th>
                        <th class="px-10 py-6 text-right">Memo Audit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($jurnalMutasi as $m)
                    <tr class="group hover:bg-slate-50 transition-all duration-300">
                        <td class="px-10 py-6">
                            <p class="text-xs font-black text-slate-900 leading-none uppercase">{{ $m->created_at->translatedFormat('d M Y • H:i') }}</p>
                            <p class="text-[9px] font-bold text-indigo-600 mt-1 uppercase tracking-widest">{{ $m->pengguna->nama ?? 'Sistem' }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-sm font-black text-slate-900 uppercase truncate max-w-[200px]">{{ $m->produk->nama ?? 'Item Terhapus' }}</p>
                            <p class="text-[9px] font-mono text-slate-400 mt-0.5 uppercase tracking-widest">{{ $m->produk->kode_unit ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <span class="text-sm font-black {{ $m->jumlah > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $m->jumlah > 0 ? '+' : '' }}{{ $m->jumlah }} <span class="text-[10px] font-bold uppercase ml-0.5">Unit</span>
                            </span>
                        </td>
                        <td class="px-6 py-6">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-slate-200">
                                {{ str_replace('_', ' ', $m->jenis_mutasi) }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <p class="text-xs text-slate-500 italic max-w-xs ml-auto leading-relaxed">{{ $m->keterangan }}</p>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-10 py-20 text-center text-slate-400 font-black uppercase tracking-widest">Jurnal audit masih kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-10 bg-slate-50/30 border-t border-slate-50 flex justify-center">{{ $jurnalMutasi->links() }}</div>
        @endif
    </div>

    <!-- Panel Mutasi Enterprise -->
    <x-ui.panel-geser id="panel-mutasi" judul="{{ $jenisAksi === 'penerimaan' ? 'PENERIMAAN LOGISTIK BARU' : 'PENYESUAIAN STOK AUDIT' }}">
        <form wire:submit.prevent="eksekusiMutasi" class="space-y-10 p-2">
            <div class="p-8 rounded-[32px] border-2 border-dashed {{ $jenisAksi === 'penerimaan' ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-amber-50 border-amber-200 text-amber-800' }}">
                <div class="flex items-center gap-4 mb-4">
                    <span class="text-3xl">{{ $jenisAksi === 'penerimaan' ? '📥' : '🛡️' }}</span>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em]">Protokol Operasional</p>
                        <h4 class="text-lg font-black tracking-tight leading-none uppercase">{{ $jenisAksi === 'penerimaan' ? 'Penerimaan Stok' : 'Audit Internal' }}</h4>
                    </div>
                </div>
                <p class="text-xs font-medium leading-relaxed opacity-80">
                    Otorisasi ini akan secara permanen mengubah posisi stok fisik unit teknologi di sistem ERP Teqara dan mempengaruhi Jurnal Audit Nasional.
                </p>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Volume Penyesuaian (Unit)</label>
                <input wire:model="jumlahMutasi" type="number" class="w-full bg-slate-50 border-none rounded-3xl p-8 text-5xl font-black text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all text-center" placeholder="0">
                @error('jumlahMutasi') <span class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-3 block text-center animate-bounce">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Memo Audit (Alasan Resmi)</label>
                <textarea wire:model="keteranganMutasi" rows="5" class="w-full bg-slate-50 border-none rounded-[32px] p-6 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-slate-300" placeholder="Jelaskan dasar penyesuaian ini secara naratif..."></textarea>
                @error('keteranganMutasi') <span class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-3 block px-4">{{ $message }}</span> @enderror
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-6 {{ $jenisAksi === 'penerimaan' ? 'bg-emerald-600' : 'bg-slate-900' }} text-white rounded-[32px] font-black text-xs uppercase tracking-[0.3em] hover:scale-[1.02] active:scale-95 transition-all shadow-2xl shadow-indigo-500/20 group">
                    <span wire:loading.remove>EKSEKUSI OTORISASI</span>
                    <span wire:loading>MENYINKRONKAN DATA...</span>
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>