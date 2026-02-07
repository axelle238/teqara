<?php

namespace App\Livewire\Pengelola;

use App\Models\Notifikasi;
use Livewire\Component;

class NotifikasiTopbar extends Component
{
    public function getNotifikasiProperty()
    {
        return Notifikasi::untukSaya()
            ->belumDibaca()
            ->latest('dibuat_pada')
            ->take(5)
            ->get();
    }

    public function getUnreadCountProperty()
    {
        return Notifikasi::untukSaya()->belumDibaca()->count();
    }

    public function markAsRead($id)
    {
        $notif = Notifikasi::find($id);
        if ($notif) {
            $notif->update(['dibaca_pada' => now()]);
        }
    }

    public function markAllAsRead()
    {
        Notifikasi::untukSaya()->belumDibaca()->update(['dibaca_pada' => now()]);
    }

    public function render()
    {
        return view('livewire.pengelola.notifikasi-topbar');
    }
}
