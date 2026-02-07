<div class="space-y-8 pb-20 animate-in fade-in zoom-in duration-500">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">WhatsApp <span class="text-emerald-600">Gateway</span></h1>
            <p class="text-slate-500 font-medium">Integrasi notifikasi pesanan via WhatsApp API.</p>
        </div>
        <div class="flex gap-3">
            <button wire:click="simpan" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-slate-900/20 active:scale-95">
                <i class="fa-solid fa-save mr-2"></i> Simpan Konfigurasi
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-emerald-600 to-teal-600 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <i class="fa-brands fa-whatsapp text-9xl"></i>
                </div>
                <div class="relative z-10">
                    <h3 class="text-2xl font-black mb-2">Instant Alert</h3>
                    <p class="text-emerald-100 text-sm leading-relaxed mb-6">
                        Kirim notifikasi status pesanan, kode OTP, dan promo langsung ke WhatsApp pelanggan. Tingkatkan trust dan engagement.
                    </p>
                    <div class="flex items-center gap-2 text-xs font-bold bg-white/10 p-3 rounded-xl border border-white/10">
                        <i class="fa-solid fa-robot text-emerald-300"></i>
                        <span>Bot Auto-Reply Ready</span>
                    </div>
                </div>
            </div>

            <!-- Test Connection -->
            <div class="bg-white rounded-[2rem] border border-slate-200 p-6 shadow-sm">
                <h4 class="font-black text-slate-900 text-sm uppercase tracking-widest mb-4">Uji Kirim Pesan</h4>
                <div class="space-y-3">
                    <input wire:model="test_number" type="tel" placeholder="08123xxxx (Nomor Tujuan)" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500">
                    <button wire:click="kirimTestWA" class="w-full py-3 bg-emerald-50 text-emerald-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-emerald-100 transition-all">
                        <i class="fa-brands fa-whatsapp mr-2"></i> Kirim Test
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Config -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 md:p-10">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Provider Gateway</label>
                        <select wire:model="wa_provider" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                            <option value="fonnte">Fonnte (Recommended)</option>
                            <option value="twilio">Twilio</option>
                            <option value="watzap">Watzap</option>
                        </select>
                        <p class="text-[10px] text-slate-400 px-1">* Saat ini integrasi native tersedia untuk Fonnte.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">API Token / Key</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors"><i class="fa-solid fa-key"></i></span>
                            <input wire:model="wa_api_key" type="password" class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500" placeholder="Masukkan Token API Provider">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">API Endpoint URL</label>
                        <input wire:model="wa_endpoint" type="url" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 font-mono text-sm" placeholder="https://api.fonnte.com/send">
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-8 mt-8">
                    <h4 class="font-black text-slate-900 text-sm uppercase tracking-widest mb-6">Template Pesan Otomatis</h4>
                    
                    <div class="space-y-6">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <h5 class="text-xs font-bold text-slate-700 mb-2">Pesanan Baru (Admin)</h5>
                            <p class="text-xs text-slate-500 font-mono bg-white p-3 rounded-xl border border-slate-200">
                                Halo Admin, Pesanan Baru #{no_invoice} sebesar Rp {total} menunggu diproses.
                            </p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <h5 class="text-xs font-bold text-slate-700 mb-2">Pembayaran Sukses (Pelanggan)</h5>
                            <p class="text-xs text-slate-500 font-mono bg-white p-3 rounded-xl border border-slate-200">
                                Halo {nama}, Terima kasih! Pembayaran untuk #{no_invoice} telah kami terima. Kami akan segera memproses pesanan Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
