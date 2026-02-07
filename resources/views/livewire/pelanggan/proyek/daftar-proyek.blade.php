<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Manajemen <span class="text-indigo-600">Proyek</span></h1>
                <p class="text-slate-500 font-medium text-sm mt-2">Kelompokkan pengadaan barang berdasarkan inisiatif bisnis Anda.</p>
            </div>
            @if(!$tambahMode)
            <button wire:click="$set('tambahMode', true)" class="flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg hover:shadow-indigo-500/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Proyek
            </button>
            @endif
        </div>

        @if($tambahMode)
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl mb-10 animate-fade-in-up">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Proyek Baru</h3>
                <button wire:click="$set('tambahMode', false)" class="text-slate-400 hover:text-rose-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit.prevent="simpan" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama Proyek</label>
                    <input wire:model="nama_proyek" type="text" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: Upgrade Server Jakarta 2026">
                    @error('nama_proyek') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Anggaran (Estimasi)</label>
                    <input wire:model="anggaran" type="number" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500" placeholder="Rp">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Target Selesai</label>
                    <input wire:model="tenggat" type="date" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Deskripsi Singkat</label>
                    <textarea wire:model="deskripsi" rows="3" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>

                <div class="md:col-span-2 pt-4 flex justify-end">
                    <button type="submit" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 transition-all">Simpan Proyek</button>
                </div>
            </form>
        </div>
        @endif

        @if($this->proyekSaya->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($this->proyekSaya as $p)
            <a href="{{ route('pelanggan.proyek.detail', $p->id) }}" class="group bg-white rounded-[2.5rem] p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <!-- Status Badge -->
                <div class="absolute top-6 right-6">
                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $p->status == 'selesai' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                        {{ $p->status }}
                    </span>
                </div>

                <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center text-3xl mb-6 text-white shadow-lg group-hover:scale-110 transition-transform">
                    📂
                </div>

                <h3 class="text-xl font-black text-slate-900 mb-2 leading-tight group-hover:text-indigo-600 transition-colors">{{ $p->nama_proyek }}</h3>
                <p class="text-sm text-slate-500 line-clamp-2 mb-6 h-10">{{ $p->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                <div class="grid grid-cols-2 gap-4 pt-6 border-t border-slate-50">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Item</p>
                        <p class="text-sm font-black text-slate-900">{{ $p->items_count }} Unit</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Anggaran</p>
                        <p class="text-sm font-black text-indigo-600">{{ $p->anggaran ? 'Rp ' . number_format($p->anggaran/1000000, 1) . ' Jt' : '-' }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $this->proyekSaya->links() }}
        </div>
        @else
        <div class="text-center py-24 bg-white rounded-[3rem] border border-dashed border-slate-200">
            <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl opacity-50">🏗️</div>
            <h3 class="text-slate-900 font-black mb-1">Belum Ada Proyek</h3>
            <p class="text-slate-400 text-sm mb-6">Mulai organisir pengadaan barang Anda dalam folder proyek.</p>
            <button wire:click="$set('tambahMode', true)" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all">Buat Sekarang</button>
        </div>
        @endif

    </div>
</div>
