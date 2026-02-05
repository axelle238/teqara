<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Teqara - Pusat Komputer dan Gadget Terlengkap">
    <title>{{ $title ?? 'Teqara Computer' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-[Inter] text-slate-800 antialiased selection:bg-cyan-500 selection:text-white">
    
    <!-- Navbar -->
    <header class="sticky top-0 z-50 w-full border-b border-slate-200 bg-white/80 backdrop-blur-md">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <!-- Logo -->
            <a href="/" wire:navigate class="flex items-center gap-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-cyan-600 font-bold text-white">T</div>
                <span class="text-xl font-bold tracking-tight text-slate-900">TEQARA</span>
            </a>

            <!-- Navigasi Utama -->
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="/" wire:navigate class="text-slate-600 hover:text-cyan-600 transition">Beranda</a>
                <a href="/katalog" wire:navigate class="text-slate-600 hover:text-cyan-600 transition">Katalog</a>
                <a href="/promo" wire:navigate class="text-slate-600 hover:text-cyan-600 transition">Promo</a>
            </nav>

            <!-- Aksi Kanan -->
            <div class="flex items-center gap-4">
                <!-- Search (Placeholder) -->
                <button class="hidden md:flex items-center gap-2 rounded-full bg-slate-100 px-4 py-1.5 text-sm text-slate-400 hover:bg-slate-200 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Cari gadget...</span>
                </button>

                @auth
                    <a href="/dashboard" wire:navigate class="text-sm font-medium text-slate-600 hover:text-cyan-600">Dashboard</a>
                @else
                    <a href="/login" wire:navigate class="rounded-lg bg-cyan-600 px-4 py-2 text-sm font-medium text-white hover:bg-cyan-700 transition shadow-sm shadow-cyan-200">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="min-h-[calc(100vh-4rem-10rem)]">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white pt-12 pb-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-1 md:col-span-2">
                    <span class="text-xl font-bold tracking-tight text-slate-900 mb-4 block">TEQARA</span>
                    <p class="text-slate-500 text-sm max-w-xs">
                        Platform belanja komputer dan gadget terpercaya dengan layanan purna jual terbaik di Indonesia.
                    </p>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-900 mb-4">Belanja</h3>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li><a href="#" class="hover:text-cyan-600">Laptop</a></li>
                        <li><a href="#" class="hover:text-cyan-600">Komponen PC</a></li>
                        <li><a href="#" class="hover:text-cyan-600">Aksesoris</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-900 mb-4">Bantuan</h3>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li><a href="#" class="hover:text-cyan-600">Lacak Pesanan</a></li>
                        <li><a href="#" class="hover:text-cyan-600">Garansi</a></li>
                        <li><a href="#" class="hover:text-cyan-600">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-100 pt-8 text-center text-sm text-slate-400">
                &copy; {{ date('Y') }} Teqara Computer. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

</body>
</html>
