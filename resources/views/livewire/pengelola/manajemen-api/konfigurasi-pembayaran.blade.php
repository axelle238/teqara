<div class="space-y-8 animate-fade-in pb-20">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-900 to-indigo-900 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden text-white">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 bg-white/10 rounded-[2rem] flex items-center justify-center text-3xl backdrop-blur-sm">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black uppercase tracking-tight">Gerbang <span class="text-indigo-300">Pembayaran</span></h1>
                    <p class="text-white/60 font-bold text-xs uppercase tracking-[0.2em] mt-2">Integrasi Midtrans Core API</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white/10 px-6 py-3 rounded-2xl backdrop-blur-md border border-white/10">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-black uppercase tracking-widest">Sistem Online</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Konfigurasi Kredensial -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-8 flex items-center gap-3">
                <i class="fa-solid fa-key text-indigo-500"></i> Kredensial API
            </h3>

            <div class="space-y-6">
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Environment</p>
                        <p class="text-sm font-bold {{ $midtrans_is_production ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $midtrans_is_production ? 'PRODUCTION (Live)' : 'SANDBOX (Testing)' }}
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="midtrans_is_production" class="sr-only peer">
                        <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Server Key</label>
                    <div class="relative">
                        <input type="password" wire:model="midtrans_server_key" class="w-full bg-slate-50 border-none rounded-xl p-4 text-sm font-mono text-slate-700 focus:ring-2 focus:ring-indigo-500" placeholder="SB-Mid-server-xxxx">
                        <i class="fa-solid fa-lock absolute right-4 top-4 text-slate-300"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Client Key</label>
                    <div class="relative">
                        <input type="text" wire:model="midtrans_client_key" class="w-full bg-slate-50 border-none rounded-xl p-4 text-sm font-mono text-slate-700 focus:ring-2 focus:ring-indigo-500" placeholder="SB-Mid-client-xxxx">
                        <i class="fa-solid fa-globe absolute right-4 top-4 text-slate-300"></i>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end">
                    <button wire:click="simpan" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-3">
                        <i class="fa-solid fa-save"></i> Simpan Konfigurasi
                    </button>
                </div>
            </div>
        </div>

        <!-- Metode Pembayaran Aktif -->
        <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-8 flex items-center gap-3">
                <i class="fa-solid fa-wallet text-indigo-500"></i> Metode Aktif
            </h3>

            <div class="space-y-4">
                @foreach($channels as $key => $aktif)
                <div wire:click="toggleChannel('{{ $key }}')" class="flex items-center justify-between p-4 rounded-xl cursor-pointer transition-all border {{ $aktif ? 'bg-indigo-50 border-indigo-100' : 'bg-slate-50 border-slate-100 grayscale opacity-70' }}">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-lg shadow-sm">
                            @if(str_contains($key, 'gopay')) <i class="fa-solid fa-wallet text-green-500"></i>
                            @elseif(str_contains($key, 'shopee')) <i class="fa-solid fa-bag-shopping text-orange-500"></i>
                            @elseif(str_contains($key, 'va')) <i class="fa-solid fa-building-columns text-blue-500"></i>
                            @else <i class="fa-solid fa-qrcode text-slate-700"></i>
                            @endif
                        </div>
                        <span class="text-xs font-black uppercase tracking-wide text-slate-700">{{ str_replace('_', ' ', $key) }}</span>
                    </div>
                    <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center {{ $aktif ? 'border-indigo-500 bg-indigo-500' : 'border-slate-300' }}">
                        @if($aktif) <i class="fa-solid fa-check text-white text-[10px]"></i> @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>