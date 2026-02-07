<div class="bg-slate-50 min-h-screen py-12 font-sans text-slate-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12 animate-fade-in-down">
            <h1 class="text-3xl font-black tracking-tighter uppercase mb-2">Pusat Privasi & <span class="text-indigo-600">Data</span></h1>
            <p class="text-slate-500 font-medium text-sm">Kendali penuh atas data pribadi Anda di ekosistem Teqara.</p>
        </div>

        <div class="space-y-8 animate-fade-in-up">
            
            <!-- Data Export -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col md:flex-row items-center gap-8">
                <div class="w-20 h-20 rounded-2xl bg-indigo-50 flex items-center justify-center text-3xl text-indigo-600 shrink-0">
                    💾
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h3 class="font-black text-lg text-slate-900 mb-2">Unduh Data Saya</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-4">
                        Dapatkan salinan lengkap riwayat pesanan, alamat tersimpan, dan aktivitas akun Anda dalam format JSON yang dapat dibaca mesin.
                    </p>
                    <button wire:click="unduhData" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20">
                        Request Arsip Data
                    </button>
                </div>
            </div>

            <!-- Privacy Policy Content -->
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm prose prose-slate max-w-none">
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-sm mb-6 border-b border-slate-100 pb-4">Kebijakan Privasi Singkat</h3>
                
                <div class="grid md:grid-cols-2 gap-8 text-sm">
                    <div>
                        <h4 class="font-bold text-indigo-600 mb-2">Pengumpulan Data</h4>
                        <p>Kami hanya mengumpulkan data esensial untuk pemrosesan transaksi (Nama, Alamat, Email, No. HP). Data pembayaran diproses langsung oleh Gateway (Midtrans) dan tidak disimpan di server kami.</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-indigo-600 mb-2">Penggunaan Data</h4>
                        <p>Data digunakan eksklusif untuk layanan pengiriman, verifikasi garansi, dan peningkatan layanan. Kami tidak menjual data ke pihak ketiga.</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-indigo-600 mb-2">Keamanan</h4>
                        <p>Seluruh transmisi data dienkripsi menggunakan SSL 256-bit. Password disimpan menggunakan algoritma hashing Bcrypt standar industri.</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-indigo-600 mb-2">Cookie</h4>
                        <p>Kami menggunakan cookie sesi untuk menjaga login Anda tetap aktif dan menyimpan keranjang belanja sementara.</p>
                    </div>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="bg-rose-50 p-8 rounded-[2.5rem] border border-rose-100">
                <h3 class="font-black text-rose-700 uppercase tracking-widest text-sm mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Zona Bahaya
                </h3>
                <p class="text-sm text-rose-600/80 mb-6 font-medium">
                    Menghapus akun bersifat permanen. Seluruh riwayat poin, level membership, dan akses ke pesanan lama akan hilang dan tidak dapat dikembalikan.
                </p>
                
                <div class="max-w-md">
                    <label class="block text-[10px] font-bold text-rose-400 uppercase mb-2">Konfirmasi Penghapusan</label>
                    <div class="flex gap-2">
                        <input wire:model="konfirmasiHapus" type="text" placeholder="Ketik HAPUS" class="flex-1 bg-white border-none rounded-xl text-sm font-bold text-rose-600 placeholder-rose-200 focus:ring-2 focus:ring-rose-500">
                        <button wire:click="hapusAkun" class="px-6 py-3 bg-rose-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-rose-700 transition-all shadow-lg shadow-rose-500/20">
                            Hapus Permanen
                        </button>
                    </div>
                    @error('konfirmasiHapus') <span class="text-[10px] text-rose-500 font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
            </div>

        </div>
    </div>
</div>