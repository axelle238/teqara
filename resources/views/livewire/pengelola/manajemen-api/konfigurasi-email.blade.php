<div class="space-y-8 pb-20 animate-in fade-in zoom-in duration-500">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Server <span class="text-indigo-600">Email</span></h1>
            <p class="text-slate-500 font-medium">Konfigurasi SMTP untuk notifikasi transaksi dan sistem.</p>
        </div>
        <div class="flex gap-3">
            <button wire:click="simpan" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg shadow-slate-900/20 active:scale-95">
                <i class="fa-solid fa-save mr-2"></i> Simpan Konfigurasi
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-indigo-600 to-violet-600 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <i class="fa-solid fa-paper-plane text-9xl"></i>
                </div>
                <div class="relative z-10">
                    <h3 class="text-2xl font-black mb-2">Notifikasi Real-time</h3>
                    <p class="text-indigo-100 text-sm leading-relaxed mb-6">
                        Sistem menggunakan protokol SMTP standar untuk mengirimkan invoice, reset password, dan notifikasi pesanan kepada pelanggan secara instan.
                    </p>
                    <div class="flex items-center gap-2 text-xs font-bold bg-white/10 p-3 rounded-xl border border-white/10">
                        <i class="fa-solid fa-circle-check text-emerald-400"></i>
                        <span>Support Gmail, Outlook, AWS SES</span>
                    </div>
                </div>
            </div>

            <!-- Test Connection -->
            <div class="bg-white rounded-[2rem] border border-slate-200 p-6 shadow-sm">
                <h4 class="font-black text-slate-900 text-sm uppercase tracking-widest mb-4">Uji Koneksi</h4>
                <div class="space-y-3">
                    <input wire:model="test_email" type="email" placeholder="Email Penerima Test" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
                    <button wire:click="kirimTestEmail" class="w-full py-3 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-100 transition-all">
                        <i class="fa-solid fa-bolt mr-2"></i> Kirim Test
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Config -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">SMTP Host</label>
                        <input wire:model="smtp_host" type="text" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500" placeholder="smtp.gmail.com">
                        @error('smtp_host') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">SMTP Port</label>
                        <input wire:model="smtp_port" type="text" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500" placeholder="587">
                        @error('smtp_port') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Username</label>
                        <input wire:model="smtp_username" type="text" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500" placeholder="email@domain.com">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Password</label>
                        <input wire:model="smtp_password" type="password" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div class="space-y-2 mb-8">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Enkripsi</label>
                    <select wire:model="smtp_encryption" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500">
                        <option value="tls">TLS (Recommended)</option>
                        <option value="ssl">SSL</option>
                        <option value="">None</option>
                    </select>
                </div>

                <div class="border-t border-slate-100 pt-8 mt-8">
                    <h4 class="font-black text-slate-900 text-sm uppercase tracking-widest mb-6">Identitas Pengirim</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Pengirim</label>
                            <input wire:model="mail_from_address" type="email" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500" placeholder="noreply@teqara.com">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Pengirim</label>
                            <input wire:model="mail_from_name" type="text" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500" placeholder="Teqara Official">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
