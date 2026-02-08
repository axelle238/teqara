<aside 
    class="fixed inset-y-0 left-0 z-50 w-72 bg-[#0f172a] text-slate-300 transition-transform duration-300 ease-in-out border-r border-slate-800 shadow-2xl flex flex-col"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-20'"
>
    <!-- 1. BRAND HEADER -->
    <div class="h-20 flex items-center justify-center relative overflow-hidden border-b border-white/5 shrink-0">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/20 to-purple-900/20"></div>
        
        <!-- Logo Expanded -->
        <a href="{{ route('pengelola.beranda') }}" wire:navigate class="flex items-center gap-3 relative z-10 transition-opacity duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 hidden'">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-cyan-500 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-500/30">
                T
            </div>
            <div class="leading-none">
                <span class="block text-xl font-black text-white tracking-tight uppercase">TEQARA</span>
                <span class="block text-[9px] font-bold text-indigo-400 uppercase tracking-[0.3em]">Enterprise v16</span>
            </div>
        </a>

        <!-- Logo Collapsed -->
        <a href="{{ route('pengelola.beranda') }}" wire:navigate class="absolute inset-0 flex items-center justify-center transition-opacity duration-300" :class="sidebarOpen ? 'opacity-0 hidden' : 'opacity-100'">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-cyan-500 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-500/30">
                T
            </div>
        </a>
    </div>

    <!-- 2. NAVIGATION MENU (SCROLLABLE) -->
    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-6 px-3 space-y-2 custom-scrollbar-dark" x-data="{ activeMenu: '{{ Request::segment(2) }}' }">
        
        <!-- DASHBOARD EKSEKUTIF -->
        <x-layouts.admin.menu-item 
            route="pengelola.beranda" 
            icon="fa-solid fa-chart-pie" 
            label="Panel Eksekutif" 
            :active="request()->routeIs('pengelola.beranda')" 
        />

        <!-- PUSAT NOTIFIKASI -->
        <x-layouts.admin.menu-item 
            route="pengelola.notifikasi.index" 
            icon="fa-solid fa-bell" 
            label="Pusat Notifikasi" 
            :active="request()->routeIs('pengelola.notifikasi.*')"
            badge="{{ \App\Models\Notifikasi::where('dibaca', false)->count() > 0 ? \App\Models\Notifikasi::where('dibaca', false)->count() : '' }}"
        />

        <div class="my-4 border-t border-white/5 mx-2" :class="!sidebarOpen && 'hidden'"></div>
        <p class="px-4 text-[9px] font-black text-slate-600 uppercase tracking-widest mb-2 transition-opacity" :class="!sidebarOpen && 'hidden'">Operasional Bisnis</p>

        <!-- MANAJEMEN TOKO (CMS) -->
        <x-layouts.admin.menu-group label="Halaman Toko" icon="fa-solid fa-store" id="cms" :active="request()->is('pengelola/cms*')">
            <x-layouts.admin.sub-menu route="pengelola.toko.beranda" label="Ringkasan CMS" />
            <x-layouts.admin.sub-menu route="pengelola.toko.berita" label="Berita & Artikel" />
            <x-layouts.admin.sub-menu route="pengelola.toko.konten" label="Konten Halaman" />
        </x-layouts.admin.menu-group>

        <!-- MANAJEMEN PRODUK -->
        <x-layouts.admin.menu-group label="Produk & Gadget" icon="fa-solid fa-laptop-code" id="produk" :active="request()->is('pengelola/produk*') || request()->routeIs('pengelola.kategori') || request()->routeIs('pengelola.merek')">
            <x-layouts.admin.sub-menu route="pengelola.produk.beranda" label="Dasbor Inventaris" />
            <x-layouts.admin.sub-menu route="pengelola.produk.katalog" label="Katalog Produk" />
            <x-layouts.admin.sub-menu route="pengelola.produk.tambah" label="Registrasi Unit Baru" />
            <x-layouts.admin.sub-menu route="pengelola.produk.stok" label="Kontrol Stok Fisik" />
            <x-layouts.admin.sub-menu route="pengelola.produk.so.riwayat" label="Stock Opname" />
            <x-layouts.admin.sub-menu route="pengelola.kategori" label="Kategori Produk" />
            <x-layouts.admin.sub-menu route="pengelola.merek" label="Merek & Brand" />
            <x-layouts.admin.sub-menu route="pengelola.produk.garansi" label="Klaim Garansi" />
        </x-layouts.admin.menu-group>

        <!-- MANAJEMEN PESANAN -->
        <x-layouts.admin.menu-group label="Pesanan & POS" icon="fa-solid fa-cart-shopping" id="pesanan" :active="request()->is('pengelola/pesanan*')">
            <x-layouts.admin.sub-menu route="pengelola.pesanan.beranda" label="Dasbor Pesanan" />
            <x-layouts.admin.sub-menu route="pengelola.pesanan.daftar" label="Semua Pesanan" />
            <x-layouts.admin.sub-menu route="pengelola.pesanan.verifikasi" label="Verifikasi Bayar" />
        </x-layouts.admin.menu-group>

        <!-- MANAJEMEN KEUANGAN -->
        <x-layouts.admin.menu-group label="Transaksi Keuangan" icon="fa-solid fa-wallet" id="transaksi" :active="request()->is('pengelola/transaksi*')">
            <x-layouts.admin.sub-menu route="pengelola.transaksi.beranda" label="Arus Kas (Cashflow)" />
        </x-layouts.admin.menu-group>

        <!-- MANAJEMEN LOGISTIK -->
        <x-layouts.admin.menu-group label="Logistik & Kurir" icon="fa-solid fa-truck-fast" id="logistik" :active="request()->is('pengelola/logistik*')">
            <x-layouts.admin.sub-menu route="pengelola.logistik.beranda" label="Pantau Pengiriman" />
        </x-layouts.admin.menu-group>

        <div class="my-4 border-t border-white/5 mx-2" :class="!sidebarOpen && 'hidden'"></div>
        <p class="px-4 text-[9px] font-black text-slate-600 uppercase tracking-widest mb-2 transition-opacity" :class="!sidebarOpen && 'hidden'">Relasi & Organisasi</p>

        <!-- MANAJEMEN PELANGGAN -->
        <x-layouts.admin.menu-group label="Member & Pelanggan" icon="fa-solid fa-users" id="pelanggan" :active="request()->is('pengelola/pelanggan*')">
            <x-layouts.admin.sub-menu route="pengelola.pelanggan.beranda" label="CRM Dashboard" />
            <x-layouts.admin.sub-menu route="pengelola.pelanggan.daftar" label="Data Member" />
            <x-layouts.admin.sub-menu route="pengelola.pelanggan.ulasan" label="Ulasan & Rating" />
        </x-layouts.admin.menu-group>

        <!-- MANAJEMEN VENDOR -->
        <x-layouts.admin.menu-group label="Vendor & PO" icon="fa-solid fa-building-shield" id="vendor" :active="request()->is('pengelola/vendor*')">
            <x-layouts.admin.sub-menu route="pengelola.vendor.beranda" label="Dasbor Supplier" />
            <x-layouts.admin.sub-menu route="pengelola.vendor.daftar" label="Daftar Mitra" />
            <x-layouts.admin.sub-menu route="pengelola.produk.pembelian.riwayat" label="Purchase Order (PO)" />
        </x-layouts.admin.menu-group>

        <!-- MANAJEMEN HRD -->
        <x-layouts.admin.menu-group label="SDM & HRD" icon="fa-solid fa-id-card-clip" id="hrd" :active="request()->is('pengelola/hrd*')">
            <x-layouts.admin.sub-menu route="pengelola.hrd.beranda" label="HR Dashboard" />
            <x-layouts.admin.sub-menu route="pengelola.pengguna.hrd" label="Direktori Karyawan" />
            <x-layouts.admin.sub-menu route="pengelola.hrd.akses" label="Hak Akses (RBAC)" />
        </x-layouts.admin.menu-group>

        <!-- LAYANAN BANTUAN -->
        <x-layouts.admin.menu-group label="Layanan Bantuan" icon="fa-solid fa-headset" id="layanan" :active="request()->is('pengelola/layanan*')">
            <x-layouts.admin.sub-menu route="pengelola.cs.beranda" label="Helpdesk Center" />
            <x-layouts.admin.sub-menu route="pengelola.cs.tiket" label="Tiket Komplain" />
        </x-layouts.admin.menu-group>

        <div class="my-4 border-t border-white/5 mx-2" :class="!sidebarOpen && 'hidden'"></div>
        <p class="px-4 text-[9px] font-black text-slate-600 uppercase tracking-widest mb-2 transition-opacity" :class="!sidebarOpen && 'hidden'">Infrastruktur Sistem</p>

        <!-- MANAJEMEN LAPORAN -->
        <x-layouts.admin.menu-group label="Laporan & Audit" icon="fa-solid fa-file-contract" id="laporan" :active="request()->is('pengelola/laporan*')">
            <x-layouts.admin.sub-menu route="pengelola.laporan.beranda" label="Pusat Laporan" />
            <x-layouts.admin.sub-menu route="pengelola.pengaturan.log" label="Log Audit Sistem" />
        </x-layouts.admin.menu-group>

        <!-- SISTEM TERPUSAT -->
        <x-layouts.admin.menu-group label="Sistem Terpusat" icon="fa-solid fa-gears" id="sistem" :active="request()->is('pengelola/sistem*')">
            <x-layouts.admin.sub-menu route="pengelola.sistem.beranda" label="Kontrol Utama" />
            <x-layouts.admin.sub-menu route="pengelola.sistem.pusat" label="Konfigurasi Global" />
            <x-layouts.admin.sub-menu route="pengelola.sistem.kesehatan" label="Kesehatan Server" />
        </x-layouts.admin.menu-group>

        <!-- PENGATURAN API -->
        <x-layouts.admin.menu-group label="Pengaturan API" icon="fa-solid fa-code" id="api" :active="request()->is('pengelola/api*')">
            <x-layouts.admin.sub-menu route="pengelola.api.pusat" label="Gateway Integrasi" />
            <x-layouts.admin.sub-menu route="pengelola.api.pembayaran" label="Payment Gateway" />
            <x-layouts.admin.sub-menu route="pengelola.api.logistik" label="Kurir Ekspedisi" />
        </x-layouts.admin.menu-group>

        <!-- KEAMANAN SIBER -->
        <x-layouts.admin.menu-group label="Keamanan Siber" icon="fa-solid fa-shield-cat" id="keamanan" :active="request()->is('pengelola/keamanan*')">
            <x-layouts.admin.sub-menu route="pengelola.keamanan.beranda" label="Security Center" />
            <x-layouts.admin.sub-menu route="pengelola.keamanan.dasbor" label="SOC Dashboard" />
            <x-layouts.admin.sub-menu route="pengelola.keamanan.firewall" label="Firewall Rules" />
            <x-layouts.admin.sub-menu route="pengelola.keamanan.pemindai" label="Scanner Malware" />
        </x-layouts.admin.menu-group>

    </nav>

    <!-- 3. FOOTER USER -->
    <div class="p-4 border-t border-white/5 bg-[#0b1120]">
        <div class="flex items-center gap-3 transition-all" :class="!sidebarOpen && 'justify-center'">
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md shrink-0">
                {{ substr(auth()->user()->nama ?? 'A', 0, 1) }}
            </div>
            <div class="overflow-hidden" :class="!sidebarOpen && 'hidden'">
                <p class="text-xs font-black text-white truncate w-32">{{ auth()->user()->nama ?? 'Administrator' }}</p>
                <p class="text-[10px] font-medium text-slate-500 truncate">Super Admin</p>
            </div>
            <a href="{{ route('logout') }}" class="ml-auto w-8 h-8 rounded-lg bg-white/5 text-slate-400 hover:bg-rose-500 hover:text-white flex items-center justify-center transition-all" :class="!sidebarOpen && 'hidden'">
                <i class="fa-solid fa-power-off text-xs"></i>
            </a>
        </div>
    </div>
</aside>