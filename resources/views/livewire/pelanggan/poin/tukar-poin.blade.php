<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <div class="inline-block px-6 py-2 bg-amber-50 rounded-full border border-amber-100 text-amber-600 font-black text-xs uppercase tracking-widest mb-4 animate-bounce">
                Reward Center
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight uppercase mb-2">Tukar <span class="text-amber-500">Poin</span></h1>
            <p class="text-slate-500 font-medium">Ubah loyalitas Anda menjadi keuntungan nyata.</p>
        </div>

        <!-- Point Balance -->
        <div class="bg-gradient-to-br from-slate-900 to-indigo-900 rounded-[3rem] p-10 text-white shadow-2xl shadow-indigo-500/30 text-center relative overflow-hidden mb-16">
            <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-10"></div>
            <div class="relative z-10">
                <p class="text-indigo-300 text-xs font-black uppercase tracking-[0.3em] mb-4">Saldo Poin Anda</p>
                <div class="text-7xl font-black tracking-tighter text-amber-400 drop-shadow-lg mb-2">
                    {{ number_format($this->poinSaya) }}
                </div>
                <div class="flex justify-center gap-4 mt-8">
                    <a href="{{ route('pelanggan.poin') }}" class="px-6 py-2 bg-white/10 rounded-xl text-xs font-bold hover:bg-white/20 transition-colors backdrop-blur-md">Riwayat Poin</a>
                    <a href="{{ route('pelanggan.absen') }}" class="px-6 py-2 bg-amber-500 text-slate-900 rounded-xl text-xs font-black hover:bg-amber-400 transition-colors shadow-lg shadow-amber-500/30">Cari Poin +</a>
                </div>
            </div>
        </div>

        <!-- Catalog Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($this->katalogHadiah as $hadiah)
            <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-300 group relative overflow-hidden">
                <!-- Icon -->
                <div class="aspect-square bg-slate-50 rounded-[2rem] mb-6 flex items-center justify-center text-5xl group-hover:scale-110 transition-transform duration-500 relative z-10">
                    @if($hadiah['tipe'] == 'voucher') 🎟️
                    @elseif($hadiah['tipe'] == 'ongkir') 🚚
                    @else 🎁
                    @endif
                </div>

                <div class="relative z-10">
                    <h3 class="text-lg font-black text-slate-900 mb-1 leading-tight">{{ $hadiah['nama'] }}</h3>
                    <p class="text-xs text-slate-500 font-bold mb-4 uppercase tracking-wider">{{ $hadiah['kode'] }}</p>
                    
                    <button wire:click="tukar({{ $hadiah['id'] }})" class="w-full py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg flex items-center justify-center gap-2 {{ $this->poinSaya >= $hadiah['poin'] ? 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-indigo-500/30' : 'bg-slate-100 text-slate-400 cursor-not-allowed' }}" {{ $this->poinSaya < $hadiah['poin'] ? 'disabled' : '' }}>
                        <span>{{ number_format($hadiah['poin']) }} Poin</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
