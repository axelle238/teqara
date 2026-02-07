<div class="space-y-8 pb-20 animate-in fade-in zoom-in duration-500">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                    <i class="fa-solid fa-database text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Cadangan <span class="text-blue-600">Data</span></h1>
                    <p class="text-slate-500 font-medium text-sm">Pusat pemulihan bencana dan arsip database otomatis.</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <button wire:click="buatCadangan" class="px-6 py-3 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/30 flex items-center gap-2">
                <i class="fa-solid fa-cloud-arrow-up"></i> Buat Cadangan Baru
            </button>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- STATUS CARD -->
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <i class="fa-solid fa-server text-9xl"></i>
                </div>
                <div class="relative z-10">
                    <h3 class="text-xl font-black mb-1">Status Penyimpanan</h3>
                    <p class="text-blue-100 font-mono text-xs mb-8 uppercase">Local Storage & Cloud (S3)</p>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-blue-200 uppercase">Backup Terakhir</p>
                                <p class="text-lg font-bold">{{ $lastBackup ? $lastBackup->diffForHumans() : 'Belum Pernah' }}</p>
                            </div>
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-blue-200 uppercase">Total Ukuran</p>
                                <p class="text-lg font-bold">{{ $backupSize }}</p>
                            </div>
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-hard-drive"></i>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs mb-1 text-blue-200 font-bold uppercase">
                                <span>Kesehatan Arsip</span>
                                <span class="text-white">Sehat</span>
                            </div>
                            <div class="w-full bg-black/20 rounded-full h-1.5">
                                <div class="bg-emerald-400 h-1.5 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm">
                <h4 class="font-bold text-slate-800 flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-gear text-slate-400"></i> Pengaturan Otomatis
                </h4>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-slate-700">Jadwal Harian</p>
                            <p class="text-[10px] text-slate-400">Setiap jam 02:00 pagi</p>
                        </div>
                        <div class="w-10 h-5 bg-emerald-500 rounded-full relative cursor-pointer">
                             <div class="w-3 h-3 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-slate-700">Notifikasi Email</p>
                            <p class="text-[10px] text-slate-400">Lapor jika gagal</p>
                        </div>
                        <div class="w-10 h-5 bg-emerald-500 rounded-full relative cursor-pointer">
                             <div class="w-3 h-3 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- HISTORY LIST -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 relative overflow-hidden">
            <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest mb-6 pb-4 border-b border-slate-100">Riwayat Pencadangan</h3>
            
            <div class="space-y-4">
                <!-- Item 1 -->
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-blue-500 group-hover:border-blue-200 transition-colors">
                        <i class="fa-solid fa-file-zipper text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h4 class="font-bold text-slate-800 text-sm">Full Backup (DB + Files)</h4>
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-600 rounded text-[10px] font-black uppercase">Sukses</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">21 Feb 2026 • 02:00 WIB • 156 MB</p>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="unduh('full')" class="p-2 text-slate-400 hover:text-blue-600 transition-colors" title="Unduh">
                            <i class="fa-solid fa-download"></i>
                        </button>
                        <button class="p-2 text-slate-400 hover:text-red-600 transition-colors" title="Hapus">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-blue-500 group-hover:border-blue-200 transition-colors">
                        <i class="fa-solid fa-database text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h4 class="font-bold text-slate-800 text-sm">Database Snapshot</h4>
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-600 rounded text-[10px] font-black uppercase">Sukses</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">20 Feb 2026 • 02:00 WIB • 12 MB</p>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="unduh('db')" class="p-2 text-slate-400 hover:text-blue-600 transition-colors" title="Unduh">
                            <i class="fa-solid fa-download"></i>
                        </button>
                        <button class="p-2 text-slate-400 hover:text-red-600 transition-colors" title="Hapus">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-blue-500 group-hover:border-blue-200 transition-colors">
                        <i class="fa-solid fa-database text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h4 class="font-bold text-slate-800 text-sm">Database Snapshot</h4>
                            <span class="px-2 py-0.5 bg-red-100 text-red-600 rounded text-[10px] font-black uppercase">Gagal</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">19 Feb 2026 • 02:00 WIB • 0 MB</p>
                    </div>
                     <div class="flex gap-2">
                        <button class="p-2 text-slate-400 hover:text-amber-600 transition-colors" title="Lihat Log">
                            <i class="fa-solid fa-bug"></i>
                        </button>
                    </div>
                </div>
            </div>
            
             <div class="mt-6 text-center">
                <button class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest">Lihat Arsip Lama</button>
            </div>
        </div>
    </div>
</div>