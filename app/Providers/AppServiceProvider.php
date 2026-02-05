<?php

namespace App\Providers;

use App\Models\Produk;
use App\Observers\ProdukObserver;
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
        Produk::observe(ProdukObserver::class);

        // Share Pengaturan Global ke Semua View
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('pengaturan')) {
                $pengaturan = \Illuminate\Support\Facades\DB::table('pengaturan')->pluck('nilai', 'kunci');
                \Illuminate\Support\Facades\View::share('pengaturanToko', $pengaturan);
            }
        } catch (\Exception $e) {
            // Abaikan jika tabel belum ada (saat migrasi awal)
        }
    }
}
