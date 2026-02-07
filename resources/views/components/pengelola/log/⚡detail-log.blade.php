<div class="space-y-8 animate-fade-in">
    <!-- Tombol Kembali -->
    <div class="flex items-center gap-4">
        <a href="{{ route('pengelola.pengaturan.log') }}" wire:navigate class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:shadow-lg transition-all border border-slate-100 shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Rincian <span class="text-indigo-600">Aktivitas</span></h1>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Audit Trail Forensik Sistem</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kartu Metadata Utama -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 space-y-6">
                    <div class="text-center pb-6 border-b border-slate-50">
                        <div class="w-20 h-20 bg-gradient-to-tr from-indigo-600 to-purple-600 rounded-3xl flex items-center justify-center text-white text-3xl shadow-xl shadow-indigo-200 mx-auto mb-4">
                            {{ substr($this->log->pengguna->nama ?? 'S', 0, 1) }}
                        </div>
                        <h3 class="font-black text-slate-900 uppercase tracking-wide">{{ $this->log->pengguna->nama ?? 'Sistem' }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $this->log->pengguna->peran ?? 'Otomatis' }}</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-1">Aksi</span>
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-indigo-100">{{ $this->log->aksi }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-1">Target</span>
                            <span class="text-xs font-bold text-slate-700 font-mono">{{ $this->log->target }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-1">Waktu Kejadian</span>
                            <span class="text-xs font-bold text-slate-700">{{ $this->log->waktu->format('d M Y - H:i:s') }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-1">Alamat IP</span>
                            <span class="text-xs font-bold text-slate-700 font-mono">{{ $this->log->meta_data['ip'] ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agen Pengguna -->
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Agen Pengguna (Browser)</h4>
                <p class="text-[10px] font-mono text-slate-500 break-words bg-slate-50 p-4 rounded-xl leading-relaxed">{{ $this->log->meta_data['agen'] ?? '-' }}</p>
            </div>
        </div>

        <!-- Kartu Detail Naratif & Perubahan -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Pesan Naratif -->
            <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-sm border border-slate-100">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg">
                        <i class="fa-solid fa-comment-dots"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Narasi Aktivitas</h3>
                </div>
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100">
                    <p class="text-slate-700 font-bold leading-relaxed italic">"{{ $this->log->pesan_naratif }}"</p>
                </div>
            </div>

            <!-- Perubahan Data (Diff) -->
            @if(isset($this->log->meta_data['perbedaan']))
            <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-sm border border-slate-100 overflow-hidden">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-lg">
                        <i class="fa-solid fa-code-compare"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Analisis Perubahan</h3>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-12 gap-4 px-4 pb-2 border-b border-slate-100">
                        <div class="col-span-4 text-[9px] font-black text-slate-400 uppercase tracking-widest">Kolom/Atribut</div>
                        <div class="col-span-4 text-[9px] font-black text-slate-400 uppercase tracking-widest text-center">Data Lama</div>
                        <div class="col-span-4 text-[9px] font-black text-slate-400 uppercase tracking-widest text-right">Data Baru</div>
                    </div>

                    @foreach($this->log->meta_data['perbedaan'] as $kunci => $nilai)
                    <div class="grid grid-cols-12 gap-4 p-4 rounded-2xl bg-slate-50/50 hover:bg-slate-50 transition-colors items-center group">
                        <div class="col-span-4">
                            <span class="text-xs font-black text-slate-600 uppercase tracking-wide">{{ str_replace('_', ' ', $kunci) }}</span>
                        </div>
                        <div class="col-span-4">
                            <div class="px-3 py-2 bg-rose-50 text-rose-600 rounded-lg text-[10px] font-bold text-center line-through decoration-rose-300">
                                {{ is_array($nilai['dari']) ? json_encode($nilai['dari']) : $nilai['dari'] }}
                            </div>
                        </div>
                        <div class="col-span-4">
                            <div class="px-3 py-2 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black text-center shadow-sm shadow-emerald-100">
                                {{ is_array($nilai['menjadi']) ? json_encode($nilai['menjadi']) : $nilai['menjadi'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Raw Data (JSON) -->
            <div x-data="{ terbuka: false }" class="bg-slate-900 rounded-[2.5rem] p-8 md:p-10 shadow-xl overflow-hidden transition-all" :class="terbuka ? 'opacity-100' : 'opacity-90'">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-slate-800 text-indigo-400 rounded-xl flex items-center justify-center text-lg">
                            <i class="fa-solid fa-json"></i>
                        </div>
                        <h3 class="text-lg font-black text-white uppercase tracking-tight">Data Mentah (JSON)</h3>
                    </div>
                    <button @click="terbuka = !terbuka" class="text-slate-400 hover:text-white text-[10px] font-black uppercase tracking-widest" x-text="terbuka ? 'Sembunyikan' : 'Tampilkan Data'"></button>
                </div>
                
                <div x-show="terbuka" x-transition.opacity class="bg-slate-800/50 rounded-2xl p-6 overflow-x-auto border border-slate-700/50">
                    <pre class="text-[10px] font-mono text-indigo-300 leading-relaxed">{{ json_encode($this->log->meta_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            </div>
        </div>
    </div>
</div>
