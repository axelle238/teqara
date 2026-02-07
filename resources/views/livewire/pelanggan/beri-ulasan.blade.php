<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 text-center animate-fade-in-down">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Beri <span class="text-amber-500">Nilai</span></h1>
            <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-2">Bagikan Pengalaman & Dapatkan Poin</p>
        </div>

        <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden animate-fade-in-up relative">
            <!-- Deco -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

            <!-- Header Produk -->
            <div class="p-8 border-b border-slate-50 bg-slate-50/50 flex gap-6 items-center relative z-10">
                <div class="w-24 h-24 rounded-2xl bg-white border border-slate-200 flex-shrink-0 p-2 shadow-sm">
                    <img src="{{ $produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply">
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Produk yang Diulas</p>
                    <h1 class="text-xl font-black text-slate-900 leading-tight uppercase">{{ $produk->nama }}</h1>
                    <p class="text-xs text-slate-500 font-medium mt-1">Invoice #{{ $pesanan->nomor_faktur }}</p>
                </div>
            </div>

            <form wire:submit.prevent="simpanUlasan" class="p-8 md:p-10 space-y-10 relative z-10">
                
                <!-- Rating Stars -->
                <div class="text-center">
                    <label class="block text-sm font-black text-slate-900 uppercase tracking-wide mb-6">Seberapa Puas Anda?</label>
                    <div class="flex justify-center gap-3 mb-4">
                        @for($i=1; $i<=5; $i++)
                        <button type="button" wire:click="$set('rating', {{ $i }})" class="group transition-transform hover:scale-110 focus:outline-none relative">
                            <svg class="w-14 h-14 transition-colors duration-300 {{ $rating >= $i ? 'text-amber-400 fill-current drop-shadow-lg' : 'text-slate-200 fill-current group-hover:text-amber-200' }}" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        </button>
                        @endfor
                    </div>
                    <div class="inline-block px-6 py-2 bg-slate-900 text-white rounded-full text-sm font-black uppercase tracking-widest shadow-lg shadow-slate-900/20 transition-all duration-300 transform">
                        {{ $rating == 5 ? 'Sangat Puas! 😍' : ($rating == 4 ? 'Puas 😊' : ($rating == 3 ? 'Cukup 🙂' : ($rating == 2 ? 'Kurang 😕' : 'Kecewa 😞'))) }}
                    </div>
                </div>

                <!-- Komentar -->
                <div class="space-y-4">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest px-1">Ulasan Detail</label>
                    <div class="relative">
                        <textarea wire:model="komentar" rows="5" class="w-full bg-slate-50 border-none rounded-2xl p-6 text-sm font-medium focus:ring-2 focus:ring-amber-400/50 transition-all placeholder:text-slate-300 resize-none shadow-inner" placeholder="Ceritakan kualitas produk, kecepatan pengiriman, dan pelayanan penjual..."></textarea>
                        <div class="absolute bottom-4 right-4 text-[10px] font-bold text-slate-400 bg-white/50 px-2 py-1 rounded-lg backdrop-blur-sm">
                            Min. 10 Karakter
                        </div>
                    </div>
                    @error('komentar') <span class="text-rose-500 text-[10px] font-bold px-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Upload Foto -->
                <div class="space-y-4">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest px-1">Foto Produk (Opsional - Bonus Poin)</label>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($foto as $f)
                        <div class="aspect-square rounded-2xl overflow-hidden border border-slate-200 relative group shadow-sm">
                            <img src="{{ $f->temporaryUrl() }}" class="w-full h-full object-cover">
                        </div>
                        @endforeach
                        
                        <label class="aspect-square rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center cursor-pointer hover:border-amber-400 hover:bg-amber-50/30 transition-all group bg-slate-50">
                            <div class="w-8 h-8 bg-white rounded-full shadow-sm flex items-center justify-center mb-1 group-hover:scale-110 transition-transform text-slate-400 group-hover:text-amber-500">
                                📷
                            </div>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest group-hover:text-amber-600">Tambah</span>
                            <input type="file" wire:model="foto" multiple class="hidden">
                        </label>
                    </div>
                    @error('foto.*') <span class="text-rose-500 text-[10px] font-bold px-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Reward Info -->
                <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100 flex gap-4 items-center">
                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center text-xl">🎁</div>
                    <div>
                        <p class="text-xs font-black text-amber-800 uppercase tracking-wide">Potensi Reward</p>
                        <p class="text-[10px] text-amber-700 font-bold mt-0.5">Dapatkan hingga <span class="text-amber-900 font-black">+125 Poin</span> dengan ulasan lengkap & foto.</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/20 active:scale-95 flex items-center justify-center gap-3">
                        <span>Kirim Ulasan</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>