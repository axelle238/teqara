<div class="space-y-12 pb-32">
    <!-- Breadcrumb & Identity -->
    <div class="flex flex-col md:flex-row md:items-center gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <a href="{{ route('pengelola.produk.katalog') }}" wire:navigate class="w-16 h-16 rounded-[24px] bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-indigo-600 hover:text-white transition-all shadow-inner group">
            <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 rounded-[28px] bg-indigo-50 border border-indigo-100 p-3 flex-shrink-0 shadow-sm">
                <img src="{{ $produk->gambar_utama_url }}" class="w-full h-full object-contain">
            </div>
            <div class="space-y-1">
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase leading-none">KONFIGURASI <span class="text-indigo-600">TEKNIS</span></h1>
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-emerald-100">Live Sync</span>
                </div>
                <p class="text-slate-500 font-medium text-lg">Unit: <span class="font-black text-slate-900">{{ $produk->nama }}</span></p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Control Center (Left) -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Quick Template -->
            <div class="bg-indigo-600 rounded-[40px] p-8 text-white shadow-2xl shadow-indigo-600/20 relative overflow-hidden group">
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <h3 class="text-xl font-black uppercase tracking-tight mb-6 relative z-10">Preset Master</h3>
                <div class="space-y-4 relative z-10">
                    <select wire:model="kategoriTemplate" class="w-full bg-white/10 border-white/20 rounded-2xl p-4 text-xs font-black uppercase tracking-widest focus:ring-white/30 text-white cursor-pointer transition-colors">
                        <option value="laptop" class="text-slate-900">💻 Laptop / Notebook</option>
                        <option value="gadget" class="text-slate-900">📱 Smartphone / Gadget</option>
                        <option value="periferal" class="text-slate-900">⌨️ Periferal / Aksesoris</option>
                    </select>
                    <button wire:click="terapkanTemplate" class="w-full py-4 bg-white text-indigo-600 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl hover:bg-indigo-50 transition-all active:scale-95">
                        Terapkan Kerangka Kerja
                    </button>
                </div>
            </div>

            <!-- Manual Entry Form -->
            <div class="bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50 space-y-8">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-1.5 bg-slate-900 rounded-full"></span>
                    <h3 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400">Parameter Baru</h3>
                </div>
                <form wire:submit.prevent="tambah" class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Label Parameter</label>
                        <input wire:model="inputJudul" type="text" class="w-full rounded-2xl border-none bg-slate-50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300" placeholder="Contoh: Chipset">
                        @error('inputJudul') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nilai Data</label>
                        <input wire:model="inputNilai" type="text" class="w-full rounded-2xl border-none bg-slate-50 px-6 py-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300" placeholder="Contoh: Apple M3 Chip">
                        @error('inputNilai') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[28px] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/10">
                        Sematkan Parameter
                    </button>
                </form>
            </div>
        </div>

        <!-- Data Grid (Right) -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
                <div class="p-10 border-b border-indigo-50 bg-slate-50/30 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Matriks Spesifikasi</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Status: {{ count($spesifikasi) }} Parameter Aktif</p>
                    </div>
                </div>

                <div class="divide-y divide-slate-50">
                    @forelse($spesifikasi as $s)
                    <div class="px-10 py-8 flex flex-col sm:flex-row sm:items-center justify-between gap-6 group hover:bg-indigo-50/20 transition-all duration-500" wire:key="spec-{{ $s->id }}">
                        <div class="flex-1 space-y-1">
                            <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] block">{{ $s->label }}</span>
                            <div class="relative max-w-lg">
                                <input 
                                    type="text" 
                                    value="{{ $s->nilai }}" 
                                    @blur="$wire.updateNilai({{ $s->id }}, $event.target.value)"
                                    class="w-full bg-transparent border-none p-0 text-2xl font-black text-slate-900 tracking-tighter focus:ring-0 placeholder:text-slate-200 uppercase leading-none"
                                >
                                <div class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-500 transition-all duration-500 group-hover:w-full"></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">Auto-Save Aktif</span>
                            <button 
                                wire:click="hapus({{ $s->id }})" 
                                wire:confirm="Hapus parameter '{{ $s->label }}'?"
                                class="w-14 h-14 bg-white border border-rose-100 text-rose-400 hover:text-white hover:bg-rose-600 rounded-[20px] transition-all shadow-sm flex items-center justify-center transform group-hover:rotate-6"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="py-32 flex flex-col items-center justify-center text-center space-y-6">
                        <div class="w-24 h-24 rounded-[32px] bg-slate-50 flex items-center justify-center text-slate-200 border-2 border-dashed border-slate-100">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a2 2 0 00-1.96 1.414l-.718 2.154a2 2 0 001.103 2.456l.005.001c.615.31 1.35.333 1.94.06a2 2 0 001.042-1.041l.001-.001z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-black text-slate-900 uppercase">Matriks Kosong</h4>
                            <p class="text-slate-400 font-medium">Gunakan preset atau tambah parameter manual di sisi kiri.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
