<div class="space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-slate-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10">
            <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Manajemen <span class="text-indigo-600">Hak Akses</span></h1>
            <p class="text-slate-500 font-bold text-xs uppercase tracking-[0.2em] mt-2">Otorisasi Dinamis & Sinkronisasi Fitur Otomatis</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Sidebar Peran -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider">Daftar Peran</h3>
                    <button wire:click="tambahPeran" class="text-indigo-600 hover:text-indigo-700 font-black text-[10px] uppercase tracking-widest">+ Peran Baru</button>
                </div>

                <div class="space-y-2">
                    @foreach($daftarPeran as $p)
                        <button wire:click="pilihPeran({{ $p->id }})" 
                                class="w-full flex items-center justify-between p-4 rounded-2xl transition-all {{ $peranTerpilihId == $p->id ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">
                            <div class="flex items-center gap-3">
                                <span class="text-lg">{{ $p->slug == 'admin' ? '🛡️' : '👤' }}</span>
                                <span class="text-xs font-black uppercase tracking-wide">{{ $p->nama }}</span>
                            </div>
                            <i class="fa-solid fa-chevron-right text-[10px] opacity-50"></i>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Form Tambah Peran (Inline) -->
            @if($modeTambahPeran)
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 animate-fade-in-up">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Buat Peran Baru</h3>
                <div class="space-y-4">
                    <input wire:model="namaPeran" type="text" placeholder="Nama Peran (misal: Staf Gudang)" class="w-full bg-slate-50 border-none rounded-xl p-4 text-xs font-bold focus:ring-2 focus:ring-indigo-500">
                    <button wire:click="simpanPeran" class="w-full py-4 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all">Simpan Peran</button>
                </div>
            </div>
            @endif
        </div>

        <!-- Matriks Hak Akses -->
        <div class="lg:col-span-8">
            @if($peranTerpilih)
            <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 pb-6 border-b border-slate-50">
                    <div>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-[9px] font-black uppercase tracking-widest">Konfigurasi Akses</span>
                        <h2 class="text-2xl font-black text-slate-900 mt-2">{{ $peranTerpilih->nama }}</h2>
                    </div>
                    <div class="flex gap-3">
                        <button wire:click="sinkronkanFitur" class="px-6 py-3 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-100 transition-all flex items-center gap-2">
                            <i class="fa-solid fa-sync"></i> Sinkron Fitur Baru
                        </button>
                        @if($peranTerpilih->slug !== 'admin')
                        <button wire:click="simpanAkses" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all">
                            Simpan Perubahan
                        </button>
                        @endif
                    </div>
                </div>

                @if($peranTerpilih->slug === 'admin')
                    <div class="py-20 text-center space-y-4">
                        <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto text-3xl">🛡️</div>
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Administrator Utama</h3>
                        <p class="text-slate-500 text-xs max-w-sm mx-auto font-medium">Peran Administrator memiliki akses mutlak ke seluruh fitur dan fungsi sistem tanpa pengecualian.</p>
                    </div>
                @else
                    <div class="space-y-10">
                        @foreach($daftarHakAkses->groupBy('grup_modul') as $modul => $fitur)
                        <div class="space-y-4">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-3">
                                <span>{{ $modul }}</span>
                                <div class="flex-1 h-px bg-slate-100"></div>
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($fitur as $f)
                                <label class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50/50 hover:bg-white border border-transparent hover:border-indigo-100 transition-all cursor-pointer group">
                                    <div class="relative">
                                        <input type="checkbox" wire:model="aksesTerpilih" value="{{ $f->id }}" class="w-5 h-5 rounded-lg border-slate-200 text-indigo-600 focus:ring-indigo-500 transition-all">
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black text-slate-700 uppercase tracking-wide group-hover:text-indigo-600">{{ $f->nama_fitur }}</span>
                                        <span class="text-[9px] font-mono text-slate-400 mt-0.5">{{ $f->kode_rute }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @else
            <div class="bg-white rounded-[2.5rem] p-20 shadow-sm border border-slate-100 text-center space-y-6">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-4xl grayscale">🔑</div>
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Pilih Peran Terlebih Dahulu</h3>
                <p class="text-slate-400 text-sm max-w-xs mx-auto font-medium">Silakan pilih salah satu peran di samping untuk mulai mengatur hak akses spesifik.</p>
            </div>
            @endif
        </div>
    </div>
</div>
