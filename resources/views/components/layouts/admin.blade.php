<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Teqara Enterprise' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50/50 text-slate-800 antialiased selection:bg-cyan-500 selection:text-white" x-data="{ sidebarOpen: false }">

    <!-- Mobile Header -->
    <div class="lg:hidden flex items-center justify-between bg-white border-b border-slate-200 px-4 py-3 sticky top-0 z-30">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white font-bold">T</div>
            <span class="font-bold text-slate-900">TEQARA</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar (Desktop & Mobile) -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-40 w-72 bg-white border-r border-slate-200 transform transition-transform duration-300 lg:static lg:translate-x-0 flex flex-col h-full shadow-2xl lg:shadow-none"
        >
            <!-- Logo Area -->
            <div class="h-20 flex items-center px-8 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white font-extrabold text-xl shadow-lg shadow-cyan-500/30 mr-3">T</div>
                <div>
                    <h1 class="font-extrabold text-lg text-slate-900 tracking-tight">TEQARA</h1>
                    <p class="text-[10px] font-bold text-cyan-600 uppercase tracking-widest">Enterprise v5.0</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1" x-data="{ activeMenu: '{{ request()->segment(2) }}' }">
                
                <!-- Dashboard Utama -->
                <a href="/admin/dashboard" wire:navigate class="{{ request()->is('admin/dashboard') ? 'bg-cyan-50 text-cyan-700 shadow-sm ring-1 ring-cyan-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 mb-6">
                    <svg class="{{ request()->is('admin/dashboard') ? 'text-cyan-600' : 'text-slate-400 group-hover:text-slate-500' }} mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard Utama
                </a>

                <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Modul Operasional</p>

                <!-- Manajemen Produk -->
                <div x-data="{ open: activeMenu === 'produk' || activeMenu === 'stok' || activeMenu === 'kategori' || activeMenu === 'merek' }" class="space-y-1">
                    <button @click="open = !open" :class="open ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all">
                        <div class="flex items-center">
                            <svg :class="open ? 'text-emerald-600' : 'text-slate-400'" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Manajemen Produk
                        </div>
                        <svg :class="open ? 'rotate-180 text-emerald-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1 relative">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-emerald-100"></div>
                        <a href="/admin/produk/dashboard" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/produk/dashboard') ? 'text-emerald-700 font-bold' : 'text-slate-500 hover:text-emerald-600' }} rounded-lg transition">Dashboard Produk</a>
                        <a href="/admin/produk/katalog" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/produk/katalog') ? 'text-emerald-700 font-bold' : 'text-slate-500 hover:text-emerald-600' }} rounded-lg transition">Katalog & Unit</a>
                        <a href="/admin/produk/stok" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/produk/stok') ? 'text-emerald-700 font-bold' : 'text-slate-500 hover:text-emerald-600' }} rounded-lg transition">Audit Stok</a>
                        <a href="/admin/kategori" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/kategori') ? 'text-emerald-700 font-bold' : 'text-slate-500 hover:text-emerald-600' }} rounded-lg transition">Kategori</a>
                        <a href="/admin/merek" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/merek') ? 'text-emerald-700 font-bold' : 'text-slate-500 hover:text-emerald-600' }} rounded-lg transition">Merek</a>
                    </div>
                </div>

                <!-- Manajemen Pesanan -->
                <div x-data="{ open: activeMenu === 'pesanan' || activeMenu === 'logistik' }" class="space-y-1">
                    <button @click="open = !open" :class="open ? 'bg-indigo-50 text-indigo-800' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all">
                        <div class="flex items-center">
                            <svg :class="open ? 'text-indigo-600' : 'text-slate-400'" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Manajemen Pesanan
                        </div>
                        <svg :class="open ? 'rotate-180 text-indigo-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1 relative">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-indigo-100"></div>
                        <a href="/admin/pesanan/dashboard" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/pesanan/dashboard') ? 'text-indigo-700 font-bold' : 'text-slate-500 hover:text-indigo-600' }} rounded-lg transition">Dashboard Pesanan</a>
                        <a href="/admin/pesanan/daftar" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/pesanan/daftar') || request()->is('admin/pesanan/detail*') ? 'text-indigo-700 font-bold' : 'text-slate-500 hover:text-indigo-600' }} rounded-lg transition">Daftar Transaksi</a>
                        <a href="/admin/logistik/pemasok" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/logistik*') ? 'text-indigo-700 font-bold' : 'text-slate-500 hover:text-indigo-600' }} rounded-lg transition">Logistik & Pemasok</a>
                    </div>
                </div>

                <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mt-8 mb-2">Relasi & Organisasi</p>

                <!-- CRM Pelanggan -->
                <div x-data="{ open: activeMenu === 'pelanggan' || activeMenu === 'voucher' }" class="space-y-1">
                    <button @click="open = !open" :class="open ? 'bg-pink-50 text-pink-800' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all">
                        <div class="flex items-center">
                            <svg :class="open ? 'text-pink-600' : 'text-slate-400'" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            CRM Pelanggan
                        </div>
                        <svg :class="open ? 'rotate-180 text-pink-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1 relative">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-pink-100"></div>
                        <a href="/admin/pelanggan/dashboard" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/pelanggan/dashboard') ? 'text-pink-700 font-bold' : 'text-slate-500 hover:text-pink-600' }} rounded-lg transition">Dashboard Pelanggan</a>
                        <a href="/admin/pelanggan/daftar" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/pelanggan/daftar') ? 'text-pink-700 font-bold' : 'text-slate-500 hover:text-pink-600' }} rounded-lg transition">Basis Data Member</a>
                        <a href="/admin/voucher" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/voucher') ? 'text-pink-700 font-bold' : 'text-slate-500 hover:text-pink-600' }} rounded-lg transition">Voucher & Promo</a>
                    </div>
                </div>

                <!-- HRD & Pengguna -->
                <div x-data="{ open: activeMenu === 'pengguna' || activeMenu === 'hrd' }" class="space-y-1">
                    <button @click="open = !open" :class="open ? 'bg-rose-50 text-rose-800' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all">
                        <div class="flex items-center">
                            <svg :class="open ? 'text-rose-600' : 'text-slate-400'" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            HRD & Pengguna
                        </div>
                        <svg :class="open ? 'rotate-180 text-rose-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1 relative">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-rose-100"></div>
                        <a href="/admin/pengguna/dashboard" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/pengguna/dashboard') ? 'text-rose-700 font-bold' : 'text-slate-500 hover:text-rose-600' }} rounded-lg transition">Dashboard Internal</a>
                        <a href="/admin/pengguna/daftar" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/pengguna/daftar') ? 'text-rose-700 font-bold' : 'text-slate-500 hover:text-rose-600' }} rounded-lg transition">Tim Administrator</a>
                        <a href="/admin/hrd/karyawan" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/hrd*') ? 'text-rose-700 font-bold' : 'text-slate-500 hover:text-rose-600' }} rounded-lg transition">Data Karyawan</a>
                    </div>
                </div>

                <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mt-8 mb-2">Pusat Kendali</p>

                <!-- Laporan -->
                <div x-data="{ open: activeMenu === 'laporan' }" class="space-y-1">
                    <button @click="open = !open" :class="open ? 'bg-orange-50 text-orange-800' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all">
                        <div class="flex items-center">
                            <svg :class="open ? 'text-orange-600' : 'text-slate-400'" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Pusat Laporan
                        </div>
                        <svg :class="open ? 'rotate-180 text-orange-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1 relative">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-orange-100"></div>
                        <a href="/admin/laporan/pusat" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/laporan*') ? 'text-orange-700 font-bold' : 'text-slate-500 hover:text-orange-600' }} rounded-lg transition">Laporan Penjualan</a>
                    </div>
                </div>

                <!-- Pengaturan Pusat -->
                <div x-data="{ open: activeMenu === 'pengaturan' }" class="space-y-1">
                    <button @click="open = !open" :class="open ? 'bg-slate-100 text-slate-800' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all">
                        <div class="flex items-center">
                            <svg :class="open ? 'text-slate-800' : 'text-slate-400'" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Pengaturan Pusat
                        </div>
                        <svg :class="open ? 'rotate-180 text-slate-800' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1 relative">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-slate-200"></div>
                        <a href="/admin/pengaturan/sistem" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/pengaturan/sistem') ? 'text-slate-900 font-bold' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition">Sistem & Identitas</a>
                        <a href="/admin/pengaturan/keamanan" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/pengaturan/keamanan') ? 'text-slate-900 font-bold' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition">Keamanan & Audit</a>
                        <a href="/admin/pengaturan/cms" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/pengaturan/cms') ? 'text-slate-900 font-bold' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition">CMS / Tampilan</a>
                        <a href="/admin/pengaturan/log" wire:navigate class="block px-4 py-2 text-sm font-medium {{ request()->is('admin/pengaturan/log') ? 'text-slate-900 font-bold' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition">Log Aktivitas</a>
                    </div>
                </div>

            </nav>

            <!-- User Profile -->
            <div class="border-t border-slate-100 p-4">
                <div class="flex items-center gap-3">
                    <img class="h-10 w-10 rounded-full border-2 border-white shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama ?? 'Admin') }}&background=0f172a&color=fff" alt="">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->nama ?? 'Administrator' }}</p>
                        <a href="/logout" class="text-xs text-red-500 hover:text-red-700 font-medium">Keluar Sesi</a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Overlay for Mobile Sidebar -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-slate-900/50 backdrop-blur-sm lg:hidden transition-opacity"></div>

    <x-ui.notifikasi-toast />
    @livewireScripts
</body>
</html>