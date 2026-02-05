<div class="bg-slate-50 min-h-screen py-12">
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-[32px] shadow-xl border border-slate-200 overflow-hidden">
            <!-- Header Produk -->
            <div class="p-8 border-b border-slate-100 flex gap-6 items-center bg-slate-50/50">
                <div class="w-20 h-20 rounded-2xl bg-white border border-slate-200 flex-shrink-0 p-2">
                    <img src="{{ $produk->gambar_utama_url }}" class="w-full h-full object-contain">
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Beri Nilai Produk</p>
                    <h1 class="text-xl font-black text-slate-900 leading-tight">{{ $produk->nama }}</h1>
                </div>
            </div>

            <form wire:submit.prevent="simpanUlasan" class="p-8 space-y-8">
                
                <!-- Rating Stars -->
                <div class="text-center">
                    <label class="block text-sm font-bold text-slate-600 mb-4">Seberapa puas Anda dengan produk ini?</label>
                    <div class="flex justify-center gap-2">
                        @for($i=1; $i<=5; $i++)
                        <button type="button" wire:click="$set('rating', {{ $i }})" class="transition-transform hover:scale-110 focus:outline-none">
                            <svg class="w-12 h-12 {{ $rating >= $i ? 'text-yellow-400 fill-current' : 'text-slate-200 fill-current' }}" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        </button>
                        @endfor
                    </div>
                    <p class="mt-2 text-sm font-bold text-cyan-600">
                        {{ $rating == 5 ? 'Sangat Puas! 😍' : ($rating == 4 ? 'Puas 😊' : ($rating == 3 ? 'Cukup 🙂' : 'Kurang Puas 😞')) }}
                    </p>
                </div>

                <!-- Komentar -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ceritakan pengalaman Anda</label>
                    <textarea wire:model="komentar" rows="4" class="w-full rounded-2xl border-slate-300 focus:border-cyan-500 focus:ring-cyan-500 text-sm" placeholder="Kualitas barang bagus, pengiriman cepat..."></textarea>
                    @error('komentar') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Upload Foto -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Foto Produk (Opsional)</label>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($foto as $f)
                        <div class="aspect-square rounded-xl overflow-hidden border border-slate-200">
                            <img src="{{ $f->temporaryUrl() }}" class="w-full h-full object-cover">
                        </div>
                        @endforeach
                        
                        <label class="aspect-square rounded-xl border-2 border-dashed border-slate-300 flex flex-col items-center justify-center cursor-pointer hover:border-cyan-500 hover:bg-cyan-50 transition">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span class="text-[10px] font-bold text-slate-500 mt-1">Upload</span>
                            <input type="file" wire:model="foto" multiple class="hidden">
                        </label>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold text-lg hover:bg-slate-800 transition shadow-lg shadow-slate-900/20">
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
