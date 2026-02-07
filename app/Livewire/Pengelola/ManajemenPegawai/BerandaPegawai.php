<?php

namespace App\Livewire\Pengelola\ManajemenPegawai;

use App\Models\Jabatan;
use App\Models\Karyawan;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaPegawai
 * Tujuan: HR Command Center - Pusat analisis data SDM, kehadiran, dan kompensasi.
 */
class BerandaPegawai extends Component
{
    #[Title('HR Command Center - Admin Teqara')]
    public function render()
    {
        $totalKaryawan = Karyawan::count();

        // Simulasi Kehadiran (Idealnya dari tabel Absensi)
        $hadirHariIni = floor($totalKaryawan * 0.9);
        $izinHariIni = $totalKaryawan - $hadirHariIni;

        // Estimasi Payroll (Gaji Pokok + Tunjangan Jabatan)
        $estimasiGaji = Karyawan::with('jabatan')->get()->sum(function ($k) {
            return ($k->jabatan->gaji_pokok ?? 0) + ($k->jabatan->tunjangan ?? 0);
        });

        // Komposisi Departemen
        $komposisiDepartemen = Jabatan::with('departemen')
            ->get()
            ->groupBy('departemen.nama')
            ->map(fn ($group) => $group->count());

        $karyawanTerbaru = Karyawan::with(['pengguna', 'jabatan.departemen'])->latest('dibuat_pada')->take(5)->get();

        return view('livewire.pengelola.manajemen-pegawai.beranda-pegawai', [
            'statistik' => [
                'headcount' => $totalKaryawan,
                'hadir' => $hadirHariIni,
                'izin' => $izinHariIni,
                'payroll' => $estimasiGaji,
            ],
            'komposisi' => $komposisiDepartemen,
            'karyawanTerbaru' => $karyawanTerbaru,
        ])->layout('components.layouts.admin');
    }
}
