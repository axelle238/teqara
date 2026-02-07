<aside class="fixed inset-y-0 left-0 z-50 bg-[#0f172a] text-slate-300 sidebar-transition flex flex-col border-r border-slate-800 shadow-2xl font-sans select-none"
       :class="sidebarOpen ? 'w-[280px] translate-x-0' : 'w-[80px] -translate-x-full lg:translate-x-0'">
    
    <!-- Area Logo Brand -->
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

    <!-- Menu Navigasi -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1.5 dark-scroll text-sm">
        
        <!-- DASBOR UTAMA -->
        <div class="mb-2 px-3" x-show="sidebarOpen"><span class="text-[9px] font-black text-slate-600 uppercase tracking-widest block">Menu Utama</span></div>
        
        <a href="{{ route('pengelola.beranda') }}" wire:navigate class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('pengelola.beranda') ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-lg border border-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-chart-line w-6 text-center text-lg {{ request()->routeIs('pengelola.beranda') ? 'text-white' : 'text-indigo-400 group-hover:text-indigo-300' }}"></i>
            <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Panel Eksekutif</span>
        </a>

        <a href="{{ route('pengelola.notifikasi.index') }}" wire:navigate class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('pengelola.notifikasi.index') ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <div class="relative">
                <i class="fa-solid fa-bell w-6 text-center text-lg"></i>
                <span class="absolute -top-1 -right-1 w-2 h-2 bg-rose-500 rounded-full animate-ping"></span>
            </div>
            <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Pusat Notifikasi</span>
        </a>

        <!-- 1. MANAJEMEN HALAMAN TOKO -->
        <div class="mt-6 mb-2 px-3" x-show="sidebarOpen"><span class="text-[9px] font-black text-slate-600 uppercase tracking-widest block">Manajemen Konten</span></div>
        <div x-data="{ open: {{ request()->routeIs('pengelola.toko*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-pink-500/10 text-pink-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-pager w-6 text-center text-lg" :class="open ? 'text-pink-500' : 'text-pink-400 group-hover:text-pink-300'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Halaman Toko</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.toko.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.toko.beranda') ? 'text-white bg-pink-600 shadow-md' : 'text-slate-500 hover:text-pink-400' }}">Dasbor Toko</a>
                <a href="{{ route('pengelola.toko.konten') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.toko.konten') ? 'text-white bg-pink-600 shadow-md' : 'text-slate-500 hover:text-pink-400' }}">Banner & Halaman</a>
                <a href="{{ route('pengelola.toko.berita') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.toko.berita') ? 'text-white bg-pink-600 shadow-md' : 'text-slate-500 hover:text-pink-400' }}">Berita & Blog</a>
            </div>
        </div>

        <!-- 2. MANAJEMEN PRODUK & GADGET -->
        <div class="mt-6 mb-2 px-3" x-show="sidebarOpen"><span class="text-[9px] font-black text-slate-600 uppercase tracking-widest block">Manajemen Inventaris</span></div>
        <div x-data="{ open: {{ (request()->routeIs('pengelola.produk*') || request()->routeIs('pengelola.kategori*') || request()->routeIs('pengelola.merek*')) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-rose-500/10 text-rose-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-laptop-code w-6 text-center text-lg" :class="open ? 'text-rose-500' : 'text-rose-400 group-hover:text-rose-300'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Produk & Gadget</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.produk.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.produk.beranda') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400' }}">Dasbor Produk</a>
                <a href="{{ route('pengelola.produk.katalog') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.produk.katalog') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400' }}">Katalog Produk</a>
                <a href="{{ route('pengelola.kategori') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.kategori*') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400' }}">Kategori</a>
                <a href="{{ route('pengelola.merek') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.merek*') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400' }}">Merek / Brand</a>
                <a href="{{ route('pengelola.produk.stok') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.produk.stok') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400' }}">Kelola Stok</a>
                <a href="{{ route('pengelola.produk.gudang') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.produk.gudang') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400' }}">Lokasi Gudang</a>
                <a href="{{ route('pengelola.produk.seri') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.produk.seri') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400' }}">Nomor Seri</a>
                <a href="{{ route('pengelola.produk.spesifikasi') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.produk.spesifikasi') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400' }}">Atribut Spesifikasi</a>
                <a href="{{ route('pengelola.produk.label') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.produk.label') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400' }}">Cetak Label</a>
                <a href="{{ route('pengelola.produk.so.riwayat') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.produk.so.riwayat') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400' }}">Stock Opname</a>
                <a href="{{ route('pengelola.produk.promo.flash-sale') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.produk.promo.flash-sale') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400' }}">Penjualan Kilat</a>
            </div>
        </div>

        <!-- 3. MANAJEMEN PESANAN -->
        <div class="mt-6 mb-2 px-3" x-show="sidebarOpen"><span class="text-[9px] font-black text-slate-600 uppercase tracking-widest block">Manajemen Operasional</span></div>
        <div x-data="{ open: {{ request()->routeIs('pengelola.pesanan*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-emerald-500/10 text-emerald-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-cart-shopping w-6 text-center text-lg" :class="open ? 'text-emerald-500' : 'text-emerald-400 group-hover:text-emerald-300'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Pesanan & POS</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.pesanan.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.pesanan.beranda') ? 'text-white bg-emerald-600 shadow-md' : 'text-slate-500 hover:text-emerald-400' }}">Dasbor Pesanan</a>
                <a href="{{ route('pengelola.pesanan.daftar') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.pesanan.daftar') ? 'text-white bg-emerald-600 shadow-md' : 'text-slate-500 hover:text-emerald-400' }}">Daftar Transaksi</a>
                <a href="{{ route('pengelola.pesanan.verifikasi') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.pesanan.verifikasi') ? 'text-white bg-emerald-600 shadow-md' : 'text-slate-500 hover:text-emerald-400' }}">Verifikasi Bayar</a>
            </div>
        </div>

        <!-- 4. MANAJEMEN TRANSAKSI -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.transaksi*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-teal-500/10 text-teal-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-file-invoice-dollar w-6 text-center text-lg" :class="open ? 'text-teal-500' : 'text-teal-400 group-hover:text-teal-300'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Transaksi & Keuangan</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.transaksi.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.transaksi.beranda') ? 'text-white bg-teal-600 shadow-md' : 'text-slate-500 hover:text-teal-400' }}">Dasbor Transaksi</a>
            </div>
        </div>

        <!-- 5. MANAJEMEN CUSTOMER SERVICE -->
        <div x-data="{ open: {{ (request()->routeIs('pengelola.cs*') || request()->routeIs('pengelola.produk.garansi')) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-violet-500/10 text-violet-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-headset w-6 text-center text-lg" :class="open ? 'text-violet-500' : 'text-violet-400 group-hover:text-violet-300'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Layanan Bantuan</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.cs.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.cs.beranda') ? 'text-white bg-violet-600 shadow-md' : 'text-slate-500 hover:text-violet-400' }}">Dasbor Layanan</a>
                <a href="{{ route('pengelola.cs.tiket') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.cs.tiket') ? 'text-white bg-violet-600 shadow-md' : 'text-slate-500 hover:text-violet-400' }}">Tiket Bantuan</a>
                <a href="{{ route('pengelola.produk.garansi') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.produk.garansi') ? 'text-white bg-violet-600 shadow-md' : 'text-slate-500 hover:text-violet-400' }}">Klaim Garansi</a>
            </div>
        </div>

        <!-- 6. MANAJEMEN LOGISTIK PENGIRIMAN -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.logistik*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-orange-500/10 text-orange-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-truck-ramp-box w-6 text-center text-lg" :class="open ? 'text-orange-500' : 'text-orange-400 group-hover:text-orange-300'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Logistik & Kurir</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.logistik.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.logistik.beranda') ? 'text-white bg-orange-600 shadow-md' : 'text-slate-500 hover:text-orange-400' }}">Dasbor Logistik</a>
            </div>
        </div>

        <!-- 7. MANAJEMEN PELANGGAN -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.pelanggan*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-sky-500/10 text-sky-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-users-gear w-6 text-center text-lg" :class="open ? 'text-sky-500' : 'text-sky-400 group-hover:text-sky-300'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Member & Pelanggan</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.pelanggan.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.pelanggan.beranda') ? 'text-white bg-sky-600 shadow-md' : 'text-slate-500 hover:text-sky-400' }}">Dasbor CRM</a>
                <a href="{{ route('pengelola.pelanggan.daftar') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.pelanggan.daftar') ? 'text-white bg-sky-600 shadow-md' : 'text-slate-500 hover:text-sky-400' }}">Database Member</a>
                <a href="{{ route('pengelola.pelanggan.ulasan') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.pelanggan.ulasan') ? 'text-white bg-sky-600 shadow-md' : 'text-slate-500 hover:text-sky-400' }}">Ulasan Produk</a>
            </div>
        </div>

        <!-- 8. MANAJEMEN VENDOR -->
        <div x-data="{ open: {{ (request()->routeIs('pengelola.vendor*') || request()->routeIs('pengelola.produk.pembelian*')) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-blue-500/10 text-blue-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-industry w-6 text-center text-lg" :class="open ? 'text-blue-500' : 'text-blue-400 group-hover:text-blue-300'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Vendor & PO</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.vendor.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.vendor.beranda') ? 'text-white bg-blue-600 shadow-md' : 'text-slate-500 hover:text-blue-400' }}">Dasbor Vendor</a>
                <a href="{{ route('pengelola.vendor.daftar') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.vendor.daftar') ? 'text-white bg-blue-600 shadow-md' : 'text-slate-500 hover:text-blue-400' }}">Database Mitra</a>
                <a href="{{ route('pengelola.vendor.penawaran') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.vendor.penawaran') ? 'text-white bg-blue-600 shadow-md' : 'text-slate-500 hover:text-blue-400' }}">Penawaran (RFQ)</a>
                <a href="{{ route('pengelola.produk.pembelian.riwayat') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.produk.pembelian.riwayat') ? 'text-white bg-blue-600 shadow-md' : 'text-slate-500 hover:text-blue-400' }}">Pesanan Beli (PO)</a>
            </div>
        </div>

        <!-- 9. MANAJEMEN PEGAWAI & PERAN -->
        <div x-data="{ open: {{ (request()->routeIs('pengelola.hrd*') || request()->routeIs('pengelola.pengguna.hrd')) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-lime-500/10 text-lime-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-user-tie w-6 text-center text-lg" :class="open ? 'text-lime-500' : 'text-lime-400 group-hover:text-lime-300'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">SDM & HRD</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.hrd.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.hrd.beranda') ? 'text-white bg-lime-600 shadow-md' : 'text-slate-500 hover:text-lime-400' }}">Dasbor SDM</a>
                <a href="{{ route('pengelola.pengguna.hrd') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.pengguna.hrd') ? 'text-white bg-lime-600 shadow-md' : 'text-slate-500 hover:text-lime-400' }}">Data Karyawan</a>
                <a href="{{ route('pengelola.hrd.struktur') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.hrd.struktur') ? 'text-white bg-lime-600 shadow-md' : 'text-slate-500 hover:text-lime-400' }}">Struktur Organisasi</a>
            </div>
        </div>

        <!-- 10. MANAJEMEN LAPORAN & ANALITIK -->
        <div x-data="{ open: {{ (request()->routeIs('pengelola.laporan*') || request()->routeIs('pengelola.pengaturan.log') || request()->routeIs('pengelola.produk.analitik')) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-amber-500/10 text-amber-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-magnifying-glass-chart w-6 text-center text-lg" :class="open ? 'text-amber-500' : 'text-amber-400 group-hover:text-amber-300'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Laporan & Audit</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.laporan.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.laporan.beranda') ? 'text-white bg-amber-600 shadow-md' : 'text-slate-500 hover:text-amber-400' }}">Dasbor Laporan</a>
                <a href="{{ route('pengelola.produk.analitik') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.produk.analitik') ? 'text-white bg-amber-600 shadow-md' : 'text-slate-500 hover:text-amber-400' }}">Analitik Produk</a>
                <a href="{{ route('pengelola.pengaturan.log') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.pengaturan.log') ? 'text-white bg-amber-600 shadow-md' : 'text-slate-500 hover:text-amber-400' }}">Log Aktivitas</a>
            </div>
        </div>

        <!-- 11. PENGATURAN SISTEM TERPUSAT -->
        <div class="mt-6 mb-2 px-3" x-show="sidebarOpen"><span class="text-[9px] font-black text-slate-600 uppercase tracking-widest block">Konfigurasi Global</span></div>
        <div x-data="{ open: {{ (request()->routeIs('pengelola.sistem*') || request()->routeIs('pengelola.api*') || request()->routeIs('pengelola.voucher')) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-slate-700/50 text-slate-200': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-gears w-6 text-center text-lg" :class="open ? 'text-slate-200' : 'text-slate-500 group-hover:text-slate-300'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Sistem Terpusat</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.sistem.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.sistem.beranda') ? 'text-white bg-slate-600' : 'text-slate-500 hover:text-slate-300' }}">Dasbor Sistem</a>
                <a href="{{ route('pengelola.sistem.pusat') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.sistem.pusat') ? 'text-white bg-slate-600' : 'text-slate-500 hover:text-slate-300' }}">Konfigurasi Global</a>
                <a href="{{ route('pengelola.voucher') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.voucher') ? 'text-white bg-slate-600' : 'text-slate-500 hover:text-slate-300' }}">Kelola Voucher</a>
                <a href="{{ route('pengelola.sistem.kesehatan') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.sistem.kesehatan') ? 'text-white bg-slate-600' : 'text-slate-500 hover:text-slate-300' }}">Kesehatan Server</a>
                <div class="h-px bg-slate-800 my-1"></div>
                <a href="{{ route('pengelola.api.pusat') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.api.pusat') ? 'text-white bg-slate-600' : 'text-slate-500 hover:text-slate-300' }}">Pusat API Hub</a>
                <a href="{{ route('pengelola.api.pembayaran') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.api.pembayaran') ? 'text-white bg-slate-600' : 'text-slate-500 hover:text-slate-300' }}">Payment Gateway</a>
                <a href="{{ route('pengelola.api.logistik') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.api.logistik') ? 'text-white bg-slate-600' : 'text-slate-500 hover:text-slate-300' }}">Integrasi Kurir</a>
                <a href="{{ route('pengelola.api.whatsapp') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.api.whatsapp') ? 'text-white bg-slate-600' : 'text-slate-500 hover:text-slate-300' }}">WhatsApp API</a>
                <a href="{{ route('pengelola.api.email') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.api.email') ? 'text-white bg-slate-600' : 'text-slate-500 hover:text-slate-300' }}">SMTP Email</a>
                <a href="{{ route('pengelola.api.kunci') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.api.kunci') ? 'text-white bg-slate-600' : 'text-slate-500 hover:text-slate-300' }}">Kunci Akses API</a>
                <a href="{{ route('pengelola.api.log') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.api.log') ? 'text-white bg-slate-600' : 'text-slate-500 hover:text-slate-300' }}">Log Akses API</a>
                <a href="{{ route('pengelola.api.dokumentasi') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.api.dokumentasi') ? 'text-white bg-slate-600' : 'text-slate-500 hover:text-slate-300' }}">Dokumentasi API</a>
            </div>
        </div>

        <!-- 12. PENGATURAN KEAMANAN TERPUSAT -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.keamanan*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-red-500/10 text-red-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-shield-halved w-6 text-center text-lg" :class="open ? 'text-red-500' : 'text-red-400 group-hover:text-red-300'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Keamanan Siber</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.keamanan.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.beranda') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Dasbor Keamanan</a>
                <a href="{{ route('pengelola.keamanan.dasbor') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.dasbor') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Monitor Ancaman</a>
                <a href="{{ route('pengelola.keamanan.firewall') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.firewall') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Firewall WAF</a>
                <a href="{{ route('pengelola.keamanan.pemindai') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.pemindai') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Pemindai Sistem</a>
                <a href="{{ route('pengelola.keamanan.siem') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.siem') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Analisis Log SIEM</a>
                <a href="{{ route('pengelola.keamanan.integritas') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.integritas') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Integritas File</a>
                <a href="{{ route('pengelola.keamanan.ueba') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.ueba') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Analisis UEBA</a>
                <a href="{{ route('pengelola.keamanan.forensik') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.forensik') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Forensik Digital</a>
                <a href="{{ route('pengelola.keamanan.honeypot') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.honeypot') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Jebakan Honeypot</a>
                <a href="{{ route('pengelola.keamanan.ancaman') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.ancaman') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Intel Ancaman</a>
                <a href="{{ route('pengelola.keamanan.pam') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.pam') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Manajemen PAM</a>
                <a href="{{ route('pengelola.keamanan.sesi') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.sesi') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Monitor Sesi</a>
                <a href="{{ route('pengelola.keamanan.dlp') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.dlp') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Proteksi DLP</a>
                <a href="{{ route('pengelola.keamanan.irp') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.irp') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Respon IRP</a>
                <a href="{{ route('pengelola.keamanan.zerotrust') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.zerotrust') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Zero Trust Akses</a>
                <a href="{{ route('pengelola.keamanan.edr') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.edr') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Deteksi EDR</a>
                <a href="{{ route('pengelola.keamanan.cadangan') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase transition-colors {{ request()->routeIs('pengelola.keamanan.cadangan') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400' }}">Cadangan Data</a>
            </div>
        </div>

    </nav>

    <!-- Area Footer -->
    <div class="p-4 bg-slate-900 border-t border-slate-800" x-show="sidebarOpen">
        <div class="bg-gradient-to-r from-indigo-900/50 to-purple-900/50 rounded-xl p-3 border border-indigo-500/20 text-center">
            <span class="text-[10px] font-black text-white uppercase tracking-widest italic tracking-[0.2em]">Teqara Enterprise V12.0</span>
        </div>
    </div>
</aside>