<div class="bg-slate-50 min-h-screen py-10 font-sans antialiased text-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Akun <span class="text-indigo-600">Saya</span></h1>
                <p class="text-slate-500 font-medium">Kelola profil, pesanan, dan preferensi akun Anda.</p>
            </div>
            <div class="flex items-center gap-4 bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-indigo-500/30">
                    {{ substr(auth()->user()->nama ?? 'U', 0, 1) }}
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-sm leading-tight">{{ auth()->user()->nama }}</h3>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">{{ $gamifikasi['level'] }} Member</p>
                </div>
            </div>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-10 items-start">
            
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-3 lg:sticky lg:top-24 space-y-2 mb-8 lg:mb-0">
                @php
                    $menuItems = [
                        'ringkasan' => ['icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'label' => 'Ringkasan'],
                        'pesanan' => ['icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'label' => 'Pesanan Saya'],
                        'alamat' => ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'label' => 'Buku Alamat'],
                        'pengaturan' => ['icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'label' => 'Pengaturan'],
                    ];
                @endphp

                @foreach($menuItems as $key => $item)
                <button wire:click="gantiTab('{{ $key }}')" class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 {{ $tabAktif == $key ? 'bg-slate-900 text-white shadow-xl shadow-slate-900/20 scale-105' : 'bg-white text-slate-500 hover:bg-slate-50 hover:text-indigo-600 border border-slate-100' }}">
                    <svg class="w-5 h-5 {{ $tabAktif == $key ? 'text-indigo-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path></svg>
                    <span class="text-xs font-black uppercase tracking-widest">{{ $item['label'] }}</span>
                </button>
                @endforeach
                
                <a href="{{ route('logout') }}" class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl bg-white text-rose-500 hover:bg-rose-50 border border-slate-100 mt-8 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="text-xs font-black uppercase tracking-widest">Keluar</span>
                </a>
            </div>

            <!-- Content Area -->
            <div class="lg:col-span-9">
                
                <!-- Tab: Ringkasan -->
                @if($tabAktif == 'ringkasan')
                <div class="space-y-8 animate-fade-in">
                    <!-- Member Card -->
                    <div class="relative w-full aspect-[2/1] md:aspect-[3/1] rounded-[2rem] overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-900 to-purple-900 shadow-2xl shadow-indigo-900/30 p-8 flex flex-col justify-between group">
                        <!-- Card Pattern -->
                        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
                        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500 rounded-full blur-[100px] opacity-30"></div>

                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <h3 class="text-white/80 text-xs font-black uppercase tracking-widest mb-1">Status Keanggotaan</h3>
                                <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight uppercase italic">{{ $gamifikasi['level'] }}</h2>
                            </div>
                            <div class="text-right">
                                <h3 class="text-white/80 text-xs font-black uppercase tracking-widest mb-1">Poin Reward</h3>
                                <h2 class="text-3xl font-black text-amber-400 tracking-tight">{{ number_format($gamifikasi['poin']) }}</h2>
                            </div>
                        </div>

                        <div class="relative z-10">
                            @if($gamifikasi['next_level'] !== 'Max')
                            <div class="flex justify-between items-end mb-2 text-xs font-bold text-white/70 uppercase tracking-widest">
                                <span>Progress ke {{ $gamifikasi['next_level'] }}</span>
                                <span>{{ number_format($gamifikasi['progress'], 0) }}%</span>
                            </div>
                            <div class="w-full h-2 bg-white/20 rounded-full overflow-hidden backdrop-blur-sm">
                                <div class="h-full bg-gradient-to-r from-indigo-500 to-amber-400 rounded-full shadow-[0_0_10px_rgba(251,191,36,0.5)]" style="width: {{ $gamifikasi['progress'] }}%"></div>
                            </div>
                            <p class="text-[10px] text-white/50 mt-2 font-medium">Belanja Rp {{ number_format($gamifikasi['sisa_target'], 0, ',', '.') }} lagi untuk naik level.</p>
                            @else
                            <p class="text-xs text-amber-400 font-bold uppercase tracking-widest">Level Maksimal Tercapai!</p>
                            @endif
                        </div>
                    </div>

                    <!-- Menu Grid (Quick Access to new pages) -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        <button wire:click="gantiTab('alamat')" class="p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-lg transition-all group text-left">
                            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">📍</div>
                            <h4 class="font-black text-slate-900 uppercase tracking-tight">Buku Alamat</h4>
                            <p class="text-xs text-slate-500 mt-1">Kelola lokasi pengiriman</p>
                        </button>
                        <a href="{{ route('customer.points') }}" class="p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-lg transition-all group">
                            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">💎</div>
                            <h4 class="font-black text-slate-900 uppercase tracking-tight">Riwayat Poin</h4>
                            <p class="text-xs text-slate-500 mt-1">Jejak perolehan & penukaran</p>
                        </a>
                        <a href="{{ route('customer.security') }}" class="p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-lg transition-all group">
                            <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">🛡️</div>
                            <h4 class="font-black text-slate-900 uppercase tracking-tight">Keamanan</h4>
                            <p class="text-xs text-slate-500 mt-1">Ubah sandi & proteksi akun</p>
                        </a>
                    </div>

                    <!-- Recent Orders -->
                    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                            <h3 class="font-black text-slate-900 uppercase tracking-widest text-sm">Pesanan Terbaru</h3>
                            <button wire:click="gantiTab('pesanan')" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Lihat Semua</button>
                        </div>
                        <div class="divide-y divide-slate-50">
                            @forelse($pesananTerakhir as $pesanan)
                            <div class="p-6 hover:bg-slate-50 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-sm">#{{ $pesanan->nomor_faktur }}</h4>
                                        <p class="text-xs text-slate-500 font-medium">{{ $pesanan->dibuat_pada->format('d M Y H:i') }} • {{ $pesanan->detailPesanan->count() }} Item</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 justify-between md:justify-end">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest 
                                        {{ $pesanan->status_pesanan == 'selesai' ? 'bg-emerald-100 text-emerald-600' : 
                                           ($pesanan->status_pesanan == 'dibatalkan' ? 'bg-rose-100 text-rose-600' : 'bg-amber-100 text-amber-600') }}">
                                        {{ $pesanan->status_pesanan }}
                                    </span>
                                    <span class="font-black text-slate-900 text-sm">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @empty
                            <div class="p-12 text-center text-slate-400 italic">Belum ada pesanan terbaru.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                @endif

                <!-- Tab: Pesanan -->
                @if($tabAktif == 'pesanan')
                    <livewire:pesanan.riwayat />
                @endif

                <!-- Tab: Alamat -->
                @if($tabAktif == 'alamat')
                    <livewire:pelanggan.buku-alamat />
                @endif

                <!-- Tab: Pengaturan (General Profile) -->
                @if($tabAktif == 'pengaturan')
                <div class="space-y-8 animate-fade-in">
                    <!-- Profile Form -->
                    <div class="bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm">
                        <h4 class="font-black text-slate-900 uppercase tracking-widest mb-6">Profil Saya</h4>
                        <div class="space-y-6 max-w-xl">
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                                <input type="text" wire:model="nama" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Email (Tidak dapat diubah)</label>
                                <input type="email" wire:model="email" class="w-full bg-slate-100 text-slate-400 border-slate-200 rounded-xl text-sm font-bold cursor-not-allowed" disabled>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Nomor Telepon</label>
                                <input type="text" wire:model="nomor_telepon" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-indigo-500">
                            </div>
                            <button wire:click="simpanProfil" class="px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                
            </div>
        </div>
    </div>
</div>