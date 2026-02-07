<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('customer.rfq.index') }}" class="flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-indigo-600 transition-colors mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar
                </a>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">RFQ <span class="text-indigo-600">#{{ str_pad($penawaran->id, 5, '0', STR_PAD_LEFT) }}</span></h1>
            </div>
            
            <div class="flex gap-2">
                <span class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-black uppercase tracking-widest text-slate-600 shadow-sm">
                    {{ $penawaran->dibuat_pada->format('d M Y') }}
                </span>
                @php
                    $statusClasses = [
                        'menunggu' => 'bg-amber-100 text-amber-700',
                        'dibalas' => 'bg-blue-100 text-blue-700',
                        'disetujui' => 'bg-emerald-100 text-emerald-700',
                        'ditolak' => 'bg-rose-100 text-rose-700',
                    ];
                @endphp
                <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest {{ $statusClasses[$penawaran->status] ?? 'bg-slate-100' }}">
                    {{ $penawaran->status }}
                </span>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            
            <!-- Left: Items -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
                    <div class="p-8 border-b border-slate-50 bg-slate-50/30">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Rincian Produk</h3>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @foreach($penawaran->items as $item)
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-slate-50 rounded-xl flex items-center justify-center p-2 border border-slate-100">
                                    <img src="{{ $item->produk->gambar_utama_url }}" class="w-full h-full object-contain mix-blend-multiply">
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">{{ $item->produk->nama }}</h4>
                                    <p class="text-xs text-slate-500 font-medium">Qty: {{ $item->jumlah }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Harga Satuan</p>
                                @if($item->harga_tawar_satuan)
                                    <span class="text-lg font-black text-emerald-600">Rp {{ number_format($item->harga_tawar_satuan, 0, ',', '.') }}</span>
                                    <br><span class="text-[10px] line-through text-slate-400">Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-sm font-black text-slate-300 italic">Menunggu Penawaran</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    @if($penawaran->total_pengajuan > 0)
                    <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                        <span class="font-bold text-slate-500 uppercase text-xs tracking-widest">Total Estimasi</span>
                        <span class="text-2xl font-black text-slate-900">Rp {{ number_format($penawaran->total_pengajuan, 0, ',', '.') }}</span>
                    </div>
                    @endif
                </div>

                <!-- Chat / Notes -->
                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4">Catatan Negosiasi</h3>
                    
                    <div class="space-y-4">
                        <!-- User Note -->
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 shrink-0">👤</div>
                            <div class="bg-slate-50 p-4 rounded-2xl rounded-tl-none border border-slate-100 text-sm text-slate-600">
                                <p>{{ $penawaran->pesan_user ?? 'Tidak ada catatan tambahan.' }}</p>
                            </div>
                        </div>

                        <!-- Admin Note -->
                        @if($penawaran->pesan_admin)
                        <div class="flex gap-4 flex-row-reverse">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 shrink-0">🏢</div>
                            <div class="bg-indigo-50 p-4 rounded-2xl rounded-tr-none border border-indigo-100 text-sm text-indigo-800">
                                <p>{{ $penawaran->pesan_admin }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right: Actions -->
            <div class="space-y-6">
                <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-indigo-500/30">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                    <h3 class="text-lg font-black uppercase tracking-tight mb-2">Status Pengajuan</h3>
                    <p class="text-sm text-indigo-100 mb-6 leading-relaxed">
                        @if($penawaran->status == 'menunggu')
                            Permintaan Anda sedang ditinjau oleh tim sales kami. Estimasi respon 1x24 jam.
                        @elseif($penawaran->status == 'dibalas')
                            Kami telah mengirimkan penawaran harga. Silakan tinjau dan konfirmasi.
                        @else
                            Proses negosiasi telah selesai.
                        @endif
                    </p>

                    @if($penawaran->status == 'dibalas')
                        <div class="space-y-3">
                            <button wire:click="terimaTawaran" class="w-full py-3 bg-white text-indigo-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-50 transition-all shadow-lg">
                                Terima Tawaran
                            </button>
                            <button wire:click="tolakTawaran" class="w-full py-3 bg-indigo-700 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-800 transition-all">
                                Tolak
                            </button>
                        </div>
                    @endif
                </div>

                @if($penawaran->file_lampiran)
                <a href="{{ asset($penawaran->file_lampiran) }}" target="_blank" class="flex items-center gap-4 p-4 bg-white rounded-2xl border border-slate-200 hover:border-indigo-300 transition-all group">
                    <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-2xl group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">📎</div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">Lihat Lampiran</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">Dokumen Pendukung</p>
                    </div>
                </a>
                @endif
            </div>

        </div>
    </div>
</div>
