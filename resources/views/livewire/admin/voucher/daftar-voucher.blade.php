<div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Form Voucher -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 sticky top-24">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Buat Voucher Baru</h2>
                
                <form wire:submit.prevent="simpan" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kode Voucher</label>
                        <input wire:model="kode" type="text" class="w-full rounded-xl border-slate-300 uppercase font-mono font-bold tracking-widest focus:ring-cyan-500" placeholder="SALE2026">
                        @error('kode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tipe</label>
                            <select wire:model.live="tipe_diskon" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500">
                                <option value="persen">Persen (%)</option>
                                <option value="nominal">Nominal (Rp)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nilai</label>
                            <input wire:model="nilai_diskon" type="number" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500" placeholder="{{ $tipe_diskon == 'persen' ? '10' : '50000' }}">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Deskripsi</label>
                        <textarea wire:model="deskripsi" rows="2" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Mulai</label>
                            <input wire:model="berlaku_mulai" type="date" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sampai</label>
                            <input wire:model="berlaku_sampai" type="date" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Min. Belanja</label>
                            <input wire:model="min_pembelian" type="number" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kuota</label>
                            <input wire:model="kuota" type="number" class="w-full rounded-xl border-slate-300 focus:ring-cyan-500">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-xl font-bold hover:bg-slate-800 transition shadow-lg">
                        Simpan Voucher
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Voucher -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Diskon</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Masa Berlaku</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kuota</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($vouchers as $v)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-cyan-50 text-cyan-700 rounded-lg font-mono font-bold text-sm tracking-wider border border-cyan-100">
                                    {{ $v->kode }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900">
                                    {{ $v->tipe_diskon == 'persen' ? $v->nilai_diskon . '%' : 'Rp ' . number_format($v->nilai_diskon/1000) . 'k' }}
                                </div>
                                <div class="text-xs text-slate-500">Min: {{ 'Rp ' . number_format($v->min_pembelian/1000) . 'k' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($v->berlaku_sampai)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $v->kuota < 10 ? 'text-red-600' : 'text-slate-700' }}">
                                {{ $v->kuota }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="hapus({{ $v->id }})" wire:confirm="Hapus voucher ini?" class="text-red-500 hover:text-red-700 font-bold text-xs">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500">Belum ada voucher aktif.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $vouchers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
