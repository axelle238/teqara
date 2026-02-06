<div class="space-y-12 pb-32">
    <!-- Header with Breadcrumb & Actions -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 bg-white p-10 rounded-[48px] shadow-sm border border-indigo-50">
        <div class="space-y-3">
            <div class="flex items-center gap-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">
                <a href="{{ route('pengelola.produk.so.riwayat') }}" wire:navigate class="hover:text-blue-600 transition-colors">Riwayat SO</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-blue-600">Sesi Aktif</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">SESI AUDIT <span class="text-blue-600">{{ $so->kode_so }}</span></h1>
            <div class="flex items-center gap-4 mt-2">
                <span class="px-3 py-1 bg-{{ $so->status === 'selesai' ? 'emerald' : 'amber' }}-50 text-{{ $so->status === 'selesai' ? 'emerald' : 'amber' }}-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-{{ $so->status === 'selesai' ? 'emerald' : 'amber' }}-100">
                    STATUS: {{ $so->status }}
                </span>
                <span class="text-sm font-bold text-slate-500">Mulai: {{ \Carbon\Carbon::parse($so->tgl_mulai)->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        @if($so->status !== 'selesai')
        <div class="flex items-center gap-3">
            <button 
                wire:click="finalisasi" 
                wire:confirm="PERINGATAN FINAL: Sistem akan otomatis menyesuaikan stok produk berdasarkan selisih yang tercatat. Tindakan ini tidak dapat dibatalkan. Lanjutkan?"
                class="px-8 py-4 bg-slate-900 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl flex items-center gap-3"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Finalisasi & Sesuaikan Stok
            </button>
        </div>
        @endif
    </div>

    @if($so->status !== 'selesai')
    <!-- Search & Add Item -->
    <div class="bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50 relative z-20">
        <div class="relative">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-2">Tambahkan Item ke Daftar Hitung</label>
            <input 
                wire:model.live.debounce.300ms="cariProduk" 
                type="text" 
                placeholder="Ketik Nama Produk atau SKU..." 
                class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-900 focus:ring-4 focus:ring-blue-500/10 transition-all"
            >
            
            @if(count($hasilPencarian) > 0)
            <div class="absolute top-full left-0 w-full mt-2 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-30">
                @foreach($hasilPencarian as $p)
                <button 
                    wire:click="tambahItem({{ $p->id }})" 
                    class="w-full text-left p-4 hover:bg-blue-50 transition-colors flex items-center justify-between group border-b border-slate-50 last:border-0"
                >
                    <div>
                        <p class="font-black text-slate-900 text-sm uppercase">{{ $p->nama }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $p->kode_unit }}</p>
                    </div>
                    <span class="text-xs font-bold text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity">Tambahkan +</span>
                </button>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Tabel Hitung -->
    <div class="bg-white rounded-[56px] shadow-sm border border-indigo-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Item Audit</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] text-center">Stok Sistem</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] text-center">Stok Fisik (Input)</th>
                        <th class="px-6 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] text-center">Selisih</th>
                        <th class="px-10 py-6 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($detail as $d)
                    <tr class="group hover:bg-blue-50/10 transition-all">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 p-1">
                                    <img src="{{ $d->produk->gambar_utama_url }}" class="w-full h-full object-contain">
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900 uppercase">{{ $d->produk->nama }}</p>
                                    <p class="text-[9px] font-mono text-slate-400 uppercase tracking-widest">{{ $d->produk->kode_unit }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <span class="text-sm font-bold text-slate-500">{{ $d->stok_sistem }}</span>
                        </td>
                        <td class="px-6 py-6 text-center">
                            @if($so->status === 'selesai')
                                <span class="text-lg font-black text-slate-900">{{ $d->stok_fisik }}</span>
                            @else
                                <input 
                                    type="number" 
                                    value="{{ $d->stok_fisik }}" 
                                    @change="$wire.updateFisik({{ $d->id }}, $event.target.value)"
                                    class="w-24 text-center rounded-xl border-slate-200 bg-slate-50 focus:ring-blue-500 font-black text-lg p-2"
                                >
                            @endif
                        </td>
                        <td class="px-6 py-6 text-center">
                            @php
                                $selisih = $d->selisih;
                                $color = $selisih == 0 ? 'slate' : ($selisih > 0 ? 'emerald' : 'rose');
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-xs font-black {{ 'bg-'.$color.'-100 text-'.$color.'-600' }}">
                                {{ $selisih > 0 ? '+' : '' }}{{ $selisih }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            @if($d->selisih == 0)
                                <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Sesuai</span>
                            @else
                                <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest">Selisih</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-10 py-20 text-center text-slate-400 font-black uppercase tracking-widest text-xs">Belum ada item dalam daftar hitung.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
