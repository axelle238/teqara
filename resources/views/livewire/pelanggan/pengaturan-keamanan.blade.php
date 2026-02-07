<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Benteng <span class="text-rose-600">Keamanan</span></h1>
            <p class="text-slate-500 font-medium text-sm mt-2">Lindungi akses otoritas Anda dengan kredensial yang kuat.</p>
        </div>

        <div class="bg-white rounded-[32px] p-10 border border-slate-100 shadow-xl relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-rose-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

            <form wire:submit.prevent="gantiPassword" class="space-y-8 relative z-10">
                
                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest px-1">Kunci Saat Ini</label>
                    <input wire:model="sandi_lama" type="password" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-rose-500 transition-all placeholder:text-slate-300" placeholder="••••••••">
                    @error('sandi_lama') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest px-1">Kunci Baru</label>
                        <input wire:model="sandi_baru" type="password" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-rose-500 transition-all placeholder:text-slate-300" placeholder="Minimal 8 Karakter">
                        @error('sandi_baru') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest px-1">Konfirmasi Kunci</label>
                        <input wire:model="sandi_baru_confirmation" type="password" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-rose-500 transition-all placeholder:text-slate-300" placeholder="Ulangi Kunci Baru">
                    </div>
                </div>

                <div class="bg-rose-50 rounded-2xl p-4 border border-rose-100 flex gap-4 items-start">
                    <div class="text-xl">🛡️</div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-rose-800">Rekomendasi Keamanan</p>
                        <p class="text-[10px] text-rose-600 leading-relaxed">Gunakan kombinasi huruf besar, kecil, angka, dan simbol. Jangan gunakan tanggal lahir atau nama umum.</p>
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="px-8 py-4 bg-rose-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-rose-700 shadow-xl shadow-rose-600/20 transition-all active:scale-95">
                        Perbarui Akses
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
