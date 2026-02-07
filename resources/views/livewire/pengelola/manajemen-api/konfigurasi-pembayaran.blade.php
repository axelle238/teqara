<div class="space-y-8 pb-20 animate-in fade-in zoom-in duration-500 font-sans">
    
    <!-- HEADER SECTION -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-4">
                <div class="p-4 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-2xl shadow-lg shadow-indigo-500/30">
                    <i class="fa-solid fa-credit-card text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase leading-none">Gerbang <span class="text-indigo-600">Pembayaran</span></h1>
                    <p class="text-slate-500 font-bold text-xs mt-1 uppercase tracking-widest">Enterprise Payment Gateway Hub</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
             <a href="https://Dasbor.midtrans.com" target="_blank" class="px-5 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-slate-50 hover:text-indigo-600 transition-all shadow-sm">
                <i class="fa-solid fa-external-link-alt mr-2"></i> Midtrans Dasbor
            </a>
            <button wire:click="testMidtrans" wire:loading.attr="disabled" class="group relative px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30 overflow-hidden">
                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                <span wire:loading.remove wire:target="testMidtrans" class="flex items-center gap-2"><i class="fa-solid fa-bolt"></i> Test Connection</span>
                <span wire:loading wire:target="testMidtrans" class="flex items-center gap-2"><i class="fa-solid fa-circle-notch fa-spin"></i> Testing Handshake...</span>
            </button>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- SIDEBAR STATUS -->
        <div class="space-y-6">
            <!-- Active Status Card -->
            <div class="bg-gradient-to-br from-[#0f172a] to-[#1e293b] rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl border border-slate-800">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <i class="fa-solid fa-shield-halved text-[10rem] text-indigo-500"></i>
                </div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <span class="inline-block px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-lg text-[10px] font-black uppercase tracking-widest border border-emerald-500/30">
                            Active Gateway
                        </span>
                        @if($test_result_midtrans)
                            @if($test_result_midtrans['status'] === 'success')
                                <span class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_10px_#10b981]"></span>
                            @else
                                <span class="w-3 h-3 bg-rose-500 rounded-full animate-pulse shadow-[0_0_10px_#f43f5e]"></span>
                            @endif
                        @endif
                    </div>

                    <h3 class="text-4xl font-black mb-1">Midtrans</h3>
                    <p class="text-slate-400 font-mono text-xs font-bold uppercase mb-8 tracking-widest">{{ $midtrans_mode === 'production' ? 'Production Environment' : 'Sandbox (Development)' }}</p>
                    
                    <div class="space-y-5">
                        <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700">
                            <div class="flex justify-between text-[10px] mb-2 text-slate-400 font-bold uppercase tracking-wider">
                                <span>API Latency</span>
                                <span class="text-emerald-400">24ms</span>
                            </div>
                            <div class="w-full bg-slate-700/50 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-1.5 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Real-time Test Result -->
                    @if($test_result_midtrans)
                    <div class="mt-6 p-4 rounded-xl border {{ $test_result_midtrans['status'] === 'success' ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-300' : 'bg-rose-500/10 border-rose-500/30 text-rose-300' }} animate-in slide-in-from-bottom-2">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid {{ $test_result_midtrans['status'] === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation' }} mt-0.5"></i>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest mb-1">{{ $test_result_midtrans['status'] === 'success' ? 'Handshake Verified' : 'Connection Failed' }}</p>
                                <p class="text-xs font-medium leading-relaxed">{{ $test_result_midtrans['pesan'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Documentation Link -->
            <div class="bg-indigo-50 border border-indigo-100 rounded-[2rem] p-8 relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 text-indigo-100 text-8xl opacity-50">
                    <i class="fa-solid fa-book"></i>
                </div>
                <h4 class="font-bold text-indigo-900 flex items-center gap-2 text-sm uppercase tracking-wider mb-3 relative z-10">
                    <i class="fa-solid fa-book-open"></i> Developer Guide
                </h4>
                <p class="text-xs text-indigo-700 leading-relaxed relative z-10">
                    Pastikan `Server Key` dan `Client Key` sesuai dengan environment yang dipilih (Sandbox/Production). Jangan pernah membagikan Server Key kepada siapapun atau menaruhnya di kode Frontend.
                </p>
            </div>
        </div>

        <!-- CONFIGURATION FORMS -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- MIDTRANS CONFIG -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl p-8 md:p-10 relative overflow-hidden group transition-all duration-300 hover:shadow-2xl hover:border-indigo-100">
                <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Midtrans.png/1200px-Midtrans.png" class="h-16 grayscale opacity-50">
                </div>

                <div class="flex flex-col md:flex-row md:items-center gap-6 mb-10 border-b border-slate-100 pb-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-inner border border-white">
                        <i class="fa-solid fa-wallet text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-800">Konfigurasi Midtrans Snap</h2>
                        <p class="text-slate-500 text-xs font-medium mt-1">Gateway utama untuk Virtual Account, QRIS, dan Kartu Kredit.</p>
                    </div>
                    <div class="md:ml-auto">
                        <label class="relative inline-flex items-center cursor-pointer group">
                            <input type="checkbox" wire:model.live="midtrans_mode" wire:true-value="production" wire:false-value="sandbox" class="sr-only peer">
                            <div class="w-32 h-10 bg-slate-100 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-100 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-['SANDBOX'] peer-checked:after:content-['PRODUCTION'] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-8 after:w-14 after:flex after:items-center after:justify-center after:text-[9px] after:font-black after:uppercase after:transition-all peer-checked:bg-indigo-600 peer-checked:after:w-16 after:text-slate-500 peer-checked:after:text-indigo-600 shadow-inner"></div>
                        </label>
                    </div>
                </div>

                <form wire:submit.prevent="simpanMidtrans" class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-1">Merchant ID</label>
                            <div class="relative group/input">
                                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within/input:text-indigo-500 transition-colors"><i class="fa-solid fa-id-badge"></i></span>
                                <input type="text" wire:model="midtrans_id" class="w-full pl-14 pr-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300 transition-all shadow-inner" placeholder="G-12345678">
                            </div>
                        </div>
                         <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-1">Client Key (Public)</label>
                            <div class="relative group/input">
                                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within/input:text-indigo-500 transition-colors"><i class="fa-solid fa-key"></i></span>
                                <input type="text" wire:model="midtrans_client" class="w-full pl-14 pr-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300 transition-all font-mono text-sm shadow-inner" placeholder="SB-Mid-client-...">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-1">Server Key (Backend Secret)</label>
                        <div class="relative group/input">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within/input:text-rose-500 transition-colors"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" wire:model="midtrans_server" class="w-full pl-14 pr-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-rose-500/10 placeholder:text-slate-300 transition-all font-mono text-sm shadow-inner" placeholder="SB-Mid-server-...">
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 px-3 py-1 bg-amber-100 text-amber-700 text-[9px] font-black rounded-lg uppercase tracking-wider flex items-center gap-1">
                                <i class="fa-solid fa-triangle-exclamation"></i> Rahasia
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 px-1 font-medium flex items-center gap-1"><i class="fa-solid fa-circle-info text-indigo-400"></i> Key ini digunakan untuk verifikasi notifikasi pembayaran dari Midtrans.</p>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-10 py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.15em] hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 active:scale-95 flex items-center gap-3 group">
                            <i class="fa-solid fa-floppy-disk group-hover:scale-110 transition-transform"></i> Simpan Konfigurasi
                        </button>
                    </div>
                </form>
            </div>

            <!-- XENDIT CONFIG (Disabled State Visual) -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 md:p-10 relative overflow-hidden opacity-60 hover:opacity-100 transition-all duration-300 grayscale hover:grayscale-0 cursor-not-allowed">
                <div class="flex items-center gap-6 mb-8">
                    <div class="w-16 h-16 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600 shadow-sm">
                        <i class="fa-solid fa-money-bill-transfer text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-800">Konfigurasi Xendit</h2>
                        <p class="text-slate-500 text-xs font-medium mt-1">Opsional / Backup Gateway.</p>
                    </div>
                    <span class="ml-auto px-4 py-2 bg-slate-100 text-slate-500 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-200">Tidak Aktif</span>
                </div>

                <div class="absolute inset-0 z-10 bg-white/50 backdrop-blur-[1px] flex items-center justify-center">
                    <button class="px-8 py-3 bg-white shadow-xl border border-slate-200 rounded-full text-xs font-black text-slate-600 uppercase tracking-widest hover:text-cyan-600 hover:border-cyan-200 transition-all transform hover:scale-105">
                        <i class="fa-solid fa-lock mr-2"></i> Fitur Premium
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
