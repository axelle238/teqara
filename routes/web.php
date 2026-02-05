<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;

// Rute Publik
Route::get('/', Beranda::class)->name('beranda');

// Rute Auth (Placeholder, akan dikembangkan nanti)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Sementara
    })->name('dashboard');
});