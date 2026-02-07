<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row items-end justify-between mb-10 gap-6 animate-fade-in-down">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Permintaan <span class="text-indigo-600">Penawaran</span></h1>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-2">Negosiasi Harga & Pengadaan B2B</p>
            </div>
            <a href="{{ route('customer.rfq.create') }}" class="flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg hover:shadow-indigo-500/30 group">
                <svg class="w-4 h-4 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat RFQ Baru
            </a>
        </div>

        @if($this->daftarPenawaran->count() > 0)
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden animate-fade-in-up">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50/80 border-b border-slate-100 backdrop-blur-sm">
                        <tr>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">ID & Tanggal</th>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">Total Estimasi</th>
                            <th class="px-8 py-6 font-black text-slate-400 uppercase tracking-widest text-[10px]">Status</th>
                            <th class="px-8 py-6 text-right font-black text-slate-400 uppercase tracking-widest text-[10px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($this->daftarPenawaran as $rfq)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-black group-hover:scale-110 transition-transform shadow-sm">
                                        📄
                                    </div>
                                    <div>
                                        <h4 class="font-black text-slate-900 text-sm font-mono tracking-wide">#RFQ-{{ str_pad($rfq->id, 5, '0', STR_PAD_LEFT) }}</h4>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $rfq->dibuat_pada->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="block text-sm font-black text-slate-900">Rp {{ number_format($rfq->total_pengajuan, 0, ',', '.') }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $rfq->items->count() ?? 0 }} Produk</span>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $statusConfig = [
                                        'menunggu' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => '⏳'],
                                        'dibalas' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => '💬'],
                                        'disetujui' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'icon' => '✅'],
                                        'ditolak' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'icon' => '❌'],
                                    ];
                                    $conf = $statusConfig[$rfq->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'icon' => '•'];
                                @endphp
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $conf['bg'] }} {{ $conf['text'] }}">
                                    <span>{{ $conf['icon'] }}</span> {{ $rfq->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <a href="{{ route('customer.rfq.detail', $rfq->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:border-indigo-200 hover:text-indigo-600 hover:bg-indigo-50 transition-all shadow-sm">
                                    Detail
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-slate-50 bg-slate-50/30">
                {{ $this->daftarPenawaran->links() }}
            </div>
        </div>
        @else
        <div class="flex flex-col items-center justify-center py-32 bg-white rounded-[3rem] border border-dashed border-slate-200 animate-fade-in-up">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6 text-4xl shadow-inner">💼</div>
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Belum Ada RFQ</h3>
            <p class="text-slate-400 text-sm font-medium max-w-sm text-center mb-8">Butuh harga khusus untuk proyek atau pembelian massal? Ajukan penawaran sekarang.</p>
            <a href="{{ route('customer.rfq.create') }}" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20 active:scale-95">
                Mulai Pengajuan
            </a>
        </div>
        @endif

    </div>
</div>