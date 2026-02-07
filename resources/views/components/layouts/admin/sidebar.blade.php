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

    <!-- User Profile Compact -->
    <div class="px-3 py-4 border-b border-slate-800 bg-slate-900/50" x-show="sidebarOpen" x-transition>
        <div class="bg-slate-800/40 rounded-xl p-3 flex items-center gap-3 border border-slate-700/30 hover:bg-slate-800 transition-colors cursor-pointer group">
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-emerald-400 to-cyan-500 p-[2px]">
                <div class="w-full h-full rounded-full bg-slate-900 flex items-center justify-center overflow-hidden">
                    @if(auth()->user()->foto_profil)
                        <img src="{{ asset(auth()->user()->foto_profil) }}" class="w-full h-full object-cover">
                    @else
                        <span class="font-bold text-emerald-400">{{ substr(auth()->user()->nama ?? 'A', 0, 1) }}</span>
                    @endif
                </div>
            </div>
            <div class="flex-1 overflow-hidden">
                <h4 class="text-xs font-bold text-slate-200 truncate group-hover:text-white transition-colors">{{ auth()->user()->nama ?? 'Administrator' }}</h4>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] text-emerald-400 font-medium">Super Admin</span>
                </div>
            </div>
            <a href="{{ route('logout') }}" class="text-slate-600 hover:text-rose-400 transition-colors p-2"><i class="fa-solid fa-power-off"></i></a>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1.5 dark-scroll text-sm">
        
        <!-- DASHBOARD -->
        <a href="{{ route('pengelola.beranda') }}" wire:navigate class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('pengelola.beranda') ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-lg shadow-indigo-900/50 border border-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-chart-line w-6 text-center text-lg {{ request()->routeIs('pengelola.beranda') ? 'text-white' : 'text-indigo-400 group-hover:text-indigo-300' }}"></i>
            <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Ringkasan Bisnis</span>
        </a>

        <!-- Section Label -->
        <div class="mt-6 mb-2 px-3" x-show="sidebarOpen"><span class="text-[9px] font-black text-slate-600 uppercase tracking-widest border-b border-slate-800/50 pb-1 block">Logistik & Produk</span></div>

        <!-- 2. KATALOG (Rose) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.produk.katalog') || request()->routeIs('pengelola.kategori*') || request()->routeIs('pengelola.merek*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-rose-500/10 text-rose-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-box-open w-6 text-center text-lg transition-colors" :class="open ? 'text-rose-500' : 'text-slate-500 group-hover:text-rose-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Katalog Produk</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.produk.katalog') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.produk.katalog') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400 hover:bg-rose-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.produk.katalog') ? 'bg-white' : 'bg-slate-600 group-hover:bg-rose-400' }}"></span> Daftar Produk
                </a>
                <a href="{{ route('pengelola.kategori') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.kategori*') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400 hover:bg-rose-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.kategori*') ? 'bg-white' : 'bg-slate-600 group-hover:bg-rose-400' }}"></span> Kategori
                </a>
                <a href="{{ route('pengelola.merek') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.merek*') ? 'text-white bg-rose-600 shadow-md' : 'text-slate-500 hover:text-rose-400 hover:bg-rose-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.merek*') ? 'bg-white' : 'bg-slate-600 group-hover:bg-rose-400' }}"></span> Merek
                </a>
            </div>
        </div>

        <!-- 3. INVENTARIS (Amber) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.produk.stok') || request()->routeIs('pengelola.produk.gudang') || request()->routeIs('pengelola.produk.so*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-amber-500/10 text-amber-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-warehouse w-6 text-center text-lg transition-colors" :class="open ? 'text-amber-500' : 'text-slate-500 group-hover:text-amber-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Inventaris & Stok</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.produk.stok') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.produk.stok') ? 'text-white bg-amber-600 shadow-md' : 'text-slate-500 hover:text-amber-400 hover:bg-amber-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.produk.stok') ? 'bg-white' : 'bg-slate-600 group-hover:bg-amber-400' }}"></span> Stok Real-time
                </a>
                <a href="{{ route('pengelola.produk.gudang') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.produk.gudang') ? 'text-white bg-amber-600 shadow-md' : 'text-slate-500 hover:text-amber-400 hover:bg-amber-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.produk.gudang') ? 'bg-white' : 'bg-slate-600 group-hover:bg-amber-400' }}"></span> Lokasi Gudang
                </a>
                <a href="{{ route('pengelola.produk.so.riwayat') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.produk.so.riwayat') ? 'text-white bg-amber-600 shadow-md' : 'text-slate-500 hover:text-amber-400 hover:bg-amber-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.produk.so.riwayat') ? 'bg-white' : 'bg-slate-600 group-hover:bg-amber-400' }}"></span> Stock Opname
                </a>
            </div>
        </div>

        <!-- 4. PENGADAAN (Blue) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.vendor*') || request()->routeIs('pengelola.produk.pembelian*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-blue-500/10 text-blue-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-truck-fast w-6 text-center text-lg transition-colors" :class="open ? 'text-blue-500' : 'text-slate-500 group-hover:text-blue-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Pengadaan (B2B)</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.produk.pembelian.riwayat') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.produk.pembelian.riwayat') ? 'text-white bg-blue-600 shadow-md' : 'text-slate-500 hover:text-blue-400 hover:bg-blue-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.produk.pembelian.riwayat') ? 'bg-white' : 'bg-slate-600 group-hover:bg-blue-400' }}"></span> Purchase Order
                </a>
                <a href="{{ route('pengelola.vendor.penawaran') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.vendor.penawaran') ? 'text-white bg-blue-600 shadow-md' : 'text-slate-500 hover:text-blue-400 hover:bg-blue-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.vendor.penawaran') ? 'bg-white' : 'bg-slate-600 group-hover:bg-blue-400' }}"></span> Penawaran (RFQ)
                </a>
                <a href="{{ route('pengelola.vendor.daftar') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.vendor.daftar') ? 'text-white bg-blue-600 shadow-md' : 'text-slate-500 hover:text-blue-400 hover:bg-blue-500/10' }}">
                    <i class="fa-solid fa-address-book w-4"></i> Database Vendor
                </a>
            </div>
        </div>

        <!-- 5. LOGISTIK PENGIRIMAN (Orange) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.logistik*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-orange-500/10 text-orange-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-truck-ramp-box w-6 text-center text-lg transition-colors" :class="open ? 'text-orange-500' : 'text-slate-500 group-hover:text-orange-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Logistik Pengiriman</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.logistik.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.logistik.beranda') ? 'text-white bg-orange-600 shadow-md' : 'text-slate-500 hover:text-orange-400 hover:bg-orange-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.logistik.beranda') ? 'bg-white' : 'bg-slate-600 group-hover:bg-orange-400' }}"></span> Dashboard Logistik
                </a>
                <a href="{{ route('pengelola.api.logistik') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.api.logistik') ? 'text-white bg-orange-600 shadow-md' : 'text-slate-500 hover:text-orange-400 hover:bg-orange-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.api.logistik') ? 'bg-white' : 'bg-slate-600 group-hover:bg-orange-400' }}"></span> Integrasi Kurir
                </a>
            </div>
        </div>

        <!-- Section Label -->
        <div class="mt-6 mb-2 px-3" x-show="sidebarOpen"><span class="text-[9px] font-black text-slate-600 uppercase tracking-widest border-b border-slate-800/50 pb-1 block">Penjualan & Pelanggan</span></div>

        <!-- 6. PESANAN (Emerald) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.pesanan*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-emerald-500/10 text-emerald-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-cart-shopping w-6 text-center text-lg transition-colors" :class="open ? 'text-emerald-500' : 'text-slate-500 group-hover:text-emerald-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Manajemen Pesanan</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.pesanan.daftar') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.pesanan.daftar') ? 'text-white bg-emerald-600 shadow-md' : 'text-slate-500 hover:text-emerald-400 hover:bg-emerald-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.pesanan.daftar') ? 'bg-white' : 'bg-slate-600 group-hover:bg-emerald-400' }}"></span> Daftar Pesanan
                </a>
                <a href="{{ route('pengelola.pesanan.verifikasi') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.pesanan.verifikasi') ? 'text-white bg-emerald-600 shadow-md' : 'text-slate-500 hover:text-emerald-400 hover:bg-emerald-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.pesanan.verifikasi') ? 'bg-white' : 'bg-slate-600 group-hover:bg-emerald-400' }}"></span> Verifikasi Bayar
                </a>
            </div>
        </div>

        <!-- 6. PELANGGAN (Sky) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.pelanggan*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-sky-500/10 text-sky-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-users w-6 text-center text-lg transition-colors" :class="open ? 'text-sky-500' : 'text-slate-500 group-hover:text-sky-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">CRM & Member</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.pelanggan.daftar') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.pelanggan.daftar') ? 'text-white bg-sky-600 shadow-md' : 'text-slate-500 hover:text-sky-400 hover:bg-sky-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.pelanggan.daftar') ? 'bg-white' : 'bg-slate-600 group-hover:bg-sky-400' }}"></span> Data Pelanggan
                </a>
                <a href="{{ route('pengelola.pelanggan.ulasan') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.pelanggan.ulasan') ? 'text-white bg-sky-600 shadow-md' : 'text-slate-500 hover:text-sky-400 hover:bg-sky-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.pelanggan.ulasan') ? 'bg-white' : 'bg-slate-600 group-hover:bg-sky-400' }}"></span> Ulasan & Rating
                </a>
            </div>
        </div>

        <!-- 7. LAYANAN & SUPPORT (Violet) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.cs*') || request()->routeIs('pengelola.produk.garansi') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-violet-500/10 text-violet-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-headset w-6 text-center text-lg transition-colors" :class="open ? 'text-violet-500' : 'text-slate-500 group-hover:text-violet-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Layanan Pelanggan</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.cs.tiket') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.cs.tiket') ? 'text-white bg-violet-600 shadow-md' : 'text-slate-500 hover:text-violet-400 hover:bg-violet-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.cs.tiket') ? 'bg-white' : 'bg-slate-600 group-hover:bg-violet-400' }}"></span> Tiket Bantuan
                </a>
                <a href="{{ route('pengelola.produk.garansi') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.produk.garansi') ? 'text-white bg-violet-600 shadow-md' : 'text-slate-500 hover:text-violet-400 hover:bg-violet-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.produk.garansi') ? 'bg-white' : 'bg-slate-600 group-hover:bg-violet-400' }}"></span> Klaim Garansi
                </a>
            </div>
        </div>

        <!-- NEW: CMS & KONTEN (Pink) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.toko*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-pink-500/10 text-pink-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-newspaper w-6 text-center text-lg transition-colors" :class="open ? 'text-pink-500' : 'text-slate-500 group-hover:text-pink-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">CMS & Konten</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.toko.berita') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.toko.berita') ? 'text-white bg-pink-600 shadow-md' : 'text-slate-500 hover:text-pink-400 hover:bg-pink-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.toko.berita') ? 'bg-white' : 'bg-slate-600 group-hover:bg-pink-400' }}"></span> Berita / Blog
                </a>
                <a href="{{ route('pengelola.toko.konten') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.toko.konten') ? 'text-white bg-pink-600 shadow-md' : 'text-slate-500 hover:text-pink-400 hover:bg-pink-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.toko.konten') ? 'bg-white' : 'bg-slate-600 group-hover:bg-pink-400' }}"></span> Halaman & Banner
                </a>
            </div>
        </div>

        <!-- Section Label -->
        <div class="mt-6 mb-2 px-3" x-show="sidebarOpen"><span class="text-[9px] font-black text-slate-600 uppercase tracking-widest border-b border-slate-800/50 pb-1 block">Keuangan & SDM</span></div>

        <!-- 8. KEUANGAN (Teal) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.transaksi*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-teal-500/10 text-teal-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-coins w-6 text-center text-lg transition-colors" :class="open ? 'text-teal-500' : 'text-slate-500 group-hover:text-teal-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Keuangan & Akuntansi</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.transaksi.beranda') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.transaksi.beranda') ? 'text-white bg-teal-600 shadow-md' : 'text-slate-500 hover:text-teal-400 hover:bg-teal-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.transaksi.beranda') ? 'bg-white' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span> Jurnal Transaksi
                </a>
                 <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide text-slate-600 hover:text-slate-500 cursor-not-allowed" title="Segera Hadir">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-700"></span> Laporan Laba Rugi
                </a>
            </div>
        </div>

        <!-- 9. SDM / HRD (Lime) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.pengguna.hrd') || request()->routeIs('pengelola.hrd*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-lime-500/10 text-lime-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-user-tie w-6 text-center text-lg transition-colors" :class="open ? 'text-lime-500' : 'text-slate-500 group-hover:text-lime-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Human Capital (HRD)</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.pengguna.hrd') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.pengguna.hrd') ? 'text-white bg-lime-600 shadow-md' : 'text-slate-500 hover:text-lime-400 hover:bg-lime-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.pengguna.hrd') ? 'bg-white' : 'bg-slate-600 group-hover:bg-lime-400' }}"></span> Data Karyawan
                </a>
                <a href="{{ route('pengelola.hrd.struktur') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.hrd.struktur') ? 'text-white bg-lime-600 shadow-md' : 'text-slate-500 hover:text-lime-400 hover:bg-lime-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.hrd.struktur') ? 'bg-white' : 'bg-slate-600 group-hover:bg-lime-400' }}"></span> Struktur Organisasi
                </a>
            </div>
        </div>

        <!-- Section Label -->
        <div class="mt-6 mb-2 px-3" x-show="sidebarOpen"><span class="text-[9px] font-black text-slate-600 uppercase tracking-widest border-b border-slate-800/50 pb-1 block">Sistem & Keamanan</span></div>

        <!-- 10. MANAJEMEN API (Cyan) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.api.pembayaran') || request()->routeIs('pengelola.api.logistik') || request()->routeIs('pengelola.api.email') || request()->routeIs('pengelola.api.whatsapp') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-cyan-500/10 text-cyan-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-network-wired w-6 text-center text-lg transition-colors" :class="open ? 'text-cyan-500' : 'text-slate-500 group-hover:text-cyan-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Integrasi Layanan</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.api.pembayaran') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.api.pembayaran') ? 'text-white bg-cyan-600 shadow-md' : 'text-slate-500 hover:text-cyan-400 hover:bg-cyan-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.api.pembayaran') ? 'bg-white' : 'bg-slate-600 group-hover:bg-cyan-400' }}"></span> Payment Gateway
                </a>
                <a href="{{ route('pengelola.api.whatsapp') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.api.whatsapp') ? 'text-white bg-cyan-600 shadow-md' : 'text-slate-500 hover:text-cyan-400 hover:bg-cyan-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.api.whatsapp') ? 'bg-white' : 'bg-slate-600 group-hover:bg-cyan-400' }}"></span> WhatsApp API
                </a>
                <a href="{{ route('pengelola.api.email') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.api.email') ? 'text-white bg-cyan-600 shadow-md' : 'text-slate-500 hover:text-cyan-400 hover:bg-cyan-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.api.email') ? 'bg-white' : 'bg-slate-600 group-hover:bg-cyan-400' }}"></span> Email SMTP
                </a>
            </div>
        </div>

        <!-- 11. PLATFORM API (Indigo) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.api.pusat') || request()->routeIs('pengelola.api.kunci') || request()->routeIs('pengelola.api.log') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-indigo-500/10 text-indigo-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-code w-6 text-center text-lg transition-colors" :class="open ? 'text-indigo-500' : 'text-slate-500 group-hover:text-indigo-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Platform API</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.api.pusat') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.api.pusat') ? 'text-white bg-indigo-600 shadow-md' : 'text-slate-500 hover:text-indigo-400 hover:bg-indigo-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.api.pusat') ? 'bg-white' : 'bg-slate-600 group-hover:bg-indigo-400' }}"></span> Status Hub
                </a>
                <a href="{{ route('pengelola.api.kunci') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.api.kunci') ? 'text-white bg-indigo-600 shadow-md' : 'text-slate-500 hover:text-indigo-400 hover:bg-indigo-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.api.kunci') ? 'bg-white' : 'bg-slate-600 group-hover:bg-indigo-400' }}"></span> Kunci API
                </a>
                <a href="{{ route('pengelola.api.log') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.api.log') ? 'text-white bg-indigo-600 shadow-md' : 'text-slate-500 hover:text-indigo-400 hover:bg-indigo-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.api.log') ? 'bg-white' : 'bg-slate-600 group-hover:bg-indigo-400' }}"></span> Log Akses
                </a>
            </div>
        </div>

        <!-- 12. KEAMANAN (Red) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.keamanan*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-red-500/10 text-red-400': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-shield-cat w-6 text-center text-lg transition-colors" :class="open ? 'text-red-500' : 'text-slate-500 group-hover:text-red-400'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Keamanan Siber</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.keamanan.dashboard') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.dashboard') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.keamanan.dashboard') ? 'bg-white' : 'bg-slate-600 group-hover:bg-red-400' }}"></span> Dashboard SOC
                </a>
                <a href="{{ route('pengelola.keamanan.firewall') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.firewall') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.keamanan.firewall') ? 'bg-white' : 'bg-slate-600 group-hover:bg-red-400' }}"></span> WAF / Firewall
                </a>
                <a href="{{ route('pengelola.keamanan.sesi') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.sesi') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.keamanan.sesi') ? 'bg-white' : 'bg-slate-600 group-hover:bg-red-400' }}"></span> Monitor Sesi
                </a>
                 <a href="{{ route('pengelola.keamanan.pemindai') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.pemindai') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.keamanan.pemindai') ? 'bg-white' : 'bg-slate-600 group-hover:bg-red-400' }}"></span> Audit & Scan
                </a>
                <a href="{{ route('pengelola.keamanan.ancaman') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.ancaman') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.keamanan.ancaman') ? 'bg-white' : 'bg-slate-600 group-hover:bg-red-400' }}"></span> Intelijen Ancaman
                </a>
                <a href="{{ route('pengelola.keamanan.integritas') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.integritas') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.keamanan.integritas') ? 'bg-white' : 'bg-slate-600 group-hover:bg-red-400' }}"></span> Integritas File
                </a>
                <a href="{{ route('pengelola.keamanan.honeypot') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.honeypot') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.keamanan.honeypot') ? 'bg-white' : 'bg-slate-600 group-hover:bg-red-400' }}"></span> Jebakan Honeypot
                </a>
                <a href="{{ route('pengelola.keamanan.dlp') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.dlp') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.keamanan.dlp') ? 'bg-white' : 'bg-slate-600 group-hover:bg-red-400' }}"></span> DLP (Kebocoran Data)
                </a>
                <a href="{{ route('pengelola.keamanan.siem') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.siem') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.keamanan.siem') ? 'bg-white' : 'bg-slate-600 group-hover:bg-red-400' }}"></span> SIEM Log Analisis
                </a>
                <a href="{{ route('pengelola.keamanan.zerotrust') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.zerotrust') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.keamanan.zerotrust') ? 'bg-white' : 'bg-slate-600 group-hover:bg-red-400' }}"></span> Zero Trust Access
                </a>
                <a href="{{ route('pengelola.keamanan.pam') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.pam') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.keamanan.pam') ? 'bg-white' : 'bg-slate-600 group-hover:bg-red-400' }}"></span> PAM (Akses Privilege)
                </a>
                <a href="{{ route('pengelola.keamanan.irp') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.irp') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.keamanan.irp') ? 'bg-white' : 'bg-slate-600 group-hover:bg-red-400' }}"></span> Respon Insiden (IRP)
                </a>
                <a href="{{ route('pengelola.keamanan.edr') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.keamanan.edr') ? 'text-white bg-red-600 shadow-md' : 'text-slate-500 hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.keamanan.edr') ? 'bg-white' : 'bg-slate-600 group-hover:bg-red-400' }}"></span> Deteksi Endpoint (EDR)
                </a>
            </div>
        </div>

        <!-- 13. PENGATURAN SISTEM (Gray) -->
        <div x-data="{ open: {{ request()->routeIs('pengelola.sistem*') || request()->routeIs('pengelola.pengaturan.log') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white" :class="{'bg-slate-700/50 text-slate-200': open}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-sliders w-6 text-center text-lg transition-colors" :class="open ? 'text-slate-200' : 'text-slate-500 group-hover:text-slate-200'"></i>
                    <span class="font-bold tracking-wide text-xs uppercase" x-show="sidebarOpen">Sistem Terpusat</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="pl-11 pr-1 space-y-1 mt-1">
                <a href="{{ route('pengelola.sistem.pusat') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.sistem.pusat') ? 'text-white bg-slate-600 shadow-md' : 'text-slate-500 hover:text-slate-300 hover:bg-slate-700/30' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.sistem.pusat') ? 'bg-white' : 'bg-slate-600 group-hover:bg-slate-400' }}"></span> Konfigurasi Global
                </a>
                <a href="{{ route('pengelola.sistem.kesehatan') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.sistem.kesehatan') ? 'text-white bg-slate-600 shadow-md' : 'text-slate-500 hover:text-slate-300 hover:bg-slate-700/30' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.sistem.kesehatan') ? 'bg-white' : 'bg-slate-600 group-hover:bg-slate-400' }}"></span> Kesehatan Server
                </a>
                <a href="{{ route('pengelola.pengaturan.log') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wide transition-colors {{ request()->routeIs('pengelola.pengaturan.log') ? 'text-white bg-slate-600 shadow-md' : 'text-slate-500 hover:text-slate-300 hover:bg-slate-700/30' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('pengelola.pengaturan.log') ? 'bg-white' : 'bg-slate-600 group-hover:bg-slate-400' }}"></span> Audit Trail
                </a>
            </div>
        </div>

    </nav>

    <!-- Footer Area -->
    <div class="p-4 bg-slate-900 border-t border-slate-800" x-show="sidebarOpen">
        <div class="bg-gradient-to-r from-indigo-900/50 to-purple-900/50 rounded-xl p-3 border border-indigo-500/20">
            <h5 class="text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-1">Status Sistem</h5>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-white">V 16.0 Enterprise</span>
                <i class="fa-solid fa-circle-check text-emerald-500 text-xs animate-pulse"></i>
            </div>
        </div>
    </div>
</aside>