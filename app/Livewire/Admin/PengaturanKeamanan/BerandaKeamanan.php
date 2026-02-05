<?php

namespace App\Livewire\Admin\PengaturanKeamanan;

use App\Models\LogAktivitas;
use App\Models\PengaturanSistem;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class BerandaKeamanan
 * Tujuan: Dashboard pilar Pengaturan Keamanan Terpusat dan audit forensik.
 */
class BerandaKeamanan extends Component
{
    use WithPagination;

    public $filterAksi = '';

    public $wajib_ganti_sandi_90_hari = false;

    public $aktifkan_2fa_admin = false;

    public function mount()
    {
        $this->wajib_ganti_sandi_90_hari = PengaturanSistem::where('kunci', 'security_wajib_ganti_sandi')->value('nilai') === '1';
        $this->aktifkan_2fa_admin = PengaturanSistem::where('kunci', 'security_2fa_admin')->value('nilai') === '1';
    }

    public function simpanKebijakan()
    {
        PengaturanSistem::updateOrCreate(['kunci' => 'security_wajib_ganti_sandi'], ['nilai' => $this->wajib_ganti_sandi_90_hari ? '1' : '0', 'tipe' => 'boolean']);
        PengaturanSistem::updateOrCreate(['kunci' => 'security_2fa_admin'], ['nilai' => $this->aktifkan_2fa_admin ? '1' : '0', 'tipe' => 'boolean']);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Kebijakan keamanan diperbarui.']);
    }

    #[Title('Pusat Keamanan - Admin Teqara')]
    public function render()
    {
        $logs = LogAktivitas::with('pengguna')
            ->when($this->filterAksi, fn ($q) => $q->where('aksi', $this->filterAksi))
            ->latest('waktu')
            ->paginate(15);

        return view('livewire.admin.pengaturan-keamanan.beranda-keamanan', [
            'logs' => $logs,
            'total_insiden' => 0,
        ])->layout('components.layouts.admin');
    }
}
