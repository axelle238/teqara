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

// Rute Admin (Memerlukan Login & Peran Admin)
Route::middleware(['auth', \App\Http\Middleware\CekPeranAdmin::class])->prefix('admin')->group(function () {
    // Dashboard Utama
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');

    // 1. Manajemen Produk
    Route::prefix('produk')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Produk\DashboardProduk::class)->name('admin.produk.dashboard');
        Route::get('/katalog', \App\Livewire\Admin\Produk\ManajemenProduk::class)->name('admin.produk.katalog');
        Route::get('/spesifikasi/{produk}', \App\Livewire\Admin\Produk\ManajemenSpesifikasi::class)->name('admin.produk.spesifikasi');
        Route::get('/stok', \App\Livewire\Admin\Stok\ManajemenStok::class)->name('admin.produk.stok');
    });
    // Redirect route lama untuk kompatibilitas
    Route::get('/produk', function () {
        return redirect()->route('admin.produk.katalog');
    })->name('admin.produk');
    Route::get('/stok', function () {
        return redirect()->route('admin.produk.stok');
    })->name('admin.stok');

    // 2. Manajemen Pesanan
    Route::prefix('pesanan')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Pesanan\DashboardPesanan::class)->name('admin.pesanan.dashboard');
        Route::get('/daftar', \App\Livewire\Admin\Pesanan\DaftarPesanan::class)->name('admin.pesanan.daftar');
        Route::get('/verifikasi', \App\Livewire\Admin\Pesanan\VerifikasiPembayaran::class)->name('admin.pesanan.verifikasi');
        Route::get('/detail/{pesanan}', \App\Livewire\Admin\Pesanan\DetailPesanan::class)->name('admin.pesanan.detail');
    });
    // Redirect route lama
    Route::get('/pesanan', function () {
        return redirect()->route('admin.pesanan.daftar');
    })->name('admin.pesanan');

    // 3. Manajemen Pelanggan
    Route::prefix('pelanggan')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Pelanggan\DashboardPelanggan::class)->name('admin.pelanggan.dashboard');
        Route::get('/daftar', \App\Livewire\Admin\Pengguna\DaftarPengguna::class)->name('admin.pelanggan.daftar');
        Route::get('/ulasan', \App\Livewire\Admin\Pelanggan\ManajemenUlasan::class)->name('admin.pelanggan.ulasan');
    });

    // 4. Manajemen Pengguna (Admin/Staff)
    Route::prefix('pengguna')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Pengguna\DashboardPengguna::class)->name('admin.pengguna.dashboard');
        Route::get('/daftar', \App\Livewire\Admin\Pengguna\DaftarPengguna::class)->name('admin.pengguna.daftar');
        Route::get('/hrd', \App\Livewire\Admin\HRD\ManajemenKaryawan::class)->name('admin.pengguna.hrd');
    });
    Route::get('/pengguna', function () {
        return redirect()->route('admin.pengguna.daftar');
    })->name('admin.pengguna');

    // 5. Manajemen Laporan
    Route::prefix('laporan')->group(function () {
        // Dashboard laporan belum dibuat khusus, gunakan DaftarLaporan sebagai pusat sementara
        Route::get('/pusat', \App\Livewire\Admin\Laporan\DaftarLaporan::class)->name('admin.laporan.pusat');
    });
    Route::get('/laporan', function () {
        return redirect()->route('admin.laporan.pusat');
    })->name('admin.laporan');

    // 6. Pengaturan Sistem (Baru)
    Route::prefix('pengaturan')->group(function () {
        Route::get('/sistem', \App\Livewire\Admin\Pengaturan\DashboardPengaturan::class)->name('admin.pengaturan.sistem');
        Route::get('/keamanan', \App\Livewire\Admin\Keamanan\DashboardKeamanan::class)->name('admin.pengaturan.keamanan');
        Route::get('/log', \App\Livewire\Admin\Log\DaftarLog::class)->name('admin.pengaturan.log');
        Route::get('/cms', \App\Livewire\Admin\CMS\ManajemenKonten::class)->name('admin.pengaturan.cms');
    });

    // 7. Master Data (Tetap)
    Route::get('/kategori', \App\Livewire\Admin\Kategori\DaftarKategori::class)->name('admin.kategori');
    Route::get('/merek', \App\Livewire\Admin\Merek\DaftarMerek::class)->name('admin.merek');
    Route::get('/voucher', \App\Livewire\Admin\Voucher\DaftarVoucher::class)->name('admin.voucher');

    // Legacy Route Fallback (untuk mencegah error 404 pada link lama)
    Route::get('/logistik/pemasok', \App\Livewire\Admin\Logistik\ManajemenPemasok::class)->name('admin.logistik.pemasok');
    Route::get('/log', function () {
        return redirect()->route('admin.pengaturan.log');
    })->name('admin.log');
    Route::get('/cms', function () {
        return redirect()->route('admin.pengaturan.cms');
    })->name('admin.cms');
});
