<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Buku <span class="text-indigo-600">Alamat</span></h1>
                <p class="text-slate-500 font-medium text-sm mt-2">Kelola lokasi pengiriman untuk proses checkout yang lebih cepat.</p>
            </div>
            @if(!$tambahMode && !$editMode)
            <button wire:click="tambahBaru" class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg hover:shadow-indigo-500/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Alamat Baru
            </button>
            @endif
        </div>

        @if($tambahMode || $editMode)
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl mb-10 animate-fade-in-up">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">{{ $editMode ? 'Ubah Alamat' : 'Tambah Alamat Baru' }}</h3>
                <button wire:click="batal" class="text-slate-400 hover:text-rose-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit.prevent="simpan" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Label Alamat</label>
                    <input wire:model="label_alamat" type="text" placeholder="Contoh: Rumah, Kantor, Apartemen" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                    @error('label_alamat') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama Penerima</label>
                    <input wire:model="penerima" type="text" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                    @error('penerima') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nomor Telepon</label>
                    <input wire:model="telepon" type="tel" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                    @error('telepon') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Alamat Lengkap</label>
                    <textarea wire:model="alamat_lengkap" rows="3" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-indigo-500" placeholder="Nama Jalan, No. Rumah, RT/RW..."></textarea>
                    @error('alamat_lengkap') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Provinsi</label>
                    <select wire:model.live="provinsi_id" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                        <option value="">Pilih Provinsi...</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                        @endforeach
                    </select>
                    @error('provinsi_id') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Kota / Kabupaten</label>
                    <select wire:model.live="kota_id" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                        <option value="">Pilih Kota...</option>
                        @foreach($cities as $city)
                            <option value="{{ $city['city_id'] }}">{{ $city['type'] }} {{ $city['city_name'] }}</option>
                        @endforeach
                    </select>
                    @error('kota_id') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Kode Pos</label>
                    <input wire:model="kode_pos" type="number" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500" readonly>
                    @error('kode_pos') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2 pt-4 flex gap-4">
                    <button type="submit" class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 transition-all">Simpan Alamat</button>
                    <button type="button" wire:click="batal" class="px-8 py-4 bg-white border border-slate-200 text-slate-500 rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-slate-50 transition-all">Batal</button>
                </div>
            </form>
        </div>
        @endif

        @if($this->daftarAlamat->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($this->daftarAlamat as $alamat)
            <div class="group relative bg-white rounded-[2.5rem] p-8 border transition-all duration-300 {{ $alamat->is_utama ? 'border-indigo-500 ring-4 ring-indigo-500/5 shadow-2xl shadow-indigo-500/10 z-10' : 'border-slate-100 hover:border-indigo-200 hover:shadow-xl' }}">
                
                @if($alamat->is_utama)
                <div class="absolute top-6 right-6 px-3 py-1 bg-indigo-100 text-indigo-600 text-[10px] font-black uppercase tracking-widest rounded-lg">
                    Utama
                </div>
                @else
                <div class="absolute top-6 right-6 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button wire:click="setUtama({{ $alamat->id }})" class="px-3 py-1 bg-white border border-slate-200 text-slate-500 text-[10px] font-bold uppercase tracking-widest rounded-lg hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-colors">
                        Jadikan Utama
                    </button>
                </div>
                @endif

                <div class="mb-6">
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-wide mb-1">{{ $alamat->label_alamat }}</h4>
                    <p class="text-xs font-bold text-slate-500">{{ $alamat->penerima }} • {{ $alamat->telepon }}</p>
                </div>

                <p class="text-sm text-slate-600 font-medium leading-relaxed mb-8 border-l-4 border-slate-100 pl-4">
                    {{ $alamat->alamat_lengkap }}<br>
                    <span class="text-slate-400">{{ $alamat->kota }}, {{ $alamat->kode_pos }}</span>
                </p>

                <div class="flex gap-3 pt-6 border-t border-slate-50">
                    <button wire:click="edit({{ $alamat->id }})" class="flex-1 py-2.5 bg-slate-50 text-slate-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-100 transition-colors">
                        Ubah
                    </button>
                    @if(!$alamat->is_utama)
                    <button wire:click="hapus({{ $alamat->id }})" class="px-4 py-2.5 bg-white border border-rose-100 text-rose-500 rounded-xl text-xs font-black hover:bg-rose-50 transition-colors">
                        Hapus
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-24 bg-white rounded-[3rem] border border-dashed border-slate-200">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl opacity-50">📍</div>
            <h3 class="text-slate-900 font-black mb-1">Belum Ada Alamat</h3>
            <p class="text-slate-400 text-sm mb-6">Tambahkan alamat pengiriman untuk memudahkan belanja Anda.</p>
            <button wire:click="tambahBaru" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all">Tambah Alamat</button>
        </div>
        @endif

    </div>
</div>