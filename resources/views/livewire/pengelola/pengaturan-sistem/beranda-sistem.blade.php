<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Konfigurasi Sistem</h1>
            <p class="text-slate-500 text-sm mt-1">Pengaturan global infrastruktur dan parameter bisnis.</p>
        </div>
        <button wire:click="simpan" class="flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
            <i class="fa-solid fa-save"></i> Simpan Perubahan
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Panel: Navigation/Status -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 text-xl">
                        <i class="fa-solid fa-server"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900">Status Sistem</h3>
                        <p class="text-xs text-slate-500">v16.0 Enterprise</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-600">Environment</span>
                        <span class="font-mono font-bold text-slate-900">Production</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-600">Database</span>
                        <span class="font-bold text-emerald-600">Terhubung</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-600">Storage</span>
                        <span class="font-bold text-emerald-600">Optimal</span>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-indigo-600 to-violet-600 p-6 rounded-[24px] text-white shadow-lg relative overflow-hidden">
                <i class="fa-solid fa-gears absolute -right-6 -bottom-6 text-9xl text-white/10"></i>
                <h3 class="font-bold text-lg mb-2 relative z-10">Mode Pemeliharaan</h3>
                <p class="text-xs text-white/80 mb-6 relative z-10 leading-relaxed">
                    Aktifkan jika ingin menutup akses publik sementara untuk maintenance.
                </p>
                <div class="flex items-center justify-between bg-white/10 p-3 rounded-xl backdrop-blur relative z-10">
                    <span class="text-xs font-bold uppercase tracking-widest">Maintenance</span>
                    <div class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-9 h-5 bg-black/20 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-400"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel: Forms -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Identitas Toko -->
            <div class="bg-white p-8 rounded-[24px] border border-slate-100 shadow-sm">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-store text-indigo-500"></i> Identitas Bisnis
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Nama Toko</label>
                        <input wire:model="nama_toko" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Email Kontak</label>
                        <input wire:model="email_kontak" type="email" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">WhatsApp Admin</label>
                        <input wire:model="nomor_wa" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Alamat Fisik</label>
                        <textarea wire:model="alamat_toko" rows="2" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500"></textarea>
                    </div>
                </div>
            </div>

            <!-- SEO & Metadata -->
            <div class="bg-white p-8 rounded-[24px] border border-slate-100 shadow-sm">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-globe text-cyan-500"></i> SEO & Pencarian
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Meta Deskripsi (Global)</label>
                        <textarea wire:model="meta_deskripsi" rows="2" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500"></textarea>
                        <p class="text-[10px] text-slate-400 mt-1 text-right">Maksimal 160 karakter disarankan.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Kata Kunci Utama</label>
                        <input wire:model="kata_kunci" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500" placeholder="komputer, gadget, teqara...">
                    </div>
                </div>
            </div>

            <!-- Integrasi API -->
            <div class="bg-white p-8 rounded-[24px] border border-slate-100 shadow-sm">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-plug text-fuchsia-500"></i> Integrasi API (Sensitif)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Payment Gateway Key</label>
                        <div class="relative">
                            <input wire:model="api_payment_gateway" type="password" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 pr-10 font-mono">
                            <i class="fa-solid fa-key absolute right-3 top-3 text-slate-400 text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">API Kurir (RajaOngkir)</label>
                        <div class="relative">
                            <input wire:model="api_kurir" type="password" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 pr-10 font-mono">
                            <i class="fa-solid fa-truck absolute right-3 top-3 text-slate-400 text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
