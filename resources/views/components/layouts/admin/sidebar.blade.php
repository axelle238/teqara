<aside class="fixed inset-y-0 left-0 z-50 bg-[#0f172a] text-slate-300 sidebar-transition flex flex-col border-r border-slate-800 shadow-2xl font-sans select-none"
       :class="sidebarOpen ? 'w-[280px] translate-x-0' : 'w-[80px] -translate-x-full lg:translate-x-0'">
    
    <!-- Brand Logo Area -->
    <div class="h-20 flex items-center justify-center border-b border-slate-800 relative bg-[#0f172a] shrink-0">
        <a href="{{ route('pengelola.beranda') }}" class="flex items-center gap-3 group" x-show="sidebarOpen" x-transition.opacity>
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center font-black text-xl shadow-lg shadow-indigo-500/20 text-white transform group-hover:scale-110 transition-transform duration-300">T</div>
            <div class="flex flex-col">
                <span class="text-xl font-black tracking-tight uppercase leading-none text-white">TEQARA<span class="text-indigo-400">.</span></span>
                <span class="text-[9px] font-bold text-slate-500 tracking-[0.25em] uppercase mt-1 group-hover:text-indigo-400 transition-colors">Enterprise</span>
            </div>
        </a>
        <a href="{{ route('pengelola.beranda') }}" class="w-10 h-10 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center font-black text-xl text-white shadow-lg" x-show="!sidebarOpen">T</a>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1.5 dark-scroll text-sm">
        
        <!-- 1. DASHBOARD UTAMA -->
        <a href="{{ route('pengelola.beranda') }}" wire:navigate class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('pengelola.beranda') ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-lg shadow-indigo-900/50 border border-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-chart-line w-6 text-center text-lg {{ request()->routeIs('pengelola.beranda') ? 'text-white' : 'text-indigo-400 group-hover:text-indigo-300' }}"></i>
            <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Ringkasan Bisnis</span>
        </a>

        <!-- 2. MANAJEMEN HALAMAN TOKO (Pink) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.toko*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-pink-500/10 text-pink-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-store w-6 text-center text-lg transition-colors" :class="open ? 'text-pink-500' : 'text-slate-500 group-hover:text-pink-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Manajemen Toko</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.toko.berita') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.toko.berita') ? 'text-white bg-pink-600 shadow-md' : 'text-slate-500 hover:text-pink-400 hover:bg-pink-500/10' }}">Berita & Blog</a>
                <a href="{{ route('pengelola.toko.konten') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.toko.konten') ? 'text-white bg-pink-600 shadow-md' : 'text-slate-500 hover:text-pink-400 hover:bg-pink-500/10' }}">Konten & Banner</a>
            </div>
        </div>

        <!-- 3. MANAJEMEN PRODUK & GADGET (Rose) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.produk*') || request()->routeIs('pengelola.kategori*') || request()->routeIs('pengelola.merek*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-rose-500/10 text-rose-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-laptop-code w-6 text-center text-lg transition-colors" :class="open ? 'text-rose-500' : 'text-slate-500 group-hover:text-rose-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Produk & Gadget</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.produk.katalog') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.produk.katalog') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400 hover:bg-rose-500/10' }}">Katalog Produk</a>
                <a href="{{ route('pengelola.produk.stok') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.produk.stok') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400 hover:bg-rose-500/10' }}">Inventaris Stok</a>
                <a href="{{ route('pengelola.kategori') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.kategori*') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400 hover:bg-rose-500/10' }}">Kategori</a>
                <a href="{{ route('pengelola.merek') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.merek*') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400 hover:bg-rose-500/10' }}">Merek</a>
                <a href="{{ route('pengelola.produk.gudang') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.produk.gudang') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400 hover:bg-rose-500/10' }}">Lokasi Gudang</a>
            </div>
        </div>

        <!-- 4. MANAJEMEN PESANAN (Emerald) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.pesanan*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-emerald-500/10 text-emerald-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-cart-arrow-down w-6 text-center text-lg transition-colors" :class="open ? 'text-emerald-500' : 'text-slate-500 group-hover:text-emerald-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Manajemen Pesanan</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.pesanan.daftar') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.pesanan.daftar') ? 'text-white bg-emerald-600 shadow-md' : 'text-slate-500 hover:text-emerald-400 hover:bg-emerald-500/10' }}">Daftar Pesanan</a>
                <a href="{{ route('pengelola.pesanan.verifikasi') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.pesanan.verifikasi') ? 'text-white bg-emerald-600 shadow-md' : 'text-slate-500 hover:text-emerald-400 hover:bg-emerald-500/10' }}">Verifikasi Bayar</a>
            </div>
        </div>

        <!-- 5. MANAJEMEN TRANSAKSI (Teal) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.transaksi*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-teal-500/10 text-teal-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-file-invoice-dollar w-6 text-center text-lg transition-colors" :class="open ? 'text-teal-500' : 'text-slate-500 group-hover:text-teal-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Manajemen Transaksi</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.transaksi.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.transaksi.beranda') ? 'text-white bg-teal-600 shadow-md' : 'text-slate-500 hover:text-teal-400 hover:bg-teal-500/10' }}">Jurnal Transaksi</a>
            </div>
        </div>

        <!-- 6. MANAJEMEN CS (Violet) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.cs*') || request()->routeIs('pengelola.produk.garansi') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-violet-500/10 text-violet-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-headset w-6 text-center text-lg transition-colors" :class="open ? 'text-violet-500' : 'text-slate-500 group-hover:text-violet-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Customer Service</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.cs.tiket') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.cs.tiket') ? 'text-white bg-violet-600 shadow-md' : 'text-slate-500 hover:text-violet-400 hover:bg-violet-500/10' }}">Tiket Bantuan</a>
                <a href="{{ route('pengelola.produk.garansi') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.produk.garansi') ? 'text-white bg-violet-600 shadow-md' : 'text-slate-500 hover:text-violet-400 hover:bg-violet-500/10' }}">Klaim Garansi</a>
            </div>
        </div>

        <!-- 7. MANAJEMEN LOGISTIK (Orange) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.logistik*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-orange-500/10 text-orange-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-truck-ramp-box w-6 text-center text-lg transition-colors" :class="open ? 'text-orange-500' : 'text-slate-500 group-hover:text-orange-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Logistik & Kurir</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.logistik.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.logistik.beranda') ? 'text-white bg-orange-600 shadow-md' : 'text-slate-500 hover:text-orange-400 hover:bg-orange-500/10' }}">Dashboard Logistik</a>
                <a href="{{ route('pengelola.api.logistik') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.api.logistik') ? 'text-white bg-orange-600 shadow-md' : 'text-slate-500 hover:text-orange-400 hover:bg-orange-500/10' }}">Integrasi Kurir</a>
            </div>
        </div>

        <!-- 8. MANAJEMEN PELANGGAN (Sky) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.pelanggan*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-sky-500/10 text-sky-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-users w-6 text-center text-lg transition-colors" :class="open ? 'text-sky-500' : 'text-slate-500 group-hover:text-sky-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Manajemen Pelanggan</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.pelanggan.daftar') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.pelanggan.daftar') ? 'text-white bg-sky-600 shadow-md' : 'text-slate-500 hover:text-sky-400 hover:bg-sky-500/10' }}">Data Pelanggan</a>
                <a href="{{ route('pengelola.pelanggan.ulasan') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.pelanggan.ulasan') ? 'text-white bg-sky-600 shadow-md' : 'text-slate-500 hover:text-sky-400 hover:bg-sky-500/10' }}">Ulasan Member</a>
            </div>
        </div>

        <!-- 9. MANAJEMEN VENDOR (Blue) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.vendor*') || request()->routeIs('pengelola.produk.pembelian*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-blue-500/10 text-blue-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-industry w-6 text-center text-lg transition-colors" :class="open ? 'text-blue-500' : 'text-slate-500 group-hover:text-blue-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Manajemen Vendor</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.vendor.daftar') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.vendor.daftar') ? 'text-white bg-blue-600 shadow-md' : 'text-slate-500 hover:text-blue-400 hover:bg-blue-500/10' }}">Database Vendor</a>
                <a href="{{ route('pengelola.vendor.penawaran') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.vendor.penawaran') ? 'text-white bg-blue-600 shadow-md' : 'text-slate-500 hover:text-blue-400 hover:bg-blue-500/10' }}">Penawaran (RFQ)</a>
                <a href="{{ route('pengelola.produk.pembelian.riwayat') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.produk.pembelian.riwayat') ? 'text-white bg-blue-600 shadow-md' : 'text-slate-500 hover:text-blue-400 hover:bg-blue-500/10' }}">Riwayat PO</a>
            </div>
        </div>

        <!-- 10. MANAJEMEN PEGAWAI (Lime) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.pengguna.hrd') || request()->routeIs('pengelola.hrd*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-lime-500/10 text-lime-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-user-gear w-6 text-center text-lg transition-colors" :class="open ? 'text-lime-500' : 'text-slate-500 group-hover:text-lime-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Pegawai & Peran</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.pengguna.hrd') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.pengguna.hrd') ? 'text-white bg-lime-600 shadow-md' : 'text-slate-500 hover:text-lime-400 hover:bg-lime-500/10' }}">Data Karyawan</a>
                <a href="{{ route('pengelola.hrd.struktur') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.hrd.struktur') ? 'text-white bg-lime-600 shadow-md' : 'text-slate-500 hover:text-lime-400 hover:bg-lime-500/10' }}">Struktur Organisasi</a>
            </div>
        </div>

        <!-- 11. LAPORAN & ANALITIK (Amber) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.laporan*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-amber-500/10 text-amber-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-chart-column w-6 text-center text-lg transition-colors" :class="open ? 'text-amber-500' : 'text-slate-500 group-hover:text-amber-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Laporan & Analitik</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.laporan.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.laporan.beranda') ? 'text-white bg-amber-600 shadow-md' : 'text-slate-500 hover:text-amber-400 hover:bg-amber-500/10' }}">Laporan Penjualan</a>
                <a href="{{ route('pengelola.pengaturan.log') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.pengaturan.log') ? 'text-white bg-amber-600 shadow-md' : 'text-slate-500 hover:text-amber-400 hover:bg-amber-500/10' }}">Log Aktivitas</a>
            </div>
        </div>

        <!-- 12. PENGATURAN SISTEM (Gray) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.sistem*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-slate-700/50 text-slate-200': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-gears w-6 text-center text-lg transition-colors" :class="open ? 'text-slate-200' : 'text-slate-500 group-hover:text-slate-200'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Sistem Terpusat</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.sistem.pusat') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.sistem.pusat') ? 'text-white bg-slate-600 shadow-md' : 'text-slate-500 hover:text-slate-300 hover:bg-slate-700/30' }}">Konfigurasi Global</a>
                <a href="{{ route('pengelola.sistem.kesehatan') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.sistem.kesehatan') ? 'text-white bg-slate-600 shadow-md' : 'text-slate-500 hover:text-slate-300 hover:bg-slate-700/30' }}">Kesehatan Server</a>
            </div>
        </div>

        <!-- 13. KEAMANAN SIBER (Red) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.keamanan*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-red-500/10 text-red-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-shield-halved w-6 text-center text-lg transition-colors" :class="open ? 'text-red-500' : 'text-slate-500 group-hover:text-red-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Keamanan Terpusat</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.keamanan.dashboard') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.dashboard') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">Pusat Kontrol (SOC)</a>
                <a href="{{ route('pengelola.keamanan.firewall') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.firewall') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">Firewall (WAF)</a>
            </div>
        </div>

    </nav>

    <!-- Footer Area -->
    <div class="p-4 bg-slate-900 border-t border-slate-800" x-show="sidebarOpen">
        <div class="bg-gradient-to-r from-indigo-900/50 to-purple-900/50 rounded-xl p-3 border border-indigo-500/20">
            <h5 class="text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-1">Status Sistem</h5>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-white">Enterprise V 12.0</span>
                <i class="fa-solid fa-circle-check text-emerald-500 text-xs animate-pulse"></i>
            </div>
        </div>
    </div>
</aside>
