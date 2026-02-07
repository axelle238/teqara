<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Jejak <span class="text-rose-600">Aktivitas</span></h1>
                <p class="text-slate-500 font-medium text-sm mt-2">Pantau akses akun dan perubahan keamanan.</p>
            </div>
            <div class="flex gap-3">
                <div class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-xs font-bold border border-emerald-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Akun Aman
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">Aktivitas</th>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">Waktu</th>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">IP Address</th>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($this->riwayat as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                                        @if($log->aksi == 'login') 🔓
                                        @elseif($log->aksi == 'logout') 🔒
                                        @elseif($log->aksi == 'ganti_sandi') 🔑
                                        @else 📝
                                        @endif
                                    </div>
                                    <span class="font-bold text-slate-900 uppercase text-xs">{{ str_replace('_', ' ', $log->aksi) }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 font-medium text-slate-600">
                                {{ $log->waktu->format('d M Y, H:i') }}
                            </td>
                            <td class="px-8 py-6 font-mono text-xs text-slate-500">
                                {{ $log->meta_data['ip'] ?? '127.0.0.1' }}
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600">
                                    Sukses
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-slate-400 italic">
                                Belum ada aktivitas tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($this->riwayat->hasPages())
            <div class="p-6 border-t border-slate-50 bg-slate-50/30">
                {{ $this->riwayat->links() }}
            </div>
            @endif
        </div>

        <div class="mt-8 bg-rose-50 rounded-2xl p-6 border border-rose-100 flex gap-4 items-start">
            <div class="text-2xl">⚠️</div>
            <div>
                <h4 class="font-bold text-rose-800 text-sm mb-1">Aktivitas Mencurigakan?</h4>
                <p class="text-xs text-rose-600 leading-relaxed mb-4">Jika Anda melihat login dari lokasi atau perangkat yang tidak dikenal, segera ubah kata sandi Anda.</p>
                <a href="{{ route('customer.security') }}" class="text-xs font-black text-rose-700 underline hover:text-rose-900">Ubah Kata Sandi Sekarang</a>
            </div>
        </div>

    </div>
</div>
