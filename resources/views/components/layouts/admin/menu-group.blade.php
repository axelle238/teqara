@props(['label', 'icon', 'id', 'active' => false])

<div x-data="{ expanded: {{ $active ? 'true' : 'false' }} }" class="relative">
    <button @click="if(!sidebarOpen) { sidebarOpen = true; setTimeout(() => expanded = true, 100); } else { expanded = !expanded; }"
            class="w-full group flex items-center justify-between px-3 py-3 rounded-xl transition-all duration-200 {{ $active ? 'text-indigo-300' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
            :class="!sidebarOpen && 'justify-center'">
        
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="w-6 h-6 flex items-center justify-center shrink-0 transition-transform group-hover:scale-110 {{ $active ? 'text-indigo-400' : 'text-slate-500 group-hover:text-white' }}">
                <i class="{{ $icon }} text-lg"></i>
            </div>
            <span class="text-xs font-bold tracking-wide truncate transition-opacity duration-300"
                  :class="!sidebarOpen ? 'opacity-0 w-0 hidden' : 'opacity-100'">
                {{ $label }}
            </span>
        </div>

        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300"
           :class="{'rotate-180': expanded, 'hidden': !sidebarOpen}"></i>
    </button>

    <div x-show="expanded" 
         x-collapse 
         x-cloak
         class="mt-1 space-y-1 pl-11 pr-2 overflow-hidden"
         :class="!sidebarOpen && 'hidden'">
        {{ $slot }}
    </div>
</div>
