<!-- 
    Nama File: resources/views/components/ui/notifikasi-toast.blade.php
    Tujuan: Menampilkan pesan notifikasi naratif yang non-blocking.
    Peran: Memberikan umpan balik instan kepada pengguna tanpa mengganggu alur kerja (Modal-free).
-->
<div
    x-data="{ 
        pesan: '', 
        tipe: 'sukses', 
        terbuka: false,
        tampilkan(detail) {
            this.pesan = detail.pesan;
            this.tipe = detail.tipe || 'sukses';
            this.terbuka = true;
            setTimeout(() => { this.terbuka = false }, 5000);
        }
    }"
    @notifikasi.window="tampilkan($event.detail)"
    x-show="terbuka"
    x-transition:enter="transform transition ease-out duration-300"
    x-transition:enter-start="translate-y-10 opacity-0 sm:translate-y-0 sm:translate-x-10"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed bottom-10 right-10 z-[200] w-full max-w-sm"
    style="display: none;"
>
    <div :class="{
        'bg-white border-emerald-500': tipe === 'sukses',
        'bg-white border-amber-500': tipe === 'peringatan',
        'bg-white border-red-500': tipe === 'error',
        'bg-white border-cyan-500': tipe === 'info'
    }" class="rounded-[24px] shadow-2xl border-l-8 p-5 flex items-center gap-4 border shadow-slate-200/50">
        
        <!-- Ikon Berwarna Berdasarkan Tipe -->
        <div :class="{
            'bg-emerald-50 text-emerald-600': tipe === 'sukses',
            'bg-amber-50 text-amber-600': tipe === 'peringatan',
            'bg-red-50 text-red-600': tipe === 'error',
            'bg-cyan-50 text-cyan-600': tipe === 'info'
        }" class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0">
            <template x-if="tipe === 'sukses'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </template>
            <template x-if="tipe === 'error'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </template>
            <template x-if="tipe === 'info' || tipe === 'peringatan'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </template>
        </div>

        <div class="flex-1">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1" x-text="tipe"></p>
            <p class="text-sm font-bold text-slate-700 leading-tight" x-text="pesan"></p>
        </div>

        <button @click="terbuka = false" class="text-slate-300 hover:text-slate-500 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
</div>
