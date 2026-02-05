<div 
    x-data="{ 
        hapus(id) {
            $wire.hapusNotifikasi(id)
        }
    }"
    @hapus-notifikasi-otomatis.window="setTimeout(() => hapus($event.detail.id), 5000)"
    class="fixed bottom-4 right-4 z-[100] flex flex-col gap-2 w-full max-w-sm"
>
    @foreach($daftarNotifikasi as $notif)
        <div 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-8"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform translate-x-8"
            class="flex items-center p-4 rounded-xl shadow-lg border backdrop-blur-md {{ $notif['tipe'] === 'sukses' ? 'bg-emerald-50/90 border-emerald-200 text-emerald-800' : ($notif['tipe'] === 'error' ? 'bg-red-50/90 border-red-200 text-red-800' : 'bg-blue-50/90 border-blue-200 text-blue-800') }}"
        >
            <div class="flex-shrink-0">
                @if($notif['tipe'] === 'sukses')
                    <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @elseif($notif['tipe'] === 'error')
                    <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @else
                    <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @endif
            </div>
            <div class="ml-3 flex-1 text-sm font-medium">
                {{ $notif['pesan'] }}
            </div>
            <button @click="hapus('{{ $notif['id'] }}')" class="ml-4 flex-shrink-0 text-slate-400 hover:text-slate-600">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endforeach
</div>
