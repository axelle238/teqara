<div class="bg-slate-50 min-h-screen py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-slate-900 mb-8">Dashboard Saya</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Ringkasan Statistik -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 text-center">
                    <img class="h-20 w-20 rounded-full mx-auto mb-4 border-4 border-cyan-50" src="https://ui-avatars.com/api/?name={{ urlencode($nama) }}&background=0891b2&color=fff" alt="">
                    <h2 class="text-xl font-bold text-slate-900">{{ $nama }}</h2>
                    <p class="text-sm text-slate-500">{{ $email }}</p>
                    <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Total Belanja</p>
                            <p class="text-sm font-bold text-cyan-600">{{ 'Rp ' . number_format($totalBelanja, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Status Akun</p>
                            <p class="text-sm font-bold text-emerald-600">Aktif</p>
                        </div>
                    </div>
                </div>

                <!-- Form Ubah Profil -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h3 class="font-bold text-slate-900 mb-4">Pengaturan Akun</h3>
                    <form wire:submit.prevent="simpanProfil" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                            <input wire:model="nama" type="text" class="w-full rounded-lg border-slate-200 text-sm focus:ring-cyan-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nomor Telepon</label>
                            <input wire:model="nomor_telepon" type="text" class="w-full rounded-lg border-slate-200 text-sm focus:ring-cyan-500" placeholder="08xxxx">
                        </div>
                        <button type="submit" class="w-full bg-slate-900 text-white py-2 rounded-lg text-sm font-bold hover:bg-slate-800 transition">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            <!-- Pesanan Terakhir -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="font-bold text-slate-900">Pesanan Terakhir</h3>
                        <a href="/pesanan/riwayat" wire:navigate class="text-xs font-bold text-cyan-600 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($pesananTerakhir as $p)
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-bold text-slate-900">{{ $p->nomor_invoice }}</p>
                                <p class="text-xs text-slate-500">{{ $p->created_at->format('d M Y') }} • {{ 'Rp ' . number_format($p->total_harga, 0, ',', '.') }}</p>
                            </div>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-bold ring-1 ring-inset {{ $p->status_pesanan === 'selesai' ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/20' : 'bg-amber-50 text-amber-700 ring-amber-600/20' }}">
                                {{ strtoupper($p->status_pesanan) }}
                            </span>
                        </div>
                        @empty
                        <div class="p-10 text-center text-slate-500">
                            <p>Anda belum memiliki riwayat pesanan.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Bantuan Section -->
                <div class="bg-cyan-600 rounded-2xl p-8 text-white relative overflow-hidden shadow-lg shadow-cyan-900/20">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold mb-2">Butuh Bantuan Teknis?</h3>
                        <p class="text-cyan-100 mb-6 max-w-md">Tim Teqara siap membantu kendala pada gadget atau pesanan Anda 24/7 melalui pusat bantuan kami.</p>
                        <button class="bg-white text-cyan-600 px-6 py-2 rounded-xl font-bold text-sm hover:bg-cyan-50 transition">Hubungi CS Teqara</button>
                    </div>
                    <div class="absolute -right-10 -bottom-10 opacity-10">
                        <svg class="h-64 w-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
