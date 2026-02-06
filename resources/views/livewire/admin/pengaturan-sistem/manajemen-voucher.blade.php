<div class="space-y-12 pb-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">STRATEGI <span class="text-cyan-600">PROMOSI</span></h1>
            <p class="text-slate-500 font-medium text-lg">Manajemen insentif penjualan, kupon digital, dan kampanye diskon.</p>
        </div>
        <button wire:click="tambahBaru" class="flex items-center gap-3 px-8 py-4 bg-slate-900 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-cyan-600 transition-all shadow-xl">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            BUAT VOUCHER BARU
        </button>
    </div>

    <!-- Voucher Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($vouchers as $v)
        <div class="relative group bg-white rounded-[32px] border border-slate-100 overflow-hidden hover:shadow-2xl hover:shadow-cyan-500/10 transition-all duration-500 flex flex-col">
            <!-- Ticket Cut Design (Top) -->
            <div class="absolute top-1/2 left-0 w-6 h-6 bg-slate-50 rounded-full -translate-x-1/2 -translate-y-1/2 border-r border-slate-200"></div>
            <div class="absolute top-1/2 right-0 w-6 h-6 bg-slate-50 rounded-full translate-x-1/2 -translate-y-1/2 border-l border-slate-200"></div>
            
            <!-- Content Top -->
            <div class="p-8 bg-gradient-to-br from-cyan-500 to-blue-600 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-2">Diskon Spesial</p>
                    <h3 class="text-4xl font-black tracking-tighter">
                        {{ $v->tipe_diskon == 'persen' ? $v->nilai_diskon . '%' : 'Rp' . number_format($v->nilai_diskon/1000) . 'k' }}
                    </h3>
                    <p class="text-xs font-bold mt-1 opacity-90">Min. Belanja: Rp {{ number_format($v->min_pembelian, 0, ',', '.') }}</p>
                </div>
                <div class="absolute -right-6 -bottom-12 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            </div>

            <!-- Content Bottom -->
            <div class="p-8 pt-10 flex-1 flex flex-col bg-slate-50/30">
                <div class="flex justify-between items-center mb-6">
                    <div class="bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                        <span class="font-mono font-black text-lg text-slate-800 tracking-widest uppercase">{{ $v->kode }}</span>
                    </div>
                    <button wire:click="edit({{ $v->id }})" class="text-cyan-600 hover:text-cyan-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                </div>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-400 font-bold">Masa Berlaku</span>
                        <span class="text-slate-700 font-bold">{{ \Carbon\Carbon::parse($v->berlaku_sampai)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-400 font-bold">Sisa Kuota</span>
                        <span class="text-slate-700 font-bold">{{ $v->kuota }} Klaim</span>
                    </div>
                    <!-- Kuota Bar -->
                    <div class="w-full bg-slate-200 rounded-full h-1.5">
                        <div class="bg-cyan-500 h-1.5 rounded-full" style="width: {{ min(100, ($v->kuota / 100) * 100) }}%"></div>
                    </div>
                </div>

                <div class="mt-auto pt-6 border-t border-slate-200 border-dashed">
                    <button wire:click="hapus({{ $v->id }})" wire:confirm="Hapus voucher promo ini secara permanen?" class="w-full py-3 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all">
                        Nonaktifkan Promo
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <div class="text-6xl mb-6">🎟️</div>
            <h3 class="text-2xl font-black text-slate-900 tracking-tighter uppercase mb-2">Belum Ada Promo</h3>
            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Buat kampanye diskon pertama Anda sekarang.</p>
        </div>
        @endforelse
    </div>

    <!-- Panel Form Voucher -->
    <x-ui.panel-geser id="form-voucher" judul="KONFIGURASI KAMPANYE DISKON">
        <form wire:submit.prevent="simpan" class="space-y-8 p-2">
            <!-- Kode & Tipe -->
            <div class="bg-cyan-50 p-6 rounded-[24px] border border-cyan-100">
                <div class="flex justify-between items-end mb-4">
                    <label class="text-[10px] font-black text-cyan-600 uppercase tracking-widest">Kode Unik Promo</label>
                    <button type="button" wire:click="generateCode" class="text-[9px] font-black text-cyan-700 bg-white px-3 py-1 rounded-lg shadow-sm hover:bg-cyan-100 transition">GENERATE ACAK</button>
                </div>
                <input wire:model="kode" type="text" class="w-full bg-white border-none rounded-xl text-2xl font-black text-slate-900 uppercase tracking-widest text-center focus:ring-2 focus:ring-cyan-500 placeholder:text-slate-300" placeholder="KODE...">
                @error('kode') <span class="text-rose-500 text-[10px] font-bold block mt-2 text-center">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tipe Potongan</label>
                    <select wire:model.live="tipe_diskon" class="w-full bg-slate-50 border-none rounded-xl font-bold text-slate-700 focus:ring-2 focus:ring-cyan-500">
                        <option value="persen">Persentase (%)</option>
                        <option value="nominal">Nominal Tetap (Rp)</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nilai Diskon</label>
                    <input wire:model="nilai_diskon" type="number" class="w-full bg-slate-50 border-none rounded-xl font-bold text-slate-900 focus:ring-2 focus:ring-cyan-500">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Deskripsi Kampanye</label>
                <textarea wire:model="deskripsi" rows="3" class="w-full bg-slate-50 border-none rounded-xl font-medium focus:ring-2 focus:ring-cyan-500" placeholder="Jelaskan syarat dan keuntungan promo..."></textarea>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Syarat Min. Belanja</label>
                    <input wire:model="min_pembelian" type="number" class="w-full bg-slate-50 border-none rounded-xl font-bold text-slate-900 focus:ring-2 focus:ring-cyan-500">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Batas Klaim (Kuota)</label>
                    <input wire:model="kuota" type="number" class="w-full bg-slate-50 border-none rounded-xl font-bold text-slate-900 focus:ring-2 focus:ring-cyan-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Mulai Berlaku</label>
                    <input wire:model="berlaku_mulai" type="datetime-local" class="w-full bg-slate-50 border-none rounded-xl font-bold text-slate-700 focus:ring-2 focus:ring-cyan-500 text-xs">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Berakhir Pada</label>
                    <input wire:model="berlaku_sampai" type="datetime-local" class="w-full bg-slate-50 border-none rounded-xl font-bold text-slate-700 focus:ring-2 focus:ring-cyan-500 text-xs">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-cyan-600 transition-all shadow-xl">
                    LUNCURKAN KAMPANYE
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>
