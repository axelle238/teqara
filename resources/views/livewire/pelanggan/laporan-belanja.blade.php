<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Laporan <span class="text-indigo-600">Belanja</span></h1>
                <p class="text-slate-500 font-medium text-sm mt-2">Analisis pengeluaran dan unduh dokumen pajak.</p>
            </div>
            <div class="flex gap-3">
                <button wire:click="unduhPDF" class="px-6 py-3 bg-rose-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-rose-700 transition-all shadow-lg shadow-rose-500/30 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Unduh PDF
                </button>
                <button wire:click="unduhExcel" class="px-6 py-3 bg-emerald-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/30 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Excel
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Periode Bulan</label>
                    <select wire:model.live="bulan" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Tahun</label>
                    <select wire:model.live="tahun" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                        @foreach(range(date('Y'), date('Y')-5) as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Tipe Laporan</label>
                    <select wire:model.live="tipe_laporan" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                        <option value="ringkasan">Ringkasan Eksekutif</option>
                        <option value="detail">Detail Per Transaksi</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Report Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-[2.5rem] p-8 text-white shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <p class="text-indigo-200 text-xs font-black uppercase tracking-widest mb-1">Total Pengeluaran</p>
                <h2 class="text-3xl font-black tracking-tight">Rp {{ number_format($this->totalPengeluaran) }}</h2>
            </div>
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm flex flex-col justify-center">
                <p class="text-slate-400 text-xs font-black uppercase tracking-widest mb-1">Total Transaksi</p>
                <h2 class="text-3xl font-black text-slate-900">{{ $this->laporanData->count() }}</h2>
            </div>
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm flex flex-col justify-center">
                <p class="text-slate-400 text-xs font-black uppercase tracking-widest mb-1">Rata-rata Keranjang</p>
                <h2 class="text-3xl font-black text-slate-900">
                    Rp {{ $this->laporanData->count() > 0 ? number_format($this->totalPengeluaran / $this->laporanData->count()) : 0 }}
                </h2>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">Tanggal</th>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">No. Invoice</th>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">Status</th>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px] text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($this->laporanData as $data)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6 font-medium text-slate-600">{{ $data->dibuat_pada->format('d/m/Y') }}</td>
                            <td class="px-8 py-6 font-bold text-slate-900">{{ $data->nomor_faktur }}</td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600">Selesai</span>
                            </td>
                            <td class="px-8 py-6 font-black text-slate-900 text-right">Rp {{ number_format($data->total_harga) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-slate-400 italic">Tidak ada data untuk periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
