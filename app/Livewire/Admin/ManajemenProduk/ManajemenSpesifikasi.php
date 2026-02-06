<?php

namespace App\Livewire\Admin\ManajemenProduk;

use App\Models\Produk;
use App\Models\SpesifikasiProduk;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class ManajemenSpesifikasi
 * Tujuan: Konfigurasi parameter teknis unit teknologi secara mendalam (ERP Standard).
 */
class ManajemenSpesifikasi extends Component
{
    public Produk $produk;
    public $spesifikasi = [];

    // Form State
    public $inputJudul;
    public $inputNilai;
    
    // Preset State
    public $kategoriTemplate = 'laptop';

    public function mount(Produk $produk)
    {
        $this->produk = $produk;
        $this->muatSpesifikasi();
    }

    public function muatSpesifikasi()
    {
        $this->spesifikasi = SpesifikasiProduk::where('produk_id', $this->produk->id)->get();
    }

    public function tambah()
    {
        $this->validate([
            'inputJudul' => 'required|min:2',
            'inputNilai' => 'required',
        ]);

        SpesifikasiProduk::create([
            'produk_id' => $this->produk->id,
            'label' => $this->inputJudul,
            'nilai' => $this->inputNilai,
        ]);

        $this->reset(['inputJudul', 'inputNilai']);
        $this->muatSpesifikasi();
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Parameter teknis berhasil disematkan.']);
    }

    public function terapkanTemplate()
    {
        $templates = [
            'laptop' => ['Prosesor', 'RAM', 'Penyimpanan', 'Kartu Grafis', 'Layar', 'Baterai'],
            'gadget' => ['Chipset', 'RAM/Internal', 'Kamera Utama', 'Kamera Depan', 'Layar', 'Baterai'],
            'periferal' => ['Konektivitas', 'Sensitivitas', 'Tipe Switch', 'Material', 'Kompatibilitas'],
        ];

        $labels = $templates[$this->kategoriTemplate] ?? [];

        foreach ($labels as $label) {
            // Cek apakah sudah ada untuk menghindari duplikat
            $exists = SpesifikasiProduk::where('produk_id', $this->produk->id)->where('label', $label)->exists();
            if (!$exists) {
                SpesifikasiProduk::create([
                    'produk_id' => $this->produk->id,
                    'label' => $label,
                    'nilai' => '-',
                ]);
            }
        }

        $this->muatSpesifikasi();
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Template spesifikasi berhasil diterapkan.']);
    }

    public function updateNilai($id, $nilai)
    {
        $s = SpesifikasiProduk::find($id);
        if ($s) {
            $s->update(['nilai' => $nilai]);
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Nilai '{$s->label}' diperbarui."]);
        }
    }

    public function hapus($id)
    {
        $s = SpesifikasiProduk::find($id);
        $label = $s->label;
        $s->delete();
        $this->muatSpesifikasi();
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => "Parameter '{$label}' dihapus."]);
    }

    #[Title('Konfigurasi Teknis Unit - Teqara Admin')]
    public function render()
    {
        return view('livewire.admin.manajemen-produk.manajemen-spesifikasi')
            ->layout('components.layouts.admin');
    }
}
