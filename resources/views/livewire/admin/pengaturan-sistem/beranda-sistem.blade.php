<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">pengaturan_sistem <span class="text-cyan-600">SISTEM</span></h1>
            <p class="text-slate-500 font-medium">Konfigurasi global identitas toko dan operasional.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Form Identitas -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 p-8 md:p-10">
                <form wire:submit.prevent="simpan" class="space-y-8">
                    
                    <div class="space-y-6">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest border-b border-slate-100 pb-4">Identitas Utama</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Toko / Brand</label>
                                <input wire:model="nama_toko" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500 font-bold">
                                @error('nama_toko') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Email Kontak Resmi</label>
                                <input wire:model="email_kontak" type="email" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500">
                                @error('email_kontak') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nomor WhatsApp Bisnis</label>
                            <input wire:model="nomor_wa" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500" placeholder="628...">
                            <p class="text-[10px] text-slate-400 mt-1">Gunakan format internasional (contoh: 628123456789)</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Alamat Fisik / Kantor</label>
                            <textarea wire:model="alamat_toko" rows="3" class="w-full rounded-2xl border-slate-200 focus:ring-cyan-500"></textarea>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition shadow-xl shadow-slate-900/10">
                            Simpan Konfigurasi
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Panel Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-cyan-50 p-8 rounded-[40px] border border-cyan-100">
                <h4 class="font-black text-cyan-900 uppercase tracking-widest text-xs mb-4">Status Sistem</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-cyan-800 font-medium">Versi Aplikasi</span>
                        <span class="font-black text-cyan-900">v5.0 Enterprise</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-cyan-800 font-medium">Framework</span>
                        <span class="font-black text-cyan-900">Laravel 12</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-cyan-800 font-medium">Mode</span>
                        <span class="px-2 py-1 bg-cyan-200 text-cyan-900 rounded text-[10px] font-bold uppercase">Production</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm">
                <h4 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-4">Integrasi API</h4>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        <span class="text-sm font-bold text-slate-600">Midtrans Gateway</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        <span class="text-sm font-bold text-slate-600">RajaOngkir Pro</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                        <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                        <span class="text-sm font-bold text-slate-600">WhatsApp API</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
