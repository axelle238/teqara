<div class="bg-slate-50 min-h-screen py-12">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Buku Alamat</h1>
            <button wire:click="tambahAlamat" class="px-6 py-3 bg-slate-900 text-white rounded-xl font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Alamat
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($daftarAlamat as $alamat)
            <div class="bg-white p-6 rounded-[24px] border-2 transition-all group {{ $alamat->is_utama ? 'border-cyan-500 shadow-xl shadow-cyan-500/10' : 'border-slate-100 hover:border-slate-300' }}">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-black uppercase tracking-widest px-2 py-1 rounded-lg {{ $alamat->is_utama ? 'bg-cyan-100 text-cyan-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $alamat->label_alamat }}
                        </span>
                        @if($alamat->is_utama)
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">UTAMA</span>
                        @endif
                    </div>
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button wire:click="edit({{ $alamat->id }})" class="text-slate-400 hover:text-cyan-600 font-bold text-xs">Edit</button>
                        <button wire:click="hapus({{ $alamat->id }})" wire:confirm="Hapus alamat ini?" class="text-slate-400 hover:text-red-500 font-bold text-xs">Hapus</button>
                    </div>
                </div>
                
                <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $alamat->penerima }}</h3>
                <p class="text-slate-500 text-sm mb-4">{{ $alamat->telepon }}</p>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">{{ $alamat->alamat_lengkap }}, {{ $alamat->kota }}, {{ $alamat->kode_pos }}</p>

                @if(!$alamat->is_utama)
                    <button wire:click="setUtama({{ $alamat->id }})" class="w-full py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                        Jadikan Utama
                    </button>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <!-- Slide Over Form (No Modal) -->
    <x-ui.slide-over id="form-alamat" title="{{ $modeEdit ? 'Ubah Alamat' : 'Alamat Baru' }}">
        <form wire:submit.prevent="simpan" class="space-y-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Label Alamat</label>
                <input wire:model="label_alamat" type="text" placeholder="Rumah / Kantor" class="w-full rounded-xl border-slate-200 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                @error('label_alamat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Penerima</label>
                    <input wire:model="penerima" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Telepon</label>
                    <input wire:model="telepon" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Alamat Lengkap</label>
                <textarea wire:model="alamat_lengkap" rows="3" class="w-full rounded-xl border-slate-200 text-sm focus:ring-cyan-500 focus:border-cyan-500"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kota / Kab</label>
                    <input wire:model="kota" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kode Pos</label>
                    <input wire:model="kode_pos" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                </div>
            </div>

            <button type="submit" class="w-full bg-cyan-600 text-white py-3 rounded-xl font-bold shadow-lg shadow-cyan-600/30 hover:bg-cyan-700 transition">
                Simpan Alamat
            </button>
        </form>
    </x-ui.slide-over>
</div>
