<aside 
    class="fixed inset-y-0 left-0 z-50 w-72 bg-[#0b1120] text-slate-300 transition-transform duration-300 ease-in-out border-r border-white/5 shadow-2xl flex flex-col font-sans"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-20'"
>
    <!-- 1. HEADER LOGO (HIGH-TECH) -->
    <div class="h-20 flex items-center justify-center relative overflow-hidden border-b border-white/5 shrink-0 bg-[#0f172a]">
        <!-- Animasi Latar Belakang -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-indigo-500 via-transparent to-transparent"></div>
        </div>

        <!-- Logo Saat Sidebar Terbuka -->
        <a href="{{ route('pengelola.beranda') }}" wire:navigate class="flex items-center gap-3 relative z-10 transition-opacity duration-300 group" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 hidden'">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-500/20 group-hover:rotate-12 transition-transform">
                T
            </div>
            <div class="leading-none">
                <span class="block text-xl font-black text-white tracking-tight uppercase group-hover:text-indigo-400 transition-colors">TEQARA</span>
                <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-[0.3em]">Sistem Enterprise</span>
            </div>
        </a>

        <!-- Logo Saat Sidebar Tertutup -->
        <a href="{{ route('pengelola.beranda') }}" wire:navigate class="absolute inset-0 flex items-center justify-center transition-opacity duration-300" :class="sidebarOpen ? 'opacity-0 hidden' : 'opacity-100'">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-500/20">
                T
            </div>
        </a>
    </div>

    <!-- 2. NAVIGASI UTAMA (GULIR HALUS) -->
    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-6 px-3 space-y-1.5 custom-scrollbar-dark">
        
        <!-- BAGIAN: DASBOR EKSEKUTIF -->
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

        <div class="my-4 border-t border-white/5 mx-2" :class="!sidebarOpen && 'hidden'"></div>
        <p class="px-4 text-[9px] font-black text-slate-600 uppercase tracking-widest mb-2 transition-opacity" :class="!sidebarOpen && 'hidden'">Manajemen Operasional</p>

        <!-- MODUL: ETALASE TOKO (PINK) -->
        <div class="text-pink-400">
            <x-layouts.admin.menu-group label="Halaman Toko" icon="fa-solid fa-store" id="cms" :active="request()->is('pengelola/cms*')">
                <x-layouts.admin.sub-menu route="pengelola.toko.beranda" label="Ringkasan Toko" icon="fa-solid fa-gauge-high" warna="text-pink-500" />
                <x-layouts.admin.sub-menu route="pengelola.toko.berita" label="Berita & Artikel" icon="fa-solid fa-newspaper" warna="text-pink-500" />
                <x-layouts.admin.sub-menu route="pengelola.toko.konten" label="Konten Halaman" icon="fa-solid fa-pager" warna="text-pink-500" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- MODUL: PRODUK & GADGET (CYAN) -->
        <div class="text-cyan-400">
            <x-layouts.admin.menu-group label="Produk & Gadget" icon="fa-solid fa-laptop-code" id="produk" :active="request()->is('pengelola/produk*') || request()->routeIs('pengelola.kategori') || request()->routeIs('pengelola.merek')">
                <x-layouts.admin.sub-menu route="pengelola.produk.beranda" label="Dasbor Produk" icon="fa-solid fa-chart-column" warna="text-cyan-500" />
                <x-layouts.admin.sub-menu route="pengelola.produk.katalog" label="Katalog Unit" icon="fa-solid fa-box-open" warna="text-cyan-500" />
                <x-layouts.admin.sub-menu route="pengelola.produk.tambah" label="Registrasi SKU" icon="fa-solid fa-plus-circle" warna="text-cyan-500" />
                <x-layouts.admin.sub-menu route="pengelola.kategori" label="Kategori" icon="fa-solid fa-layer-group" warna="text-cyan-500" />
                <x-layouts.admin.sub-menu route="pengelola.merek" label="Merek & Brand" icon="fa-solid fa-copyright" warna="text-cyan-500" />
                <div class="h-px bg-white/5 my-2 mx-3"></div>
                <x-layouts.admin.sub-menu route="pengelola.produk.stok" label="Kontrol Stok" icon="fa-solid fa-boxes-stacked" warna="text-cyan-500" />
                <x-layouts.admin.sub-menu route="pengelola.produk.gudang" label="Lokasi Gudang" icon="fa-solid fa-warehouse" warna="text-cyan-500" />
                <x-layouts.admin.sub-menu route="pengelola.produk.so.riwayat" label="Audit Stok (SO)" icon="fa-solid fa-clipboard-check" warna="text-cyan-500" />
                <x-layouts.admin.sub-menu route="pengelola.produk.seri" label="Nomor Seri (SN)" icon="fa-solid fa-barcode" warna="text-cyan-500" />
                <div class="h-px bg-white/5 my-2 mx-3"></div>
                <x-layouts.admin.sub-menu route="pengelola.produk.spesifikasi" label="Spesifikasi Teknis" icon="fa-solid fa-microchip" warna="text-cyan-500" />
                <x-layouts.admin.sub-menu route="pengelola.produk.garansi" label="Klaim Garansi" icon="fa-solid fa-medal" warna="text-cyan-500" />
                <x-layouts.admin.sub-menu route="pengelola.produk.promo.flash-sale" label="Penjualan Kilat" icon="fa-solid fa-bolt" warna="text-cyan-500" />
                <x-layouts.admin.sub-menu route="pengelola.produk.label" label="Cetak Label QR" icon="fa-solid fa-print" warna="text-cyan-500" />
                <x-layouts.admin.sub-menu route="pengelola.produk.analitik" label="Analitik Produk" icon="fa-solid fa-magnifying-glass-chart" warna="text-cyan-500" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- MODUL: PESANAN & POS (EMERALD) -->
        <div class="text-emerald-400">
            <x-layouts.admin.menu-group label="Pesanan & POS" icon="fa-solid fa-cart-shopping" id="pesanan" :active="request()->is('pengelola/pesanan*')">
                <x-layouts.admin.sub-menu route="pengelola.pesanan.beranda" label="Dasbor Pesanan" icon="fa-solid fa-chart-line" warna="text-emerald-500" />
                <x-layouts.admin.sub-menu route="pengelola.pesanan.daftar" label="Semua Pesanan" icon="fa-solid fa-list-check" warna="text-emerald-500" />
                <x-layouts.admin.sub-menu route="pengelola.pesanan.verifikasi" label="Verifikasi Bayar" icon="fa-solid fa-money-check-dollar" warna="text-emerald-500" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- MODUL: TRANSAKSI KEUANGAN (AMBER) -->
        <div class="text-amber-400">
            <x-layouts.admin.menu-group label="Keuangan" icon="fa-solid fa-wallet" id="transaksi" :active="request()->is('pengelola/transaksi*')">
                <x-layouts.admin.sub-menu route="pengelola.transaksi.beranda" label="Arus Kas Global" icon="fa-solid fa-coins" warna="text-amber-500" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- MODUL: LOGISTIK & KURIR (ORANGE) -->
        <div class="text-orange-400">
            <x-layouts.admin.menu-group label="Logistik & Kurir" icon="fa-solid fa-truck-fast" id="logistik" :active="request()->is('pengelola/logistik*')">
                <x-layouts.admin.sub-menu route="pengelola.logistik.beranda" label="Pantau Pengiriman" icon="fa-solid fa-map-location-dot" warna="text-orange-500" />
            </x-layouts.admin.menu-group>
        </div>

        <div class="my-4 border-t border-white/5 mx-2" :class="!sidebarOpen && 'hidden'"></div>
        <p class="px-4 text-[9px] font-black text-slate-600 uppercase tracking-widest mb-2 transition-opacity" :class="!sidebarOpen && 'hidden'">Relasi Eksternal & Internal</p>

        <!-- MODUL: MEMBER & PELANGGAN (BLUE) -->
        <div class="text-blue-400">
            <x-layouts.admin.menu-group label="Member & Pelanggan" icon="fa-solid fa-users" id="pelanggan" :active="request()->is('pengelola/pelanggan*')">
                <x-layouts.admin.sub-menu route="pengelola.pelanggan.beranda" label="Dasbor Pelanggan" icon="fa-solid fa-id-card" warna="text-blue-500" />
                <x-layouts.admin.sub-menu route="pengelola.pelanggan.daftar" label="Database Anggota" icon="fa-solid fa-users-viewfinder" warna="text-blue-500" />
                <x-layouts.admin.sub-menu route="pengelola.pelanggan.ulasan" label="Ulasan & Penilaian" icon="fa-solid fa-star" warna="text-blue-500" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- MODUL: VENDOR & PO (TEAL) -->
        <div class="text-teal-400">
            <x-layouts.admin.menu-group label="Vendor & PO" icon="fa-solid fa-building-shield" id="vendor" :active="request()->is('pengelola/vendor*')">
                <x-layouts.admin.sub-menu route="pengelola.vendor.beranda" label="Dasbor Pemasok" icon="fa-solid fa-industry" warna="text-teal-500" />
                <x-layouts.admin.sub-menu route="pengelola.vendor.daftar" label="Direktori Pemasok" icon="fa-solid fa-address-book" warna="text-teal-500" />
                <x-layouts.admin.sub-menu route="pengelola.vendor.penawaran" label="Penawaran Masuk" icon="fa-solid fa-file-invoice" warna="text-teal-500" />
                <x-layouts.admin.sub-menu route="pengelola.produk.pembelian.riwayat" label="Riwayat PO" icon="fa-solid fa-file-contract" warna="text-teal-500" />
                <x-layouts.admin.sub-menu route="pengelola.produk.pembelian.baru" label="Buat PO Baru" icon="fa-solid fa-cart-plus" warna="text-teal-500" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- MODUL: SDM & HRD (VIOLET) -->
        <div class="text-violet-400">
            <x-layouts.admin.menu-group label="SDM & HRD" icon="fa-solid fa-id-card-clip" id="hrd" :active="request()->is('pengelola/hrd*')">
                <x-layouts.admin.sub-menu route="pengelola.hrd.beranda" label="Dasbor SDM" icon="fa-solid fa-users-gear" warna="text-violet-500" />
                <x-layouts.admin.sub-menu route="pengelola.pengguna.hrd" label="Daftar Karyawan" icon="fa-solid fa-user-tie" warna="text-violet-500" />
                <x-layouts.admin.sub-menu route="pengelola.hrd.struktur" label="Struktur Organisasi" icon="fa-solid fa-sitemap" warna="text-violet-500" />
                <x-layouts.admin.sub-menu route="pengelola.hrd.akses" label="Hak Akses (RBAC)" icon="fa-solid fa-key" warna="text-violet-500" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- MODUL: LAYANAN BANTUAN (LIME) -->
        <div class="text-lime-400">
            <x-layouts.admin.menu-group label="Layanan Bantuan" icon="fa-solid fa-headset" id="layanan" :active="request()->is('pengelola/layanan*')">
                <x-layouts.admin.sub-menu route="pengelola.cs.beranda" label="Pusat Bantuan" icon="fa-solid fa-life-ring" warna="text-lime-500" />
                <x-layouts.admin.sub-menu route="pengelola.cs.tiket" label="Tiket Keluhan" icon="fa-solid fa-ticket" warna="text-lime-500" />
            </x-layouts.admin.menu-group>
        </div>

        <div class="my-4 border-t border-white/5 mx-2" :class="!sidebarOpen && 'hidden'"></div>
        <p class="px-4 text-[9px] font-black text-slate-600 uppercase tracking-widest mb-2 transition-opacity" :class="!sidebarOpen && 'hidden'">Keamanan & Infrastruktur</p>

        <!-- MODUL: KEAMANAN SIBER (RED) -->
        <div class="text-red-500">
            <x-layouts.admin.menu-group label="Keamanan Siber" icon="fa-solid fa-shield-cat" id="keamanan" :active="request()->is('pengelola/keamanan*')">
                <x-layouts.admin.sub-menu route="pengelola.keamanan.beranda" label="Pusat Keamanan" icon="fa-solid fa-lock" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.dasbor" label="Dasbor SOC" icon="fa-solid fa-eye" warna="text-red-500" />
                <div class="h-px bg-white/5 my-2 mx-3"></div>
                <x-layouts.admin.sub-menu route="pengelola.keamanan.firewall" label="Dinding Api (WAF)" icon="fa-solid fa-fire" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.pemindai" label="Pemindai Malware" icon="fa-solid fa-bug" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.siem" label="Monitor Log SIEM" icon="fa-solid fa-file-waveform" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.integritas" label="Integritas Berkas" icon="fa-solid fa-file-shield" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.ueba" label="Analisa Perilaku" icon="fa-solid fa-user-secret" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.forensik" label="Forensik Digital" icon="fa-solid fa-magnifying-glass" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.honeypot" label="Umpan Honeypot" icon="fa-solid fa-flask" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.ancaman" label="Intelijen Ancaman" icon="fa-solid fa-skull" warna="text-red-500" />
                <div class="h-px bg-white/5 my-2 mx-3"></div>
                <x-layouts.admin.sub-menu route="pengelola.keamanan.pam" label="Akses Istimewa" icon="fa-solid fa-id-badge" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.sesi" label="Monitor Sesi" icon="fa-solid fa-desktop" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.dlp" label="Cegah Kebocoran" icon="fa-solid fa-filter" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.irp" label="Respon Insiden" icon="fa-solid fa-briefcase-medical" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.zerotrust" label="Akses Zero Trust" icon="fa-solid fa-handshake-slash" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.edr" label="Deteksi Endpoint" icon="fa-solid fa-laptop-medical" warna="text-red-500" />
                <x-layouts.admin.sub-menu route="pengelola.keamanan.cadangan" label="Cadangan Data" icon="fa-solid fa-database" warna="text-red-500" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- MODUL: PENGATURAN API (FUCHSIA) -->
        <div class="text-fuchsia-400">
            <x-layouts.admin.menu-group label="Pengaturan API" icon="fa-solid fa-code" id="api" :active="request()->is('pengelola/api*')">
                <x-layouts.admin.sub-menu route="pengelola.api.pusat" label="Gerbang Integrasi" icon="fa-solid fa-network-wired" warna="text-fuchsia-500" />
                <x-layouts.admin.sub-menu route="pengelola.api.pembayaran" label="Gerbang Bayar" icon="fa-solid fa-credit-card" warna="text-fuchsia-500" />
                <x-layouts.admin.sub-menu route="pengelola.api.logistik" label="Integrasi Kurir" icon="fa-solid fa-truck-plane" warna="text-fuchsia-500" />
                <x-layouts.admin.sub-menu route="pengelola.api.whatsapp" label="API WhatsApp" icon="fa-brands fa-whatsapp" warna="text-fuchsia-500" />
                <x-layouts.admin.sub-menu route="pengelola.api.email" label="Server SMTP" icon="fa-solid fa-server" warna="text-fuchsia-500" />
                <x-layouts.admin.sub-menu route="pengelola.api.kunci" label="Kunci API Sistem" icon="fa-solid fa-key" warna="text-fuchsia-500" />
                <x-layouts.admin.sub-menu route="pengelola.api.log" label="Log Akses API" icon="fa-solid fa-terminal" warna="text-fuchsia-500" />
                <x-layouts.admin.sub-menu route="pengelola.api.dokumentasi" label="Dokumentasi API" icon="fa-solid fa-book" warna="text-fuchsia-500" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- MODUL: LAPORAN & AUDIT (LAVENDER) -->
        <div class="text-indigo-300">
            <x-layouts.admin.menu-group label="Laporan & Audit" icon="fa-solid fa-file-contract" id="laporan" :active="request()->is('pengelola/laporan*')">
                <x-layouts.admin.sub-menu route="pengelola.laporan.beranda" label="Pusat Laporan" icon="fa-solid fa-chart-column" warna="text-indigo-300" />
                <x-layouts.admin.sub-menu route="pengelola.pengaturan.log" label="Log Audit Sistem" icon="fa-solid fa-clock-rotate-left" warna="text-indigo-300" />
            </x-layouts.admin.menu-group>
        </div>

        <!-- MODUL: SISTEM TERPUSAT (SLATE) -->
        <div class="text-slate-400">
            <x-layouts.admin.menu-group label="Sistem Terpusat" icon="fa-solid fa-gears" id="sistem" :active="request()->is('pengelola/sistem*')">
                <x-layouts.admin.sub-menu route="pengelola.sistem.beranda" label="Kontrol Utama" icon="fa-solid fa-sliders" warna="text-slate-500" />
                <x-layouts.admin.sub-menu route="pengelola.sistem.pusat" label="Pengaturan Global" icon="fa-solid fa-globe" warna="text-slate-500" />
                <x-layouts.admin.sub-menu route="pengelola.sistem.kesehatan" label="Kesehatan Server" icon="fa-solid fa-heart-pulse" warna="text-slate-500" />
                <x-layouts.admin.sub-menu route="pengelola.voucher" label="Kupon & Voucher" icon="fa-solid fa-ticket-simple" warna="text-slate-500" />
            </x-layouts.admin.menu-group>
        </div>

    </nav>

    <!-- 3. FOOTER PROFIL (GLASSMORPHISM) -->
    <div class="p-4 border-t border-white/5 bg-[#080c16]">
        <div class="flex items-center gap-3 transition-all" :class="!sidebarOpen && 'justify-center'">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md shrink-0 ring-2 ring-white/10">
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