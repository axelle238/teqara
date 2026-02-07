<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row items-end justify-between mb-12 gap-6 animate-fade-in-down">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Manajemen <span class="text-indigo-600">Tim</span></h1>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-2">Kolaborasi Bisnis yang Efisien & Terkontrol</p>
            </div>
            @if(!$tambahMode)
            <button wire:click="$set('tambahMode', true)" class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg hover:shadow-indigo-500/30 group">
                <span class="group-hover:rotate-90 transition-transform duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </span>
                Undang Anggota
            </button>
            @endif
        </div>

        @if($tambahMode)
        <div class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-slate-100 shadow-xl mb-10 animate-fade-in-up relative overflow-hidden">
            <!-- Background Glow -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

            <div class="flex justify-between items-center mb-8 relative z-10">
                <div>
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Undang Anggota Baru</h3>
                    <p class="text-xs text-slate-500 font-medium">Berikan akses ke staf Anda sesuai kebutuhan.</p>
                </div>
                <button wire:click="$set('tambahMode', false)" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit.prevent="tambahAnggota" class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Lengkap</label>
                    <div class="relative">
                        <input wire:model="nama" type="text" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 pl-12 transition-all">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">👤</span>
                    </div>
                    @error('nama') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Kerja</label>
                    <div class="relative">
                        <input wire:model="email" type="email" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 pl-12 transition-all">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">📧</span>
                    </div>
                    @error('email') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Peran Akses</label>
                    <div class="relative">
                        <select wire:model="peran" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 cursor-pointer appearance-none pl-12 transition-all">
                            <option value="staf">Staf (Pembelian)</option>
                            <option value="keuangan">Keuangan (Invoice)</option>
                            <option value="admin">Admin (Full Akses)</option>
                        </select>
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">🛡️</span>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">▼</span>
                    </div>
                </div>

                <div class="md:col-span-3 pt-4 flex justify-end border-t border-slate-50">
                    <button type="submit" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 transition-all active:scale-95 flex items-center gap-3">
                        <span>Kirim Undangan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </div>
            </form>
        </div>
        @endif

        <!-- Team List -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden animate-fade-in-up delay-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">Anggota</th>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">Peran</th>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">Status</th>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">Bergabung</th>
                            <th class="px-8 py-6 text-right font-black text-slate-400 uppercase tracking-widest text-[10px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <!-- Owner (Self) -->
                        <tr class="bg-indigo-50/20">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 text-white flex items-center justify-center font-black text-sm shadow-lg shadow-indigo-500/20">
                                        {{ substr(auth()->user()->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900">{{ auth()->user()->nama }} (Anda)</h4>
                                        <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-wide">Pemilik Bisnis</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-[10px] font-black uppercase tracking-widest border border-indigo-200">Super Admin</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="flex items-center gap-2 text-[10px] font-black text-emerald-600 uppercase tracking-widest">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Online
                                </span>
                            </td>
                            <td class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">-</td>
                            <td class="px-8 py-6"></td>
                        </tr>

                        <!-- Team Members -->
                        @foreach($this->timSaya as $member)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center font-black text-sm border border-slate-200 group-hover:bg-white group-hover:shadow-sm transition-all">
                                        {{ substr($member->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900">{{ $member->nama }}</h4>
                                        <p class="text-xs text-slate-500">{{ $member->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-white border border-slate-200 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-widest group-hover:border-indigo-200 group-hover:text-indigo-600 transition-colors">
                                    {{ $member->peran }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                    <span class="w-2 h-2 rounded-full {{ $member->status == 'aktif' ? 'bg-emerald-400' : 'bg-amber-400' }}"></span> 
                                    {{ ucfirst($member->status) }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $member->dibuat_pada->format('d M Y') }}</td>
                            <td class="px-8 py-6 text-right">
                                <button wire:click="hapus({{ $member->id }})" class="p-2 rounded-lg text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-all" title="Hapus Anggota">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($this->timSaya->count() == 0)
            <div class="py-24 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl opacity-50">👥</div>
                <h3 class="text-slate-900 font-black mb-1">Tim Masih Solo</h3>
                <p class="text-slate-400 text-sm mb-6 max-w-xs mx-auto">Tambahkan anggota tim untuk berbagi beban kerja dan pengelolaan akun bisnis.</p>
                <button wire:click="$set('tambahMode', true)" class="text-xs font-black text-indigo-600 uppercase tracking-widest hover:underline">
                    Mulai Undang Tim
                </button>
            </div>
            @endif
        </div>

    </div>
</div>