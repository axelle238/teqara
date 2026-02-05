<?php

use App\Livewire\Beranda;
use Illuminate\Support\Facades\Route;

// Rute Publik
Route::get('/', Beranda::class)->name('beranda');
Route::get('/katalog', \App\Livewire\Katalog::class)->name('katalog');
Route::get('/produk/{slug}', \App\Livewire\Produk\DetailProduk::class)->name('produk.detail');
Route::get('/login', \App\Livewire\Auth\Masuk::class)->name('login');

// Keluar (Logout)
Route::get('/logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/');
})->name('logout');

// Rute Pelanggan (Memerlukan Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/keranjang', \App\Livewire\KeranjangBelanja::class)->name('keranjang');
    Route::get('/checkout', \App\Livewire\Checkout::class)->name('checkout');
    Route::get('/pesanan/riwayat', \App\Livewire\Pesanan\Riwayat::class)->name('pesanan.riwayat');
    Route::get('/pesanan/lacak/{invoice}', \App\Livewire\Pelanggan\DetailPesanan::class)->name('pesanan.lacak');
    Route::get('/pesanan/bayar/{invoice}', \App\Livewire\Pelanggan\BayarPesanan::class)->name('pesanan.bayar');
    Route::get('/pesanan/faktur/{invoice}', \App\Http\Controllers\CetakFakturController::class)->name('pesanan.faktur');
    Route::get('/ulasan/{pesananId}/{produkId}', \App\Livewire\Pelanggan\BeriUlasan::class)->name('ulasan.buat');
    Route::get('/dashboard', \App\Livewire\Pelanggan\Profil::class)->name('dashboard');
});

// Rute Admin 11 Pilar Utama (Memerlukan Login & Peran Admin)
Route::middleware(['auth', \App\Http\Middleware\CekPeranAdmin::class])->prefix('admin')->group(function () {
    // Pilar 0: Dashboard Statistik Total
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');

    // Pilar 1: Manajemen Halaman Toko
    Route::prefix('toko')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Toko\DashboardToko::class)->name('admin.toko.dashboard');
        Route::get('/konten', \App\Livewire\Admin\Toko\ManajemenKonten::class)->name('admin.toko.konten');
        Route::get('/berita', \App\Livewire\Admin\Toko\ManajemenBerita::class)->name('admin.toko.berita');
    });

    // Pilar 2: Manajemen Produk & Gadget
    Route::prefix('produk')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Produk\DashboardProduk::class)->name('admin.produk.dashboard');
        Route::get('/katalog', \App\Livewire\Admin\Produk\ManajemenProduk::class)->name('admin.produk.katalog');
        Route::get('/spesifikasi/{produk}', \App\Livewire\Admin\Produk\ManajemenSpesifikasi::class)->name('admin.produk.spesifikasi');
        Route::get('/stok', \App\Livewire\Admin\Stok\ManajemenStok::class)->name('admin.produk.stok');
    });

    // Pilar 3: Manajemen Pesanan
    Route::prefix('pesanan')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Pesanan\DashboardPesanan::class)->name('admin.pesanan.dashboard');
        Route::get('/daftar', \App\Livewire\Admin\Pesanan\DaftarPesanan::class)->name('admin.pesanan.daftar');
        Route::get('/detail/{pesanan}', \App\Livewire\Admin\Pesanan\DetailPesanan::class)->name('admin.pesanan.detail');
    });

    // Pilar 4: Manajemen Transaksi
    Route::prefix('transaksi')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Transaksi\DashboardTransaksi::class)->name('admin.transaksi.dashboard');
        Route::get('/verifikasi', \App\Livewire\Admin\Pesanan\VerifikasiPembayaran::class)->name('admin.pesanan.verifikasi');
    });

    // Pilar 5: Manajemen Customer Service
    Route::prefix('cs')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\CustomerService\DashboardCs::class)->name('admin.cs.dashboard');
        Route::get('/tiket', \App\Livewire\Admin\CustomerService\ManajemenTiket::class)->name('admin.cs.tiket');
        Route::get('/ulasan', \App\Livewire\Admin\Pelanggan\ManajemenUlasan::class)->name('admin.pelanggan.ulasan');
    });

    // Pilar 6: Manajemen Logistik Pengiriman
    Route::prefix('logistik')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Logistik\DashboardLogistik::class)->name('admin.logistik.dashboard');
        Route::get('/pemasok', \App\Livewire\Admin\Logistik\ManajemenPemasok::class)->name('admin.logistik.pemasok');
    });

    // Pilar 7: Manajemen Pelanggan
    Route::prefix('pelanggan')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Pelanggan\DashboardPelanggan::class)->name('admin.pelanggan.dashboard');
        Route::get('/daftar', \App\Livewire\Admin\Pengguna\DaftarPengguna::class)->name('admin.pelanggan.daftar');
    });

    // Pilar 8: Manajemen Pegawai & Peran
    Route::prefix('pengguna')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Pengguna\DashboardPengguna::class)->name('admin.pengguna.dashboard');
        Route::get('/daftar', \App\Livewire\Admin\Pengguna\DaftarPengguna::class)->name('admin.pengguna.daftar');
        Route::get('/struktur', \App\Livewire\Admin\HRD\ManajemenStruktur::class)->name('admin.hrd.karyawan');
        Route::get('/hrd', \App\Livewire\Admin\HRD\ManajemenKaryawan::class)->name('admin.pengguna.hrd');
    });

    // Pilar 9: Manajemen Laporan & Analitik
    Route::prefix('laporan')->group(function () {
        Route::get('/pusat', \App\Livewire\Admin\Laporan\DaftarLaporan::class)->name('admin.laporan.pusat');
    });

    // Pilar 10: Pengaturan Sistem Terpusat
    Route::prefix('pengaturan/sistem')->group(function () {
        Route::get('/', \App\Livewire\Admin\Pengaturan\DashboardPengaturan::class)->name('admin.pengaturan.sistem');
        Route::get('/voucher', \App\Livewire\Admin\Voucher\DaftarVoucher::class)->name('admin.voucher');
    });

    // Pilar 11: Pengaturan Keamanan Terpusat
    Route::prefix('pengaturan/keamanan')->group(function () {
        Route::get('/', \App\Livewire\Admin\Keamanan\DashboardKeamanan::class)->name('admin.pengaturan.keamanan');
        Route::get('/log', \App\Livewire\Admin\Log\DaftarLog::class)->name('admin.pengaturan.log');
    });

    // Master Data & Fallbacks
    Route::get('/kategori', \App\Livewire\Admin\Kategori\DaftarKategori::class)->name('admin.kategori');
    Route::get('/merek', \App\Livewire\Admin\Merek\DaftarMerek::class)->name('admin.merek');
});
