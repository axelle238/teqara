<div class="animate-in fade-in slide-in-from-right-8 duration-500 pb-20">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Tim <span class="text-purple-600">Internal</span></h1>
            <p class="text-slate-500 font-medium text-sm mt-1">Kelola akses dan peran staf perusahaan.</p>
        </div>
        
        @if(!$tambahMode)
        <button wire:click="$set('tambahMode', true)" class="px-8 py-4 bg-purple-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-purple-700 shadow-xl shadow-purple-500/30 transition-all active:scale-95">
            <i class="fa-solid fa-user-plus mr-2"></i> Tambah Staf
        </button>
        @endif
    </div>

    @if($tambahMode)
    <div class="bg-white rounded-[40px] p-10 border border-purple-50 shadow-xl mb-10 animate-in slide-in-from-top-4">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest">Formulir Rekrutmen</h3>
            <button wire:click="$set('tambahMode', false)" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form wire:submit.prevent="simpan" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Lengkap</label>
                <input wire:model="nama" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 placeholder:text-slate-300">
                @error('nama') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Perusahaan</label>
                <input wire:model="email" type="email" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 placeholder:text-slate-300">
                @error('email') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Divisi / Peran</label>
                <select wire:model="peran" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 cursor-pointer">
                    <option value="admin">Administrator (Super User)</option>
                    <option value="editor">Editor Konten (Produk/Blog)</option>
                    <option value="cs">Customer Service (Tiket)</option>
                    <option value="gudang">Staf Gudang (Logistik)</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Password Akses</label>
                <input wire:model="password" type="password" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-purple-500/10 placeholder:text-slate-300">
                @error('password') <span class="text-rose-500 text-xs font-bold px-1">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2 pt-4 flex justify-end">
                <button type="submit" class="px-10 py-4 bg-purple-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-purple-700 shadow-lg shadow-purple-500/20 transition-all active:scale-95">
                    Simpan Data Karyawan
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Staff List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($karyawan as $staff)
        <div class="bg-white rounded-[35px] p-6 border border-slate-100 shadow-sm flex items-center gap-6 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
            <!-- Background Blob -->
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-purple-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>

            <div class="relative z-10 w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-xl font-black text-slate-400 shrink-0 uppercase">
                {{ substr($staff->nama, 0, 2) }}
            </div>
            
            <div class="relative z-10 flex-1 min-w-0">
                <h4 class="font-black text-slate-900 text-lg truncate">{{ $staff->nama }}</h4>
                <p class="text-xs text-slate-500 truncate mb-2">{{ $staff->email }}</p>
                <span class="inline-block px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest bg-purple-50 text-purple-700 border border-purple-100">
                    {{ strtoupper($staff->peran) }}
                </span>
            </div>

            @if($staff->id != auth()->id())
            <button wire:click="hapus({{ $staff->id }})" wire:confirm="Hapus akses karyawan ini?" class="absolute top-6 right-6 text-slate-300 hover:text-rose-500 transition-colors z-20">
                <i class="fa-solid fa-trash-can"></i>
            </button>
            @endif
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $karyawan->links() }}
    </div>
</div>
