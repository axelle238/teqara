<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="bg-violet-900 rounded-[3rem] p-10 overflow-hidden shadow-2xl border border-violet-800 flex flex-col md:flex-row justify-between items-center gap-8 relative">
        <div class="relative z-10 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-2">
                <i class="fa-solid fa-key text-violet-300"></i>
                <span class="text-[10px] font-black text-violet-100 uppercase tracking-widest">Privileged Access Management</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase leading-none">AKSES <span class="text-violet-400">PRIVILEGE</span></h1>
            <p class="text-violet-200 font-medium text-lg">Kontrol ketat untuk akun prioritas tinggi dan manajemen rahasia.</p>
        </div>
        
        <div class="relative z-10 flex gap-4">
            <div class="w-32 h-32 rounded-full border-4 border-violet-500/30 flex flex-col items-center justify-center bg-violet-800/50 shadow-xl backdrop-blur-sm">
                <span class="text-3xl font-black text-white">JIT</span>
                <span class="text-[9px] font-bold text-violet-300 uppercase">Access</span>
            </div>
        </div>

        <!-- Background Effect -->
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Access Requests -->
        <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-black text-slate-800 text-lg uppercase">Permintaan Akses (JIT)</h3>
                <span class="px-3 py-1 bg-violet-50 text-violet-600 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-violet-100">
                    Just-In-Time
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">User & Role</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Durasi & Alasan</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($requests as $req)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="block text-xs font-black text-slate-800">{{ $req['user'] }}</span>
                                <span class="block text-[10px] text-violet-500 font-bold uppercase">{{ $req['role'] }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="block text-xs font-bold text-slate-600">{{ $req['duration'] }}</span>
                                <span class="block text-[10px] text-slate-400 italic truncate max-w-[150px]">{{ $req['reason'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($req['status'] == 'pending')
                                    <div class="flex gap-2 justify-end">
                                        <button wire:click="approveRequest('{{ $req['id'] }}')" class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 hover:bg-emerald-200 flex items-center justify-center transition-colors">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                        <button wire:click="rejectRequest('{{ $req['id'] }}')" class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 hover:bg-rose-200 flex items-center justify-center transition-colors">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                @elseif($req['status'] == 'approved')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase border border-emerald-100">
                                        <i class="fa-solid fa-check-circle"></i> Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-rose-50 text-rose-600 text-[10px] font-black uppercase border border-rose-100">
                                        <i class="fa-solid fa-ban"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Secret Vault -->
        <div class="bg-slate-900 rounded-[30px] shadow-xl border border-slate-800 overflow-hidden">
            <div class="p-8 border-b border-slate-800 flex justify-between items-center">
                <h3 class="font-black text-white text-lg uppercase">Secret Vault</h3>
                <i class="fa-solid fa-vault text-violet-500"></i>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($secrets as $secret)
                    <div class="flex items-center justify-between p-4 bg-slate-800 rounded-2xl border border-slate-700/50 hover:border-violet-500/30 transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-violet-500/10 flex items-center justify-center text-violet-400">
                                <i class="fa-solid {{ $secret['type'] == 'API Key' ? 'fa-code' : 'fa-key' }}"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-200 text-sm">{{ $secret['name'] }}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[9px] font-mono text-slate-500 uppercase bg-slate-900 px-2 py-0.5 rounded">{{ $secret['type'] }}</span>
                                    <span class="text-[9px] text-slate-500">Last: {{ $secret['accessed_by'] }}</span>
                                </div>
                            </div>
                        </div>
                        <button class="px-3 py-1.5 bg-violet-600 hover:bg-violet-500 text-white rounded-lg text-[10px] font-bold uppercase transition-colors opacity-0 group-hover:opacity-100">
                            View
                        </button>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 pt-6 border-t border-slate-800 text-center">
                    <button class="text-xs font-bold text-violet-400 hover:text-violet-300 uppercase tracking-widest flex items-center justify-center gap-2 w-full transition-colors">
                        <i class="fa-solid fa-plus-circle"></i> Simpan Rahasia Baru
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
