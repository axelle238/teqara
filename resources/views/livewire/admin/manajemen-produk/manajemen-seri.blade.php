<div class="space-y-12 pb-32">
    <!-- Header: High-Tech Security Focus -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rose-50 border border-rose-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-rose-600 animate-pulse"></span>
                <span class="text-[10px] font-black text-rose-600 uppercase tracking-[0.3em]">Unit Identification Security</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">IMEI & <span class="text-rose-600">SERIAL</span></h1>
            <p class="text-slate-500 font-medium text-lg">Pusat kendali identitas unit tunggal untuk pelacakan garansi dan otentikasi stok.</p>
        </div>
        <button 
            wire:click="bukaPanelRegistrasi" 
            class="px-8 py-4 bg-slate-900 text-white rounded-3xl font-black text-xs uppercase tracking-widest shadow-2xl hover:bg-rose-600 transition-all active:scale-95 flex items-center gap-3"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"></path></svg>
            Registrasi Seri Massal
        </button>
    </div>

    <!-- Statistik Identitas -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm flex flex-col justify-between group hover:border-indigo-200 transition-all">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Populasi Seri terdata</span>
            <p class="text-4xl font-black text-slate-900 tracking-tighter group-hover:scale-110 transition-transform origin-left">{{ number_format($statistik['total']) }}</p>
        </div>
        <div class="bg-emerald-50 p-8 rounded-[40px] border border-emerald-100 flex flex-col justify-between">
            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-4">Siap Aktivasi</span>
            <p class="text-4xl font-black text-emerald-700 tracking-tighter">{{ number_format($statistik['tersedia']) }}</p>
        </div>
        <div class="bg-indigo-50 p-8 rounded-[40px] border border-indigo-100 flex flex-col justify-between">
            <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-4">Tangan Pelanggan</span>
            <p class="text-4xl font-black text-indigo-700 tracking-tighter">{{ number_format($statistik['terjual']) }}</p>
        </div>
        <div class="bg-rose-50 p-8 rounded-[40px] border border-rose-100 flex flex-col justify-between">
            <span class="text-[10px] font-black text-rose-600 uppercase tracking-widest mb-4">Anomali & Retur</span>
            <p class="text-4xl font-black text-rose-700 tracking-tighter">{{ number_format($statistik['masalah']) }}</p>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
        <!-- Toolbar Kontrol -->
        <div class="p-8 border-b border-indigo-50 bg-slate-50/30 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex flex-wrap items-center gap-4">
                <div class="relative w-72 group">
                    <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Identifikasi Seri/IMEI..." class="w-full pl-12 pr-4 py-4 bg-white border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-rose-500/10 shadow-sm transition-all">
                    <svg class="w-5 h-5 absolute left-4 top-4 text-slate-300 group-focus-within:text-rose-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <select wire:model.live="filterProduk" class="bg-white border-none rounded-2xl px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-500 focus:ring-4 focus:ring-rose-500/10 shadow-sm transition-all cursor-pointer">
                    <option value="">Semua Perangkat</option>
                    @foreach($semuaProduk as $p) <option value="{{ $p->id }}">{{ $p->nama }}</option> @endforeach
                </select>
            </div>
            
            <div class="flex items-center gap-2 bg-white p-1.5 rounded-2xl border border-indigo-50 shadow-inner">
                <button wire:click="$set('filterStatus', '')" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterStatus === '' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-400 hover:text-rose-600' }}">SEMUA</button>
                <button wire:click="$set('filterStatus', 'tersedia')" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterStatus === 'tersedia' ? 'bg-emerald-500 text-white shadow-lg' : 'text-slate-400 hover:text-rose-600' }}">TERSEDIA</button>
                <button wire:click="$set('filterStatus', 'terjual')" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $filterStatus === 'terjual' ? 'bg-indigo-500 text-white shadow-lg' : 'text-slate-400 hover:text-rose-600' }}">TERJUAL</button>
            </div>
        </div>

        <!-- Tabel Identitas -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Identitas Fisik (SN/IMEI)</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Subjek Perangkat</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Status Otoritas</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Waktu Data</th>
                        <th class="px-10 py-6 text-right">Otoritas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($daftarSeri as $s)
                    <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                        <td class="px-10 py-6">
                            <span class="text-lg font-black text-slate-900 tracking-tighter uppercase font-mono">{{ $s->nomor_seri }}</span>
                        </td>
                        <td class="px-6 py-6">
                            <p class="font-black text-slate-700 text-sm tracking-tight leading-none uppercase">{{ $s->produk->nama }}</p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $s->produk->kategori->nama }}</p>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-3">
                                @php
                                    $color = match($s->status) {
                                        'tersedia' => 'emerald',
                                        'terjual' => 'indigo',
                                        'rusak' => 'rose',
                                        'retur' => 'amber',
                                        default => 'slate'
                                    };
                                @endphp
                                <span class="px-3 py-1 bg-{{ $color }}-50 text-{{ $color }}-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-{{ $color }}-100">{{ $s->status }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-xs font-bold text-slate-500 uppercase">{{ $s->created_at->translatedFormat('d M Y') }}</p>
                            <p class="text-[9px] text-slate-400 mt-0.5 uppercase">{{ $s->created_at->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all transform group-hover:translate-x-0 translate-x-4">
                                <div class="relative group/menu" x-data="{ open: false }">
                                    <button @click="open = !open" class="p-3 bg-white border border-indigo-100 text-slate-400 hover:text-indigo-600 rounded-2xl transition-all shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-3xl shadow-2xl border border-indigo-50 p-3 z-20 animate-in fade-in zoom-in-95 duration-200">
                                        <button wire:click="ubahStatus({{ $s->id }}, 'tersedia')" class="w-full text-left px-4 py-2 text-[10px] font-black uppercase tracking-widest text-emerald-600 hover:bg-emerald-50 rounded-xl transition">Set Tersedia</button>
                                        <button wire:click="ubahStatus({{ $s->id }}, 'rusak')" class="w-full text-left px-4 py-2 text-[10px] font-black uppercase tracking-widest text-rose-600 hover:bg-rose-50 rounded-xl transition">Set Rusak</button>
                                        <button wire:click="ubahStatus({{ $s->id }}, 'retur')" class="w-full text-left px-4 py-2 text-[10px] font-black uppercase tracking-widest text-amber-600 hover:bg-amber-50 rounded-xl transition">Set Retur</button>
                                        <div class="my-2 border-t border-slate-50"></div>
                                        <button wire:click="hapus({{ $s->id }})" wire:confirm="Hapus data identitas seri ini?" class="w-full text-left px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:bg-slate-50 rounded-xl transition">Hapus Data</button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-10 py-32 text-center text-slate-300 font-black uppercase tracking-[0.3em] italic">Basis data identitas unit tidak terdeteksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-10 bg-slate-50/30 border-t border-slate-50 flex justify-center">{{ $daftarSeri->links() }}</div>
    </div>

    <!-- Panel Registrasi Seri Massal -->
    <x-ui.panel-geser id="panel-registrasi-seri" judul="REGISTRASI IDENTITAS UNIT">
        <form wire:submit.prevent="registrasiSeri" class="space-y-10 p-2">
            <div class="p-8 rounded-[32px] border-2 border-dashed bg-rose-50 border-rose-200 text-rose-800">
                <div class="flex items-center gap-4 mb-4">
                    <span class="text-3xl">🛡️</span>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em]">Protokol Keamanan Inventaris</p>
                        <h4 class="text-lg font-black tracking-tight leading-none uppercase">Input SN/IMEI Massal</h4>
                    </div>
                </div>
                <p class="text-xs font-medium leading-relaxed opacity-80">
                    Sistem akan secara otomatis menyinkronkan jumlah stok fisik produk berdasarkan total nomor seri yang berhasil divalidasi dan disimpan.
                </p>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Unit Sasaran</label>
                <select wire:model="produkTerpilihId" class="w-full bg-slate-50 border-none rounded-2xl p-5 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-rose-500/10">
                    <option value="">Pilih Produk</option>
                    @foreach($semuaProduk as $p) <option value="{{ $p->id }}">{{ $p->nama }}</option> @endforeach
                </select>
                @error('produkTerpilihId') <span class="text-rose-500 text-[10px] font-black uppercase tracking-widest px-1 block mt-2">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Daftar Nomor Seri (Satu per baris / Koma)</label>
                <textarea wire:model="inputSeriMassal" rows="10" class="w-full bg-slate-50 border-none rounded-[32px] p-8 text-sm font-mono font-bold text-slate-900 focus:ring-4 focus:ring-rose-500/10 transition-all placeholder:text-slate-300" placeholder="IMEI8829100293&#10;IMEI8829100294&#10;SN-LPT-99201"></textarea>
                @error('inputSeriMassal') <span class="text-rose-500 text-[10px] font-black uppercase tracking-widest px-1 block mt-2">{{ $message }}</span> @enderror
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-6 bg-slate-900 text-white rounded-[32px] font-black text-xs uppercase tracking-[0.3em] hover:bg-rose-600 transition-all shadow-2xl shadow-rose-500/20 active:scale-95 group">
                    <span wire:loading.remove>OTORISASI & SIMPAN</span>
                    <span wire:loading>VALIDASI DATABASE...</span>
                </button>
            </div>
        </form>
    </x-ui.panel-geser>
</div>
