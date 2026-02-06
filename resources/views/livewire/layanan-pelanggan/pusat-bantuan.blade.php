<div class="bg-slate-50 min-h-screen py-20 relative overflow-hidden">
    <!-- Decorative -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-500/5 blur-[120px] rounded-full translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-20 space-y-6">
            <span class="px-4 py-2 bg-white border border-indigo-100 rounded-full text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] shadow-sm">Dukungan Enterprise 24/7</span>
            <h1 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase leading-none">
                PUSAT <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-cyan-500">BANTUAN</span>
            </h1>
            <p class="text-lg text-slate-500 font-medium leading-relaxed">
                Kami siap membantu Anda mengoptimalkan pengalaman belanja teknologi. Temukan jawaban cepat atau hubungi tim spesialis kami.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Knowledge Base (FAQ) -->
            <div class="lg:col-span-7 space-y-8">
                <div class="bg-white rounded-[40px] p-8 border border-white shadow-xl shadow-slate-200/50">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Basis Pengetahuan</h3>
                        <div class="relative w-64">
                            <input 
                                wire:model.live.debounce.300ms="cariFaq" 
                                type="text" 
                                placeholder="Cari Topik..." 
                                class="w-full pl-10 pr-4 py-2 bg-slate-50 border-none rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500 transition-all"
                            >
                            <svg class="w-4 h-4 absolute left-3 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($faqs as $index => $faq)
                        <div class="border border-slate-100 rounded-3xl overflow-hidden transition-all duration-300 {{ $faqTerbuka === $index ? 'bg-indigo-50/50 border-indigo-100 shadow-sm' : 'bg-white hover:border-indigo-100' }}">
                            <button 
                                wire:click="toggleFaq({{ $index }})" 
                                class="w-full flex items-center justify-between p-6 text-left"
                            >
                                <span class="text-sm font-black text-slate-900 {{ $faqTerbuka === $index ? 'text-indigo-700' : '' }}">{{ $faq['q'] }}</span>
                                <span class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-slate-400 shadow-sm transition-transform duration-300 {{ $faqTerbuka === $index ? 'rotate-180 text-indigo-600' : '' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </span>
                            </button>
                            <div 
                                class="px-6 pb-6 text-sm text-slate-600 leading-relaxed overflow-hidden transition-all duration-300"
                                style="{{ $faqTerbuka === $index ? 'max-height: 500px; opacity: 1;' : 'max-height: 0; opacity: 0; padding-bottom: 0;' }}"
                            >
                                {{ $faq['a'] }}
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-10">
                            <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Topik tidak ditemukan.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Kontak Cepat -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-indigo-600 rounded-[32px] p-8 text-white relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                        <h4 class="font-black uppercase tracking-widest text-xs mb-2 text-indigo-200">Email Dukungan</h4>
                        <p class="text-xl font-bold">support@teqara.id</p>
                        <p class="text-[10px] mt-4 opacity-70">Respon dalam 24 jam kerja.</p>
                    </div>
                    <div class="bg-white rounded-[32px] p-8 border border-white shadow-lg relative overflow-hidden group">
                        <h4 class="font-black uppercase tracking-widest text-xs mb-2 text-slate-400">Hotline Prioritas</h4>
                        <p class="text-xl font-bold text-slate-900">1500-TEQ</p>
                        <p class="text-[10px] mt-4 text-slate-500">Senin - Jumat, 08:00 - 17:00 WIB.</p>
                    </div>
                </div>
            </div>

            <!-- Tiket Form -->
            <div class="lg:col-span-5 sticky top-32">
                <div class="bg-white rounded-[48px] p-10 border border-white shadow-2xl shadow-indigo-500/10">
                    <div class="mb-8">
                        <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight mb-2">Buat Tiket Baru</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tim spesialis akan menangani kendala Anda.</p>
                    </div>

                    @auth
                    <form wire:submit.prevent="kirimTiket" class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Subjek Kendala</label>
                            <input wire:model="subjek" type="text" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-slate-300" placeholder="Contoh: Pesanan belum sampai...">
                            @error('subjek') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Departemen</label>
                                <select wire:model="kategori" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-xs font-bold focus:ring-4 focus:ring-indigo-500/10">
                                    <option value="umum">Umum</option>
                                    <option value="teknis">Teknis Produk</option>
                                    <option value="penagihan">Pembayaran</option>
                                    <option value="pesanan">Logistik</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Urgensi</label>
                                <select wire:model="prioritas" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-xs font-bold focus:ring-4 focus:ring-indigo-500/10">
                                    <option value="rendah">Rendah</option>
                                    <option value="sedang">Sedang</option>
                                    <option value="tinggi">Tinggi (Darurat)</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Detail Kendala</label>
                            <textarea wire:model="pesan" rows="5" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-slate-300" placeholder="Jelaskan masalah secara rinci..."></textarea>
                            @error('pesan') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Lampiran (Opsional)</label>
                            <div class="relative group cursor-pointer bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-indigo-400 transition-colors">
                                <input type="file" wire:model="lampiran" class="absolute inset-0 opacity-0 cursor-pointer">
                                @if($lampiran)
                                    <span class="text-xs font-bold text-indigo-600">{{ $lampiran->getClientOriginalName() }}</span>
                                @else
                                    <span class="text-xs font-bold text-slate-400 group-hover:text-indigo-500 transition-colors">Klik untuk unggah tangkapan layar</span>
                                @endif
                            </div>
                            @error('lampiran') <span class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl hover:shadow-indigo-500/30 transform hover:-translate-y-1">
                            Kirim Tiket
                        </button>
                    </form>
                    @else
                    <div class="text-center py-10 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <p class="text-slate-500 font-bold text-sm mb-6">Silakan masuk untuk membuat tiket bantuan.</p>
                        <a href="/login" class="inline-block px-8 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-colors">Masuk Sekarang</a>
                    </div>
                    @endauth
                </div>
            </div>

        </div>
    </div>
</div>
