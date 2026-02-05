<div class="max-w-4xl mx-auto pb-20">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Manajemen Konten (CMS)</h1>
        <p class="text-slate-500 text-sm">Sesuaikan tampilan halaman depan toko Anda.</p>
    </div>

    <!-- Hero Section Editor -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h3 class="font-bold text-slate-900">Hero Section (Banner Utama)</h3>
            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">Aktif</span>
        </div>
        
        <form wire:submit.prevent="simpanHero" class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Preview Gambar -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Gambar Banner</label>
                    <div class="relative aspect-video rounded-xl overflow-hidden bg-slate-100 border-2 border-dashed border-slate-300 group hover:border-cyan-500 transition">
                        @if($hero_gambar_baru)
                            <img src="{{ $hero_gambar_baru->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif($hero_gambar_lama)
                            <img src="{{ $hero_gambar_lama }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-slate-400">Belum ada gambar</div>
                        @endif
                        
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                            <label class="cursor-pointer px-4 py-2 bg-white rounded-lg text-sm font-bold hover:bg-slate-50">
                                Ganti Foto
                                <input type="file" wire:model="hero_gambar_baru" class="hidden">
                            </label>
                        </div>
                    </div>
                    @error('hero_gambar_baru') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Input Teks -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Judul Utama (Headline)</label>
                        <textarea wire:model="hero_judul" rows="2" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500 font-bold text-lg"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Deskripsi Sub-judul</label>
                        <textarea wire:model="hero_deskripsi" rows="3" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500 text-sm"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Teks Tombol</label>
                            <input wire:model="hero_tombol" type="text" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Link Tujuan</label>
                            <input wire:model="hero_url" type="text" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 text-right">
                <button type="submit" class="px-6 py-3 bg-slate-900 text-white rounded-xl font-bold hover:bg-slate-800 transition shadow-lg">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
