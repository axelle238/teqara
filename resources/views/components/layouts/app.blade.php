<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Teqara - Pusat Teknologi Masa Depan' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfcfd; }
        .vibrant-navbar { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); }
        .colorful-gradient { background: linear-gradient(to right, #4f46e5, #06b6d4, #10b981); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .vibrant-btn { background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%); }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Navbar: No Black, Transparent Vibrant Look -->
    <header class="sticky top-0 z-[60] w-full vibrant-navbar border-b border-indigo-50 shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-24 items-center justify-between gap-8">
                
                <!-- Logo -->
                <a href="/" wire:navigate class="flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-600 to-cyan-600 flex items-center justify-center text-white font-black text-2xl shadow-xl shadow-indigo-500/20 group-hover:rotate-12 transition-transform">T</div>
                    <div class="hidden sm:block">
                        <span class="text-2xl font-black tracking-tighter text-indigo-600 group-hover:colorful-gradient transition-all uppercase">TEQARA</span>
                        <div class="h-1 w-full bg-gradient-to-r from-indigo-500 to-cyan-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></div>
                    </div>
                </a>

                <!-- Navigasi dengan Ikon -->
                <nav class="hidden lg:flex items-center gap-2">
                    <a href="/" wire:navigate class="flex items-center gap-2 px-5 py-3 text-sm font-black {{ request()->is('/') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }} rounded-2xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        BERANDA
                    </a>
                    <a href="/katalog" wire:navigate class="flex items-center gap-2 px-5 py-3 text-sm font-black {{ request()->is('katalog*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }} rounded-2xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        KATALOG
                    </a>
                    
                    <div class="relative group" x-data="{ open: false }">
                        <button @mouseenter="open = true" class="flex items-center gap-2 px-5 py-3 text-sm font-black text-slate-500 hover:text-indigo-600 rounded-2xl transition-all group">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            KATEGORI
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <!-- Mega Dropdown: Colorful with Icons -->
                        <div x-show="open" @mouseleave="open = false" class="absolute top-full left-0 w-72 bg-white border border-indigo-50 rounded-3xl shadow-2xl p-4 animate-in fade-in slide-in-from-top-4 duration-300">
                            <div class="grid gap-2">
                                <a href="/katalog?kategori=laptop-notebook" class="flex items-center gap-4 p-3 hover:bg-indigo-50 rounded-2xl transition group">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">💻</div>
                                    <div>
                                        <p class="text-xs font-black text-slate-900 uppercase">Laptop</p>
                                        <p class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest">Notebook & Workstation</p>
                                    </div>
                                </a>
                                <a href="/katalog?kategori=smartphone" class="flex items-center gap-4 p-3 hover:bg-emerald-50 rounded-2xl transition group">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">📱</div>
                                    <div>
                                        <p class="text-xs font-black text-slate-900 uppercase">Smartphone</p>
                                        <p class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest">Mobile & Gadgets</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Aksi Kanan -->
                <div class="flex items-center gap-4">
                    <livewire:komponen.spotlight-search />
                    <livewire:komponen.navbar-keranjang />

                    <div class="h-10 w-px bg-slate-100 mx-2 hidden sm:block"></div>

                    @auth
                        <a href="/Beranda" wire:navigate class="hidden sm:flex items-center gap-3 px-6 py-3 vibrant-btn text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:scale-105 transition-all shadow-lg shadow-indigo-500/20">
                            Beranda
                        </a>
                    @else
                        <a href="/login" wire:navigate class="px-8 py-3 bg-slate-100 hover:bg-indigo-600 hover:text-white text-indigo-600 rounded-2xl text-xs font-black uppercase tracking-widest transition-all">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer: Vibrant & Clean -->
    <footer class="bg-indigo-50/50 border-t border-indigo-100 pt-32 pb-12 overflow-hidden relative">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-4xl h-64 bg-indigo-500/10 blur-[120px] -z-10"></div>
        
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-16 mb-24">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-600 to-cyan-600 flex items-center justify-center text-white font-black text-2xl">T</div>
                        <span class="text-3xl font-black tracking-tighter text-indigo-600 uppercase">TEQARA<span class="text-cyan-500">.</span></span>
                    </div>
                    <p class="text-slate-500 text-xl font-medium leading-relaxed max-w-md">
                        Mendefinisikan ulang pengadaan teknologi dengan solusi hulu ke hilir yang transparan dan terpercaya.
                    </p>
                </div>
                <!-- Navigasi Footer -->
                <div class="space-y-8">
                    <h4 class="font-black text-indigo-600 uppercase tracking-[0.3em] text-[10px]">Perusahaan</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-slate-600 hover:text-indigo-600 font-bold transition">Tentang Kami</a></li>
                        <li><a href="#" class="text-slate-600 hover:text-indigo-600 font-bold transition">Karir</a></li>
                        <li><a href="#" class="text-slate-600 hover:text-indigo-600 font-bold transition">Mitra Bisnis</a></li>
                    </ul>
                </div>
                <div class="space-y-8">
                    <h4 class="font-black text-indigo-600 uppercase tracking-[0.3em] text-[10px]">Dukungan</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-slate-600 hover:text-indigo-600 font-bold transition">Pusat Bantuan</a></li>
                        <li><a href="#" class="text-slate-600 hover:text-indigo-600 font-bold transition">Kebijakan Retur</a></li>
                        <li><a href="#" class="text-slate-600 hover:text-indigo-600 font-bold transition">Status Pengiriman</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-12 border-t border-indigo-100 flex flex-col md:flex-row justify-between items-center gap-8">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">&copy; {{ date('Y') }} TEQARA Hub. Semua Hak Cipta Dilindungi.</p>
                <div class="flex gap-8">
                    <a href="#" class="text-slate-400 hover:text-indigo-600 transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.148-6.786 2.542-6.933 6.913-.059 1.277-.073 1.684-.073 4.948 0 3.264.014 3.671.072 4.947.148 4.358 2.542 6.786 6.913 6.933 1.277.059 1.684.073 4.948.073 3.264 0 3.671-.014 4.947-.072 4.358-.148 6.786-2.542 6.933-6.913.059-1.277.073-1.684.073-4.948 0-3.264-.014-3.671-.072-4.947-.148-4.358-2.542-6.786-6.913-6.933-1.277-.059-1.684-.073-4.948-.073z"></path></svg></a>
                    <a href="#" class="text-slate-400 hover:text-indigo-600 transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path></svg></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global Feedback Components -->
    <x-ui.notifikasi-toast />
    @livewireScripts
    <livewire:komponen.keranjang-preview />
</body>
</html>
