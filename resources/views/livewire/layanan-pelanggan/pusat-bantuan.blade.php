<div class="bg-slate-50 min-h-screen py-16 relative overflow-hidden font-sans antialiased">
    <!-- Background Decor -->
    <div class="absolute top-0 left-0 w-full h-[500px] bg-indigo-600 -z-0">
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-50"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header Section -->
        <div class="text-center pt-8 pb-20">
            <h1 class="text-5xl font-black text-white uppercase tracking-tighter mb-6">Pusat <span class="text-indigo-200">Bantuan</span></h1>
            <p class="text-indigo-100 text-lg font-medium max-w-2xl mx-auto mb-12">Temukan solusi cepat untuk setiap pertanyaan Anda tentang layanan Teqara Enterprise.</p>
            
            <div class="max-w-2xl mx-auto relative group">
                <input type="text" placeholder="Apa yang bisa kami bantu hari ini?" class="w-full px-8 py-6 rounded-[2rem] bg-white border-none shadow-2xl text-lg font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/20 placeholder:text-slate-300 transition-all">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 p-4 bg-indigo-600 text-white rounded-2xl shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Support Channels Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
            <div class="bg-white rounded-[2.5rem] p-10 border border-white shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:-translate-y-2 transition-all group">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:bg-indigo-600 transition-all">💬</div>
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Live Chat</h3>
                <p class="text-slate-500 text-sm font-medium leading-relaxed mb-8">Bicara langsung dengan agen bantuan kami untuk respon instan.</p>
                <a href="#" class="text-xs font-black text-indigo-600 uppercase tracking-widest hover:underline">Mulai Chat →</a>
            </div>

            <div class="bg-white rounded-[2.5rem] p-10 border border-white shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:-translate-y-2 transition-all group">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:bg-emerald-600 transition-all">🎫</div>
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Tiket Support</h3>
                <p class="text-slate-500 text-sm font-medium leading-relaxed mb-8">Ajukan pertanyaan teknis atau komplain melalui sistem tiket terpadu.</p>
                <button @click="document.getElementById('buat-tiket').scrollIntoView({behavior: 'smooth'})" class="text-xs font-black text-indigo-600 uppercase tracking-widest hover:underline">Buka Tiket →</button>
            </div>

            <div class="bg-white rounded-[2.5rem] p-10 border border-white shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:-translate-y-2 transition-all group">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:bg-amber-600 transition-all">📞</div>
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">Pusat Panggilan</h3>
                <p class="text-slate-500 text-sm font-medium leading-relaxed mb-8">Hubungi hotline kami di 0800-1-TEQARA untuk bantuan mendesak.</p>
                <a href="tel:08001234567" class="text-xs font-black text-indigo-600 uppercase tracking-widest hover:underline">Hubungi Kami →</a>
            </div>
        </div>

        <!-- FAQ Sections -->
        <div class="bg-white rounded-[3rem] p-10 md:p-16 border border-white shadow-2xl shadow-slate-200/50">
            <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight mb-12 flex items-center gap-4">
                <span class="w-12 h-1.5 bg-indigo-600 rounded-full"></span>
                Pertanyaan Umum (FAQ)
            </h2>

            <div class="space-y-6" x-data="{ active: null }">
                @foreach($faqs as $index => $faq)
                <div class="border border-slate-50 rounded-[2rem] overflow-hidden bg-slate-50/30 transition-all duration-300" :class="{ 'bg-indigo-50/50 border-indigo-100': active === {{ $index }} }">
                    <button @click="active = (active === {{ $index }} ? null : {{ $index }})" class="w-full px-8 py-6 text-left flex items-center justify-between group">
                        <span class="font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $faq['q'] }}</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="{ 'rotate-180 text-indigo-600': active === {{ $index }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === {{ $index }}" x-collapse class="px-8 pb-8">
                        <p class="text-slate-600 text-sm font-medium leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Form Buat Tiket -->
        <div id="buat-tiket" class="mt-20 bg-white rounded-[3rem] p-10 md:p-16 border border-white shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50 rounded-full blur-3xl -mr-20 -mt-20 opacity-50"></div>
            
            <div class="relative z-10">
                <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight mb-4">Buat Tiket Baru</h2>
                <p class="text-slate-500 font-medium mb-10 max-w-xl">Ceritakan kendala Anda secara detail agar tim kami dapat memberikan solusi terbaik secepatnya.</p>

                <form wire:submit.prevent="kirimTiket" class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Judul Kendala</label>
                            <input type="text" wire:model="subjek" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300" placeholder="Cth: Pesanan belum sampai">
                            @error('subjek') <span class="text-rose-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-3">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Kategori</label>
                            <select wire:model="kategori" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-900 focus:ring-4 focus:ring-indigo-500/10 cursor-pointer">
                                <option value="umum">Pertanyaan Umum</option>
                                <option value="pesanan">Masalah Pesanan</option>
                                <option value="teknis">Kendala Teknis</option>
                                <option value="penagihan">Pembayaran & Tagihan</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Detail Pesan</label>
                        <textarea wire:model="pesan" rows="5" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-medium text-slate-900 focus:ring-4 focus:ring-indigo-500/10 placeholder:text-slate-300" placeholder="Jelaskan kronologi masalah..."></textarea>
                        @error('pesan') <span class="text-rose-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Lampiran (Opsional)</label>
                        <div class="flex items-center gap-4">
                            <label class="cursor-pointer inline-flex items-center gap-2 px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                Pilih File
                                <input type="file" wire:model="lampiran" class="hidden">
                            </label>
                            @if($lampiran)
                                <span class="text-xs font-bold text-emerald-600">File terpilih: {{ $lampiran->getClientOriginalName() }}</span>
                            @endif
                        </div>
                        @error('lampiran') <span class="text-rose-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-10 py-5 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/30 flex items-center gap-3">
                            <span wire:loading.remove wire:target="kirimTiket">Kirim Tiket</span>
                            <span wire:loading wire:target="kirimTiket">Mengirim...</span>
                            <svg wire:loading.remove wire:target="kirimTiket" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Still Need Help -->
        <div class="mt-20 text-center">
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-4">Masih Butuh Bantuan?</h3>
            <p class="text-slate-500 font-medium mb-8">Tim spesialis kami siap mendampingi Anda 24/7.</p>
            <a href="mailto:support@teqara.com" class="inline-flex items-center gap-3 px-10 py-5 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-2xl shadow-indigo-500/20 active:scale-95">
                Kirim Email Ke Support
            </a>
        </div>

    </div>
</div>
