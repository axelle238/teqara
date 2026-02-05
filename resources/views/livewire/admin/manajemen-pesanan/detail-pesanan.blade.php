<!-- 
    Nama File: resources/views/livewire/admin/pesanan/detail-pesanan.blade.php
    Tujuan: Panel kontrol terperinci untuk memproses satu transaksi spesifik.
    Gaya: Enterprise Layout, High-Contrast Status, No Modal.
-->
<div class="p-6 lg:p-10 space-y-10 pb-20">
    
    <!-- Breadcrumb & Navigasi -->
    <div class="flex items-center justify-between">
        <a href="/admin/pesanan" wire:navigate class="flex items-center gap-2 group">
            <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white group-hover:border-indigo-600 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </div>
            <span class="text-sm font-black text-slate-500 group-hover:text-indigo-600 transition-colors uppercase tracking-widest">Kembali</span>
        </a>
        <div class="flex items-center gap-4">
            <span class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-[10px] font-black uppercase tracking-[0.2em]">Pesanan #{{ $pesanan->nomor_faktur }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- KOLOM KIRI: DATA TRANSAKSI & PELANGGAN -->
        <div class="lg:col-span-2 space-y-10">
            
            <!-- Daftar Item Belanja -->
            <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Manifest Pengiriman</h3>
                </div>
                <div class="divide-y divide-slate-50">
                    @foreach($pesanan->detailPesanan as $detail)
                    <div class="px-8 py-6 flex items-center justify-between group">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 rounded-2xl bg-slate-50 p-2 border border-slate-100 flex-shrink-0">
                                <img src="{{ $detail->produk->gambar_utama }}" class="w-full h-full object-contain">
                            </div>
                            <div>
                                <p class="font-black text-slate-900 tracking-tight leading-none mb-1">{{ $detail->produk->nama }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $detail->jumlah }} Unit x Rp {{ number_format($detail->harga_saat_ini, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-black text-slate-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="px-8 py-8 bg-slate-50/50 flex justify-between items-center border-t border-slate-100">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Total Nilai Pesanan</p>
                    <p class="text-3xl font-black text-indigo-600 tracking-tighter">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Detail Pelanggan & Alamat -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-[10px] mb-6 text-indigo-500">Profil Pelanggan</h3>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 font-black">{{ substr($pesanan->pengguna->nama, 0, 1) }}</div>
                            <div>
                                <p class="font-black text-slate-900 leading-none">{{ $pesanan->pengguna->nama }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ $pesanan->pengguna->email }}</p>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-slate-400 mt-4 leading-relaxed uppercase tracking-widest">Telepon: {{ $pesanan->pengguna->nomor_telepon ?? '-' }}</p>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-[10px] mb-6 text-amber-500">Destinasi Pengiriman</h3>
                    <div class="flex gap-4">
                        <svg class="w-6 h-6 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <p class="text-sm font-bold text-slate-700 leading-relaxed">{{ $pesanan->alamat_pengiriman }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: PANEL KONTROL & STATUS -->
        <div class="space-y-10">
            <div class="bg-slate-900 rounded-[48px] p-10 text-white shadow-2xl shadow-indigo-500/10 border border-white/5 relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-black uppercase tracking-[0.3em] text-[10px] text-indigo-400 mb-10">Pusat Komando Pesanan</h3>
                    
                    <form wire:submit.prevent="simpanPerubahan" class="space-y-8">
                        <!-- Status Pembayaran -->
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-white/40 uppercase tracking-widest">Otoritas Pembayaran</label>
                            <select wire:model="statusPembayaran" class="w-full bg-white/5 border-white/10 rounded-2xl text-sm font-bold focus:ring-indigo-500 focus:border-indigo-500 py-4 transition-all">
                                <option value="belum_dibayar" class="text-slate-900">BELUM DIBAYAR</option>
                                <option value="menunggu_verifikasi" class="text-slate-900">MENUNGGU VERIFIKASI</option>
                                <option value="lunas" class="text-slate-900">LUNAS (VERIFIED)</option>
                                <option value="gagal" class="text-slate-900">GAGAL / EXPIRED</option>
                            </select>
                        </div>

                        <!-- Status Logistik -->
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-white/40 uppercase tracking-widest">Alur Logistik</label>
                            <select wire:model="statusPesanan" class="w-full bg-white/5 border-white/10 rounded-2xl text-sm font-bold focus:ring-indigo-500 focus:border-indigo-500 py-4 transition-all">
                                <option value="menunggu" class="text-slate-900">MENUNGGU ANTRIAN</option>
                                <option value="diproses" class="text-slate-900">SEDANG PACKING</option>
                                <option value="dikirim" class="text-slate-900">DALAM PENGIRIMAN</option>
                                <option value="selesai" class="text-slate-900">DITERIMA PELANGGAN</option>
                                <option value="batal" class="text-slate-900">BATALKAN TRANSAKSI</option>
                            </select>
                        </div>

                        <!-- Input Resi -->
                        @if($statusPesanan === 'dikirim' || $statusPesanan === 'selesai')
                        <div class="space-y-3 animate-in fade-in slide-in-from-top-4 duration-500">
                            <label class="block text-[10px] font-black text-white/40 uppercase tracking-widest">Nomor Resi / AWB</label>
                            <input wire:model="resiPengiriman" type="text" placeholder="Contoh: TEQ-AWB-998877" class="w-full bg-white/5 border-white/10 rounded-2xl text-sm font-black focus:ring-indigo-500 focus:border-indigo-500 py-4 placeholder:text-white/20">
                        </div>
                        @endif

                        <div class="pt-6">
                            <button type="submit" class="w-full py-5 bg-gradient-to-r from-indigo-600 to-cyan-600 text-white rounded-[24px] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-indigo-600/30">
                                Eksekusi Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Dekorasi -->
                <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-indigo-500/20 rounded-full blur-[100px]"></div>
            </div>

            <!-- Info Logistik Tambahan -->
            <div class="bg-indigo-50 p-8 rounded-[40px] border border-indigo-100">
                <h4 class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-4">Metode Pengiriman</h4>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                    </div>
                    <span class="font-bold text-slate-700">Ekspedisi Reguler (JNE/J&T/Sicepat)</span>
                </div>
            </div>
        </div>
    </div>
</div>
