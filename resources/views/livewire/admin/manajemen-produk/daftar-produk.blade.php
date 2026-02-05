<div>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-slate-900">Daftar Produk</h1>
            <p class="mt-2 text-sm text-slate-700">Kelola katalog barang dagangan toko.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="/admin/produk/tambah" wire:navigate class="inline-flex items-center justify-center rounded-md border border-transparent bg-cyan-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 sm:w-auto">
                + Tambah Produk
            </a>
        </div>
    </div>

    <div class="mt-8 flex justify-between">
        <div class="w-full max-w-sm">
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari nama atau KODE UNIT..." class="block w-full rounded-md border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm">
        </div>
    </div>

    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-slate-300">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">Produk</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Kategori</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Harga</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Stok</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Status</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse($produk as $p)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $p->gambar_utama }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-slate-900">{{ $p->nama }}</div>
                                            <div class="text-slate-500">{{ `p->kode_unit }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                                    {{ $p->kategori->nama }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                                    {{ 'Rp ' . number_format($p->harga_jual, 0, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                                    <span class="{{ $p->stok < 5 ? 'text-red-600 font-bold' : '' }}">{{ $p->stok }}</span>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $p->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800' }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <a href="/admin/produk/{{ $p->id }}/edit" wire:navigate class="text-cyan-600 hover:text-cyan-900 mr-4">Edit</a>
                                    <button wire:click="hapusProduk({{ $p->id }})" wire:confirm="Yakin ingin menghapus produk ini?" class="text-red-600 hover:text-red-900">Hapus</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-3 py-10 text-center text-sm text-slate-500">
                                    Tidak ada produk ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        {{ $produk->links() }}
    </div>
</div>
