<div class="bg-slate-50 min-h-screen py-20 relative overflow-hidden">
    <!-- Decorative Accents -->
    <div class="absolute top-0 left-0 w-full h-[500px] bg-gradient-to-b from-indigo-600/5 to-transparent pointer-events-none"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-500/10 blur-[100px] rounded-full"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="flex flex-col lg:flex-row gap-12 items-start">
            
            <!-- Sidebar Navigasi -->
            <aside class="w-full lg:w-80 shrink-0 space-y-6 lg:sticky lg:top-32">
                <div class="bg-white rounded-[48px] p-8 border border-white shadow-xl shadow-slate-200/50">
                    <div class="flex flex-col items-center text-center mb-10">
                        <div class="relative group cursor-pointer mb-6">
                            <div class="w-32 h-32 rounded-[40px] bg-indigo-50 border-4 border-white shadow-2xl overflow-hidden relative">
                                @if($foto_baru)
                                    <img src="{{ $foto_baru->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif($foto_profil)
                                    <img src="{{ $foto_profil }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-4xl font-black text-indigo-300">
                                        {{ substr($nama, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <input type="file" wire:model="foto_baru" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-indigo-600 rounded-2xl border-4 border-white flex items-center justify-center text-white shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                        </div>
                        <h2 class="text-xl font-black text-slate-900 tracking-tight uppercase">{{ $nama }}</h2>
                        <span class="px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-widest mt-2">Level: {{ $gamifikasi['level'] }}</span>
                    </div>

                    <nav class="space-y-2">
                        @php
                            $menus = [
                                'ringkasan' => ['label' => 'Ringkasan', 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16'],
                                'pesanan' => ['label' => 'Riwayat Pesanan', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
                                'alamat' => ['label' => 'Buku Alamat', 'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'],
                                'loyalitas' => ['label' => 'Pusat Loyalitas', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                'pengaturan' => ['label' => 'Pengaturan Akun', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
                            ];
                        @endphp

                        @foreach($menus as $key => $menu)
                        <button 
                            wire:click="gantiTab('{{ $key }}')"
                            class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ $tabAktif === $key ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }}"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="{{ $menu['icon'] }}"></path></svg>
                            {{ $menu['label'] }}
                        </button>
                        @endforeach
                        
                        <a href="/keluar" class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl text-xs font-black uppercase tracking-widest text-rose-500 hover:bg-rose-50 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M17 16l4-4m0 0l-4-4m4-4H7m6 4v1h-2v4a2 2 0 002 2h6a2 2 0 002-2V9a2 2 0 00-2-2h-6"></path></svg>
                            Logout Sistem
                        </a>
                    </nav>
                </div>
            </aside>

            <!-- Konten Utama -->
            <main class="flex-1 w-full space-y-10 animate-in fade-in slide-in-from-right-8 duration-700">
                
                @if($tabAktif === 'ringkasan')
                    <!-- Dashboard Ringkasan -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-8 rounded-[40px] border border-white shadow-xl shadow-slate-200/50 flex flex-col justify-between">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-4">Total Belanja</span>
                            <p class="text-3xl font-black text-slate-900 tracking-tighter leading-none">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-indigo-600 p-8 rounded-[40px] shadow-xl shadow-indigo-600/20 text-white flex flex-col justify-between relative overflow-hidden">
                            <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                            <span class="text-[10px] font-black text-white/70 uppercase tracking-widest block mb-4">Saldo Poin</span>
                            <p class="text-3xl font-black tracking-tighter leading-none">{{ number_format($gamifikasi['poin']) }} POIN</p>
                        </div>
                        <div class="bg-emerald-500 p-8 rounded-[40px] shadow-xl shadow-emerald-500/20 text-white flex flex-col justify-between relative overflow-hidden">
                            <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                            <span class="text-[10px] font-black text-white/70 uppercase tracking-widest block mb-4">Unit Pesanan</span>
                            <p class="text-3xl font-black tracking-tighter leading-none">{{ $jumlahPesanan }} TRX</p>
                        </div>
                    </div>

                    <!-- Level Progress -->
                    <div class="bg-white rounded-[48px] p-10 border border-white shadow-xl shadow-slate-200/50">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                            <div class="space-y-1">
                                <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase">Progresi Level Member</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Akumulasi untuk upgrade ke {{ $gamifikasi['next_level'] }}</p>
                            </div>
                            <span class="px-6 py-2 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg">{{ $gamifikasi['level'] }} STATUS</span>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="h-4 w-full bg-slate-50 rounded-full overflow-hidden border border-slate-100 p-1">
                                <div class="h-full bg-gradient-to-r from-indigo-600 to-cyan-500 rounded-full transition-all duration-1000" style="width: {{ $gamifikasi['progress'] }}%"></div>
                            </div>
                            <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest">
                                <span class="text-indigo-600">{{ $gamifikasi['level'] }}</span>
                                <span class="text-slate-400">Target: Rp {{ number_format($gamifikasi['sisa_target'], 0, ',', '.') }} Lagi</span>
                                <span class="text-indigo-600">{{ $gamifikasi['next_level'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="bg-white rounded-[48px] p-10 border border-white shadow-xl shadow-slate-200/50">
                        <div class="flex items-center justify-between mb-10">
                            <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase">Pesanan Terakhir</h3>
                            <button wire:click="gantiTab('pesanan')" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline">Lihat Semua</button>
                        </div>
                        
                        <div class="space-y-6">
                            @forelse($pesananTerakhir as $p)
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-6 rounded-3xl bg-slate-50 border border-slate-100 group hover:border-indigo-200 transition-all">
                                <div class="flex items-center gap-6">
                                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center p-3 border border-slate-100 shadow-sm">
                                        @if($p->detailPesanan->first())
                                            <img src="{{ $p->detailPesanan->first()->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply">
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-slate-900 uppercase tracking-tight">#{{ $p->nomor_faktur }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $p->created_at->translatedFormat('d F Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-8">
                                    <div class="text-right">
                                        <p class="text-sm font-black text-slate-900 leading-none">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $p->detailPesanan->count() }} Unit Produk</p>
                                    </div>
                                    <span class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest 
                                        {{ $p->status_pesanan === 'selesai' ? 'bg-emerald-100 text-emerald-600' : 
                                           ($p->status_pesanan === 'menunggu' ? 'bg-amber-100 text-amber-600' : 'bg-indigo-100 text-indigo-600') }}">
                                        {{ str_replace('_', ' ', $p->status_pesanan) }}
                                    </span>
                                </div>
                            </div>
                            @empty
                            <p class="text-center py-10 text-slate-400 font-bold uppercase tracking-widest text-xs">Belum ada riwayat transaksi.</p>
                            @endforelse
                        </div>
                    </div>
                @endif

                @if($tabAktif === 'alamat')
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                        <div class="space-y-1">
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight uppercase leading-none">Buku Alamat</h3>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Manajemen Destinasi Pengiriman Unit</p>
                        </div>
                        <button wire:click="tambahAlamat" class="px-8 py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl hover:bg-indigo-600 transition-all">Tambah Alamat Baru</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @forelse($alamat as $a)
                        <div class="bg-white rounded-[40px] p-8 border border-white shadow-xl shadow-slate-200/50 relative group {{ $a->is_utama ? 'ring-2 ring-indigo-600 ring-offset-4 ring-offset-slate-50' : '' }}">
                            @if($a->is_utama)
                                <span class="absolute -top-3 left-8 px-4 py-1 bg-indigo-600 text-white text-[9px] font-black uppercase tracking-widest rounded-lg shadow-lg shadow-indigo-600/20">Alamat Utama</span>
                            @endif
                            <div class="flex justify-between items-start mb-6">
                                <span class="px-3 py-1 bg-slate-50 rounded-lg text-[10px] font-black uppercase tracking-widest text-slate-500">{{ $a->label_alamat }}</span>
                                <div class="flex gap-2">
                                    <button wire:click="editAlamat({{ $a->id }})" class="p-2 bg-slate-50 text-slate-400 hover:text-indigo-600 rounded-xl transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <button wire:click="hapusAlamat({{ $a->id }})" wire:confirm="Hapus alamat ini?" class="p-2 bg-slate-50 text-slate-400 hover:text-rose-500 rounded-xl transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <h4 class="text-lg font-black text-slate-900 mb-1 uppercase leading-none">{{ $a->penerima }}</h4>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">{{ $a->telepon }}</p>
                            <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8">{{ $a->alamat_lengkap }}, {{ $a->kota }}, {{ $a->kode_pos }}</p>
                            
                            @if(!$a->is_utama)
                                <button wire:click="setUtama({{ $a->id }})" class="w-full py-3 bg-slate-50 text-slate-500 hover:bg-indigo-600 hover:text-white rounded-2xl text-[9px] font-black uppercase tracking-widest transition-all">Jadikan Alamat Utama</button>
                            @endif
                        </div>
                        @empty
                        <div class="col-span-full py-20 text-center bg-white rounded-[48px] border-4 border-dashed border-slate-100">
                            <p class="text-slate-400 font-black uppercase tracking-widest text-xs">Belum ada alamat tersimpan.</p>
                        </div>
                        @endforelse
                    </div>
                @endif

                @if($tabAktif === 'loyalitas')
                    <div class="bg-indigo-600 rounded-[56px] p-12 text-white shadow-2xl shadow-indigo-600/30 relative overflow-hidden mb-12">
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-cyan-400/20 rounded-full blur-3xl"></div>
                        
                        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-12">
                            <div class="space-y-6 text-center md:text-left">
                                <span class="px-5 py-2 bg-white/20 backdrop-blur-md rounded-2xl text-[10px] font-black uppercase tracking-[0.3em]">Tier: {{ $gamifikasi['level'] }}</span>
                                <h3 class="text-5xl font-black tracking-tighter uppercase leading-none">{{ number_format($gamifikasi['poin']) }} <span class="text-cyan-300">Poin</span></h3>
                                <p class="text-white/70 font-medium text-lg max-w-sm">Dapatkan 1 poin setiap belanja kelipatan Rp 10.000 untuk meningkatkan level keuntungan Anda.</p>
                            </div>
                            <div class="w-48 h-48 bg-white/10 backdrop-blur-xl rounded-[48px] border border-white/20 p-8 flex flex-col items-center justify-center shadow-2xl">
                                <span class="text-6xl mb-4">💎</span>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-cyan-300">Member Aktif</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-[48px] p-10 border border-white shadow-xl shadow-slate-200/50">
                        <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase mb-10">Riwayat Mutasi Poin</h3>
                        <div class="space-y-4">
                            @forelse($this->riwayatPoin as $r)
                            <div class="flex items-center justify-between p-6 rounded-3xl bg-slate-50 border border-slate-100">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl {{ $r->jumlah > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                        {{ $r->jumlah > 0 ? '↑' : '↓' }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900 uppercase tracking-tight">{{ $r->keterangan }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $r->created_at->translatedFormat('d F Y • H:i') }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-black {{ $r->jumlah > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $r->jumlah > 0 ? '+' : '' }}{{ number_format($r->jumlah) }}
                                </span>
                            </div>
                            @empty
                            <p class="text-center py-10 text-slate-400 font-bold uppercase tracking-widest text-xs">Belum ada riwayat mutasi poin.</p>
                            @endforelse
                        </div>
                    </div>
                @endif

                @if($tabAktif === 'pengaturan')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <!-- Update Profile -->
                        <div class="bg-white rounded-[48px] p-10 border border-white shadow-xl shadow-slate-200/50 space-y-8">
                            <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase">Identitas Diri</h3>
                            <form wire:submit.prevent="simpanProfil" class="space-y-6">
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Lengkap</label>
                                    <input wire:model="nama" type="text" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold focus:ring-4 focus:ring-indigo-500/10">
                                    @error('nama') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-2 opacity-50">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Aktif (Locked)</label>
                                    <input wire:model="email" type="email" disabled class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold cursor-not-allowed">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nomor Telepon</label>
                                    <input wire:model="nomor_telepon" type="text" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold focus:ring-4 focus:ring-indigo-500/10">
                                </div>
                                <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-[24px] font-black text-xs uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl">Simpan Perubahan</button>
                            </form>
                        </div>

                        <!-- Update Password -->
                        <div class="bg-white rounded-[48px] p-10 border border-white shadow-xl shadow-slate-200/50 space-y-8">
                            <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase">Otoritas Keamanan</h3>
                            <form wire:submit.prevent="gantiPassword" class="space-y-6">
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Sandi Saat Ini</label>
                                    <input wire:model="sandi_lama" type="password" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold focus:ring-4 focus:ring-indigo-500/10">
                                    @error('sandi_lama') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Sandi Baru</label>
                                    <input wire:model="sandi_baru" type="password" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold focus:ring-4 focus:ring-indigo-500/10">
                                    @error('sandi_baru') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Konfirmasi Sandi Baru</label>
                                    <input wire:model="sandi_baru_confirmation" type="password" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold focus:ring-4 focus:ring-indigo-500/10">
                                </div>
                                <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-[24px] font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20">Aktivasi Sandi Baru</button>
                            </form>
                        </div>
                    </div>
                @endif

            </main>
        </div>
    </div>

    <!-- Slide-over: Alamat Form -->
    <x-ui.panel-geser id="form-alamat" judul="Konfigurasi Alamat Distribusi">
        <form wire:submit.prevent="simpanAlamat" class="space-y-8 p-2">
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Label Alamat (Contoh: Kantor, Rumah)</label>
                <input wire:model="label_alamat" type="text" class="w-full bg-slate-50 border-none rounded-xl p-4 font-bold focus:ring-2 focus:ring-indigo-500">
                @error('label_alamat') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Penerima</label>
                    <input wire:model="penerima" type="text" class="w-full bg-slate-50 border-none rounded-xl p-4 font-bold focus:ring-2 focus:ring-indigo-500">
                    @error('penerima') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nomor Telepon</label>
                    <input wire:model="telepon" type="text" class="w-full bg-slate-50 border-none rounded-xl p-4 font-bold focus:ring-2 focus:ring-indigo-500">
                    @error('telepon') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Alamat Lengkap</label>
                <textarea wire:model="alamat_lengkap" rows="4" class="w-full bg-slate-50 border-none rounded-xl p-4 font-bold focus:ring-2 focus:ring-indigo-500"></textarea>
                @error('alamat_lengkap') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kota</label>
                    <input wire:model="kota" type="text" class="w-full bg-slate-50 border-none rounded-xl p-4 font-bold focus:ring-2 focus:ring-indigo-500">
                    @error('kota') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kode Pos</label>
                    <input wire:model="kode_pos" type="text" class="w-full bg-slate-50 border-none rounded-xl p-4 font-bold focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl">
                    SIMPAN ALAMAT DISTRIBUSI
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>
