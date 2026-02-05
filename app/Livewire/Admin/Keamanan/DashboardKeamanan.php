<?php

namespace App\Livewire\Admin\Keamanan;

use App\Models\LogAktivitas;
use App\Models\Pengaturan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardKeamanan extends Component
{
    use WithPagination;

    public $filterAksi = '';

    public $wajib_ganti_sandi_90_hari = false;

    public $aktifkan_2fa_admin = false;

    public function mount()
    {
        $this->wajib_ganti_sandi_90_hari = Pengaturan::where('kunci', 'security_wajib_ganti_sandi')->value('nilai') === '1';
        $this->aktifkan_2fa_admin = Pengaturan::where('kunci', 'security_2fa_admin')->value('nilai') === '1';
    }

    public function simpanKebijakan()
    {
        Pengaturan::updateOrCreate(['kunci' => 'security_wajib_ganti_sandi'], ['nilai' => $this->wajib_ganti_sandi_90_hari ? '1' : '0', 'tipe' => 'boolean']);
        Pengaturan::updateOrCreate(['kunci' => 'security_2fa_admin'], ['nilai' => $this->aktifkan_2fa_admin ? '1' : '0', 'tipe' => 'boolean']);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Kebijakan keamanan diperbarui.']);
    }

    #[Title('Pusat Keamanan - Admin Teqara')]
    public function render()
    {
        $logs = LogAktivitas::with('pengguna')
            ->when($this->filterAksi, fn ($q) => $q->where('aksi', $this->filterAksi))
            ->latest('waktu')
            ->paginate(15);

        return view('livewire.admin.keamanan.dashboard-keamanan', [
            'logs' => $logs,
            'total_insiden' => 0, // Placeholder untuk masa depan
        ])->layout('components.layouts.admin');
    }
}
