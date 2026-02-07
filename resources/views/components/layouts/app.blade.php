<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? ($globalSettings['nama_situs'] ?? 'Teqara Enterprise') }}</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $globalSettings['seo_description'] ?? ($globalSettings['deskripsi_situs'] ?? 'Pusat Teknologi Masa Depan') }}">
    <meta name="keywords" content="{{ $globalSettings['seo_keywords'] ?? 'ecommerce, teqara, teknologi, gadget, laptop' }}">
    <meta name="author" content="{{ $globalSettings['nama_situs'] ?? 'Teqara' }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        
        /* Dynamic Navbar State */
        .nav-scrolled { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        .nav-transparent { background: transparent; border-bottom: 1px solid transparent; }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-indigo-500 selection:text-white flex flex-col min-h-screen bg-slate-50/50">

    <!-- Enterprise Top Bar -->
    <div class="bg-[#0f172a] text-white/80 py-2 relative overflow-hidden hidden lg:block z-50">
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center relative z-10 text-[10px] font-bold uppercase tracking-[0.15em]">
            <div class="flex items-center gap-6">
                <a href="tel:{{ $globalSettings['telepon_dukungan'] ?? '' }}" class="flex items-center gap-2 hover:text-white transition-colors group">
                    <i class="fa-solid fa-phone-volume text-indigo-400 group-hover:text-indigo-300"></i> {{ $globalSettings['telepon_dukungan'] ?? 'Hubungi Kami' }}
                </a>
                <span class="text-slate-700">|</span>
                <a href="mailto:{{ $globalSettings['email_dukungan'] ?? '' }}" class="flex items-center gap-2 hover:text-white transition-colors group">
                    <i class="fa-solid fa-envelope text-indigo-400 group-hover:text-indigo-300"></i> {{ $globalSettings['email_dukungan'] ?? 'Email Support' }}
                </a>
            </div>
            <div class="flex items-center gap-6">
                <a href="/bantuan" class="hover:text-white transition-colors">Pusat Bantuan</a>
                <a href="/pesanan" class="hover:text-white transition-colors">Lacak Pesanan</a>
                @guest
                    <span class="text-slate-700">|</span>
                    <a href="/login" class="text-indigo-300 hover:text-white transition-colors">Login Staff</a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Smart Sticky Navigation -->
    <header class="sticky top-0 z-40 w-full transition-all duration-300" 
            x-data="{ scrolled: false, mobileMenuOpen: false, searchOpen: false }" 
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="scrolled ? 'nav-scrolled py-2' : 'nav-transparent py-4'">
        
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-8">
                
                <!-- Brand Logo -->
                <a href="/" wire:navigate class="flex items-center gap-3 group shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-cyan-500 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-500/20 group-hover:rotate-12 transition-transform duration-300">
                        {{ substr($globalSettings['nama_situs'] ?? 'T', 0, 1) }}
                    </div>
                    <div class="hidden sm:block leading-none">
                        <span class="block text-xl font-black tracking-tight text-slate-900 group-hover:text-indigo-600 transition-colors uppercase">{{ $globalSettings['nama_situs'] ?? 'TEQARA' }}</span>
                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em] group-hover:text-indigo-400 transition-colors">Enterprise Store</span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="/" wire:navigate class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide transition-all {{ request()->is('/') ? 'text-indigo-600 bg-indigo-50/50' : 'text-slate-500 hover:text-slate-900 hover:bg-white/50' }}">
                        Beranda
                    </a>
                    
                    <!-- Mega Menu Trigger -->
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide flex items-center gap-1 transition-all {{ request()->is('katalog*') ? 'text-indigo-600 bg-indigo-50/50' : 'text-slate-500 hover:text-slate-900 hover:bg-white/50' }}">
                            Katalog <i class="fa-solid fa-chevron-down text-[9px] transition-transform duration-300 opacity-50" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <!-- Mega Menu Content -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute top-full left-1/2 -translate-x-1/2 w-[600px] bg-white/95 backdrop-blur-xl rounded-[2rem] shadow-2xl border border-white/20 p-6 z-50 mt-2 grid grid-cols-2 gap-6 ring-1 ring-slate-900/5">
                            
                            <!-- Categories Column -->
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-100 pb-2">Kategori Utama</h4>
                                <div class="grid gap-2 max-h-[300px] overflow-y-auto custom-scrollbar pr-2">
                                    @foreach($globalCategories as $kat)
                                    <a href="/katalog?kategori={{ $kat->slug }}" class="flex items-center gap-3 p-2 rounded-xl hover:bg-indigo-50 transition-colors group">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-100/50 text-indigo-600 flex items-center justify-center text-sm group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                            <i class="{{ $kat->ikon ?? 'fa-solid fa-layer-group' }}"></i>
                                        </div>
                                        <div>
                                            <span class="block text-xs font-bold text-slate-700 group-hover:text-indigo-700">{{ $kat->nama }}</span>
                                            <span class="block text-[9px] text-slate-400">{{ $kat->produk_count }} Produk</span>
                                        </div>
                                    </a>
                                    @endforeach
                                    
                                    <a href="/katalog" class="flex items-center gap-2 p-2 mt-2 text-[10px] font-black uppercase tracking-widest text-indigo-600 hover:gap-3 transition-all sticky bottom-0 bg-white">
                                        Lihat Semua Kategori <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Featured Promo Column -->
                            <div class="bg-gradient-to-br from-indigo-600 to-violet-700 rounded-2xl p-6 text-white flex flex-col justify-between relative overflow-hidden group">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 group-hover:bg-white/20 transition-all"></div>
                                <div class="relative z-10">
                                    <span class="inline-block px-2 py-1 bg-white/20 rounded-md text-[9px] font-black uppercase tracking-wider mb-3 backdrop-blur-sm">Promo Spesial</span>
                                    <h3 class="text-xl font-black leading-tight mb-1">Upgrade Gear Kamu</h3>
                                    <p class="text-xs text-indigo-100 opacity-90 leading-relaxed">Diskon hingga 20% untuk produk terpilih khusus bulan ini.</p>
                                </div>
                                <a href="/katalog?promo=true" class="relative z-10 mt-4 px-4 py-2 bg-white text-indigo-700 text-[10px] font-black uppercase tracking-widest rounded-lg text-center hover:bg-indigo-50 transition-colors w-full">
                                    Cek Promo
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="/berita" wire:navigate class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide transition-all {{ request()->is('berita*') ? 'text-indigo-600 bg-indigo-50/50' : 'text-slate-500 hover:text-slate-900 hover:bg-white/50' }}">
                        Berita
                    </a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    
                    <!-- Quick Search (Desktop) -->
                    <div class="hidden md:block w-64 lg:w-80 relative" x-data="{ searchOpen: false }">
                        <livewire:komponen.pencarian-cepat />
                    </div>

                    <!-- Search Toggle (Mobile) -->
                    <div class="md:hidden relative">
                        <a href="/pencarian" wire:navigate class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-slate-50 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </a>
                    </div>

                    <!-- Cart -->
                    <livewire:komponen.navbar-keranjang />

                    <div class="h-6 w-px bg-slate-200 mx-1 hidden sm:block"></div>

                    @auth
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ userOpen: false }">
                            <button @click="userOpen = !userOpen" class="flex items-center gap-3 pl-1 pr-3 py-1 bg-white border border-slate-200 rounded-full hover:border-indigo-300 transition-all shadow-sm group">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 text-white flex items-center justify-center font-black text-xs shadow-md group-hover:scale-105 transition-transform">
                                    {{ substr(auth()->user()->nama, 0, 1) }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Halo,</span>
                                    <span class="block text-xs font-black text-slate-900 leading-none truncate max-w-[80px]">{{ explode(' ', auth()->user()->nama)[0] }}</span>
                                </div>
                                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform" :class="userOpen ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="userOpen" @click.away="userOpen = false" class="absolute top-full right-0 mt-3 w-64 bg-white/95 backdrop-blur-xl rounded-[2rem] shadow-2xl border border-white/20 p-2 z-50 animate-in fade-in slide-in-from-top-2 ring-1 ring-slate-900/5">
                                <div class="p-4 bg-slate-50/80 rounded-[1.5rem] mb-2 text-center border border-slate-100">
                                    <h4 class="font-bold text-slate-900">{{ auth()->user()->nama }}</h4>
                                    <p class="text-[10px] text-slate-500 font-mono">{{ auth()->user()->email }}</p>
                                    <div class="mt-3 flex justify-center gap-2">
                                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-[9px] font-black uppercase rounded-full tracking-wider border border-indigo-200">{{ auth()->user()->level_member ?? 'MEMBER' }}</span>
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <a href="{{ route('pelanggan.dasbor') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 text-slate-600 hover:text-indigo-600 transition-colors text-xs font-bold uppercase tracking-wide group">
                                        <i class="fa-solid fa-gauge-high w-5 text-center group-hover:scale-110 transition-transform"></i> Dasbor
                                    </a>
                                    <a href="{{ route('pesanan.riwayat') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 text-slate-600 hover:text-indigo-600 transition-colors text-xs font-bold uppercase tracking-wide group">
                                        <i class="fa-solid fa-box-open w-5 text-center group-hover:scale-110 transition-transform"></i> Pesanan
                                    </a>
                                    <a href="{{ route('pelanggan.profil') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 text-slate-600 hover:text-indigo-600 transition-colors text-xs font-bold uppercase tracking-wide group">
                                        <i class="fa-solid fa-user-gear w-5 text-center group-hover:scale-110 transition-transform"></i> Akun
                                    </a>
                                    <div class="h-px bg-slate-100 my-1"></div>
                                    <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-rose-50 text-rose-500 transition-colors text-xs font-black uppercase tracking-wide group">
                                        <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center group-hover:translate-x-1 transition-transform"></i> Keluar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="px-6 py-2.5 bg-slate-900 text-white rounded-full text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg shadow-slate-900/20 hover:shadow-indigo-600/30 active:scale-95">
                            Masuk / Daftar
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-600 flex items-center justify-center hover:bg-slate-50 transition-colors">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen" class="lg:hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm" x-transition.opacity>
            <div class="absolute right-0 top-0 h-full w-80 bg-white p-6 shadow-2xl overflow-y-auto" @click.away="mobileMenuOpen = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full">
                
                <div class="flex justify-between items-center mb-8">
                    <span class="text-xl font-black text-slate-900 uppercase tracking-tight">Menu</span>
                    <button @click="mobileMenuOpen = false" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-rose-100 hover:text-rose-500 transition-colors">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <div class="space-y-2">
                    <a href="/" class="block px-4 py-3 rounded-xl bg-slate-50 text-slate-900 font-bold text-sm">Beranda</a>
                    <a href="/katalog" class="block px-4 py-3 rounded-xl hover:bg-slate-50 text-slate-600 font-bold text-sm transition-colors">Katalog Produk</a>
                    <a href="/berita" class="block px-4 py-3 rounded-xl hover:bg-slate-50 text-slate-600 font-bold text-sm transition-colors">Berita & Blog</a>
                    <a href="/bantuan" class="block px-4 py-3 rounded-xl hover:bg-slate-50 text-slate-600 font-bold text-sm transition-colors">Pusat Bantuan</a>
                </div>

                @auth
                    <div class="mt-8 pt-8 border-t border-slate-100">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-lg">
                                {{ substr(auth()->user()->nama, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">{{ auth()->user()->nama }}</h4>
                                <p class="text-[10px] text-slate-500 font-mono uppercase tracking-wide">Member Access</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('pelanggan.dasbor') }}" class="px-4 py-3 rounded-xl bg-indigo-600 text-white text-xs font-bold text-center uppercase tracking-wide">Dasbor</a>
                            <a href="{{ route('logout') }}" class="px-4 py-3 rounded-xl bg-rose-50 text-rose-600 text-xs font-bold text-center uppercase tracking-wide">Keluar</a>
                        </div>
                    </div>
                @else
                    <div class="mt-8 pt-8 border-t border-slate-100">
                        <a href="{{ route('login') }}" class="block w-full py-4 bg-slate-900 text-white rounded-xl text-center font-black uppercase tracking-widest text-xs">Masuk Akun</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Enterprise Footer -->
    <footer class="bg-[#0f172a] text-slate-300 pt-20 pb-10 border-t border-slate-800 relative overflow-hidden">
        <!-- Decor -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 via-cyan-500 to-emerald-500"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-500/10 rounded-full blur-[100px] opacity-50"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-[100px] opacity-30"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 mb-16">
                
                <!-- Brand Info -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-cyan-500 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-900/50">
                            {{ substr($globalSettings['nama_situs'] ?? 'T', 0, 1) }}
                        </div>
                        <span class="text-2xl font-black text-white tracking-tight uppercase">{{ $globalSettings['nama_situs'] ?? 'TEQARA' }}</span>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400 max-w-xs">
                        {{ $globalSettings['deskripsi_situs'] ?? 'Platform Enterprise Commerce solusi pengadaan teknologi hulu ke hilir terpercaya.' }}
                    </p>
                    <div class="flex gap-4">
                        @if(!empty($globalSettings['sosial_facebook']))
                            <a href="{{ $globalSettings['sosial_facebook'] }}" class="w-10 h-10 rounded-full bg-slate-800/50 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all border border-slate-700 hover:border-indigo-500"><i class="fa-brands fa-facebook-f"></i></a>
                        @endif
                        @if(!empty($globalSettings['sosial_instagram']))
                            <a href="{{ $globalSettings['sosial_instagram'] }}" class="w-10 h-10 rounded-full bg-slate-800/50 flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all border border-slate-700 hover:border-pink-500"><i class="fa-brands fa-instagram"></i></a>
                        @endif
                        @if(!empty($globalSettings['sosial_twitter']))
                            <a href="{{ $globalSettings['sosial_twitter'] }}" class="w-10 h-10 rounded-full bg-slate-800/50 flex items-center justify-center hover:bg-sky-500 hover:text-white transition-all border border-slate-700 hover:border-sky-400"><i class="fa-brands fa-twitter"></i></a>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-[10px] font-black text-white uppercase tracking-[0.2em] mb-6">Perusahaan</h4>
                    <ul class="space-y-4 text-sm font-medium text-slate-400">
                        <li><a href="{{ route('tentang-kami') }}" class="hover:text-indigo-400 transition-colors flex items-center gap-2 group"><span class="w-1 h-1 bg-indigo-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition-colors flex items-center gap-2 group"><span class="w-1 h-1 bg-indigo-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Karir</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition-colors flex items-center gap-2 group"><span class="w-1 h-1 bg-indigo-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Berita & Media</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition-colors flex items-center gap-2 group"><span class="w-1 h-1 bg-indigo-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Mitra Bisnis</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-[10px] font-black text-white uppercase tracking-[0.2em] mb-6">Layanan Pelanggan</h4>
                    <ul class="space-y-4 text-sm font-medium text-slate-400">
                        <li><a href="{{ route('bantuan') }}" class="hover:text-indigo-400 transition-colors flex items-center gap-2 group"><span class="w-1 h-1 bg-indigo-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition-colors flex items-center gap-2 group"><span class="w-1 h-1 bg-indigo-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Metode Pembayaran</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition-colors flex items-center gap-2 group"><span class="w-1 h-1 bg-indigo-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Pengiriman & Logistik</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition-colors flex items-center gap-2 group"><span class="w-1 h-1 bg-indigo-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Kebijakan Garansi</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-[10px] font-black text-white uppercase tracking-[0.2em] mb-6">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm font-medium text-slate-400">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-indigo-500 shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <span class="mt-1">{{ $globalSettings['alamat_fisik'] ?? 'Jakarta, Indonesia' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-indigo-500 shrink-0">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <span>{{ $globalSettings['telepon_dukungan'] ?? '-' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-indigo-500 shrink-0">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <span>{{ $globalSettings['email_dukungan'] ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-bold text-slate-500">
                <p>&copy; {{ date('Y') }} {{ $globalSettings['nama_situs'] ?? 'Teqara' }}. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notifications -->
    <x-ui.notifikasi-toast />
</body>
</html>
