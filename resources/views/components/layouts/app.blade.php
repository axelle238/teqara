<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Teqara - Solusi Teknologi Enterprise' }}</title>
    
    <!-- Fonts: Plus Jakarta Sans (Modern & Enterprise) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        .text-gradient { background: linear-gradient(to right, #0891b2, #4f46e5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-cyan-500 selection:text-white">

    <!-- Top Glow Ornament -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-4xl h-64 bg-cyan-500/10 blur-[120px] -z-10 pointer-events-none"></div>

    <!-- Header / Navbar Enterprise -->
    <header class="sticky top-0 z-[60] w-full glass-effect border-b border-slate-200/60">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between gap-8">
                <!-- Logo -->
                <a href="/" wire:navigate class="flex items-center gap-3 group">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-cyan-500 to-indigo-600 font-black text-white shadow-lg shadow-cyan-500/20 group-hover:scale-110 transition-transform duration-300">T</div>
                    <div class="hidden sm:block">
                        <span class="text-xl font-extrabold tracking-tighter text-slate-900">TEQARA</span>
                        <div class="h-1 w-full bg-gradient-to-r from-cyan-500 to-indigo-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></div>
                    </div>
                </a>

                <!-- Navigasi Tengah -->
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="/" wire:navigate class="px-4 py-2 text-sm font-bold {{ request()->is('/') ? 'text-cyan-600 bg-cyan-50' : 'text-slate-600 hover:text-cyan-600 hover:bg-slate-50' }} rounded-xl transition-all">Beranda</a>
                    <a href="/katalog" wire:navigate class="px-4 py-2 text-sm font-bold {{ request()->is('katalog*') ? 'text-cyan-600 bg-cyan-50' : 'text-slate-600 hover:text-cyan-600 hover:bg-slate-50' }} rounded-xl transition-all">Katalog</a>
                    <div class="relative group">
                        <button class="px-4 py-2 text-sm font-bold text-slate-600 group-hover:text-cyan-600 flex items-center gap-1 transition-all">
                            Kategori
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <!-- Mega Menu Dropdown (BUKAN MODAL) -->
                        <div class="absolute top-full left-0 w-64 bg-white border border-slate-200 rounded-2xl shadow-xl opacity-0 translate-y-4 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-300 p-4">
                            <div class="grid gap-2">
                                <a href="/katalog?kategori=laptop-notebook" class="flex items-center gap-3 p-2 hover:bg-cyan-50 rounded-xl transition text-slate-600 hover:text-cyan-700">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">💻</div>
                                    <span class="text-sm font-bold">Laptop & Notebook</span>
                                </a>
                                <a href="/katalog?kategori=smartphone" class="flex items-center gap-3 p-2 hover:bg-cyan-50 rounded-xl transition text-slate-600 hover:text-cyan-700">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">📱</div>
                                    <span class="text-sm font-bold">Smartphone</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Aksi Kanan -->
                <div class="flex items-center gap-2">
                    <!-- Global Search -->
                    <livewire:komponen.spotlight-search />

                    <livewire:komponen.navbar-keranjang />

                    <div class="h-8 w-px bg-slate-200 mx-2 hidden sm:block"></div>

                    @auth
                        <a href="/dashboard" wire:navigate class="hidden sm:flex items-center gap-3 px-4 py-2 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/20">
                            Dashboard
                        </a>
                    @else
                        <a href="/login" wire:navigate class="hidden sm:block text-sm font-bold text-slate-600 hover:text-cyan-600 px-4 transition-all">Masuk</a>
                        <a href="/login" wire:navigate class="px-5 py-2.5 bg-gradient-to-r from-cyan-600 to-indigo-600 text-white rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-cyan-500/30 transition-all">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer Enterprise -->
    <footer class="bg-white border-t border-slate-200 pt-24 pb-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white font-bold">T</div>
                        <span class="text-2xl font-black tracking-tighter text-slate-900 uppercase">TEQARA</span>
                    </div>
                    <p class="text-slate-500 text-lg leading-relaxed max-w-md">
                        Membangun masa depan teknologi Indonesia dengan menghadirkan solusi komputasi tercanggih untuk profesional dan gamer.
                    </p>
                </div>
                <div>
                    <h4 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Navigasi</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-slate-500 hover:text-cyan-600 font-bold transition">Tentang Kami</a></li>
                        <li><a href="#" class="text-slate-500 hover:text-cyan-600 font-bold transition">Karir</a></li>
                        <li><a href="#" class="text-slate-500 hover:text-cyan-600 font-bold transition">Kontak Bisnis</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Dukungan</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-slate-500 hover:text-cyan-600 font-bold transition">Pusat Bantuan</a></li>
                        <li><a href="#" class="text-slate-500 hover:text-cyan-600 font-bold transition">Kebijakan Garansi</a></li>
                        <li><a href="#" class="text-slate-500 hover:text-cyan-600 font-bold transition">Lacak Pesanan</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-400 text-sm font-medium">&copy; {{ date('Y') }} Teqara Enterprise. Seluruh Hak Cipta Dilindungi.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-slate-400 hover:text-cyan-600 transition">Instagram</a>
                    <a href="#" class="text-slate-400 hover:text-cyan-600 transition">LinkedIn</a>
                    <a href="#" class="text-slate-400 hover:text-cyan-600 transition">Twitter</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global Components -->
    <x-ui.notifikasi-toast />
    <x-ui.slide-over id="global-panel" title="Panel Sistem" />

</body>
</html>