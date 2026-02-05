<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard - Teqara' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body class="bg-slate-100 font-[Inter] antialiased text-slate-800">

    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-slate-900 text-white flex-shrink-0">
            <div class="h-16 flex items-center justify-center border-b border-slate-800">
                <span class="text-xl font-bold tracking-tight text-white">TEQARA <span class="text-cyan-400">ADMIN</span></span>
            </div>

            <nav class="mt-6 px-4 space-y-2">
                <a href="/admin/dashboard" wire:navigate class="{{ request()->is('admin/dashboard') ? 'bg-cyan-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md transition">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dasbor
                </a>

                <a href="/admin/pesanan" wire:navigate class="{{ request()->is('admin/pesanan*') ? 'bg-cyan-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md transition">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Pesanan
                </a>

                <a href="/admin/laporan" wire:navigate class="{{ request()->is('admin/laporan*') ? 'bg-cyan-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md transition">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Laporan Penjualan
                </a>

                <a href="/admin/produk" wire:navigate class="{{ request()->is('admin/produk*') ? 'bg-cyan-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md transition">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Produk
                </a>

                <div class="pt-4 pb-2">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-2">Master Data</p>
                </div>

                <a href="/admin/kategori" wire:navigate class="{{ request()->is('admin/kategori*') ? 'bg-cyan-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md transition">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Kategori
                </a>

                <a href="/admin/merek" wire:navigate class="{{ request()->is('admin/merek*') ? 'bg-cyan-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md transition">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Merek
                </a>

                <div class="pt-4 pb-2">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-2">Audit</p>
                </div>

                <a href="/admin/log" wire:navigate class="{{ request()->is('admin/log*') ? 'bg-cyan-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md transition">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Log Aktivitas
                </a>

                <a href="/logout" class="mt-8 text-red-400 hover:bg-slate-800 hover:text-red-300 group flex items-center px-2 py-2 text-sm font-medium rounded-md transition">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm border-b border-slate-200 py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-lg font-bold leading-6 text-slate-900">{{ $title ?? 'Admin Area' }}</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-500">Halo, <span class="font-bold text-slate-900">{{ auth()->user()->nama ?? 'Admin' }}</span></span>
                    <img class="h-8 w-8 rounded-full bg-slate-300" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama ?? 'Admin') }}&background=0891b2&color=fff" alt="">
                </div>
            </header>

            <div class="py-6">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    @livewire('komponen.notifikasi')
</body>
</html>
