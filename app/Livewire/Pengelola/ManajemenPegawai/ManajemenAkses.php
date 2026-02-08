<?php

namespace App\Livewire\Pengelola\ManajemenPegawai;

use App\Helpers\LogHelper;
use App\Models\HakAksesRole;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class ManajemenAkses
 * Tujuan: Mengelola matriks hak akses Role-Based Access Control (RBAC).
 */
class ManajemenAkses extends Component
{
    public $peranList = ['Admin', 'Editor', 'CS', 'Gudang'];
    public $modulList = ['Produk', 'Pesanan', 'Laporan', 'HRD', 'Keamanan'];

    public function mount()
    {
        // Inisialisasi Matriks jika kosong
        foreach ($this->peranList as $peran) {
            foreach ($this->modulList as $modul) {
                HakAksesRole::firstOrCreate(
                    ['peran' => $peran, 'modul' => $modul],
                    ['baca' => false, 'tulis' => false, 'hapus' => false]
                );
            }
        }
    }

    public function toggleAkses($id, $tipe)
    {
        $akses = HakAksesRole::find($id);
        
        // Admin selalu punya akses penuh (proteksi)
        if ($akses->peran === 'Admin') {
            $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Hak akses Administrator tidak dapat diubah.']);
            return;
        }

        $akses->$tipe = !$akses->$tipe;
        $akses->save();

        LogHelper::catat('ubah_akses', "{$akses->peran}-{$akses->modul}", "Mengubah izin {$tipe} menjadi " . ($akses->$tipe ? 'Aktif' : 'Nonaktif'));
    }

    #[Title('Matriks Akses Keamanan - Admin Teqara')]
    public function render()
    {
        // Mengelompokkan data berdasarkan Peran untuk ditampilkan per kolom/grup
        $matriks = HakAksesRole::all()->groupBy('peran');

        return view('livewire.pengelola.manajemen-pegawai.manajemen-akses', [
            'matriks' => $matriks
        ])->layout('components.layouts.admin', ['header' => 'Keamanan & Akses']);
    }
}
