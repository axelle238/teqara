<div class="animate-in fade-in zoom-in duration-500 pb-20">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Matriks <span class="text-rose-600">Keamanan</span></h1>
            <p class="text-slate-500 font-medium text-sm mt-1">Konfigurasi hak akses Role-Based Access Control (RBAC) per divisi.</p>
        </div>
        <div class="px-4 py-2 bg-rose-50 text-rose-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-rose-100 flex items-center gap-2">
            <i class="fa-solid fa-lock"></i> Area Terproteksi
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">
        @foreach($matriks as $peran => $hakAksesList)
        <div class="bg-white rounded-[35px] border border-slate-200 shadow-sm overflow-hidden flex flex-col h-full hover:shadow-xl hover:border-rose-200 transition-all duration-300">
            <!-- Header Role -->
            <div class="p-6 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-700 shadow-sm">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <h3 class="font-black text-slate-900 uppercase tracking-tight">{{ $peran }}</h3>
                </div>
                @if($peran === 'Admin')
                    <i class="fa-solid fa-star text-amber-400" title="Super User"></i>
                @endif
            </div>

            <!-- List Modul -->
            <div class="p-6 space-y-6 flex-1">
                @foreach($hakAksesList as $akses)
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-slate-300"></div>
                        <span class="text-xs font-bold text-slate-600 uppercase tracking-wide">{{ $akses->modul }}</span>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-2">
                        <!-- Toggle Baca -->
                        <button wire:click="toggleAkses({{ $akses->id }}, 'baca')" 
                            class="flex flex-col items-center justify-center p-2 rounded-xl border transition-all {{ $akses->baca ? 'bg-emerald-50 border-emerald-200 text-emerald-600' : 'bg-slate-50 border-slate-100 text-slate-300' }} {{ $peran === 'Admin' ? 'cursor-not-allowed opacity-70' : 'hover:scale-105' }}">
                            <i class="fa-solid fa-eye text-xs mb-1"></i>
                            <span class="text-[8px] font-black uppercase">Lihat</span>
                        </button>

                        <!-- Toggle Tulis -->
                        <button wire:click="toggleAkses({{ $akses->id }}, 'tulis')" 
                            class="flex flex-col items-center justify-center p-2 rounded-xl border transition-all {{ $akses->tulis ? 'bg-indigo-50 border-indigo-200 text-indigo-600' : 'bg-slate-50 border-slate-100 text-slate-300' }} {{ $peran === 'Admin' ? 'cursor-not-allowed opacity-70' : 'hover:scale-105' }}">
                            <i class="fa-solid fa-pen text-xs mb-1"></i>
                            <span class="text-[8px] font-black uppercase">Edit</span>
                        </button>

                        <!-- Toggle Hapus -->
                        <button wire:click="toggleAkses({{ $akses->id }}, 'hapus')" 
                            class="flex flex-col items-center justify-center p-2 rounded-xl border transition-all {{ $akses->hapus ? 'bg-rose-50 border-rose-200 text-rose-600' : 'bg-slate-50 border-slate-100 text-slate-300' }} {{ $peran === 'Admin' ? 'cursor-not-allowed opacity-70' : 'hover:scale-105' }}">
                            <i class="fa-solid fa-trash text-xs mb-1"></i>
                            <span class="text-[8px] font-black uppercase">Hapus</span>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="p-4 bg-slate-50 border-t border-slate-100 text-center">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">
                    {{ $peran === 'Admin' ? 'Akses Penuh Permanen' : 'Konfigurasi Kustom' }}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>
