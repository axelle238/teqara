<div class="space-y-12 pb-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em]">Corporate Brands Hub</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">OTORITAS <span class="text-indigo-600">MEREK</span></h1>
            <p class="text-slate-500 font-medium text-lg">Manajemen prinsipal dan pemegang lisensi perangkat teknologi.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Form Panel (Left) -->
        <div class="lg:col-span-4">
            <div class="bg-white p-10 rounded-[48px] shadow-xl shadow-slate-200/50 border border-white sticky top-10">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-xl shadow-lg">
                        {{ $modeEdit ? '✎' : '＋' }}
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">{{ $modeEdit ? 'Ubah Merek' : 'Merek Baru' }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Registrasi Entitas</p>
                    </div>
                </div>

                <form wire:submit.prevent="{{ $modeEdit ? 'perbarui' : 'simpan' }}" class="space-y-8">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Prinsipal (Merek)</label>
                        <input wire:model.live="nama" type="text" class="w-full rounded-2xl border-none bg-slate-50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-slate-300" placeholder="ASUS, Apple, Lenovo, dsb">
                        @error('nama') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest mt-2 px-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">URL Logo Vektor</label>
                        <input wire:model="logo" type="text" class="w-full rounded-2xl border-none bg-slate-50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-slate-300" placeholder="https://domain.com/logo.png">
                    </div>

                    @if($logo)
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 flex items-center justify-center">
                        <img src="{{ $logo }}" class="h-16 object-contain filter grayscale group-hover:grayscale-0 transition-all">
                    </div>
                    @endif

                    <div class="pt-4 flex gap-3">
                        @if($modeEdit)
                            <button type="submit" class="flex-1 bg-indigo-600 text-white py-5 rounded-[28px] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20 active:scale-95">
                                PERBARUI DATA
                            </button>
                            <button type="button" wire:click="$set('modeEdit', false)" class="px-8 bg-slate-100 text-slate-400 rounded-[28px] font-black text-xs uppercase tracking-[0.2em] hover:bg-rose-50 hover:text-rose-600 transition-all">
                                BATAL
                            </button>
                        @else
                            <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-[28px] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/10 active:scale-95 group">
                                KONFIRMASI MEREK
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Grid (Right) -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
                <div class="p-10 border-b border-indigo-50 bg-slate-50/30 flex items-center justify-between">
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Portofolio Merek</h3>
                    <span class="px-4 py-1.5 bg-white border border-indigo-50 rounded-full text-[10px] font-black text-indigo-400 uppercase tracking-widest shadow-sm">{{ $daftarMerek->total() }} Partner</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Logo & Korporasi</th>
                                <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Handle (Slug)</th>
                                <th class="px-10 py-6 text-right">Otoritas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($daftarMerek as $merk)
                            <tr class="group hover:bg-indigo-50/20 transition-all duration-300">
                                <td class="px-10 py-6">
                                    <div class="flex items-center gap-6">
                                        <div class="w-16 h-16 rounded-2xl bg-white border border-indigo-50 flex-shrink-0 flex items-center justify-center p-3 shadow-sm group-hover:scale-110 transition-transform">
                                            @if($merk->logo)
                                                <img class="w-full h-full object-contain" src="{{ $merk->logo }}" alt="">
                                            @else
                                                <span class="text-2xl font-black text-indigo-200 uppercase">{{ substr($merk->nama, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div class="space-y-1">
                                            <p class="font-black text-slate-900 tracking-tight leading-none text-base uppercase">{{ $merk->nama }}</p>
                                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Brand ID: #{{ str_pad($merk->id, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <span class="text-xs font-mono font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-lg border border-slate-200 uppercase tracking-wider">{{ $merk->slug }}</span>
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all transform group-hover:translate-x-0 translate-x-4">
                                        <button wire:click="edit({{ $merk->id }})" class="p-3 bg-white border border-indigo-100 text-indigo-400 hover:text-white hover:bg-indigo-600 rounded-2xl transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button wire:click="hapus({{ $merk->id }})" wire:confirm="PERINGATAN: Menghapus merek akan memutus kaitan pada unit produk terkait. Eksekusi?" class="p-3 bg-white border border-rose-100 text-rose-400 hover:text-white hover:bg-rose-600 rounded-2xl transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-10 py-20 text-center text-slate-400 font-black uppercase tracking-widest">Partner merek belum terdaftar.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-10 bg-slate-50/30 border-t border-slate-50 flex justify-center">{{ $daftarMerek->links() }}</div>
            </div>
        </div>
    </div>
</div>