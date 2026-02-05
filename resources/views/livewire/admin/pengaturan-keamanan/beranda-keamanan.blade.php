<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">PUSAT <span class="text-red-600">KEAMANAN</span></h1>
            <p class="text-slate-500 font-medium">Audit akses, log aktivitas, dan kebijakan proteksi.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Kebijakan Keamanan -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Kebijakan Akses</h3>
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-slate-700">Rotasi Sandi 90 Hari</p>
                            <p class="text-xs text-slate-400">Wajibkan staff mengganti sandi berkala.</p>
                        </div>
                        <button wire:click="$toggle('wajib_ganti_sandi_90_hari'); $wire.simpanKebijakan()" class="w-12 h-6 rounded-full transition-colors {{ $wajib_ganti_sandi_90_hari ? 'bg-emerald-500' : 'bg-slate-200' }} relative">
                            <span class="absolute top-1 left-1 bg-white w-4 h-4 rounded-full transition-transform {{ $wajib_ganti_sandi_90_hari ? 'translate-x-6' : '' }}"></span>
                        </button>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-slate-700">Autentikasi 2 Faktor (2FA)</p>
                            <p class="text-xs text-slate-400">Wajib untuk level Administrator.</p>
                        </div>
                        <button wire:click="$toggle('aktifkan_2fa_admin'); $wire.simpanKebijakan()" class="w-12 h-6 rounded-full transition-colors {{ $aktifkan_2fa_admin ? 'bg-emerald-500' : 'bg-slate-200' }} relative">
                            <span class="absolute top-1 left-1 bg-white w-4 h-4 rounded-full transition-transform {{ $aktifkan_2fa_admin ? 'translate-x-6' : '' }}"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 p-8 rounded-[40px] border border-red-100">
                <h4 class="font-black text-red-900 uppercase tracking-widest text-xs mb-4">Status Ancaman</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-red-800 font-medium">Login Gagal (24h)</span>
                        <span class="font-black text-red-900">0 Percobaan</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-red-800 font-medium">IP Mencurigakan</span>
                        <span class="font-black text-red-900">0 Terdeteksi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Log Aktivitas -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Jejak Audit Digital</h3>
                    <select wire:model.live="filterAksi" class="text-xs border-none bg-slate-50 rounded-lg font-bold text-slate-600 focus:ring-0">
                        <option value="">Semua Aktivitas</option>
                        <option value="login">Login Masuk</option>
                        <option value="create_produk">Tambah Produk</option>
                        <option value="update_pesanan">Update Pesanan</option>
                    </select>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Aktor</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($logs as $log)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <p class="text-xs font-bold text-slate-900">{{ $log->waktu->format('d/m/Y H:i') }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $log->waktu->diffForHumans() }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-black">{{ substr($log->pengguna->nama ?? 'S', 0, 1) }}</div>
                                        <span class="text-xs font-bold text-slate-700">{{ $log->pengguna->nama ?? 'Sistem' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs text-slate-600 leading-relaxed">{{ $log->pesan_naratif }}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[10px] font-mono">{{ $log->aksi }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-slate-50/30">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
