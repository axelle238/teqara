@props(['route', 'icon', 'label', 'active' => false, 'badge' => null])

<a href="{{ route($route) }}" wire:navigate 
   class="group flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 relative overflow-hidden {{ $active ? 'bg-indigo-600/10 text-indigo-400 shadow-inner' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
   :class="!sidebarOpen && 'justify-center'"
   title="{{ $label }}">
    
    @if($active)
        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-indigo-500 rounded-r-full shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>
    @endif

    <div class="w-6 h-6 flex items-center justify-center shrink-0 transition-transform group-hover:scale-110 {{ $active ? 'text-indigo-400' : 'text-slate-500 group-hover:text-white' }}">
        <i class="{{ $icon }} text-lg"></i>
    </div>

    <span class="text-xs font-bold tracking-wide truncate transition-opacity duration-300" 
          :class="!sidebarOpen ? 'opacity-0 w-0 hidden' : 'opacity-100 flex-1'">
        {{ $label }}
    </span>

    @if($badge)
        <span class="px-2 py-0.5 rounded-full bg-rose-500 text-white text-[9px] font-black shrink-0 shadow-lg shadow-rose-500/20"
              :class="!sidebarOpen && 'absolute top-1 right-1 w-2 h-2 p-0 rounded-full'">
            <span :class="!sidebarOpen && 'hidden'">{{ $badge }}</span>
        </span>
    @endif
</a>
