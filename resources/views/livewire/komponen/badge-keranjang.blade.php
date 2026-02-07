<div class="inline-block">
    @if($jumlahItem > 0)
        <span class="absolute top-0 right-0 -mr-1 -mt-1 flex h-4 w-4 items-center justify-center rounded-full bg-indigo-600 text-[9px] font-black text-white ring-2 ring-white shadow-sm animate-in zoom-in duration-300">
            {{ $jumlahItem > 99 ? '99+' : $jumlahItem }}
        </span>
    @endif
</div>
