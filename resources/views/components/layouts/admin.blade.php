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
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="h-full overflow-hidden" x-data="{ sidebarOpen: true }">

    <!-- Sidebar Navigasi -->
    <aside 
        class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-white transition-transform duration-300 ease-in-out flex flex-col border-r border-slate-800"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <!-- Logo Area -->
        <div class="h-16 flex items-center gap-3 px-6 bg-slate-950 border-b border-slate-800 shrink-0">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-cyan-500 flex items-center justify-center font-black text-white">T</div>
            <span class="font-black tracking-widest uppercase text-lg">TEQARA<span class="text-cyan-400">.</span>ENT</span>
        </div>

        <!-- Menu Scroll Area -->
        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-8 custom-scrollbar">
            
            <!-- Pilar 0: Pusat Komando -->
            <div>
                <p class="px-3 text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Pusat Komando</p>
                <a href="{{ route('admin.beranda') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.beranda') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-all group">
                    <i class="fa-solid fa-chart-pie w-5 text-center group-hover:scale-110 transition-transform"></i>
                    Dashboard Utama
                </a>
            </div>

            <!-- Pilar 1 & 2: Hulu (Produk & Toko) -->
            <div>
                <p class="px-3 text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Manajemen Hulu (Produk)</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.toko.beranda') }}" wire:navigate class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('admin/toko*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                        <i class="fa-solid fa-store w-5 text-center"></i> Halaman Toko & CMS
                    </a>
                    <a href="{{ route('admin.produk.beranda') }}" wire:navigate class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('admin/produk*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                        <i class="fa-solid fa-box-open w-5 text-center"></i> Inventaris Produk
                    </a>
                    <a href="{{ route('admin.kategori') }}" wire:navigate class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('admin.kategori') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                        <i class="fa-solid fa-tags w-5 text-center"></i> Kategori & Atribut
                    </a>
                </div>
            </div>

            <!-- Pilar 3 & 4: Tengah (Transaksi) -->
            <div>
                <p class="px-3 text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Manajemen Tengah (Transaksi)</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.pesanan.beranda') }}" wire:navigate class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('admin/pesanan*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                        <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i> Sirkulasi Pesanan
                    </a>
                    <a href="{{ route('admin.transaksi.beranda') }}" wire:navigate class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('admin/transaksi*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                        <i class="fa-solid fa-wallet w-5 text-center"></i> Keuangan & Verifikasi
                    </a>
                </div>
            </div>

            <!-- Pilar 5, 6, 7: Hilir (Pelanggan & Logistik) -->
            <div>
                <p class="px-3 text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Manajemen Hilir (CRM & Logistik)</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.logistik.beranda') }}" wire:navigate class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('admin/logistik*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                        <i class="fa-solid fa-truck-fast w-5 text-center"></i> Logistik Pengiriman
                    </a>
                    <a href="{{ route('admin.pelanggan.beranda') }}" wire:navigate class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('admin/pelanggan*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                        <i class="fa-solid fa-users w-5 text-center"></i> Data Pelanggan (CRM)
                    </a>
                    <a href="{{ route('admin.cs.beranda') }}" wire:navigate class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('admin/layanan*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                        <i class="fa-solid fa-headset w-5 text-center"></i> Layanan Pelanggan
                    </a>
                </div>
            </div>

            <!-- Pilar 8, 9, 10, 11: Pendukung -->
            <div>
                <p class="px-3 text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Sistem Enterprise</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.pengguna.beranda') }}" wire:navigate class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('admin/pegawai*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                        <i class="fa-solid fa-id-card-clip w-5 text-center"></i> SDM & Akses
                    </a>
                    <a href="{{ route('admin.laporan.pusat') }}" wire:navigate class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('admin/laporan*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                        <i class="fa-solid fa-chart-line w-5 text-center"></i> Analitik Bisnis
                    </a>
                    <a href="{{ route('admin.pengaturan.sistem') }}" wire:navigate class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('admin/sistem*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                        <i class="fa-solid fa-gears w-5 text-center"></i> Pengaturan Sistem
                    </a>
                    <a href="{{ route('admin.pengaturan.keamanan') }}" wire:navigate class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('admin/keamanan*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                        <i class="fa-solid fa-shield-halved w-5 text-center"></i> Keamanan & Audit
                    </a>
                </div>
            </div>

            <!-- Logout -->
            <div class="pt-8 pb-4">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-bold text-rose-400 hover:bg-rose-500/10 hover:text-rose-500 transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i> Keluar Sistem
                </a>
            </div>
        </nav>
        
        <!-- User Profile Mini -->
        <div class="p-4 bg-slate-950 border-t border-slate-800 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center font-bold text-white shadow-lg">
                {{ substr(auth()->user()->nama ?? 'A', 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-white truncate">{{ auth()->user()->nama ?? 'Administrator' }}</p>
                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->peran ?? 'Super Admin' }}</p>
            </div>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main 
        class="flex-1 h-full overflow-hidden flex flex-col transition-all duration-300 ease-in-out bg-slate-50"
        :class="sidebarOpen ? 'ml-72' : 'ml-0'"
    >
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 z-40 sticky top-0 shadow-sm">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                
                <!-- Breadcrumb Dinamis -->
                <nav class="hidden md:flex items-center text-sm font-medium text-slate-500">
                    <span>Admin</span>
                    <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-slate-300"></i>
                    <span class="text-slate-900">{{ $title ?? 'Dashboard' }}</span>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <!-- Global Spotlight Search -->
                <div class="relative hidden md:block w-96">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400"></i>
                    <input type="text" placeholder="Cari pesanan, produk, atau pelanggan..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <div class="absolute right-2 top-2 px-1.5 py-0.5 bg-slate-200 rounded text-[10px] font-bold text-slate-500">CTRL+K</div>
                </div>

                <!-- Notifikasi -->
                <button class="relative p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
                    <i class="fa-regular fa-bell text-lg"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
                </button>
            </div>
        </header>

        <!-- Area Konten Scrollable -->
        <div class="flex-1 overflow-auto p-6 lg:p-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Global Components -->
    <x-ui.notifikasi-toast />
    @livewireScripts
</body>
</html>