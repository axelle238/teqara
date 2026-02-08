<div class="space-y-8 pb-20 animate-slide-in-right">
    
    <!-- HEADER NAVIGASI -->
    <div class="flex items-center justify-between">
        <a href="{{ route('pengelola.pengaturan.log') }}" wire:navigate class="group flex items-center gap-3 text-slate-400 hover:text-slate-900 transition-colors">
            <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm group-hover:shadow-md transition-all">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
            <span class="text-xs font-black uppercase tracking-widest">Kembali ke Daftar</span>
        </a>
        <span class="px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-slate-900/20">
            ID Log: #{{ $log->id }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI: KONTEKS UTAMA -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Kartu Aktor -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-[100px] -mr-6 -mt-6"></div>
                
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 relative z-10">Aktor Utama</h3>
                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-16 h-16 rounded-[1.5rem] bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-2xl font-black text-white shadow-lg shadow-indigo-500/30">
                        {{ substr($log->pengguna->nama ?? 'S', 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-900 leading-tight">{{ $log->pengguna->nama ?? 'Sistem Otomatis' }}</h2>
                        <p class="text-xs font-bold text-slate-500 mt-1">{{ $log->pengguna->email ?? 'root@system' }}</p>
                        <span class="inline-block mt-2 px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-indigo-100">
                            {{ $log->pengguna->peran ?? 'System' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Kartu Konteks -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Konteks Eksekusi</h3>
                
                <div class="space-y-4">
                    <div class="flex items-start gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-slate-400 shadow-sm shrink-0">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Waktu Kejadian</p>
                            <p class="text-sm font-bold text-slate-700 mt-1">{{ $log->waktu->translatedFormat('l, d F Y') }}</p>
                            <p class="text-xs font-mono text-slate-500">{{ $log->waktu->format('H:i:s') }} WIB</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-slate-400 shadow-sm shrink-0">
                            <i class="fa-solid fa-bullseye"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Target Objek</p>
                            <p class="text-sm font-bold text-slate-700 mt-1 break-all">{{ $log->target }}</p>
                            <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mt-1">{{ $log->aksi }}</p>
                        </div>
                    </div>

                    @if(isset($log->meta_data['ip']))
                    <div class="flex items-start gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-slate-400 shadow-sm shrink-0">
                            <i class="fa-solid fa-network-wired"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Jejak Digital</p>
                            <p class="text-xs font-mono text-slate-600 mt-1">IP: {{ $log->meta_data['ip'] }}</p>
                            <p class="text-[10px] text-slate-400 mt-1 line-clamp-2" title="{{ $log->meta_data['agen'] ?? '-' }}">
                                {{ $log->meta_data['agen'] ?? '-' }}
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: DETAIL PERUBAHAN (DIFF VIEWER) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Narasi -->
            <div class="bg-indigo-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-indigo-500/30 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="relative z-10">
                    <h3 class="text-[10px] font-black text-indigo-200 uppercase tracking-[0.3em] mb-4">Narasi Sistem</h3>
                    <p class="text-xl md:text-2xl font-medium leading-relaxed italic">"{{ $log->pesan_naratif }}"</p>
                </div>
            </div>

            <!-- Perubahan Data (Diff) -->
            @if(isset($log->meta_data['perbedaan']) && count($log->meta_data['perbedaan']) > 0)
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em] flex items-center gap-2">
                        <i class="fa-solid fa-code-compare text-indigo-500"></i> Rekaman Perubahan Data
                    </h3>
                    <span class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-[9px] font-black text-slate-500 uppercase tracking-widest">
                        {{ count($log->meta_data['perbedaan']) }} Atribut Berubah
                    </span>
                </div>
                
                <div class="divide-y divide-slate-100">
                    @foreach($log->meta_data['perbedaan'] as $field => $diff)
                    <div class="grid grid-cols-1 md:grid-cols-12 group hover:bg-slate-50/50 transition-colors">
                        <!-- Nama Field -->
                        <div class="md:col-span-3 p-6 border-b md:border-b-0 md:border-r border-slate-100 flex items-center">
                            <span class="font-mono text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">
                                {{ $field }}
                            </span>
                        </div>
                        
                        <!-- Nilai Lama -->
                        <div class="md:col-span-4 p-6 border-b md:border-b-0 md:border-r border-slate-100 bg-rose-50/30">
                            <p class="text-[9px] font-black text-rose-400 uppercase tracking-widest mb-2">SEBELUM</p>
                            <div class="font-mono text-xs text-rose-700 break-all">
                                @if(is_array($diff['dari']))
                                    <pre class="whitespace-pre-wrap">{{ json_encode($diff['dari'], JSON_PRETTY_PRINT) }}</pre>
                                @else
                                    {{ $diff['dari'] ?? '(Kosong)' }}
                                @endif
                            </div>
                        </div>

                        <!-- Nilai Baru -->
                        <div class="md:col-span-5 p-6 bg-emerald-50/30">
                            <p class="text-[9px] font-black text-emerald-500 uppercase tracking-widest mb-2">SESUDAH</p>
                            <div class="font-mono text-xs text-emerald-700 break-all">
                                @if(is_array($diff['menjadi']))
                                    <pre class="whitespace-pre-wrap">{{ json_encode($diff['menjadi'], JSON_PRETTY_PRINT) }}</pre>
                                @else
                                    {{ $diff['menjadi'] ?? '(Kosong)' }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @elseif(isset($log->meta_data['data_baru']))
            <!-- Jika hanya data snapshot (Create) -->
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em] mb-4">Snapshot Data Masuk</h3>
                <pre class="bg-slate-900 text-emerald-400 p-6 rounded-2xl text-xs font-mono overflow-x-auto custom-scrollbar-dark">{{ json_encode($log->meta_data['data_baru'], JSON_PRETTY_PRINT) }}</pre>
            </div>
            @else
            <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2.5rem] p-12 text-center">
                <i class="fa-solid fa-file-circle-xmark text-4xl text-slate-300 mb-4"></i>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Tidak ada detail perubahan data yang tercatat.</p>
            </div>
            @endif

        </div>
    </div>
</div>
