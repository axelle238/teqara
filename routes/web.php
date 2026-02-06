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
Route::get('/masuk', \App\Livewire\Auth\Masuk::class)->name('login');
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
Route::middleware(['auth', \App\Http\Middleware\CekPeranAdmin::class])->prefix('admin')->group(function () {

    // Pilar 0: Beranda Utama (Statistik Agregat)
    Route::get('/beranda', \App\Livewire\Admin\BerandaUtama::class)->name('admin.beranda');

    // Pilar 1: Manajemen Halaman Toko (CMS)
    Route::prefix('toko')->group(function () {
        Route::get('/beranda', \App\Livewire\Admin\ManajemenToko\BerandaToko::class)->name('admin.toko.beranda');
        Route::get('/konten', \App\Livewire\Admin\ManajemenToko\ManajemenKonten::class)->name('admin.toko.konten');
        Route::get('/berita', \App\Livewire\Admin\ManajemenToko\ManajemenBerita::class)->name('admin.toko.berita');
    });

    // Pilar 2: Manajemen Produk & Gadget
    Route::prefix('produk')->group(function () {
        Route::get('/beranda', \App\Livewire\Admin\ManajemenProduk\BerandaProduk::class)->name('admin.produk.beranda');
        Route::get('/katalog', \App\Livewire\Admin\ManajemenProduk\ManajemenProduk::class)->name('admin.produk.katalog');
        Route::get('/tambah', \App\Livewire\Admin\ManajemenProduk\FormProduk::class)->name('admin.produk.tambah');
        Route::get('/edit/{id}', \App\Livewire\Admin\ManajemenProduk\FormProduk::class)->name('admin.produk.edit');
        Route::get('/spesifikasi/{produk}', \App\Livewire\Admin\ManajemenProduk\ManajemenSpesifikasi::class)->name('admin.produk.spesifikasi');
        Route::get('/seri', \App\Livewire\Admin\ManajemenProduk\ManajemenSeri::class)->name('admin.produk.seri');
        Route::get('/label/{id}', \App\Livewire\Admin\ManajemenProduk\Label\CetakLabel::class)->name('admin.produk.label');
        Route::get('/stok', \App\Livewire\Admin\ManajemenProduk\ManajemenStok::class)->name('admin.produk.stok');
        Route::get('/pembelian', \App\Livewire\Admin\ManajemenProduk\Pembelian\RiwayatPembelian::class)->name('admin.produk.pembelian.riwayat');
        Route::get('/pembelian/baru', \App\Livewire\Admin\ManajemenProduk\Pembelian\FormPembelian::class)->name('admin.produk.pembelian.baru');
        Route::get('/pembelian/{id}', \App\Livewire\Admin\ManajemenProduk\Pembelian\FormPembelian::class)->name('admin.produk.pembelian.detail');
        Route::get('/promo/flash-sale', \App\Livewire\Admin\ManajemenProduk\Promo\ManajemenFlashSale::class)->name('admin.produk.promo.flash-sale');
        Route::get('/garansi', \App\Livewire\Admin\ManajemenProduk\Garansi\ManajemenKlaim::class)->name('admin.produk.garansi');
        Route::get('/laporan-analitik', \App\Livewire\Admin\ManajemenProduk\Laporan\AnalitikProduk::class)->name('admin.produk.laporan');
        Route::get('/stock-opname', \App\Livewire\Admin\ManajemenProduk\StockOpname\RiwayatStockOpname::class)->name('admin.produk.so.riwayat');
        Route::get('/stock-opname/{id}', \App\Livewire\Admin\ManajemenProduk\StockOpname\DetailStockOpnameComp::class)->name('admin.produk.so.detail');
    });

    // Pilar 3: Manajemen Pesanan
    Route::prefix('pesanan')->group(function () {
        Route::get('/beranda', \App\Livewire\Admin\ManajemenPesanan\BerandaPesanan::class)->name('admin.pesanan.beranda');
        Route::get('/daftar', \App\Livewire\Admin\ManajemenPesanan\DaftarPesanan::class)->name('admin.pesanan.daftar');
        Route::get('/detail/{pesanan}', \App\Livewire\Admin\ManajemenPesanan\DetailPesanan::class)->name('admin.pesanan.detail');
    });

    // Pilar 4: Manajemen Transaksi & Finansial
    Route::prefix('transaksi')->group(function () {
        Route::get('/beranda', \App\Livewire\Admin\ManajemenTransaksi\BerandaTransaksi::class)->name('admin.transaksi.beranda');
        Route::get('/verifikasi', \App\Livewire\Admin\ManajemenPesanan\VerifikasiPembayaran::class)->name('admin.pesanan.verifikasi');
    });

    // Pilar 5: Manajemen Layanan Pelanggan (CS)
    Route::prefix('layanan')->group(function () {
        Route::get('/beranda', \App\Livewire\Admin\LayananPelanggan\BerandaLayanan::class)->name('admin.cs.beranda');
        Route::get('/tiket', \App\Livewire\Admin\LayananPelanggan\ManajemenTiket::class)->name('admin.cs.tiket');
        Route::get('/ulasan', \App\Livewire\Admin\ManajemenPelanggan\ManajemenUlasan::class)->name('admin.pelanggan.ulasan');
    });

    // Pilar 6: Manajemen Logistik & Pengiriman
    Route::prefix('logistik')->group(function () {
        Route::get('/beranda', \App\Livewire\Admin\ManajemenLogistik\BerandaLogistik::class)->name('admin.logistik.beranda');
    });

    // Pilar 7: Manajemen Vendor (Pemasok)
    Route::prefix('vendor')->group(function () {
        Route::get('/beranda', \App\Livewire\Admin\ManajemenVendor\BerandaVendor::class)->name('admin.vendor.beranda');
        Route::get('/daftar', \App\Livewire\Admin\ManajemenLogistik\ManajemenPemasok::class)->name('admin.vendor.daftar');
        Route::get('/pemasok/baru', \App\Livewire\Admin\ManajemenProduk\Pemasok\FormPemasok::class)->name('admin.vendor.tambah');
        Route::get('/pemasok/edit/{id}', \App\Livewire\Admin\ManajemenProduk\Pemasok\FormPemasok::class)->name('admin.vendor.edit');
    });

    // Pilar 8: Manajemen Pelanggan (CRM)
    Route::prefix('pelanggan')->group(function () {
        Route::get('/beranda', \App\Livewire\Admin\ManajemenPelanggan\BerandaPelanggan::class)->name('admin.pelanggan.beranda');
        Route::get('/daftar', \App\Livewire\Admin\ManajemenPelanggan\DaftarMember::class)->name('admin.pelanggan.daftar');
        Route::get('/ulasan', \App\Livewire\Admin\ManajemenPelanggan\ManajemenUlasan::class)->name('admin.pelanggan.ulasan');
    });

    // Pilar 8: Manajemen Pegawai & Peran (SDM)
    Route::prefix('pegawai')->group(function () {
        Route::get('/beranda', \App\Livewire\Admin\ManajemenPegawai\BerandaPegawai::class)->name('admin.pengguna.beranda');
        Route::get('/struktur', \App\Livewire\Admin\ManajemenPegawai\ManajemenStruktur::class)->name('admin.hrd.karyawan');
        Route::get('/karyawan', \App\Livewire\Admin\ManajemenPegawai\ManajemenKaryawan::class)->name('admin.pengguna.hrd');
    });

    // Pilar 9: Manajemen Laporan & Analitik Bisnis
    Route::prefix('laporan')->group(function () {
        Route::get('/pusat', \App\Livewire\Admin\ManajemenLaporan\BerandaLaporan::class)->name('admin.laporan.pusat');
    });

    // Pilar 10: Pengaturan Sistem Terpusat
    Route::prefix('sistem')->group(function () {
        Route::get('/identitas', \App\Livewire\Admin\PengaturanSistem\BerandaSistem::class)->name('admin.pengaturan.sistem');
        Route::get('/voucher', \App\Livewire\Admin\PengaturanSistem\ManajemenVoucher::class)->name('admin.voucher');
    });

    // Pilar 11: Pengaturan Keamanan Terpusat
    Route::prefix('keamanan')->group(function () {
        Route::get('/radar', \App\Livewire\Admin\PengaturanKeamanan\BerandaKeamanan::class)->name('admin.pengaturan.keamanan');
        Route::get('/log', \App\Livewire\Admin\Log\DaftarLog::class)->name('admin.pengaturan.log');
    });

    // Data Master
    Route::get('/kategori', \App\Livewire\Admin\ManajemenProduk\DaftarKategori::class)->name('admin.kategori');
    Route::get('/kategori/tambah', \App\Livewire\Admin\ManajemenProduk\Kategori\FormKategori::class)->name('admin.kategori.tambah');
    Route::get('/kategori/edit/{id}', \App\Livewire\Admin\ManajemenProduk\Kategori\FormKategori::class)->name('admin.kategori.edit');
    Route::get('/merek', \App\Livewire\Admin\ManajemenProduk\DaftarMerek::class)->name('admin.merek');
    Route::get('/merek/tambah', \App\Livewire\Admin\ManajemenProduk\Merek\FormMerek::class)->name('admin.merek.tambah');
    Route::get('/merek/edit/{id}', \App\Livewire\Admin\ManajemenProduk\Merek\FormMerek::class)->name('admin.merek.edit');
});

// Rute Mitra B2B (Supplier)
Route::middleware(['auth', \App\Http\Middleware\CekPeranMitra::class])->prefix('mitra')->group(function () {
    Route::get('/beranda', \App\Livewire\Mitra\Beranda::class)->name('mitra.beranda');
});