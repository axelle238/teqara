<div class="relative group" x-data="{ open: false }" @click.away="open = false">
    <div class="hidden md:flex relative">
        <input 
            wire:model.live.debounce.300ms="kueri" 
            @focus="open = true"
            type="text" 
            placeholder="Pencarian Global (Unit, Faktur, Member...)" 
            class="pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-xs font-bold w-64 focus:ring-2 focus:ring-indigo-500 transition-all focus:w-96 placeholder:text-slate-400 text-slate-700 shadow-inner"
        >
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400"></i>
    </div>

    <!-- Results Dropdown -->
    <div 
        x-show="open && kueri.length >= 3" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="absolute top-full right-0 mt-2 w-[400px] bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-[100]"
        style="display: none;"
    >
        <div class="max-h-[500px] overflow-y-auto custom-scrollbar">
            
            @php $adaHasil = false; @endphp

            <!-- PRODUK -->
            @if(!empty($hasil['produk']) && count($hasil['produk']) > 0)
                @php $adaHasil = true; @endphp
                <div class="p-4 bg-slate-50/50 border-b border-slate-50">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500">Unit Produk</span>
                </div>
                @foreach($hasil['produk'] as $p)
                <a href="{{ route('pengelola.produk.edit', $p->id) }}" wire:navigate class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0 group">
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $p->nama }}</p>
                        <p class="text-[10px] font-mono text-slate-400 uppercase">{{ $p->kode_unit }}</p>
                    </div>
                </a>
                @endforeach
            @endif

            <!-- PESANAN -->
            @if(!empty($hasil['pesanan']) && count($hasil['pesanan']) > 0)
                @php $adaHasil = true; @endphp
                <div class="p-4 bg-slate-50/50 border-b border-slate-50">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500">Faktur Pesanan</span>
                </div>
                @foreach($hasil['pesanan'] as $p)
                <a href="{{ route('pengelola.pesanan.detail', $p->id) }}" wire:navigate class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0 group">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-800 group-hover:text-emerald-600 transition-colors">{{ $p->nomor_faktur }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $p->status_pesanan }}</p>
                    </div>
                </a>
                @endforeach
            @endif

            <!-- PELANGGAN -->
            @if(!empty($hasil['pelanggan']) && count($hasil['pelanggan']) > 0)
                @php $adaHasil = true; @endphp
                <div class="p-4 bg-slate-50/50 border-b border-slate-50">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-cyan-500">Direktori Member</span>
                </div>
                @foreach($hasil['pelanggan'] as $p)
                <a href="#" class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0 group">
                    <div class="w-10 h-10 rounded-lg bg-cyan-50 flex items-center justify-center text-cyan-600">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-800 group-hover:text-cyan-600 transition-colors">{{ $p->nama }}</p>
                        <p class="text-[10px] font-bold text-slate-400">{{ $p->email }}</p>
                    </div>
                </a>
                @endforeach
            @endif

            <!-- VENDOR -->
            @if(!empty($hasil['vendor']) && count($hasil['vendor']) > 0)
                @php $adaHasil = true; @endphp
                <div class="p-4 bg-slate-50/50 border-b border-slate-50">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-500">Mitra Vendor</span>
                </div>
                @foreach($hasil['vendor'] as $v)
                <a href="{{ route('pengelola.vendor.edit', $v->id) }}" wire:navigate class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0 group">
                    <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-800 group-hover:text-orange-600 transition-colors">{{ $v->nama_perusahaan }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $v->kode_pemasok }}</p>
                    </div>
                </a>
                @endforeach
            @endif

            @if(!$adaHasil)
            <div class="p-12 text-center">
                <i class="fa-solid fa-magnifying-glass-slash text-3xl text-slate-200 mb-4"></i>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Data Tidak Ditemukan</p>
            </div>
            @endif

        </div>
        
        <div class="p-4 bg-indigo-600 text-center">
            <span class="text-[9px] font-black text-white/80 uppercase tracking-[0.3em]">Teqara Intelligence Search</span>
        </div>
    </div>
</div>
