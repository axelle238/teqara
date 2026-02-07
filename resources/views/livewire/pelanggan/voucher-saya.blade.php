<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-16 animate-fade-in-down">
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase mb-2">Dompet <span class="text-indigo-600">Voucher</span></h1>
            <p class="text-slate-500 font-bold text-sm uppercase tracking-widest">Klaim & Gunakan Penawaran Spesial Anda</p>
        </div>

        @if($this->voucherTersedia->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($this->voucherTersedia as $v)
            <!-- Ticket Card -->
            <div class="group relative flex bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 h-48 animate-fade-in-up">
                
                <!-- Left: Visual & Value -->
                <div class="w-1/3 bg-gradient-to-br from-indigo-600 to-purple-700 relative flex flex-col items-center justify-center p-6 text-white text-center overflow-hidden">
                    <!-- Pattern -->
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
                    <div class="absolute -top-10 -left-10 w-32 h-32 bg-white/20 rounded-full blur-2xl"></div>
                    
                    <div class="relative z-10">
                        <span class="block text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-1">Hemat</span>
                        <h2 class="text-3xl font-black tracking-tighter leading-none mb-1">
                            {{ $v->tipe == 'nominal' ? number_format($v->nilai/1000, 0).'K' : $v->nilai.'%' }}
                        </h2>
                        <span class="block text-[10px] font-bold uppercase tracking-widest bg-white/20 px-2 py-0.5 rounded-md">
                            {{ $v->tipe == 'nominal' ? 'Potongan' : 'Diskon' }}
                        </span>
                    </div>

                    <!-- Perforated Line (Visual) -->
                    <div class="absolute right-0 top-0 bottom-0 w-4 translate-x-1/2 flex flex-col justify-between z-20">
                         @for ($i = 0; $i < 12; $i++)
                            <div class="w-3 h-3 rounded-full bg-slate-50 -ml-1.5"></div>
                         @endfor
                    </div>
                </div>

                <!-- Right: Details -->
                <div class="flex-1 p-6 pl-8 flex flex-col justify-between relative bg-white">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-2 py-1 bg-amber-50 text-amber-600 text-[9px] font-black uppercase tracking-widest rounded-lg border border-amber-100">
                                {{ $v->kategori ?? 'Semua Produk' }}
                            </span>
                            @if($v->kuota < 50)
                                <div class="flex items-center gap-1 text-[9px] font-bold text-rose-500">
                                    <span class="relative flex h-2 w-2">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                                    </span>
                                    Sisa {{ $v->kuota }}
                                </div>
                            @endif
                        </div>
                        <h3 class="font-black text-slate-900 leading-tight uppercase mb-1">{{ $v->nama ?? 'Voucher Spesial' }}</h3>
                        <p class="text-xs text-slate-500 font-medium">Min. belanja Rp {{ number_format($v->min_belanja, 0, ',', '.') }}</p>
                    </div>

                    <div class="mt-4">
                        <div class="flex gap-2">
                            <div class="flex-1 bg-slate-50 border border-dashed border-slate-300 rounded-xl flex items-center justify-center px-3 py-2">
                                <span class="font-mono text-sm font-black text-slate-700 tracking-wider">{{ $v->kode }}</span>
                            </div>
                            <button wire:click="salinKode('{{ $v->kode }}')" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20 active:scale-95">
                                Salin
                            </button>
                        </div>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-2 text-center">
                            Exp: {{ $v->berlaku_sampai->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="flex flex-col items-center justify-center py-32 bg-white rounded-[3rem] border border-dashed border-slate-200 animate-fade-in-up">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6 text-4xl shadow-inner animate-bounce">🎟️</div>
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Dompet Kosong</h3>
            <p class="text-slate-400 text-sm font-medium max-w-sm text-center mb-8">Anda belum memiliki voucher aktif. Tingkatkan level membership atau tukar poin Anda.</p>
            <div class="flex gap-4">
                <a href="{{ route('katalog') }}" class="px-8 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg hover:shadow-indigo-500/30">
                    Mulai Belanja
                </a>
                <a href="{{ route('customer.rewards') }}" class="px-8 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-amber-50 hover:text-amber-600 hover:border-amber-200 transition-all">
                    Tukar Poin
                </a>
            </div>
        </div>
        @endif

        <!-- Terms -->
        <div class="mt-16 text-center max-w-2xl mx-auto">
            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Syarat & Ketentuan Umum</h4>
            <p class="text-[10px] text-slate-400 leading-relaxed">
                Voucher tidak dapat diuangkan. Penggunaan voucher tunduk pada kebijakan privasi dan aturan layanan Teqara. Voucher dengan label "Sekali Pakai" akan hangus setelah transaksi selesai atau dibatalkan.
            </p>
        </div>

    </div>
</div>