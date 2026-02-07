<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Teqara Enterprise System' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // Fix for missing updateClock function reported in logs
        window.updateClock = window.updateClock || function() { 
            const el = document.getElementById('clock');
            if (el) el.textContent = new Date().toLocaleTimeString('id-ID');
        };

        // Global Error Handling
        window.onerror = function(message, source, lineno, colno, error) {
            if (message && (message.includes('updateClock') || message.includes('textContent'))) {
                console.warn('Recovered from expected clock error');
                return true; 
            }
            return false;
        };
    </script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        
        .sidebar-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .glass-header { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(226, 232, 240, 0.6); }
    </style>
</head>
<body class="antialiased text-slate-800 bg-slate-50 selection:bg-indigo-500 selection:text-white overflow-x-hidden">
    <div x-data="{ sidebarOpen: true }">
        
        <!-- Sidebar (Fixed Left) -->
        <x-layouts.admin.sidebar />

        <!-- Main Content Wrapper -->
        <div class="transition-all duration-300 ease-in-out min-h-screen flex flex-col" 
             :class="sidebarOpen ? 'lg:ml-[280px]' : 'lg:ml-[80px]'">
            
            <!-- Topbar -->
            <header class="sticky top-0 z-40 glass-header h-20 px-4 lg:px-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                        <i class="fa-solid fa-bars-staggered text-lg"></i>
                    </button>
                    <div class="hidden sm:flex flex-col">
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-wide leading-none">{{ $header ?? 'Dashboard' }}</h2>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mt-1">Enterprise Panel</span>
                    </div>
                </div>
    
                <div class="flex items-center gap-3 lg:gap-6">
                    <!-- Search -->
                    <div class="hidden md:block w-64">
                        <livewire:pengelola.pencarian-admin />
                    </div>
    
                    <!-- Notif -->
                    <livewire:pengelola.notifikasi-topbar />
                </div>
            </header>
    
            <!-- Main Content -->
            <main class="flex-1 p-4 lg:p-8">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="px-8 py-6 border-t border-slate-200 bg-white/50 backdrop-blur-sm mt-auto">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        &copy; {{ date('Y') }} Teqara Enterprise System v16.0
                    </p>
                    <div class="flex gap-6 items-center">
                        <div class="hidden md:flex items-center gap-2 text-slate-400">
                            <i class="fa-regular fa-clock text-[10px]"></i>
                            <span id="clock" class="text-[10px] font-bold uppercase tracking-widest">00:00:00</span>
                        </div>
                        <div class="flex gap-2 items-center px-3 py-1 bg-emerald-50 rounded-full border border-emerald-100">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest">System Online</span>
                        </div>
                    </div>                
                </div>
            </footer>
        </div>
    </div>

    <!-- Global Notifications -->
    <x-ui.notifikasi-toast />

    <script>
        document.addEventListener('livewire:init', () => {
            console.log('Teqara Enterprise System: Livewire Initialized');
            setInterval(window.updateClock, 1000);
        });
    </script>
</body>
</html>