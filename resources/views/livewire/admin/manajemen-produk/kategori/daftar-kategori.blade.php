<div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 sticky top-24">
                <h2 class="text-lg font-bold text-slate-900 mb-4">{{ $modeEdit ? 'Ubah Kategori' : 'Tambah Kategori' }}</h2>
                
                <form wire:submit.prevent="{{ $modeEdit ? 'perbarui' : 'simpan' }}" class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700">Nama Kategori</label>
                        <input wire:model.live="nama" type="text" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm" placeholder="Contoh: Laptop Gaming">
                        @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700">Ikon (Class/Text)</label>
                        <input wire:model="ikon" type="text" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm" placeholder="laptop, smartphone, dll">
                    </div>

                    <div class="pt-2">
                        @if($modeEdit)
                            <div class="flex gap-2">
                                <button type="submit" class="flex-1 bg-cyan-600 text-white py-2 rounded-md font-bold hover:bg-cyan-700 transition">Update</button>
                                <button type="button" wire:click="$set('modeEdit', false)" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-md hover:bg-slate-200 transition">Batal</button>
                            </div>
                        @else
                            <button type="submit" class="w-full bg-slate-900 text-white py-2 rounded-md font-bold hover:bg-slate-800 transition">Simpan Kategori</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Slug</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($daftarKategori as $kat)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 mr-3">
                                        <span class="text-xs uppercase font-bold">{{ substr($kat->nama, 0, 2) }}</span>
                                    </div>
                                    <span class="text-sm font-bold text-slate-900">{{ $kat->nama }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $kat->slug }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $kat->id }})" class="text-cyan-600 hover:text-cyan-900 mr-3">Ubah</button>
                                <button wire:click="hapus({{ $kat->id }})" wire:confirm="Hapus kategori ini? Produk di dalamnya akan terpengaruh." class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-slate-500">Belum ada data kategori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-3 border-t border-slate-100">
                    {{ $daftarKategori->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
