<div class="hidden lg:block w-72 shrink-0 space-y-8">
    <!-- Profil Card -->
    <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-sm text-center relative overflow-hidden group">
        <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-indigo-500 to-purple-600"></div>
        <div class="relative z-10 -mt-12 mb-4">
            <div class="w-24 h-24 mx-auto bg-white p-1 rounded-full shadow-xl">
                <div class="w-full h-full rounded-full bg-slate-100 flex items-center justify-center text-3xl font-black text-indigo-600 overflow-hidden">
                    {{ substr(auth()->user()->nama, 0, 1) }}
                </div>
            </div>
        </div>
        <h3 class="font-black text-slate-900 text-lg uppercase tracking-tight mb-1">{{ auth()->user()->nama }}</h3>
        <p class="text-xs font-bold text-slate-400 mb-4">{{ auth()->user()->email }}</p>
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-full text-[10px] font-black uppercase tracking-widest">
            <i class="fa-solid fa-crown text-amber-400"></i> {{ auth()->user()->level_member ?? 'Member' }}
        </div>
    </div>

    <!-- Navigasi Menu -->
    <nav class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-sm space-y-2">
        <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Menu Utama</p>
        
        <a href="{{ route('pelanggan.dasbor') }}" wire:navigate class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('pelanggan.dasbor') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i class="fa-solid fa-gauge-high w-5 text-center"></i>
            <span class="text-xs font-bold uppercase tracking-wide">Ringkasan</span>
        </a>

        <a href="{{ route('pesanan.riwayat') }}" wire:navigate class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('pesanan*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i class="fa-solid fa-box-open w-5 text-center"></i>
            <span class="text-xs font-bold uppercase tracking-wide">Pesanan Saya</span>
        </a>

        <a href="{{ route('pelanggan.dompet') }}" wire:navigate class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('pelanggan.dompet') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i class="fa-solid fa-wallet w-5 text-center"></i>
            <span class="text-xs font-bold uppercase tracking-wide">Dompet & Poin</span>
        </a>

        <a href="{{ route('pelanggan.voucher') }}" wire:navigate class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('pelanggan.voucher') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i class="fa-solid fa-ticket w-5 text-center"></i>
            <span class="text-xs font-bold uppercase tracking-wide">Voucher</span>
        </a>

        <div class="h-px bg-slate-100 my-4"></div>
        <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pengaturan</p>

        <a href="{{ route('pelanggan.profil') }}" wire:navigate class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('pelanggan.profil') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i class="fa-solid fa-user-gear w-5 text-center"></i>
            <span class="text-xs font-bold uppercase tracking-wide">Edit Profil</span>
        </a>

        <a href="{{ route('pelanggan.alamat') }}" wire:navigate class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('pelanggan.alamat') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i class="fa-solid fa-map-location-dot w-5 text-center"></i>
            <span class="text-xs font-bold uppercase tracking-wide">Buku Alamat</span>
        </a>

        <a href="{{ route('pelanggan.keamanan') }}" wire:navigate class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('pelanggan.keamanan') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i class="fa-solid fa-shield-halved w-5 text-center"></i>
            <span class="text-xs font-bold uppercase tracking-wide">Keamanan</span>
        </a>

        <div class="h-px bg-slate-100 my-4"></div>

        <button wire:click="logout" onclick="window.location.href='{{ route('logout') }}'" class="w-full flex items-center gap-4 px-4 py-3 rounded-2xl text-rose-500 hover:bg-rose-50 transition-all text-left">
            <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
            <span class="text-xs font-black uppercase tracking-wide">Keluar</span>
        </button>
    </nav>
</div>
