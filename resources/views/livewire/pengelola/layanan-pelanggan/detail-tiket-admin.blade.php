<div class="animate-in fade-in slide-in-from-bottom-4 duration-500 pb-20">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('pengelola.cs.tiket') }}" class="w-12 h-12 bg-white rounded-2xl border border-slate-200 flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Tiket #{{ str_pad($tiket->id, 5, '0', STR_PAD_LEFT) }}</h1>
                <p class="text-sm font-bold text-slate-500 mt-1 uppercase tracking-widest">{{ $tiket->subjek }}</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <select wire:model.live="statusBaru" wire:change="updateStatus" class="bg-white border-slate-200 rounded-xl text-xs font-black uppercase tracking-widest px-4 py-2.5 focus:ring-indigo-500 cursor-pointer shadow-sm">
                <option value="terbuka">Terbuka</option>
                <option value="diproses">Diproses</option>
                <option value="selesai">Selesai</option>
            </select>
            <select wire:model.live="prioritasBaru" wire:change="updateStatus" class="bg-white border-slate-200 rounded-xl text-xs font-black uppercase tracking-widest px-4 py-2.5 focus:ring-indigo-500 cursor-pointer shadow-sm">
                <option value="rendah">Rendah</option>
                <option value="sedang">Sedang</option>
                <option value="tinggi">Tinggi</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Chat Area (Left) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white rounded-[40px] border border-slate-100 shadow-xl overflow-hidden flex flex-col h-[650px] relative">
                <!-- Messages List -->
                <div class="flex-1 overflow-y-auto p-8 space-y-8 bg-slate-50/50 scrollbar-thin scrollbar-thumb-slate-200">
                    <div class="text-center">
                        <span class="px-4 py-1.5 bg-slate-200 rounded-full text-[9px] font-black text-slate-500 uppercase tracking-[0.2em]">
                            Konsultasi Dimulai: {{ $tiket->dibuat_pada->translatedFormat('d M Y, H:i') }}
                        </span>
                    </div>

                    @foreach($tiket->riwayat_pesan as $pesan)
                    <div class="flex flex-col {{ $pesan['pengirim'] == 'admin' ? 'items-end' : 'items-start' }}">
                        <div class="max-w-[85%] {{ $pesan['pengirim'] == 'admin' ? 'bg-indigo-600 text-white rounded-tr-none shadow-indigo-200' : 'bg-white border border-slate-200 text-slate-700 rounded-tl-none shadow-sm' }} rounded-[25px] p-6 relative group">
                            <p class="text-sm leading-relaxed font-medium whitespace-pre-wrap">{{ $pesan['pesan'] }}</p>
                            
                            @if(!empty($pesan['lampiran']))
                            <div class="mt-4 pt-4 border-t {{ $pesan['pengirim'] == 'admin' ? 'border-indigo-500' : 'border-slate-100' }}">
                                @foreach($pesan['lampiran'] as $file)
                                <a href="{{ asset($file) }}" target="_blank" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest hover:underline {{ $pesan['pengirim'] == 'admin' ? 'text-indigo-200' : 'text-indigo-600' }}">
                                    <i class="fa-solid fa-paperclip"></i> Lihat Lampiran
                                </a>
                                @endforeach
                            </div>
                            @endif

                            <div class="absolute -bottom-6 {{ $pesan['pengirim'] == 'admin' ? 'right-0' : 'left-0' }} flex items-center gap-2">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $pesan['nama'] }}</span>
                                <span class="text-[9px] font-bold text-slate-300">{{ \Carbon\Carbon::parse($pesan['waktu'])->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Input Balasan -->
                <div class="p-6 bg-white border-t border-slate-100 relative z-10">
                    @if($tiket->status != 'selesai')
                    <form wire:submit.prevent="kirimPesan" class="flex gap-4 items-end">
                        <div class="flex-1 relative">
                            <textarea wire:model="pesanBaru" rows="3" class="w-full bg-slate-50 border-none rounded-[25px] px-6 py-4 text-sm font-medium focus:ring-4 focus:ring-indigo-500/10 pr-12 resize-none placeholder:text-slate-400 shadow-inner" placeholder="Tulis instruksi atau jawaban resolusi..."></textarea>
                            
                            <label class="absolute right-4 bottom-4 cursor-pointer text-slate-400 hover:text-indigo-600 transition-colors">
                                <input type="file" wire:model="lampiran" class="hidden">
                                <i class="fa-solid fa-paperclip text-lg"></i>
                            </label>
                        </div>
                        
                        <button type="submit" class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-xl shadow-indigo-500/30 hover:bg-indigo-700 transition-all active:scale-90 flex-shrink-0 group">
                            <i class="fa-solid fa-paper-plane text-xl group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>
                    @else
                    <div class="text-center py-6 bg-emerald-50 rounded-3xl border-2 border-dashed border-emerald-200">
                        <p class="text-xs font-black text-emerald-600 uppercase tracking-widest">Tiket ini telah diselesaikan</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Meta Info (Right) -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Customer Card -->
            <div class="bg-white rounded-[35px] p-8 border border-slate-100 shadow-sm text-center">
                <div class="w-20 h-20 rounded-full bg-indigo-50 flex items-center justify-center text-2xl font-black text-indigo-600 mx-auto mb-4 border-4 border-white shadow-lg">
                    {{ substr($tiket->pengguna->nama ?? 'A', 0, 1) }}
                </div>
                <h3 class="font-black text-slate-900 text-lg leading-tight">{{ $tiket->pengguna->nama ?? 'Tamu' }}</h3>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $tiket->pengguna->email ?? '-' }}</p>
                <div class="mt-6 pt-6 border-t border-slate-50 grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[9px] font-black text-slate-300 uppercase">Tier Member</p>
                        <p class="text-xs font-bold text-indigo-600">{{ $tiket->pengguna->level_member ?? 'Classic' }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-300 uppercase">Total Tiket</p>
                        <p class="text-xs font-bold text-slate-700">{{ $tiket->pengguna->tiket_bantuan_count ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Context Info -->
            <div class="bg-slate-900 rounded-[35px] p-8 text-white relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl -mr-10 -mt-10"></div>
                <h3 class="text-xs font-black uppercase tracking-widest text-indigo-300 mb-6 border-b border-white/10 pb-4">Metadata Tiket</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Departemen</span>
                        <span class="text-xs font-black uppercase">{{ $tiket->kategori ?? 'Umum' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">ID Tiket</span>
                        <span class="text-xs font-black uppercase font-mono">#{{ $tiket->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Respon Terakhir</span>
                        <span class="text-xs font-black uppercase">{{ $tiket->diperbarui_pada->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
