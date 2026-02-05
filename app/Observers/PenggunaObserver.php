<?php

namespace App\Observers;

use App\Models\Pengguna;
use App\Services\LayananDokumentasi;

class PenggunaObserver
{
    public function __construct(protected LayananDokumentasi $layanan) {}

    public function created(Pengguna $pengguna): void { $this->layanan->perbaruiDokumentasi(); }
    public function updated(Pengguna $pengguna): void { $this->layanan->perbaruiDokumentasi(); }
    public function deleted(Pengguna $pengguna): void { $this->layanan->perbaruiDokumentasi(); }
}