<div class="bg-slate-50 min-h-screen py-12 font-sans antialiased text-slate-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('bantuan') }}" class="flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-indigo-600 transition-colors mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Pusat Bantuan
                </a>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Tiket #{{ str_pad($tiket->id, 5, '0', STR_PAD_LEFT) }}</h1>
                <p class="text-sm font-bold text-slate-500 mt-1">{{ $tiket->subjek }}</p>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest {{ $tiket->status == 'selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ $tiket->status }}
                </span>
                @if($tiket->status != 'selesai')
                <button wire:click="tutupTiket" class="px-4 py-2 bg-white border border-rose-200 text-rose-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-rose-50 transition-all">
                    Tutup Tiket
                </button>
                @endif
            </div>
        </div>

        <!-- Chat Area -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden flex flex-col h-[600px]">
            
            <!-- Messages List -->
            <div class="flex-1 overflow-y-auto p-8 space-y-6 bg-slate-50/50 scrollbar-thin scrollbar-thumb-slate-200">
                <div class="text-center">
                    <span class="px-4 py-1 bg-slate-200 rounded-full text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                        Tiket Dibuat: {{ $tiket->dibuat_pada->format('d M Y, H:i') }}
                    </span>
                </div>

                @foreach($tiket->riwayat_pesan as $pesan)
                <div class="flex flex-col {{ $pesan['pengirim'] == 'user' ? 'items-end' : 'items-start' }}">
                    <div class="max-w-[80%] {{ $pesan['pengirim'] == 'user' ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white border border-slate-200 text-slate-700 rounded-tl-none' }} rounded-2xl p-5 shadow-sm relative group">
                        <p class="text-sm leading-relaxed font-medium whitespace-pre-wrap">{{ $pesan['pesan'] }}</p>
                        
                        <!-- Attachments -->
                        @if(!empty($pesan['lampiran']))
                        <div class="mt-3 pt-3 border-t {{ $pesan['pengirim'] == 'user' ? 'border-indigo-500' : 'border-slate-100' }}">
                            @foreach($pesan['lampiran'] as $file)
                            <a href="{{ asset($file) }}" target="_blank" class="flex items-center gap-2 text-xs font-bold hover:underline {{ $pesan['pengirim'] == 'user' ? 'text-indigo-200' : 'text-indigo-600' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                Lihat Lampiran
                            </a>
                            @endforeach
                        </div>
                        @endif

                        <span class="text-[9px] font-bold uppercase tracking-widest absolute -bottom-5 {{ $pesan['pengirim'] == 'user' ? 'right-0 text-slate-400' : 'left-0 text-slate-400' }}">
                            {{ \Carbon\Carbon::parse($pesan['waktu'])->format('H:i') }} • {{ $pesan['nama'] }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Input Area -->
            <div class="p-6 bg-white border-t border-slate-100">
                @if($tiket->status != 'selesai')
                <form wire:submit.prevent="kirimPesan" class="flex gap-4 items-end">
                    <div class="flex-1 relative">
                        <textarea wire:model="pesanBaru" rows="2" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-indigo-500 pr-12 resize-none placeholder:text-slate-400" placeholder="Ketik balasan Anda..."></textarea>
                        
                        <!-- Attachment Button -->
                        <label class="absolute right-3 bottom-3 cursor-pointer text-slate-400 hover:text-indigo-600 transition-colors">
                            <input type="file" wire:model="lampiran" class="hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        </label>
                    </div>
                    
                    <button type="submit" class="w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-indigo-700 transition-all hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5 translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </form>
                @if($lampiran)
                    <div class="mt-2 text-xs font-bold text-emerald-600 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        File terpilih: {{ $lampiran->getClientOriginalName() }}
                    </div>
                @endif
                @else
                <div class="text-center py-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <p class="text-sm font-bold text-slate-500">Tiket ini telah ditutup. Silakan buat tiket baru jika ada pertanyaan lain.</p>
                </div>
                @endif
            </div>

        </div>

    </div>
</div>
