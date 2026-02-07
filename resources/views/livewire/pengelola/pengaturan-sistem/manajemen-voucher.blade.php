<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Kode <span class="text-emerald-600">Promo</span></h1>
            <p class="text-slate-500 font-medium">Manajemen kampanye diskon dan voucher belanja.</p>
        </div>
        
        @if(!$tampilkanForm)
        <button wire:click="tambahBaru" class="flex items-center gap-3 px-6 py-3 bg-emerald-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 active:scale-95">
            <i class="fa-solid fa-ticket"></i> Buat Voucher
        </button>
        @endif
    </div>

    @if(!$tampilkanForm)
        <!-- Search Bar -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm">
            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-search"></i>
                </div>
                <input wire:model.live.debounce.300ms="cari" type="text" class="w-full pl-11 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 transition-all" placeholder="Cari Kode Promo...">
            </div>
        </div>

        <!-- Voucher List -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($vouchers as $v)
            <div class="bg-white rounded-[2rem] border border-slate-200 p-6 shadow-sm hover:border-emerald-200 hover:shadow-lg transition-all relative overflow-hidden group">
                <!-- Decorative Circle -->
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full group-hover:bg-emerald-100 transition-colors"></div>

                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-4">
                        <span class="font-black text-emerald-600 text-lg bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100">{{ $v->kode }}</span>
                        
                        @php
                            $isExpired = $v->berlaku_sampai && \Carbon\Carbon::now()->gt($v->berlaku_sampai);
                        @endphp
                        
                        @if($isExpired)
                            <span class="px-2 py-1 bg-rose-100 text-rose-600 rounded text-[9px] font-black uppercase tracking-widest">Kadaluwarsa</span>
                        @else
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-600 rounded text-[9px] font-black uppercase tracking-widest">Aktif</span>
                        @endif
                    </div>

                    <div class="space-y-2 mb-6">
                        <p class="text-sm font-bold text-slate-700">{{ $v->deskripsi ?? 'Diskon Spesial' }}</p>
                        <p class="text-2xl font-black text-slate-900 tracking-tight">
                            @if($v->tipe_diskon == 'persen')
                                {{ $v->nilai_diskon }}% OFF
                            @else
                                -Rp {{ number_format($v->nilai_diskon/1000) }}K
                            @endif
                        </p>
                        <p class="text-xs text-slate-400">Min. Belanja: Rp {{ number_format($v->min_pembelian) }}</p>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            <i class="fa-solid fa-users w-4"></i> Kuota: {{ $v->kuota }}
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="edit({{ $v->id }})" class="w-8 h-8 rounded-lg bg-slate-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </button>
                            <button wire:confirm="Hentikan promo ini?" wire:click="hapus({{ $v->id }})" class="w-8 h-8 rounded-lg bg-slate-50 text-rose-500 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all">
                                <i class="fa-solid fa-stop text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center text-slate-400">
                <i class="fa-solid fa-ticket-simple text-4xl mb-4 opacity-30"></i>
                <p class="font-bold">Belum ada promo aktif.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $vouchers->links() }}
        </div>

    @else
        <!-- Form Editor -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-10 max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-8 border-b border-slate-100 pb-6">
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">
                    {{ $voucherId ? 'Edit Kampanye' : 'Kampanye Baru' }}
                </h3>
                <button wire:click="batal" class="text-slate-400 hover:text-rose-500 transition-colors">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>

            <form wire:submit="simpan" class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kode Promo</label>
                        <div class="flex gap-2">
                            <input type="text" wire:model="kode" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-mono text-lg font-black text-emerald-600 focus:ring-2 focus:ring-emerald-500 uppercase placeholder-slate-300" placeholder="TEQ-SALE2026">
                            <button type="button" wire:click="generateCode" class="px-4 bg-slate-100 rounded-xl text-slate-500 hover:bg-slate-200 transition-colors">
                                <i class="fa-solid fa-wand-magic-sparkles"></i>
                            </button>
                        </div>
                        @error('kode') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Kampanye</label>
                        <input type="text" wire:model="deskripsi" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500" placeholder="Contoh: Diskon Kemerdekaan">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tipe Potongan</label>
                        <select wire:model="tipe_diskon" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                            <option value="persen">Persentase (%)</option>
                            <option value="nominal">Nominal Tetap (Rp)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nilai Diskon</label>
                        <input type="number" wire:model="nilai_diskon" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Min. Belanja</label>
                        <input type="number" wire:model="min_pembelian" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kuota Klaim</label>
                        <input type="number" wire:model="kuota" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Mulai Berlaku</label>
                        <input type="datetime-local" wire:model="berlaku_mulai" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Berakhir Pada</label>
                        <input type="datetime-local" wire:model="berlaku_sampai" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t border-slate-100">
                    <button type="submit" class="px-8 py-4 bg-emerald-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">
                        Luncurkan Promo
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
