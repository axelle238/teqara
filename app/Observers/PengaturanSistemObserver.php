<?php

namespace App\Observers;

use App\Models\PengaturanSistem;
use Illuminate\Support\Facades\Cache;

class PengaturanSistemObserver
{
    public function saved(PengaturanSistem $pengaturan)
    {
        Cache::forget('global_settings');
    }

    public function deleted(PengaturanSistem $pengaturan)
    {
        Cache::forget('global_settings');
    }
}
