<div class="space-y-10">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">BERITA & <span class="text-purple-600">INFORMASI</span></h1>
            <p class="text-slate-500 font-medium">Kelola artikel, berita teknologi, dan pengumuman untuk pelanggan.</p>
        </div>
        <button wire:click="tambahBaru" class="px-6 py-3 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition shadow-xl shadow-slate-900/20 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tulis Artikel
        </button>
    </div>

    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex items-center gap-4">
            <div class="relative flex-1">
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari judul berita..." class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-purple-500">
                <svg class="w-5 h-5 absolute left-4 top-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Konten Berita</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Dibaca</th>
                        <th class="px-8 py-5 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($daftar_berita as $b)
                    <tr class="group hover:bg-slate-50/50 transition">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-10 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                    <img src="{{ $b->gambar_unggulan ?? 'https://via.placeholder.com/160x100?text=No+Image' }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 leading-tight mb-1">{{ $b->judul }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $b->created_at->translatedFormat('d F Y') }} • Oleh: {{ $b->penulis->nama }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $b->status === 'publikasi' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                {{ $b->status }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center text-sm font-black text-slate-900">{{ number_format($b->jumlah_baca) }}</td>
                        <td class="px-8 py-5 text-right">
                            <button wire:click="edit({{ $b->id }})" class="p-2 text-slate-400 hover:text-purple-600 hover:bg-purple-50 rounded-xl transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold">Belum ada berita tertulis.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-slate-50/30">{{ $daftar_berita->links() }}</div>
    </div>

    <!-- Panel Form Berita -->
    <x-ui.panel-geser id="form-berita" judul="{{ $berita_id ? 'EDIT ARTIKEL' : 'TULIS ARTIKEL BARU' }}">
        <form wire:submit.prevent="simpan" class="space-y-8">
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Judul Artikel Utama</label>
                    <input wire:model="judul" type="text" class="w-full rounded-2xl border-slate-200 focus:ring-purple-500 font-bold" placeholder="Contoh: Tren Teknologi AI pada MacBook Terbaru 2026">
                    @error('judul') <span class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Ringkasan Singkat (Lead)</label>
                    <textarea wire:model="ringkasan" rows="2" class="w-full rounded-2xl border-slate-200 focus:ring-purple-500 text-sm" placeholder="Penjelasan singkat konten artikel..."></textarea>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Isi Konten Lengkap</label>
                    <textarea wire:model="konten" rows="10" class="w-full rounded-2xl border-slate-200 focus:ring-purple-500 text-sm" placeholder="Tuliskan narasi lengkap artikel di sini..."></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Status Publikasi</label>
                        <select wire:model="status" class="w-full rounded-2xl border-slate-200 focus:ring-purple-500 text-sm font-bold">
                            <option value="draft">DRAFT / ARSIP</option>
                            <option value="publikasi">PUBLIKASIKAN</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Gambar Unggulan</label>
                        <input type="file" wire:model="gambar_baru" class="text-xs">
                    </div>
                </div>
            </div>
            <div class="pt-6 border-t border-slate-100 flex gap-3">
                <button type="submit" class="flex-1 py-4 bg-purple-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-purple-700 transition shadow-xl shadow-purple-600/20">Simpan Perubahan</button>
                <button type="button" @click="$dispatch('close-panel-form-berita')" class="px-8 py-4 bg-slate-100 text-slate-400 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-50 hover:text-red-500 transition">Batal</button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>
