<div class="space-y-8 animate-fade-in pb-20">
    
    <!-- Tab Navigasi -->
    <div class="bg-white rounded-[2rem] p-2 border border-slate-100 shadow-sm flex flex-wrap gap-2">
        <button wire:click="gantiTab('umum')" class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $tabAktif == 'umum' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-500 hover:bg-slate-50' }}">
            Identitas
        </button>
        <button wire:click="gantiTab('tampilan')" class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $tabAktif == 'tampilan' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-500 hover:bg-slate-50' }}">
            Tampilan & Logo
        </button>
        <button wire:click="gantiTab('kontak')" class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $tabAktif == 'kontak' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-500 hover:bg-slate-50' }}">
            Kontak & Sosial
        </button>
        <button wire:click="gantiTab('seo')" class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $tabAktif == 'seo' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-500 hover:bg-slate-50' }}">
            SEO & Metadata
        </button>
    </div>

    <!-- Konten Tab -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-xl relative overflow-hidden">
        
        <!-- Tab: Identitas Umum -->
        @if($tabAktif == 'umum')
        <div class="space-y-8 animate-fade-in">
            <div class="max-w-2xl">
                <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-6">Identitas Situs</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Aplikasi / Toko</label>
                        <input type="text" wire:model="nama_situs" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Singkat</label>
                        <textarea wire:model="deskripsi_situs" rows="4" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 transition-all"></textarea>
                        <p class="text-[10px] text-slate-400 mt-2">Digunakan untuk footer dan meta deskripsi default.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tab: Tampilan -->
        @if($tabAktif == 'tampilan')
        <div class="space-y-8 animate-fade-in">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-6">Logo Utama</h2>
                    <div class="bg-slate-50 rounded-3xl p-8 text-center border-2 border-dashed border-slate-200 hover:border-indigo-300 transition-colors relative group">
                        @if($logo_baru)
                            <img src="{{ $logo_baru->temporaryUrl() }}" class="h-24 mx-auto mb-4 object-contain">
                        @elseif($logo_url)
                            <img src="{{ $logo_url }}" class="h-24 mx-auto mb-4 object-contain">
                        @else
                            <div class="h-24 w-24 bg-slate-200 rounded-full mx-auto mb-4 flex items-center justify-center text-slate-400 text-2xl"><i class="fa-solid fa-image"></i></div>
                        @endif
                        
                        <label class="cursor-pointer">
                            <span class="px-6 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all shadow-sm">Ganti Logo</span>
                            <input type="file" wire:model="logo_baru" class="hidden" accept="image/*">
                        </label>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-6">Favicon</h2>
                    <div class="bg-slate-50 rounded-3xl p-8 text-center border-2 border-dashed border-slate-200 hover:border-indigo-300 transition-colors relative group">
                        @if($favicon_baru)
                            <img src="{{ $favicon_baru->temporaryUrl() }}" class="h-16 w-16 mx-auto mb-4 object-contain">
                        @elseif($favicon_url)
                            <img src="{{ $favicon_url }}" class="h-16 w-16 mx-auto mb-4 object-contain">
                        @else
                            <div class="h-16 w-16 bg-slate-200 rounded-xl mx-auto mb-4 flex items-center justify-center text-slate-400 text-xl"><i class="fa-solid fa-star"></i></div>
                        @endif
                        
                        <label class="cursor-pointer">
                            <span class="px-6 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all shadow-sm">Ganti Icon</span>
                            <input type="file" wire:model="favicon_baru" class="hidden" accept="image/png, image/x-icon">
                        </label>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tab: Kontak -->
        @if($tabAktif == 'kontak')
        <div class="space-y-8 animate-fade-in">
            <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-6">Informasi Kontak & Sosial</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Fisik</label>
                        <input type="text" wire:model="alamat_fisik" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Email Dukungan</label>
                        <input type="email" wire:model="email_dukungan" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Telepon / WhatsApp</label>
                        <input type="text" wire:model="telepon_dukungan" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold">
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">URL Facebook</label>
                        <input type="url" wire:model="sosial_facebook" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">URL Instagram</label>
                        <input type="url" wire:model="sosial_instagram" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">URL Twitter / X</label>
                        <input type="url" wire:model="sosial_twitter" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold">
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tab: SEO -->
        @if($tabAktif == 'seo')
        <div class="space-y-8 animate-fade-in">
            <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-6">Optimasi Mesin Pencari (SEO)</h2>
            <div class="max-w-3xl space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Meta Description Default</label>
                    <textarea wire:model="seo_description" rows="3" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold"></textarea>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Meta Keywords (Pisahkan dengan koma)</label>
                    <input type="text" wire:model="seo_keywords" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold">
                </div>
            </div>
        </div>
        @endif

        <!-- Action Bar -->
        <div class="mt-10 pt-8 border-t border-slate-100 flex justify-end">
            <button wire:click="simpan" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all active:scale-95 flex items-center gap-3">
                <i class="fa-solid fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </div>
</div>