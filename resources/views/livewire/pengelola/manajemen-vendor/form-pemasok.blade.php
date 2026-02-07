<div class="max-w-4xl mx-auto py-12 animate-in fade-in zoom-in duration-500">
    
    <div class="bg-white rounded-[50px] p-10 md:p-16 border border-slate-200 shadow-2xl relative overflow-hidden">
        
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-purple-50 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-50 rounded-full blur-3xl -ml-10 -mb-10"></div>

        <div class="flex justify-between items-center mb-12 relative z-10">
            <div class="flex items-center gap-6">
                <a href="{{ route('pengelola.vendor.daftar') }}" class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-all border border-slate-100 shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">{{ $pemasokId ? 'Sunting Mitra' : 'Registrasi Vendor' }}</h1>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mt-1">Manajemen Rantai Pasok Enterprise</p>
                </div>
            </div>
        </div>

        <form wire:submit="simpan" class="space-y-10 relative z-10">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Perusahaan / Institusi</label>
                    <div class="relative">
                        <input type="text" wire:model="nama_perusahaan" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-black text-slate-800 focus:ring-4 focus:ring-purple-500/10 placeholder-slate-300 transition-all" placeholder="Cth: PT. Teknologi Global">
                        <i class="fa-solid fa-building absolute right-6 top-1/2 -translate-y-1/2 text-slate-300"></i>
                    </div>
                    @error('nama_perusahaan') <span class="text-rose-500 text-xs font-bold px-1 block mt-2">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kode Unik Vendor (System Generated)</label>
                    <input type="text" wire:model="kode_pemasok" class="w-full px-6 py-4 bg-slate-100 border-none rounded-2xl font-mono text-sm font-black text-slate-500 cursor-not-allowed" readonly>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Penanggung Jawab (PIC)</label>
                    <input type="text" wire:model="penanggung_jawab" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Korespondensi</label>
                    <input type="email" wire:model="email" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nomor Telepon / WA</label>
                    <input type="text" wire:model="telepon" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Alamat Kantor Pusat</label>
                <textarea wire:model="alamat" rows="3" class="w-full px-6 py-4 bg-slate-50 border-none rounded-[30px] text-sm font-medium text-slate-700 focus:ring-4 focus:ring-purple-500/10 transition-all resize-none"></textarea>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Status Kemitraan</label>
                    <div class="flex bg-slate-100 p-1 rounded-xl">
                        <button type="button" wire:click="$set('status', 'aktif')" class="px-4 py-2 rounded-lg text-[10px] font-black uppercase transition-all {{ $status == 'aktif' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-400' }}">Aktif</button>
                        <button type="button" wire:click="$set('status', 'nonaktif')" class="px-4 py-2 rounded-lg text-[10px] font-black uppercase transition-all {{ $status == 'nonaktif' ? 'bg-white text-rose-600 shadow-sm' : 'text-slate-400' }}">Non-Aktif</button>
                    </div>
                </div>
                
                <button type="submit" class="px-12 py-5 bg-purple-600 text-white rounded-3xl font-black text-xs uppercase tracking-[0.2em] hover:bg-purple-700 shadow-2xl shadow-purple-500/30 transition-all active:scale-95 flex items-center gap-3">
                    <span>{{ $pemasokId ? 'PERBARUI DATA' : 'ONBOARD VENDOR' }}</span>
                    <i class="fa-solid fa-arrow-right-long"></i>
                </button>
            </div>

        </form>
    </div>
</div>
