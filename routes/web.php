<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;

// Rute Publik
Route::get('/', Beranda::class)->name('beranda');
Route::get('/katalog', \App\Livewire\Katalog::class)->name('katalog');
Route::get('/produk/{slug}', \App\Livewire\Produk\DetailProduk::class)->name('produk.detail');

// Rute Auth (Placeholder, akan dikembangkan nanti)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Sementara
    })->name('dashboard');
});