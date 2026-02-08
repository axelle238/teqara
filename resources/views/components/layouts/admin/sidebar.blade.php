<aside 
    class="fixed inset-y-0 left-0 z-50 w-72 bg-[#0b1120] text-slate-300 transition-transform duration-300 ease-in-out border-r border-white/5 shadow-2xl flex flex-col font-sans"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-20'"
>
    <!-- 1. BRAND HEADER -->
    <div class="h-20 flex items-center justify-center relative overflow-hidden border-b border-white/5 shrink-0 bg-[#0f172a]">
        <!-- Logo Expanded -->
        <a href="{{ route('pengelola.beranda') }}" wire:navigate class="flex items-center gap-3 relative z-10 transition-opacity duration-300 group" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 hidden'">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform">
                T
            </div>
            <div class="leading-none">
                <span class="block text-xl font-black text-white tracking-tight uppercase group-hover:text-indigo-400 transition-colors">TEQARA</span>
                <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-[0.3em]">Enterprise v16</span>
            </div>
        </a>

        <!-- Logo Collapsed -->
        <a href="{{ route('pengelola.beranda') }}" wire:navigate class="absolute inset-0 flex items-center justify-center transition-opacity duration-300" :class="sidebarOpen ? 'opacity-0 hidden' : 'opacity-100'">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-500/20">
                T
            </div>
        </a>
    </div>

    <!-- 2. NAVIGATION MENU (SCROLLABLE) -->
    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-6 px-3 space-y-1.5 custom-scrollbar-dark" x-data="{ activeMenu: '{{ Request::segment(2) }}' }">
        
        <!-- DASHBOARD & UTAMA -->
        <div class="text-indigo-400">
            <x-layouts.admin.menu-item 
                route="pengelola.beranda" 
                icon="fa-solid fa-chart-pie" 
                label="Panel Eksekutif" 
                :active="request()->routeIs('pengelola.beranda')" 
            />
            <x-layouts.admin.menu-item 
                route="pengelola.notifikasi.index" 
                icon="fa-solid fa-bell" 
                label="Pusat Notifikasi" 
                :active="request()->routeIs('pengelola.notifikasi.*')"
                badge="{{ \App\Models\Notifikasi::whereNull('dibaca_pada')->count() > 0 ? \App\Models\Notifikasi::whereNull('dibaca_pada')->count() : '' }}"
            />
        </div>

        <!-- DIVIDER: OPERASIONAL -->
        <div class="mt-6 mb-2 px-4 flex items-center gap-3" :class="!sidebarOpen && 'hidden'">
            <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest flex-1">Bisnis Utama</span>
            <div class="h-px bg-slate-800 w-8"></div>
        </div>

        <!-- CMS TOKO (PINK) -->
        <div class="text-pink-400 group-cms">
            <x-layouts.admin.menu-group label="Etalase Toko" icon="fa-solid fa-store" id="cms" :active="request()->is('pengelola/cms*')">
                <x-layouts.admin.sub-menu route="pengelola.toko.beranda" label="Ringkasan CMS" icon="fa-solid fa-gauge" />
                <x-layouts.admin.sub-menu route="pengelola.toko.berita" label="Berita & Artikel" icon="fa-solid fa-newspaper" />
                <x-layouts.admin.sub-menu route="pengelola.toko.konten" label="Konten Halaman" icon="fa-solid fa-pager" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- PRODUK (CYAN) -->
        <div class="text-cyan-400 group-produk">
            <x-layouts.admin.menu-group label="Produk & Stok" icon="fa-solid fa-laptop-code" id="produk" :active="request()->is('pengelola/produk*') || request()->routeIs('pengelola.kategori') || request()->routeIs('pengelola.merek')">
                <x-layouts.admin.sub-menu route="pengelola.produk.beranda" label="Dasbor Inventaris" icon="fa-solid fa-chart-column" />
                <x-layouts.admin.sub-menu route="pengelola.produk.katalog" label="Katalog Produk" icon="fa-solid fa-box-open" />
                <x-layouts.admin.sub-menu route="pengelola.produk.tambah" label="Registrasi Unit" icon="fa-solid fa-plus" />
                <x-layouts.admin.sub-menu route="pengelola.kategori" label="Kategori" icon="fa-solid fa-layer-group" />
                <x-layouts.admin.sub-menu route="pengelola.merek" label="Merek & Brand" icon="fa-solid fa-copyright" />
                <div class="h-px bg-white/5 my-2 mx-3"></div>
                <x-layouts.admin.sub-menu route="pengelola.produk.stok" label="Kontrol Stok" icon="fa-solid fa-boxes-stacked" />
                <x-layouts.admin.sub-menu route="pengelola.produk.gudang" label="Lokasi Gudang" icon="fa-solid fa-warehouse" />
                <x-layouts.admin.sub-menu route="pengelola.produk.so.riwayat" label="Stock Opname" icon="fa-solid fa-clipboard-check" />
                <x-layouts.admin.sub-menu route="pengelola.produk.seri" label="Nomor Seri (SN)" icon="fa-solid fa-barcode" />
                <div class="h-px bg-white/5 my-2 mx-3"></div>
                <x-layouts.admin.sub-menu route="pengelola.produk.spesifikasi" label="Spesifikasi Teknis" icon="fa-solid fa-microchip" />
                <x-layouts.admin.sub-menu route="pengelola.produk.garansi" label="Klaim Garansi" icon="fa-solid fa-medal" />
                <x-layouts.admin.sub-menu route="pengelola.produk.promo.flash-sale" label="Flash Sale" icon="fa-solid fa-bolt" />
                <x-layouts.admin.sub-menu route="pengelola.produk.label" label="Cetak Label" icon="fa-solid fa-print" />
                <x-layouts.admin.sub-menu route="pengelola.produk.analitik" label="Analisa Produk" icon="fa-solid fa-magnifying-glass-chart" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- PESANAN (EMERALD) -->
        <div class="text-emerald-400 group-pesanan">
            <x-layouts.admin.menu-group label="Pesanan & POS" icon="fa-solid fa-cart-shopping" id="pesanan" :active="request()->is('pengelola/pesanan*')">
                <x-layouts.admin.sub-menu route="pengelola.pesanan.beranda" label="Dasbor Penjualan" icon="fa-solid fa-chart-line" />
                <x-layouts.admin.sub-menu route="pengelola.pesanan.daftar" label="Semua Pesanan" icon="fa-solid fa-list-check" />
                <x-layouts.admin.sub-menu route="pengelola.pesanan.verifikasi" label="Verifikasi Bayar" icon="fa-solid fa-money-check-dollar" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- KEUANGAN (AMBER) -->
        <div class="text-amber-400 group-keuangan">
            <x-layouts.admin.menu-group label="Keuangan" icon="fa-solid fa-wallet" id="transaksi" :active="request()->is('pengelola/transaksi*')">
                <x-layouts.admin.sub-menu route="pengelola.transaksi.beranda" label="Arus Kas (Cashflow)" icon="fa-solid fa-coins" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- LOGISTIK (ORANGE) -->
        <div class="text-orange-400 group-logistik">
            <x-layouts.admin.menu-group label="Logistik" icon="fa-solid fa-truck-fast" id="logistik" :active="request()->is('pengelola/logistik*')">
                <x-layouts.admin.sub-menu route="pengelola.logistik.beranda" label="Pantau Pengiriman" icon="fa-solid fa-map-location-dot" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- DIVIDER: RELASI -->
        <div class="mt-6 mb-2 px-4 flex items-center gap-3" :class="!sidebarOpen && 'hidden'">
            <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest flex-1">Relasi & SDM</span>
            <div class="h-px bg-slate-800 w-8"></div>
        </div>

        <!-- PELANGGAN (BLUE) -->
        <div class="text-blue-400 group-pelanggan">
            <x-layouts.admin.menu-group label="Pelanggan (CRM)" icon="fa-solid fa-users" id="pelanggan" :active="request()->is('pengelola/pelanggan*')">
                <x-layouts.admin.sub-menu route="pengelola.pelanggan.beranda" label="CRM Dashboard" icon="fa-solid fa-chart-pie" />
                <x-layouts.admin.sub-menu route="pengelola.pelanggan.daftar" label="Database Member" icon="fa-solid fa-address-book" />
                <x-layouts.admin.sub-menu route="pengelola.pelanggan.ulasan" label="Ulasan & Rating" icon="fa-solid fa-star" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- VENDOR (TEAL) -->
        <div class="text-teal-400 group-vendor">
            <x-layouts.admin.menu-group label="Vendor & B2B" icon="fa-solid fa-building-shield" id="vendor" :active="request()->is('pengelola/vendor*')">
                <x-layouts.admin.sub-menu route="pengelola.vendor.beranda" label="Dasbor Supplier" icon="fa-solid fa-industry" />
                <x-layouts.admin.sub-menu route="pengelola.vendor.daftar" label="Direktori Vendor" icon="fa-solid fa-book-open" />
                <x-layouts.admin.sub-menu route="pengelola.vendor.penawaran" label="Penawaran Masuk" icon="fa-solid fa-file-invoice" />
                <x-layouts.admin.sub-menu route="pengelola.produk.pembelian.riwayat" label="Purchase Order (PO)" icon="fa-solid fa-file-contract" />
                <x-layouts.admin.sub-menu route="pengelola.produk.pembelian.baru" label="Buat PO Baru" icon="fa-solid fa-cart-plus" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- HRD (VIOLET) -->
        <div class="text-violet-400 group-hrd">
            <x-layouts.admin.menu-group label="SDM & HRD" icon="fa-solid fa-id-card-clip" id="hrd" :active="request()->is('pengelola/hrd*')">
                <x-layouts.admin.sub-menu route="pengelola.hrd.beranda" label="HR Dashboard" icon="fa-solid fa-users-viewfinder" />
                <x-layouts.admin.sub-menu route="pengelola.pengguna.hrd" label="Direktori Karyawan" icon="fa-solid fa-user-tie" />
                <x-layouts.admin.sub-menu route="pengelola.hrd.struktur" label="Struktur Organisasi" icon="fa-solid fa-sitemap" />
                <x-layouts.admin.sub-menu route="pengelola.hrd.akses" label="Hak Akses (RBAC)" icon="fa-solid fa-key" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- LAYANAN (LIME) -->
        <div class="text-lime-400 group-layanan">
            <x-layouts.admin.menu-group label="Helpdesk" icon="fa-solid fa-headset" id="layanan" :active="request()->is('pengelola/layanan*')">
                <x-layouts.admin.sub-menu route="pengelola.cs.beranda" label="Helpdesk Center" icon="fa-solid fa-life-ring" />
                <x-layouts.admin.sub-menu route="pengelola.cs.tiket" label="Tiket Komplain" icon="fa-solid fa-ticket" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- DIVIDER: INFRASTRUKTUR -->
        <div class="mt-6 mb-2 px-4 flex items-center gap-3" :class="!sidebarOpen && 'hidden'">
            <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest flex-1">Infrastruktur IT</span>
            <div class="h-px bg-slate-800 w-8"></div>
        </div>

        <!-- KEAMANAN (RED) -->
        <div class="text-red-500 group-keamanan">
            <x-layouts.admin.menu-group label="Cyber Security" icon="fa-solid fa-shield-cat" id="keamanan" :active="request()->is('pengelola/keamanan*')">
                <x-layouts.admin.sub-menu route="pengelola.keamanan.beranda" label="Security Center" icon="fa-solid fa-lock" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.dasbor" label="SOC Dashboard" icon="fa-solid fa-globe" />
                <div class="h-px bg-white/5 my-2 mx-3"></div>
                <x-layouts.admin.sub-menu route="pengelola.keamanan.firewall" label="Firewall WAF" icon="fa-solid fa-fire" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.pemindai" label="Scanner Malware" icon="fa-solid fa-bug" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.siem" label="SIEM Logs" icon="fa-solid fa-file-waveform" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.integritas" label="File Integrity" icon="fa-solid fa-file-shield" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.ueba" label="Analisa Perilaku" icon="fa-solid fa-user-secret" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.forensik" label="Forensik Digital" icon="fa-solid fa-magnifying-glass" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.honeypot" label="Honeypot" icon="fa-solid fa-flask" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.ancaman" label="Intel Ancaman" icon="fa-solid fa-skull" />
                <div class="h-px bg-white/5 my-2 mx-3"></div>
                <x-layouts.admin.sub-menu route="pengelola.keamanan.pam" label="Privilege Access" icon="fa-solid fa-id-badge" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.sesi" label="Monitor Sesi" icon="fa-solid fa-desktop" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.dlp" label="Cegah Kebocoran" icon="fa-solid fa-filter" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.irp" label="Respon Insiden" icon="fa-solid fa-briefcase-medical" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.zerotrust" label="Zero Trust" icon="fa-solid fa-handshake-slash" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.edr" label="Endpoint Detection" icon="fa-solid fa-laptop-medical" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.cadangan" label="Backup Data" icon="fa-solid fa-database" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- API (FUSCHIA) -->
        <div class="text-fuchsia-400 group-api">
            <x-layouts.admin.menu-group label="Integrasi API" icon="fa-solid fa-code" id="api" :active="request()->is('pengelola/api*')">
                <x-layouts.admin.sub-menu route="pengelola.api.pusat" label="Gateway Hub" icon="fa-solid fa-network-wired" />
                <x-layouts.admin.sub-menu route="pengelola.api.pembayaran" label="Payment Gateway" icon="fa-solid fa-credit-card" />
                <x-layouts.admin.sub-menu route="pengelola.api.logistik" label="Kurir Ekspedisi" icon="fa-solid fa-truck-plane" />
                <x-layouts.admin.sub-menu route="pengelola.api.whatsapp" label="WhatsApp API" icon="fa-brands fa-whatsapp" />
                <x-layouts.admin.sub-menu route="pengelola.api.email" label="SMTP Server" icon="fa-solid fa-server" />
                <x-layouts.admin.sub-menu route="pengelola.api.kunci" label="Kunci API" icon="fa-solid fa-key" />
                <x-layouts.admin.sub-menu route="pengelola.api.log" label="Log Akses API" icon="fa-solid fa-terminal" />
                <x-layouts.admin.sub-menu route="pengelola.api.dokumentasi" label="Dokumentasi" icon="fa-solid fa-book" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- SISTEM (SLATE) -->
        <div class="text-slate-400 group-sistem">
            <x-layouts.admin.menu-group label="Konfigurasi" icon="fa-solid fa-gears" id="sistem" :active="request()->is('pengelola/sistem*') || request()->is('pengelola/laporan*')">
                <x-layouts.admin.sub-menu route="pengelola.sistem.beranda" label="Kontrol Utama" icon="fa-solid fa-sliders" />
                <x-layouts.admin.sub-menu route="pengelola.sistem.pusat" label="Setting Global" icon="fa-solid fa-globe" />
                <x-layouts.admin.sub-menu route="pengelola.sistem.kesehatan" label="Health Check" icon="fa-solid fa-heart-pulse" />
                <x-layouts.admin.sub-menu route="pengelola.voucher" label="Kupon & Voucher" icon="fa-solid fa-ticket-simple" />
                <div class="h-px bg-white/5 my-2 mx-3"></div>
                <x-layouts.admin.sub-menu route="pengelola.laporan.beranda" label="Pusat Laporan" icon="fa-solid fa-file-contract" />
                <x-layouts.admin.sub-menu route="pengelola.pengaturan.log" label="Audit Log" icon="fa-solid fa-clock-rotate-left" />
            </x-layouts.admin.menu-group>
        </div>

    </nav>

    <!-- 3. FOOTER USER -->
    <div class="p-4 border-t border-white/5 bg-[#080c16]">
        <div class="flex items-center gap-3 transition-all" :class="!sidebarOpen && 'justify-center'">
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md shrink-0 ring-2 ring-white/10">
                {{ substr(auth()->user()->nama ?? 'A', 0, 1) }}
            </div>
            <div class="overflow-hidden" :class="!sidebarOpen && 'hidden'">
                <p class="text-xs font-black text-white truncate w-32">{{ auth()->user()->nama ?? 'Administrator' }}</p>
                <p class="text-[10px] font-medium text-slate-500 truncate">Super Admin</p>
            </div>
            <a href="{{ route('logout') }}" class="ml-auto w-8 h-8 rounded-lg bg-white/5 text-slate-400 hover:bg-rose-500 hover:text-white flex items-center justify-center transition-all" :class="!sidebarOpen && 'hidden'" title="Keluar Sistem">
                <i class="fa-solid fa-power-off text-xs"></i>
            </a>
        </div>
    </div>
</aside>
