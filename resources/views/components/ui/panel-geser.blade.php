<!-- 
    Nama File: resources/views/components/ui/panel-geser.blade.php
    Tujuan: Komponen pengganti modal (Slide-over) dengan gaya High-Tech.
    Peran: Menyediakan kontainer untuk form atau detail tanpa menutup konteks halaman utama.
-->
@props(['id', 'judul' => 'Detail Panel'])

<div
    x-data="{ terbuka: false }"
    x-show="terbuka"
    @open-slide-over.window="if ($event.detail.id === '{{ $id }}') terbuka = true"
    @close-slide-over.window="if ($event.detail.id === '{{ $id }}') terbuka = false"
    @keydown.escape.window="terbuka = false"
    class="relative z-[100]"
    style="display: none;"
>
    <!-- Latar Belakang Blur (No Modal) -->
    <div 
        x-show="terbuka"
        x-transition:enter="ease-in-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"
        @click="terbuka = false"
    ></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                <div
                    x-show="terbuka"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="pointer-events-auto w-screen max-w-2xl"
                >
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl border-l border-slate-200">
                        <!-- Header Panel -->
                        <div class="bg-slate-50 px-6 py-6 border-b border-slate-100 sm:px-8">
                            <div class="flex items-start justify-between">
                                <h2 class="text-xl font-black text-slate-900 tracking-tighter uppercase">{{ $judul }}</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button 
                                        type="button" 
                                        class="rounded-xl bg-white p-2 text-slate-400 hover:text-red-500 border border-slate-200 transition-all hover:rotate-90"
                                        @click="terbuka = false"
                                    >
                                        <span class="sr-only">Tutup panel</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Konten Panel -->
                        <div class="relative flex-1 px-6 py-8 sm:px-8">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
