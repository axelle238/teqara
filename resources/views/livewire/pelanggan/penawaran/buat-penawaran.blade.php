<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12 animate-fade-in-down">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Buat <span class="text-indigo-600">Pengajuan</span></h1>
            <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-2">Formulir Permintaan Harga Khusus (RFQ)</p>
        </div>

        <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-xl animate-fade-in-up relative overflow-hidden">
             <!-- Background Glow -->
             <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

            <form wire:submit.prevent="ajukan" class="space-y-10 relative z-10">
                
                <!-- Items Repeater -->
                <div class="space-y-6">
                    <div class="flex justify-between items-center border-b border-slate-50 pb-4">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">1</span>
                            Daftar Produk
                        </h3>
                        <button type="button" wire:click="tambahItem" class="flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-100 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Item
                        </button>
                    </div>

                    @foreach($items as $index => $item)
                    <div class="p-6 bg-slate-50/50 rounded-3xl border border-slate-100 relative group transition-all hover:bg-white hover:shadow-lg hover:border-indigo-100 hover:-translate-y-1">
                        @if(count($items) > 1)
                        <button type="button" wire:click="hapusItem({{ $index }})" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white text-slate-400 hover:text-rose-500 hover:bg-rose-50 border border-slate-200 flex items-center justify-center transition-all shadow-sm z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <div class="md:col-span-8 space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Pilih Produk</label>
                                <div class="relative">
                                    <select wire:model="items.{{ $index }}.produk_id" class="w-full bg-white border-none rounded-2xl p-4 pl-12 text-sm font-bold focus:ring-2 focus:ring-indigo-500 cursor-pointer shadow-sm appearance-none">
                                        <option value="">-- Cari di Katalog --</option>
                                        @foreach($this->daftarProduk as $p)
                                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl">📦</span>
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs">▼</span>
                                </div>
                                @error("items.{$index}.produk_id") <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="md:col-span-4 space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Jumlah Unit</label>
                                <div class="relative">
                                    <input type="number" wire:model="items.{{ $index }}.jumlah" class="w-full bg-white border-none rounded-2xl p-4 pl-12 text-sm font-bold focus:ring-2 focus:ring-indigo-500 shadow-sm" placeholder="100">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl">🔢</span>
                                </div>
                                @error("items.{$index}.jumlah") <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Additional Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-4">
                    <div class="space-y-4">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest flex items-center gap-2 border-b border-slate-50 pb-2">
                            <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">2</span>
                            Detail Kebutuhan
                        </h3>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Catatan Proyek</label>
                            <textarea wire:model="pesan" rows="6" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300" placeholder="Jelaskan spesifikasi teknis, target harga, atau timeline pengiriman yang diharapkan..."></textarea>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest flex items-center gap-2 border-b border-slate-50 pb-2">
                            <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">3</span>
                            Dokumen Pendukung
                        </h3>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Lampiran (PDF/Excel)</label>
                            <label class="block w-full h-48 bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl flex flex-col items-center justify-center text-center cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/20 transition-all relative group overflow-hidden">
                                <input type="file" wire:model="lampiran" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-3xl mb-4 group-hover:scale-110 transition-transform duration-300 relative z-10">
                                    📎
                                </div>
                                <p class="text-xs font-bold text-slate-500 relative z-10">
                                    {{ $lampiran ? $lampiran->getClientOriginalName() : 'Klik untuk Unggah File' }}
                                </p>
                                <p class="text-[10px] text-slate-400 mt-1 relative z-10">Maks. 5MB</p>

                                <!-- Drag Overlay -->
                                <div class="absolute inset-0 bg-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity z-0"></div>
                            </label>
                            @error('lampiran') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-8 border-t border-slate-50">
                    <button type="submit" class="px-10 py-5 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20 active:scale-95 flex items-center gap-4 group">
                        <span>Kirim RFQ</span>
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>