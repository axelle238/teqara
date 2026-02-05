<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;

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

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

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
});