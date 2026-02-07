<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Portal Mitra Teqara B2B' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="h-full overflow-hidden" x-data="{ sidebarOpen: true }">

    <!-- Sidebar Mitra B2B -->
    <aside 
        class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-white transition-transform duration-300 ease-in-out flex flex-col border-r border-slate-800"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <!-- Logo Area -->
        <div class="h-16 flex items-center gap-3 px-6 bg-slate-950 border-b border-slate-800 shrink-0">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center font-black text-white">M</div>
            <span class="font-black tracking-widest uppercase text-lg">MITRA<span class="text-emerald-400">.</span>B2B</span>
        </div>

        <!-- Menu Scroll Area -->
        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-2 custom-scrollbar">
            
            <a href="{{ route('mitra.beranda') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('mitra.beranda') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/50' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-all group">
                <i class="fa-solid fa-chart-pie w-5 text-center group-hover:scale-110 transition-transform"></i>
                Dashboard Mitra
            </a>

            <div class="pt-4 pb-2">
                <p class="px-3 text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Operasional</p>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors opacity-50 cursor-not-allowed" title="Segera Hadir">
                    <i class="fa-solid fa-box w-5 text-center"></i> Produk Saya
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors opacity-50 cursor-not-allowed" title="Segera Hadir">
                    <i class="fa-solid fa-file-invoice w-5 text-center"></i> Pesanan Masuk (PO)
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors opacity-50 cursor-not-allowed" title="Segera Hadir">
                    <i class="fa-solid fa-wallet w-5 text-center"></i> Keuangan & Faktur
                </a>
            </div>

            <div class="pt-4 pb-2">
                <p class="px-3 text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Pengaturan</p>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors opacity-50 cursor-not-allowed">
                    <i class="fa-solid fa-user-gear w-5 text-center"></i> Profil Perusahaan
                </a>
            </div>
            
            <!-- Logout -->
            <div class="pt-8 pb-4">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-bold text-rose-400 hover:bg-rose-500/10 hover:text-rose-500 transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i> Keluar Portal
                </a>
            </div>
        </nav>
        
        <!-- User Profile Mini -->
        <div class="p-4 bg-slate-950 border-t border-slate-800 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center font-bold text-white shadow-lg">
                {{ substr(auth()->user()->nama ?? 'M', 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-white truncate">{{ auth()->user()->nama ?? 'Mitra' }}</p>
                <p class="text-xs text-slate-500 truncate">Supplier Terverifikasi</p>
            </div>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main 
        class="flex-1 h-full overflow-hidden flex flex-col transition-all duration-300 ease-in-out bg-slate-50"
        :class="sidebarOpen ? 'ml-72' : 'ml-0'"
    >
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 z-40 sticky top-0 shadow-sm">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                
                <nav class="hidden md:flex items-center text-sm font-medium text-slate-500">
                    <span>Mitra Portal</span>
                    <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-slate-300"></i>
                    <span class="text-slate-900">{{ $title ?? 'Dashboard' }}</span>
                </nav>
            </div>
        </header>

        <!-- Area Konten Scrollable -->
        <div class="flex-1 overflow-auto p-6 lg:p-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Global Components -->
    <x-ui.notifikasi-toast />
</body>
</html>
