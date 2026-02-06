<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Teqara Enterprise System' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Scrollbar Halus */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="h-full overflow-hidden flex" x-data="{ sidebarOpen: true }">

    <!-- Sidebar Navigasi Enterprise (11 Pilar Utama) -->
    <aside 
        class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 flex flex-col transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 shadow-2xl lg:shadow-none"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <!-- Logo Header -->
        <div class="h-20 flex items-center gap-3 px-6 border-b border-slate-100 bg-white shrink-0">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                <i class="fa-solid fa-earth-asia text-xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="font-black text-xl tracking-tight text-slate-900 leading-none">TEQARA<span class="text-indigo-600">.</span></span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.25em] mt-1">Enterprise v16</span>
            </div>
        </div>

        <!-- Menu Navigasi Lengkap (Granular Split) -->
        <nav class="flex-1 overflow-y-auto custom-scrollbar p-4 space-y-4" x-data="{ 
            activeGroup: '{{ 
                request()->is('admin/toko*') ? 'toko' :
                (request()->is('admin/produk*') || request()->is('admin/kategori*') || request()->is('admin/merek*') ? 'produk' :
                (request()->is('admin/pesanan*') ? 'pesanan' :
                (request()->is('admin/transaksi*') || request()->is('admin/voucher*') ? 'transaksi' :
                (request()->is('admin/cs*') || request()->is('admin/layanan*') ? 'cs' :
                (request()->is('admin/logistik*') ? 'logistik' :
                (request()->is('admin/pelanggan*') ? 'pelanggan' :
                (request()->is('admin/pegawai*') || request()->is('admin/pengguna*') || request()->is('admin/hrd*') ? 'pegawai' :
                (request()->is('admin/laporan*') ? 'laporan' :
                (request()->is('admin/sistem*') || request()->is('admin/pengaturan/sistem*') ? 'sistem' :
                (request()->is('admin/keamanan*') || request()->is('admin/pengaturan/log*') || request()->is('admin/pengaturan/keamanan*') ? 'keamanan' : 
                ''))))))))))
            }}',
            toggle(group) {
                this.activeGroup = this.activeGroup === group ? '' : group;
            }
        }">
            
            <!-- 0. Dashboard Utama -->
            <div>
                <a href="{{ route('admin.beranda') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all {{ request()->routeIs('admin.beranda') ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-100' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <i class="fa-solid fa-gauge-high w-5 text-center"></i>
                    <span class="text-xs uppercase tracking-wide">Pusat Komando</span>
                </a>
            </div>

            <!-- 1. Manajemen Halaman Toko -->
            <div class="border-t border-slate-50 pt-2">
                <button @click="toggle('toko')" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors group">
                    <span>Manajemen Halaman Toko</span>
                    <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="activeGroup === 'toko' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'toko'" x-collapse class="space-y-1 pl-2 mt-1">
                    <a href="{{ route('admin.toko.beranda') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.toko.beranda') ? 'bg-purple-50 text-purple-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-store w-4 text-center text-purple-500"></i> Dashboard Toko
                    </a>
                    <a href="{{ route('admin.toko.konten') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.toko.konten') ? 'bg-purple-50 text-purple-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-pen-nib w-4 text-center text-purple-500"></i> Konten & Banner
                    </a>
                    <a href="{{ route('admin.toko.berita') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.toko.berita') ? 'bg-purple-50 text-purple-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-newspaper w-4 text-center text-purple-500"></i> Berita & Artikel
                    </a>
                </div>
            </div>

            <!-- 2. Manajemen Produk & Gadget -->
            <div class="border-t border-slate-50 pt-2">
                <button @click="toggle('produk')" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors group">
                    <span>Manajemen Produk</span>
                    <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="activeGroup === 'produk' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'produk'" x-collapse class="space-y-1 pl-2 mt-1">
                    <a href="{{ route('admin.produk.beranda') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.produk.beranda') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-chart-pie w-4 text-center text-emerald-500"></i> Dashboard Produk
                    </a>
                    <a href="{{ route('admin.produk.katalog') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.produk.katalog') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-laptop w-4 text-center text-emerald-500"></i> Katalog Produk
                    </a>
                    <a href="{{ route('admin.produk.tambah') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.produk.tambah') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-plus-circle w-4 text-center text-emerald-500"></i> Tambah Produk Baru
                    </a>
                    <a href="{{ route('admin.kategori') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.kategori') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-tags w-4 text-center text-emerald-500"></i> Kategori
                    </a>
                    <a href="{{ route('admin.merek') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.merek') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-copyright w-4 text-center text-emerald-500"></i> Merek & Brand
                    </a>
                    <a href="{{ route('admin.produk.seri') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.produk.seri') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-layer-group w-4 text-center text-emerald-500"></i> Seri & Varian
                    </a>
                    <a href="{{ route('admin.produk.stok') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.produk.stok') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-boxes-stacked w-4 text-center text-emerald-500"></i> Stok Gudang
                    </a>
                    <a href="{{ route('admin.produk.pembelian.riwayat') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.produk.pembelian*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-dolly w-4 text-center text-emerald-500"></i> Pembelian Stok (PO)
                    </a>
                    <a href="{{ route('admin.produk.so.riwayat') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.produk.so*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-clipboard-list w-4 text-center text-emerald-500"></i> Stock Opname
                    </a>
                    <a href="{{ route('admin.produk.garansi') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.produk.garansi') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-shield-halved w-4 text-center text-emerald-500"></i> Klaim Garansi
                    </a>
                </div>
            </div>

            <!-- 3. Manajemen Pesanan -->
            <div class="border-t border-slate-50 pt-2">
                <button @click="toggle('pesanan')" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors group">
                    <span>Manajemen Pesanan</span>
                    <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="activeGroup === 'pesanan' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'pesanan'" x-collapse class="space-y-1 pl-2 mt-1">
                    <a href="{{ route('admin.pesanan.beranda') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.pesanan.beranda') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-clipboard-check w-4 text-center text-blue-500"></i> Dashboard Pesanan
                    </a>
                    <a href="{{ route('admin.pesanan.daftar') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.pesanan.daftar') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-list-ol w-4 text-center text-blue-500"></i> Daftar Pesanan
                    </a>
                </div>
            </div>

            <!-- 4. Manajemen Transaksi -->
            <div class="border-t border-slate-50 pt-2">
                <button @click="toggle('transaksi')" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors group">
                    <span>Manajemen Transaksi</span>
                    <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="activeGroup === 'transaksi' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'transaksi'" x-collapse class="space-y-1 pl-2 mt-1">
                    <a href="{{ route('admin.transaksi.beranda') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.transaksi.beranda') ? 'bg-amber-50 text-amber-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-wallet w-4 text-center text-amber-500"></i> Dashboard Transaksi
                    </a>
                    <a href="{{ route('admin.pesanan.verifikasi') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.pesanan.verifikasi') ? 'bg-amber-50 text-amber-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-money-check-dollar w-4 text-center text-amber-500"></i> Verifikasi Pembayaran
                    </a>
                    <a href="{{ route('admin.produk.promo.flash-sale') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.produk.promo*') ? 'bg-amber-50 text-amber-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-bolt w-4 text-center text-amber-500"></i> Flash Sale & Promo
                    </a>
                    <a href="{{ route('admin.voucher') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.voucher') ? 'bg-amber-50 text-amber-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-ticket w-4 text-center text-amber-500"></i> Voucher
                    </a>
                </div>
            </div>

            <!-- 5. Manajemen Customer Service -->
            <div class="border-t border-slate-50 pt-2">
                <button @click="toggle('cs')" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors group">
                    <span>Manajemen CS</span>
                    <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="activeGroup === 'cs' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'cs'" x-collapse class="space-y-1 pl-2 mt-1">
                    <a href="{{ route('admin.cs.beranda') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.cs.beranda') ? 'bg-pink-50 text-pink-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-headset w-4 text-center text-pink-500"></i> Dashboard Layanan
                    </a>
                    <a href="{{ route('admin.cs.tiket') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.cs.tiket') ? 'bg-pink-50 text-pink-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-life-ring w-4 text-center text-pink-500"></i> Tiket Bantuan
                    </a>
                </div>
            </div>

            <!-- 6. Manajemen Logistik Pengiriman -->
            <div class="border-t border-slate-50 pt-2">
                <button @click="toggle('logistik')" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors group">
                    <span>Manajemen Logistik</span>
                    <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="activeGroup === 'logistik' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'logistik'" x-collapse class="space-y-1 pl-2 mt-1">
                    <a href="{{ route('admin.logistik.beranda') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.logistik.beranda') ? 'bg-orange-50 text-orange-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-truck-fast w-4 text-center text-orange-500"></i> Dashboard Logistik
                    </a>
                    <a href="{{ route('admin.logistik.pemasok') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.logistik.pemasok*') ? 'bg-orange-50 text-orange-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-handshake w-4 text-center text-orange-500"></i> Data Pemasok (Vendor)
                    </a>
                </div>
            </div>

            <!-- 7. Manajemen Pelanggan -->
            <div class="border-t border-slate-50 pt-2">
                <button @click="toggle('pelanggan')" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors group">
                    <span>Manajemen Pelanggan</span>
                    <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="activeGroup === 'pelanggan' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'pelanggan'" x-collapse class="space-y-1 pl-2 mt-1">
                    <a href="{{ route('admin.pelanggan.beranda') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.pelanggan.beranda') ? 'bg-teal-50 text-teal-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-users w-4 text-center text-teal-500"></i> Dashboard CRM
                    </a>
                    <a href="{{ route('admin.pelanggan.daftar') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.pelanggan.daftar') ? 'bg-teal-50 text-teal-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-address-book w-4 text-center text-teal-500"></i> Data Member
                    </a>
                    <a href="{{ route('admin.pelanggan.ulasan') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.pelanggan.ulasan') ? 'bg-teal-50 text-teal-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-star w-4 text-center text-teal-500"></i> Ulasan Produk
                    </a>
                </div>
            </div>

            <!-- 8. Manajemen Pegawai & Peran -->
            <div class="border-t border-slate-50 pt-2">
                <button @click="toggle('pegawai')" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors group">
                    <span>Manajemen Pegawai</span>
                    <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="activeGroup === 'pegawai' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'pegawai'" x-collapse class="space-y-1 pl-2 mt-1">
                    <a href="{{ route('admin.pengguna.beranda') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.pengguna.beranda') ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-briefcase w-4 text-center text-sky-500"></i> Dashboard SDM
                    </a>
                    <a href="{{ route('admin.hrd.karyawan') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.hrd.karyawan') ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-sitemap w-4 text-center text-sky-500"></i> Struktur Organisasi
                    </a>
                    <a href="{{ route('admin.pengguna.hrd') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.pengguna.hrd') ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-id-badge w-4 text-center text-sky-500"></i> Data Karyawan
                    </a>
                </div>
            </div>

            <!-- 9. Manajemen Laporan & Analitik -->
            <div class="border-t border-slate-50 pt-2">
                <button @click="toggle('laporan')" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors group">
                    <span>Laporan & Analitik</span>
                    <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="activeGroup === 'laporan' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'laporan'" x-collapse class="space-y-1 pl-2 mt-1">
                    <a href="{{ route('admin.laporan.pusat') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.laporan.pusat') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-chart-line w-4 text-center text-indigo-500"></i> Pusat Laporan
                    </a>
                </div>
            </div>

            <!-- 10. Pengaturan Sistem Terpusat -->
            <div class="border-t border-slate-50 pt-2">
                <button @click="toggle('sistem')" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors group">
                    <span>Pengaturan Sistem</span>
                    <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="activeGroup === 'sistem' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'sistem'" x-collapse class="space-y-1 pl-2 mt-1">
                    <a href="{{ route('admin.pengaturan.sistem') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.pengaturan.sistem') ? 'bg-slate-100 text-slate-800' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-sliders w-4 text-center text-slate-600"></i> Konfigurasi Global
                    </a>
                </div>
            </div>

            <!-- 11. Pengaturan Keamanan Terpusat -->
            <div class="border-t border-slate-50 pt-2 pb-6">
                <button @click="toggle('keamanan')" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors group">
                    <span>Keamanan Terpusat</span>
                    <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="activeGroup === 'keamanan' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'keamanan'" x-collapse class="space-y-1 pl-2 mt-1">
                    <a href="{{ route('admin.pengaturan.keamanan') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.pengaturan.keamanan') ? 'bg-rose-50 text-rose-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-shield-virus w-4 text-center text-rose-500"></i> Keamanan Sistem
                    </a>
                    <a href="{{ route('admin.pengaturan.log') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.pengaturan.log') ? 'bg-rose-50 text-rose-700' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-file-shield w-4 text-center text-rose-500"></i> Log Audit (Jejak Digital)
                    </a>
                </div>
            </div>

            <!-- Logout -->
            <div class="pt-2 pb-20 border-t border-slate-100">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/20">
                    <i class="fa-solid fa-power-off w-5 text-center"></i>
                    <span class="text-xs uppercase tracking-wider">Keluar Sistem</span>
                </a>
            </div>

        </nav>
        
        <!-- User Profile Footer -->
        <div class="p-4 border-t border-slate-200 bg-slate-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-slate-900 flex items-center justify-center text-white font-bold text-sm shadow-md ring-2 ring-white">
                    {{ substr(auth()->user()->nama ?? 'A', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-black text-slate-800 truncate uppercase">{{ auth()->user()->nama ?? 'Administrator' }}</p>
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest truncate">{{ auth()->user()->peran ?? 'Super Admin' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Konten Utama (Full Width & Accessible) -->
    <main class="flex-1 h-full overflow-hidden flex flex-col bg-[#F8FAFC]">
        <!-- Topbar -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-6 lg:px-10 shrink-0 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-slate-500 hover:bg-slate-100 rounded-xl transition-colors lg:hidden">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <div>
                    <h1 class="text-xl font-black text-slate-800 tracking-tight leading-none">{{ $title ?? 'Pusat Komando' }}</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Enterprise Management System</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center bg-white border border-slate-200 rounded-full px-4 py-2 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500/20 focus-within:border-indigo-500 transition-all">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
                    <input type="text" placeholder="Cari data global..." class="bg-transparent border-none text-sm font-bold text-slate-700 placeholder:text-slate-400 focus:ring-0 ml-2 w-64">
                    <div class="text-[9px] font-bold bg-slate-100 text-slate-500 px-2 py-0.5 rounded border border-slate-200">CTRL+K</div>
                </div>
                <div class="h-8 w-px bg-slate-200 mx-2"></div>
                <button class="relative p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white animate-pulse"></span>
                </button>
                <button class="p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors">
                    <i class="fa-regular fa-circle-question text-xl"></i>
                </button>
            </div>
        </header>

        <!-- Area Konten (Scrollable) -->
        <div class="flex-1 overflow-auto p-6 lg:p-10 custom-scrollbar">
            {{ $slot }}
        </div>
    </main>

    <x-ui.notifikasi-toast />
    @livewireScripts
</body>
</html>
