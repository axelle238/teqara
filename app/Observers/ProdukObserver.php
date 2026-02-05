<?php

namespace App\Observers;

use App\Models\Produk;
use Illuminate\Support\Facades\Cache;

class ProdukObserver
{
    /**
     * Handle the Produk "created" event.
     */
    public function created(Produk $produk): void
    {
        $this->bersihkanCache();
    }

    /**
     * Handle the Produk "updated" event.
     */
    public function updated(Produk $produk): void
    {
        $this->bersihkanCache();
    }

    /**
     * Handle the Produk "deleted" event.
     */
    public function deleted(Produk $produk): void
    {
        $this->bersihkanCache();
    }

    private function bersihkanCache()
    {
        Cache::forget('beranda_kategori');
        Cache::forget('beranda_produk_unggulan');
        Cache::forget('beranda_statistik');
    }
}
