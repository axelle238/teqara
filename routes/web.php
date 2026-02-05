<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;

// Rute Publik
Route::get('/', Beranda::class)->name('beranda');
Route::get('/katalog', \App\Livewire\Katalog::class)->name('katalog');
Route::get('/produk/{slug}', \App\Livewire\Produk\DetailProduk::class)->name('produk.detail');

// Rute Pelanggan (Memerlukan Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/keranjang', \App\Livewire\Keranjang::class)->name('keranjang');
    Route::get('/checkout', \App\Livewire\Checkout::class)->name('checkout');
    Route::get('/pesanan/riwayat', \App\Livewire\Pesanan\Riwayat::class)->name('pesanan.riwayat');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});