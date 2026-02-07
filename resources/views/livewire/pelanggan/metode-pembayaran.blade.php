<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Metode <span class="text-indigo-600">Pembayaran</span></h1>
                <p class="text-slate-500 font-medium text-sm mt-2">Kelola kartu dan rekening untuk checkout instan.</p>
            </div>
            @if(!$tambahMode)
            <button wire:click="tambahBaru" class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg hover:shadow-indigo-500/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Kartu
            </button>
            @endif
        </div>

        @if($tambahMode)
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl mb-10 animate-fade-in-up">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Tambah Kartu Baru</h3>
                <button wire:click="$set('tambahMode', false)" class="text-slate-400 hover:text-rose-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit.prevent="simpan" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nomor Kartu</label>
                    <div class="relative">
                        <input wire:model="nomor_kartu" type="text" placeholder="0000 0000 0000 0000" class="w-full pl-12 bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 font-mono">
                        <div class="absolute left-4 top-4 text-slate-400">💳</div>
                    </div>
                    @error('nomor_kartu') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama Pemilik</label>
                    <input wire:model="nama_pemilik" type="text" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 uppercase">
                    @error('nama_pemilik') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Expiry</label>
                        <input wire:model="expiry" type="text" placeholder="MM/YY" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 text-center">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">CVV</label>
                        <input wire:model="cvv" type="password" placeholder="123" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 text-center">
                    </div>
                </div>

                <div class="md:col-span-2 pt-4">
                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 transition-all">Simpan Kartu</button>
                </div>
            </form>
        </div>
        @endif

        <div class="grid gap-6">
            @foreach($this->metodeTersimpan as $kartu)
            <div class="group relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-[2.5rem] p-8 text-white shadow-xl overflow-hidden hover:scale-[1.02] transition-transform duration-300">
                <!-- Card Visuals -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-500/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

                <div class="relative z-10 flex justify-between items-start mb-8">
                    <span class="font-black italic text-2xl tracking-widest">{{ $kartu['jenis'] }}</span>
                    <button wire:click="hapus({{ $kartu['id'] }})" class="p-2 bg-white/10 hover:bg-rose-500/80 rounded-xl transition-colors backdrop-blur-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>

                <div class="relative z-10 mb-8">
                    <div class="flex items-center gap-4 text-2xl font-mono tracking-widest opacity-90">
                        <span>••••</span>
                        <span>••••</span>
                        <span>••••</span>
                        <span>{{ $kartu['last4'] }}</span>
                    </div>
                </div>

                <div class="relative z-10 flex justify-between items-end">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Pemilik Kartu</p>
                        <p class="font-bold tracking-wide">{{ $kartu['holder'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Berlaku Hingga</p>
                        <p class="font-bold font-mono">{{ $kartu['exp'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
