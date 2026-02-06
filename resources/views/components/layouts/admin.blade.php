<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Teqara Enterprise System' }}</title>
    
    <!-- Fonts: Plus Jakarta Sans (Modern & Corporate) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }

        /* Modern Colorful Gradient (Deep Nebula) */
        .sidebar-gradient { 
            background: linear-gradient(150deg, #312e81 0%, #4338ca 50%, #7c3aed 100%);
        }
        
        /* Glass Effect for Active Items */
        .nav-item-active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #22d3ee; /* Cyan-400 */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body class="h-full overflow-hidden flex bg-slate-100" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/80 z-40 lg:hidden"></div>

    <!-- Sidebar Navigation -->
    <aside 
        class="fixed inset-y-0 left-0 z-50 w-72 sidebar-gradient text-white flex flex-col transition-transform duration-300 ease-in-out shadow-2xl lg:static lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <!-- Header / Logo -->
        <div class="h-24 flex items-center gap-4 px-6 border-b border-white/10 shrink-0 bg-black/10 backdrop-blur-sm">
            <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-indigo-700 shadow-lg shadow-indigo-900/20">
                <i class="fa-solid fa-cube text-2xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="font-extrabold text-2xl tracking-tight leading-none text-white">TEQARA<span class="text-cyan-400">.</span></span>
                <span class="text-[10px] font-bold text-indigo-200 uppercase tracking-[0.25em] mt-1">Enterprise V16</span>
            </div>
        </div>

        <!-- Menu List -->
        <nav class="flex-1 overflow-y-auto custom-scrollbar p-4 space-y-2" x-data="{ 
            activeGroup: '{{ 
                request()->is('admin/toko*') ? 'toko' :
                (request()->is('admin/produk*') || request()->is('admin/kategori*') || request()->is('admin/merek*') ? 'produk' :
                (request()->is('admin/pesanan*') ? 'pesanan' :
                (request()->is('admin/transaksi*') || request()->is('admin/voucher*') ? 'transaksi' :
                (request()->is('admin/cs*') || request()->is('admin/layanan*') ? 'cs' :
                (request()->is('admin/logistik*') ? 'logistik' :
                (request()->is('admin/vendor*') ? 'vendor' :
                (request()->is('admin/pelanggan*') ? 'pelanggan' :
                (request()->is('admin/pegawai*') || request()->is('admin/pengguna*') || request()->is('admin/hrd*') ? 'pegawai' :
                (request()->is('admin/laporan*') ? 'laporan' :
                (request()->is('admin/sistem*') || request()->is('admin/pengaturan/sistem*') ? 'sistem' :
                (request()->is('admin/keamanan*') || request()->is('admin/pengaturan/log*') || request()->is('admin/pengaturan/keamanan*') ? 'keamanan' : 
                '')))))))))))
            }}',
            toggle(group) {
                this.activeGroup = this.activeGroup === group ? '' : group;
            }
        }">
            
            <!-- 1. Dashboard Statistik -->
            <a href="{{ route('pengelola.beranda') }}" wire:navigate class="flex items-center gap-4 px-4 py-3.5 rounded-xl font-bold transition-all group mb-4 {{ request()->routeIs('pengelola.beranda') ? 'nav-item-active' : 'hover:bg-white/10 hover:shadow-lg' }}">
                <div class="w-8 flex justify-center">
                    <i class="fa-solid fa-gauge-high text-lg {{ request()->routeIs('pengelola.beranda') ? 'text-cyan-300' : 'text-indigo-200 group-hover:text-white' }}"></i>
                </div>
                <span class="text-sm tracking-wide">Dashboard Statistik</span>
            </a>

            <!-- Separator -->
            <div class="px-4 pt-2 pb-1">
                <span class="text-[10px] font-black text-indigo-300 uppercase tracking-widest">Manajemen Operasional</span>
            </div>

            <!-- 2. Manajemen Halaman Toko -->
            <div class="rounded-xl overflow-hidden transition-all duration-300" :class="activeGroup === 'toko' ? 'bg-black/20' : ''">
                <button @click="toggle('toko')" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-8 flex justify-center"><i class="fa-solid fa-store text-indigo-200"></i></div>
                        <span>Halaman Toko</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-indigo-300" :class="activeGroup === 'toko' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'toko'" x-collapse class="bg-black/10">
                    <a href="{{ route('pengelola.toko.beranda') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Dashboard Toko
                    </a>
                    <a href="{{ route('pengelola.toko.konten') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Konten & Banner
                    </a>
                    <a href="{{ route('pengelola.toko.berita') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Berita & Artikel
                    </a>
                </div>
            </div>

            <!-- 3. Manajemen Produk & Gadget -->
            <div class="rounded-xl overflow-hidden transition-all duration-300" :class="activeGroup === 'produk' ? 'bg-black/20' : ''">
                <button @click="toggle('produk')" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-8 flex justify-center"><i class="fa-solid fa-mobile-screen-button text-indigo-200"></i></div>
                        <span>Produk & Gadget</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-indigo-300" :class="activeGroup === 'produk' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'produk'" x-collapse class="bg-black/10">
                    <a href="{{ route('pengelola.produk.beranda') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Dashboard Produk
                    </a>
                    <a href="{{ route('pengelola.produk.katalog') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Katalog Produk
                    </a>
                    <a href="{{ route('pengelola.produk.tambah') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Tambah Baru
                    </a>
                    <a href="{{ route('pengelola.kategori') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Kategori
                    </a>
                    <a href="{{ route('pengelola.merek') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Merek & Brand
                    </a>
                    <a href="{{ route('pengelola.produk.seri') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Seri & Varian
                    </a>
                    <a href="{{ route('pengelola.produk.stok') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Stok Gudang
                    </a>
                    <a href="{{ route('pengelola.produk.pembelian.riwayat') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Pembelian (PO)
                    </a>
                    <a href="{{ route('pengelola.produk.so.riwayat') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Stock Opname
                    </a>
                    <a href="{{ route('pengelola.produk.garansi') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Garansi
                    </a>
                </div>
            </div>

            <!-- 4. Manajemen Pesanan -->
            <div class="rounded-xl overflow-hidden transition-all duration-300" :class="activeGroup === 'pesanan' ? 'bg-black/20' : ''">
                <button @click="toggle('pesanan')" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-8 flex justify-center"><i class="fa-solid fa-receipt text-indigo-200"></i></div>
                        <span>Pesanan</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-indigo-300" :class="activeGroup === 'pesanan' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'pesanan'" x-collapse class="bg-black/10">
                    <a href="{{ route('pengelola.pesanan.beranda') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Dashboard Pesanan
                    </a>
                    <a href="{{ route('pengelola.pesanan.daftar') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Daftar Pesanan
                    </a>
                </div>
            </div>

            <!-- 5. Manajemen Transaksi -->
            <div class="rounded-xl overflow-hidden transition-all duration-300" :class="activeGroup === 'transaksi' ? 'bg-black/20' : ''">
                <button @click="toggle('transaksi')" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-8 flex justify-center"><i class="fa-solid fa-wallet text-indigo-200"></i></div>
                        <span>Transaksi</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-indigo-300" :class="activeGroup === 'transaksi' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'transaksi'" x-collapse class="bg-black/10">
                    <a href="{{ route('pengelola.transaksi.beranda') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Dashboard Keuangan
                    </a>
                    <a href="{{ route('pengelola.pesanan.verifikasi') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Verifikasi Bayar
                    </a>
                    <a href="{{ route('pengelola.produk.promo.flash-sale') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Flash Sale
                    </a>
                    <a href="{{ route('pengelola.voucher') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Voucher
                    </a>
                </div>
            </div>

            <!-- 6. Manajemen Customer Service -->
            <div class="rounded-xl overflow-hidden transition-all duration-300" :class="activeGroup === 'cs' ? 'bg-black/20' : ''">
                <button @click="toggle('cs')" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-8 flex justify-center"><i class="fa-solid fa-headset text-indigo-200"></i></div>
                        <span>Customer Service</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-indigo-300" :class="activeGroup === 'cs' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'cs'" x-collapse class="bg-black/10">
                    <a href="{{ route('pengelola.cs.beranda') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Dashboard Layanan
                    </a>
                    <a href="{{ route('pengelola.cs.tiket') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Tiket Bantuan
                    </a>
                </div>
            </div>

            <!-- 7. Manajemen Logistik Pengiriman -->
            <div class="rounded-xl overflow-hidden transition-all duration-300" :class="activeGroup === 'logistik' ? 'bg-black/20' : ''">
                <button @click="toggle('logistik')" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-8 flex justify-center"><i class="fa-solid fa-truck-fast text-indigo-200"></i></div>
                        <span>Logistik Pengiriman</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-indigo-300" :class="activeGroup === 'logistik' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'logistik'" x-collapse class="bg-black/10">
                    <a href="{{ route('pengelola.logistik.beranda') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Dashboard Logistik
                    </a>
                </div>
            </div>

            <!-- Separator -->
            <div class="px-4 pt-4 pb-1">
                <span class="text-[10px] font-black text-indigo-300 uppercase tracking-widest">Relasi & SDM</span>
            </div>

            <!-- 8. Manajemen Vendor -->
            <div class="rounded-xl overflow-hidden transition-all duration-300" :class="activeGroup === 'vendor' ? 'bg-black/20' : ''">
                <button @click="toggle('vendor')" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-8 flex justify-center"><i class="fa-solid fa-handshake text-indigo-200"></i></div>
                        <span>Manajemen Vendor</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-indigo-300" :class="activeGroup === 'vendor' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'vendor'" x-collapse class="bg-black/10">
                    <a href="{{ route('pengelola.vendor.beranda') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Dashboard Vendor
                    </a>
                    <a href="{{ route('pengelola.vendor.daftar') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Daftar Pemasok
                    </a>
                </div>
            </div>

            <!-- 9. Manajemen Pelanggan -->
            <div class="rounded-xl overflow-hidden transition-all duration-300" :class="activeGroup === 'pelanggan' ? 'bg-black/20' : ''">
                <button @click="toggle('pelanggan')" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-8 flex justify-center"><i class="fa-solid fa-users text-indigo-200"></i></div>
                        <span>Pelanggan</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-indigo-300" :class="activeGroup === 'pelanggan' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'pelanggan'" x-collapse class="bg-black/10">
                    <a href="{{ route('pengelola.pelanggan.beranda') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Dashboard CRM
                    </a>
                    <a href="{{ route('pengelola.pelanggan.daftar') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Data Member
                    </a>
                    <a href="{{ route('pengelola.pelanggan.ulasan') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Ulasan
                    </a>
                </div>
            </div>

            <!-- 10. Manajemen Pegawai & Peran -->
            <div class="rounded-xl overflow-hidden transition-all duration-300" :class="activeGroup === 'pegawai' ? 'bg-black/20' : ''">
                <button @click="toggle('pegawai')" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-8 flex justify-center"><i class="fa-solid fa-id-card-clip text-indigo-200"></i></div>
                        <span>Pegawai & Peran</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-indigo-300" :class="activeGroup === 'pegawai' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'pegawai'" x-collapse class="bg-black/10">
                    <a href="{{ route('pengelola.pengguna.beranda') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Dashboard SDM
                    </a>
                    <a href="{{ route('pengelola.hrd.karyawan') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Struktur Organisasi
                    </a>
                    <a href="{{ route('pengelola.pengguna.hrd') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Data Karyawan
                    </a>
                </div>
            </div>

            <!-- Separator -->
            <div class="px-4 pt-4 pb-1">
                <span class="text-[10px] font-black text-indigo-300 uppercase tracking-widest">Sistem & Keamanan</span>
            </div>

            <!-- 11. Manajemen Laporan & Analitik -->
            <div class="rounded-xl overflow-hidden transition-all duration-300" :class="activeGroup === 'laporan' ? 'bg-black/20' : ''">
                <button @click="toggle('laporan')" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-8 flex justify-center"><i class="fa-solid fa-chart-line text-indigo-200"></i></div>
                        <span>Laporan & Analitik</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-indigo-300" :class="activeGroup === 'laporan' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'laporan'" x-collapse class="bg-black/10">
                    <a href="{{ route('pengelola.laporan.pusat') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Pusat Laporan
                    </a>
                </div>
            </div>

            <!-- 12. Pengaturan Sistem Terpusat -->
            <div class="rounded-xl overflow-hidden transition-all duration-300" :class="activeGroup === 'sistem' ? 'bg-black/20' : ''">
                <button @click="toggle('sistem')" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-8 flex justify-center"><i class="fa-solid fa-sliders text-indigo-200"></i></div>
                        <span>Pengaturan Sistem</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-indigo-300" :class="activeGroup === 'sistem' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'sistem'" x-collapse class="bg-black/10">
                    <a href="{{ route('pengelola.pengaturan.sistem') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Identitas Toko
                    </a>
                </div>
            </div>

            <!-- 13. Pengaturan Keamanan Terpusat -->
            <div class="rounded-xl overflow-hidden transition-all duration-300" :class="activeGroup === 'keamanan' ? 'bg-black/20' : ''">
                <button @click="toggle('keamanan')" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-8 flex justify-center"><i class="fa-solid fa-shield-halved text-indigo-200"></i></div>
                        <span>Pengaturan Keamanan</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-indigo-300" :class="activeGroup === 'keamanan' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeGroup === 'keamanan'" x-collapse class="bg-black/10">
                    <a href="{{ route('pengelola.pengaturan.keamanan') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Keamanan Sistem
                    </a>
                    <a href="{{ route('pengelola.pengaturan.log') }}" wire:navigate class="flex items-center gap-3 pl-14 pr-4 py-2.5 text-xs font-medium text-indigo-100 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-regular fa-circle text-[8px] opacity-70"></i> Jejak Audit (Log)
                    </a>
                </div>
            </div>

            <!-- Logout -->
            <div class="pt-6 pb-20">
                <a href="{{ route('logout') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold transition-all border border-white/5 hover:border-white/20">
                    <div class="w-8 flex justify-center"><i class="fa-solid fa-power-off text-rose-300"></i></div>
                    <span class="text-sm">Keluar Sistem</span>
                </a>
            </div>

        </nav>
        
        <!-- User Footer -->
        <div class="p-4 border-t border-white/10 bg-black/20 backdrop-blur-md">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-cyan-400 to-indigo-500 p-0.5">
                    <div class="w-full h-full rounded-full bg-slate-900 flex items-center justify-center">
                        <span class="text-white font-bold text-sm">{{ substr(auth()->user()->nama ?? 'A', 0, 1) }}</span>
                    </div>
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-white truncate uppercase tracking-wide">{{ auth()->user()->nama ?? 'Administrator' }}</p>
                    <p class="text-[9px] font-medium text-indigo-200 uppercase tracking-widest truncate">{{ auth()->user()->peran ?? 'Super Admin' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 h-full overflow-hidden flex flex-col bg-slate-50">
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 lg:px-8 shrink-0 sticky top-0 z-30 shadow-sm">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition-colors lg:hidden">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-bold text-slate-800 tracking-tight leading-none hidden sm:block">{{ $title ?? 'Pusat Komando' }}</h1>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <!-- Status System -->
                <div class="hidden lg:flex items-center gap-4 mr-4 bg-slate-50 px-3 py-1.5 rounded-full border border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">System OK</span>
                    </div>
                </div>

                <div class="hidden md:flex items-center bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 focus-within:ring-2 focus-within:ring-indigo-500/20 focus-within:border-indigo-500 transition-all w-64">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
                    <input type="text" placeholder="Cari cepat (CTRL+K)..." class="bg-transparent border-none text-xs font-semibold text-slate-700 placeholder:text-slate-400 focus:ring-0 ml-2 w-full">
                </div>

                <button class="relative p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                    <i class="fa-regular fa-bell text-lg"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                </button>
            </div>
        </header>

        <!-- Area Konten -->
        <div class="flex-1 overflow-auto p-4 lg:p-8 custom-scrollbar relative">
            {{ $slot }}
        </div>
    </main>

    <x-ui.notifikasi-toast />
    @livewireScripts
</body>
</html>
