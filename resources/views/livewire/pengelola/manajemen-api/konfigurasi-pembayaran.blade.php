<div class="space-y-8 pb-20 animate-in fade-in zoom-in duration-500">
    
    <!-- HEADER SECTION -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-cyan-100 text-cyan-600 rounded-xl">
                    <i class="fa-solid fa-credit-card text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Gerbang <span class="text-cyan-600">Pembayaran</span></h1>
                    <p class="text-slate-500 font-medium text-sm">Konfigurasi API Midtrans, Xendit, dan metode pembayaran lainnya.</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
             <a href="https://dashboard.midtrans.com" target="_blank" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-slate-50 transition-colors">
                <i class="fa-solid fa-external-link-alt mr-2"></i> Midtrans Dash
            </a>
            <button wire:click="cekKoneksi" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/30">
                <i class="fa-solid fa-rotate mr-2"></i> Cek Koneksi
            </button>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- SIDEBAR STATUS -->
        <div class="space-y-6">
            <!-- Active Status Card -->
            <div class="bg-gradient-to-br from-indigo-900 to-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <i class="fa-solid fa-shield-halved text-9xl"></i>
                </div>
                <div class="relative z-10">
                    <span class="inline-block px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-500/30 mb-4">
                        Sistem Aktif
                    </span>
                    <h3 class="text-3xl font-black mb-1">Midtrans</h3>
                    <p class="text-slate-400 font-mono text-sm mb-6">{{ $midtrans_mode === 'production' ? 'Production Env' : 'Sandbox (Test)' }}</p>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-xs mb-1 text-slate-300 font-bold uppercase">
                                <span>Kesehatan API</span>
                                <span class="text-emerald-400">100%</span>
                            </div>
                            <div class="w-full bg-slate-700 rounded-full h-1.5">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                         <div>
                            <div class="flex justify-between text-xs mb-1 text-slate-300 font-bold uppercase">
                                <span>Success Rate</span>
                                <span class="text-blue-400">98.2%</span>
                            </div>
                            <div class="w-full bg-slate-700 rounded-full h-1.5">
                                <div class="bg-blue-500 h-1.5 rounded-full" style="width: 98%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documentation Link -->
            <div class="bg-indigo-50 border border-indigo-100 rounded-3xl p-6">
                <h4 class="font-bold text-indigo-900 flex items-center gap-2">
                    <i class="fa-solid fa-book-open"></i> Panduan Integrasi
                </h4>
                <p class="text-xs text-indigo-700 mt-2 leading-relaxed">
                    Pastikan `Server Key` dan `Client Key` sesuai dengan environment yang dipilih (Sandbox/Production). Jangan bagikan Server Key kepada siapapun.
                </p>
            </div>
        </div>

        <!-- CONFIGURATION FORMS -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- MIDTRANS CONFIG -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 md:p-10 relative overflow-hidden group hover:border-indigo-200 transition-all">
                <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Midtrans.png/1200px-Midtrans.png" class="h-12 grayscale">
                </div>

                <div class="flex items-center gap-4 mb-8 border-b border-slate-100 pb-6">
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm">
                        <i class="fa-solid fa-wallet text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-800">Konfigurasi Midtrans Snap</h2>
                        <p class="text-slate-500 text-xs mt-1">Gateway utama untuk Virtual Account, QRIS, dan Kartu Kredit.</p>
                    </div>
                    <div class="ml-auto">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="midtrans_mode" wire:true-value="production" wire:false-value="sandbox" class="sr-only peer">
                            <div class="w-24 h-8 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-['Sandbox'] peer-checked:after:content-['Production'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-7 after:w-12 after:flex after:items-center after:justify-center after:text-[8px] after:font-black after:uppercase after:transition-all peer-checked:bg-indigo-600 peer-checked:after:w-11 after:text-slate-500 peer-checked:after:text-indigo-600"></div>
                        </label>
                    </div>
                </div>

                <form wire:submit.prevent="simpanMidtrans" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest px-1">Merchant ID</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-solid fa-id-badge"></i></span>
                                <input type="text" wire:model="midtrans_id" class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300 transition-all" placeholder="G-12345678">
                            </div>
                        </div>
                         <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest px-1">Client Key (Frontend)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-solid fa-key"></i></span>
                                <input type="text" wire:model="midtrans_client" class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300 transition-all font-mono text-sm" placeholder="SB-Mid-client-...">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest px-1">Server Key (Backend Secret)</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-red-500 transition-colors"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" wire:model="midtrans_server" class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-red-500/10 placeholder:text-slate-300 transition-all font-mono text-sm" placeholder="SB-Mid-server-...">
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 px-2 py-1 bg-amber-100 text-amber-700 text-[9px] font-black rounded uppercase">Rahasia</div>
                        </div>
                        <p class="text-[10px] text-slate-400 px-1">Kunci ini digunakan untuk verifikasi notifikasi pembayaran. Jangan bagikan ke frontend.</p>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/20 active:scale-95 flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Konfigurasi
                        </button>
                    </div>
                </form>
            </div>

            <!-- XENDIT CONFIG -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 md:p-10 relative overflow-hidden group hover:border-cyan-200 transition-all opacity-80 hover:opacity-100">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600 shadow-sm">
                        <i class="fa-solid fa-money-bill-transfer text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-800">Konfigurasi Xendit</h2>
                        <p class="text-slate-500 text-xs mt-1">Opsional / Backup Gateway.</p>
                    </div>
                    <span class="ml-auto px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-black uppercase">Tidak Aktif</span>
                </div>

                <form wire:submit.prevent="simpanXendit" class="space-y-6 opacity-50 pointer-events-none filter blur-[1px]">
                     <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest px-1">Secret API Key</label>
                        <input type="password" wire:model="xendit_secret" class="w-full px-6 py-3.5 bg-slate-50 border-none rounded-2xl font-bold text-slate-800" placeholder="xnd_development_...">
                    </div>
                </form>
                 <div class="absolute inset-0 flex items-center justify-center z-10">
                    <button class="px-6 py-2 bg-white shadow-lg border border-slate-200 rounded-full text-xs font-bold text-slate-600 uppercase tracking-wider hover:text-cyan-600 hover:border-cyan-200">
                        Aktifkan Xendit
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>