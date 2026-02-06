<div class="space-y-12 pb-32">
    <!-- Header SOC -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-slate-900 p-10 rounded-[40px] shadow-2xl relative overflow-hidden">
        <div class="relative z-10 space-y-2">
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase leading-none">SECURITY <span class="text-red-500">OPERATIONS</span></h1>
            <p class="text-slate-400 font-medium text-lg">Pusat komando pertahanan siber dan integritas data enterprise.</p>
        </div>
        <div class="relative z-10 flex items-center gap-4">
            <button 
                wire:click="toggleMaintenance" 
                wire:confirm="PERINGATAN DARURAT: Apakah Anda yakin ingin mengunci/membuka akses sistem untuk publik? Hanya Admin dengan token khusus yang dapat masuk."
                class="px-8 py-4 {{ $mode_pemeliharaan ? 'bg-emerald-600 hover:bg-emerald-500' : 'bg-red-600 hover:bg-red-500' }} text-white rounded-3xl font-black text-xs uppercase tracking-[0.2em] transition-all shadow-xl flex items-center gap-3"
            >
                <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                {{ $mode_pemeliharaan ? 'PULIHKAN AKSES' : 'KUNCI SISTEM (DARURAT)' }}
            </button>
        </div>
        
        <!-- Radar Animation Background -->
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-red-600/20 rounded-full blur-[100px]"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Radar Ancaman & Kebijakan -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Statistik Real-time -->
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Radar Ancaman Live</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-red-50 p-6 rounded-3xl border border-red-100 text-center">
                        <p class="text-3xl font-black text-red-600 mb-1">{{ $statistik['login_gagal'] }}</p>
                        <p class="text-[9px] font-black text-red-400 uppercase tracking-widest">Login Gagal</p>
                    </div>
                    <div class="bg-indigo-50 p-6 rounded-3xl border border-indigo-100 text-center">
                        <p class="text-3xl font-black text-indigo-600 mb-1">{{ $statistik['ip_aktif'] }}</p>
                        <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest">IP Unik Aktif</p>
                    </div>
                </div>
            </div>

            <!-- Kontrol Kebijakan -->
            <div class="bg-slate-50 p-8 rounded-[40px] border border-slate-200">
                <h4 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Protokol Keamanan</h4>
                <div class="space-y-6">
                    <div class="flex items-center justify-between group">
                        <div>
                            <p class="text-sm font-bold text-slate-700">Rotasi Sandi Wajib</p>
                            <p class="text-xs text-slate-400">Interval 90 hari.</p>
                        </div>
                        <button wire:click="$toggle('wajib_ganti_sandi_90_hari'); $wire.simpanKebijakan()" class="w-12 h-6 rounded-full transition-colors {{ $wajib_ganti_sandi_90_hari ? 'bg-emerald-500' : 'bg-slate-300' }} relative">
                            <span class="absolute top-1 left-1 bg-white w-4 h-4 rounded-full transition-transform {{ $wajib_ganti_sandi_90_hari ? 'translate-x-6' : '' }}"></span>
                        </button>
                    </div>
                    <div class="flex items-center justify-between group">
                        <div>
                            <p class="text-sm font-bold text-slate-700">MFA Administrator</p>
                            <p class="text-xs text-slate-400">Verifikasi ganda.</p>
                        </div>
                        <button wire:click="$toggle('aktifkan_2fa_admin'); $wire.simpanKebijakan()" class="w-12 h-6 rounded-full transition-colors {{ $aktifkan_2fa_admin ? 'bg-emerald-500' : 'bg-slate-300' }} relative">
                            <span class="absolute top-1 left-1 bg-white w-4 h-4 rounded-full transition-transform {{ $aktifkan_2fa_admin ? 'translate-x-6' : '' }}"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Log Forensik Digital -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden h-full flex flex-col">
                <div class="px-8 py-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/30">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Jejak Audit Forensik
                    </h3>
                    <div class="flex gap-2">
                        <select wire:model.live="filterAksi" class="text-xs border-slate-200 bg-white rounded-xl font-bold text-slate-600 focus:ring-indigo-500 py-2 pl-3 pr-8">
                            <option value="">Semua Event</option>
                            <option value="login">Autentikasi</option>
                            <option value="system_lock">Sistem Kritis</option>
                            <option value="hapus_data">Penghapusan Data</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex-1 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-white border-b border-slate-50">
                            <tr>
                                <th class="px-8 py-4 text-[9px] font-black text-slate-400 uppercase tracking-wider">Timestamp</th>
                                <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase tracking-wider">Aktor & IP</th>
                                <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase tracking-wider">Aktivitas Sistem</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($logs as $log)
                            <tr class="hover:bg-indigo-50/30 transition-colors group">
                                <td class="px-8 py-4 w-48">
                                    <p class="text-xs font-mono font-bold text-slate-900">{{ $log->waktu->format('H:i:s') }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase">{{ $log->waktu->format('d M Y') }}</p>
                                </td>
                                <td class="px-6 py-4 w-64">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-[10px] font-black text-indigo-600 border border-indigo-100">
                                            {{ substr($log->pengguna->nama ?? 'S', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-700">{{ $log->pengguna->nama ?? 'SISTEM INTEL' }}</p>
                                            <p class="text-[9px] font-mono text-slate-400">{{ $log->meta_data['ip_address'] ?? '127.0.0.1' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest mb-1 {{ $log->aksi === 'system_lock' ? 'bg-red-100 text-red-600' : 'bg-slate-100 text-slate-500' }}">
                                        {{ str_replace('_', ' ', $log->aksi) }}
                                    </span>
                                    <p class="text-xs text-slate-600 leading-relaxed font-medium group-hover:text-indigo-800 transition-colors">{{ $log->pesan_naratif }}</p>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-8 py-20 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">Tidak ada aktivitas terekam.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-slate-50/30 border-t border-slate-50">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
