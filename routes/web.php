<?php

use App\Livewire\Beranda;
use Illuminate\Support\Facades\Route;

// --- WEBHOOKS ---
Route::post('/payment/midtrans/notification', [\App\Http\Controllers\MidtransNotificationController::class, 'handle'])->name('payment.midtrans.notification');

// --- SEO & UTILITAS ---
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// --- RUTE PUBLIK ---
Route::get('/', Beranda::class)->name('beranda');
Route::get('/katalog', \App\Livewire\Katalog::class)->name('katalog');
Route::get('/produk/{slug}', \App\Livewire\Produk\DetailProduk::class)->name('produk.detail');
Route::get('/pencarian', \App\Livewire\PencarianGlobal::class)->name('pencarian');
Route::get('/berita', \App\Livewire\Berita\DaftarBerita::class)->name('berita.daftar');
Route::get('/berita/{slug}', \App\Livewire\Berita\DetailBerita::class)->name('berita.detail');
Route::get('/tentang-kami', \App\Livewire\Pelanggan\TentangKami::class)->name('tentang-kami');
Route::get('/bantuan', \App\Livewire\LayananPelanggan\PusatBantuan::class)->name('bantuan');

// --- OTENTIKASI ---
Route::get('/masuk', \App\Livewire\Otentikasi\Masuk::class)->name('login');
Route::get('/daftar', \App\Livewire\Otentikasi\Daftar::class)->name('register');
Route::redirect('/login', '/masuk');
Route::redirect('/register', '/daftar');
Route::get('/keluar', function () {
    auth()->logout(); session()->invalidate(); session()->regenerateToken(); return redirect('/');
})->name('logout');

// --- RUTE PELANGGAN (Authenticated) ---
Route::middleware(['auth'])->group(function () {
    // Dashboard & Profil
    Route::get('/dashboard', \App\Livewire\Pelanggan\Beranda::class)->name('customer.dashboard');
    Route::get('/panel-kontrol', function() { return redirect()->route('customer.dashboard'); })->name('dashboard');
    Route::get('/profil', \App\Livewire\Pelanggan\Profil::class)->name('customer.profile');
    Route::get('/profil-bisnis', \App\Livewire\Pelanggan\ProfilBisnis::class)->name('customer.business-profile');
    Route::get('/alamat', \App\Livewire\Pelanggan\BukuAlamat::class)->name('customer.address');
    Route::get('/keamanan', \App\Livewire\Pelanggan\PengaturanKeamanan::class)->name('customer.security');
    Route::get('/riwayat-login', \App\Livewire\Pelanggan\RiwayatLogin::class)->name('customer.security.log');
    
    // Transaksi & Belanja
    Route::get('/keranjang', \App\Livewire\KeranjangBelanja::class)->name('keranjang');
    Route::get('/checkout', \App\Livewire\Checkout::class)->name('checkout');
    Route::get('/pesanan', \App\Livewire\Pesanan\Riwayat::class)->name('pesanan.riwayat');
    Route::get('/pesanan/lacak/{invoice}', \App\Livewire\Pelanggan\DetailPesanan::class)->name('pesanan.lacak');
    Route::get('/pesanan/bayar/{invoice}', \App\Livewire\Pelanggan\BayarPesanan::class)->name('pesanan.bayar');
    Route::get('/pesanan/faktur/{invoice}', \App\Http\Controllers\CetakFakturController::class)->name('pesanan.faktur');
    Route::get('/pesanan/{id}/batal', \App\Livewire\Pelanggan\BatalkanPesanan::class)->name('pesanan.batal');
    Route::get('/ulasan/{pesananId}/{produkId}', \App\Livewire\Pelanggan\BeriUlasan::class)->name('ulasan.buat');
    Route::get('/ulasan-saya', \App\Livewire\Pelanggan\UlasanSaya::class)->name('customer.reviews');
    Route::get('/beli-lagi', \App\Livewire\Pelanggan\BeliLagi::class)->name('customer.buy-again');
    Route::get('/wishlist', \App\Livewire\Pelanggan\DaftarKeinginan::class)->name('wishlist');
    Route::get('/wishlist/{id}', \App\Livewire\Pelanggan\DaftarBelanja\DetailDaftar::class)->name('customer.wishlist.detail'); // Reuse wishlist concept as DaftarBelanja detail or create specific
    Route::get('/daftar-belanja', \App\Livewire\Pelanggan\DaftarBelanja\SemuaDaftar::class)->name('customer.wishlist.index'); // Mapping to Daftar Belanja
    Route::get('/bandingkan', \App\Livewire\Produk\Bandingkan::class)->name('bandingkan');

    // Fitur Enterprise B2B
    Route::get('/penawaran', \App\Livewire\Pelanggan\Penawaran\DaftarPenawaran::class)->name('customer.rfq.index');
    Route::get('/penawaran/baru', \App\Livewire\Pelanggan\Penawaran\BuatPenawaran::class)->name('customer.rfq.create');
    Route::get('/penawaran/{id}', \App\Livewire\Pelanggan\Penawaran\DetailPenawaran::class)->name('customer.rfq.detail');
    Route::get('/langganan', \App\Livewire\Pelanggan\Langganan\DaftarLangganan::class)->name('customer.subscription.index');
    Route::get('/langganan/{id}', \App\Livewire\Pelanggan\Langganan\DetailLangganan::class)->name('customer.subscription.detail');
    Route::get('/tim', \App\Livewire\Pelanggan\ManajemenTim::class)->name('customer.team');
    Route::get('/api-access', \App\Livewire\Pelanggan\AksesApi::class)->name('customer.api');

    // Loyalitas & Wallet
    Route::get('/poin', \App\Livewire\Pelanggan\JejakPoin::class)->name('customer.points');
    Route::get('/checkin', \App\Livewire\Pelanggan\Poin\AbsensiHarian::class)->name('customer.checkin');
    Route::get('/tukar-poin', \App\Livewire\Pelanggan\Poin\TukarPoin::class)->name('customer.rewards');
    Route::get('/dompet', \App\Livewire\Pelanggan\DompetDigital::class)->name('customer.wallet');
    Route::get('/voucher', \App\Livewire\Pelanggan\VoucherSaya::class)->name('customer.vouchers');
    Route::get('/keanggotaan', \App\Livewire\Pelanggan\Keanggotaan::class)->name('customer.membership');
    Route::get('/referral', \App\Livewire\Pelanggan\Referral::class)->name('customer.referral');

    // Layanan & Lainnya
    Route::get('/notifikasi', \App\Livewire\Pelanggan\Notifikasi::class)->name('customer.notifications');
    Route::get('/tiket/{id}', \App\Livewire\LayananPelanggan\DetailTiket::class)->name('tiket.detail');
    Route::get('/ajukan-retur', \App\Livewire\Pelanggan\AjukanRetur::class)->name('customer.return');
    Route::get('/laporan-belanja', \App\Livewire\Pelanggan\LaporanBelanja::class)->name('customer.reports');
    Route::get('/unduhan', \App\Livewire\Pelanggan\PusatUnduhan::class)->name('customer.downloads');
    Route::get('/privasi', \App\Livewire\Pelanggan\PusatPrivasi::class)->name('customer.privacy');
});

// --- RUTE ADMIN / PENGELOLA (Enterprise) ---
// Middleware: auth + cek role admin/staf
Route::middleware(['auth'])->prefix('pengelola')->group(function () {
    
    // Dashboard
    Route::get('/beranda', \App\Livewire\Pengelola\BerandaUtama::class)->name('pengelola.beranda');

    // Notifikasi Terpusat
    Route::get('/notifikasi', \App\Livewire\Pengelola\PusatNotifikasi::class)->name('pengelola.notifikasi.index');

    // Manajemen Produk (Inventory)
    Route::prefix('produk')->group(function () {
        Route::get('/', \App\Livewire\Pengelola\ManajemenProduk\ManajemenProduk::class)->name('pengelola.produk.katalog');
        Route::get('/tambah', \App\Livewire\Pengelola\ManajemenProduk\FormProduk::class)->name('pengelola.produk.tambah');
        Route::get('/edit/{id}', \App\Livewire\Pengelola\ManajemenProduk\FormProduk::class)->name('pengelola.produk.edit');
        Route::get('/stok', \App\Livewire\Pengelola\ManajemenProduk\ManajemenStok::class)->name('pengelola.produk.stok');
        Route::get('/gudang', \App\Livewire\Pengelola\ManajemenProduk\Gudang\DaftarGudang::class)->name('pengelola.produk.gudang');
        Route::get('/seri', \App\Livewire\Pengelola\ManajemenProduk\ManajemenSeri::class)->name('pengelola.produk.seri');
        Route::get('/garansi', \App\Livewire\Pengelola\ManajemenProduk\Garansi\ManajemenKlaim::class)->name('pengelola.produk.garansi');
        
        // Pengadaan
        Route::get('/pembelian', \App\Livewire\Pengelola\ManajemenProduk\Pembelian\RiwayatPembelian::class)->name('pengelola.produk.pembelian.riwayat');
        Route::get('/pembelian/baru', \App\Livewire\Pengelola\ManajemenProduk\Pembelian\FormPembelian::class)->name('pengelola.produk.pembelian.baru');
        Route::get('/pembelian/edit/{id}', \App\Livewire\Pengelola\ManajemenProduk\Pembelian\FormPembelian::class)->name('pengelola.produk.pembelian.edit');
        Route::get('/pembelian/detail/{id}', \App\Livewire\Pengelola\ManajemenProduk\Pembelian\FormPembelian::class)->name('pengelola.produk.pembelian.detail');
        Route::get('/stock-opname', \App\Livewire\Pengelola\ManajemenProduk\StockOpname\RiwayatStockOpname::class)->name('pengelola.produk.so.riwayat');
        
        // Promo
        Route::get('/flash-sale', \App\Livewire\Pengelola\ManajemenProduk\Promo\ManajemenFlashSale::class)->name('pengelola.produk.promo.flash-sale');
    });

    // Data Master
    Route::get('/kategori', \App\Livewire\Pengelola\ManajemenProduk\DaftarKategori::class)->name('pengelola.kategori');
    Route::get('/kategori/tambah', \App\Livewire\Pengelola\ManajemenProduk\Kategori\FormKategori::class)->name('pengelola.kategori.tambah');
    Route::get('/kategori/edit/{id}', \App\Livewire\Pengelola\ManajemenProduk\Kategori\FormKategori::class)->name('pengelola.kategori.edit');
    Route::get('/merek', \App\Livewire\Pengelola\ManajemenProduk\DaftarMerek::class)->name('pengelola.merek');
    Route::get('/merek/tambah', \App\Livewire\Pengelola\ManajemenProduk\Merek\FormMerek::class)->name('pengelola.merek.tambah');
    Route::get('/merek/edit/{id}', \App\Livewire\Pengelola\ManajemenProduk\Merek\FormMerek::class)->name('pengelola.merek.edit');
    
    // B2B & VENDOR
    Route::prefix('vendor')->group(function () {
        Route::get('/', \App\Livewire\Pengelola\ManajemenVendor\DaftarPemasok::class)->name('pengelola.vendor.daftar');
        Route::get('/tambah', \App\Livewire\Pengelola\ManajemenVendor\FormPemasok::class)->name('pengelola.vendor.tambah');
        Route::get('/edit/{id}', \App\Livewire\Pengelola\ManajemenVendor\FormPemasok::class)->name('pengelola.vendor.edit');
        Route::get('/penawaran', \App\Livewire\Pengelola\ManajemenVendor\ManajemenPenawaran::class)->name('pengelola.vendor.penawaran');
    });

    // Manajemen Pesanan
    Route::prefix('pesanan')->group(function () {
        Route::get('/', \App\Livewire\Pengelola\ManajemenPesanan\DaftarPesanan::class)->name('pengelola.pesanan.daftar');
        Route::get('/detail/{pesanan}', \App\Livewire\Pengelola\ManajemenPesanan\DetailPesanan::class)->name('pengelola.pesanan.detail');
        Route::get('/verifikasi', \App\Livewire\Pengelola\ManajemenPesanan\VerifikasiPembayaran::class)->name('pengelola.pesanan.verifikasi'); 
    });

    // Keuangan
    Route::prefix('transaksi')->group(function () {
        Route::get('/', \App\Livewire\Pengelola\ManajemenTransaksi\BerandaTransaksi::class)->name('pengelola.transaksi.beranda');
    });

    // Logistik
    Route::prefix('logistik')->group(function () {
        Route::get('/', \App\Livewire\Pengelola\ManajemenLogistik\BerandaLogistik::class)->name('pengelola.logistik.beranda');
    });

    // CRM & Pelanggan
    Route::prefix('pelanggan')->group(function () {
        Route::get('/', \App\Livewire\Pengelola\ManajemenPelanggan\DaftarMember::class)->name('pengelola.pelanggan.daftar');
        Route::get('/ulasan', \App\Livewire\Pengelola\ManajemenPelanggan\ManajemenUlasan::class)->name('pengelola.pelanggan.ulasan');
    });

    // Layanan (CS)
    Route::prefix('layanan')->group(function () {
        Route::get('/tiket', \App\Livewire\Pengelola\LayananPelanggan\ManajemenTiket::class)->name('pengelola.cs.tiket');
        Route::get('/tiket/{id}', \App\Livewire\Pengelola\LayananPelanggan\DetailTiketAdmin::class)->name('pengelola.cs.tiket.detail');
        Route::get('/', \App\Livewire\Pengelola\LayananPelanggan\ManajemenTiket::class)->name('pengelola.cs.beranda'); 
    });

    // Manajemen API
    Route::prefix('api')->group(function () {
        Route::get('/', \App\Livewire\Pengelola\ManajemenApi\PusatIntegrasi::class)->name('pengelola.api.pusat');
        Route::get('/kunci', \App\Livewire\Pengelola\ManajemenApi\DaftarKunciApi::class)->name('pengelola.api.kunci');
        Route::get('/log', \App\Livewire\Pengelola\ManajemenApi\LogAksesApi::class)->name('pengelola.api.log');
        Route::get('/dokumentasi', \App\Livewire\Pengelola\ManajemenApi\DokumentasiApi::class)->name('pengelola.api.dokumentasi');
        
        // Konfigurasi Integrasi
        Route::get('/pembayaran', \App\Livewire\Pengelola\ManajemenApi\KonfigurasiPembayaran::class)->name('pengelola.api.pembayaran');
        Route::get('/logistik', \App\Livewire\Pengelola\ManajemenApi\KonfigurasiLogistik::class)->name('pengelola.api.logistik');
        Route::get('/email', \App\Livewire\Pengelola\ManajemenApi\KonfigurasiEmail::class)->name('pengelola.api.email');
        Route::get('/whatsapp', \App\Livewire\Pengelola\ManajemenApi\KonfigurasiWhatsapp::class)->name('pengelola.api.whatsapp');
    });
    
    // PUSAT KEAMANAN (Security Operations)
    Route::prefix('keamanan')->group(function () {
        Route::get('/', \App\Livewire\Pengelola\ManajemenKeamanan\DashboardKeamanan::class)->name('pengelola.keamanan.dashboard');
        Route::get('/firewall', \App\Livewire\Pengelola\ManajemenKeamanan\AturanFirewallLivewire::class)->name('pengelola.keamanan.firewall');
        Route::get('/sesi', \App\Livewire\Pengelola\ManajemenKeamanan\MonitorSesi::class)->name('pengelola.keamanan.sesi');
        Route::get('/backup', \App\Livewire\Pengelola\ManajemenKeamanan\CadanganData::class)->name('pengelola.keamanan.backup');
        Route::get('/scanner', \App\Livewire\Pengelola\ManajemenKeamanan\PemindaiSistem::class)->name('pengelola.keamanan.pemindai');
    });

    // PUSAT KONTROL SISTEM
    Route::prefix('sistem')->group(function () {
        Route::get('/', \App\Livewire\Pengelola\ManajemenSistem\PusatPengaturan::class)->name('pengelola.sistem.pusat');
        Route::get('/kesehatan', \App\Livewire\Pengelola\ManajemenSistem\StatusKesehatan::class)->name('pengelola.sistem.kesehatan');
        // Route::get('/voucher', ... ) -> moved or kept for legacy if needed, but sidebar points here now
        Route::get('/voucher', \App\Livewire\Pengelola\PengaturanSistem\ManajemenVoucher::class)->name('pengelola.voucher');
        Route::get('/log', \App\Livewire\Pengelola\Log\DaftarLog::class)->name('pengelola.pengaturan.log');
    });

    // HRD (Pegawai)
    Route::prefix('hrd')->group(function () {
        Route::get('/karyawan', \App\Livewire\Pengelola\ManajemenPegawai\ManajemenKaryawan::class)->name('pengelola.pengguna.hrd');
        Route::get('/struktur', \App\Livewire\Pengelola\ManajemenPegawai\ManajemenStruktur::class)->name('pengelola.hrd.struktur');
    });

    // Laporan
    Route::get('/laporan', \App\Livewire\Pengelola\ManajemenLaporan\BerandaLaporan::class)->name('pengelola.laporan.pusat');

    // CMS & Konten
    Route::prefix('cms')->group(function () {
        Route::get('/berita', \App\Livewire\Pengelola\ManajemenToko\ManajemenBerita::class)->name('pengelola.toko.berita');
        Route::get('/konten', \App\Livewire\Pengelola\ManajemenToko\ManajemenKonten::class)->name('pengelola.toko.konten');
    });
});