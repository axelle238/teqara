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

        // Global Settings Composer (Real-time & Cached)
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $settings = \Illuminate\Support\Facades\Cache::remember('global_settings', 60, function () {
                try {
                    return \App\Models\PengaturanSistem::pluck('nilai', 'kunci');
                } catch (\Exception $e) {
                    return collect([]);
                }
            });
            $view->with('globalSettings', $settings);
        });
    }
}
