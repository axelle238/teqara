@props(['id', 'title' => 'Panel'])

<div 
    x-data="{ show: false }"
    x-on:open-slide-over.window="if ($event.detail.id === '{{ $id }}') show = true"
    x-on:close-slide-over.window="if ($event.detail.id === '{{ $id }}') show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="relative z-[999]" 
    aria-labelledby="slide-over-title" 
    role="dialog" 
    aria-modal="true"
    style="display: none;"
>
    <!-- Background backdrop -->
    <div 
        x-show="show"
        x-transition:enter="ease-in-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"
        @click="show = false"
    ></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div 
                    x-show="show"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="pointer-events-auto w-screen max-w-md"
                >
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl">
                        <!-- Header -->
                        <div class="px-4 py-6 sm:px-6 bg-slate-50 border-b border-slate-100">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-bold text-slate-900" id="slide-over-title">{{ $title }}</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button @click="show = false" type="button" class="relative rounded-md text-slate-400 hover:text-slate-500 focus:outline-none">
                                        <span class="absolute -inset-2.5"></span>
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Body -->
                        <div class="relative flex-1 px-4 py-6 sm:px-6">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
