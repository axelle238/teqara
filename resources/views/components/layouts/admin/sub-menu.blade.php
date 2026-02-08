@props(['route', 'label', 'icon' => 'fa-regular fa-circle-dot', 'warna' => 'text-slate-400'])

@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}" wire:navigate 
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[11px] font-bold transition-all relative group {{ $isActive ? 'text-white bg-white/10 shadow-sm' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    
    @if($isActive)
        <span class="absolute left-0 top-1/2 -translate-y-1/2 -ml-2 w-1 h-6 bg-current rounded-r-full opacity-50"></span>
    @endif
    
    <div class="w-6 h-6 flex items-center justify-center rounded-lg {{ $isActive ? 'bg-white/20 text-white' : $warna . ' group-hover:scale-110 group-hover:brightness-125' }} transition-all duration-300">
        <i class="{{ $icon }} text-xs"></i>
    </div>
    
    <span class="truncate">{{ $label }}</span>
</a>
