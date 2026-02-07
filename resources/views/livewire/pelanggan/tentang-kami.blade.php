<div class="bg-slate-50 min-h-screen py-12 font-sans text-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Hero Section -->
        <div class="text-center mb-16 animate-fade-in-down">
            <h1 class="text-4xl md:text-6xl font-black tracking-tighter uppercase mb-4">
                Membangun Masa Depan <br><span class="text-indigo-600">Teknologi Indonesia</span>
            </h1>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed">
                Teqara hadir sebagai platform Enterprise Commerce terdepan yang menjembatani kebutuhan teknologi bisnis dan personal dengan standar layanan kelas dunia.
            </p>
        </div>

        <!-- Vision Mission -->
        <div class="grid md:grid-cols-2 gap-8 mb-20 animate-fade-in-up">
            <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-xl shadow-indigo-500/5 relative overflow-hidden group hover:-translate-y-2 transition-all duration-500">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-full blur-3xl -z-0 opacity-50 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-3xl mb-6">🚀</div>
                    <h2 class="text-2xl font-black uppercase tracking-tight mb-4">Visi Kami</h2>
                    <p class="text-slate-600 leading-relaxed">
                        Menjadi ekosistem teknologi nomor satu di Asia Tenggara yang memberdayakan setiap individu dan organisasi melalui akses mudah terhadap inovasi digital terbaru.
                    </p>
                </div>
            </div>
            <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-xl shadow-emerald-500/5 relative overflow-hidden group hover:-translate-y-2 transition-all duration-500">
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-50 rounded-full blur-3xl -z-0 opacity-50 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl mb-6">🎯</div>
                    <h2 class="text-2xl font-black uppercase tracking-tight mb-4">Misi Kami</h2>
                    <ul class="space-y-3 text-slate-600">
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                            <span>Menyediakan produk original dengan jaminan purna jual resmi.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                            <span>Membangun rantai pasok yang efisien dan transparan.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                            <span>Memberikan pengalaman belanja B2B & B2C yang seamless.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Values -->
        <div class="mb-20">
            <h2 class="text-center text-2xl font-black uppercase tracking-widest mb-10 text-slate-400">Nilai Inti</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach([
                    ['icon' => '🛡️', 'title' => 'Integritas', 'desc' => 'Jujur dan transparan dalam setiap transaksi.'],
                    ['icon' => '💡', 'title' => 'Inovasi', 'desc' => 'Selalu beradaptasi dengan teknologi terbaru.'],
                    ['icon' => '🤝', 'title' => 'Kolaborasi', 'desc' => 'Tumbuh bersama mitra dan pelanggan.'],
                    ['icon' => '⚡', 'title' => 'Kecepatan', 'desc' => 'Layanan responsif dan pengiriman kilat.']
                ] as $val)
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 text-center hover:shadow-lg transition-all cursor-default">
                    <div class="text-4xl mb-4 grayscale hover:grayscale-0 transition-all">{{ $val['icon'] }}</div>
                    <h3 class="font-black text-slate-900 uppercase tracking-wide mb-2">{{ $val['title'] }}</h3>
                    <p class="text-xs text-slate-500">{{ $val['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Team / Contact CTA -->
        <div class="bg-indigo-900 rounded-[3rem] p-12 text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>
            <div class="relative z-10">
                <h2 class="text-3xl font-black uppercase tracking-tight mb-4">Siap Berkolaborasi?</h2>
                <p class="text-indigo-200 mb-8 max-w-xl mx-auto">
                    Hubungi tim enterprise kami untuk solusi pengadaan kantor atau kebutuhan proyek skala besar.
                </p>
                <a href="{{ route('bantuan') }}" class="inline-block px-8 py-4 bg-white text-indigo-900 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-50 transition-colors shadow-xl">
                    Hubungi Kami
                </a>
            </div>
        </div>

    </div>
</div>
