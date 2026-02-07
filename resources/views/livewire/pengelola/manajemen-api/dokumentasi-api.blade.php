<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- HEADER -->
    <div class="bg-indigo-900 rounded-[40px] p-12 text-white relative overflow-hidden shadow-2xl">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500 rounded-full blur-[120px] opacity-30 -mr-20 -mt-20"></div>
        
        <div class="relative z-10 space-y-4">
            <span class="px-4 py-1 bg-white/10 border border-white/20 rounded-full text-[10px] font-black uppercase tracking-[0.3em]">Developer Resources</span>
            <h1 class="text-5xl font-black tracking-tighter uppercase leading-none">TEQARA <span class="text-cyan-400">REST API</span></h1>
            <p class="text-lg text-indigo-100 max-w-2xl font-medium leading-relaxed">Hubungkan ekosistem bisnis Anda dengan Teqara Hub menggunakan API standar industri kami.</p>
        </div>
    </div>

    <!-- DOCUMENTATION CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10 items-start">
        
        <!-- SIDEBAR NAV -->
        <div class="lg:col-span-1 space-y-2 sticky top-28">
            @foreach(['pengenalan' => 'Pengenalan', 'autentikasi' => 'Autentikasi', 'produk' => 'Endpoint Produk', 'pesanan' => 'Endpoint Pesanan', 'pelanggan' => 'Endpoint Pelanggan', 'admin' => 'Admin API (Internal)'] as $key => $label)
            <button wire:click="setTab('{{ $key }}')" 
                    class="w-full text-left px-6 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ $tabAktif === $key ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>

        <!-- CONTENT AREA -->
        <div class="lg:col-span-3 bg-white rounded-[40px] border border-slate-200 shadow-sm p-10 min-h-[600px]">
            
            @if($tabAktif === 'admin')
            <div class="space-y-6 animate-in slide-in-from-bottom-4 duration-500">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Admin API (Internal)</h2>
                <p class="text-slate-600 leading-relaxed font-medium">Endpoint khusus untuk otomasi tugas administratif dan sinkronisasi HRD.</p>
                <div class="p-6 bg-rose-50 rounded-3xl border border-rose-100 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="px-3 py-1.5 bg-rose-500 text-white text-[10px] font-black rounded-lg">GET</span>
                        <span class="text-sm font-bold text-slate-700 font-mono">/v1/admin/laporan/stok</span>
                    </div>
                    <span class="text-[10px] font-black text-rose-400 uppercase">Admin Access Only</span>
                </div>
            </div>
            @endif
            @if($tabAktif === 'pengenalan')
            <div class="space-y-6 animate-in slide-in-from-bottom-4 duration-500">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Selamat Datang di Teqara API</h2>
                <p class="text-slate-600 leading-relaxed font-medium">API Teqara memungkinkan developer untuk mengakses data katalog, mengelola pesanan, dan mengintegrasikan sistem inventaris dengan aplikasi eksternal (Mobile, ERP, atau Dasbor Kustom).</p>
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Base URL</h4>
                    <code class="text-indigo-600 font-black font-mono bg-white px-4 py-2 rounded-xl border border-indigo-100">https://api.teqara.com/v16</code>
                </div>
            </div>
            @endif

            @if($tabAktif === 'autentikasi')
            <div class="space-y-6 animate-in slide-in-from-bottom-4 duration-500">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Autentikasi Token</h2>
                <p class="text-slate-600 leading-relaxed font-medium">Gunakan Header `Authorization` dengan tipe `Bearer` untuk setiap permintaan API. Token dapat digenerate melalui panel Manajemen Kunci API.</p>
                <div class="bg-slate-900 p-6 rounded-3xl text-emerald-400 font-mono text-sm leading-relaxed">
                    <p>curl -X GET "https://api.teqara.com/v1/produk" \</p>
                    <p class="pl-4">-H "Authorization: Bearer TEQARA_API_TOKEN"</p>
                </div>
            </div>
            @endif

            @if($tabAktif === 'produk')
            <div class="space-y-8 animate-in slide-in-from-bottom-4 duration-500">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-2">Endpoint Produk</h2>
                    <p class="text-slate-600 leading-relaxed font-medium">Gunakan endpoint ini untuk sinkronisasi katalog produk ke aplikasi pihak ketiga.</p>
                </div>

                <div class="space-y-6">
                    <!-- GET ALL -->
                    <div class="bg-slate-50 rounded-3xl border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-200 flex items-center justify-between bg-white">
                            <div class="flex items-center gap-4">
                                <span class="px-3 py-1.5 bg-emerald-500 text-white text-[10px] font-black rounded-lg">GET</span>
                                <span class="text-sm font-bold text-slate-700 font-mono">/v1/produk</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-400 uppercase">Rate Limit: 100/min</span>
                        </div>
                        <div class="p-6 space-y-4">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Query Parameters</p>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-3 bg-white rounded-xl border border-slate-200">
                                    <code class="text-indigo-600 font-bold text-xs">cari</code>
                                    <p class="text-[10px] text-slate-400 mt-1">String - Cari nama produk</p>
                                </div>
                                <div class="p-3 bg-white rounded-xl border border-slate-200">
                                    <code class="text-indigo-600 font-bold text-xs">kategori</code>
                                    <p class="text-[10px] text-slate-400 mt-1">Slug - Filter per kategori</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- GET DETAIL -->
                    <div class="bg-slate-50 rounded-3xl border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-200 flex items-center justify-between bg-white">
                            <div class="flex items-center gap-4">
                                <span class="px-3 py-1.5 bg-emerald-500 text-white text-[10px] font-black rounded-lg">GET</span>
                                <span class="text-sm font-bold text-slate-700 font-mono">/v1/produk/{id}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Response Sample (200 OK)</p>
                            <div class="bg-slate-900 p-6 rounded-2xl text-[11px] font-mono text-emerald-400 leading-relaxed shadow-inner">
                                <pre>{
  "success": true,
  "data": {
    "id": 101,
    "nama": "MacBook Pro M3",
    "harga": 24999000,
    "stok": 15,
    "varian": [...]
  }
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($tabAktif === 'pesanan')
            <div class="space-y-8 animate-in slide-in-from-bottom-4 duration-500">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-2">Endpoint Pesanan</h2>
                    <p class="text-slate-600 leading-relaxed font-medium">Otomasi pembuatan pesanan dan pengecekan status transaksi.</p>
                </div>

                <div class="space-y-6">
                    <div class="bg-slate-50 rounded-3xl border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-200 flex items-center justify-between bg-white">
                            <div class="flex items-center gap-4">
                                <span class="px-3 py-1.5 bg-indigo-600 text-white text-[10px] font-black rounded-lg">POST</span>
                                <span class="text-sm font-bold text-slate-700 font-mono">/v1/pesanan/buat</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Request Body (JSON)</p>
                            <div class="bg-slate-900 p-6 rounded-2xl text-[11px] font-mono text-indigo-300 leading-relaxed">
                                <pre>{
  "items": [
    {"produk_id": 101, "qty": 1},
    {"produk_id": 105, "qty": 2}
  ],
  "alamat_id": 45
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($tabAktif === 'pelanggan')
            <div class="space-y-8 animate-in slide-in-from-bottom-4 duration-500">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-2">Endpoint Pelanggan</h2>
                    <p class="text-slate-600 leading-relaxed font-medium">Manajemen profil dan sinkronisasi data member.</p>
                </div>

                <div class="space-y-4">
                    <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <span class="px-3 py-1.5 bg-emerald-500 text-white text-[10px] font-black rounded-lg">GET</span>
                            <span class="text-sm font-bold text-slate-700 font-mono">/v1/profil</span>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase">User Profile Data</span>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <span class="px-3 py-1.5 bg-amber-500 text-white text-[10px] font-black rounded-lg">PUT</span>
                            <span class="text-sm font-bold text-slate-700 font-mono">/v1/profil/update</span>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase">Update Info</span>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>
