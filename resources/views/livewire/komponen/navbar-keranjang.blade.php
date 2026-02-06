<button 
    wire:click="$dispatch('open-slide-over', { id: 'keranjang-preview' })" 
    class="relative p-2 text-slate-500 hover:bg-slate-100 hover:text-indigo-600 rounded-xl transition-all group"
>
    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
    </svg>
    
    @if($jumlahItem > 0)
        <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-indigo-600 text-[9px] font-black text-white ring-2 ring-white shadow-sm">
            {{ $jumlahItem > 99 ? '99+' : $jumlahItem }}
        </span>
    @endif
</button>
