<div class="min-h-screen flex bg-white">
    
    <!-- Kolom Kiri: Form -->
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white z-10 relative">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div class="mb-10">
                <a href="/" wire:navigate class="flex items-center gap-3 mb-8 group w-fit">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-cyan-500/30 group-hover:scale-110 transition-transform">T</div>
                    <span class="text-2xl font-black tracking-tighter text-slate-900 uppercase">TEQARA</span>
                </a>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Selamat Datang Kembali</h2>
                <p class="mt-2 text-sm text-slate-500 font-medium">
                    Belum punya akun? 
                    <a href="/register" wire:navigate class="font-bold text-cyan-600 hover:text-cyan-500 transition">Daftar sekarang</a>
                </p>
            </div>

            <div class="mt-8">
                <form wire:submit.prevent="masuk" class="space-y-6">
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-900 uppercase tracking-widest mb-2">Alamat Email</label>
                        <div class="mt-1 relative rounded-2xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input wire:model="email" id="email" type="email" autocomplete="email" required class="block w-full pl-12 pr-4 py-4 border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm font-medium transition-all bg-slate-50 focus:bg-white" placeholder="nama@perusahaan.com">
                        </div>
                        @error('email') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-900 uppercase tracking-widest mb-2">Kata Sandi</label>
                        <div class="mt-1 relative rounded-2xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input wire:model="password" id="password" type="password" autocomplete="current-password" required class="block w-full pl-12 pr-4 py-4 border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm font-medium transition-all bg-slate-50 focus:bg-white" placeholder="••••••••">
                        </div>
                        @error('password') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input wire:model="ingatSaya" id="remember-me" type="checkbox" class="h-4 w-4 text-cyan-600 focus:ring-cyan-500 border-slate-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm font-bold text-slate-600">Ingat perangkat ini</label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-bold text-cyan-600 hover:text-cyan-500 transition">Lupa sandi?</a>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-xl shadow-cyan-500/20 text-sm font-black text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-all uppercase tracking-widest">
                            Akses Dashboard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Visual Branding -->
    <div class="hidden lg:block relative w-0 flex-1 bg-slate-900 overflow-hidden">
        <!-- Abstract Tech Background -->
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1550745165-9bc0b252726f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2850&q=80')] bg-cover bg-center opacity-40"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/90 via-slate-900/80 to-cyan-900/50"></div>
        
        <div class="absolute inset-0 flex flex-col justify-center px-20">
            <div class="relative z-10">
                <div class="w-20 h-1 bg-cyan-500 mb-8 rounded-full"></div>
                <h1 class="text-5xl font-black text-white leading-tight mb-6">
                    Masa Depan <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">Komputasi Enterprise</span>
                </h1>
                <p class="text-xl text-slate-300 font-medium max-w-lg leading-relaxed">
                    Kelola infrastruktur IT perusahaan Anda dengan platform pengadaan paling canggih di Indonesia.
                </p>
                
                <div class="mt-12 flex gap-4">
                    <div class="flex -space-x-4">
                        <img class="w-12 h-12 rounded-full border-4 border-slate-900" src="https://ui-avatars.com/api/?name=CEO&background=0891b2&color=fff" alt="">
                        <img class="w-12 h-12 rounded-full border-4 border-slate-900" src="https://ui-avatars.com/api/?name=CTO&background=4f46e5&color=fff" alt="">
                        <img class="w-12 h-12 rounded-full border-4 border-slate-900" src="https://ui-avatars.com/api/?name=IT&background=10b981&color=fff" alt="">
                    </div>
                    <div class="flex flex-col justify-center">
                        <p class="text-white font-bold text-sm">Bergabung bersama</p>
                        <p class="text-slate-400 text-xs font-bold">10.000+ Profesional IT</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-500/20 rounded-full blur-[120px] -translate-y-1/4 translate-x-1/4"></div>
    </div>
</div>