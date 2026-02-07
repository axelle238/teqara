<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use App\Models\InsidenKeamanan;
use App\Models\AturanFirewall;
use Livewire\Attributes\Title;
use Livewire\Component;

class DashboardKeamanan extends Component
{
    public $ringkasan = [];

    public function mount()
    {
        $this->muatRingkasan();
    }

    public function muatRingkasan()
    {
        $this->ringkasan = [
            'total_insiden_24j' => InsidenKeamanan::where('dibuat_pada', '>=', now()->subDay())->count(),
            'total_blokir' => AturanFirewall::where('tipe_aturan', 'blokir')->aktif()->count(),
            'insiden_kritis' => InsidenKeamanan::where('tingkat_keparahan', 'kritis')->where('dibuat_pada', '>=', now()->subWeek())->count(),
            'serangan_terbanyak' => InsidenKeamanan::select('jenis_insiden', \DB::raw('count(*) as total'))
                ->groupBy('jenis_insiden')
                ->orderByDesc('total')
                ->first()?->jenis_insiden ?? 'Nihil',
        ];
    }

    #[Title('Pusat Komando Keamanan - Teqara Enterprise')]
    public function render()
    {
        $insidenTerbaru = InsidenKeamanan::with('pengguna')->latest('dibuat_pada')->take(5)->get();
        $aturanAktif = AturanFirewall::latest('dibuat_pada')->take(5)->get();

        return view('livewire.pengelola.manajemen-keamanan.dashboard-keamanan', [
            'insidenTerbaru' => $insidenTerbaru,
            'aturanAktif' => $aturanAktif
        ])->layout('components.layouts.admin', ['header' => 'Security Operation Center (SOC)']);
    }
}
