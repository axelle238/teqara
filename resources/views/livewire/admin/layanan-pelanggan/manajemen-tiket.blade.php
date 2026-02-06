<div class="animate-in fade-in duration-500">
    
    @if(!$tampilkanDetail)
        <!-- TAMPILAN 1: PUSAT TIKET BANTUAN (FULL PAGE LIST) -->
        <div class="space-y-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="space-y-1">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Dashboard Helpdesk</h1>
                    <p class="text-slate-500 font-medium">Resolusi kendala dan layanan purna jual pelanggan enterprise.</p>
                </div>
                <div class="flex gap-4">
                    <div class="bg-indigo-50 px-6 py-3 rounded-2xl border border-indigo-100 flex items-center gap-3">
                        <span class="text-xs font-black text-indigo-600 uppercase tracking-widest">Total Antrean:</span>
                        <span class="text-xl font-black text-indigo-700">{{ $statistik['terbuka'] + $statistik['diproses'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Stats & Quick Filters -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <button wire:click="$set('filterStatus', 'terbuka')" class="p-6 rounded-[35px] border-2 transition-all text-left flex items-center justify-between {{ $filterStatus === 'terbuka' ? 'bg-indigo-600 border-indigo-600 text-white shadow-xl shadow-indigo-500/20' : 'bg-white border-slate-50 text-slate-600 hover:border-indigo-200' }}">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Tiket Terbuka</p>
                        <h3 class="text-3xl font-black">{{ $statistik['terbuka'] }}</h3>
                    </div>
                    <i class="fa-solid fa-envelope-open-text text-3xl opacity-30"></i>
                </button>
                <button wire:click="$set('filterStatus', 'diproses')" class="p-6 rounded-[35px] border-2 transition-all text-left flex items-center justify-between {{ $filterStatus === 'diproses' ? 'bg-amber-500 border-amber-500 text-white shadow-xl shadow-amber-500/20' : 'bg-white border-slate-50 text-slate-600 hover:border-amber-200' }}">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Sedang Ditangani</p>
                        <h3 class="text-3xl font-black">{{ $statistik['diproses'] }}</h3>
                    </div>
                    <i class="fa-solid fa-user-gear text-3xl opacity-30"></i>
                </button>
                <button wire:click="$set('filterStatus', 'selesai')" class="p-6 rounded-[35px] border-2 transition-all text-left flex items-center justify-between {{ $filterStatus === 'selesai' ? 'bg-emerald-500 border-emerald-500 text-white shadow-xl shadow-emerald-500/20' : 'bg-white border-slate-50 text-slate-600 hover:border-emerald-200' }}">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Berhasil Diselesaikan</p>
                        <h3 class="text-3xl font-black">{{ $statistik['selesai'] }}</h3>
                    </div>
                    <i class="fa-solid fa-circle-check text-3xl opacity-30"></i>
                </button>
            </div>

            <!-- Tiket Table -->
            <div class="bg-white rounded-[45px] shadow-sm border border-indigo-50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tiket & Subjek</th>
                                <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pelanggan</th>
                                <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status Akhir</th>
                                <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Waktu Input</th>
                                <th class="px-10 py-6 text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($daftarTiket as $tiket)
                            <tr class="group hover:bg-indigo-50/30 transition-all">
                                <td class="px-10 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-1">ID: #{{ $tiket->id }}</span>
                                        <span class="text-sm font-black text-slate-800 leading-tight">{{ $tiket->subjek }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500 uppercase border border-slate-200">
                                            {{ substr($tiket->pengguna->nama ?? 'U', 0, 1) }}
                                        </div>
                                        <span class="text-xs font-bold text-slate-700">{{ $tiket->pengguna->nama ?? 'Guest' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    @php
                                        $statusClass = match($tiket->status) {
                                            'terbuka' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                            'diproses' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            default => 'bg-slate-50 text-slate-500',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $statusClass }}">
                                        {{ $tiket->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-6">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">{{ $tiket->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <button wire:click="bukaTiket({{ $tiket->id }})" class="px-6 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-sm">KELOLA TIKET</button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-10 py-20 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">Antrean tiket bantuan kosong.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-10 border-t border-slate-50">{{ $daftarTiket->links() }}</div>
            </div>
        </div>
    @else
        <!-- TAMPILAN 2: RUANG RESOLUSI TIKET (FULL PAGE FORM) -->
        <div class="space-y-8 animate-in slide-in-from-right-8 duration-500">
            <!-- Header Resolusi -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="flex items-center gap-6">
                    <button wire:click="kembali" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                    </button>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Resolusi Tiket #{{ $tiketTerpilih->id }}</h1>
                        <p class="text-slate-500 font-medium">Mitra: {{ $tiketTerpilih->pengguna->nama }} — {{ $tiketTerpilih->subjek }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button wire:click="ubahStatus('selesai')" wire:confirm="Tandai tiket ini sudah terselesaikan?" class="px-8 py-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-3xl text-sm font-black shadow-xl shadow-emerald-500/20 transition-all active:scale-95">SELESAIKAN TIKET</button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Chat & Balasan -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Riwayat Percakapan -->
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8 min-h-[500px] flex flex-col">
                        <div class="flex-1 space-y-10 overflow-y-auto custom-scrollbar pr-4">
                            <!-- Pesan Awal Pelanggan -->
                            <div class="flex gap-6 items-start">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-600 shrink-0 shadow-sm font-black">
                                    {{ substr($tiketTerpilih->pengguna->nama, 0, 1) }}
                                </div>
                                <div class="space-y-3">
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-black text-slate-800">{{ $tiketTerpilih->pengguna->nama }}</span>
                                        <span class="text-[9px] font-bold text-slate-300 uppercase tracking-widest">{{ $tiketTerpilih->created_at->format('H:i') }} WIB</span>
                                    </div>
                                    <div class="bg-slate-50 p-6 rounded-[30px] rounded-tl-none border border-slate-100">
                                        <p class="text-sm font-bold text-slate-600 leading-relaxed">{{ $tiketTerpilih->pesan }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Balasan Admin/Sistem -->
                            @foreach($tiketTerpilih->riwayat_pesan ?? [] as $riwayat)
                                <div class="flex gap-6 items-start {{ $riwayat['pengirim'] === 'admin' ? 'flex-row-reverse' : '' }}">
                                    <div class="w-12 h-12 rounded-2xl {{ $riwayat['pengirim'] === 'admin' ? 'bg-indigo-600 text-white shadow-indigo-500/20' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center shrink-0 shadow-lg font-black uppercase">
                                        {{ substr($riwayat['nama'], 0, 1) }}
                                    </div>
                                    <div class="space-y-3 {{ $riwayat['pengirim'] === 'admin' ? 'text-right' : '' }}">
                                        <div class="flex items-center gap-3 {{ $riwayat['pengirim'] === 'admin' ? 'justify-end' : '' }}">
                                            <span class="text-sm font-black text-slate-800">{{ $riwayat['nama'] }}</span>
                                            <span class="text-[9px] font-bold text-slate-300 uppercase tracking-widest">{{ \Carbon\Carbon::parse($riwayat['waktu'])->format('H:i') }} WIB</span>
                                        </div>
                                        <div class="p-6 rounded-[30px] border {{ $riwayat['pengirim'] === 'admin' ? 'bg-indigo-600 text-white rounded-tr-none border-indigo-500' : 'bg-slate-50 text-slate-600 rounded-tl-none border-slate-100' }}">
                                            <p class="text-sm font-bold leading-relaxed">{{ $riwayat['pesan'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Input Balasan Baru -->
                        <div class="pt-8 border-t border-slate-50">
                            <form wire:submit.prevent="kirimBalasan" class="relative group">
                                <textarea wire:model="pesanBaru" rows="3" class="w-full bg-slate-50 border-none rounded-[35px] pl-8 pr-32 py-6 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300" placeholder="Ketik balasan solusi untuk pelanggan..."></textarea>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2">
                                    <button type="submit" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-3xl text-xs font-black uppercase tracking-widest shadow-xl shadow-indigo-500/20 transition-all active:scale-95">BALAS</button>
                                </div>
                            </form>
                            @error('pesanBaru') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest mt-2 block ml-8">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Informasi Pendukung -->
                <div class="space-y-8">
                    <!-- Status & Otoritas -->
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8 text-center">
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Status Pemrosesan</label>
                            <div class="flex flex-wrap justify-center gap-2">
                                @foreach(['terbuka', 'diproses', 'selesai'] as $s)
                                    <button wire:click="ubahStatus('{{ $s }}')" class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest border transition-all {{ $tiketTerpilih->status === $s ? 'bg-slate-900 text-white border-slate-900 shadow-lg' : 'bg-slate-50 text-slate-400 border-slate-100 hover:border-slate-300' }}">
                                        {{ $s }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-8 border-t border-slate-50 space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Kontak Terdaftar</label>
                            <div class="bg-slate-50 p-6 rounded-[35px] border border-slate-100 text-left space-y-4">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-envelope text-indigo-400 text-xs w-4"></i>
                                    <span class="text-xs font-black text-slate-600 truncate">{{ $tiketTerpilih->pengguna->email }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-phone text-indigo-400 text-xs w-4"></i>
                                    <span class="text-xs font-black text-slate-600">{{ $tiketTerpilih->pengguna->nomor_telepon ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instruksi CS -->
                    <div class="bg-indigo-600 p-10 rounded-[50px] text-white shadow-2xl shadow-indigo-500/30 space-y-4 relative overflow-hidden group">
                        <i class="fa-solid fa-lightbulb text-4xl opacity-20 absolute -right-4 -top-4 group-hover:scale-150 transition-transform duration-1000"></i>
                        <h4 class="text-lg font-black uppercase tracking-tight">Protokol Solusi</h4>
                        <p class="text-xs font-bold text-indigo-100 leading-relaxed italic opacity-80">
                            "Berikan balasan yang empatik. Gunakan bahasa yang jelas dan instruksi yang mudah diikuti untuk memastikan tingkat kepuasan pelanggan tetap maksimal."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
