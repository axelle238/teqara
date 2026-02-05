<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Teqara Enterprise Hub' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .vibrant-gradient { background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%); }
        .glass-card { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        /* Glow Effects */
        .glow-indigo { box-shadow: 0 10px 30px -5px rgba(79, 70, 229, 0.3); }
        .glow-emerald { box-shadow: 0 10px 30px -5px rgba(16, 185, 129, 0.3); }
        .glow-amber { box-shadow: 0 10px 30px -5px rgba(245, 158, 11, 0.3); }
    </style>
</head>
<body class="text-slate-700 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar: No Black, Only Vibrant Gradients -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-40 w-80 bg-white border-r border-indigo-100 transform transition-transform duration-500 lg:static lg:translate-x-0 flex flex-col h-full shadow-xl"
        >
            <!-- Brand Area -->
            <div class="h-28 flex items-center px-8 vibrant-gradient shadow-lg relative overflow-hidden">
                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white font-black text-2xl shadow-inner mr-4 group cursor-pointer border border-white/30">
                    <span class="drop-shadow-lg">T</span>
                </div>
                <div class="relative z-10">
                    <h1 class="font-black text-xl text-white tracking-tighter leading-none mb-1">TEQARA<span class="text-cyan-200">.</span></h1>
                    <p class="text-[9px] font-black text-indigo-100 uppercase tracking-[0.3em]">Vibrant Enterprise</p>
                </div>
                <!-- Abstract Circles -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full translate-x-16 -translate-y-16"></div>
            </div>

            <!-- Navigasi 11 Pilar dengan Ikon Berwarna -->
            <nav 
                class="flex-1 overflow-y-auto py-8 px-6 space-y-2 custom-scrollbar bg-white" 
                x-data="{ 
                    aktif: '{{ 
                        match(true) {
                            request()->is('admin/dashboard') => 'dashboard',
                            request()->is('admin/toko*') => 'toko',
                            request()->is('admin/produk*') || request()->is('admin/kategori*') || request()->is('admin/merek*') || request()->is('admin/stok*') => 'produk',
                            request()->is('admin/pesanan*') && !request()->is('admin/pesanan/verifikasi*') && !request()->is('admin/transaksi*') => 'pesanan',
                            request()->is('admin/transaksi*') || request()->is('admin/pesanan/verifikasi*') => 'transaksi',
                            request()->is('admin/cs*') => 'cs',
                            request()->is('admin/logistik*') => 'logistik',
                            request()->is('admin/pelanggan*') => 'pelanggan',
                            request()->is('admin/pengguna*') || request()->is('admin/hrd*') => 'pengguna',
                            request()->is('admin/laporan*') => 'laporan',
                            request()->is('admin/pengaturan/sistem*') || request()->is('admin/voucher*') => 'sistem',
                            request()->is('admin/pengaturan/keamanan*') || request()->is('admin/pengaturan/log*') => 'keamanan',
                            default => ''
                        }
                    }}',
                    pilih(menu) { this.aktif = (this.aktif === menu ? '' : menu) }
                }"
            >
                
                <!-- Dashboard Utama -->
                <a 
                    href="/admin/dashboard" 
                    wire:navigate 
                    @click="aktif = 'dashboard'"
                    :class="aktif === 'dashboard' ? 'bg-indigo-600 text-white shadow-lg glow-indigo' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600'"
                    class="group flex items-center px-5 py-4 text-xs font-black rounded-2xl transition-all duration-300 mb-10 uppercase tracking-[0.2em]"
                >
                    <div :class="aktif === 'dashboard' ? 'bg-white/20' : 'bg-indigo-100'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V1.512A9.025 9.001 0 0120.488 9z"></path></svg>
                    </div>
                    IKHTISAR REAL-TIME
                </a>

                <p class="px-5 text-[9px] font-black text-indigo-300 uppercase tracking-[0.4em] mb-4">Operations Control</p>

                <!-- 1. Halaman Toko -->
                <div class="space-y-1">
                    <button @click="pilih('toko')" :class="aktif === 'toko' ? 'bg-purple-100 text-purple-900 shadow-sm' : 'text-slate-500 hover:bg-purple-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'toko' ? 'bg-purple-600 text-white shadow-lg' : 'bg-purple-100 text-purple-600'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1-0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                            </div>
                            Halaman Toko
                        </div>
                        <svg :class="aktif === 'toko' ? 'rotate-180 text-purple-600' : 'text-slate-300'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'toko'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-purple-100 ml-9">
                        <a href="{{ route('admin.toko.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/toko/dashboard') ? 'text-purple-700 bg-purple-50' : 'text-slate-400 hover:text-purple-600' }} rounded-xl transition uppercase tracking-widest">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"></path></svg>
                            Visual Hub
                        </a>
                        <a href="{{ route('admin.toko.konten') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/toko/konten') ? 'text-purple-700 bg-purple-50' : 'text-slate-400 hover:text-purple-600' }} rounded-xl transition uppercase tracking-widest">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Editor CMS
                        </a>
                        <a href="{{ route('admin.toko.berita') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/toko/berita') ? 'text-purple-700 bg-purple-50' : 'text-slate-400 hover:text-purple-600' }} rounded-xl transition uppercase tracking-widest">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            Artikel Berita
                        </a>
                    </div>
                </div>

                <!-- 2. Manajemen Produk (Emerald Theme) -->
                <div class="space-y-1">
                    <button @click="pilih('produk')" :class="aktif === 'produk' ? 'bg-emerald-100 text-emerald-900' : 'text-slate-500 hover:bg-emerald-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'produk' ? 'bg-emerald-600 text-white' : 'bg-emerald-100 text-emerald-600'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            Produk & Gadget
                        </div>
                        <svg :class="aktif === 'produk' ? 'rotate-180 text-emerald-600' : 'text-slate-300'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'produk'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-emerald-100 ml-9">
                        <a href="{{ route('admin.produk.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/produk/dashboard') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-400 hover:text-emerald-600' }} rounded-xl transition uppercase tracking-widest">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Statistik Unit
                        </a>
                        <a href="{{ route('admin.produk.katalog') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/produk/katalog') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-400 hover:text-emerald-600' }} rounded-xl transition uppercase tracking-widest">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            Katalog Pusat
                        </a>
                        <a href="{{ route('admin.produk.stok') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/produk/stok') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-400 hover:text-emerald-600' }} rounded-xl transition uppercase tracking-widest">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Audit Inventaris
                        </a>
                    </div>
                </div>

                <!-- 3. Pilar Pesanan (Amber Theme) -->
                <div class="space-y-1">
                    <button @click="pilih('pesanan')" :class="aktif === 'pesanan' ? 'bg-amber-100 text-amber-900' : 'text-slate-500 hover:bg-amber-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'pesanan' ? 'bg-amber-500 text-white' : 'bg-amber-100 text-amber-600'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            Alur Pesanan
                        </div>
                        <svg :class="aktif === 'pesanan' ? 'rotate-180 text-amber-600' : 'text-slate-300'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'pesanan'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-amber-100 ml-9">
                        <a href="{{ route('admin.pesanan.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pesanan/dashboard') ? 'text-amber-700 bg-amber-50' : 'text-slate-400 hover:text-amber-600' }} rounded-xl transition uppercase tracking-widest">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1"></path></svg>
                            Pusat Order
                        </a>
                        <a href="{{ route('admin.pesanan.daftar') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pesanan/daftar') ? 'text-amber-700 bg-amber-50' : 'text-slate-400 hover:text-amber-600' }} rounded-xl transition uppercase tracking-widest">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Antrian Transaksi
                        </a>
                    </div>
                </div>

                <p class="px-5 text-[9px] font-black text-indigo-300 uppercase tracking-[0.4em] mt-8 mb-4">Financial & Clients</p>

                <!-- 4. Pilar Transaksi (Indigo Theme) -->
                <div class="space-y-1">
                    <button @click="pilih('transaksi')" :class="aktif === 'transaksi' ? 'bg-indigo-100 text-indigo-900 shadow-sm' : 'text-slate-500 hover:bg-indigo-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'transaksi' ? 'bg-indigo-600 text-white' : 'bg-indigo-100 text-indigo-600'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            Keuangan & Bayar
                        </div>
                        <svg :class="aktif === 'transaksi' ? 'rotate-180 text-indigo-600' : 'text-slate-300'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'transaksi'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-indigo-100 ml-9">
                        <a href="{{ route('admin.transaksi.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/transaksi/dashboard') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-400 hover:text-indigo-600' }} rounded-xl transition uppercase tracking-widest">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"></path></svg>
                            Arus Kas Digital
                        </a>
                        <a href="{{ route('admin.pesanan.verifikasi') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pesanan/verifikasi') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-400 hover:text-indigo-600' }} rounded-xl transition uppercase tracking-widest">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Verifikasi Bayar
                        </a>
                    </div>
                </div>

                <!-- ... (Navigasi lainnya diperbarui dengan palet warna yang sama: Pink untuk CS, Cyan untuk Logistik, Rose untuk Pelanggan, Slate untuk Pengaturan) ... -->

            </nav>

            <!-- User Footer (Modern Vibrant Look) -->
            <div class="p-8 vibrant-gradient border-t border-white/10 text-white">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img class="h-12 w-12 rounded-[18px] object-cover border-4 border-white/20 shadow-xl" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama) }}&background=ffffff&color=4f46e5" alt="">
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-400 border-4 border-white rounded-full shadow-lg"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-black text-white truncate uppercase tracking-widest">{{ auth()->user()->nama }}</p>
                        <p class="text-[9px] font-bold text-indigo-100 uppercase truncate">{{ auth()->user()->peran }} Hub</p>
                    </div>
                    <a href="/logout" class="p-2 text-white/60 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto relative">
            <!-- Glass Top Bar -->
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-indigo-50 h-20 flex items-center px-10 justify-between">
                <div class="flex items-center gap-4 text-xs font-black text-slate-400 uppercase tracking-[0.2em]">
                    <span class="text-indigo-600">Admin</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-slate-900">{{ $title ?? 'Dashboard' }}</span>
                </div>
                <div class="flex items-center gap-6">
                    <div class="hidden md:flex flex-col text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ now()->translatedFormat('l, d F Y') }}</p>
                        <p class="text-xs font-black text-indigo-600 uppercase" id="live-clock">{{ now()->format('H:i:s') }} WIB</p>
                    </div>
                    <div class="h-10 w-px bg-indigo-50"></div>
                    <button class="relative p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white shadow-sm animate-bounce"></span>
                    </button>
                </div>
            </header>

            <div class="p-10 max-w-[1600px] mx-auto animate-in fade-in duration-700">
                {{ $slot }}
            </div>
        </main>
    </div>

    <x-ui.notifikasi-toast />
    @livewireScripts

    <script>
        setInterval(() => {
            document.getElementById('live-clock').textContent = new Date().toLocaleTimeString('id-ID', { hour12: false }) + ' WIB';
        }, 1000);
    </script>
</body>
</html>