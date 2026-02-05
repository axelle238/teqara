<a href="/keranjang" wire:navigate class="relative p-2 text-slate-600 hover:text-cyan-600 transition group">
    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
    </svg>
    
    @if($jumlahItem > 0)
        <span class="absolute top-0 right-0 flex h-4 w-4 items-center justify-center rounded-full bg-cyan-600 text-[10px] font-bold text-white ring-2 ring-white">
            {{ $jumlahItem > 99 ? '99+' : $jumlahItem }}
        </span>
    @endif
</a>
