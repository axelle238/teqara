<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="bg-slate-900 rounded-[3rem] p-10 overflow-hidden shadow-2xl border border-slate-800 flex flex-col md:flex-row justify-between items-center gap-8 relative">
        <div class="relative z-10 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-900/50 border border-red-500/30 mb-2">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                <span class="text-[10px] font-black text-red-400 uppercase tracking-widest">Live Threat Map</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase leading-none">INTELIJEN <span class="text-red-500">ANCAMAN</span></h1>
            <p class="text-slate-400 font-medium text-lg">Pemantauan vektor serangan global dan manajemen blokir geo-lokasi.</p>
        </div>
        <div class="relative z-10 w-24 h-24 bg-red-500/10 rounded-full flex items-center justify-center text-red-500 text-5xl shadow-inner border border-red-500/20">
            <i class="fa-solid fa-earth-americas"></i>
        </div>
        
        <!-- Grid Deco -->
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay"></div>
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-red-600/20 rounded-full blur-[100px]"></div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-8 rounded-[30px] border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-600 text-xl">
                    <i class="fa-solid fa-shield-virus"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-900">2,450</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase">Serangan Ditangkis (24 Jam)</p>
                </div>
            </div>
            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-slate-800 h-full w-[70%]"></div>
            </div>
        </div>
        
        <div class="bg-red-50 p-8 rounded-[30px] border border-red-100 shadow-sm">
             <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center text-red-600 text-xl">
                    <i class="fa-solid fa-ban"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-red-700">{{ count($blokirNegara) }}</h3>
                    <p class="text-xs font-bold text-red-400 uppercase">Negara Diblokir</p>
                </div>
            </div>
            <div class="w-full bg-red-200 h-1.5 rounded-full overflow-hidden">
                <div class="bg-red-500 h-full w-[30%]"></div>
            </div>
        </div>

        <div class="bg-indigo-50 p-8 rounded-[30px] border border-indigo-100 shadow-sm">
             <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl">
                    <i class="fa-solid fa-radar"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-indigo-700">Aktif</h3>
                    <p class="text-xs font-bold text-indigo-400 uppercase">Status IDS / IPS</p>
                </div>
            </div>
             <div class="w-full bg-indigo-200 h-1.5 rounded-full overflow-hidden">
                <div class="bg-indigo-500 h-full w-full animate-pulse"></div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Top Attack Sources -->
        <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-black text-slate-800 text-lg uppercase">Sumber Serangan Teratas</h3>
                <span class="px-3 py-1 bg-slate-100 rounded-lg text-[10px] font-bold uppercase text-slate-500">Real-time</span>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($ancamanDunia as $ancaman)
                    <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100 group">
                        <div class="flex items-center gap-4">
                            <span class="text-2xl">{{ $ancaman['negara'] == 'CN' ? '🇨🇳' : ($ancaman['negara'] == 'RU' ? '🇷🇺' : ($ancaman['negara'] == 'US' ? '🇺🇸' : ($ancaman['negara'] == 'BR' ? '🇧🇷' : '🇮🇳'))) }}</span>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">{{ $ancaman['nama'] }}</h4>
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $ancaman['level'] == 'tinggi' ? 'bg-red-500' : ($ancaman['level'] == 'sedang' ? 'bg-amber-500' : 'bg-blue-500') }}"></span>
                                    <span class="text-[10px] font-bold uppercase text-slate-400">Ancaman {{ $ancaman['level'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="font-mono font-bold text-slate-700">{{ number_format($ancaman['serangan']) }} Hit</span>
                            @if(array_key_exists($ancaman['negara'], $blokirNegara))
                                <button wire:click="lepasBlokir('{{ $ancaman['negara'] }}')" class="px-3 py-1.5 bg-slate-200 text-slate-600 text-[10px] font-black uppercase rounded-lg hover:bg-slate-300">Buka</button>
                            @else
                                <button wire:click="blokirNegara('{{ $ancaman['negara'] }}', '{{ $ancaman['nama'] }}')" class="px-3 py-1.5 bg-red-100 text-red-600 text-[10px] font-black uppercase rounded-lg hover:bg-red-200">Blokir</button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Geo-Blocking Rules -->
        <div class="bg-slate-900 rounded-[40px] shadow-xl border border-slate-800 overflow-hidden text-slate-300">
            <div class="p-8 border-b border-slate-800 flex justify-between items-center">
                <h3 class="font-black text-white text-lg uppercase">Aturan Geo-Blocking Aktif</h3>
                <i class="fa-solid fa-globe text-indigo-500"></i>
            </div>
            <div class="p-8">
                @if(count($blokirNegara) > 0)
                    <div class="flex flex-wrap gap-3">
                        @foreach($blokirNegara as $kode => $nama)
                        <div class="flex items-center gap-2 px-4 py-2 bg-red-500/10 border border-red-500/20 rounded-xl">
                            <span class="text-lg">{{ $kode == 'KP' ? '🇰🇵' : ($kode == 'IR' ? '🇮🇷' : ($kode == 'CN' ? '🇨🇳' : '🏳️')) }}</span>
                            <span class="text-xs font-bold text-red-400 uppercase">{{ $nama }}</span>
                            <button wire:click="lepasBlokir('{{ $kode }}')" class="w-5 h-5 rounded-full bg-red-500/20 flex items-center justify-center text-red-400 hover:bg-red-500 hover:text-white transition-colors ml-1">
                                <i class="fa-solid fa-xmark text-[10px]"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-8 p-6 bg-slate-800/50 rounded-2xl border border-slate-700/50">
                        <p class="text-xs text-slate-400 leading-relaxed">
                            <i class="fa-solid fa-circle-info text-indigo-400 mr-2"></i>
                            Lalu lintas dari negara-negara di atas akan ditolak secara otomatis oleh Web Application Firewall (WAF) sebelum mencapai server aplikasi.
                        </p>
                    </div>
                @else
                    <div class="text-center py-10">
                        <i class="fa-solid fa-earth-americas text-4xl text-slate-700 mb-4"></i>
                        <p class="text-sm font-bold text-slate-500">Tidak ada pemblokiran wilayah aktif.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
