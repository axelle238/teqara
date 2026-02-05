<div class="bg-slate-50 min-h-screen">
    
    <!-- Header Profile -->
    <div class="bg-slate-900 pt-20 pb-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-6">
                <div class="relative group">
                    <img class="h-24 w-24 rounded-3xl border-4 border-slate-800 shadow-2xl" src="https://ui-avatars.com/api/?name={{ urlencode($nama) }}&background=0891b2&color=fff&size=128" alt="">
                    <div class="absolute inset-0 bg-black/20 rounded-3xl opacity-0 group-hover:opacity-100 transition flex items-center justify-center cursor-pointer">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tight">{{ $nama }}</h1>
                    <p class="text-slate-400 font-medium">{{ $email }}</p>
                    <div class="flex gap-3 mt-3">
                        <span class="px-3 py-1 rounded-lg bg-slate-800 border border-slate-700 text-xs font-bold text-cyan-400 uppercase tracking-widest">Member Enterprise</span>
                        <span class="px-3 py-1 rounded-lg bg-emerald-900/30 border border-emerald-900 text-xs font-bold text-emerald-400 uppercase tracking-widest">Akun Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-20">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Sidebar Nav -->
            <div class="lg:col-span-1">
                <nav class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-4 space-y-2 sticky top-24">
                    <button wire:click="gantiTab('ringkasan')" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all {{ $tabAktif === 'ringkasan' ? 'bg-cyan-50 text-cyan-700' : 'text-slate-600 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5 {{ $tabAktif === 'ringkasan' ? 'text-cyan-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z"></path></svg>
                        Ringkasan
                    </button>
                    <button wire:click="gantiTab('pesanan')" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all {{ $tabAktif === 'pesanan' ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5 {{ $tabAktif === 'pesanan' ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Pesanan Saya
                    </button>
                    <a href="/buku-alamat" wire:navigate class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Buku Alamat
                    </a>
                    <button wire:click="gantiTab('pengaturan')" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all {{ $tabAktif === 'pengaturan' ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5 {{ $tabAktif === 'pengaturan' ? 'text-slate-900' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan Akun
                    </button>
                    <div class="pt-4 mt-4 border-t border-slate-100">
                        <a href="/logout" class="w-full flex items-center gap-3 px-4 py-2 rounded-xl text-sm font-bold text-red-500 hover:bg-red-50 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar Sesi
                        </a>
                    </div>
                </nav>
            </div>

            <!-- Content Area -->
            <div class="lg:col-span-3 space-y-8 pb-20">
                
                <!-- Tab: Ringkasan -->
                <div x-show="$wire.tabAktif === 'ringkasan'" class="space-y-8">
                    <!-- Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total Pengeluaran</p>
                            <h3 class="text-3xl font-black text-slate-900">{{ 'Rp ' . number_format($totalBelanja, 0, ',', '.') }}</h3>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total Transaksi</p>
                            <h3 class="text-3xl font-black text-slate-900">{{ $jumlahPesanan }} <span class="text-base font-bold text-slate-400">Pesanan</span></h3>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="font-bold text-slate-900">Aktivitas Terakhir</h3>
                            <button wire:click="gantiTab('pesanan')" class="text-xs font-bold text-cyan-600 hover:underline">Lihat Semua</button>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @forelse($pesananTerakhir as $p)
                            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50 transition">
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="text-sm font-black text-slate-900">#{{ $p->nomor_invoice }}</span>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide {{ $p->status_pesanan === 'selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $p->status_pesanan }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500">{{ $p->created_at->format('d M Y') }} • {{ $p->detailPesanan->count() }} Item</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-sm font-bold text-slate-900">{{ 'Rp ' . number_format($p->total_harga, 0, ',', '.') }}</span>
                                    <a href="/pesanan/lacak/{{ $p->nomor_invoice }}" wire:navigate class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:text-cyan-600 hover:border-cyan-200 transition">
                                        Detail
                                    </a>
                                </div>
                            </div>
                            @empty
                            <div class="p-12 text-center text-slate-400 text-sm">Belum ada aktivitas pesanan.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Tab: Pesanan (Full List - Placeholder logic for now shows same list but can be paginated) -->
                <div x-show="$wire.tabAktif === 'pesanan'" class="space-y-6">
                    <h2 class="text-xl font-bold text-slate-900">Riwayat Pesanan Lengkap</h2>
                    <!-- Reuse logic or component for full list here -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 text-center">
                        <p class="text-slate-500 mb-4">Untuk melihat riwayat lengkap dengan filter, kunjungi halaman khusus.</p>
                        <a href="/pesanan/riwayat" wire:navigate class="px-6 py-3 bg-cyan-600 text-white rounded-xl font-bold text-sm hover:bg-cyan-700 transition shadow-lg">Buka Riwayat Pesanan</a>
                    </div>
                </div>

                <!-- Tab: Pengaturan -->
                <div x-show="$wire.tabAktif === 'pengaturan'" class="grid grid-cols-1 gap-8">
                    <!-- Edit Profil -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                        <h3 class="text-lg font-bold text-slate-900 mb-6">Ubah Profil</h3>
                        <form wire:submit.prevent="simpanProfil" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Lengkap</label>
                                    <input wire:model="nama" type="text" class="w-full rounded-xl border-slate-200 focus:border-cyan-500 focus:ring-cyan-500 font-medium">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nomor Telepon</label>
                                    <input wire:model="nomor_telepon" type="text" class="w-full rounded-xl border-slate-200 focus:border-cyan-500 focus:ring-cyan-500 font-medium">
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-slate-800 transition">Simpan Profil</button>
                            </div>
                        </form>
                    </div>

                    <!-- Ganti Password -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 border-t-4 border-t-red-500">
                        <h3 class="text-lg font-bold text-slate-900 mb-6">Keamanan Akun</h3>
                        <form wire:submit.prevent="gantiPassword" class="space-y-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kata Sandi Saat Ini</label>
                                <input wire:model="sandi_lama" type="password" class="w-full rounded-xl border-slate-200 focus:border-red-500 focus:ring-red-500">
                                @error('sandi_lama') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kata Sandi Baru</label>
                                    <input wire:model="sandi_baru" type="password" class="w-full rounded-xl border-slate-200 focus:border-red-500 focus:ring-red-500">
                                    @error('sandi_baru') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Konfirmasi Sandi Baru</label>
                                    <input wire:model="sandi_baru_confirmation" type="password" class="w-full rounded-xl border-slate-200 focus:border-red-500 focus:ring-red-500">
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-xl font-bold text-sm hover:bg-red-700 transition shadow-lg shadow-red-600/20">Update Keamanan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>