<div class="space-y-8">
    <!-- User Card Mini -->
    <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-sm relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50 rounded-full blur-2xl -mr-10 -mt-10 group-hover:bg-indigo-100 transition-colors"></div>
        <div class="relative z-10 flex items-center gap-4">
            <div class="w-16 h-16 rounded-[1.5rem] bg-gradient-to-tr from-indigo-500 to-purple-500 p-1 shadow-lg">
                <div class="w-full h-full bg-white rounded-[1.3rem] flex items-center justify-center text-2xl font-black text-indigo-600">
                    {{ substr(auth()->user()->nama, 0, 1) }}
                </div>
            </div>
            <div>
                <h4 class="font-black text-slate-900 text-lg leading-tight">{{ explode(' ', auth()->user()->nama)[0] }}</h4>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ auth()->user()->level_member ?? 'Member' }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="bg-white rounded-[2.5rem] p-4 border border-slate-100 shadow-sm space-y-2">
        @php
            $menu = [
                ['label' => 'Dashboard Utama', 'route' => 'pelanggan.dasbor', 'icon' => 'fa-gauge-high', 'color' => 'indigo'],
                ['label' => 'Pesanan Saya', 'route' => 'pesanan.riwayat', 'icon' => 'fa-box-open', 'color' => 'emerald'],
                ['label' => 'Keranjang Belanja', 'route' => 'keranjang', 'icon' => 'fa-cart-shopping', 'color' => 'rose'],
                ['label' => 'Wishlist & Favorit', 'route' => 'daftar-keinginan', 'icon' => 'fa-heart', 'color' => 'pink'],
                ['label' => 'Tiket Bantuan', 'route' => 'bantuan', 'icon' => 'fa-headset', 'color' => 'amber'],
                ['label' => 'Pengaturan Akun', 'route' => 'pelanggan.profil', 'icon' => 'fa-user-gear', 'color' => 'slate'],
            ];
        @endphp

        @foreach($menu as $item)
        <a href="{{ route($item['route']) }}" wire:navigate 
           class="flex items-center gap-4 px-5 py-4 rounded-2xl transition-all group relative overflow-hidden {{ request()->routeIs($item['route']) ? 'bg-'.$item['color'].'-50 text-'.$item['color'].'-600 shadow-sm ring-1 ring-'.$item['color'].'-100' : 'hover:bg-slate-50 text-slate-500 hover:text-slate-900' }}">
            
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg transition-colors {{ request()->routeIs($item['route']) ? 'bg-white text-'.$item['color'].'-600 shadow-sm' : 'bg-slate-50 text-slate-400 group-hover:bg-white group-hover:text-'.$item['color'].'-500 group-hover:shadow-sm' }}">
                <i class="fa-solid {{ $item['icon'] }}"></i>
            </div>
            
            <span class="text-xs font-black uppercase tracking-wide flex-1">{{ $item['label'] }}</span>
            
            @if(request()->routeIs($item['route']))
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
            @endif
        </a>
        @endforeach

        <div class="h-px bg-slate-100 my-2 mx-4"></div>

        <button wire:click="logout" class="w-full flex items-center gap-4 px-5 py-4 rounded-2xl hover:bg-rose-50 text-slate-500 hover:text-rose-600 transition-all group">
            <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center text-lg group-hover:bg-white group-hover:text-rose-500 group-hover:shadow-sm transition-colors">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </div>
            <span class="text-xs font-black uppercase tracking-wide">Keluar</span>
        </button>
    </nav>

    <!-- Promo Banner Mini -->
    <div class="bg-gradient-to-br from-indigo-600 to-violet-700 rounded-[2.5rem] p-6 text-white relative overflow-hidden text-center">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 space-y-4">
            <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto text-xl">
                <i class="fa-solid fa-gem"></i>
            </div>
            <div>
                <h4 class="font-black text-lg">Member Premium</h4>
                <p class="text-[10px] text-indigo-100 opacity-90 leading-relaxed mt-1">Dapatkan diskon ongkir prioritas dan akses promo eksklusif.</p>
            </div>
            <button class="w-full py-3 bg-white text-indigo-700 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg hover:bg-indigo-50 transition-colors">
                Upgrade Sekarang
            </button>
        </div>
    </div>
</div>
