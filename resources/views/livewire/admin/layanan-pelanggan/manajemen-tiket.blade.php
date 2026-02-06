<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Pusat Bantuan</h1>
            <p class="text-slate-500 text-sm mt-1">Manajemen keluhan dan pertanyaan pelanggan.</p>
        </div>
        <div class="flex gap-2">
            <!-- Filter Tabs -->
            <button wire:click="$set('filterStatus', '')" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ $filterStatus == '' ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-slate-500 hover:bg-slate-50' }}">Semua</button>
            <button wire:click="$set('filterStatus', 'terbuka')" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ $filterStatus == 'terbuka' ? 'bg-rose-500 text-white shadow-md' : 'bg-white text-slate-500 hover:bg-slate-50' }}">Terbuka</button>
            <button wire:click="$set('filterStatus', 'diproses')" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ $filterStatus == 'diproses' ? 'bg-amber-500 text-white shadow-md' : 'bg-white text-slate-500 hover:bg-slate-50' }}">Diproses</button>
            <button wire:click="$set('filterStatus', 'selesai')" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ $filterStatus == 'selesai' ? 'bg-emerald-500 text-white shadow-md' : 'bg-white text-slate-500 hover:bg-slate-50' }}">Selesai</button>
        </div>
    </div>

    <!-- Ticket Grid -->
    <div class="grid gap-4">
        @foreach($daftarTiket as $tiket)
        <div class="bg-white rounded-[20px] p-6 border border-slate-100 shadow-sm hover:shadow-md transition-all cursor-pointer group" wire:click="bukaTiket({{ $tiket->id }})">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500">
                        {{ substr($tiket->pengguna->nama ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">{{ $tiket->pengguna->nama ?? 'Anonim' }}</h4>
                        <p class="text-xs text-slate-400">{{ $tiket->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @php
                    $badge = match($tiket->status) {
                        'terbuka' => 'bg-rose-100 text-rose-600',
                        'diproses' => 'bg-amber-100 text-amber-600',
                        'selesai' => 'bg-emerald-100 text-emerald-600',
                    };
                @endphp
                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $badge }}">
                    {{ $tiket->status }}
                </span>
            </div>
            
            <h3 class="font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">{{ $tiket->subjek }}</h3>
            <p class="text-sm text-slate-500 line-clamp-2">{{ $tiket->pesan }}</p>
            
            <div class="mt-4 pt-4 border-t border-slate-50 flex items-center gap-4 text-xs font-bold text-slate-400">
                <span class="flex items-center gap-1"><i class="fa-solid fa-layer-group"></i> {{ $tiket->kategori }}</span>
                <span class="flex items-center gap-1"><i class="fa-solid fa-hashtag"></i> #TKT-{{ $tiket->id }}</span>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-6">
        {{ $daftarTiket->links() }}
    </div>

    <!-- Detail & Chat Slide Over -->
    <x-ui.panel-geser id="detail-tiket" judul="Detail Tiket Bantuan">
        @if($tiketTerpilih)
        <div class="flex flex-col h-full pb-20">
            
            <!-- Info Panel -->
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 mb-6">
                <h3 class="font-bold text-slate-900 mb-1">{{ $tiketTerpilih->subjek }}</h3>
                <div class="flex justify-between items-center text-xs mt-2">
                    <span class="font-mono text-slate-500">#TKT-{{ $tiketTerpilih->id }}</span>
                    <div class="flex gap-2">
                        @if($tiketTerpilih->status !== 'selesai')
                            <button wire:click="ubahStatus('selesai')" class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg font-bold hover:bg-emerald-200 transition-colors">
                                <i class="fa-solid fa-check"></i> Selesaikan
                            </button>
                        @endif
                        @if($tiketTerpilih->status !== 'diproses' && $tiketTerpilih->status !== 'selesai')
                            <button wire:click="ubahStatus('diproses')" class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg font-bold hover:bg-amber-200 transition-colors">
                                <i class="fa-solid fa-spinner"></i> Proses
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Chat History -->
            <div class="flex-1 overflow-y-auto space-y-4 pr-2 mb-4">
                <!-- Pesan Awal User -->
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-full bg-slate-200 flex-shrink-0 flex items-center justify-center text-xs font-bold text-slate-600">
                        {{ substr($tiketTerpilih->pengguna->nama ?? 'U', 0, 1) }}
                    </div>
                    <div class="bg-white border border-slate-200 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[85%]">
                        <p class="text-xs font-bold text-slate-900 mb-1">{{ $tiketTerpilih->pengguna->nama ?? 'User' }}</p>
                        <p class="text-sm text-slate-700">{{ $tiketTerpilih->pesan }}</p>
                        <span class="text-[10px] text-slate-400 mt-2 block">{{ $tiketTerpilih->created_at->format('H:i') }}</span>
                    </div>
                </div>

                @if($tiketTerpilih->riwayat_pesan)
                    @foreach($tiketTerpilih->riwayat_pesan as $chat)
                        <div class="flex gap-3 {{ $chat['pengirim'] == 'admin' ? 'flex-row-reverse' : '' }}">
                            <div class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold text-white {{ $chat['pengirim'] == 'admin' ? 'bg-indigo-600' : 'bg-slate-200 text-slate-600' }}">
                                {{ substr($chat['nama'], 0, 1) }}
                            </div>
                            <div class="p-3 rounded-2xl shadow-sm max-w-[85%] {{ $chat['pengirim'] == 'admin' ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white border border-slate-200 rounded-tl-none' }}">
                                <p class="text-xs font-bold mb-1 {{ $chat['pengirim'] == 'admin' ? 'text-indigo-200' : 'text-slate-900' }}">{{ $chat['nama'] }}</p>
                                <p class="text-sm">{{ $chat['pesan'] }}</p>
                                <span class="text-[10px] mt-2 block {{ $chat['pengirim'] == 'admin' ? 'text-indigo-300' : 'text-slate-400' }}">{{ \Carbon\Carbon::parse($chat['waktu'])->format('H:i') }}</span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Reply Box -->
            <div class="fixed bottom-0 right-0 w-full md:w-[480px] bg-white border-t border-slate-200 p-4 z-50">
                @if($tiketTerpilih->status == 'selesai')
                    <div class="text-center p-4 bg-slate-50 rounded-xl border border-slate-200 text-sm font-bold text-slate-500">
                        Tiket ini telah ditutup.
                    </div>
                @else
                    <form wire:submit.prevent="kirimBalasan" class="relative">
                        <textarea wire:model="pesanBaru" rows="3" class="w-full rounded-2xl border-slate-200 pr-12 focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="Tulis balasan..."></textarea>
                        <button type="submit" class="absolute right-2 bottom-2 p-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @endif
    </x-ui.panel-geser>
</div>