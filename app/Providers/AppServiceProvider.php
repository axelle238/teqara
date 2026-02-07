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
        \Illuminate\Support\Facades\Cache::extend('basis_data', function ($app, $config) {
            $connection = $app['db']->connection($config['connection'] ?? null);
            $table = $config['table'];
            $prefix = $app['config']['cache.prefix'];

            return \Illuminate\Support\Facades\Cache::repository(
                new \App\Extensions\PengelolaCacheBasisData($connection, $table, $prefix)
            );
        });

        \Illuminate\Support\Facades\Session::extend('basis_data', function ($app) {
            $table = $app['config']['session.table'];
            $minutes = $app['config']['session.lifetime'];
            $connection = $app['db']->connection($app['config']['session.connection']);

            return new \App\Extensions\PengelolaSesiBasisData($connection, $table, $minutes, $app);
        });

        \App\Models\Produk::observe(\App\Observers\ProdukObserver::class);
        \App\Models\Pesanan::observe(\App\Observers\PesananObserver::class);
        \App\Models\Pengguna::observe(\App\Observers\PenggunaObserver::class);
        \App\Models\PengaturanSistem::observe(\App\Observers\PengaturanSistemObserver::class);

        // Integrasi Layanan Pengaturan Terpusat
        // Menggunakan View Composer agar variabel $globalSettings tersedia di SELURUH view
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                // Menggunakan Service untuk konsistensi caching
                $layanan = app(\App\Services\LayananPengaturan::class);
                $view->with('globalSettings', $layanan->ambilSemua());

                // Kategori Global untuk Menu Navigasi
                $view->with('globalCategories', \App\Models\Kategori::withCount('produk')
                    ->orderBy('produk_count', 'desc')
                    ->take(8)
                    ->get());
            } catch (\Exception $e) {
                // Fallback aman saat migrasi/awal setup
                $view->with('globalSettings', []);
                $view->with('globalCategories', collect([]));
            }
        });
    }
}