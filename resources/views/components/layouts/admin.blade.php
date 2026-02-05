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
        /* Custom Scrollbar */
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
                    <p class="text-[10px] font-bold text-cyan-600 uppercase tracking-widest">Enterprise</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Ikhtisar</p>
                
                <a href="/admin/dashboard" wire:navigate class="{{ request()->is('admin/dashboard') ? 'bg-cyan-50 text-cyan-700 shadow-sm ring-1 ring-cyan-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->is('admin/dashboard') ? 'text-cyan-600' : 'text-slate-400 group-hover:text-slate-500' }} mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard Utama
                </a>

                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mt-8 mb-2">Manajemen Toko</p>

                <a href="/admin/pesanan" wire:navigate class="{{ request()->is('admin/pesanan*') ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->is('admin/pesanan*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }} mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Pesanan Masuk
                    <span class="ml-auto bg-indigo-100 text-indigo-600 py-0.5 px-2 rounded-full text-xs font-bold">New</span>
                </a>

                <a href="/admin/produk" wire:navigate class="{{ request()->is('admin/produk*') ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->is('admin/produk*') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-slate-500' }} mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Katalog Produk
                </a>

                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium text-slate-600 rounded-xl hover:bg-slate-50 transition-all">
                        <div class="flex items-center">
                            <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Master Data
                        </div>
                        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-slate-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1">
                        <a href="/admin/kategori" class="block px-4 py-2 text-sm font-medium text-slate-500 hover:text-cyan-600 rounded-lg transition">Kategori</a>
                        <a href="/admin/merek" class="block px-4 py-2 text-sm font-medium text-slate-500 hover:text-cyan-600 rounded-lg transition">Merek</a>
                        <a href="/admin/voucher" class="block px-4 py-2 text-sm font-medium text-slate-500 hover:text-cyan-600 rounded-lg transition">Voucher Promo</a>
                    </div>
                </div>

                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mt-8 mb-2">Laporan & Pengguna</p>

                <a href="/admin/laporan" wire:navigate class="{{ request()->is('admin/laporan*') ? 'bg-orange-50 text-orange-700 shadow-sm ring-1 ring-orange-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->is('admin/laporan*') ? 'text-orange-600' : 'text-slate-400 group-hover:text-slate-500' }} mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan Keuangan
                </a>

                <a href="/admin/pengguna" wire:navigate class="{{ request()->is('admin/pengguna*') ? 'bg-pink-50 text-pink-700 shadow-sm ring-1 ring-pink-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->is('admin/pengguna*') ? 'text-pink-600' : 'text-slate-400 group-hover:text-slate-500' }} mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Pengguna
                </a>

                <a href="/admin/cms" wire:navigate class="{{ request()->is('admin/cms*') ? 'bg-purple-50 text-purple-700 shadow-sm ring-1 ring-purple-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->is('admin/cms*') ? 'text-purple-600' : 'text-slate-400 group-hover:text-slate-500' }} mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                    CMS / Tampilan
                </a>

                <a href="/admin/log" wire:navigate class="{{ request()->is('admin/log*') ? 'bg-slate-100 text-slate-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->is('admin/log*') ? 'text-slate-600' : 'text-slate-400 group-hover:text-slate-500' }} mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Audit Log
                </a>
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