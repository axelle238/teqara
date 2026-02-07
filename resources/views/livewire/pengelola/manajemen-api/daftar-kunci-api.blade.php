<div class="space-y-8 pb-20 animate-in slide-in-from-bottom-4 duration-500">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-indigo-100 text-indigo-600 rounded-xl">
                    <i class="fa-solid fa-key text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Manajemen <span class="text-indigo-600">Kunci API</span></h1>
                    <p class="text-slate-500 font-medium text-sm">Kelola token akses untuk aplikasi mobile dan integrasi pihak ketiga.</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <button wire:click="tambahBaru" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/30 flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Buat Kunci Baru
            </button>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- SIDEBAR INFO -->
        <div class="space-y-6">
            <div class="bg-indigo-900 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <i class="fa-solid fa-shield-halved text-9xl"></i>
                </div>
                <div class="relative z-10">
                    <h3 class="text-xl font-black mb-1">Status Keamanan</h3>
                    <p class="text-indigo-200 font-mono text-xs mb-6 uppercase">OAuth 2.0 / Bearer Token</p>
                    
                    <div class="space-y-4">
                         <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-indigo-300 uppercase">Token Aktif</p>
                                <p class="text-lg font-bold">{{ $kunciApis->total() }}</p>
                            </div>
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-fingerprint"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm">
                <h4 class="font-bold text-slate-800 flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-circle-info text-indigo-500"></i> Panduan Keamanan
                </h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Token hanya ditampilkan sekali saat pembuatan. Pastikan menyalinnya ke tempat aman. Gunakan hak akses (scopes) seminimal mungkin. Cabut kunci jika terindikasi kebocoran.
                </p>
            </div>
        </div>

        <!-- LIST / FORM AREA -->
        <div class="lg:col-span-2">
            
            @if($tampilkanForm)
            <!-- FORM -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 md:p-10 relative overflow-hidden animate-in zoom-in-95 duration-300">
                <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
                    <h3 class="text-xl font-black text-slate-800">{{ $kunciId ? 'Edit Kunci API' : 'Generate Token Baru' }}</h3>
                    <button wire:click="batal" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-colors">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>

                @if($tokenBaru)
                <div class="mb-8 p-6 bg-emerald-50 border border-emerald-200 rounded-2xl">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fa-solid fa-check-circle text-emerald-600 text-xl"></i>
                        <h4 class="font-bold text-emerald-800">Token Berhasil Dibuat!</h4>
                    </div>
                    <p class="text-xs text-emerald-600 mb-4">Salin token ini sekarang. Anda tidak akan bisa melihatnya lagi.</p>
                    <div class="relative">
                        <input type="text" readonly value="{{ $tokenBaru }}" class="w-full pl-4 pr-12 py-3 bg-white border border-emerald-200 rounded-xl font-mono text-sm font-bold text-slate-700" onclick="this.select()">
                         <button class="absolute right-3 top-1/2 -translate-y-1/2 text-emerald-600 hover:text-emerald-800" onclick="navigator.clipboard.writeText('{{ $tokenBaru }}')">
                            <i class="fa-solid fa-copy"></i>
                        </button>
                    </div>
                    <div class="mt-4 text-right">
                         <button wire:click="batal" class="px-5 py-2 bg-emerald-600 text-white rounded-lg font-bold text-xs uppercase tracking-wide hover:bg-emerald-700">Selesai</button>
                    </div>
                </div>
                @else

                <form wire:submit.prevent="simpan" class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest px-1">Nama Aplikasi / Token</label>
                        <input type="text" wire:model="nama_token" class="w-full px-5 py-3.5 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300" placeholder="Mobile App v2 - Android">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest px-1">Pemilik Token (Pengguna)</label>
                        <select wire:model="pengguna_id" class="w-full px-5 py-3.5 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                            <option value="">-- Pilih Pengguna --</option>
                            @foreach($daftarPengguna as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->email }}) - {{ ucfirst($p->peran) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                         <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest px-1">Cakupan Akses (Scopes)</label>
                         <div class="grid grid-cols-2 gap-3">
                             <label class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100">
                                 <input type="checkbox" wire:model="hak_akses" value="read-products" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                                 <span class="text-xs font-bold text-slate-700">Read Products</span>
                             </label>
                             <label class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100">
                                 <input type="checkbox" wire:model="hak_akses" value="create-orders" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                                 <span class="text-xs font-bold text-slate-700">Create Orders</span>
                             </label>
                              <label class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100">
                                 <input type="checkbox" wire:model="hak_akses" value="manage-users" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                                 <span class="text-xs font-bold text-slate-700">Manage Users</span>
                             </label>
                         </div>
                    </div>

                     <div class="space-y-2">
                         <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest px-1">Status</label>
                         <div class="flex gap-4">
                             <label class="cursor-pointer">
                                 <input type="radio" wire:model="status" value="aktif" class="peer sr-only">
                                 <div class="px-6 py-2 bg-slate-50 rounded-xl border border-transparent peer-checked:bg-emerald-50 peer-checked:border-emerald-200 peer-checked:text-emerald-700 font-bold text-sm text-center transition-all hover:bg-slate-100 uppercase">Aktif</div>
                             </label>
                             <label class="cursor-pointer">
                                 <input type="radio" wire:model="status" value="nonaktif" class="peer sr-only">
                                 <div class="px-6 py-2 bg-slate-50 rounded-xl border border-transparent peer-checked:bg-slate-200 peer-checked:text-slate-700 font-bold text-sm text-center transition-all hover:bg-slate-100 uppercase">Non-Aktif</div>
                             </label>
                         </div>
                     </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" wire:click="batal" class="px-6 py-3 bg-white text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition-colors">Batal</button>
                        <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30">
                            {{ $kunciId ? 'Simpan Perubahan' : 'Generate Token' }}
                        </button>
                    </div>
                </form>
                @endif
            </div>

            @else
            <!-- LIST -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden animate-in fade-in duration-500">
                <div class="p-6 border-b border-slate-100">
                     <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" wire:model.live.debounce.300ms="cari" class="w-full pl-10 pr-4 py-3 bg-slate-50 border-none rounded-xl font-bold text-sm focus:ring-2 focus:ring-indigo-500/20" placeholder="Cari token atau nama pengguna...">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Token</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pemilik</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Akses</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($kunciApis as $kunci)
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-800">{{ $kunci->nama_token }}</span>
                                        <span class="text-[10px] text-slate-400 font-mono">Last used: {{ $kunci->terakhir_digunakan ? $kunci->terakhir_digunakan->diffForHumans() : 'Never' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="w-6 h-6 bg-slate-200 rounded-full flex items-center justify-center text-[10px] font-bold text-slate-600">{{ substr($kunci->pengguna->nama ?? '?', 0, 1) }}</span>
                                        <span class="text-xs font-bold text-slate-600">{{ $kunci->pengguna->nama ?? 'Terhapus' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($kunci->hak_akses ?? [] as $scope)
                                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded text-[9px] font-bold uppercase">{{ $scope }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($kunci->status == 'aktif')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                            <i class="fa-solid fa-circle text-[6px]"></i> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">
                                            <i class="fa-solid fa-ban text-[8px]"></i> Revoked
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button wire:click="edit({{ $kunci->id }})" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button wire:click="hapus({{ $kunci->id }})" wire:confirm="Cabut akses kunci ini?" class="p-2 text-slate-400 hover:text-rose-600 transition-colors">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center text-slate-400">
                                    <p class="text-sm font-bold">Belum ada kunci API.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-5 border-t border-slate-100">
                    {{ $kunciApis->links() }}
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
