<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Identitas <span class="text-indigo-600">Bisnis</span></h1>
            <p class="text-slate-500 font-medium text-sm mt-2">Kelola informasi perusahaan untuk keperluan faktur pajak.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-xl relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

            <form wire:submit.prevent="simpan" class="space-y-8 relative z-10">
                
                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest px-1">Nama Perusahaan / Instansi</label>
                    <input wire:model="nama_perusahaan" type="text" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300" placeholder="PT. Teqara Teknologi Indonesia">
                    @error('nama_perusahaan') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest px-1">NPWP</label>
                        <input wire:model="npwp" type="text" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-mono font-bold focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300" placeholder="00.000.000.0-000.000">
                        @error('npwp') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest px-1">Email Bisnis (Faktur)</label>
                        <input wire:model="email_bisnis" type="email" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300">
                        @error('email_bisnis') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest px-1">Alamat Kantor Pusat</label>
                    <textarea wire:model="alamat_perusahaan" rows="3" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300"></textarea>
                </div>

                <div class="bg-indigo-50 rounded-2xl p-4 border border-indigo-100 flex gap-4 items-start">
                    <div class="text-xl">🏢</div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-indigo-800">Informasi Pajak</p>
                        <p class="text-[10px] text-indigo-600 leading-relaxed">Data ini akan dicetak otomatis pada setiap faktur pembelian untuk keperluan pelaporan pajak perusahaan Anda.</p>
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-xl shadow-indigo-600/20 transition-all active:scale-95">
                        Simpan Identitas
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
