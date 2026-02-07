<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12 animate-fade-in-down">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Pusat <span class="text-indigo-600">Unduhan</span></h1>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-2">Aset Digital & Dokumen Legal Anda</p>
            </div>
            <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-xl shadow-sm text-[10px] font-black uppercase tracking-widest text-slate-500">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Penyimpanan Awan Aktif
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden animate-fade-in-up relative">
            <!-- Header Filter -->
            <div class="px-8 py-4 border-b border-slate-50 bg-slate-50/50 backdrop-blur-md sticky top-0 z-10">
                <div class="flex gap-4 overflow-x-auto scrollbar-hide">
                    <button class="px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-slate-900/20">Semua File</button>
                    <button class="px-4 py-2 bg-white text-slate-500 hover:text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all border border-transparent hover:border-slate-200">Invoice</button>
                    <button class="px-4 py-2 bg-white text-slate-500 hover:text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all border border-transparent hover:border-slate-200">Manual Book</button>
                    <button class="px-4 py-2 bg-white text-slate-500 hover:text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all border border-transparent hover:border-slate-200">Software</button>
                </div>
            </div>

            <!-- File List -->
            <div class="divide-y divide-slate-50">
                @forelse($this->daftarUnduhan as $file)
                <div class="group p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 hover:bg-slate-50 transition-all duration-300">
                    <div class="flex items-center gap-6 w-full md:w-auto">
                        <!-- Icon -->
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl shadow-sm transition-transform group-hover:scale-110 group-hover:rotate-3
                            {{ $file['tipe'] == 'PDF' ? 'bg-rose-50 text-rose-500 group-hover:bg-rose-100' : 'bg-indigo-50 text-indigo-500 group-hover:bg-indigo-100' }}
                        ">
                            {{ $file['tipe'] == 'PDF' ? '📄' : '📦' }}
                        </div>
                        
                        <div>
                            <h4 class="font-black text-slate-900 text-sm group-hover:text-indigo-600 transition-colors">{{ $file['judul'] }}</h4>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-[9px] font-bold text-slate-500 uppercase tracking-wide">{{ $file['tipe'] }}</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $file['ukuran'] }}</span>
                                <span class="text-slate-300">•</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $file['tanggal']->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ $file['url'] }}" target="_blank" class="w-full md:w-auto px-8 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm flex items-center justify-center gap-2 group/btn">
                        <span>Unduh File</span>
                        <svg class="w-3 h-3 transition-transform group-hover/btn:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-32">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6 text-4xl opacity-50 shadow-inner">💾</div>
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-2">Arsip Kosong</h3>
                    <p class="text-slate-400 text-xs font-medium max-w-xs text-center">Belum ada dokumen digital yang tersedia untuk akun Anda.</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>