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
            Route::get('/ulasan/{pesananId}/{produkId}', \App\Livewire\Pelanggan\BeriUlasan::class)->name('ulasan.buat');        
            Route::get('/dashboard', \App\Livewire\Pelanggan\Profil::class)->name('dashboard');});

// Rute Admin (Memerlukan Login & Peran Admin)
Route::middleware(['auth', \App\Http\Middleware\CekPeranAdmin::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');

    // Manajemen Pesanan
    Route::get('/pesanan', \App\Livewire\Admin\Pesanan\DaftarPesanan::class)->name('admin.pesanan');
    Route::get('/pesanan/{pesanan}', \App\Livewire\Admin\Pesanan\DetailPesanan::class)->name('admin.pesanan.detail');

    // Manajemen Produk
    Route::get('/produk', \App\Livewire\Admin\Produk\DaftarProduk::class)->name('admin.produk');
    Route::get('/produk/tambah', \App\Livewire\Admin\Produk\FormProduk::class)->name('admin.produk.tambah');
    Route::get('/produk/{id}/edit', \App\Livewire\Admin\Produk\FormProduk::class)->name('admin.produk.edit');

    // Manajemen Master & Audit
    Route::get('/kategori', \App\Livewire\Admin\Kategori\DaftarKategori::class)->name('admin.kategori');
    Route::get('/merek', \App\Livewire\Admin\Merek\DaftarMerek::class)->name('admin.merek');
    Route::get('/voucher', \App\Livewire\Admin\Voucher\DaftarVoucher::class)->name('admin.voucher');
    Route::get('/log', \App\Livewire\Admin\Log\DaftarLog::class)->name('admin.log');
    Route::get('/laporan', \App\Livewire\Admin\Laporan\DaftarLaporan::class)->name('admin.laporan');
    Route::get('/pengguna', \App\Livewire\Admin\Pengguna\DaftarPengguna::class)->name('admin.pengguna');
    Route::get('/cms', \App\Livewire\Admin\CMS\ManajemenKonten::class)->name('admin.cms');
});
