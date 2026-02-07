<div class="space-y-6 animate-fade-in pb-20">
    <div class="flex justify-between items-center bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
        <div>
            <h1 class="text-xl font-black text-slate-900 uppercase tracking-tight">Voucher <span class="text-indigo-600">Promo</span></h1>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Kelola Kupon Diskon</p>
        </div>
        <button wire:click="tambahBaru" class="px-6 py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg">
            <i class="fa-solid fa-plus mr-2"></i> Buat Voucher
        </button>
    </div>

    <!-- Form Inline (Tanpa Modal) -->
    @if($modeForm)
    <div class="bg-indigo-50/50 p-8 rounded-[2.5rem] border border-indigo-100 animate-slide-down relative">
        <button wire:click="$set('modeForm', false)" class="absolute top-6 right-6 text-slate-400 hover:text-rose-500"><i class="fa-solid fa-xmark text-xl"></i></button>
        <h3 class="text-sm font-black text-indigo-900 uppercase tracking-widest mb-6">Editor Voucher</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kode Voucher</label>
                <input type="text" wire:model="kode" class="w-full bg-white border-none rounded-xl p-4 text-xs font-black uppercase tracking-widest focus:ring-2 focus:ring-indigo-500" placeholder="CONTOH: PROMO123">
                @error('kode') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tipe Potongan</label>
                <select wire:model="tipe" class="w-full bg-white border-none rounded-xl p-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
                    <option value="persentase">Persentase (%)</option>
                    <option value="tetap">Nominal Tetap (Rp)</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nilai Potongan</label>
                <input type="number" wire:model="nominal" class="w-full bg-white border-none rounded-xl p-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Min. Belanja</label>
                <input type="number" wire:model="min_belanja" class="w-full bg-white border-none rounded-xl p-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kuota</label>
                <input type="number" wire:model="kuota" class="w-full bg-white border-none rounded-xl p-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Berlaku Sampai</label>
                <input type="date" wire:model="berlaku_sampai" class="w-full bg-white border-none rounded-xl p-4 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>
        <div class="mt-8 flex justify-end gap-3">
            <button wire:click="$set('modeForm', false)" class="px-6 py-3 bg-white text-slate-500 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50">Batal</button>
            <button wire:click="simpan" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200">Simpan Voucher</button>
        </div>
    </div>
    @endif

    <!-- Daftar Voucher -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($voucher as $v)
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-xl transition-all">
            <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50 rounded-bl-[2rem] -mr-4 -mt-4 transition-transform group-hover:scale-150 group-hover:bg-indigo-100"></div>
            
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-[9px] font-black uppercase tracking-widest">{{ $v->tipe }}</span>
                    <div class="flex gap-2">
                        <button wire:click="edit({{ $v->id }})" class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-200 transition-colors"><i class="fa-solid fa-pen text-xs"></i></button>
                        <button wire:click="hapus({{ $v->id }})" wire:confirm="Hapus voucher ini?" class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-rose-600 hover:border-rose-200 transition-colors"><i class="fa-solid fa-trash text-xs"></i></button>
                    </div>
                </div>

                <h3 class="text-2xl font-black text-slate-900 tracking-tight font-mono mb-1">{{ $v->kode }}</h3>
                <p class="text-xs font-bold text-slate-500">
                    Diskon {{ $v->tipe == 'persentase' ? $v->nominal . '%' : 'Rp ' . number_format($v->nominal,0,',','.') }}
                </p>

                <div class="mt-6 pt-4 border-t border-slate-50 flex justify-between items-center">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Sisa Kuota</p>
                        <p class="text-sm font-black text-slate-800">{{ $v->kuota }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Berlaku Hingga</p>
                        <p class="text-xs font-bold text-slate-800">{{ \Carbon\Carbon::parse($v->berlaku_sampai)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-3xl">
                <i class="fa-solid fa-ticket-simple"></i>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Belum ada voucher aktif</p>
        </div>
        @endforelse
    </div>

    {{ $voucher->links() }}
</div>