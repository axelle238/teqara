<div class="space-y-8 pb-20 animate-in fade-in zoom-in duration-500">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-red-100 text-red-600 rounded-xl">
                    <i class="fa-solid fa-microscope text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Pemindai <span class="text-red-600">Kerentanan</span></h1>
                    <p class="text-slate-500 font-medium text-sm">Analisis otomatis keamanan server, konfigurasi, dan integritas file.</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <button wire:click="startScan" wire:loading.attr="disabled" class="px-6 py-3 bg-red-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-red-700 transition-all shadow-lg shadow-red-500/30 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed group">
                <i class="fa-solid fa-radar group-hover:animate-spin-slow" wire:loading.class="animate-spin"></i>
                <span wire:loading.remove>Mulai Pemindaian</span>
                <span wire:loading>Memindai...</span>
            </button>
        </div>
    </div>

    <!-- MAIN DASHBOARD -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- SCORE CARD -->
        <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white flex flex-col items-center justify-center text-center relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 right-0 p-10 opacity-10">
                <i class="fa-solid fa-shield-cat text-[12rem]"></i>
            </div>
            
            <div class="relative z-10">
                <h3 class="font-bold text-slate-400 text-sm uppercase tracking-widest mb-6">Skor Keamanan</h3>
                
                <div class="relative w-48 h-48 flex items-center justify-center mb-6">
                    <svg class="w-full h-full transform -rotate-90">
                        <circle cx="96" cy="96" r="88" stroke="currentColor" stroke-width="12" fill="transparent" class="text-slate-800" />
                        <circle cx="96" cy="96" r="88" stroke="currentColor" stroke-width="12" fill="transparent" 
                                class="{{ $score >= 80 ? 'text-emerald-500' : ($score >= 50 ? 'text-amber-500' : 'text-red-500') }} transition-all duration-1000 ease-out" 
                                stroke-dasharray="552" 
                                stroke-dashoffset="{{ 552 - (552 * $score / 100) }}" />
                    </svg>
                    <div class="absolute flex flex-col items-center">
                        <span class="text-6xl font-black">{{ $score }}</span>
                        <span class="text-sm font-bold text-slate-400">/ 100</span>
                    </div>
                </div>

                @if($score >= 80)
                    <div class="px-4 py-2 bg-emerald-500/20 border border-emerald-500/30 rounded-full text-emerald-400 font-black text-xs uppercase tracking-widest">
                        <i class="fa-solid fa-check-circle mr-1"></i> Sistem Aman
                    </div>
                @elseif($score >= 50)
                    <div class="px-4 py-2 bg-amber-500/20 border border-amber-500/30 rounded-full text-amber-400 font-black text-xs uppercase tracking-widest">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> Perlu Perhatian
                    </div>
                @else
                    <div class="px-4 py-2 bg-red-500/20 border border-red-500/30 rounded-full text-red-400 font-black text-xs uppercase tracking-widest animate-pulse">
                        <i class="fa-solid fa-skull mr-1"></i> Sangat Berbahaya
                    </div>
                @endif
            </div>
        </div>

        <!-- SCAN RESULTS -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 md:p-10 relative overflow-hidden min-h-[400px]">
            
            @if($scanning)
                <div class="absolute inset-0 bg-white/90 backdrop-blur-sm z-20 flex flex-col items-center justify-center">
                    <div class="w-24 h-24 border-4 border-slate-200 border-t-red-500 rounded-full animate-spin mb-4"></div>
                    <h3 class="text-xl font-black text-slate-800">Sedang Menganalisis...</h3>
                    <p class="text-slate-500 font-medium">Memeriksa konfigurasi server & database</p>
                    <div class="w-64 bg-slate-100 rounded-full h-2 mt-6 overflow-hidden">
                        <div class="bg-red-500 h-2 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            @endif

            @if(empty($scanResults) && !$scanning)
                <div class="h-full flex flex-col items-center justify-center text-center opacity-50">
                    <i class="fa-solid fa-magnifying-glass-chart text-6xl text-slate-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-slate-800">Belum Ada Hasil</h3>
                    <p class="text-sm text-slate-500">Tekan tombol "Mulai Pemindaian" untuk analisis.</p>
                </div>
            @else
                <div class="space-y-6 animate-in slide-in-from-bottom-4 duration-500">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest">Laporan Detail</h3>
                        <span class="text-xs text-slate-400 font-bold">{{ now()->format('d M Y, H:i') }}</span>
                    </div>

                    <div class="space-y-4">
                        @foreach($scanResults as $result)
                        <div class="flex items-start gap-4 p-4 rounded-2xl border {{ $result['passed'] ? 'bg-emerald-50/50 border-emerald-100' : 'bg-red-50/50 border-red-100' }}">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 {{ $result['passed'] ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600' }}">
                                <i class="fa-solid {{ $result['passed'] ? 'fa-check' : 'fa-xmark' }}"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-sm text-slate-800">{{ $result['test'] }}</h4>
                                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded {{ $result['severity'] === 'critical' ? 'bg-slate-800 text-white' : ($result['severity'] === 'high' ? 'bg-red-100 text-red-700' : 'bg-slate-200 text-slate-600') }}">
                                        {{ $result['severity'] }}
                                    </span>
                                </div>
                                <p class="text-xs font-medium mt-1 {{ $result['passed'] ? 'text-emerald-700' : 'text-red-700' }}">{{ $result['message'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>