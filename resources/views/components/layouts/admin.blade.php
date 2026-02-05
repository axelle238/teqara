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
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-indigo-500 selection:text-white" x-data="{ sidebarOpen: false }">

    <!-- Mobile Header (Hanya muncul di layar kecil) -->
    <div class="lg:hidden flex items-center justify-between bg-white border-b border-slate-200 px-4 py-3 sticky top-0 z-30">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center text-white font-black text-xs">T</div>
            <span class="font-black text-slate-900 tracking-tighter uppercase text-sm">TEQARA HUB</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation 11 Pilar Utama -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-40 w-72 bg-white border-r border-slate-200 transform transition-transform duration-300 lg:static lg:translate-x-0 flex flex-col h-full shadow-2xl lg:shadow-none"
        >
            <!-- Brand Identity -->
            <div class="h-24 flex items-center px-8 border-b border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white font-black text-xl shadow-xl mr-4 group cursor-pointer overflow-hidden relative">
                    <span class="relative z-10">T</span>
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-cyan-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                <div>
                    <h1 class="font-black text-lg text-slate-900 tracking-tighter leading-none mb-1">TEQARA</h1>
                    <p class="text-[9px] font-black text-indigo-600 uppercase tracking-[0.3em]">Command Center v9.0</p>
                </div>
            </div>

            <!-- Navigasi Utama dengan Kontrol Aktif Eksklusif -->
            <nav 
                class="flex-1 overflow-y-auto py-8 px-4 space-y-1 custom-scrollbar" 
                x-data="{ 
                    aktif: '{{ 
                        match(true) {
                            request()->is('admin/dashboard') => 'dashboard',
                            request()->is('admin/toko*') => 'toko',
                            request()->is('admin/produk*') || request()->is('admin/kategori*') || request()->is('admin/merek*') || request()->is('admin/stok*') => 'produk',
                            request()->is('admin/pesanan*') && !request()->is('admin/pesanan/verifikasi*') => 'pesanan',
                            request()->is('admin/transaksi*') || request()->is('admin/pesanan/verifikasi*') => 'transaksi',
                            request()->is('admin/cs*') => 'cs',
                            request()->is('admin/logistik*') => 'logistik',
                            request()->is('admin/pelanggan*') => 'pelanggan',
                            request()->is('admin/pengguna*') || request()->is('admin/hrd*') => 'pengguna',
                            request()->is('admin/laporan*') => 'laporan',
                            request()->is('admin/pengaturan/sistem*') => 'sistem',
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
                    :class="aktif === 'dashboard' ? 'bg-slate-900 text-white shadow-xl shadow-slate-900/20' : 'text-slate-600 hover:bg-slate-100'"
                    class="group flex items-center px-5 py-4 text-xs font-black rounded-2xl transition-all duration-300 mb-8 uppercase tracking-[0.2em]"
                >
                    <svg :class="aktif === 'dashboard' ? 'text-indigo-400' : 'text-slate-400'" class="mr-4 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V1.512A9.025 9.001 0 0120.488 9z"></path></svg>
                    STATISTIK GLOBAL
                </a>

                <p class="px-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.4em] mb-4 opacity-50">Operasional Inti</p>

                <!-- 1. Manajemen Halaman Toko -->
                <div class="space-y-1">
                    <button @click="pilih('toko')" :class="aktif === 'toko' ? 'bg-purple-50 text-purple-900' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg :class="aktif === 'toko' ? 'text-purple-600' : 'text-slate-400'" class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1-0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                            Halaman Toko
                        </div>
                        <svg :class="aktif === 'toko' ? 'rotate-180 text-purple-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'toko'" x-cloak class="pl-12 space-y-1 py-2 border-l-2 border-purple-100 ml-7">
                        <a href="{{ route('admin.toko.dashboard') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/toko/dashboard') ? 'text-purple-700' : 'text-slate-500 hover:text-purple-600' }} transition uppercase tracking-widest">Dashboard Visual</a>
                        <a href="{{ route('admin.toko.konten') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/toko/konten') ? 'text-purple-700' : 'text-slate-500 hover:text-purple-600' }} transition uppercase tracking-widest">Editor CMS</a>
                        <a href="{{ route('admin.toko.berita') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/toko/berita') ? 'text-purple-700' : 'text-slate-500 hover:text-purple-600' }} transition uppercase tracking-widest">Berita & Informasi</a>
                    </div>
                </div>

                <!-- 2. Manajemen Produk & Gadget -->
                <div class="space-y-1">
                    <button @click="pilih('produk')" :class="aktif === 'produk' ? 'bg-emerald-50 text-emerald-900' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg :class="aktif === 'produk' ? 'text-emerald-600' : 'text-slate-400'" class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Produk & Gadget
                        </div>
                        <svg :class="aktif === 'produk' ? 'rotate-180 text-emerald-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'produk'" x-cloak class="pl-12 space-y-1 py-2 border-l-2 border-emerald-100 ml-7">
                        <a href="{{ route('admin.produk.dashboard') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/produk/dashboard') ? 'text-emerald-700' : 'text-slate-500 hover:text-emerald-600' }} transition uppercase tracking-widest">Dashboard Unit</a>
                        <a href="{{ route('admin.produk.katalog') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/produk/katalog') ? 'text-emerald-700' : 'text-slate-500 hover:text-emerald-600' }} transition uppercase tracking-widest">Katalog Pusat</a>
                        <a href="{{ route('admin.produk.stok') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/produk/stok') ? 'text-emerald-700' : 'text-slate-500 hover:text-emerald-600' }} transition uppercase tracking-widest">Audit Stok</a>
                    </div>
                </div>

                <!-- 3. Manajemen Pesanan -->
                <div class="space-y-1">
                    <button @click="pilih('pesanan')" :class="aktif === 'pesanan' ? 'bg-amber-50 text-amber-900' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg :class="aktif === 'pesanan' ? 'text-amber-600' : 'text-slate-400'" class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Pesanan Unit
                        </div>
                        <svg :class="aktif === 'pesanan' ? 'rotate-180 text-amber-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'pesanan'" x-cloak class="pl-12 space-y-1 py-2 border-l-2 border-amber-100 ml-7">
                        <a href="{{ route('admin.pesanan.dashboard') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/pesanan/dashboard') ? 'text-amber-700' : 'text-slate-500 hover:text-amber-600' }} transition uppercase tracking-widest">Dashboard Order</a>
                        <a href="{{ route('admin.pesanan.daftar') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/pesanan/daftar') ? 'text-amber-700' : 'text-slate-500 hover:text-amber-600' }} transition uppercase tracking-widest">Antrian Transaksi</a>
                    </div>
                </div>

                <!-- 4. Manajemen Transaksi -->
                <div class="space-y-1">
                    <button @click="pilih('transaksi')" :class="aktif === 'transaksi' ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg :class="aktif === 'transaksi' ? 'text-indigo-600' : 'text-slate-400'" class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Keuangan & Bayar
                        </div>
                        <svg :class="aktif === 'transaksi' ? 'rotate-180 text-indigo-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'transaksi'" x-cloak class="pl-12 space-y-1 py-2 border-l-2 border-indigo-100 ml-7">
                        <a href="{{ route('admin.transaksi.dashboard') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/transaksi/dashboard') ? 'text-indigo-700' : 'text-slate-500 hover:text-indigo-600' }} transition uppercase tracking-widest">Dashboard Arus Kas</a>
                        <a href="{{ route('admin.pesanan.verifikasi') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/pesanan/verifikasi') ? 'text-indigo-700' : 'text-slate-500 hover:text-indigo-600' }} transition uppercase tracking-widest">Validasi Pembayaran</a>
                    </div>
                </div>

                <p class="px-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.4em] mt-8 mb-4 opacity-50">Support & Services</p>

                <!-- 5. Customer Service -->
                <div class="space-y-1">
                    <button @click="pilih('cs')" :class="aktif === 'cs' ? 'bg-pink-50 text-pink-900' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg :class="aktif === 'cs' ? 'text-pink-600' : 'text-slate-400'" class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Customer Service
                        </div>
                        <svg :class="aktif === 'cs' ? 'rotate-180 text-pink-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'cs'" x-cloak class="pl-12 space-y-1 py-2 border-l-2 border-pink-100 ml-7">
                        <a href="{{ route('admin.cs.dashboard') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/cs/dashboard') ? 'text-pink-700' : 'text-slate-500 hover:text-pink-600' }} transition uppercase tracking-widest">Dashboard Bantuan</a>
                        <a href="{{ route('admin.pelanggan.ulasan') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/pelanggan/ulasan') ? 'text-pink-700' : 'text-slate-500 hover:text-pink-600' }} transition uppercase tracking-widest">Moderasi Ulasan</a>
                    </div>
                </div>

                <!-- 6. Logistik & Pengiriman -->
                <div class="space-y-1">
                    <button @click="pilih('logistik')" :class="aktif === 'logistik' ? 'bg-cyan-50 text-cyan-900' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg :class="aktif === 'logistik' ? 'text-cyan-600' : 'text-slate-400'" class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                            Logistik & Armada
                        </div>
                        <svg :class="aktif === 'logistik' ? 'rotate-180 text-cyan-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'logistik'" x-cloak class="pl-12 space-y-1 py-2 border-l-2 border-cyan-100 ml-7">
                        <a href="{{ route('admin.logistik.dashboard') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/logistik/dashboard') ? 'text-cyan-700' : 'text-slate-500 hover:text-cyan-600' }} transition uppercase tracking-widest">Dashboard Armada</a>
                        <a href="{{ route('admin.logistik.pemasok') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/logistik/pemasok') ? 'text-cyan-700' : 'text-slate-500 hover:text-cyan-600' }} transition uppercase tracking-widest">Manajemen Pemasok</a>
                    </div>
                </div>

                <!-- 7. Manajemen Pelanggan -->
                <div class="space-y-1">
                    <button @click="pilih('pelanggan')" :class="aktif === 'pelanggan' ? 'bg-rose-50 text-rose-900' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg :class="aktif === 'pelanggan' ? 'text-rose-600' : 'text-slate-400'" class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Data Pelanggan
                        </div>
                        <svg :class="aktif === 'pelanggan' ? 'rotate-180 text-rose-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'pelanggan'" x-cloak class="pl-12 space-y-1 py-2 border-l-2 border-rose-100 ml-7">
                        <a href="{{ route('admin.pelanggan.dashboard') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/pelanggan/dashboard') ? 'text-rose-700' : 'text-slate-500 hover:text-rose-600' }} transition uppercase tracking-widest">Dashboard CRM</a>
                        <a href="{{ route('admin.pelanggan.daftar') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/pelanggan/daftar') ? 'text-rose-700' : 'text-slate-500 hover:text-rose-600' }} transition uppercase tracking-widest">Basis Data Member</a>
                    </div>
                </div>

                <p class="px-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.4em] mt-8 mb-4 opacity-50">Identity & Governance</p>

                <!-- 8. Pegawai & Peran -->
                <div class="space-y-1">
                    <button @click="pilih('pengguna')" :class="aktif === 'pengguna' ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg :class="aktif === 'pengguna' ? 'text-slate-900' : 'text-slate-400'" class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Pegawai & Peran
                        </div>
                        <svg :class="aktif === 'pengguna' ? 'rotate-180 text-slate-900' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'pengguna'" x-cloak class="pl-12 space-y-1 py-2 border-l-2 border-slate-200 ml-7">
                        <a href="{{ route('admin.pengguna.dashboard') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/pengguna/dashboard') ? 'text-slate-900' : 'text-slate-500 hover:text-slate-900' }} transition uppercase tracking-widest">Dashboard SDM</a>
                        <a href="{{ route('admin.pengguna.daftar') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/pengguna/daftar') ? 'text-slate-900' : 'text-slate-500 hover:text-slate-900' }} transition uppercase tracking-widest">Administrator</a>
                        <a href="{{ route('admin.hrd.karyawan') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/hrd*') ? 'text-slate-900' : 'text-slate-500 hover:text-slate-900' }} transition uppercase tracking-widest">Struktur Kerja</a>
                    </div>
                </div>

                <!-- 9. Laporan & Analitik -->
                <div class="space-y-1">
                    <button @click="pilih('laporan')" :class="aktif === 'laporan' ? 'bg-orange-50 text-orange-900' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg :class="aktif === 'laporan' ? 'text-orange-600' : 'text-slate-400'" class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Laporan & Analitik
                        </div>
                        <svg :class="aktif === 'laporan' ? 'rotate-180 text-orange-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'laporan'" x-cloak class="pl-12 space-y-1 py-2 border-l-2 border-orange-100 ml-7">
                        <a href="{{ route('admin.laporan.pusat') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/laporan*') ? 'text-orange-700' : 'text-slate-500 hover:text-orange-600' }} transition uppercase tracking-widest">Jurnal Penjualan</a>
                    </div>
                </div>

                <!-- 10. Sistem Terpusat -->
                <div class="space-y-1">
                    <button @click="pilih('sistem')" :class="aktif === 'sistem' ? 'bg-cyan-50 text-cyan-900' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg :class="aktif === 'sistem' ? 'text-cyan-600' : 'text-slate-400'" class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Sistem Terpusat
                        </div>
                        <svg :class="aktif === 'sistem' ? 'rotate-180 text-cyan-600' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'sistem'" x-cloak class="pl-12 space-y-1 py-2 border-l-2 border-cyan-100 ml-7">
                        <a href="{{ route('admin.pengaturan.sistem') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/pengaturan/sistem') ? 'text-cyan-700' : 'text-slate-500 hover:text-cyan-600' }} transition uppercase tracking-widest">Identitas & API</a>
                        <a href="{{ route('admin.voucher') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/voucher') ? 'text-cyan-700' : 'text-slate-500 hover:text-cyan-600' }} transition uppercase tracking-widest">Voucher Promo</a>
                    </div>
                </div>

                <!-- 11. Keamanan Terpusat -->
                <div class="space-y-1">
                    <button @click="pilih('keamanan')" :class="aktif === 'keamanan' ? 'bg-red-900 text-white shadow-lg' : 'text-slate-600 hover:bg-slate-50'" class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-black rounded-2xl transition-all uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg :class="aktif === 'keamanan' ? 'text-red-400' : 'text-slate-400'" class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Keamanan Pusat
                        </div>
                        <svg :class="aktif === 'keamanan' ? 'rotate-180 text-red-400' : 'text-slate-400'" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="aktif === 'keamanan'" x-cloak class="pl-12 space-y-1 py-2 border-l-2 border-red-900 ml-7">
                        <a href="{{ route('admin.pengaturan.keamanan') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/pengaturan/keamanan') ? 'text-red-600' : 'text-slate-500 hover:text-red-600' }} transition uppercase tracking-widest">Kebijakan Akses</a>
                        <a href="{{ route('admin.pengaturan.log') }}" wire:navigate class="block px-4 py-2 text-[10px] font-bold {{ request()->is('admin/pengaturan/log') ? 'text-red-600' : 'text-slate-500 hover:text-red-600' }} transition uppercase tracking-widest">Audit Forensik</a>
                    </div>
                </div>

            </nav>

            <!-- User Footer Status -->
            <div class="p-6 bg-slate-50 border-t border-slate-100">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img class="h-10 w-10 rounded-xl object-cover border-2 border-white shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama) }}&background=0f172a&color=fff" alt="">
                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-black text-slate-900 truncate uppercase tracking-widest">{{ auth()->user()->nama }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase truncate">{{ auth()->user()->peran }} SISTEM</p>
                    </div>
                    <a href="/logout" class="p-2 text-slate-300 hover:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content Viewport -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- UI Components -->
    <x-ui.notifikasi-toast />
    @livewireScripts
</body>
</html>