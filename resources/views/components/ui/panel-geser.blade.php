@props(['id', 'judul' => 'Panel Informasi'])

<!-- Container Utama: Z-Index Tinggi, Pointer-events dikelola via Alpine -->
<div 
    x-data="{ open: false }"
    x-on:open-slide-over.window="if ($event.detail.id === '{{ $id }}') open = true"
    x-on:open-panel-form-karyawan.window="if ('{{ $id }}' === 'panel-form-karyawan') open = true"
    x-on:open-panel-form-produk.window="if ('{{ $id }}' === 'panel-form-produk') open = true"
    x-on:close-slide-over.window="if ($event.detail.id === '{{ $id }}') open = false"
    x-on:close-panel-form-karyawan.window="if ('{{ $id }}' === 'panel-form-karyawan') open = false"
    x-on:close-panel-form-produk.window="if ('{{ $id }}' === 'panel-form-produk') open = false"
    x-on:keydown.escape.window="open = false"
    class="relative z-[60]"
    aria-labelledby="slide-over-title" 
    role="dialog" 
    aria-modal="true"
    style="display: none;"
    x-show="open"
>
    <!-- Backdrop Blur (Klik luar untuk tutup) -->
    <div 
        x-show="open"
        x-transition:enter="ease-in-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-indigo-900/20 backdrop-blur-sm transition-opacity" 
        @click="open = false"
    ></div>

    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                
                <!-- Panel Geser -->
                <div 
                    x-show="open"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="pointer-events-auto w-screen max-w-md"
                >
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl">
                        <!-- Header Panel -->
                        <div class="px-6 py-6 bg-gradient-to-r from-indigo-600 to-purple-600 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-black text-white uppercase tracking-widest leading-6" id="slide-over-title">
                                    {{ $judul }}
                                </h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" class="rounded-full bg-white/20 p-1 text-white hover:bg-white hover:text-indigo-600 transition-all focus:outline-none focus:ring-2 focus:ring-white" @click="open = false">
                                        <span class="sr-only">Tutup panel</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Isi Konten -->
                        <div class="relative flex-1 px-4 py-6 sm:px-6 bg-slate-50">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
