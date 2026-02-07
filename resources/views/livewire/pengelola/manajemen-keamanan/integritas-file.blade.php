<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20" x-data="{ 
    scanning: @entangle('scanStatus'), 
    progress: @entangle('progress') 
}" x-init="
    $watch('scanning', value => {
        if (value === 'scanning') {
            let interval = setInterval(() => {
                if ($wire.progress >= 100) {
                    clearInterval(interval);
                } else {
                    $wire.updateProgress();
                }
            }, 500);
        }
    })
">
    
    <!-- Header -->
    <div class="bg-white rounded-[3rem] p-10 overflow-hidden shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-8 relative">
        <div class="relative z-10 space-y-2">
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">INTEGRITAS <span class="text-indigo-600">FILE</span></h1>
            <p class="text-slate-500 font-medium text-lg">Pemindaian perubahan tidak sah pada file inti sistem (FIM).</p>
        </div>
        <div class="relative z-10">
            <button wire:click="mulaiScan" 
                    :disabled="scanning === 'scanning'"
                    class="group relative px-8 py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/20 disabled:opacity-50 disabled:cursor-not-allowed">
                <span x-show="scanning !== 'scanning'" class="flex items-center gap-3"><i class="fa-solid fa-fingerprint"></i> Mulai Scan Manual</span>
                <span x-show="scanning === 'scanning'" class="flex items-center gap-3"><i class="fa-solid fa-circle-notch fa-spin"></i> Memindai...</span>
            </button>
        </div>
    </div>

    <!-- Scanner Visualization -->
    <div class="bg-slate-900 rounded-[40px] p-10 shadow-2xl relative overflow-hidden border border-slate-800" x-show="scanning === 'scanning'">
        <div class="flex flex-col items-center justify-center text-center relative z-10 py-10">
            <div class="w-32 h-32 rounded-full border-4 border-indigo-500/30 flex items-center justify-center relative mb-6">
                <div class="absolute inset-0 rounded-full border-4 border-t-indigo-500 border-r-transparent border-b-transparent border-l-transparent animate-spin"></div>
                <span class="text-2xl font-black text-white" x-text="progress + '%'"></span>
            </div>
            <h3 class="text-xl font-black text-white uppercase tracking-widest animate-pulse">Memverifikasi Checksum SHA-256...</h3>
            <p class="text-indigo-400 font-mono text-xs mt-2">Membandingkan hash file lokal dengan repositori master.</p>
        </div>
        <!-- Matrix Rain Effect (Simulated with CSS/BG) -->
        <div class="absolute inset-0 opacity-10 bg-[url('https://media.giphy.com/media/U3qYN8S0j3bpK/giphy.gif')] bg-cover mix-blend-screen"></div>
    </div>

    <!-- Results -->
    <div class="grid grid-cols-1 gap-6" x-show="scanning === 'selesai'">
        <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-black text-slate-800 text-lg uppercase">Laporan Integritas Terakhir</h3>
                <span class="px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl text-xs font-black uppercase tracking-widest">
                    <i class="fa-solid fa-check-circle mr-1"></i> Scan Selesai
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Lokasi File</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Checksum Hash</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Waktu Ubah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($fileBerubah as $file)
                        <tr class="group hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $file['status'] == 'aman' ? 'bg-slate-100 text-slate-500' : 'bg-amber-100 text-amber-600' }}">
                                        <i class="fa-solid {{ $file['status'] == 'aman' ? 'fa-file-code' : 'fa-file-circle-exclamation' }}"></i>
                                    </div>
                                    <span class="font-mono text-xs font-bold text-slate-700">{{ $file['path'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="font-mono text-[10px] text-slate-400 bg-slate-100 px-2 py-1 rounded border border-slate-200">{{ $file['hash'] }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $file['status'] == 'aman' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                                    {{ $file['status'] }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="text-xs font-bold text-slate-500">{{ \Carbon\Carbon::parse($file['waktu'])->diffForHumans() }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="bg-indigo-50 rounded-[30px] p-8 border border-indigo-100 flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 shrink-0">
            <i class="fa-solid fa-circle-info"></i>
        </div>
        <div>
            <h4 class="font-bold text-indigo-900 text-sm uppercase mb-1">Penting</h4>
            <p class="text-xs text-indigo-700 leading-relaxed">
                Pemindai integritas file menggunakan algoritma hashing SHA-256 untuk mendeteksi modifikasi yang tidak sah. Jika ditemukan perubahan pada file `.env` atau file konfigurasi inti, segera lakukan audit manual dan rotasi kredensial.
            </p>
        </div>
    </div>

</div>
