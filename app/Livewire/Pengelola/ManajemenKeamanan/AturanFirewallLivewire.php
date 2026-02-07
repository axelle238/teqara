<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use App\Models\AturanFirewall;
use App\Services\LayananKeamanan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class AturanFirewallLivewire extends Component
{
    use WithPagination;

    public $ipBaru;
    public $alasanBaru;

    protected $rules = [
        'ipBaru' => 'required|ip',
        'alasanBaru' => 'required|string|max:255',
    ];

    public function blokirManual(LayananKeamanan $layanan)
    {
        $this->validate();

        $layanan->blokirOtomatis($this->ipBaru, "Manual Admin: " . $this->alasanBaru);
        
        $this->reset(['ipBaru', 'alasanBaru']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'IP berhasil ditambahkan ke daftar blokir.']);
    }

    public function hapusAturan($id)
    {
        AturanFirewall::destroy($id);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Aturan blokir dihapus.']);
    }

    #[Title('WAF Firewall - SOC Cyber Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.aturan-firewall', [
            'aturan' => AturanFirewall::latest()->paginate(10)
        ])->layout('components.layouts.admin', ['header' => 'Firewall Manager']);
    }
}