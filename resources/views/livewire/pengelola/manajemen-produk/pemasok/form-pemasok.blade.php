<div class="max-w-5xl mx-auto pb-20 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-3 py-1 rounded-full bg-cyan-50 text-cyan-700 text-[10px] font-black uppercase tracking-widest border border-cyan-100">Logistic & Supply Chain</span>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $pemasokId ? 'Edit Profil Vendor' : 'Registrasi Vendor Baru' }}</h1>
            <p class="text-slate-500 font-medium mt-1">Lengkapi data administrasi dan kontak untuk mitra pemasok resmi.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('pengelola.logistik.pemasok') }}" wire:navigate class="px-6 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all shadow-sm">
                Batal
            </a>
            <button wire:click="simpan" class="px-8 py-3 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-slate-800 shadow-lg shadow-slate-900/20 transition-all active:scale-95 flex items-center gap-2">
                <i class="fa-solid fa-save"></i> Simpan Data
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Kolom Kiri: Identitas Utama -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Data Perusahaan -->
            <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-50 rounded-bl-[100px] -mr-10 -mt-10"></div>
                
                <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-building text-cyan-500"></i> Identitas Korporat
                </h3>
                
                <div class="space-y-6 relative z-10">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Nama Perusahaan / Vendor</label>
                        <input wire:model="nama_perusahaan" type="text" class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-slate-900 font-bold focus:border-cyan-500 focus:ring-cyan-500 px-4 py-3" placeholder="PT. Teqara Supply Indonesia">
                        @error('nama_perusahaan') <span class="text-xs text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Kode Vendor (Auto)</label>
                            <input wire:model="kode_pemasok" type="text" class="w-full rounded-2xl border-slate-200 bg-slate-100 text-slate-500 font-mono font-bold px-4 py-3 cursor-not-allowed" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">NPWP (Pajak)</label>
                            <input wire:model="npwp" type="text" class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-slate-900 font-medium focus:border-cyan-500 focus:ring-cyan-500 px-4 py-3" placeholder="00.000.000.0-000.000">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Alamat Kantor Pusat</label>
                        <textarea wire:model="alamat" rows="3" class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-slate-900 font-medium focus:border-cyan-500 focus:ring-cyan-500 px-4 py-3"></textarea>
                    </div>
                </div>
            </div>

            <!-- Kontak PIC -->
            <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100">
                <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-address-card text-indigo-500"></i> Kontak & PIC
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Penanggung Jawab (PIC)</label>
                        <input wire:model="penanggung_jawab" type="text" class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-slate-900 font-bold focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Jabatan</label>
                        <input type="text" class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-slate-900 font-medium focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3" placeholder="Opsional">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Nomor Telepon / WA</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-slate-400"><i class="fa-solid fa-phone"></i></span>
                            <input wire:model="telepon" type="text" class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-slate-900 font-bold focus:border-indigo-500 focus:ring-indigo-500 pl-10 pr-4 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Email Resmi</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-slate-400"><i class="fa-solid fa-envelope"></i></span>
                            <input wire:model="email" type="email" class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-slate-900 font-medium focus:border-indigo-500 focus:ring-indigo-500 pl-10 pr-4 py-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Status & Meta -->
        <div class="space-y-8">
            <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100">
                <h3 class="text-lg font-black text-slate-900 mb-6">Status Kerjasama</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Status Aktif</label>
                        <select wire:model="status" class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-slate-900 font-bold focus:border-cyan-500 focus:ring-cyan-500 px-4 py-3">
                            <option value="aktif">✅ Aktif Beroperasi</option>
                            <option value="nonaktif">❌ Non-Aktif / Blacklist</option>
                            <option value="hold">⚠️ Ditangguhkan (Hold)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Website / Katalog Online</label>
                        <div class="flex gap-2">
                            <span class="flex items-center justify-center w-12 bg-slate-100 rounded-xl border border-slate-200 text-slate-500"><i class="fa-solid fa-globe"></i></span>
                            <input wire:model="website" type="text" class="flex-1 rounded-2xl border-slate-200 bg-slate-50/50 text-slate-900 font-medium focus:border-cyan-500 focus:ring-cyan-500 px-4 py-3" placeholder="https://">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Catatan Internal</label>
                        <textarea wire:model="catatan" rows="4" class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-slate-900 text-sm focus:border-cyan-500 focus:ring-cyan-500 px-4 py-3" placeholder="Catatan khusus mengenai vendor ini..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Info Tambahan -->
            <div class="bg-indigo-50 p-6 rounded-[32px] border border-indigo-100">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-indigo-600 shadow-sm shrink-0">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-indigo-900 text-sm mb-1">Panduan Vendor</h4>
                        <p class="text-xs text-indigo-700 leading-relaxed">
                            Pastikan data NPWP valid untuk keperluan faktur pajak. Vendor yang di-blacklist tidak akan muncul di form Purchase Order (PO).
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
