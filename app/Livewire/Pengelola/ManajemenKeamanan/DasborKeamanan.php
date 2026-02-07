<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use App\Models\InsidenKeamanan;
use App\Models\AturanFirewall;
use App\Services\LayananKeamanan;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Komponen Dasbor Keamanan
 * 
 * Pusat monitoring keamanan siber, ancaman real-time, dan audit forensik.
 */
class DasborKeamanan extends Component
{
    public $ringkasan = [];
    public $skorRisiko = 100;
    public $analisisGeo = [];
    public $ancamanTerdeteksi = [];

    public function mount(LayananKeamanan $keamanan)
    {
        $this->muatData($keamanan);
    }

    public function muatData(LayananKeamanan $keamanan)
    {
        $this->skorRisiko = $keamanan->hitungSkorRisiko();
        $this->analisisGeo = $keamanan->dapatkanAnalisisGeo();
        $this->ancamanTerdeteksi = $keamanan->deteksiAncamanOtomatis();

        $this->ringkasan = [
            'total_insiden_24j' => InsidenKeamanan::where('dibuat_pada', '>=', now()->subDay())->count(),
            'total_blokir' => AturanFirewall::where('tipe_aturan', 'blokir')->aktif()->count(),
            'insiden_kritis' => InsidenKeamanan::where('tingkat_keparahan', 'kritis')->where('dibuat_pada', '>=', now()->subWeek())->count(),
            'serangan_terbanyak' => InsidenKeamanan::select('jenis_insiden', \DB::raw('count(*) as total'))
                ->groupBy('jenis_insiden')
                ->orderByDesc('total')
                ->first()?->jenis_insiden ?? 'Nihil',
            'api_uptime' => '99.98%',
            'mfa_compliance' => '85%',
        ];
    }

    public function autoRemediate($index)
    {
        $ancaman = $this->ancamanTerdeteksi[$index];
        
        AturanFirewall::create([
            'alamat_ip' => $ancaman['ip'],
            'tipe_aturan' => 'blokir',
            'alasan' => 'Auto-Remediation: ' . $ancaman['tipe'],
            'status' => 'aktif'
        ]);

        unset($this->ancamanTerdeteksi[$index]);
        $this->dispatch('notifikasi', tipe: 'sukses', pesan: 'IP ' . $ancaman['ip'] . ' telah diblokir secara otomatis.');
    }

    #[Title('Pusat Komando Keamanan - Teqara Enterprise')]
    public function render()
    {
        $insidenTerbaru = InsidenKeamanan::with('pengguna')->latest('dibuat_pada')->take(10)->get();
        $aturanAktif = AturanFirewall::latest('dibuat_pada')->take(5)->get();

        return view('livewire.pengelola.manajemen-keamanan.dasbor-keamanan', [
            'insidenTerbaru' => $insidenTerbaru,
            'aturanAktif' => $aturanAktif
        ])->layout('components.layouts.admin', ['header' => 'Pusat Operasi Keamanan (SOC)']);
    }
}
