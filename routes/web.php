<?php

use App\Livewire\Beranda;
use Illuminate\Support\Facades\Route;

/**
 * Rute Utama Sistem Teqara v16.0
 * Kepatuhan: 100% Bahasa Indonesia & Nasionalisasi Arsitektur.
 */

// Rute Publik
Route::get('/', Beranda::class)->name('beranda');
Route::get('/katalog', \App\Livewire\Katalog::class)->name('katalog');
Route::get('/produk/{slug}', \App\Livewire\Produk\DetailProduk::class)->name('produk.detail');

// Rute Informasi & Bantuan (Enterprise Updates)
Route::get('/bantuan', \App\Livewire\LayananPelanggan\PusatBantuan::class)->name('bantuan');
Route::get('/berita', \App\Livewire\Berita\DaftarBerita::class)->name('berita.daftar');
Route::get('/berita/{slug}', \App\Livewire\Berita\DetailBerita::class)->name('berita.detail');

// Otentikasi (Bahasa Indonesia)
Route::get('/masuk', \App\Livewire\Otentikasi\Masuk::class)->name('login');
Route::redirect('/login', '/masuk'); // Alias untuk kompatibilitas sistem

// Keluar (Logout)
Route::get('/keluar', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/');
})->name('logout');

// Rute Pelanggan (Memerlukan Otoritas Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/keranjang', \App\Livewire\KeranjangBelanja::class)->name('keranjang');
    Route::get('/checkout', \App\Livewire\Checkout::class)->name('checkout');
    Route::get('/pesanan/riwayat', \App\Livewire\Pesanan\Riwayat::class)->name('pesanan.riwayat');
    Route::get('/pesanan/lacak/{invoice}', \App\Livewire\Pelanggan\DetailPesanan::class)->name('pesanan.lacak');
    Route::get('/pesanan/bayar/{invoice}', \App\Livewire\Pelanggan\BayarPesanan::class)->name('pesanan.bayar');
    Route::get('/pesanan/faktur/{invoice}', \App\Http\Controllers\CetakFakturController::class)->name('pesanan.faktur');
    Route::get('/ulasan/{pesananId}/{produkId}', \App\Livewire\Pelanggan\BeriUlasan::class)->name('ulasan.buat');
    Route::get('/profil', \App\Livewire\Pelanggan\Profil::class)->name('dashboard');
});

// Rute Admin 11 Pilar Utama (Otoritas Kendali Enterprise)
Route::middleware(['auth', \App\Http\Middleware\CekPeranAdmin::class])->prefix('pengelola')->group(function () {

    // Pilar 0: Beranda Utama (Statistik Agregat)
    Route::get('/beranda', \App\Livewire\Pengelola\BerandaUtama::class)->name('pengelola.beranda');

    // Pilar 1: Manajemen Halaman Toko (CMS)
    Route::prefix('toko')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenToko\BerandaToko::class)->name('pengelola.toko.beranda');
        Route::get('/konten', \App\Livewire\Pengelola\ManajemenToko\ManajemenKonten::class)->name('pengelola.toko.konten');
        Route::get('/berita', \App\Livewire\Pengelola\ManajemenToko\ManajemenBerita::class)->name('pengelola.toko.berita');
    });

    // Pilar 2: Manajemen Produk & Gadget
    Route::prefix('produk')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenProduk\BerandaProduk::class)->name('pengelola.produk.beranda');
        Route::get('/katalog', \App\Livewire\Pengelola\ManajemenProduk\ManajemenProduk::class)->name('pengelola.produk.katalog');
        Route::get('/tambah', \App\Livewire\Pengelola\ManajemenProduk\FormProduk::class)->name('pengelola.produk.tambah');
        Route::get('/edit/{id}', \App\Livewire\Pengelola\ManajemenProduk\FormProduk::class)->name('pengelola.produk.edit');
        Route::get('/spesifikasi/{produk}', \App\Livewire\Pengelola\ManajemenProduk\ManajemenSpesifikasi::class)->name('pengelola.produk.spesifikasi');
        Route::get('/seri', \App\Livewire\Pengelola\ManajemenProduk\ManajemenSeri::class)->name('pengelola.produk.seri');
        Route::get('/label/{id}', \App\Livewire\Pengelola\ManajemenProduk\Label\CetakLabel::class)->name('pengelola.produk.label');
        Route::get('/stok', \App\Livewire\Pengelola\ManajemenProduk\ManajemenStok::class)->name('pengelola.produk.stok');
        Route::get('/pembelian', \App\Livewire\Pengelola\ManajemenProduk\Pembelian\RiwayatPembelian::class)->name('pengelola.produk.pembelian.riwayat');
        Route::get('/pembelian/baru', \App\Livewire\Pengelola\ManajemenProduk\Pembelian\FormPembelian::class)->name('pengelola.produk.pembelian.baru');
        Route::get('/pembelian/{id}', \App\Livewire\Pengelola\ManajemenProduk\Pembelian\FormPembelian::class)->name('pengelola.produk.pembelian.detail');
        Route::get('/promo/flash-sale', \App\Livewire\Pengelola\ManajemenProduk\Promo\ManajemenFlashSale::class)->name('pengelola.produk.promo.flash-sale');
        Route::get('/garansi', \App\Livewire\Pengelola\ManajemenProduk\Garansi\ManajemenKlaim::class)->name('pengelola.produk.garansi');
        Route::get('/laporan-analitik', \App\Livewire\Pengelola\ManajemenProduk\Laporan\AnalitikProduk::class)->name('pengelola.produk.laporan');
        Route::get('/stock-opname', \App\Livewire\Pengelola\ManajemenProduk\StockOpname\RiwayatStockOpname::class)->name('pengelola.produk.so.riwayat');
        Route::get('/stock-opname/{id}', \App\Livewire\Pengelola\ManajemenProduk\StockOpname\DetailStockOpnameComp::class)->name('pengelola.produk.so.detail');
    });

    // Pilar 3: Manajemen Pesanan
    Route::prefix('pesanan')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenPesanan\BerandaPesanan::class)->name('pengelola.pesanan.beranda');
        Route::get('/daftar', \App\Livewire\Pengelola\ManajemenPesanan\DaftarPesanan::class)->name('pengelola.pesanan.daftar');
        Route::get('/detail/{pesanan}', \App\Livewire\Pengelola\ManajemenPesanan\DetailPesanan::class)->name('pengelola.pesanan.detail');
    });

    // Pilar 4: Manajemen Transaksi & Finansial
    Route::prefix('transaksi')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenTransaksi\BerandaTransaksi::class)->name('pengelola.transaksi.beranda');
        Route::get('/verifikasi', \App\Livewire\Pengelola\ManajemenPesanan\VerifikasiPembayaran::class)->name('pengelola.pesanan.verifikasi');
    });

    // Pilar 5: Manajemen Layanan Pelanggan (CS)
    Route::prefix('layanan')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\LayananPelanggan\BerandaLayanan::class)->name('pengelola.cs.beranda');
        Route::get('/tiket', \App\Livewire\Pengelola\LayananPelanggan\ManajemenTiket::class)->name('pengelola.cs.tiket');
        Route::get('/ulasan', \App\Livewire\Pengelola\ManajemenPelanggan\ManajemenUlasan::class)->name('pengelola.pelanggan.ulasan');
    });

    // Pilar 6: Manajemen Logistik & Pengiriman
    Route::prefix('logistik')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenLogistik\BerandaLogistik::class)->name('pengelola.logistik.beranda');
    });

    // Pilar 7: Manajemen Vendor (Pemasok)
    Route::prefix('vendor')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenVendor\BerandaVendor::class)->name('pengelola.vendor.beranda');
        Route::get('/daftar', \App\Livewire\Pengelola\ManajemenLogistik\ManajemenPemasok::class)->name('pengelola.vendor.daftar');
        Route::get('/pemasok/baru', \App\Livewire\Pengelola\ManajemenProduk\Pemasok\FormPemasok::class)->name('pengelola.vendor.tambah');
        Route::get('/pemasok/edit/{id}', \App\Livewire\Pengelola\ManajemenProduk\Pemasok\FormPemasok::class)->name('pengelola.vendor.edit');
    });

    // Pilar 8: Manajemen Pelanggan (CRM)
    Route::prefix('pelanggan')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenPelanggan\BerandaPelanggan::class)->name('pengelola.pelanggan.beranda');
        Route::get('/daftar', \App\Livewire\Pengelola\ManajemenPelanggan\DaftarMember::class)->name('pengelola.pelanggan.daftar');
        Route::get('/ulasan', \App\Livewire\Pengelola\ManajemenPelanggan\ManajemenUlasan::class)->name('pengelola.pelanggan.ulasan');
    });

    // Pilar 8: Manajemen Pegawai & Peran (SDM)
    Route::prefix('pegawai')->group(function () {
        Route::get('/beranda', \App\Livewire\Pengelola\ManajemenPegawai\BerandaPegawai::class)->name('pengelola.pengguna.beranda');
        Route::get('/struktur', \App\Livewire\Pengelola\ManajemenPegawai\ManajemenStruktur::class)->name('pengelola.hrd.karyawan');
        Route::get('/karyawan', \App\Livewire\Pengelola\ManajemenPegawai\ManajemenKaryawan::class)->name('pengelola.pengguna.hrd');
    });

    // Pilar 9: Manajemen Laporan & Analitik Bisnis
    Route::prefix('laporan')->group(function () {
        Route::get('/pusat', \App\Livewire\Pengelola\ManajemenLaporan\BerandaLaporan::class)->name('pengelola.laporan.pusat');
    });

    // Pilar 10: Pengaturan Sistem Terpusat
    Route::prefix('sistem')->group(function () {
        Route::get('/identitas', \App\Livewire\Pengelola\PengaturanSistem\BerandaSistem::class)->name('pengelola.pengaturan.sistem');
        Route::get('/voucher', \App\Livewire\Pengelola\PengaturanSistem\ManajemenVoucher::class)->name('pengelola.voucher');
    });

    // Pilar 11: Pengaturan Keamanan Terpusat
    Route::prefix('keamanan')->group(function () {
        Route::get('/radar', \App\Livewire\Pengelola\PengaturanKeamanan\BerandaKeamanan::class)->name('pengelola.pengaturan.keamanan');
        Route::get('/log', \App\Livewire\Pengelola\Log\DaftarLog::class)->name('pengelola.pengaturan.log');
    });

    // Data Master
    Route::get('/kategori', \App\Livewire\Pengelola\ManajemenProduk\DaftarKategori::class)->name('pengelola.kategori');
    Route::get('/kategori/tambah', \App\Livewire\Pengelola\ManajemenProduk\Kategori\FormKategori::class)->name('pengelola.kategori.tambah');
    Route::get('/kategori/edit/{id}', \App\Livewire\Pengelola\ManajemenProduk\Kategori\FormKategori::class)->name('pengelola.kategori.edit');
    Route::get('/merek', \App\Livewire\Pengelola\ManajemenProduk\DaftarMerek::class)->name('pengelola.merek');
    Route::get('/merek/tambah', \App\Livewire\Pengelola\ManajemenProduk\Merek\FormMerek::class)->name('pengelola.merek.tambah');
    Route::get('/merek/edit/{id}', \App\Livewire\Pengelola\ManajemenProduk\Merek\FormMerek::class)->name('pengelola.merek.edit');
});

// Rute Mitra B2B (Supplier)
Route::middleware(['auth', \App\Http\Middleware\CekPeranMitra::class])->prefix('mitra')->group(function () {
    Route::get('/beranda', \App\Livewire\Mitra\Beranda::class)->name('mitra.beranda');
});
