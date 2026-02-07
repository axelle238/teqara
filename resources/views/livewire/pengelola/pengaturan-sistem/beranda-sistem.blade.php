<div class="animate-in fade-in slide-in-from-bottom-8 duration-500 pb-20">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Branding Preview (Dummy) -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-indigo-900 rounded-[40px] p-8 text-center text-white shadow-2xl shadow-indigo-900/30 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
                
                <div class="relative z-10">
                    <div class="w-24 h-24 mx-auto bg-white rounded-3xl flex items-center justify-center shadow-lg mb-6 p-4">
                        @if($logo)
                            <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-contain">
                        @elseif($logo_lama)
                            <img src="{{ asset($logo_lama) }}" class="w-full h-full object-contain">
                        @else
                            <span class="text-4xl font-black text-indigo-900">T</span>
                        @endif
                    </div>
                    <h2 class="text-2xl font-black tracking-tight">{{ $nama_toko }}</h2>
                    <p class="text-indigo-200 text-xs font-medium mt-2">{{ $email_kontak }}</p>
                </div>
            </div>

            <div class="bg-white rounded-[30px] p-8 border border-slate-200 shadow-sm">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-4">Panduan Konfigurasi</h3>
                <ul class="space-y-3 text-sm text-slate-500">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-emerald-500 mt-1"></i>
                        <span>Nama toko akan muncul di Invoice dan Header website.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-emerald-500 mt-1"></i>
                        <span>Email kontak digunakan untuk notifikasi sistem dan footer.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-emerald-500 mt-1"></i>
                        <span>Logo sebaiknya berformat PNG transparan (512x512px).</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Right: Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[40px] p-10 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-4 mb-8 border-b border-slate-100 pb-6">
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                        <i class="fa-solid fa-sliders text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900">Identitas Toko</h3>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Informasi dasar perusahaan</p>
                    </div>
                </div>

                <form wire:submit.prevent="simpan" class="space-y-8">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Toko / Brand</label>
                            <input wire:model="nama_toko" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                            @error('nama_toko') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Resmi</label>
                            <input wire:model="email_kontak" type="email" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Deskripsi Singkat (SEO)</label>
                        <textarea wire:model="deskripsi_toko" rows="3" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-medium text-slate-600 focus:ring-4 focus:ring-indigo-500/10 resize-none"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nomor Telepon / CS</label>
                            <input wire:model="nomor_telepon" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Upload Logo Baru</label>
                            <input wire:model="logo" type="file" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 text-xs font-bold text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-white file:text-indigo-600 hover:file:bg-indigo-50">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Alamat Fisik</label>
                        <textarea wire:model="alamat_toko" rows="3" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-medium text-slate-600 focus:ring-4 focus:ring-indigo-500/10 resize-none"></textarea>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-10 py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/20 active:scale-95">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
