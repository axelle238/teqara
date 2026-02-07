<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12 animate-fade-in-down">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Ajukan <span class="text-rose-600">Retur</span></h1>
            <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-2">Garansi Kepuasan Pelanggan 100%</p>
        </div>

        <div class="bg-white rounded-[3rem] p-8 md:p-12 border border-slate-100 shadow-2xl shadow-slate-200/50 relative overflow-hidden animate-fade-in-up">
            <!-- Deco -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-rose-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

            <form wire:submit.prevent="ajukan" class="space-y-10 relative z-10">
                
                <!-- Step 1: Select Order -->
                <div class="space-y-4">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest flex items-center gap-2 border-b border-slate-50 pb-2">
                        <span class="w-6 h-6 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center text-xs">1</span>
                        Pilih Pesanan
                    </h3>
                    <div class="relative">
                        <select wire:model="pesanan_id" class="w-full bg-slate-50 border-none rounded-2xl p-4 pl-12 text-sm font-bold focus:ring-2 focus:ring-rose-500 cursor-pointer appearance-none transition-all hover:bg-slate-100">
                            <option value="">-- Pilih Pesanan Bermasalah --</option>
                            @foreach($this->daftarPesanan as $p)
                                <option value="{{ $p->id }}">Order #{{ $p->nomor_faktur }} — {{ $p->diperbarui_pada->format('d M Y') }}</option>
                            @endforeach
                        </select>
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl">📦</span>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs">▼</span>
                    </div>
                    @if($this->daftarPesanan->isEmpty())
                        <div class="bg-amber-50 p-4 rounded-xl border border-amber-100 flex gap-3 items-start">
                            <span class="text-lg">ℹ️</span>
                            <p class="text-[10px] text-amber-600 font-bold leading-relaxed">
                                Hanya pesanan dengan status "Selesai" dalam 7 hari terakhir yang dapat diajukan retur. Hubungi CS jika melewati batas waktu.
                            </p>
                        </div>
                    @endif
                    @error('pesanan_id') <span class="text-rose-500 text-[10px] font-bold px-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Step 2: Reason -->
                <div class="space-y-4">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest flex items-center gap-2 border-b border-slate-50 pb-2">
                        <span class="w-6 h-6 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center text-xs">2</span>
                        Kendala Utama
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <label class="cursor-pointer group">
                            <input type="radio" wire:model="alasan" value="cacat_fisik" class="peer sr-only">
                            <div class="h-full p-4 rounded-2xl border-2 border-slate-50 bg-slate-50 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700 transition-all text-center group-hover:border-rose-200">
                                <span class="text-3xl block mb-2 group-hover:scale-110 transition-transform">🔨</span>
                                <span class="text-[10px] font-black uppercase tracking-wide block">Rusak Fisik</span>
                            </div>
                        </label>
                        <label class="cursor-pointer group">
                            <input type="radio" wire:model="alasan" value="fungsi_rusak" class="peer sr-only">
                            <div class="h-full p-4 rounded-2xl border-2 border-slate-50 bg-slate-50 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700 transition-all text-center group-hover:border-rose-200">
                                <span class="text-3xl block mb-2 group-hover:scale-110 transition-transform">🔌</span>
                                <span class="text-[10px] font-black uppercase tracking-wide block">Mati Total</span>
                            </div>
                        </label>
                        <label class="cursor-pointer group">
                            <input type="radio" wire:model="alasan" value="salah_kirim" class="peer sr-only">
                            <div class="h-full p-4 rounded-2xl border-2 border-slate-50 bg-slate-50 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700 transition-all text-center group-hover:border-rose-200">
                                <span class="text-3xl block mb-2 group-hover:scale-110 transition-transform">📦</span>
                                <span class="text-[10px] font-black uppercase tracking-wide block">Salah Barang</span>
                            </div>
                        </label>
                        <label class="cursor-pointer group">
                            <input type="radio" wire:model="alasan" value="lainnya" class="peer sr-only">
                            <div class="h-full p-4 rounded-2xl border-2 border-slate-50 bg-slate-50 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700 transition-all text-center group-hover:border-rose-200">
                                <span class="text-3xl block mb-2 group-hover:scale-110 transition-transform">📝</span>
                                <span class="text-[10px] font-black uppercase tracking-wide block">Lainnya</span>
                            </div>
                        </label>
                    </div>
                    @error('alasan') <span class="text-rose-500 text-[10px] font-bold px-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Step 3: Evidence -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kronologi Detail</label>
                        <textarea wire:model="keterangan" rows="5" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-rose-500 transition-all placeholder:text-slate-300 resize-none" placeholder="Ceritakan kondisi barang saat diterima..."></textarea>
                        @error('keterangan') <span class="text-rose-500 text-[10px] font-bold px-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Bukti Foto / Video (Wajib)</label>
                        <div class="h-32 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center text-center cursor-pointer hover:border-rose-400 hover:bg-rose-50/10 transition-all relative group overflow-hidden bg-slate-50">
                            <input type="file" wire:model="bukti_foto" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                            
                            <div class="relative z-10 group-hover:scale-110 transition-transform duration-300">
                                <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center mx-auto mb-2 text-xl">📸</div>
                                <p class="text-[10px] font-bold text-slate-500">Klik untuk Unggah</p>
                            </div>
                        </div>
                        
                        @if($bukti_foto)
                            <div class="flex gap-2 overflow-x-auto pb-2 mt-2">
                                @foreach($bukti_foto as $f)
                                    <div class="w-16 h-16 rounded-xl overflow-hidden border border-slate-200 shrink-0 shadow-sm relative group">
                                        <img src="{{ $f->temporaryUrl() }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-colors"></div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @error('bukti_foto.*') <span class="text-rose-500 text-[10px] font-bold px-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <button type="submit" class="w-full py-5 bg-rose-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-rose-700 shadow-xl shadow-rose-600/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                        <span>Kirim Pengajuan Retur</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    <p class="text-center text-[10px] text-slate-400 mt-4 font-bold bg-slate-50 inline-block px-4 py-2 rounded-full mx-auto block w-max">
                        🕒 Estimasi Respon: 1x24 Jam Kerja
                    </p>
                </div>

            </form>
        </div>
    </div>
</div>