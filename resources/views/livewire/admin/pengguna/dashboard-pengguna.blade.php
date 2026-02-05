<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">MANAJEMEN <span class="text-slate-600">PENGGUNA</span></h1>
            <p class="text-slate-500 font-medium">Kontrol akses internal dan peran administrator.</p>
        </div>
        <button class="px-6 py-3 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition shadow-lg">
            Tambah Admin
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Administrator Utama</p>
            <p class="text-3xl font-black text-slate-900">{{ number_format($total_admin) }}</p>
        </div>
        <div class="bg-slate-50 p-8 rounded-[32px] border border-slate-200">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Staff Pendukung</p>
            <p class="text-3xl font-black text-slate-800">{{ number_format($total_staff) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Daftar Akses Internal</h3>
        </div>
        <div class="divide-y divide-slate-50">
            @foreach($daftar_admin as $a)
            <div class="px-8 py-5 flex items-center justify-between hover:bg-slate-50 transition">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold">{{ substr($a->nama, 0, 1) }}</div>
                    <div>
                        <p class="font-bold text-slate-900 text-sm">{{ $a->nama }}</p>
                        <p class="text-xs text-slate-500">{{ $a->email }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $a->peran == 'admin' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600' }}">
                    {{ $a->peran }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>
