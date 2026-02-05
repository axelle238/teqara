<div>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-slate-900">Daftar Pesanan</h1>
            <p class="mt-2 text-sm text-slate-700">Daftar seluruh transaksi masuk dari pelanggan.</p>
        </div>
    </div>

    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-between">
        <!-- Filter Status -->
        <div class="flex gap-2">
            <button wire:click="$set('filterStatus', '')" class="px-3 py-1 text-sm font-medium rounded-full {{ $filterStatus === '' ? 'bg-slate-800 text-white' : 'bg-white text-slate-600 border border-slate-300' }}">Semua</button>
            <button wire:click="$set('filterStatus', 'menunggu')" class="px-3 py-1 text-sm font-medium rounded-full {{ $filterStatus === 'menunggu' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-white text-slate-600 border border-slate-300' }}">Menunggu</button>
            <button wire:click="$set('filterStatus', 'diproses')" class="px-3 py-1 text-sm font-medium rounded-full {{ $filterStatus === 'diproses' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-white text-slate-600 border border-slate-300' }}">Diproses</button>
            <button wire:click="$set('filterStatus', 'selesai')" class="px-3 py-1 text-sm font-medium rounded-full {{ $filterStatus === 'selesai' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-white text-slate-600 border border-slate-300' }}">Selesai</button>
        </div>

        <!-- Search -->
        <div>
            <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari No. Invoice..." class="block w-full rounded-md border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm">
        </div>
    </div>

    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-slate-300">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">Invoice</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Tanggal</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Pelanggan</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Total</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Status</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse($pesanan as $p)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-bold text-slate-900 sm:pl-6">
                                    {{ $p->nomor_invoice }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                                    {{ $p->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                                    {{ $p->pengguna->nama }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-slate-900">
                                    {{ 'Rp ' . number_format($p->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                                        {{ $p->status_pesanan === 'selesai' ? 'bg-green-100 text-green-800' : 
                                          ($p->status_pesanan === 'batal' ? 'bg-red-100 text-red-800' : 
                                          ($p->status_pesanan === 'dikirim' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                        {{ strtoupper($p->status_pesanan) }}
                                    </span>
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <a href="/admin/pesanan/{{ $p->id }}" wire:navigate class="text-cyan-600 hover:text-cyan-900 font-bold">Proses</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-3 py-10 text-center text-sm text-slate-500">
                                    Tidak ada data pesanan ditemukan.
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
        {{ $pesanan->links() }}
    </div>
</div>
