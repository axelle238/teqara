<div class="flex min-h-[calc(100vh-8rem)] items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8 bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
        <div>
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-cyan-600 font-bold text-white text-2xl">T</div>
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-slate-900">Masuk ke Akun Anda</h2>
            <p class="mt-2 text-center text-sm text-slate-600">
                Belum punya akun?
                <a href="#" class="font-medium text-cyan-600 hover:text-cyan-500">Daftar sekarang (Segera)</a>
            </p>
        </div>
        <form class="mt-8 space-y-6" wire:submit="masuk">
            <div class="-space-y-px rounded-md shadow-sm">
                <div>
                    <label for="email-address" class="sr-only">Alamat Email</label>
                    <input wire:model="email" id="email-address" name="email" type="email" autocomplete="email" required class="relative block w-full rounded-t-md border-0 py-1.5 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6" placeholder="Alamat Email">
                </div>
                <div>
                    <label for="password" class="sr-only">Kata Sandi</label>
                    <input wire:model="kata_sandi" id="password" name="password" type="password" autocomplete="current-password" required class="relative block w-full rounded-b-md border-0 py-1.5 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6" placeholder="Kata Sandi">
                </div>
            </div>

            @error('email') <span class="text-red-500 text-sm text-center block">{{ $message }}</span> @enderror

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input wire:model="ingat_saya" id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-cyan-600 focus:ring-cyan-600">
                    <label for="remember-me" class="ml-2 block text-sm text-slate-900">Ingat saya</label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-cyan-600 hover:text-cyan-500">Lupa kata sandi?</a>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative flex w-full justify-center rounded-md bg-cyan-600 px-3 py-2 text-sm font-semibold text-white hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600 transition">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-cyan-500 group-hover:text-cyan-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Masuk
                </button>
            </div>
            
            <div class="mt-4 text-center">
                <p class="text-xs text-slate-400">Akun Demo Admin: admin@teqara.com / password</p>
            </div>
        </form>
    </div>
</div>
