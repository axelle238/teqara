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

// --- RUTE PELANGGAN (Otentikasi) ---
Route::middleware(['auth'])->group(function () {
    // Dasbor & Profil
    Route::get('/dasbor', \App\Livewire\Pelanggan\Beranda::class)->name('pelanggan.dasbor');
    Route::get('/panel-kontrol', function() { return redirect()->route('pelanggan.dasbor'); })->name('dasbor');
    Route::get('/profil', \App\Livewire\Pelanggan\Profil::class)->name('pelanggan.profil');
    Route::get('/profil-bisnis', \App\Livewire\Pelanggan\ProfilBisnis::class)->name('pelanggan.profil-bisnis');
    Route::get('/alamat', \App\Livewire\Pelanggan\BukuAlamat::class)->name('pelanggan.alamat');
    Route::get('/keamanan', \App\Livewire\Pelanggan\PengaturanKeamanan::class)->name('pelanggan.keamanan');
    Route::get('/riwayat-login', \App\Livewire\Pelanggan\RiwayatLogin::class)->name('pelanggan.keamanan.log');
    
    // Transaksi & Belanja
    Route::get('/keranjang', \App\Livewire\KeranjangBelanja::class)->name('keranjang');
    Route::get('/checkout', \App\Livewire\Checkout::class)->name('checkout');
    Route::get('/pesanan', \App\Livewire\Pesanan\Riwayat::class)->name('pesanan.riwayat');
    Route::get('/pesanan/lacak/{invoice}', \App\Livewire\Pelanggan\DetailPesanan::class)->name('pesanan.lacak');
    Route::get('/pesanan/bayar/{invoice}', \App\Livewire\Pelanggan\BayarPesanan::class)->name('pesanan.bayar');
    Route::get('/pesanan/faktur/{invoice}', \App\Http\Controllers\CetakFakturController::class)->name('pesanan.faktur');
    Route::get('/pesanan/{id}/batal', \App\Livewire\Pelanggan\BatalkanPesanan::class)->name('pesanan.batal')->where('id', '[0-9]+');
    Route::get('/ulasan/{pesananId}/{produkId}', \App\Livewire\Pelanggan\BeriUlasan::class)->name('ulasan.buat');
    Route::get('/ulasan-saya', \App\Livewire\Pelanggan\UlasanSaya::class)->name('pelanggan.ulasan');
    Route::get('/beli-lagi', \App\Livewire\Pelanggan\BeliLagi::class)->name('pelanggan.beli-lagi');
    Route::get('/wishlist', \App\Livewire\Pelanggan\DaftarKeinginan::class)->name('daftar-keinginan');
    Route::get('/wishlist/{id}', \App\Livewire\Pelanggan\DaftarBelanja\DetailDaftar::class)->name('pelanggan.daftar-belanja.detail'); 
    Route::get('/daftar-belanja', \App\Livewire\Pelanggan\DaftarBelanja\SemuaDaftar::class)->name('pelanggan.daftar-belanja.indeks'); 
    Route::get('/bandingkan', \App\Livewire\Produk\Bandingkan::class)->name('bandingkan');

    // Fitur Enterprise B2B
    Route::get('/penawaran', \App\Livewire\Pelanggan\Penawaran\DaftarPenawaran::class)->name('pelanggan.penawaran.indeks');
    Route::get('/penawaran/baru', \App\Livewire\Pelanggan\Penawaran\BuatPenawaran::class)->name('pelanggan.penawaran.buat');
    Route::get('/penawaran/{id}', \App\Livewire\Pelanggan\Penawaran\DetailPenawaran::class)->name('pelanggan.penawaran.detail');
    Route::get('/langganan', \App\Livewire\Pelanggan\Langganan\DaftarLangganan::class)->name('pelanggan.langganan.indeks');
    Route::get('/langganan/{id}', \App\Livewire\Pelanggan\Langganan\DetailLangganan::class)->name('pelanggan.langganan.detail');
    Route::get('/tim', \App\Livewire\Pelanggan\ManajemenTim::class)->name('pelanggan.tim');
    Route::get('/api-access', \App\Livewire\Pelanggan\AksesApi::class)->name('pelanggan.api');

    // Loyalitas & Poin
    Route::get('/poin', \App\Livewire\Pelanggan\JejakPoin::class)->name('pelanggan.poin');
    Route::get('/checkin', \App\Livewire\Pelanggan\Poin\AbsensiHarian::class)->name('pelanggan.absen');
    Route::get('/tukar-poin', \App\Livewire\Pelanggan\Poin\TukarPoin::class)->name('pelanggan.tukar-poin');
    Route::get('/voucher', \App\Livewire\Pelanggan\VoucherSaya::class)->name('pelanggan.voucher');
    Route::get('/keanggotaan', \App\Livewire\Pelanggan\Keanggotaan::class)->name('pelanggan.keanggotaan');
    Route::get('/referral', \App\Livewire\Pelanggan\Referral::class)->name('pelanggan.referral');

    // Layanan & Lainnya
    Route::get('/notifikasi', \App\Livewire\Pelanggan\Notifikasi::class)->name('pelanggan.notifikasi');
    Route::get('/tiket/{id}', \App\Livewire\LayananPelanggan\DetailTiket::class)->name('tiket.detail');
    Route::get('/ajukan-retur', \App\Livewire\Pelanggan\AjukanRetur::class)->name('pelanggan.retur');
    Route::get('/laporan-belanja', \App\Livewire\Pelanggan\LaporanBelanja::class)->name('pelanggan.laporan');
    Route::get('/unduhan', \App\Livewire\Pelanggan\PusatUnduhan::class)->name('pelanggan.unduhan');
    Route::get('/privasi', \App\Livewire\Pelanggan\PusatPrivasi::class)->name('pelanggan.privasi');
});

// --- RUTE ADMIN / PENGELOLA (Enterprise) ---
Route::middleware(['auth', 'otorisasi'])->prefix('pengelola')->group(function () {
    
    Route::get('/beranda', \App\Livewire\Pengelola\BerandaUtama::class)->name('pengelola.beranda');
    Route::get('/notifikasi', \App\Livewire\Pengelola\PusatNotifikasi::class)->name('pengelola.notifikasi.index');

    // 1. Manajemen Halaman Toko
    Route::prefix('cms')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenToko\BerandaToko::class)->name('pengelola.toko.beranda');
        Route::get('/berita', \App\Livewire\Pengelola\ManajemenToko\ManajemenBerita::class)->name('pengelola.toko.berita');
        Route::get('/konten', \App\Livewire\Pengelola\ManajemenToko\ManajemenKonten::class)->name('pengelola.toko.konten');
    });

    // 2. Manajemen Produk & Gadget
    Route::prefix('produk')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenProduk\BerandaProduk::class)->name('pengelola.produk.beranda');
        Route::get('/', \App\Livewire\Pengelola\ManajemenProduk\ManajemenProduk::class)->name('pengelola.produk.katalog');
        Route::get('/tambah', \App\Livewire\Pengelola\ManajemenProduk\FormProduk::class)->name('pengelola.produk.tambah');
        Route::get('/edit/{id}', \App\Livewire\Pengelola\ManajemenProduk\FormProduk::class)->name('pengelola.produk.edit');
        Route::get('/stok', \App\Livewire\Pengelola\ManajemenProduk\ManajemenStok::class)->name('pengelola.produk.stok');
        Route::get('/gudang', \App\Livewire\Pengelola\ManajemenProduk\Gudang\DaftarGudang::class)->name('pengelola.produk.gudang');
        Route::get('/seri', \App\Livewire\Pengelola\ManajemenProduk\ManajemenSeri::class)->name('pengelola.produk.seri');
        Route::get('/garansi', \App\Livewire\Pengelola\ManajemenProduk\Garansi\ManajemenKlaim::class)->name('pengelola.produk.garansi');
        Route::get('/stock-opname', \App\Livewire\Pengelola\ManajemenProduk\StockOpname\RiwayatStockOpname::class)->name('pengelola.produk.so.riwayat');
        Route::get('/stock-opname/{id}', \App\Livewire\Pengelola\ManajemenProduk\StockOpname\DetailStockOpnameComp::class)->name('pengelola.produk.so.detail');
        Route::get('/flash-sale', \App\Livewire\Pengelola\ManajemenProduk\Promo\ManajemenFlashSale::class)->name('pengelola.produk.promo.flash-sale');
        
        Route::get('/label', \App\Livewire\Pengelola\ManajemenProduk\Label\CetakLabel::class)->name('pengelola.produk.label');
        Route::get('/spesifikasi', \App\Livewire\Pengelola\ManajemenProduk\ManajemenSpesifikasi::class)->name('pengelola.produk.spesifikasi');
        Route::get('/analitik', \App\Livewire\Pengelola\ManajemenProduk\Laporan\AnalitikProduk::class)->name('pengelola.produk.analitik');
    });

    Route::get('/kategori', \App\Livewire\Pengelola\ManajemenProduk\DaftarKategori::class)->name('pengelola.kategori');
    Route::get('/merek', \App\Livewire\Pengelola\ManajemenProduk\DaftarMerek::class)->name('pengelola.merek');

    // 3. Manajemen Pesanan
    Route::prefix('pesanan')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenPesanan\BerandaPesanan::class)->name('pengelola.pesanan.beranda');
        Route::get('/', \App\Livewire\Pengelola\ManajemenPesanan\DaftarPesanan::class)->name('pengelola.pesanan.daftar');
        Route::get('/detail/{pesanan}', \App\Livewire\Pengelola\ManajemenPesanan\DetailPesanan::class)->name('pengelola.pesanan.detail');
        Route::get('/verifikasi', \App\Livewire\Pengelola\ManajemenPesanan\VerifikasiPembayaran::class)->name('pengelola.pesanan.verifikasi'); 
    });

    // 4. Manajemen Transaksi
    Route::prefix('transaksi')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenTransaksi\BerandaTransaksi::class)->name('pengelola.transaksi.beranda');
    });

    // 5. Manajemen Customer Service
    Route::prefix('layanan')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\LayananPelanggan\BerandaLayanan::class)->name('pengelola.cs.beranda');
        Route::get('/tiket', \App\Livewire\Pengelola\LayananPelanggan\ManajemenTiket::class)->name('pengelola.cs.tiket');
        Route::get('/tiket/{id}', \App\Livewire\Pengelola\LayananPelanggan\DetailTiketAdmin::class)->name('pengelola.cs.tiket.detail');
    });

    // 6. Manajemen Logistik Pengiriman
    Route::prefix('logistik')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenLogistik\BerandaLogistik::class)->name('pengelola.logistik.beranda');
    });

    // 7. Manajemen Pelanggan
    Route::prefix('pelanggan')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenPelanggan\BerandaPelanggan::class)->name('pengelola.pelanggan.beranda');
        Route::get('/', \App\Livewire\Pengelola\ManajemenPelanggan\DaftarMember::class)->name('pengelola.pelanggan.daftar');
        Route::get('/ulasan', \App\Livewire\Pengelola\ManajemenPelanggan\ManajemenUlasan::class)->name('pengelola.pelanggan.ulasan');
    });

    // 8. Manajemen Vendor
    Route::prefix('vendor')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenVendor\BerandaVendor::class)->name('pengelola.vendor.beranda');
        Route::get('/', \App\Livewire\Pengelola\ManajemenVendor\DaftarPemasok::class)->name('pengelola.vendor.daftar');
        Route::get('/penawaran', \App\Livewire\Pengelola\ManajemenVendor\ManajemenPenawaran::class)->name('pengelola.vendor.penawaran');
        Route::get('/pembelian', \App\Livewire\Pengelola\ManajemenProduk\Pembelian\RiwayatPembelian::class)->name('pengelola.produk.pembelian.riwayat');
        Route::get('/pembelian/baru', \App\Livewire\Pengelola\ManajemenProduk\Pembelian\FormPembelian::class)->name('pengelola.produk.pembelian.baru');
        Route::get('/pembelian/{id}', \App\Livewire\Pengelola\ManajemenProduk\Pembelian\FormPembelian::class)->name('pengelola.produk.pembelian.detail');
        Route::get('/pembelian/edit/{id}', \App\Livewire\Pengelola\ManajemenProduk\Pembelian\FormPembelian::class)->name('pengelola.produk.pembelian.edit');
    });

    // 9. Manajemen Pegawai & Peran
    Route::prefix('hrd')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenPegawai\BerandaPegawai::class)->name('pengelola.hrd.beranda');
        Route::get('/karyawan', \App\Livewire\Pengelola\ManajemenPegawai\ManajemenKaryawan::class)->name('pengelola.pengguna.hrd');
        Route::get('/struktur', \App\Livewire\Pengelola\ManajemenPegawai\ManajemenStruktur::class)->name('pengelola.hrd.struktur');
        Route::get('/akses', \App\Livewire\Pengelola\ManajemenPegawai\ManajemenAkses::class)->name('pengelola.hrd.akses');
    });

    // 10. Manajemen Laporan & Analitik
    Route::prefix('laporan')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenLaporan\BerandaLaporan::class)->name('pengelola.laporan.beranda');
        Route::get('/', \App\Livewire\Pengelola\ManajemenLaporan\BerandaLaporan::class)->name('pengelola.laporan.pusat');
        Route::get('/log', \App\Livewire\Pengelola\Log\DaftarLog::class)->name('pengelola.pengaturan.log');
        Route::get('/log/{id}', \App\Livewire\Pengelola\Log\DetailLog::class)->name('pengelola.log.detail');
    });

    // 11. Pengaturan Sistem Terpusat
    Route::prefix('sistem')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\PengaturanSistem\BerandaSistem::class)->name('pengelola.sistem.beranda');
        Route::get('/pusat', \App\Livewire\Pengelola\ManajemenSistem\PusatPengaturan::class)->name('pengelola.sistem.pusat');
        Route::get('/kesehatan', \App\Livewire\Pengelola\ManajemenSistem\StatusKesehatan::class)->name('pengelola.sistem.kesehatan');
        Route::get('/voucher', \App\Livewire\Pengelola\PengaturanSistem\ManajemenVoucher::class)->name('pengelola.voucher');
    });

    // 12. Pengaturan API Terpusat
    Route::prefix('api')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenApi\PusatIntegrasi::class)->name('pengelola.api.pusat');
        Route::get('/pembayaran', \App\Livewire\Pengelola\ManajemenApi\KonfigurasiPembayaran::class)->name('pengelola.api.pembayaran');
        Route::get('/logistik', \App\Livewire\Pengelola\ManajemenApi\KonfigurasiLogistik::class)->name('pengelola.api.logistik');
        Route::get('/whatsapp', \App\Livewire\Pengelola\ManajemenApi\KonfigurasiWhatsapp::class)->name('pengelola.api.whatsapp');
        Route::get('/email', \App\Livewire\Pengelola\ManajemenApi\KonfigurasiEmail::class)->name('pengelola.api.email');
        Route::get('/kunci-api', \App\Livewire\Pengelola\ManajemenApi\DaftarKunciApi::class)->name('pengelola.api.kunci');
        Route::get('/log-api', \App\Livewire\Pengelola\ManajemenApi\LogAksesApi::class)->name('pengelola.api.log');
        Route::get('/dokumentasi-api', \App\Livewire\Pengelola\ManajemenApi\DokumentasiApi::class)->name('pengelola.api.dokumentasi');
    });
    
    // 13. Pengaturan Keamanan Terpusat (Cyber Security SOC)
    Route::prefix('keamanan')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\PengaturanKeamanan\BerandaKeamanan::class)->name('pengelola.keamanan.beranda');
        Route::get('/soc', \App\Livewire\Pengelola\ManajemenKeamanan\DasborKeamanan::class)->name('pengelola.keamanan.dasbor');
        Route::get('/firewall', \App\Livewire\Pengelola\ManajemenKeamanan\AturanFirewallLivewire::class)->name('pengelola.keamanan.firewall');
        Route::get('/scanner', \App\Livewire\Pengelola\ManajemenKeamanan\PemindaiSistem::class)->name('pengelola.keamanan.pemindai');
        Route::get('/siem', \App\Livewire\Pengelola\ManajemenKeamanan\AnalisisLogSiem::class)->name('pengelola.keamanan.siem');
        Route::get('/integritas', \App\Livewire\Pengelola\ManajemenKeamanan\IntegritasFile::class)->name('pengelola.keamanan.integritas');
        Route::get('/ueba', \App\Livewire\Pengelola\ManajemenKeamanan\AnalisisPerilakuUser::class)->name('pengelola.keamanan.ueba');
        Route::get('/forensik', \App\Livewire\Pengelola\ManajemenKeamanan\ForensikDigital::class)->name('pengelola.keamanan.forensik');
        Route::get('/honeypot', \App\Livewire\Pengelola\ManajemenKeamanan\HoneypotLog::class)->name('pengelola.keamanan.honeypot');
        Route::get('/ancaman', \App\Livewire\Pengelola\ManajemenKeamanan\IntelAncaman::class)->name('pengelola.keamanan.ancaman');
        Route::get('/pam', \App\Livewire\Pengelola\ManajemenKeamanan\ManajemenAksesPrivilege::class)->name('pengelola.keamanan.pam');
        Route::get('/sesi', \App\Livewire\Pengelola\ManajemenKeamanan\MonitorSesi::class)->name('pengelola.keamanan.sesi');
        Route::get('/dlp', \App\Livewire\Pengelola\ManajemenKeamanan\PencegahanKebocoran::class)->name('pengelola.keamanan.dlp');
        Route::get('/irp', \App\Livewire\Pengelola\ManajemenKeamanan\ResponInsiden::class)->name('pengelola.keamanan.irp');
        Route::get('/zerotrust', \App\Livewire\Pengelola\ManajemenKeamanan\ZeroTrustAkses::class)->name('pengelola.keamanan.zerotrust');
        Route::get('/edr', \App\Livewire\Pengelola\ManajemenKeamanan\DeteksiEndpoint::class)->name('pengelola.keamanan.edr');
        Route::get('/cadangan', \App\Livewire\Pengelola\ManajemenKeamanan\CadanganData::class)->name('pengelola.keamanan.cadangan');
    });
});