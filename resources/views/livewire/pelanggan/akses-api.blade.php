<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Integrasi <span class="text-indigo-600">API</span></h1>
                <p class="text-slate-500 font-medium text-sm mt-2">Hubungkan sistem ERP Anda dengan Teqara Hub.</p>
            </div>
            <button wire:click="$set('tambahMode', true)" class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg hover:shadow-indigo-500/30">
                + Buat Token Baru
            </button>
        </div>

        @if($token_baru)
        <div class="bg-emerald-50 border border-emerald-100 rounded-[2rem] p-8 mb-10 animate-fade-in-up">
            <h3 class="text-lg font-black text-emerald-800 uppercase tracking-tight mb-2">Token Berhasil Dibuat!</h3>
            <p class="text-sm text-emerald-600 mb-4">Salin token ini sekarang. Anda tidak akan bisa melihatnya lagi.</p>
            <div class="flex items-center gap-4">
                <code class="bg-white px-6 py-4 rounded-xl border border-emerald-200 text-emerald-900 font-mono font-bold text-sm w-full break-all">
                    {{ $token_baru }}
                </code>
                <button onclick="navigator.clipboard.writeText('{{ $token_baru }}')" class="px-6 py-4 bg-emerald-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-colors shadow-lg">
                    Salin
                </button>
            </div>
            <button wire:click="$set('token_baru', null)" class="mt-4 text-xs font-bold text-emerald-500 hover:text-emerald-700 uppercase tracking-widest">Tutup</button>
        </div>
        @endif

        @if($tambahMode && !$token_baru)
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl mb-10 animate-fade-in-up">
            <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6">Konfigurasi Token</h3>
            <form wire:submit.prevent="buatToken" class="flex gap-4 items-start">
                <div class="flex-1">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama Aplikasi / Penggunaan</label>
                    <input wire:model="nama_token" type="text" placeholder="Contoh: Integrasi SAP, Mobile App Gudang" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                    @error('nama_token') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="mt-8 px-8 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 transition-all">
                    Generate
                </button>
                <button type="button" wire:click="$set('tambahMode', false)" class="mt-8 px-6 py-4 bg-white border border-slate-200 text-slate-500 rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-slate-50 transition-all">
                    Batal
                </button>
            </form>
        </div>
        @endif

        <div class="space-y-4">
            @forelse($this->kunciApi as $key)
            <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-lg transition-all duration-300">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-2xl border border-slate-100">
                        🔑
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 text-sm uppercase tracking-wide">{{ $key->nama_token }}</h4>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Dibuat: {{ $key->dibuat_pada->format('d M Y') }}</span>
                            <span class="text-slate-300">•</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Terakhir Dipakai: {{ $key->terakhir_dipakai ? $key->terakhir_dipakai->diffForHumans() : 'Belum Pernah' }}</span>
                        </div>
                    </div>
                </div>
                <button wire:click="hapus({{ $key->id }})" class="px-6 py-3 bg-white border border-rose-100 text-rose-500 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-50 transition-colors">
                    Cabut Akses
                </button>
            </div>
            @empty
            <div class="text-center py-24 bg-white rounded-[3rem] border border-dashed border-slate-200">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl opacity-50">🔌</div>
                <h3 class="text-slate-900 font-black mb-1">Belum Ada Integrasi</h3>
                <p class="text-slate-400 text-sm mb-6">Buat kunci API pertama Anda untuk menghubungkan sistem eksternal.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>
