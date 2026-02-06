<div class="animate-in fade-in duration-500">
    
    @if(!$tampilkanForm)
        <!-- TAMPILAN 1: DAFTAR KONTEN (FULL PAGE LIST) -->
        <div class="space-y-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="space-y-1">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">KONTEN VISUAL TOKO</h1>
                    <p class="text-slate-500 font-medium">Kelola elemen pemasaran dan navigasi visual halaman publik.</p>
                </div>
                <button wire:click="tambahBlok" class="flex items-center gap-3 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-indigo-600/20 transition-all active:scale-95">
                    <i class="fa-solid fa-plus text-lg"></i> TAMBAH BLOK BARU
                </button>
            </div>

            <!-- Grid Konten -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                @forelse($daftarKonten as $konten)
                <div class="group bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden hover:shadow-2xl hover:border-indigo-200 transition-all duration-500">
                    <div class="relative h-56 bg-slate-100 overflow-hidden">
                        <img src="{{ $konten->gambar ?? 'https://via.placeholder.com/800x400?text=Tanpa+Gambar' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6 text-white space-y-2">
                            <span class="inline-block px-3 py-1 rounded-full bg-indigo-500 text-[9px] font-black uppercase tracking-[0.2em] border border-white/20">
                                {{ str_replace('_', ' ', $konten->bagian) }}
                            </span>
                            <h3 class="font-black text-xl leading-tight truncate">{{ $konten->judul }}</h3>
                        </div>
                    </div>

                    <div class="p-8 space-y-6">
                        <p class="text-slate-500 text-sm font-medium leading-relaxed line-clamp-2 h-10">{{ $konten->deskripsi }}</p>
                        
                        <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                            <div class="flex gap-3">
                                <button wire:click="editBlok({{ $konten->id }})" class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-all shadow-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button wire:click="hapusBlok({{ $konten->id }})" wire:confirm="Hapus blok konten ini selamanya?" class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-all shadow-sm">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Urutan</span>
                                <span class="text-lg font-black text-slate-800">{{ $konten->urutan }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center bg-white rounded-[50px] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-box-open text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Belum Ada Konten</h3>
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Mulai dengan menambahkan blok visual pertama Anda.</p>
                </div>
                @endforelse
            </div>
        </div>
    @else
        <!-- TAMPILAN 2: FORMULIR EDITOR (FULL PAGE FORM) -->
        <div class="space-y-8 animate-in slide-in-from-right-8 duration-500">
            <!-- Header Editor -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="flex items-center gap-6">
                    <button wire:click="batal" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                    </button>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">{{ $blokTerpilihId ? 'Ubah Konfigurasi Blok' : 'Registrasi Blok Baru' }}</h1>
                        <p class="text-slate-500 font-medium">Sesuaikan parameter visual dan interaksi elemen toko Anda.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-3xl text-sm font-black hover:bg-slate-100 transition-all">BATAL</button>
                    <button wire:click="simpanBlok" class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-3xl text-sm font-black shadow-xl shadow-indigo-600/20 transition-all active:scale-95">SIMPAN PERUBAHAN</button>
                </div>
            </div>

            <!-- Form Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kolom Kiri: Input Data -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10">
                        <!-- Tipe Bagian -->
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Klasifikasi Penempatan</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="bagian" value="hero_section" class="peer sr-only">
                                    <div class="p-6 rounded-3xl border-2 border-slate-50 text-center transition-all peer-checked:bg-indigo-50 peer-checked:border-indigo-500 hover:bg-slate-50">
                                        <i class="fa-solid fa-display text-2xl mb-3 text-slate-300 peer-checked:text-indigo-600 transition-colors"></i>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 peer-checked:text-indigo-700">Hero Utama</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="bagian" value="promo_banner" class="peer sr-only">
                                    <div class="p-6 rounded-3xl border-2 border-slate-50 text-center transition-all peer-checked:bg-fuchsia-50 peer-checked:border-fuchsia-500 hover:bg-slate-50">
                                        <i class="fa-solid fa-ticket-simple text-2xl mb-3 text-slate-300 peer-checked:text-fuchsia-600 transition-colors"></i>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 peer-checked:text-fuchsia-700">Banner Promo</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="bagian" value="fitur_unggulan" class="peer sr-only">
                                    <div class="p-6 rounded-3xl border-2 border-slate-50 text-center transition-all peer-checked:bg-cyan-50 peer-checked:border-cyan-500 hover:bg-slate-50">
                                        <i class="fa-solid fa-gem text-2xl mb-3 text-slate-300 peer-checked:text-cyan-600 transition-colors"></i>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 peer-checked:text-cyan-700">Fitur Layanan</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Judul & Deskripsi -->
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Judul Narasi</label>
                                <input wire:model="judul" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300" placeholder="Masukkan judul yang memikat...">
                                @error('judul') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Deskripsi Penjelas</label>
                                <textarea wire:model="deskripsi" rows="4" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-600 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300" placeholder="Berikan informasi lebih detail mengenai blok ini..."></textarea>
                            </div>
                        </div>

                        <!-- Aksi Tombol -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Label Tombol</label>
                                <input wire:model="teks_tombol" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10" placeholder="Cth: Belanja Sekarang">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">URL Navigasi</label>
                                <input wire:model="tautan_tujuan" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10" placeholder="Cth: /katalog">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Media & Preview -->
                <div class="space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Aset Visual Utama</label>
                            <div class="relative aspect-video bg-slate-50 rounded-3xl border-4 border-dashed border-slate-100 flex items-center justify-center overflow-hidden group hover:border-indigo-200 transition-all">
                                @if($gambar_baru)
                                    <img src="{{ $gambar_baru->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif($gambar_lama)
                                    <img src="{{ asset($gambar_lama) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-center space-y-3">
                                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-slate-200 group-hover:text-indigo-400 transition-colors"></i>
                                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Pilih Gambar</p>
                                    </div>
                                @endif
                                <input type="file" wire:model="gambar_baru" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            @error('gambar_baru') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest">{{ $message }}</span> @enderror
                            <p class="text-[10px] font-bold text-slate-400 leading-relaxed italic text-center">*Gunakan format 16:9 untuk hasil terbaik di Hero Utama.</p>
                        </div>

                        <div class="space-y-4 pt-8 border-t border-slate-50">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Prioritas Tampilan</label>
                            <div class="flex items-center gap-6">
                                <input wire:model="urutan" type="number" class="w-24 bg-slate-50 border-none rounded-2xl px-6 py-4 text-center text-lg font-black text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                                <p class="text-[10px] font-bold text-slate-400 uppercase leading-snug tracking-widest">Nilai lebih kecil akan tampil paling awal.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Informatif -->
                    <div class="bg-indigo-600 p-10 rounded-[50px] text-white shadow-2xl shadow-indigo-500/30 space-y-4 relative overflow-hidden group">
                        <i class="fa-solid fa-circle-info text-4xl opacity-20 absolute -right-4 -top-4 group-hover:scale-150 transition-transform duration-1000"></i>
                        <h4 class="text-lg font-black uppercase tracking-tight">Kiat Enterprise</h4>
                        <p class="text-xs font-bold text-indigo-100 leading-relaxed italic opacity-80">
                            "Konten visual yang konsisten dan berkualitas tinggi meningkatkan kepercayaan pelanggan hingga 40%. Pastikan setiap gambar memiliki pencahayaan yang optimal."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
