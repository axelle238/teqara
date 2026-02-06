<div class="animate-in fade-in duration-500 pb-20">
    
    @if(!$tampilkanForm)
        <!-- TAMPILAN 1: PUSAT KAMPANYE PROMO (FULL PAGE LIST) -->
        <div class="space-y-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="space-y-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <span class="text-[9px] font-black text-amber-600 uppercase tracking-widest">Akselerasi Penjualan</span>
                    </div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Voucher & Kode Promo</h1>
                    <p class="text-slate-500 font-medium">Strategi insentif belanja untuk meningkatkan loyalitas pelanggan.</p>
                </div>
                <button wire:click="tambahBaru" class="flex items-center gap-3 px-8 py-4 bg-amber-500 hover:bg-amber-600 text-white rounded-3xl text-sm font-black shadow-xl shadow-amber-500/20 transition-all active:scale-95">
                    <i class="fa-solid fa-ticket-simple text-lg"></i> RILIS KAMPANYE BARU
                </button>
            </div>

            <!-- Toolbar Search -->
            <div class="bg-white p-4 rounded-[30px] border border-indigo-50 flex items-center px-6 gap-4 shadow-sm">
                <i class="fa-solid fa-magnifying-glass text-slate-300"></i>
                <input wire:model.live.debounce.300ms="cari" type="text" placeholder="Cari kode promo atau deskripsi..." class="flex-1 bg-transparent border-none text-sm font-bold text-slate-700 focus:ring-0 placeholder:text-slate-300">
            </div>

            <!-- Grid Voucher -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @forelse($vouchers as $v)
                <div class="group bg-white rounded-[45px] p-1 border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 relative overflow-hidden flex">
                    <!-- Ticket Left Side -->
                    <div class="w-1/3 bg-amber-50 rounded-l-[40px] border-r-4 border-dashed border-white flex flex-col items-center justify-center p-6 text-center space-y-2 group-hover:bg-amber-100 transition-colors">
                        <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Nilai Diskon</p>
                        <h3 class="text-3xl font-black text-amber-700 tracking-tighter">
                            {{ $v->tipe_diskon === 'persen' ? $v->nilai_diskon.'%' : 'Rp'.number_format($v->nilai_diskon/1000, 0).'k' }}
                        </h3>
                        <div class="w-10 h-10 rounded-2xl bg-white flex items-center justify-center text-amber-500 shadow-sm">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                    </div>

                    <!-- Ticket Right Side -->
                    <div class="flex-1 p-8 space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-xl font-black text-slate-800 tracking-tight font-mono uppercase">{{ $v->kode }}</h4>
                                <p class="text-xs font-bold text-slate-400 mt-1">{{ $v->deskripsi ?? 'Tanpa deskripsi publik.' }}</p>
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="edit({{ $v->id }})" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-amber-100 hover:text-amber-600 flex items-center justify-center transition-all shadow-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button wire:click="hapus({{ $v->id }})" wire:confirm="Hentikan kampanye promo ini?" class="w-10 h-10 rounded-xl bg-rose-50 text-rose-400 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-all shadow-sm">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-50">
                            <div>
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Ketersediaan</p>
                                <p class="text-xs font-bold text-slate-600">{{ $v->kuota }} Tersisa</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Min. Belanja</p>
                                <p class="text-xs font-bold text-slate-600">Rp{{ number_format($v->min_pembelian, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="pt-2">
                            <span class="text-[9px] font-black text-amber-600 uppercase tracking-[0.2em] bg-amber-50 px-3 py-1 rounded-lg border border-amber-100">
                                Berlaku s/d: {{ \Carbon\Carbon::parse($v->berlaku_sampai)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center bg-white rounded-[50px] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-ticket-simple text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Belum Ada Promo</h3>
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Segera luncurkan kampanye diskon perdana Anda.</p>
                </div>
                @endforelse
            </div>

            <div class="pt-10">
                {{ $vouchers->links() }}
            </div>
        </div>
    @else
        <!-- TAMPILAN 2: EDITOR STRATEGI PROMO (FULL PAGE FORM) -->
        <div class="space-y-8 animate-in slide-in-from-right-8 duration-500">
            <!-- Header Editor -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-indigo-50">
                <div class="flex items-center gap-6">
                    <button wire:click="batal" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                    </button>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">{{ $voucherId ? 'Sunting Parameter Promo' : 'Rancang Kampanye Baru' }}</h1>
                        <p class="text-slate-500 font-medium text-[10px] uppercase tracking-widest">Konfigurator Diskon Enterprise Teqara</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button wire:click="batal" class="px-8 py-4 bg-slate-50 text-slate-500 rounded-3xl text-sm font-black hover:bg-slate-100 transition-all">BATAL</button>
                    <button wire:click="simpan" class="px-10 py-4 bg-amber-500 hover:bg-amber-600 text-white rounded-3xl text-sm font-black shadow-xl shadow-amber-500/20 transition-all active:scale-95">TERBITKAN PROMO</button>
                </div>
            </div>

            <!-- Editor Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kolom Kiri: Konfigurasi Nilai -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-10">
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Kode Promo (ID)</label>
                                    <div class="flex gap-3">
                                        <input wire:model="kode" type="text" class="flex-1 bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-indigo-600 focus:ring-4 focus:ring-amber-500/10 uppercase font-mono" placeholder="Ketik atau acak...">
                                        <button wire:click="generateCode" type="button" class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all flex items-center justify-center">
                                            <i class="fa-solid fa-shuffle"></i>
                                        </button>
                                    </div>
                                    @error('kode') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest mt-2 block">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Metode Potongan</label>
                                    <select wire:model="tipe_diskon" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-amber-500/10">
                                        <option value="persen">📈 PERSENTASE (%)</option>
                                        <option value="nominal">💰 NOMINAL RUPIAH (IDR)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Narasi Singkat Promo</label>
                                <input wire:model="deskripsi" type="text" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-amber-500/10 placeholder:text-slate-300" placeholder="Cth: Diskon Hari Raya Gadget 2026">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-slate-50">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Nilai Potongan Harga</label>
                                <div class="relative">
                                    <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-300">{{ $tipe_diskon === 'persen' ? '%' : 'Rp' }}</span>
                                    <input wire:model="nilai_diskon" type="number" class="w-full bg-slate-50 border-none rounded-2xl pl-14 pr-6 py-4 text-lg font-black text-slate-800 focus:ring-4 focus:ring-amber-500/10">
                                </div>
                                @error('nilai_diskon') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest mt-2 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Minimal Pembelian (Opsional)</label>
                                <div class="relative">
                                    <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-300">Rp</span>
                                    <input wire:model="min_pembelian" type="number" class="w-full bg-slate-50 border-none rounded-2xl pl-14 pr-6 py-4 text-lg font-black text-slate-800 focus:ring-4 focus:ring-amber-500/10">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Kuota & Validitas -->
                <div class="space-y-8">
                    <!-- Batasan Kampanye -->
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-8">
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Ketersediaan Voucher</label>
                            <input wire:model="kuota" type="number" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-xl font-black text-slate-800 focus:ring-4 focus:ring-amber-500/10 text-center">
                            @error('kuota') <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest text-center block">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-4 pt-8 border-t border-slate-50">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Maksimal Potongan (IDR)</label>
                            <input wire:model="maks_potongan" type="number" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 focus:ring-4 focus:ring-amber-500/10" placeholder="Biarkan kosong jika tidak dibatasi...">
                        </div>
                    </div>

                    <!-- Masa Berlaku -->
                    <div class="bg-white p-10 rounded-[50px] shadow-sm border border-indigo-50 space-y-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Waktu Aktivasi</label>
                            <input wire:model="berlaku_mulai" type="datetime-local" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-xs font-black text-slate-800 focus:ring-4 focus:ring-amber-500/10 uppercase">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Waktu Kedaluwarsa</label>
                            <input wire:model="berlaku_sampai" type="datetime-local" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-xs font-black text-slate-800 focus:ring-4 focus:ring-amber-500/10 uppercase">
                        </div>
                    </div>

                    <!-- Strategi Enterprise -->
                    <div class="bg-amber-500 p-10 rounded-[50px] text-white shadow-2xl shadow-amber-500/30 space-y-4 relative overflow-hidden group">
                        <i class="fa-solid fa-chart-line text-4xl opacity-20 absolute -right-4 -top-4 group-hover:scale-150 transition-transform duration-1000"></i>
                        <h4 class="text-lg font-black uppercase tracking-tight">Strategi Diskon</h4>
                        <p class="text-xs font-bold text-amber-50 leading-relaxed opacity-90">
                            "Voucher dengan persentase (10-20%) cenderung meningkatkan jumlah item per transaksi dibandingkan potongan nominal kecil."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
