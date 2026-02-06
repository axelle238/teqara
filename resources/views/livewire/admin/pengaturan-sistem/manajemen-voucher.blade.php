<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Marketing Campaigns</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola voucher diskon dan promosi penjualan.</p>
        </div>
        <button wire:click="tambahBaru" class="flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
            <i class="fa-solid fa-ticket"></i> Buat Promo Baru
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-indigo-500 to-fuchsia-600 rounded-[24px] p-6 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-xs font-bold text-white/80 uppercase tracking-widest">Voucher Aktif</p>
                <h3 class="text-3xl font-black mt-2">{{ $vouchers->total() }}</h3>
            </div>
            <i class="fa-solid fa-tags absolute right-4 top-4 text-white/20 text-6xl rotate-12"></i>
        </div>
    </div>

    <!-- Voucher Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($vouchers as $v)
        <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition-all flex flex-col sm:flex-row">
            <!-- Left Ticket Part -->
            <div class="bg-slate-900 p-6 flex flex-col items-center justify-center text-center w-full sm:w-40 relative group">
                <div class="absolute inset-y-0 right-0 w-4 translate-x-2 bg-white rounded-full"></div> <!-- Cutout effect -->
                <div class="absolute inset-y-0 left-0 w-4 -translate-x-2 bg-white rounded-full sm:hidden"></div>
                
                <h3 class="text-2xl font-black text-white tracking-widest">{{ $v->kode }}</h3>
                <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase">Kode Promo</p>
                
                <button onclick="navigator.clipboard.writeText('{{ $v->kode }}')" class="mt-4 p-2 bg-white/10 hover:bg-white/20 rounded-lg text-white transition-colors" title="Salin Kode">
                    <i class="fa-regular fa-copy"></i>
                </button>
            </div>

            <!-- Right Detail Part -->
            <div class="p-6 flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <span class="px-2 py-1 rounded bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest">
                            {{ $v->tipe_diskon == 'persen' ? 'Diskon %' : 'Potongan Harga' }}
                        </span>
                        <div class="flex gap-2">
                            <button wire:click="edit({{ $v->id }})" class="text-slate-400 hover:text-indigo-600 transition-colors"><i class="fa-solid fa-pen"></i></button>
                            <button wire:click="hapus({{ $v->id }})" wire:confirm="Hentikan promo ini?" class="text-slate-400 hover:text-rose-500 transition-colors"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                    
                    <h4 class="font-bold text-slate-900 text-lg">
                        @if($v->tipe_diskon == 'persen')
                            Diskon {{ $v->nilai_diskon }}%
                        @else
                            Potongan Rp {{ number_format($v->nilai_diskon, 0, ',', '.') }}
                        @endif
                    </h4>
                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $v->deskripsi }}</p>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center text-xs">
                    <div class="font-bold text-slate-600">
                        <i class="fa-solid fa-users mr-1 text-slate-400"></i> Sisa Kuota: {{ $v->kuota }}
                    </div>
                    <div class="font-bold text-slate-600">
                        <i class="fa-regular fa-calendar mr-1 text-slate-400"></i> Exp: {{ \Carbon\Carbon::parse($v->berlaku_sampai)->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Slide Over Form -->
    <x-ui.panel-geser id="panel-form-voucher" :judul="$voucherId ? 'Edit Promo' : 'Buat Kampanye Baru'">
        <form wire:submit="simpan" class="space-y-6">
            
            <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 flex justify-between items-center">
                <div>
                    <label class="block text-xs font-bold text-indigo-800 uppercase tracking-widest mb-1">Kode Voucher</label>
                    <input wire:model="kode" type="text" class="bg-transparent border-none p-0 text-xl font-black text-indigo-900 placeholder-indigo-300 focus:ring-0 uppercase tracking-widest" placeholder="SALE2026">
                </div>
                <button type="button" wire:click="generateCode" class="p-2 bg-white rounded-lg text-indigo-600 hover:scale-110 transition-transform shadow-sm">
                    <i class="fa-solid fa-arrows-rotate"></i>
                </button>
            </div>
            @error('kode') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Deskripsi Promo</label>
                <textarea wire:model="deskripsi" rows="2" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500" placeholder="Contoh: Diskon spesial ulang tahun Teqara..."></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Tipe Diskon</label>
                    <select wire:model="tipe_diskon" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold">
                        <option value="persen">Persentase (%)</option>
                        <option value="nominal">Nominal Tetap (Rp)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Nilai Diskon</label>
                    <input wire:model="nilai_diskon" type="number" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold" placeholder="10 atau 50000">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Syarat Min. Belanja</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-xs font-bold text-slate-400">Rp</span>
                    <input wire:model="min_pembelian" type="number" class="w-full pl-8 rounded-xl border-slate-200 text-sm focus:ring-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Kuota Pemakaian</label>
                    <input wire:model="kuota" type="number" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Berlaku Sampai</label>
                    <input wire:model="berlaku_sampai" type="datetime-local" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500">
                </div>
            </div>

            <div class="fixed bottom-0 right-0 w-full md:w-[480px] bg-white border-t border-slate-200 p-6 z-50">
                <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
                    Simpan Kampanye
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>