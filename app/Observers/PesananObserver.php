<?php

namespace App\Observers;

use App\Models\Pesanan;
use App\Services\LayananDokumentasi;

class PesananObserver
{
    public function __construct(protected LayananDokumentasi $layanan) {}

    public function created(Pesanan $pesanan): void { $this->layanan->perbaruiDokumentasi(); }
    public function updated(Pesanan $pesanan): void { $this->layanan->perbaruiDokumentasi(); }
    public function deleted(Pesanan $pesanan): void { $this->layanan->perbaruiDokumentasi(); }
}