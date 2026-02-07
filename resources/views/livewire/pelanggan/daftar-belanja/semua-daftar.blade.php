<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Daftar <span class="text-indigo-600">Belanja</span></h1>
                <p class="text-slate-500 font-medium text-sm mt-2">Simpan kebutuhan rutin Anda untuk checkout cepat.</p>
            </div>
            
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg">
                    + Buat Daftar
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-xl border border-slate-100 p-4 z-20" style="display: none;">
                    <form wire:submit.prevent="buatDaftar">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Nama Daftar Baru</label>
                        <input wire:model="nama_baru" type="text" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-500 mb-3" placeholder="Misal: Bulanan Kantor">
                        <button type="submit" @click="open = false" class="w-full py-2 bg-indigo-600 text-white rounded-lg text-xs font-bold">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        @if($this->daftarSaya->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($this->daftarSaya as $daftar)
            <div class="group relative bg-white rounded-[2.5rem] p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute top-6 right-6">
                    <button wire:click="hapus({{ $daftar->id }})" class="text-slate-300 hover:text-rose-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>

                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                    📝
                </div>

                <h3 class="text-lg font-black text-slate-900 mb-1">{{ $daftar->nama_daftar }}</h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">{{ $daftar->items_count }} Item Tersimpan</p>

                <div class="flex flex-col gap-2">
                    <a href="{{ route('pelanggan.daftar-belanja.detail', $daftar->id) }}" class="w-full py-3 bg-white border-2 border-slate-100 text-slate-600 text-center rounded-xl text-xs font-black uppercase tracking-widest hover:border-indigo-600 hover:text-indigo-600 transition-all">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-24 bg-white rounded-[3rem] border border-dashed border-slate-200">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl opacity-50">📋</div>
            <h3 class="text-slate-900 font-black mb-1">Belum Ada Daftar</h3>
            <p class="text-slate-400 text-sm mb-6">Buat daftar belanja untuk mengelompokkan kebutuhan Anda.</p>
        </div>
        @endif

    </div>
</div>
