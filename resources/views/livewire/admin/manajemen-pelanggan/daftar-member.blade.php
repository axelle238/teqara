<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Data Pelanggan</h1>
            <p class="text-slate-500 text-sm mt-1">Direktori seluruh anggota terdaftar.</p>
        </div>
        
        <!-- Search -->
        <div class="relative w-full sm:w-64">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari Nama/Email/HP..." class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
        </div>
    </div>

    <!-- Member Table -->
    <div class="bg-white border border-slate-100 rounded-[24px] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-black tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Profil</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4 text-center">Pesanan</th>
                        <th class="px-6 py-4 text-right">Total Belanja</th>
                        <th class="px-6 py-4 text-center">Bergabung</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($member as $m)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-slate-500">
                                    {{ substr($m->nama, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900">{{ $m->nama }}</p>
                                    @if($m->email_verified_at)
                                        <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                                            <i class="fa-solid fa-check-circle"></i> Terverifikasi
                                        </span>
                                    @else
                                        <span class="text-[10px] text-slate-400">Belum Verifikasi</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs text-slate-600"><i class="fa-solid fa-envelope w-4 text-slate-400"></i> {{ $m->email }}</p>
                            <p class="text-xs text-slate-600 mt-1"><i class="fa-solid fa-phone w-4 text-slate-400"></i> {{ $m->telepon ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold">
                                {{ $m->pesanan_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-mono font-bold text-slate-900">
                            Rp {{ number_format($m->pesanan_sum_total_harga ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center text-xs text-slate-500">
                            {{ $m->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            Tidak ada data pelanggan ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $member->links() }}
        </div>
    </div>
</div>