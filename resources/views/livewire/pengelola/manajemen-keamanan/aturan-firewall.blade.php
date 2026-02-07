<div class="space-y-8 pb-20 animate-in slide-in-from-bottom-4 duration-500">
    
    <!-- HEADER -->
    <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 p-10 opacity-10">
            <i class="fa-solid fa-fire text-9xl text-rose-500"></i>
        </div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-8">
            <div class="space-y-4">
                <div class="flex items-center gap-3 mb-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-black text-emerald-400 uppercase tracking-[0.2em]">Sistem Pertahanan Aktif</span>
                </div>
                <h1 class="text-4xl font-black tracking-tight leading-none">Web Application <span class="text-rose-500">Firewall</span></h1>
                <p class="text-slate-400 font-medium max-w-xl text-sm leading-relaxed">
                    Atur lalu lintas masuk dan keluar, blokir IP mencurigakan, dan lindungi aplikasi dari serangan bot atau DDoS secara real-time.
                </p>
                <div class="flex gap-4 pt-4">
                    <button wire:click="setTab('create')" class="px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold text-xs uppercase tracking-widest transition-all shadow-lg shadow-rose-900/50 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved"></i> Tambah Aturan Baru
                    </button>
                    <button wire:click="setTab('list')" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl font-bold text-xs uppercase tracking-widest transition-all border border-slate-700">
                        <i class="fa-solid fa-list-ul"></i> Lihat Log Aturan
                    </button>
                </div>
            </div>

            <div class="flex gap-6 text-center">
                <div class="bg-slate-800/50 rounded-2xl p-4 border border-slate-700/50 backdrop-blur-sm">
                    <span class="block text-2xl font-black text-white mb-1">24</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Aturan Aktif</span>
                </div>
                <div class="bg-slate-800/50 rounded-2xl p-4 border border-slate-700/50 backdrop-blur-sm">
                    <span class="block text-2xl font-black text-rose-400 mb-1">1.2k</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Blokir (24j)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- SIDEBAR / FILTER -->
        <div class="space-y-6">
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6">
                <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest mb-4">Filter Log</h3>
                <div class="relative mb-4">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" wire:model.live.debounce.300ms="cari" class="w-full pl-10 pr-4 py-3 bg-slate-50 border-none rounded-xl font-bold text-sm focus:ring-2 focus:ring-rose-500/20" placeholder="Cari IP / User Agent...">
                </div>
                
                <div class="space-y-2">
                    <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors group">
                        <div class="w-4 h-4 rounded border-2 border-slate-300 group-hover:border-rose-500 transition-colors"></div>
                        <span class="text-xs font-bold text-slate-600">Hanya yang Aktif</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors group">
                        <div class="w-4 h-4 rounded border-2 border-slate-300 group-hover:border-rose-500 transition-colors"></div>
                        <span class="text-xs font-bold text-slate-600">Level Kritis Saja</span>
                    </label>
                </div>
            </div>

            <div class="bg-rose-50 border border-rose-100 rounded-[2rem] p-6">
                <h4 class="font-bold text-rose-900 flex items-center gap-2 text-sm mb-2">
                    <i class="fa-solid fa-circle-info"></i> Info WAF
                </h4>
                <p class="text-xs text-rose-700 leading-relaxed">
                    Aturan "Blokir" akan menolak akses secara instan (403 Forbidden). Aturan diproses dari atas ke bawah. IP Whitelist akan diutamakan dari Blacklist global.
                </p>
            </div>
        </div>

        <!-- LIST / FORM AREA -->
        <div class="lg:col-span-2">
            
            @if($activeTab === 'create')
            <!-- FORM TAMBAH/EDIT -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 animate-in zoom-in-95 duration-300">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-black text-slate-800">{{ $ruleId ? 'Edit Aturan' : 'Buat Aturan Baru' }}</h3>
                    <button wire:click="setTab('list')" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-colors">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>

                <form wire:submit.prevent="simpan" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Alamat IP Target</label>
                            <input type="text" wire:model="alamat_ip" class="w-full px-5 py-3.5 bg-slate-50 border-none rounded-xl font-mono font-bold text-sm focus:ring-4 focus:ring-rose-500/10 placeholder:text-slate-300" placeholder="192.168.1.1">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">User Agent (Regex Opsional)</label>
                            <input type="text" wire:model="user_agent" class="w-full px-5 py-3.5 bg-slate-50 border-none rounded-xl font-mono font-bold text-sm focus:ring-4 focus:ring-rose-500/10 placeholder:text-slate-300" placeholder="python-requests/2.2">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tindakan</label>
                            <select wire:model="tipe_aturan" class="w-full px-5 py-3.5 bg-slate-50 border-none rounded-xl font-bold text-sm focus:ring-4 focus:ring-rose-500/10">
                                <option value="blokir">⛔ BLOKIR (Block)</option>
                                <option value="izinkan">✅ IZINKAN (Allow)</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Level Ancaman</label>
                            <select wire:model="level_ancaman" class="w-full px-5 py-3.5 bg-slate-50 border-none rounded-xl font-bold text-sm focus:ring-4 focus:ring-rose-500/10">
                                <option value="low">Rendah</option>
                                <option value="medium">Sedang</option>
                                <option value="high">Tinggi</option>
                                <option value="critical">Kritis</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kedaluwarsa (Opsional)</label>
                            <input type="datetime-local" wire:model="kadaluarsa_pada" class="w-full px-5 py-3.5 bg-slate-50 border-none rounded-xl font-bold text-sm focus:ring-4 focus:ring-rose-500/10 text-slate-600">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Alasan / Catatan Log</label>
                        <textarea wire:model="alasan" rows="3" class="w-full px-5 py-3.5 bg-slate-50 border-none rounded-xl font-bold text-sm focus:ring-4 focus:ring-rose-500/10 placeholder:text-slate-300" placeholder="Contoh: Terdeteksi melakukan brute force login pada jam 02:00"></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                        <button type="button" wire:click="resetForm" class="px-6 py-3 bg-white text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition-colors">Reset</button>
                        <button type="submit" class="px-8 py-3 bg-rose-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-rose-700 transition-all shadow-lg shadow-rose-500/30">
                            <i class="fa-solid fa-shield-virus mr-2"></i> Terapkan Aturan
                        </button>
                    </div>
                </form>
            </div>

            @else
            <!-- LIST VIEW -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden animate-in fade-in duration-500">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Target</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tipe & Level</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Alasan</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($rules as $rule)
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-4">
                                    <div class="flex flex-col">
                                        @if($rule->alamat_ip)
                                        <span class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded w-fit mb-1">{{ $rule->alamat_ip }}</span>
                                        @endif
                                        @if($rule->user_agent)
                                        <span class="text-[10px] text-slate-400 truncate max-w-[150px]"><i class="fa-solid fa-robot mr-1"></i> {{ $rule->user_agent }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-start gap-1">
                                        <span class="px-2 py-1 rounded-md text-[10px] font-black uppercase {{ $rule->tipe_aturan == 'blokir' ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' }}">
                                            {{ $rule->tipe_aturan }}
                                        </span>
                                        <span class="text-[9px] font-bold text-slate-400 uppercase">{{ $rule->level_ancaman }} Priority</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs font-bold text-slate-600 truncate max-w-[200px]">{{ $rule->alasan }}</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $rule->dibuat_pada->diffForHumans() }}</p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button wire:click="toggleStatus({{ $rule->id }})" class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors {{ $rule->aktif ? 'bg-emerald-100 text-emerald-600 hover:bg-emerald-200' : 'bg-slate-100 text-slate-400 hover:bg-slate-200' }}" title="Toggle Status">
                                            <i class="fa-solid fa-power-off"></i>
                                        </button>
                                        <button wire:click="edit({{ $rule->id }})" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 flex items-center justify-center transition-colors">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button wire:click="hapus({{ $rule->id }})" 
                                                wire:confirm="Yakin ingin menghapus aturan ini?"
                                                class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition-colors">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <i class="fa-solid fa-shield-cat text-4xl mb-3 opacity-20"></i>
                                        <p class="text-sm font-bold">Belum ada aturan firewall.</p>
                                        <p class="text-xs">Sistem menggunakan kebijakan default.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-4 border-t border-slate-100">
                    {{ $rules->links() }}
                </div>
            </div>
            @endif

        </div>
    </div>
</div>