<div class="bg-slate-50 min-h-screen py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter mb-4">Perbandingan Spesifikasi</h1>
            <p class="text-slate-500">Temukan perangkat yang paling tepat untuk kebutuhan Anda.</p>
        </div>

        @if($produkBandings->count() > 0)
        <div class="bg-white rounded-[32px] shadow-xl border border-slate-200 overflow-hidden overflow-x-auto">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr>
                        <th class="p-6 w-48 bg-slate-50 border-b border-r border-slate-200 text-xs font-black text-slate-400 uppercase tracking-widest">Spesifikasi</th>
                        @foreach($produkBandings as $p)
                        <th class="p-6 border-b border-slate-200 w-64 align-top relative group">
                            <button wire:click="hapus({{ $p->id }})" class="absolute top-4 right-4 text-slate-300 hover:text-red-500 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            <div class="flex flex-col items-center text-center">
                                <img src="{{ $p->gambar_utama_url }}" class="h-32 object-contain mb-4">
                                <h3 class="text-lg font-bold text-slate-900 leading-tight mb-2 h-12 overflow-hidden">{{ $p->nama }}</h3>
                                <p class="text-xl font-black text-cyan-600 mb-4">{{ 'Rp ' . number_format($p->harga_jual, 0, ',', '.') }}</p>
                                <a href="/produk/{{ $p->slug }}" class="px-6 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition shadow-lg">Lihat Detail</a>
                            </div>
                        </th>
                        @endforeach
                        @if($produkBandings->count() < 3)
                        <th class="p-6 border-b border-slate-200 w-64 align-middle text-center bg-slate-50/50">
                            <a href="/katalog" class="inline-flex flex-col items-center justify-center w-16 h-16 rounded-full bg-white border-2 border-dashed border-slate-300 text-slate-400 hover:border-cyan-500 hover:text-cyan-600 transition">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </a>
                            <p class="mt-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Tambah Produk</p>
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <!-- Hardcoded Specs for Demo, in real app use Dynamic Attributes -->
                    <tr>
                        <td class="p-6 bg-slate-50 font-bold text-slate-600 text-sm border-r border-slate-200">Merek</td>
                        @foreach($produkBandings as $p)
                        <td class="p-6 font-medium text-slate-900 text-center">{{ $p->merek->nama ?? '-' }}</td>
                        @endforeach
                        @if($produkBandings->count() < 3) <td></td> @endif
                    </tr>
                    <tr>
                        <td class="p-6 bg-slate-50 font-bold text-slate-600 text-sm border-r border-slate-200">Kategori</td>
                        @foreach($produkBandings as $p)
                        <td class="p-6 font-medium text-slate-900 text-center">{{ $p->kategori->nama }}</td>
                        @endforeach
                        @if($produkBandings->count() < 3) <td></td> @endif
                    </tr>
                    <!-- Loop Spesifikasi Dinamis -->
                    @php
                        // Kumpulkan semua kunci spesifikasi unik
                        $semuaKunci = $produkBandings->flatMap->spesifikasi->pluck('nama')->unique();
                    @endphp
                    @foreach($semuaKunci as $kunci)
                    <tr>
                        <td class="p-6 bg-slate-50 font-bold text-slate-600 text-sm border-r border-slate-200">{{ $kunci }}</td>
                        @foreach($produkBandings as $p)
                            @php $nilai = $p->spesifikasi->where('nama', $kunci)->first()?->nilai ?? '-'; @endphp
                            <td class="p-6 font-medium text-slate-900 text-center">{{ $nilai }}</td>
                        @endforeach
                        @if($produkBandings->count() < 3) <td></td> @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-24 bg-white rounded-[32px] border border-dashed border-slate-200">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-50 rounded-full mb-6 text-slate-300">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-900 mb-2">Belum Ada Produk</h3>
            <p class="text-slate-500 font-medium mb-8">Pilih produk dari katalog untuk mulai membandingkan.</p>
            <a href="/katalog" wire:navigate class="px-8 py-3 bg-cyan-600 text-white rounded-xl font-bold hover:bg-cyan-700 transition shadow-lg shadow-cyan-600/20">
                Ke Katalog
            </a>
        </div>
        @endif

    </div>
</div>
