<div class="space-y-8">
    
    <!-- Header Vibrant -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">BASIS DATA <span class="text-rose-600">PELANGGAN</span></h1>
            <p class="text-slate-500 font-medium">Manajemen identitas member dan segmentasi pengguna.</p>
        </div>
        <div class="w-full md:w-96">
            <div class="relative group">
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari nama, email atau ID..." class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-rose-500 transition-all">
                <svg class="w-5 h-5 absolute left-4 top-4 text-slate-400 group-focus-within:text-rose-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Filter Pills -->
    <div class="flex flex-wrap gap-2 pb-2">
        <div class="flex items-center gap-2 pr-4 border-r border-slate-200">
            @foreach(['' => 'SEMUA', 'admin' => 'ADMINISTRATOR', 'pelanggan' => 'MEMBER', 'staf_gudang' => 'LOGISTIK'] as $val => $label)
            <button wire:click="$set('filterPeran', '{{ $val }}')" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition {{ $filterPeran === $val ? 'bg-rose-600 text-white shadow-lg shadow-rose-500/30' : 'bg-white text-slate-500 hover:bg-rose-50 hover:text-rose-600' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>
        <div class="flex items-center gap-2 pl-2">
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mr-2">Segmen:</span>
            @foreach(['vip' => 'VIP', 'loyal' => 'SETIA', 'new' => 'BARU', 'passive' => 'PASIF'] as $val => $label)
            <button wire:click="$set('filterSegmen', '{{ $filterSegmen === $val ? '' : $val }}')" class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition {{ $filterSegmen === $val ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'bg-white text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 border border-slate-100' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Tabel Member -->
    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-8 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Identitas</th>
                    <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Akses Peran</th>
                    <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Bergabung</th>
                    <th class="px-8 py-6 text-right"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($daftarPengguna as $user)
                <tr class="group hover:bg-rose-50/20 transition-colors">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-[18px] bg-slate-100 flex items-center justify-center text-slate-400 font-black shadow-inner">
                                {{ substr($user->nama, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-black text-slate-900 text-sm">{{ $user->nama }}</div>
                                <div class="text-xs text-slate-500 font-medium">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $user->peran === 'admin' ? 'bg-indigo-100 text-indigo-700' : ($user->peran === 'staf_gudang' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700') }}">
                            {{ $user->peran }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-xs font-bold text-slate-500">
                        {{ $user->created_at->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-8 py-5 text-right">
                        <button wire:click="inspeksi({{ $user->id }})" class="px-5 py-2 bg-white border border-rose-100 text-rose-500 hover:bg-rose-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition shadow-sm">
                            INSPEKSI PROFIL
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-8 py-10 text-center text-slate-400 font-bold">Data pengguna tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-8 bg-slate-50/30">{{ $daftarPengguna->links() }}</div>
    </div>

    <!-- Panel Inspeksi 360 Derajat -->
    <x-ui.panel-geser id="inspeksi-member" judul="PROFIL MEMBER 360°">
        @if($memberTerpilih)
        <div x-data="{ tab: 'profil' }" class="space-y-8">
            
            <!-- Header Profil Ringkas -->
            <div class="bg-slate-900 rounded-[32px] p-8 text-white relative overflow-hidden">
                <div class="relative z-10 flex items-start gap-6">
                    <div class="w-20 h-20 rounded-[24px] bg-white/10 flex items-center justify-center text-3xl font-black backdrop-blur-sm border border-white/20">
                        {{ substr($memberTerpilih->nama, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-black tracking-tight">{{ $memberTerpilih->nama }}</h3>
                        <p class="text-white/60 font-medium mb-4">{{ $memberTerpilih->email }}</p>
                        
                        <div class="flex gap-3">
                            <span class="px-3 py-1 bg-gradient-to-r from-amber-400 to-orange-500 text-white rounded-lg text-[9px] font-black uppercase tracking-widest shadow-lg">
                                MEMBER {{ strtoupper($statistikMember['segmen'] ?? 'BRONZE') }}
                            </span>
                            <span class="px-3 py-1 bg-white/10 text-white rounded-lg text-[9px] font-black uppercase tracking-widest border border-white/10">
                                ID: #{{ $memberTerpilih->id }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Background Pattern -->
                <div class="absolute right-0 top-0 w-64 h-64 bg-rose-500/20 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/2"></div>
            </div>

            <!-- Tab Navigasi -->
            <div class="flex p-1 bg-slate-100 rounded-2xl">
                <button @click="tab = 'profil'" :class="tab === 'profil' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Statistik & Bio</button>
                <button @click="tab = 'transaksi'" :class="tab === 'transaksi' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Riwayat Belanja</button>
                <button @click="tab = 'akses'" :class="tab === 'akses' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Hak Akses</button>
            </div>

            <!-- Konten Tab: Profil & Statistik -->
            <div x-show="tab === 'profil'" x-transition class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-rose-50 p-6 rounded-[24px] border border-rose-100">
                        <p class="text-[9px] font-black text-rose-400 uppercase tracking-widest mb-1">Lifetime Value (LTV)</p>
                        <p class="text-xl font-black text-rose-600">Rp {{ number_format($statistikMember['ltv'] ?? 0) }}</p>
                    </div>
                    <div class="bg-indigo-50 p-6 rounded-[24px] border border-indigo-100">
                        <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-1">Total Pesanan</p>
                        <p class="text-xl font-black text-indigo-600">{{ $statistikMember['frekuensi'] ?? 0 }} <span class="text-xs">Transaksi</span></p>
                    </div>
                    <div class="bg-emerald-50 p-6 rounded-[24px] border border-emerald-100">
                        <p class="text-[9px] font-black text-emerald-400 uppercase tracking-widest mb-1">Rata-rata Keranjang</p>
                        <p class="text-xl font-black text-emerald-600">Rp {{ number_format($statistikMember['aov'] ?? 0) }}</p>
                    </div>
                    <div class="bg-amber-50 p-6 rounded-[24px] border border-amber-100">
                        <p class="text-[9px] font-black text-amber-600 uppercase tracking-widest mb-1">Tiket Support</p>
                        <p class="text-xl font-black text-amber-700">{{ $statistikMember['tiket_terbuka'] ?? 0 }} <span class="text-xs">Open</span></p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[24px] border border-slate-100">
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4">Informasi Kontak</h4>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between border-b border-slate-50 pb-2">
                            <span class="text-slate-500">Email</span>
                            <span class="font-bold text-slate-900">{{ $memberTerpilih->email }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-50 pb-2">
                            <span class="text-slate-500">Telepon</span>
                            <span class="font-bold text-slate-900">{{ $memberTerpilih->nomor_telepon ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-50 pb-2">
                            <span class="text-slate-500">Bergabung</span>
                            <span class="font-bold text-slate-900">{{ $memberTerpilih->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Konten Tab: Transaksi -->
            <div x-show="tab === 'transaksi'" x-transition class="space-y-4">
                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-2">5 Transaksi Terakhir</h4>
                @forelse($memberTerpilih->pesanan()->latest()->take(5)->get() as $p)
                <div class="bg-white p-5 rounded-[20px] border border-slate-100 flex justify-between items-center group hover:border-rose-200 transition-colors">
                    <div>
                        <p class="font-black text-slate-900 text-xs">#{{ $p->nomor_faktur }}</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $p->created_at->translatedFormat('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-slate-900 text-sm">Rp {{ number_format($p->total_harga) }}</p>
                        <span class="text-[9px] font-bold uppercase {{ $p->status_pesanan == 'selesai' ? 'text-emerald-500' : 'text-amber-500' }}">{{ $p->status_pesanan }}</span>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center bg-slate-50 rounded-[20px] text-slate-400 font-bold text-xs">Belum ada riwayat transaksi.</div>
                @endforelse
            </div>

            <!-- Konten Tab: Akses -->
            <div x-show="tab === 'akses'" x-transition class="space-y-6">
                <div class="bg-indigo-50/50 p-6 rounded-[24px] border border-indigo-100">
                    <h4 class="text-xs font-black text-indigo-700 uppercase tracking-widest mb-4">Manajemen Otoritas</h4>
                    <p class="text-xs text-slate-600 mb-6 leading-relaxed">Mengubah peran pengguna akan memberikan akses ke fitur administratif. Pastikan tindakan ini telah disetujui oleh atasan.</p>
                    
                    <div class="space-y-3">
                        <button wire:click="ubahPeran({{ $memberTerpilih->id }}, 'pelanggan')" class="w-full p-4 flex items-center justify-between bg-white rounded-xl border {{ $memberTerpilih->peran === 'pelanggan' ? 'border-indigo-500 ring-1 ring-indigo-500' : 'border-slate-200 hover:border-indigo-300' }} transition-all">
                            <span class="text-xs font-bold text-slate-700">MEMBER (Pelanggan)</span>
                            @if($memberTerpilih->peran === 'pelanggan') <span class="w-2 h-2 rounded-full bg-indigo-500"></span> @endif
                        </button>
                        <button wire:click="ubahPeran({{ $memberTerpilih->id }}, 'staf_gudang')" class="w-full p-4 flex items-center justify-between bg-white rounded-xl border {{ $memberTerpilih->peran === 'staf_gudang' ? 'border-amber-500 ring-1 ring-amber-500' : 'border-slate-200 hover:border-amber-300' }} transition-all">
                            <span class="text-xs font-bold text-slate-700">LOGISTIK (Staf Gudang)</span>
                            @if($memberTerpilih->peran === 'staf_gudang') <span class="w-2 h-2 rounded-full bg-amber-500"></span> @endif
                        </button>
                        <button wire:click="ubahPeran({{ $memberTerpilih->id }}, 'admin')" wire:confirm="PERINGATAN: Anda akan memberikan akses ADMINISTRATOR penuh. Lanjutkan?" class="w-full p-4 flex items-center justify-between bg-white rounded-xl border {{ $memberTerpilih->peran === 'admin' ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-200 hover:border-rose-300' }} transition-all">
                            <span class="text-xs font-bold text-slate-700">ADMINISTRATOR (Super User)</span>
                            @if($memberTerpilih->peran === 'admin') <span class="w-2 h-2 rounded-full bg-rose-500"></span> @endif
                        </button>
                    </div>
                </div>
            </div>

        </div>
        @endif
    </x-ui.panel-geser>
</div>
