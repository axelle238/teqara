<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Pusat <span class="text-slate-500">Kontrol Sistem</span></h1>
            <p class="text-slate-500 font-medium text-sm mt-1">Konfigurasi inti operasional platform Teqara Enterprise.</p>
        </div>
        <div class="flex gap-2">
            <button wire:click="simpan" class="flex items-center gap-3 px-8 py-3 bg-indigo-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                <i class="fa-solid fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- SIDEBAR NAV -->
        <div class="space-y-2">
            @foreach(['umum' => 'Identitas & Umum', 'bisnis' => 'Parameter Bisnis', 'seo' => 'SEO Engine', 'pemeliharaan' => 'Mode Pemeliharaan'] as $key => $label)
            <button wire:click="setTab('{{ $key }}')" 
                    class="w-full text-left px-6 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ $activeTab === $key ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-500 hover:bg-slate-50 hover:text-slate-900 border border-slate-200' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>

        <!-- FORM CONTENT -->
        <div class="lg:col-span-3 bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-10 min-h-[500px]">
            
            @if($activeTab === 'umum')
            <div class="space-y-8 animate-in slide-in-from-right-4 duration-500">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-6">Identitas Platform</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Aplikasi</label>
                        <input type="text" wire:model="nama_situs" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-lg font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tagline / Deskripsi</label>
                        <input type="text" wire:model="deskripsi_situs" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                    </div>
                </div>

                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex items-center gap-6">
                    <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center border border-slate-200 text-slate-300 text-2xl">
                        <i class="fa-solid fa-image"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-900 text-sm">Logo Perusahaan</h4>
                        <p class="text-xs text-slate-500 mt-1 mb-3">Format PNG/SVG, Maks 2MB. Digunakan di header dan email.</p>
                        <input type="file" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:uppercase file:bg-indigo-600 file:text-white hover:file:bg-indigo-700">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t border-slate-100">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Dukungan (Support)</label>
                        <input type="email" wire:model="email_dukungan" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Kontak Telepon / WA</label>
                        <input type="text" wire:model="telepon_dukungan" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                    </div>
                </div>

                <div class="space-y-2 pt-6 border-t border-slate-100">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Alamat Fisik Perusahaan</label>
                    <textarea wire:model="alamat_fisik" rows="2" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10"></textarea>
                </div>

                <div class="space-y-4 pt-6 border-t border-slate-100">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Tautan Sosial Media</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Facebook URL</label>
                            <input type="text" wire:model="sosial_facebook" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Instagram URL</label>
                            <input type="text" wire:model="sosial_instagram" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Twitter / X URL</label>
                            <input type="text" wire:model="sosial_twitter" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($activeTab === 'bisnis')
            <div class="space-y-8 animate-in slide-in-from-right-4 duration-500">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-6">Parameter Bisnis</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Pajak PPN (%)</label>
                        <div class="relative">
                            <input type="number" wire:model="pajak_persen" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-lg font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                            <span class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 font-black">%</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Mata Uang Utama</label>
                        <select wire:model="mata_uang" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10">
                            <option value="IDR">IDR - Rupiah Indonesia</option>
                            <option value="USD">USD - US Dollar</option>
                        </select>
                    </div>
                </div>
            </div>
            @endif

            @if($activeTab === 'seo')
            <div class="space-y-8 animate-in slide-in-from-right-4 duration-500">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-6">Search Engine Optimization (SEO)</h2>
                
                <div class="bg-indigo-50 border-l-4 border-indigo-500 p-6 rounded-r-xl mb-8">
                    <div class="flex items-start gap-4">
                        <i class="fa-brands fa-google text-indigo-600 text-xl mt-1"></i>
                        <div>
                            <h4 class="font-black text-indigo-800 uppercase tracking-wide text-sm">Global Meta Data</h4>
                            <p class="text-indigo-700 text-sm mt-1">Pengaturan ini akan diterapkan pada halaman beranda dan sebagai default jika halaman spesifik tidak memiliki meta data.</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Meta Keywords</label>
                        <textarea wire:model="seo_keywords" rows="3" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10" placeholder="ecommerce, jual beli, toko online..."></textarea>
                        <p class="text-[10px] text-slate-400 px-1">* Pisahkan dengan koma.</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Meta Description</label>
                        <textarea wire:model="seo_description" rows="4" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-800 focus:ring-4 focus:ring-indigo-500/10"></textarea>
                    </div>
                </div>
            </div>
            @endif

            @if($activeTab === 'pemeliharaan')
            <div class="space-y-8 animate-in slide-in-from-right-4 duration-500">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-6">Mode Pemeliharaan</h2>
                
                <div class="bg-amber-50 border-l-4 border-amber-500 p-6 rounded-r-xl">
                    <div class="flex items-start gap-4">
                        <i class="fa-solid fa-triangle-exclamation text-amber-600 text-xl mt-1"></i>
                        <div>
                            <h4 class="font-black text-amber-800 uppercase tracking-wide text-sm">Peringatan Keras</h4>
                            <p class="text-amber-700 text-sm mt-1">Mengaktifkan mode ini akan menutup akses publik ke toko. Hanya admin yang dapat masuk.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between bg-slate-50 p-6 rounded-3xl">
                    <div>
                        <span class="block font-bold text-slate-900">Status Toko</span>
                        <span class="text-xs text-slate-500">Saat ini: <span class="text-emerald-600 font-black uppercase">Online</span></span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer">
                        <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-7 after:w-7 after:transition-all peer-checked:bg-rose-600"></div>
                    </label>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
