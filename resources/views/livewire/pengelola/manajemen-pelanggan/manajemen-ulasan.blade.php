<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="flex items-center gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Ulasan <span class="text-indigo-600">Pelanggan</span></h1>
            <p class="text-slate-500 font-medium">Moderasi feedback dan penilaian produk secara langsung.</p>
        </div>
        <div class="bg-indigo-50 text-indigo-700 px-4 py-2 rounded-xl text-xs font-bold border border-indigo-100 flex items-center gap-2">
            <i class="fa-solid fa-star text-amber-400"></i>
            <span>{{ $ulasan->total() }} Ulasan Masuk</span>
        </div>
    </div>

    <!-- Review Grid -->
    <div class="grid gap-6">
        @forelse($ulasan as $u)
        <div class="bg-white rounded-[30px] p-6 border border-slate-100 shadow-sm hover:shadow-lg transition-all flex flex-col md:flex-row gap-6 relative group overflow-hidden">
            <!-- Product Thumb -->
            <div class="w-full md:w-48 aspect-video md:aspect-square bg-slate-50 rounded-2xl flex items-center justify-center p-4 border border-slate-50">
                <img src="{{ $u->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-500">
            </div>

            <!-- Content -->
            <div class="flex-1 min-w-0 flex flex-col">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h4 class="font-black text-slate-900 text-lg line-clamp-1 mb-1">{{ $u->produk->nama }}</h4>
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <span class="font-bold text-slate-700">{{ $u->pengguna->nama }}</span>
                            <span>•</span>
                            <span>{{ $u->dibuat_pada->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 bg-amber-50 px-3 py-1 rounded-lg border border-amber-100">
                        <i class="fa-solid fa-star text-amber-400 text-sm"></i>
                        <span class="font-black text-amber-600 text-sm">{{ $u->rating }}</span>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-2xl p-4 text-sm text-slate-600 italic border border-slate-100 mb-4">
                    "{{ $u->komentar }}"
                </div>

                <!-- Photos -->
                @if($u->foto_ulasan && count($u->foto_ulasan) > 0)
                <div class="flex gap-2 mb-4">
                    @foreach($u->foto_ulasan as $foto)
                    <a href="{{ $foto }}" target="_blank" class="w-12 h-12 rounded-lg overflow-hidden border border-slate-200">
                        <img src="{{ $foto }}" class="w-full h-full object-cover">
                    </a>
                    @endforeach
                </div>
                @endif

                <!-- Actions -->
                <div class="mt-auto flex justify-end gap-3 pt-4 border-t border-slate-50 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button wire:click="hapus({{ $u->id }})" wire:confirm="Hapus ulasan ini? Tindakan tidak dapat dibatalkan." class="px-4 py-2 bg-rose-50 text-rose-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-100 transition-colors">
                        <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                    </button>
                    <!-- Future: Reply Feature -->
                    <button class="px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-colors">
                        <i class="fa-solid fa-reply mr-1"></i> Balas
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="py-20 text-center bg-white rounded-[40px] border border-dashed border-slate-200">
            <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl text-amber-400">
                <i class="fa-regular fa-star"></i>
            </div>
            <h3 class="text-xl font-black text-slate-900 uppercase">Belum Ada Ulasan</h3>
            <p class="text-slate-400 font-medium text-sm mt-2">Daftar ulasan produk akan muncul di sini.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $ulasan->links() }}
    </div>
</div>
