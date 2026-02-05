<div class="min-h-screen flex bg-white relative overflow-hidden">
    
    <!-- Abstract Colorful Ornaments -->
    <div class="absolute top-0 right-0 w-full h-full pointer-events-none -z-0">
        <div class="absolute top-[-10%] right-[-5%] w-[40%] h-[40%] bg-indigo-500/10 blur-[120px] rounded-full animate-pulse"></div>
        <div class="absolute bottom-[-5%] left-[-10%] w-[30%] h-[30%] bg-cyan-500/10 blur-[100px] rounded-full"></div>
    </div>

    <!-- Kolom Kiri: Form Masuk (Vibrant Light) -->
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-32 bg-white/80 backdrop-blur-md z-10 relative">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div class="mb-12">
                <a href="/" wire:navigate class="flex items-center gap-4 mb-10 group w-fit">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-600 to-cyan-600 flex items-center justify-center text-white font-black text-2xl shadow-xl shadow-indigo-500/20 group-hover:rotate-12 transition-transform">T</div>
                    <span class="text-2xl font-black tracking-tighter text-indigo-600 uppercase">TEQARA HUB</span>
                </a>
                <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none mb-2">SELAMAT <span class="text-indigo-600">DATANG</span></h2>
                <p class="text-sm text-slate-500 font-bold uppercase tracking-widest">Akses Portal Enterprise Anda</p>
            </div>

            <div class="mt-10">
                <form wire:submit.prevent="masuk" class="space-y-8">
                    <div class="space-y-2">
                        <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-1">Otoritas Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-indigo-300 group-focus-within:text-indigo-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input wire:model="email" id="email" type="email" autocomplete="email" required class="block w-full pl-12 pr-4 py-4 bg-indigo-50/50 border-none rounded-2xl text-slate-900 placeholder-slate-300 focus:ring-2 focus:ring-indigo-500 font-bold transition-all" placeholder="nama@perusahaan.com">
                        </div>
                        @error('email') <p class="mt-2 text-xs font-black text-rose-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-1">Kunci Akses</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-indigo-300 group-focus-within:text-indigo-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input wire:model="password" id="password" type="password" autocomplete="current-password" required class="block w-full pl-12 pr-4 py-4 bg-indigo-50/50 border-none rounded-2xl text-slate-900 placeholder-slate-300 focus:ring-2 focus:ring-indigo-500 font-bold transition-all" placeholder="••••••••">
                        </div>
                        @error('password') <p class="mt-2 text-xs font-black text-rose-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between px-1">
                        <div class="flex items-center">
                            <input wire:model="ingatSaya" id="remember-me" type="checkbox" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-indigo-100 rounded-lg bg-indigo-50 transition-all">
                            <label for="remember-me" class="ml-3 block text-xs font-black text-slate-500 uppercase tracking-widest cursor-pointer">Ingat Sesi</label>
                        </div>
                        <a href="#" class="text-xs font-black text-indigo-600 hover:text-indigo-700 transition uppercase tracking-widest">Lupa Sandi?</a>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-5 px-4 bg-gradient-to-r from-indigo-600 to-cyan-600 text-white rounded-[24px] shadow-2xl shadow-indigo-500/30 text-xs font-black uppercase tracking-[0.2em] hover:scale-[1.02] active:scale-95 transition-all">
                            AKTIVASI Beranda
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                        Belum Memiliki Otoritas? 
                        <a href="/register" wire:navigate class="text-indigo-600 hover:underline ml-1">Daftar Akun</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Visual High-Tech (No Dark Colors) -->
    <div class="hidden lg:block relative w-0 flex-1 bg-indigo-50 overflow-hidden shrink-0">
        <!-- Tech Canvas Background -->
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&q=80&w=2070')] bg-cover bg-center opacity-20 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/40 via-cyan-500/20 to-white/10"></div>
        
        <div class="absolute inset-0 flex flex-col justify-center px-24">
            <div class="relative z-10 space-y-8">
                <div class="w-24 h-1.5 bg-white rounded-full shadow-lg"></div>
                <h1 class="text-6xl font-black text-white leading-[1.1] tracking-tighter drop-shadow-2xl">
                    MASA DEPAN <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-cyan-100">KENDALI TI</span>
                </h1>
                <p class="text-xl text-indigo-100 font-bold max-w-lg leading-relaxed drop-shadow-md">
                    Ekosistem pengadaan unit teknologi tercanggih dengan alur kerja yang sangat presisi dan informatif.
                </p>
                
                <div class="pt-10 flex items-center gap-6">
                    <div class="flex -space-x-4">
                        <div class="w-14 h-14 rounded-full border-4 border-white bg-indigo-100 flex items-center justify-center text-xl shadow-2xl">🚀</div>
                        <div class="w-14 h-14 rounded-full border-4 border-white bg-cyan-100 flex items-center justify-center text-xl shadow-2xl">🛰️</div>
                        <div class="w-14 h-14 rounded-full border-4 border-white bg-emerald-100 flex items-center justify-center text-xl shadow-2xl">📡</div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-white font-black text-sm uppercase tracking-widest">Terintegrasi Penuh</p>
                        <p class="text-indigo-100 text-xs font-bold uppercase tracking-widest opacity-80">10.000+ Infrastruktur Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative Floating Elements -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-white/10 rounded-full blur-[80px] animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-cyan-400/20 rounded-full blur-[120px]"></div>
    </div>
</div>
