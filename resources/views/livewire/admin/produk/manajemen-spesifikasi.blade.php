<div class="space-y-10">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.produk.katalog') }}" wire:navigate class="p-3 bg-white border border-slate-200 rounded-2xl text-slate-400 hover:text-indigo-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tighter uppercase">SPESIFIKASI <span class="text-indigo-600">UNIT</span></h1>
            <p class="text-sm text-slate-500 font-medium">Mengatur rincian teknis untuk: <span class="font-bold text-slate-900">{{ $produk->nama }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Form Input -->
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 sticky top-10">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">Tambah Parameter</h3>
                <form wire:submit.prevent="tambah" class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Label (Judul)</label>
                        <input wire:model="inputJudul" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-indigo-500 font-bold" placeholder="Contoh: RAM / Prosesor">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nilai (Value)</label>
                        <input wire:model="inputNilai" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-indigo-500" placeholder="Contoh: 16GB LPDDR5X">
                    </div>
                    <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-slate-800 transition shadow-xl shadow-slate-900/10">
                        Sematkan Data
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Arsip Spesifikasi Saat Ini</h3>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse($spesifikasi as $s)
                    <div class="px-8 py-6 flex items-center justify-between group hover:bg-slate-50/50 transition">
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-1">{{ $s->judul }}</p>
                            <p class="text-lg font-bold text-slate-900 tracking-tight">{{ $s->nilai }}</p>
                        </div>
                        <button wire:click="hapus({{ $s->id }})" class="p-3 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all opacity-0 group-hover:opacity-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                    @empty
                    <div class="px-8 py-20 text-center">
                        <p class="text-slate-400 font-bold">Belum ada spesifikasi teknis yang ditambahkan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
