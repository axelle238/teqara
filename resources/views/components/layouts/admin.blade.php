<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Teqara Enterprise Hub' }}</title>
    
    <!-- Fonts: Plus Jakarta Sans (Enterprise Standard) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        .glass-sidebar { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
        .active-glow-indigo { box-shadow: 0 0 20px rgba(79, 70, 229, 0.15); }
        .active-glow-emerald { box-shadow: 0 0 20px rgba(16, 185, 129, 0.15); }
        .active-glow-purple { box-shadow: 0 0 20px rgba(147, 51, 234, 0.15); }
        .active-glow-amber { box-shadow: 0 0 20px rgba(245, 158, 11, 0.15); }
        .active-glow-pink { box-shadow: 0 0 20px rgba(219, 39, 119, 0.15); }
        .active-glow-cyan { box-shadow: 0 0 20px rgba(6, 182, 212, 0.15); }
        .active-glow-red { box-shadow: 0 0 20px rgba(220, 38, 38, 0.15); }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-indigo-500 selection:text-white" x-data="{ sidebarOpen: false }">

    <!-- Ornamen Latar Belakang High-Tech -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-500/5 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] bg-cyan-500/5 blur-[120px] rounded-full"></div>
    </div>

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-40 w-80 glass-sidebar border-r border-slate-200/60 transform transition-transform duration-500 lg:static lg:translate-x-0 flex flex-col h-full shadow-2xl lg:shadow-none"
        >
            <!-- Header Brand -->
            <div class="h-28 flex items-center px-8 border-b border-slate-100 bg-white/50">
                <div class="w-14 h-14 rounded-[22px] bg-slate-900 flex items-center justify-center text-white font-black text-2xl shadow-2xl shadow-slate-900/20 mr-4 group cursor-pointer overflow-hidden relative">
                    <span class="relative z-10">T</span>
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-cyan-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <div>
                    <h1 class="font-black text-xl text-slate-900 tracking-tighter leading-none mb-1">TEQARA<span class="text-indigo-600">.</span></h1>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Command Hub 13.0</p>
                    </div>
                </div>
            </div>

            <!-- Navigasi 11 Pilar dengan Ikon Lengkap -->
            <nav 
                class="flex-1 overflow-y-auto py-8 px-6 space-y-2 custom-scrollbar" 
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
                
                <!-- 0. Dashboard Utama -->
                <a 
                    href="/admin/dashboard" 
                    wire:navigate 
                    @click="aktif = 'dashboard'"
                    :class="aktif === 'dashboard' ? 'bg-slate-900 text-white shadow-2xl shadow-slate-900/30 active-glow-indigo' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900'"
                    class="group flex items-center px-5 py-4 text-xs font-black rounded-2xl transition-all duration-300 mb-10 uppercase tracking-[0.2em]"
                >
                    <div :class="aktif === 'dashboard' ? 'bg-indigo-500 shadow-lg shadow-indigo-500/50' : 'bg-slate-100 group-hover:bg-white'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V1.512A9.025 9.001 0 0120.488 9z"></path></svg>
                    </div>
                    IKHTISAR GLOBAL
                </a>

                <p class="px-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.4em] mb-4 opacity-50">Manajemen Bisnis</p>

                <!-- 1. Pilar Halaman Toko -->
                <div class="space-y-1">
                    <button @click="pilih('toko')" :class="aktif === 'toko' ? 'bg-purple-50 text-purple-900 active-glow-purple' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900'" class="w-full group flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'toko' ? 'bg-purple-600 text-white shadow-lg shadow-purple-600/30' : 'bg-slate-100 group-hover:bg-white'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1-0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                            </div>
                            Tampilan Toko
                        </div>
                        <svg :class="aktif === 'toko' ? 'rotate-180 opacity-100' : 'opacity-40'" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'toko'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-purple-100 ml-9">
                        <a href="{{ route('admin.toko.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/toko/dashboard') ? 'text-purple-700' : 'text-slate-400 hover:text-purple-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"></path></svg>
                            Dashboard Toko
                        </a>
                        <a href="{{ route('admin.toko.konten') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/toko/konten') ? 'text-purple-700' : 'text-slate-400 hover:text-purple-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Editor Konten
                        </a>
                        <a href="{{ route('admin.toko.berita') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/toko/berita') ? 'text-purple-700' : 'text-slate-400 hover:text-purple-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            Berita & Info
                        </a>
                    </div>
                </div>

                <!-- 2. Pilar Produk & Gadget -->
                <div class="space-y-1">
                    <button @click="pilih('produk')" :class="aktif === 'produk' ? 'bg-emerald-50 text-emerald-900 active-glow-emerald' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900'" class="w-full group flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'produk' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-slate-100 group-hover:bg-white'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            Katalog Unit
                        </div>
                        <svg :class="aktif === 'produk' ? 'rotate-180 opacity-100' : 'opacity-40'" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'produk'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-emerald-100 ml-9">
                        <a href="{{ route('admin.produk.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/produk/dashboard') ? 'text-emerald-700' : 'text-slate-400 hover:text-emerald-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Dashboard Produk
                        </a>
                        <a href="{{ route('admin.produk.katalog') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/produk/katalog') ? 'text-emerald-700' : 'text-slate-400 hover:text-emerald-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            Basis Data Unit
                        </a>
                        <a href="{{ route('admin.produk.stok') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/produk/stok') ? 'text-emerald-700' : 'text-slate-400 hover:text-emerald-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Audit Inventaris
                        </a>
                    </div>
                </div>

                <!-- 3. Pilar Pesanan -->
                <div class="space-y-1">
                    <button @click="pilih('pesanan')" :class="aktif === 'pesanan' ? 'bg-amber-50 text-amber-900 active-glow-amber' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900'" class="w-full group flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'pesanan' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/30' : 'bg-slate-100 group-hover:bg-white'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            Pesanan Unit
                        </div>
                        <svg :class="aktif === 'pesanan' ? 'rotate-180 opacity-100' : 'opacity-40'" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'pesanan'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-amber-100 ml-9">
                        <a href="{{ route('admin.pesanan.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pesanan/dashboard') ? 'text-amber-700' : 'text-slate-400 hover:text-amber-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1"></path></svg>
                            Dashboard Order
                        </a>
                        <a href="{{ route('admin.pesanan.daftar') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pesanan/daftar') ? 'text-amber-700' : 'text-slate-400 hover:text-amber-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Daftar Transaksi
                        </a>
                    </div>
                </div>

                <!-- 4. Pilar Transaksi -->
                <div class="space-y-1">
                    <button @click="pilih('transaksi')" :class="aktif === 'transaksi' ? 'bg-indigo-50 text-indigo-900 active-glow-indigo' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900'" class="w-full group flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'transaksi' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'bg-slate-100 group-hover:bg-white'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            Transaksi Finansial
                        </div>
                        <svg :class="aktif === 'transaksi' ? 'rotate-180 opacity-100' : 'opacity-40'" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'transaksi'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-indigo-100 ml-9">
                        <a href="{{ route('admin.transaksi.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/transaksi/dashboard') ? 'text-indigo-700' : 'text-slate-400 hover:text-indigo-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"></path></svg>
                            Dashboard Arus Kas
                        </a>
                        <a href="{{ route('admin.pesanan.verifikasi') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pesanan/verifikasi') ? 'text-indigo-700' : 'text-slate-400 hover:text-indigo-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Validasi Pembayaran
                        </a>
                    </div>
                </div>

                <p class="px-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.4em] mt-8 mb-4 opacity-50">Identity & Goverment</p>

                <!-- 5. Pilar CS -->
                <div class="space-y-1">
                    <button @click="pilih('cs')" :class="aktif === 'cs' ? 'bg-pink-50 text-pink-900 active-glow-pink' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900'" class="w-full group flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'cs' ? 'bg-pink-600 text-white shadow-lg shadow-pink-600/30' : 'bg-slate-100 group-hover:bg-white'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            Customer Service
                        </div>
                        <svg :class="aktif === 'cs' ? 'rotate-180 opacity-100' : 'opacity-40'" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'cs'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-pink-100 ml-9">
                        <a href="{{ route('admin.cs.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/cs/dashboard') ? 'text-pink-700' : 'text-slate-400 hover:text-pink-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            Dashboard Bantuan
                        </a>
                        <a href="{{ route('admin.pelanggan.ulasan') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pelanggan/ulasan') ? 'text-pink-700' : 'text-slate-400 hover:text-pink-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.783.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                            Ulasan & Feedback
                        </a>
                    </div>
                </div>

                <!-- 6. Pilar Logistik -->
                <div class="space-y-1">
                    <button @click="pilih('logistik')" :class="aktif === 'logistik' ? 'bg-cyan-50 text-cyan-900 active-glow-cyan' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900'" class="w-full group flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'logistik' ? 'bg-cyan-600 text-white shadow-lg shadow-cyan-600/30' : 'bg-slate-100 group-hover:bg-white'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                            </div>
                            Logistik & Armada
                        </div>
                        <svg :class="aktif === 'logistik' ? 'rotate-180 opacity-100' : 'opacity-40'" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'logistik'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-cyan-100 ml-9">
                        <a href="{{ route('admin.logistik.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/logistik/dashboard') ? 'text-cyan-700' : 'text-slate-400 hover:text-cyan-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Dashboard Armada
                        </a>
                        <a href="{{ route('admin.logistik.pemasok') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/logistik/pemasok') ? 'text-cyan-700' : 'text-slate-400 hover:text-cyan-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Manajemen Pemasok
                        </a>
                    </div>
                </div>

                <!-- 7. Pilar Pelanggan -->
                <div class="space-y-1">
                    <button @click="pilih('pelanggan')" :class="aktif === 'pelanggan' ? 'bg-rose-50 text-rose-900 active-glow-pink' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900'" class="w-full group flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'pelanggan' ? 'bg-rose-600 text-white shadow-lg shadow-rose-600/30' : 'bg-slate-100 group-hover:bg-white'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            Basis Pelanggan
                        </div>
                        <svg :class="aktif === 'pelanggan' ? 'rotate-180 opacity-100' : 'opacity-40'" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'pelanggan'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-rose-100 ml-9">
                        <a href="{{ route('admin.pelanggan.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pelanggan/dashboard') ? 'text-rose-700' : 'text-slate-400 hover:text-rose-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"></path></svg>
                            Dashboard CRM
                        </a>
                        <a href="{{ route('admin.pelanggan.daftar') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pelanggan/daftar') ? 'text-rose-700' : 'text-slate-400 hover:text-rose-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Database Member
                        </a>
                    </div>
                </div>

                <p class="px-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.4em] mt-8 mb-4 opacity-50">Identity & Governance</p>

                <!-- 8. Pilar Pegawai -->
                <div class="space-y-1">
                    <button @click="pilih('pengguna')" :class="aktif === 'pengguna' ? 'bg-slate-100 text-slate-900 active-glow-red' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900'" class="w-full group flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'pengguna' ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/30' : 'bg-slate-100 group-hover:bg-white'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            Pegawai & Peran
                        </div>
                        <svg :class="aktif === 'pengguna' ? 'rotate-180 opacity-100' : 'opacity-40'" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'pengguna'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-slate-200 ml-9">
                        <a href="{{ route('admin.pengguna.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pengguna/dashboard') ? 'text-slate-900' : 'text-slate-400 hover:text-slate-900' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Dashboard SDM
                        </a>
                        <a href="{{ route('admin.pengguna.daftar') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pengguna/daftar') ? 'text-slate-900' : 'text-slate-400 hover:text-slate-900' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Administrator
                        </a>
                        <a href="{{ route('admin.hrd.karyawan') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/hrd*') ? 'text-slate-900' : 'text-slate-400 hover:text-slate-900' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Struktur Kerja
                        </a>
                    </div>
                </div>

                <!-- 9. Laporan & Analitik -->
                <div class="space-y-1">
                    <button @click="pilih('laporan')" :class="aktif === 'laporan' ? 'bg-orange-50 text-orange-900 active-glow-amber' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900'" class="w-full group flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'laporan' ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/30' : 'bg-slate-100 group-hover:bg-white'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            Laporan & Profit
                        </div>
                        <svg :class="aktif === 'laporan' ? 'rotate-180 opacity-100' : 'opacity-40'" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'laporan'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-orange-100 ml-9">
                        <a href="{{ route('admin.laporan.pusat') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/laporan*') ? 'text-orange-700' : 'text-slate-400 hover:text-orange-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Jurnal Penjualan
                        </a>
                    </div>
                </div>

                <!-- 10. Pengaturan Sistem -->
                <div class="space-y-1">
                    <button @click="pilih('sistem')" :class="aktif === 'sistem' ? 'bg-cyan-50 text-cyan-900 active-glow-cyan' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900'" class="w-full group flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'sistem' ? 'bg-cyan-600 text-white shadow-lg shadow-cyan-600/30' : 'bg-slate-100 group-hover:bg-white'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            Sistem Terpusat
                        </div>
                        <svg :class="aktif === 'sistem' ? 'rotate-180 opacity-100' : 'opacity-40'" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'sistem'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-cyan-100 ml-9">
                        <a href="{{ route('admin.pengaturan.sistem') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pengaturan/sistem') ? 'text-cyan-700' : 'text-slate-400 hover:text-cyan-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Identitas & API
                        </a>
                        <a href="{{ route('admin.voucher') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/voucher') ? 'text-cyan-700' : 'text-slate-400 hover:text-cyan-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            Voucher Promo
                        </a>
                    </div>
                </div>

                <!-- 11. Pengaturan Keamanan -->
                <div class="space-y-1">
                    <button @click="pilih('keamanan')" :class="aktif === 'keamanan' ? 'bg-red-900 text-white active-glow-red' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900'" class="w-full group flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <div :class="aktif === 'keamanan' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-slate-100 group-hover:bg-white'" class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            Keamanan Pusat
                        </div>
                        <svg :class="aktif === 'keamanan' ? 'rotate-180 opacity-100' : 'opacity-40'" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'keamanan'" x-cloak x-collapse class="pl-12 space-y-1 py-2 border-l-2 border-red-900 ml-9">
                        <a href="{{ route('admin.pengaturan.keamanan') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pengaturan/keamanan') ? 'text-red-600' : 'text-slate-400 hover:text-red-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Kebijakan Akses
                        </a>
                        <a href="{{ route('admin.pengaturan.log') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-bold {{ request()->is('admin/pengaturan/log') ? 'text-red-600' : 'text-slate-400 hover:text-red-600' }} transition uppercase tracking-widest">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Audit Forensik
                        </a>
                    </div>
                </div>

            </nav>

            <!-- Footer User Section -->
            <div class="p-8 bg-white border-t border-slate-100">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img class="h-12 w-12 rounded-[18px] object-cover border-4 border-slate-50 shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama) }}&background=0f172a&color=fff" alt="">
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-4 border-white rounded-full"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-black text-slate-900 truncate uppercase tracking-widest">{{ auth()->user()->nama }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase truncate">{{ auth()->user()->peran }} ADMINISTRATOR</p>
                    </div>
                    <a href="/logout" class="p-2 text-slate-300 hover:text-red-500 transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto relative">
            <!-- Glass Header / Top Bar -->
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200/60 h-20 flex items-center px-10 justify-between">
                <div class="flex items-center gap-4">
                    <div class="h-8 w-1 bg-indigo-600 rounded-full"></div>
                    <h2 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em]">{{ $title ?? 'SISTEM MANAJEMEN TERPADU' }}</h2>
                </div>
                <div class="flex items-center gap-6">
                    <div class="hidden md:flex flex-col text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ now()->translatedFormat('l, d F Y') }}</p>
                        <p class="text-xs font-bold text-indigo-600 uppercase" id="live-clock">{{ now()->format('H:i:s') }} WIB</p>
                    </div>
                    <div class="h-10 w-px bg-slate-200"></div>
                    <button class="relative p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                </div>
            </header>

            <div class="p-10">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- UI Feedback Components -->
    <x-ui.notifikasi-toast />
    @livewireScripts

    <script>
        // Jam Digital Real-time
        setInterval(() => {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour12: false }) + ' WIB';
            document.getElementById('live-clock').textContent = timeString;
        }, 1000);
    </script>
</body>
</html>