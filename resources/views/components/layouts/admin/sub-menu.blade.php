@props(['route', 'label'])

@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}" wire:navigate 
   class="block px-3 py-2 rounded-lg text-[11px] font-bold transition-all relative group {{ $isActive ? 'text-white bg-white/10' : 'text-slate-500 hover:text-slate-300 hover:bg-white/5' }}">
    
    @if($isActive)
        <span class="absolute left-0 top-1/2 -translate-y-1/2 -ml-2 w-1 h-1 bg-indigo-400 rounded-full shadow-[0_0_8px_rgba(99,102,241,0.8)]"></span>
    @endif
    
    {{ $label }}
</a>
