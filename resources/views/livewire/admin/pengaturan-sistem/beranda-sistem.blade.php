<div class="space-y-12 pb-32" x-data="{ tab: 'identitas' }">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">INFRASTRUKTUR <span class="text-cyan-600">SISTEM</span></h1>
            <p class="text-slate-500 font-medium text-lg">Pusat kendali konfigurasi global, integrasi API, dan parameter operasional.</p>
        </div>
        <div class="flex gap-2 bg-slate-100 p-1.5 rounded-2xl">
            <button @click="tab = 'identitas'" :class="tab === 'identitas' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Identitas & Ops</button>
            <button @click="tab = 'seo'" :class="tab === 'seo' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">SEO & Meta</button>
            <button @click="tab = 'api'" :class="tab === 'api' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Integrasi API</button>
        </div>
    </div>

    <form wire:submit.prevent="simpan">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Config Area -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Tab: Identitas & Operasional -->
                <div x-show="tab === 'identitas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white rounded-[40px] shadow-sm border border-slate-100 p-10 space-y-8">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest border-b border-slate-100 pb-4">Profil Bisnis Utama</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Brand / Toko</label>
                            <input wire:model="nama_toko" type="text" class="w-full bg-slate-50 border-none rounded-xl font-bold text-slate-900 focus:ring-2 focus:ring-cyan-500 p-4">
                            @error('nama_toko') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Resmi</label>
                            <input wire:model="email_kontak" type="email" class="w-full bg-slate-50 border-none rounded-xl font-bold text-slate-900 focus:ring-2 focus:ring-cyan-500 p-4">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Hotline WhatsApp</label>
                            <input wire:model="nomor_wa" type="text" class="w-full bg-slate-50 border-none rounded-xl font-bold text-slate-900 focus:ring-2 focus:ring-cyan-500 p-4" placeholder="628...">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Mata Uang Dasar</label>
                            <select wire:model="mata_uang" class="w-full bg-slate-50 border-none rounded-xl font-bold text-slate-900 focus:ring-2 focus:ring-cyan-500 p-4">
                                <option value="IDR">IDR (Rupiah Indonesia)</option>
                                <option value="USD">USD (Dolar Amerika)</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Lokasi Fisik HQ</label>
                        <textarea wire:model="alamat_toko" rows="3" class="w-full bg-slate-50 border-none rounded-xl font-medium text-slate-900 focus:ring-2 focus:ring-cyan-500 p-4"></textarea>
                    </div>

                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest border-b border-slate-100 pb-4 pt-4">Jadwal Operasional</h3>
                    <div class="grid grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Jam Buka</label>
                            <input wire:model="jam_buka" type="time" class="w-full bg-slate-50 border-none rounded-xl font-bold text-slate-900 focus:ring-2 focus:ring-cyan-500 p-4">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Jam Tutup</label>
                            <input wire:model="jam_tutup" type="time" class="w-full bg-slate-50 border-none rounded-xl font-bold text-slate-900 focus:ring-2 focus:ring-cyan-500 p-4">
                        </div>
                    </div>
                </div>

                <!-- Tab: SEO & Metadata -->
                <div x-show="tab === 'seo'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white rounded-[40px] shadow-sm border border-slate-100 p-10 space-y-8" style="display: none;">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest border-b border-slate-100 pb-4">Optimasi Mesin Pencari (SEO)</h3>
                    
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Meta Deskripsi Global</label>
                        <textarea wire:model="meta_deskripsi" rows="4" class="w-full bg-slate-50 border-none rounded-xl font-medium text-slate-900 focus:ring-2 focus:ring-cyan-500 p-4" placeholder="Deskripsi singkat toko untuk hasil pencarian Google..."></textarea>
                        <p class="text-[10px] text-slate-400 px-1">Maksimal 160 karakter direkomendasikan.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kata Kunci (Keywords)</label>
                        <input wire:model="kata_kunci" type="text" class="w-full bg-slate-50 border-none rounded-xl font-bold text-slate-900 focus:ring-2 focus:ring-cyan-500 p-4" placeholder="komputer, gadget, murah...">
                        <p class="text-[10px] text-slate-400 px-1">Pisahkan dengan koma.</p>
                    </div>
                </div>

                <!-- Tab: API Integrasi -->
                <div x-show="tab === 'api'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white rounded-[40px] shadow-sm border border-slate-100 p-10 space-y-8" style="display: none;">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest border-b border-slate-100 pb-4">Konektor Layanan Pihak Ketiga</h3>
                    
                    <div class="space-y-6">
                        <div class="p-6 bg-slate-50 rounded-3xl border border-slate-200">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    </div>
                                    <span class="font-black text-slate-900 text-sm uppercase">Payment Gateway</span>
                                </div>
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[9px] font-black uppercase tracking-widest">Aktif</span>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kunci API Server (Server Key)</label>
                                <input wire:model="api_payment_gateway" type="password" class="w-full bg-white border border-slate-200 rounded-xl font-mono text-slate-900 focus:ring-2 focus:ring-cyan-500 p-3" placeholder="SB-Mid-server-xxxx">
                            </div>
                        </div>

                        <div class="p-6 bg-slate-50 rounded-3xl border border-slate-200">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </div>
                                    <span class="font-black text-slate-900 text-sm uppercase">Layanan Kurir (RajaOngkir)</span>
                                </div>
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[9px] font-black uppercase tracking-widest">Aktif</span>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kunci API (API Key)</label>
                                <input wire:model="api_kurir" type="password" class="w-full bg-white border border-slate-200 rounded-xl font-mono text-slate-900 focus:ring-2 focus:ring-cyan-500 p-3" placeholder="rajaongkir-key-xxxx">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-10 py-4 bg-slate-900 text-white rounded-[20px] font-black text-xs uppercase tracking-[0.2em] hover:bg-cyan-600 hover:scale-105 transition-all shadow-xl">
                        SIMPAN KONFIGURASI
                    </button>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-cyan-900 p-8 rounded-[40px] text-white relative overflow-hidden shadow-2xl">
                    <div class="relative z-10">
                        <h4 class="font-black text-cyan-200 uppercase tracking-widest text-xs mb-6">Status Server</h4>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-cyan-100 font-medium">Versi Teqara</span>
                                <span class="font-black text-white">v16.4 Enterprise</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-cyan-100 font-medium">Framework</span>
                                <span class="font-black text-white">Laravel 12</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-cyan-100 font-medium">Database</span>
                                <span class="font-black text-white">MySQL 8.0</span>
                            </div>
                            <div class="h-px bg-white/10 my-2"></div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-cyan-100 font-medium">Lingkungan</span>
                                <span class="px-3 py-1 bg-emerald-500 text-white rounded-lg text-[10px] font-black uppercase tracking-widest">PRODUCTION</span>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-cyan-500/20 rounded-full blur-[60px]"></div>
                </div>

                <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm">
                    <h4 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Panduan Cepat</h4>
                    <ul class="space-y-4 text-xs text-slate-600 font-medium leading-relaxed">
                        <li class="flex gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 mt-1.5 shrink-0"></span>
                            Perubahan identitas toko akan langsung terlihat di halaman publik dan invoice.
                        </li>
                        <li class="flex gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 mt-1.5 shrink-0"></span>
                            Pastikan API Key valid. Kunci yang salah akan memblokir transaksi.
                        </li>
                        <li class="flex gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 mt-1.5 shrink-0"></span>
                            Meta deskripsi yang baik meningkatkan peringkat di Google.
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </form>
</div>
