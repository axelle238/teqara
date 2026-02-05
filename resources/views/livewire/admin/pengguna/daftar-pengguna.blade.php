<div>
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex gap-2">
            <button wire:click="$set('filterPeran', '')" class="px-4 py-1.5 text-xs font-bold rounded-full border {{ $filterPeran === '' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-200' }}">Semua</button>
            <button wire:click="$set('filterPeran', 'admin')" class="px-4 py-1.5 text-xs font-bold rounded-full border {{ $filterPeran === 'admin' ? 'bg-cyan-600 text-white border-cyan-600' : 'bg-white text-slate-600 border-slate-200' }}">Admin</button>
            <button wire:click="$set('filterPeran', 'pelanggan')" class="px-4 py-1.5 text-xs font-bold rounded-full border {{ $filterPeran === 'pelanggan' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-slate-600 border-slate-200' }}">Pelanggan</button>
        </div>
        <div class="w-full max-w-xs">
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari nama atau email..." class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm">
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pengguna</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Peran</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Terdaftar Pada</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($daftarPengguna as $user)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                <img class="h-10 w-10 rounded-full bg-slate-100" src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=f1f5f9&color=64748b" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-slate-900">{{ $user->nama }}</div>
                                <div class="text-xs text-slate-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold {{ $user->peran === 'admin' ? 'bg-cyan-100 text-cyan-800' : 'bg-slate-100 text-slate-800' }}">
                            {{ strtoupper($user->peran) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <select 
                                onchange="confirm('Ubah peran pengguna ini?') || event.stopImmediatePropagation()"
                                wire:change="ubahPeran({{ $user->id }}, $event.target.value)" 
                                class="text-xs border-slate-200 rounded-lg focus:ring-cyan-500 focus:border-cyan-500"
                            >
                                <option value="pelanggan" {{ $user->peran === 'pelanggan' ? 'selected' : '' }}>Set Pelanggan</option>
                                <option value="staf_gudang" {{ $user->peran === 'staf_gudang' ? 'selected' : '' }}>Set Staf</option>
                                <option value="admin" {{ $user->peran === 'admin' ? 'selected' : '' }}>Set Admin</option>
                            </select>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-slate-500">Tidak ada pengguna ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $daftarPengguna->links() }}
        </div>
    </div>
</div>
