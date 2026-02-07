<div class="space-y-8">
    
    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Incidents 24h -->
        <div class="bg-white p-6 rounded-2xl border-l-4 border-red-500 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Insiden (24 Jam)</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-2">{{ $ringkasan['total_insiden_24j'] }}</h3>
                </div>
                <div class="p-3 bg-red-50 rounded-lg text-red-500">
                    <i class="fa-solid fa-bell text-xl animate-pulse"></i>
                </div>
            </div>
            <p class="text-[10px] text-slate-400 mt-2 font-medium">Ancaman terdeteksi oleh sistem</p>
        </div>

        <!-- Blocked IPs -->
        <div class="bg-white p-6 rounded-2xl border-l-4 border-slate-700 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">IP Terblokir</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-2">{{ $ringkasan['total_blokir'] }}</h3>
                </div>
                <div class="p-3 bg-slate-100 rounded-lg text-slate-600">
                    <i class="fa-solid fa-ban text-xl"></i>
                </div>
            </div>
             <p class="text-[10px] text-slate-400 mt-2 font-medium">Aktif dalam Firewall Rules</p>
        </div>

        <!-- Critical Threats -->
        <div class="bg-white p-6 rounded-2xl border-l-4 border-orange-500 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Ancaman Kritis</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-2">{{ $ringkasan['insiden_kritis'] }}</h3>
                </div>
                <div class="p-3 bg-orange-50 rounded-lg text-orange-500">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                </div>
            </div>
             <p class="text-[10px] text-slate-400 mt-2 font-medium">Membutuhkan penanganan segera</p>
        </div>

        <!-- Top Attack Type -->
        <div class="bg-white p-6 rounded-2xl border-l-4 border-indigo-500 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Top Serangan</p>
                    <h3 class="text-lg font-black text-slate-800 mt-2 uppercase truncate">{{ $ringkasan['serangan_terbanyak'] }}</h3>
                </div>
                <div class="p-3 bg-indigo-50 rounded-lg text-indigo-500">
                    <i class="fa-solid fa-bug text-xl"></i>
                </div>
            </div>
             <p class="text-[10px] text-slate-400 mt-2 font-medium">Pola serangan paling umum</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Live Threat Log -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-list-ul text-slate-400"></i> Log Insiden Terkini
                    </h3>
                </div>
                <a href="{{ route('pengelola.keamanan.pemindai') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider">
                        <tr>
                            <th class="px-6 py-3">Waktu</th>
                            <th class="px-6 py-3">Jenis Serangan</th>
                            <th class="px-6 py-3">IP Sumber</th>
                            <th class="px-6 py-3">Target</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($insidenTerbaru as $insiden)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $insiden->dibuat_pada ? $insiden->dibuat_pada->diffForHumans() : '-' }}</td>
                            <td class="px-6 py-4 font-bold text-slate-700">{{ $insiden->jenis_insiden }}</td>
                            <td class="px-6 py-4 font-mono text-xs text-slate-500 bg-slate-50 rounded">{{ $insiden->ip_address }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500 truncate max-w-[150px]">{{ $insiden->url_target ?? 'System' }}</td>
                            <td class="px-6 py-4">
                                @if($insiden->status == 'selesai')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                        <i class="fa-solid fa-check"></i> Ditangani
                                    </span>
                                @elseif($insiden->status == 'investigasi')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">
                                        <i class="fa-solid fa-magnifying-glass"></i> Investigasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700 animate-pulse">
                                        <i class="fa-solid fa-bell"></i> Terbuka
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-shield-cat text-4xl mb-3 opacity-20"></i>
                                <p class="text-sm">Tidak ada insiden keamanan baru.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Firewall Rules & System Health -->
        <div class="space-y-6">
            <!-- Active Rules -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-fire text-red-500"></i> Aturan Firewall Terbaru
                    </h3>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($aturanAktif as $aturan)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="font-mono text-xs font-bold text-slate-700">{{ $aturan->alamat_ip }}</p>
                            <p class="text-[10px] text-slate-400">{{ $aturan->alasan ?? 'Suspicious activity' }}</p>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-1 rounded uppercase {{ $aturan->tipe_aturan == 'blokir' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                            {{ $aturan->tipe_aturan }}
                        </span>
                    </div>
                    @empty
                    <div class="px-6 py-4 text-center text-slate-400 text-xs">Belum ada aturan khusus.</div>
                    @endforelse
                </div>
                 <div class="p-4 bg-slate-50 border-t border-slate-100">
                    <a href="{{ route('pengelola.keamanan.firewall') }}" class="block w-full text-center py-2 rounded-lg border border-slate-300 bg-white text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors">Konfigurasi Firewall</a>
                </div>
            </div>

            <!-- Server Health (Static Visual) -->
            <div class="bg-slate-900 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                 <div class="absolute top-0 right-0 p-3 opacity-10">
                    <i class="fa-solid fa-server text-6xl"></i>
                 </div>
                <h3 class="font-bold text-slate-200 mb-4 text-sm uppercase tracking-widest">Kesehatan Server</h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-400">CPU Usage</span>
                            <span class="font-mono font-bold text-emerald-400">12%</span>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-1.5">
                            <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 12%"></div>
                        </div>
                    </div>
                     <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-400">Memory (RAM)</span>
                            <span class="font-mono font-bold text-blue-400">4.2GB / 16GB</span>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-1.5">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: 26%"></div>
                        </div>
                    </div>
                     <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-400">Disk Space</span>
                            <span class="font-mono font-bold text-indigo-400">45% Used</span>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-1.5">
                            <div class="bg-indigo-500 h-1.5 rounded-full" style="width: 45%"></div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse mt-1"></span>
                    <span class="text-xs text-emerald-400 font-bold">Semua layanan berjalan normal</span>
                </div>
            </div>
        </div>
    </div>
</div>