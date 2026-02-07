<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Preferensi <span class="text-indigo-600">Notifikasi</span></h1>
            <p class="text-slate-500 font-medium text-sm mt-2">Atur bagaimana kami menghubungi Anda.</p>
        </div>

        <div class="bg-white rounded-[32px] p-10 border border-slate-100 shadow-xl">
            <div class="space-y-8">
                
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Transaksi & Pesanan</h3>
                        <p class="text-xs text-slate-500 mt-1">Status pengiriman, invoice, dan konfirmasi pembayaran.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="notifikasi_transaksi" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>

                <div class="h-px bg-slate-100 w-full"></div>

                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Promo & Diskon</h3>
                        <p class="text-xs text-slate-500 mt-1">Info flash sale, voucher eksklusif, dan penawaran spesial.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="notifikasi_promo" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>

                <div class="h-px bg-slate-100 w-full"></div>

                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Newsletter Buletin</h3>
                        <p class="text-xs text-slate-500 mt-1">Artikel teknologi, tips, dan wawasan industri mingguan.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="newsletter_email" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>

            </div>

            <div class="mt-10 pt-8 border-t border-slate-100 flex justify-end">
                <button wire:click="simpan" class="px-8 py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg hover:shadow-indigo-500/30">
                    Simpan Perubahan
                </button>
            </div>
        </div>

    </div>
</div>
