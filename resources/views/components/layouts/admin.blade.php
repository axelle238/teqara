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
                
                <!-- 1. Dashboard Utama -->
                <a href="/admin/dashboard" wire:navigate class="{{ request()->is('admin/dashboard') ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-4 py-3 text-sm font-black rounded-xl transition-all duration-200 mb-6 uppercase tracking-widest">
                    <svg class="{{ request()->is('admin/dashboard') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }} mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    KONTROL UTAMA
                </a>

                <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 opacity-50">Manajemen Inti</p>

                <!-- 2. Manajemen Produk & Gadget -->
                <div x-data="{ open: activeMenu === 'produk' || activeMenu === 'stok' || activeMenu === 'kategori' || activeMenu === 'merek' }" class="space-y-1">
                    <button @click="open = !open" :class="open ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold rounded-xl transition-all">
                        <div class="flex items-center">
                            <svg :class="open ? 'text-emerald-600' : 'text-slate-400'" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Produk & Gadget
                        </div>
                        <svg :class="open ? 'rotate-180 text-emerald-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1 relative py-2">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-emerald-100"></div>
                        <a href="/admin/produk/dashboard" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/produk/dashboard') ? 'text-emerald-700' : 'text-slate-500 hover:text-emerald-600' }} rounded-lg transition">DASHBOARD UNIT</a>
                        <a href="/admin/produk/katalog" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/produk/katalog') ? 'text-emerald-700' : 'text-slate-500 hover:text-emerald-600' }} rounded-lg transition">KATALOG & VARIAN</a>
                        <a href="/admin/produk/stok" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/produk/stok') ? 'text-emerald-700' : 'text-slate-500 hover:text-emerald-600' }} rounded-lg transition">AUDIT INVENTARIS</a>
                        <a href="/admin/kategori" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/kategori') ? 'text-emerald-700' : 'text-slate-500 hover:text-emerald-600' }} rounded-lg transition">KATEGORI</a>
                        <a href="/admin/merek" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/merek') ? 'text-emerald-700' : 'text-slate-500 hover:text-emerald-600' }} rounded-lg transition">MEREK</a>
                    </div>
                </div>

                <!-- 3. Manajemen Pesanan & Pembayaran -->
                <div x-data="{ open: activeMenu === 'pesanan' }" class="space-y-1">
                    <button @click="open = !open" :class="open ? 'bg-amber-50 text-amber-800' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold rounded-xl transition-all">
                        <div class="flex items-center">
                            <svg :class="open ? 'text-amber-600' : 'text-slate-400'" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Pesanan & Bayar
                        </div>
                        <svg :class="open ? 'rotate-180 text-amber-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1 relative py-2">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-amber-100"></div>
                        <a href="/admin/pesanan/dashboard" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/pesanan/dashboard') ? 'text-amber-700' : 'text-slate-500 hover:text-amber-600' }} rounded-lg transition">DASHBOARD ARUS KAS</a>
                        <a href="/admin/pesanan/daftar" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/pesanan/daftar') ? 'text-amber-700' : 'text-slate-500 hover:text-amber-600' }} rounded-lg transition">ANTRIAN TRANSAKSI</a>
                        <a href="/admin/pesanan/verifikasi" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/pesanan/verifikasi') ? 'text-amber-700' : 'text-slate-500 hover:text-amber-600' }} rounded-lg transition">VERIFIKASI BAYAR</a>
                    </div>
                </div>

                <!-- 4. Manajemen Pelanggan (CRM) -->
                <div x-data="{ open: activeMenu === 'pelanggan' }" class="space-y-1">
                    <button @click="open = !open" :class="open ? 'bg-pink-50 text-pink-800' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold rounded-xl transition-all">
                        <div class="flex items-center">
                            <svg :class="open ? 'text-pink-600' : 'text-slate-400'" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Relasi Pelanggan
                        </div>
                        <svg :class="open ? 'rotate-180 text-pink-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1 relative py-2">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-pink-100"></div>
                        <a href="/admin/pelanggan/dashboard" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/pelanggan/dashboard') ? 'text-pink-700' : 'text-slate-500 hover:text-pink-600' }} rounded-lg transition">DASHBOARD CRM</a>
                        <a href="/admin/pelanggan/daftar" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/pelanggan/daftar') ? 'text-pink-700' : 'text-slate-500 hover:text-pink-600' }} rounded-lg transition">BASIS DATA MEMBER</a>
                        <a href="/admin/pelanggan/ulasan" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/pelanggan/ulasan') ? 'text-pink-700' : 'text-slate-500 hover:text-pink-600' }} rounded-lg transition">ULASAN & FEEDBACK</a>
                    </div>
                </div>

                <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mt-8 mb-2 opacity-50">Otoritas & Data</p>

                <!-- 5. Manajemen Pengguna & HRD -->
                <div x-data="{ open: activeMenu === 'pengguna' || activeMenu === 'hrd' }" class="space-y-1">
                    <button @click="open = !open" :class="open ? 'bg-rose-50 text-rose-800' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold rounded-xl transition-all">
                        <div class="flex items-center">
                            <svg :class="open ? 'text-rose-600' : 'text-slate-400'" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Pengguna & HRD
                        </div>
                        <svg :class="open ? 'rotate-180 text-rose-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1 relative py-2">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-rose-100"></div>
                        <a href="/admin/pengguna/dashboard" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/pengguna/dashboard') ? 'text-rose-700' : 'text-slate-500 hover:text-rose-600' }} rounded-lg transition">DASHBOARD INTERNAL</a>
                        <a href="/admin/pengguna/daftar" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/pengguna/daftar') ? 'text-rose-700' : 'text-slate-500 hover:text-rose-600' }} rounded-lg transition">TIM ADMINISTRATOR</a>
                        <a href="/admin/hrd/karyawan" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/hrd*') ? 'text-rose-700' : 'text-slate-500 hover:text-rose-600' }} rounded-lg transition">STRUKTUR ORGANISASI</a>
                    </div>
                </div>

                <!-- 6. Laporan & Analitik -->
                <div x-data="{ open: activeMenu === 'laporan' }" class="space-y-1">
                    <button @click="open = !open" :class="open ? 'bg-orange-50 text-orange-800' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold rounded-xl transition-all">
                        <div class="flex items-center">
                            <svg :class="open ? 'text-orange-600' : 'text-slate-400'" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Laporan & Analitik
                        </div>
                        <svg :class="open ? 'rotate-180 text-orange-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1 relative py-2">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-orange-100"></div>
                        <a href="/admin/laporan/pusat" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/laporan*') ? 'text-orange-700' : 'text-slate-500 hover:text-orange-600' }} rounded-lg transition">JURNAL PENJUALAN</a>
                    </div>
                </div>

                <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mt-8 mb-2 opacity-50">Konfigurasi Pusat</p>

                <!-- 7. Pengaturan Sistem Terpusat -->
                <div x-data="{ open: activeMenu === 'pengaturan' && !request()->is('admin/pengaturan/keamanan*') && !request()->is('admin/pengaturan/log*') }" class="space-y-1">
                    <button @click="open = !open" :class="open ? 'bg-cyan-50 text-cyan-800' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold rounded-xl transition-all">
                        <div class="flex items-center">
                            <svg :class="open ? 'text-cyan-600' : 'text-slate-400'" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Pengaturan Sistem
                        </div>
                        <svg :class="open ? 'rotate-180 text-cyan-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1 relative py-2">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-cyan-100"></div>
                        <a href="/admin/pengaturan/sistem" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/pengaturan/sistem') ? 'text-cyan-700' : 'text-slate-500 hover:text-cyan-600' }} rounded-lg transition">IDENTITAS TOKO</a>
                        <a href="/admin/pengaturan/cms" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/pengaturan/cms') ? 'text-cyan-700' : 'text-slate-500 hover:text-cyan-600' }} rounded-lg transition">CMS HALAMAN DEPAN</a>
                    </div>
                </div>

                <!-- 8. Pengaturan Keamanan Terpusat -->
                <div x-data="{ open: request()->is('admin/pengaturan/keamanan*') || request()->is('admin/pengaturan/log*') }" class="space-y-1">
                    <button @click="open = !open" :class="open ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold rounded-xl transition-all">
                        <div class="flex items-center">
                            <svg :class="open ? 'text-emerald-400' : 'text-slate-400'" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Keamanan Pusat
                        </div>
                        <svg :class="open ? 'rotate-180 text-emerald-400' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-12 space-y-1 relative py-2">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-slate-700"></div>
                        <a href="/admin/pengaturan/keamanan" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/pengaturan/keamanan') ? 'text-emerald-400' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition">KEBIJAKAN AKSES</a>
                        <a href="/admin/pengaturan/log" wire:navigate class="block px-4 py-2 text-xs font-bold {{ request()->is('admin/pengaturan/log') ? 'text-emerald-400' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition">JEJAK AUDIT (LOG)</a>
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