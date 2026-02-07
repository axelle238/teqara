<?php

namespace App\Livewire\Pengelola\PengaturanKeamanan;

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

    public $mode_pemeliharaan = false;

    public function mount()
    {
        $this->wajib_ganti_sandi_90_hari = PengaturanSistem::where('kunci', 'security_wajib_ganti_sandi')->value('nilai') === '1';
        $this->aktifkan_2fa_admin = PengaturanSistem::where('kunci', 'security_2fa_admin')->value('nilai') === '1';
        $this->mode_pemeliharaan = app()->isDownForMaintenance();
    }

    public function toggleMaintenance()
    {
        if ($this->mode_pemeliharaan) {
            \Illuminate\Support\Facades\Artisan::call('up');
            $this->mode_pemeliharaan = false;
            $pesan = 'Sistem telah dipulihkan. Akses publik dibuka kembali.';
        } else {
            \Illuminate\Support\Facades\Artisan::call('down', ['--secret' => 'teqara-admin-access']);
            $this->mode_pemeliharaan = true;
            $pesan = 'Sistem dikunci (Maintenance Mode). Akses publik ditutup.';
        }

        \App\Helpers\LogHelper::catat('system_lock', 'Core System', $pesan);
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => $pesan]);
    }

    public function simpanKebijakan()
    {
        PengaturanSistem::updateOrCreate(['kunci' => 'security_wajib_ganti_sandi'], ['nilai' => $this->wajib_ganti_sandi_90_hari ? '1' : '0', 'tipe' => 'boolean']);
        PengaturanSistem::updateOrCreate(['kunci' => 'security_2fa_admin'], ['nilai' => $this->aktifkan_2fa_admin ? '1' : '0', 'tipe' => 'boolean']);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Kebijakan keamanan diperbarui.']);
    }

    #[Title('Pusat Keamanan Siber - Admin Teqara')]
    public function render()
    {
        // Analisis Anomali Sederhana
        $loginGagal = LogAktivitas::where('aksi', 'login_gagal')
            ->where('waktu', '>=', now()->subDay())
            ->count();

        $ipUnik = LogAktivitas::where('waktu', '>=', now()->subDay())
            ->distinct('meta_data->alamat_ip') 
            ->count();

        $logs = LogAktivitas::with('pengguna')
            ->when($this->filterAksi, fn ($q) => $q->where('aksi', $this->filterAksi))
            ->latest('waktu')
            ->paginate(15);

        return view('livewire.pengelola.pengaturan-keamanan.beranda-keamanan', [
            'logs' => $logs,
            'statistik' => [
                'login_gagal' => $loginGagal,
                'ip_aktif' => $ipUnik,
                'insiden_kritis' => 0,
            ],
        ])->layout('components.layouts.admin');
    }
}
