<?php

namespace App\Observers;

use App\Models\Produk;
use App\Services\LayananDokumentasi;

class ProdukObserver
{
    public function __construct(protected LayananDokumentasi $layanan) {}

    public function saved(Produk $produk): void { $this->layanan->perbaruiDokumentasi(); }
    public function deleted(Produk $produk): void { $this->layanan->perbaruiDokumentasi(); }
}