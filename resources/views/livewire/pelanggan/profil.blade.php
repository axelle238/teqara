<div class="bg-slate-50 min-h-screen py-12">
    <div class="container mx-auto px-6">
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Sidebar Navigasi -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Profil Card -->
                <div class="bg-white rounded-[32px] p-8 border border-slate-100 shadow-sm text-center">
                    <div class="w-20 h-20 rounded-full bg-slate-900 text-white flex items-center justify-center text-3xl font-black mx-auto mb-4 shadow-xl">
                        {{ substr(auth()->user()->nama, 0, 1) }}
                    </div>
                    <h2 class="text-lg font-black text-slate-900">{{ auth()->user()->nama }}</h2>
                    <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">Member {{ $totalBelanja > 10000000 ? 'Gold' : 'Basic' }}</p>
                </div>

                <!-- Menu Menu -->
                <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
                    <nav class="flex flex-col p-4 space-y-2">
                        <button wire:click="gantiTab('ringkasan')" class="flex items-center gap-4 px-6 py-4 rounded-2xl text-xs font-bold uppercase tracking-widest transition-all {{ $tabAktif == 'ringkasan' ? 'bg-indigo-50 text-indigo-600' : 'text-slate-500 hover:bg-slate-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Ringkasan Akun
                        </button>
                        <button wire:click="gantiTab('pesanan')" class="flex items-center gap-4 px-6 py-4 rounded-2xl text-xs font-bold uppercase tracking-widest transition-all {{ $tabAktif == 'pesanan' ? 'bg-indigo-50 text-indigo-600' : 'text-slate-500 hover:bg-slate-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Riwayat Pesanan
                        </button>
                        <button wire:click="gantiTab('pengaturan')" class="flex items-center gap-4 px-6 py-4 rounded-2xl text-xs font-bold uppercase tracking-widest transition-all {{ $tabAktif == 'pengaturan' ? 'bg-indigo-50 text-indigo-600' : 'text-slate-500 hover:bg-slate-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Pengaturan Akun
                        </button>
                        <a href="{{ route('logout') }}" class="flex items-center gap-4 px-6 py-4 rounded-2xl text-xs font-bold uppercase tracking-widest text-rose-500 hover:bg-rose-50 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="lg:col-span-3 space-y-8">
                
                <!-- Tab Ringkasan -->
                <div x-show="$wire.tabAktif === 'ringkasan'" class="space-y-8 animate-in fade-in slide-in-from-bottom-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-indigo-600 p-8 rounded-[32px] text-white shadow-xl shadow-indigo-600/20 relative overflow-hidden">
                            <div class="relative z-10">
                                <p class="text-[10px] font-black text-indigo-200 uppercase tracking-widest mb-2">Total Pengeluaran</p>
                                <h3 class="text-4xl font-black tracking-tighter">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</h3>
                            </div>
                            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        </div>
                        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm flex flex-col justify-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Frekuensi Belanja</p>
                            <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $jumlahPesanan }}x <span class="text-sm text-slate-400 font-bold">Transaksi</span></h3>
                        </div>
                    </div>

                    <div class="bg-white rounded-[32px] border border-slate-100 p-8">
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Aktivitas Terakhir</h3>
                        <div class="space-y-6">
                            @forelse($pesananTerakhir as $p)
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-50 last:border-0 last:pb-0">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center font-black text-slate-400 text-xs">
                                        #{{ substr($p->nomor_faktur, -4) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Pesanan #{{ $p->nomor_faktur }}</p>
                                        <p class="text-xs text-slate-500">{{ $p->created_at->format('d M Y') }} • {{ $p->detailPesanan->count() }} Produk</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $p->status_pesanan === 'selesai' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                        {{ $p->status_pesanan }}
                                    </span>
                                    <a href="{{ route('pesanan.lacak', $p->nomor_faktur) }}" wire:navigate class="px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all">Lacak</a>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-slate-400 text-sm">Belum ada aktivitas belanja.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Tab Pesanan (Full List) -->
                <div x-show="$wire.tabAktif === 'pesanan'" class="bg-white rounded-[32px] border border-slate-100 p-8 animate-in fade-in slide-in-from-bottom-4" style="display: none;">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Semua Transaksi</h3>
                    <!-- Bisa ditambahkan pagination di sini jika pesanan banyak -->
                    <div class="space-y-4">
                        @foreach($pesananTerakhir as $p) <!-- Menggunakan data yang sama utk contoh -->
                        <div class="p-4 border border-slate-100 rounded-2xl hover:border-indigo-200 transition-colors">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-bold text-slate-900">Invoice: {{ $p->nomor_faktur }}</p>
                                    <p class="text-xs text-slate-500 mt-1">Total: Rp {{ number_format($p->total_harga) }}</p>
                                </div>
                                <a href="{{ route('pesanan.lacak', $p->nomor_faktur) }}" class="text-xs font-bold text-indigo-600 hover:underline">Detail</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tab Pengaturan -->
                <div x-show="$wire.tabAktif === 'pengaturan'" class="bg-white rounded-[32px] border border-slate-100 p-8 animate-in fade-in slide-in-from-bottom-4" style="display: none;">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-8">Edit Profil</h3>
                    
                    <form wire:submit.prevent="simpanProfil" class="space-y-6 max-w-lg">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Lengkap</label>
                            <input wire:model="nama" type="text" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nomor Telepon</label>
                            <input wire:model="nomor_telepon" type="text" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 font-bold">
                        </div>
                        <button type="submit" class="px-8 py-3 bg-slate-900 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all">Simpan Perubahan</button>
                    </form>

                    <div class="border-t border-slate-100 my-8 pt-8">
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Keamanan</h3>
                        <form wire:submit.prevent="gantiPassword" class="space-y-6 max-w-lg">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kata Sandi Saat Ini</label>
                                <input wire:model="sandi_lama" type="password" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kata Sandi Baru</label>
                                <input wire:model="sandi_baru" type="password" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Konfirmasi Sandi Baru</label>
                                <input wire:model="sandi_baru_confirmation" type="password" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500">
                            </div>
                            <button type="submit" class="px-8 py-3 bg-white border border-slate-200 text-slate-900 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-50 transition-all">Update Sandi</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>