<?php

namespace App\Livewire\Pengelola\ManajemenPegawai;

use App\Models\HakAkses;
use App\Models\Peran;
use App\Services\LayananHakAkses;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Komponen Manajemen Hak Akses
 * 
 * Mengelola matriks hak akses antar peran dan fitur sistem secara dinamis.
 */
class ManajemenAkses extends Component
{
    // Properti Dasar
    public $peranTerpilihId;
    public $modeTambahPeran = false;
    public $namaPeran;
    public $aksesTerpilih = [];

    /**
     * Mengambil daftar peran yang tersedia.
     */
    public function getDaftarPeranProperty()
    {
        return Peran::orderBy('nama')->get();
    }

    /**
     * Mengambil daftar seluruh hak akses (fitur sistem).
     */
    public function getDaftarHakAksesProperty()
    {
        return HakAkses::orderBy('grup_modul')->orderBy('nama_fitur')->get();
    }

    /**
     * Mengambil instance peran yang sedang terpilih.
     */
    public function getPeranTerpilihProperty()
    {
        return $this->peranTerpilihId ? Peran::find($this->peranTerpilihId) : null;
    }

    /**
     * Memilih peran untuk dikonfigurasi hak aksesnya.
     */
    public function pilihPeran($id)
    {
        $this->peranTerpilihId = $id;
        $this->aksesTerpilih = $this->peranTerpilih->hakAkses->pluck('id')->toArray();
        $this->modeTambahPeran = false;
    }

    /**
     * Menampilkan form tambah peran baru.
     */
    public function tambahPeran()
    {
        $this->modeTambahPeran = true;
        $this->peranTerpilihId = null;
        $this->namaPeran = '';
    }

    /**
     * Menyimpan peran baru ke database.
     */
    public function simpanPeran()
    {
        $this->validate(['namaPeran' => 'required|unique:peran,nama|min:3']);

        $peran = Peran::create([
            'nama' => $this->namaPeran,
            'slug' => Str::slug($this->namaPeran),
        ]);

        $this->pilihPeran($peran->id);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Peran '{$peran->nama}' berhasil dibuat."]);
    }

    /**
     * Sinkronisasi rute sistem ke tabel hak akses secara manual.
     */
    public function sinkronkanFitur(LayananHakAkses $layanan)
    {
        $hasil = $layanan->sinkronkan();
        $pesan = "Sinkronisasi selesai. {$hasil['baru']} fitur baru ditambahkan.";
        
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => $pesan]);
    }

    /**
     * Menyimpan perubahan matriks hak akses untuk peran terpilih.
     */
    public function simpanAkses()
    {
        if ($this->peranTerpilih && $this->peranTerpilih->slug !== 'admin') {
            $this->peranTerpilih->hakAkses()->sync($this->aksesTerpilih);
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Hak akses untuk '{$this->peranTerpilih->nama}' diperbarui."]);
        }
    }

    #[Title('Manajemen Hak Akses - Teqara Enterprise')]
    public function render()
    {
        return view('components.pengelola.manajemen-pegawai.⚡manajemen-akses')
            ->layout('components.layouts.admin', ['header' => 'Keamanan SDM']);
    }
}
