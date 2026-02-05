<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Produk::observe(\App\Observers\ProdukObserver::class);
        \App\Models\Pesanan::observe(\App\Observers\PesananObserver::class);
        \App\Models\Pengguna::observe(\App\Observers\PenggunaObserver::class);

        // Share pengaturan_sistem Global ke Semua View
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('pengaturan_sistem')) {
                $pengaturan_sistem = \Illuminate\Support\Facades\DB::table('pengaturan_sistem')->pluck('nilai', 'kunci');
                \Illuminate\Support\Facades\View::share('pengaturan_sistemToko', $pengaturan_sistem);
            }
        } catch (\Exception $e) {
            // Abaikan jika tabel belum ada (saat migrasi awal)
        }
    }
}
