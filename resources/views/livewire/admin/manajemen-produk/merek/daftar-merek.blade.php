<div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 sticky top-24">
                <h2 class="text-lg font-bold text-slate-900 mb-4">{{ $modeEdit ? 'Ubah Merek' : 'Tambah Merek' }}</h2>
                
                <form wire:submit.prevent="{{ $modeEdit ? 'perbarui' : 'simpan' }}" class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700">Nama Merek</label>
                        <input wire:model.live="nama" type="text" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm" placeholder="ASUS, Apple, dsb">
                        @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700">URL Logo (Opsional)</label>
                        <input wire:model="logo" type="text" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm" placeholder="https://...">
                    </div>

                    <div class="pt-2">
                        @if($modeEdit)
                            <div class="flex gap-2">
                                <button type="submit" class="flex-1 bg-cyan-600 text-white py-2 rounded-md font-bold hover:bg-cyan-700 transition">Update</button>
                                <button type="button" wire:click="$set('modeEdit', false)" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-md hover:bg-slate-200 transition">Batal</button>
                            </div>
                        @else
                            <button type="submit" class="w-full bg-slate-900 text-white py-2 rounded-md font-bold hover:bg-slate-800 transition">Simpan Merek</button>
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
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Merek</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Slug</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($daftarMerek as $merk)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($merk->logo)
                                        <img class="h-8 w-8 rounded-md object-contain border border-slate-100 mr-3" src="{{ $merk->logo }}" alt="">
                                    @else
                                        <div class="h-8 w-8 rounded-md bg-cyan-100 flex items-center justify-center text-cyan-700 font-bold text-xs mr-3">
                                            {{ substr($merk->nama, 0, 1) }}
                                        </div>
                                    @endif
                                    <span class="text-sm font-bold text-slate-900">{{ $merk->nama }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $merk->slug }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $merk->id }})" class="text-cyan-600 hover:text-cyan-900 mr-3">Ubah</button>
                                <button wire:click="hapus({{ $merk->id }})" wire:confirm="Hapus merek ini? Produk yang terkait akan tetap ada namun tanpa merek." class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-slate-500">Belum ada data merek.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-3 border-t border-slate-100">
                    {{ $daftarMerek->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
