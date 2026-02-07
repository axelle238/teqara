<div class="space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Hub Integrasi Eksternal</h1>
            <p class="text-slate-500 font-medium mt-1">Kelola koneksi layanan pihak ketiga dan API Gateway secara terpusat.</p>
        </div>
        <div class="flex gap-3">
            <button class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">
                <i class="fa-solid fa-rotate mr-2"></i> Refresh Status
            </button>
            <a href="{{ route('pengelola.api.dokumentasi') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/30">
                <i class="fa-solid fa-book mr-2"></i> Dokumentasi API
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Active Integrations -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-plug text-6xl text-emerald-500"></i>
            </div>
            <h3 class="text-slate-500 font-bold uppercase text-xs tracking-widest">Layanan Aktif</h3>
            <p class="text-3xl font-black text-slate-800 mt-2">12 <span class="text-sm font-bold text-slate-400">/ 15</span></p>
            <div class="mt-4 flex items-center gap-2 text-emerald-600 text-xs font-bold">
                <i class="fa-solid fa-circle-check"></i> 80% Operasional
            </div>
        </div>

        <!-- API Hits -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-chart-area text-6xl text-blue-500"></i>
            </div>
            <h3 class="text-slate-500 font-bold uppercase text-xs tracking-widest">Request Hari Ini</h3>
            <p class="text-3xl font-black text-slate-800 mt-2">84.2K</p>
            <div class="mt-4 flex items-center gap-2 text-blue-600 text-xs font-bold">
                <i class="fa-solid fa-arrow-trend-up"></i> +12.5% Traffic
            </div>
        </div>

        <!-- Error Rate -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-triangle-exclamation text-6xl text-amber-500"></i>
            </div>
            <h3 class="text-slate-500 font-bold uppercase text-xs tracking-widest">Tingkat Kesalahan</h3>
            <p class="text-3xl font-black text-slate-800 mt-2">0.05%</p>
            <div class="mt-4 flex items-center gap-2 text-emerald-600 text-xs font-bold">
                <i class="fa-solid fa-check"></i> Stabil
            </div>
        </div>

        <!-- Response Time -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-stopwatch text-6xl text-violet-500"></i>
            </div>
            <h3 class="text-slate-500 font-bold uppercase text-xs tracking-widest">Avg. Latency</h3>
            <p class="text-3xl font-black text-slate-800 mt-2">124ms</p>
            <div class="mt-4 flex items-center gap-2 text-slate-500 text-xs font-bold">
                <i class="fa-solid fa-server"></i> Server Optim
            </div>
        </div>
    </div>

    <!-- Integration Categories -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Payment Gateways -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-cyan-100 flex items-center justify-center text-cyan-600">
                        <i class="fa-solid fa-credit-card text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">Payment Gateway</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-wide">Proses Pembayaran</p>
                    </div>
                </div>
                <a href="{{ route('pengelola.api.pembayaran') }}" wire:navigate class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest">Konfigurasi</a>
            </div>
            <div class="divide-y divide-slate-100">
                <!-- Midtrans -->
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Midtrans.png/1200px-Midtrans.png" alt="Midtrans" class="h-6 w-auto grayscale opacity-70">
                        <div>
                            <h4 class="font-bold text-sm text-slate-800">Midtrans Snap</h4>
                            <p class="text-[10px] text-slate-500">Production Mode</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-1 rounded-md bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase">Terhubung</span>
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    </div>
                </div>
                <!-- Xendit -->
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4">
                         <div class="h-6 w-16 bg-slate-200 rounded flex items-center justify-center text-[10px] font-bold text-slate-400">XENDIT</div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-800">Xendit API</h4>
                            <p class="text-[10px] text-slate-500">Backup Channel</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-1 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold uppercase">Non-Aktif</span>
                        <div class="w-10 h-5 bg-slate-200 rounded-full relative cursor-pointer">
                            <div class="w-3 h-3 bg-white rounded-full absolute top-1 left-1 shadow-sm"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logistics -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600">
                        <i class="fa-solid fa-truck-fast text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">Logistik & Kurir</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-wide">Cek Ongkir & Resi</p>
                    </div>
                </div>
                <a href="{{ route('pengelola.api.logistik') }}" wire:navigate class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest">Konfigurasi</a>
            </div>
            <div class="divide-y divide-slate-100">
                <!-- RajaOngkir -->
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="h-6 w-6 bg-slate-200 rounded-full flex items-center justify-center"><i class="fa-solid fa-crown text-slate-500 text-xs"></i></div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-800">RajaOngkir Pro</h4>
                            <p class="text-[10px] text-slate-500">Exp: 21 Des 2026</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-1 rounded-md bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase">Terhubung</span>
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    </div>
                </div>
                <!-- Biteship -->
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4">
                         <div class="h-6 w-6 bg-slate-200 rounded-full flex items-center justify-center"><i class="fa-solid fa-ship text-slate-500 text-xs"></i></div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-800">Biteship</h4>
                            <p class="text-[10px] text-slate-500">Order Booking</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-1 rounded-md bg-amber-100 text-amber-700 text-[10px] font-bold uppercase">Maintenance</span>
                        <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Communication -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                        <i class="fa-brands fa-whatsapp text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">Komunikasi</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-wide">WA Gateway & SMTP</p>
                    </div>
                </div>
                <a href="{{ route('pengelola.api.whatsapp') }}" wire:navigate class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest">Konfigurasi</a>
            </div>
            <div class="divide-y divide-slate-100">
                <!-- Fonnte/Wablas -->
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="h-8 w-8 bg-green-500 rounded-full flex items-center justify-center text-white"><i class="fa-brands fa-whatsapp"></i></div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-800">WhatsApp Business API</h4>
                            <p class="text-[10px] text-slate-500">Notifikasi OTP & Order</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-1 rounded-md bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase">Terhubung</span>
                         <span class="text-[10px] font-medium text-slate-500">Quota: Unlimited</span>
                    </div>
                </div>
                <!-- SMTP -->
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="h-8 w-8 bg-indigo-500 rounded-full flex items-center justify-center text-white"><i class="fa-solid fa-paper-plane"></i></div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-800">SMTP Server (Mailgun)</h4>
                            <p class="text-[10px] text-slate-500">Email Transaksional</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-1 rounded-md bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase">Terhubung</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Developer Tools -->
         <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600">
                        <i class="fa-solid fa-code text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">Developer Tools</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-wide">Akses Internal</p>
                    </div>
                </div>
                <a href="{{ route('pengelola.api.kunci') }}" wire:navigate class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest">Kelola Key</a>
            </div>
            <div class="divide-y divide-slate-100">
                 <!-- API Keys -->
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <i class="fa-solid fa-key text-slate-400"></i>
                        <div>
                            <h4 class="font-bold text-sm text-slate-800">Kunci API Internal</h4>
                            <p class="text-[10px] text-slate-500">Untuk Mobile App & Pihak Ketiga</p>
                        </div>
                    </div>
                     <h4 class="font-black text-xl text-slate-800">5 <span class="text-xs font-medium text-slate-400">Active Keys</span></h4>
                </div>
                 <!-- Webhooks -->
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <i class="fa-solid fa-globe text-slate-400"></i>
                        <div>
                            <h4 class="font-bold text-sm text-slate-800">Webhook Events</h4>
                            <p class="text-[10px] text-slate-500">Callback status pesanan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 rounded bg-slate-100 text-slate-600 text-[10px] font-bold">payment.success</span>
                        <span class="px-2 py-1 rounded bg-slate-100 text-slate-600 text-[10px] font-bold">order.shipped</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
