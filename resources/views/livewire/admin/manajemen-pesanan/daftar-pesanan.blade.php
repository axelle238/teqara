<!-- 
    Nama File: resources/views/livewire/admin/pesanan/daftar-pesanan.blade.php
    Tujuan: Antarmuka administrasi untuk melacak dan mengelola seluruh transaksi pelanggan.
    Gaya: High-Tech Enterprise, Clean Layout, Real-time Status.
-->
<div class="p-6 lg:p-10 space-y-10">
    
    <!-- Header Halaman -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">ARUS <span class="text-indigo-600">TRANSAKSI</span></h1>
            <p class="text-slate-500 font-medium">Monitoring pesanan masuk dan status pengiriman secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative group">
                <input 
                    wire:model.live.debounce.300ms="cari" 
                    type="text" 
                    placeholder="Cari Invoice atau Pelanggan..." 
                    class="w-72 pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"
                >
                <svg class="w-5 h-5 absolute left-4 top-3.5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Statistik Transaksi -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[32px] shadow-sm border border-slate-100">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Pesanan</p>
            <p class="text-2xl font-black text-slate-900">{{ number_format($statistik['total']) }}</p>
        </div>
        <div class="bg-amber-50 p-6 rounded-[32px] border border-amber-100">
            <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.2em] mb-1">Menunggu</p>
            <p class="text-2xl font-black text-amber-700">{{ number_format($statistik['menunggu']) }}</p>
        </div>
        <div class="bg-indigo-50 p-6 rounded-[32px] border border-indigo-100">
            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em] mb-1">Sedang Proses</p>
            <p class="text-2xl font-black text-indigo-700">{{ number_format($statistik['proses']) }}</p>
        </div>
        <div class="bg-emerald-50 p-6 rounded-[32px] border border-emerald-100">
            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-1">Berhasil</p>
            <p class="text-2xl font-black text-emerald-700">{{ number_format($statistik['selesai']) }}</p>
        </div>
    </div>

    <!-- Kontrol Filter & Tabel -->
    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex items-center gap-2 overflow-x-auto">
            <button wire:click="$set('filterStatus', '')" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $filterStatus === '' ? 'bg-slate-900 text-white' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">SEMUA</button>
            <button wire:click="$set('filterStatus', 'menunggu')" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $filterStatus === 'menunggu' ? 'bg-amber-500 text-white' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">MENUNGGU</button>
            <button wire:click="$set('filterStatus', 'diproses')" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $filterStatus === 'diproses' ? 'bg-indigo-500 text-white' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">DIPROSES</button>
            <button wire:click="$set('filterStatus', 'dikirim')" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $filterStatus === 'dikirim' ? 'bg-cyan-500 text-white' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">DIKIRIM</button>
            <button wire:click="$set('filterStatus', 'selesai')" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $filterStatus === 'selesai' ? 'bg-emerald-500 text-white' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">SELESAI</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Data Transaksi</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pelanggan</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pembayaran</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Nilai Akhir</th>
                        <th class="px-8 py-5 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pesanan as $p)
                    <tr class="group hover:bg-indigo-50/30 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-900 tracking-tight">#{{ $p->nomor_faktur }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $p->created_at->translatedFormat('d F Y • H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-black text-slate-500 border border-slate-200 uppercase">
                                    {{ substr($p->pengguna->nama, 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-slate-700">{{ $p->pengguna->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest 
                                {{ $p->status_pembayaran === 'lunas' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                {{ str_replace('_', ' ', $p->status_pembayaran) }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-sm font-black text-slate-900">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <a 
                                href="/admin/pesanan/{{ $p->id }}" 
                                wire:navigate 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all shadow-sm"
                            >
                                Proses
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="text-slate-400 font-bold text-sm tracking-tight">Tidak ada pesanan yang sesuai dengan kriteria.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Navigasi Halaman -->
        <div class="p-8 bg-slate-50/30 border-t border-slate-50">
            {{ $pesanan->links() }}
        </div>
    </div>

</div>
