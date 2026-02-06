<div class="space-y-12 pb-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[40px] shadow-sm border border-indigo-50">
        <div class="space-y-2">
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">PUSAT <span class="text-pink-600">RESOLUSI</span></h1>
            <p class="text-slate-500 font-medium text-lg">Konsol penanganan keluhan dan komunikasi pelanggan real-time.</p>
        </div>
        <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl">
            @foreach(['' => 'SEMUA', 'terbuka' => 'OPEN', 'diproses' => 'PROGRES', 'selesai' => 'SOLVED'] as $val => $label)
            <button wire:click="$set('filterStatus', '{{ $val }}')" class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterStatus === $val ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Daftar Tiket -->
    <div class="bg-white rounded-[56px] border border-indigo-50 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 border-b border-indigo-50">
                    <tr>
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Tiket</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Pelapor</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Isu Utama</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Prioritas</th>
                        <th class="px-10 py-6 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-50">
                    @forelse($daftarTiket as $t)
                    <tr class="group hover:bg-pink-50/10 transition-all duration-300">
                        <td class="px-10 py-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800 mb-1">
                                #{{ $t->id }}
                            </span>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $t->created_at->diffForHumans() }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">
                                    {{ substr($t->pengguna->nama ?? 'A', 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-slate-900">{{ $t->pengguna->nama ?? 'Anonim' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-sm font-black text-slate-900">{{ $t->judul }}</p>
                            <p class="text-xs text-slate-500 truncate max-w-xs">{{ $t->kategori }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $t->prioritas === 'tinggi' ? 'bg-rose-100 text-rose-600' : 'bg-slate-100 text-slate-600' }}">
                                {{ $t->prioritas }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <button wire:click="bukaTiket({{ $t->id }})" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 hover:border-pink-500 hover:text-pink-600 rounded-2xl text-[9px] font-black uppercase tracking-widest transition-all shadow-sm">
                                BUKA KONSOL
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-10 py-20 text-center text-slate-400 font-bold">Tidak ada tiket aktif.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 bg-slate-50/30 border-t border-slate-50">{{ $daftarTiket->links() }}</div>
    </div>

    <!-- Panel Konsol Resolusi -->
    <x-ui.panel-geser id="detail-tiket" judul="KONSOL RESOLUSI">
        @if($tiketTerpilih)
        <div class="flex flex-col h-[calc(100vh-10rem)]">
            <!-- Info Tiket -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 mb-6 shrink-0">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">{{ $tiketTerpilih->judul }}</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1">ID: #{{ $tiketTerpilih->id }} • {{ $tiketTerpilih->kategori }}</p>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="ubahStatus('selesai')" class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-emerald-200">Selesai</button>
                        <button wire:click="ubahStatus('ditutup')" class="px-3 py-1 bg-slate-200 text-slate-700 rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-slate-300">Tutup</button>
                    </div>
                </div>
                <div class="flex items-center gap-3 text-xs text-slate-600 bg-white p-3 rounded-xl border border-slate-100">
                    <span class="font-bold">{{ $tiketTerpilih->pengguna->nama }}</span>
                    <span>&bull;</span>
                    <span>{{ $tiketTerpilih->pengguna->email }}</span>
                </div>
            </div>

            <!-- Area Chat -->
            <div class="flex-1 overflow-y-auto space-y-6 p-4 bg-slate-50/50 rounded-2xl border border-slate-100 mb-6 scroll-smooth">
                @if(empty($tiketTerpilih->riwayat_pesan))
                    <div class="text-center text-slate-400 py-10 text-xs font-bold uppercase tracking-widest">Belum ada percakapan. Mulai diskusi sekarang.</div>
                @else
                    @foreach($tiketTerpilih->riwayat_pesan as $chat)
                    <div class="flex {{ ($chat['pengirim'] ?? '') === 'admin' ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[80%] {{ ($chat['pengirim'] ?? '') === 'admin' ? 'bg-indigo-600 text-white rounded-t-2xl rounded-bl-2xl' : 'bg-white text-slate-800 border border-slate-200 rounded-t-2xl rounded-br-2xl' }} p-4 shadow-sm">
                            <p class="text-xs font-bold mb-1 opacity-70 uppercase tracking-wider">{{ $chat['nama'] ?? 'User' }}</p>
                            <p class="text-sm leading-relaxed">{{ $chat['pesan'] }}</p>
                            <p class="text-[9px] font-black mt-2 opacity-50 text-right">{{ \Carbon\Carbon::parse($chat['waktu'])->format('H:i') }}</p>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>

            <!-- Input Balasan -->
            <div class="shrink-0 bg-white p-4 rounded-2xl border border-slate-200 shadow-lg">
                <form wire:submit.prevent="kirimBalasan">
                    <textarea wire:model="pesanBaru" rows="3" class="w-full border-none bg-slate-50 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 p-4 mb-4 placeholder:text-slate-400 font-medium" placeholder="Tulis balasan solusi..."></textarea>
                    <div class="flex justify-between items-center">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Tekan Enter untuk baris baru</p>
                        <button type="submit" class="px-8 py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition shadow-lg">Kirim Balasan</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </x-ui.panel-geser>
</div>
