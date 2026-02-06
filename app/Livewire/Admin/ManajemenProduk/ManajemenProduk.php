<?php

namespace App\Livewire\Admin\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use App\Services\LayananStok;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

/**
 * Class ManajemenProduk
 * Tujuan: Mengelola inventaris produk komputer dan gadget secara hulu ke hilir.
 */
class ManajemenProduk extends Component
{
    use WithFileUploads, WithPagination;

    // Properti Form
    public $produk_id;

    public $kategori_id;

    public $merek_id;

    public $nama;

    public $kode_unit;

    public $harga_modal;

    public $harga_jual;

    public $stok;

    public $berat_gram;

    public $deskripsi_singkat;

    public $deskripsi_lengkap;

    public $status = 'aktif';

    public $gambar_baru;

    // Filter & Pencarian
    public $cari = '';

    public $filter_kategori = '';

    public $selectedProduk = [];

    public $selectAll = false;

    // ... (rest of existing properties)

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedProduk = Produk::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedProduk = [];
        }
    }

    public function bulkDelete()
    {
        $count = count($this->selectedProduk);
        if ($count > 0) {
            Produk::whereIn('id', $this->selectedProduk)->delete();
            
            LogHelper::catat(
                'hapus_massal_produk',
                "{$count} Produk",
                "Admin menghapus {$count} produk sekaligus dari inventaris."
            );

            $this->reset(['selectedProduk', 'selectAll']);
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "{$count} unit berhasil dihapus."]);
        }
    }

    public function bulkArchive()
    {
        $count = count($this->selectedProduk);
        if ($count > 0) {
            Produk::whereIn('id', $this->selectedProduk)->update(['status' => 'arsip']);

            LogHelper::catat(
                'arsip_massal_produk',
                "{$count} Produk",
                "Admin mengarsipkan {$count} produk sekaligus."
            );

            $this->reset(['selectedProduk', 'selectAll']);
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "{$count} unit berhasil diarsipkan."]);
        }
    }

    protected function rules()
    {
        return [
            'nama' => 'required|min:5',
            'kategori_id' => 'required|exists:kategori,id',
            'merek_id' => 'required|exists:merek,id',
            'kode_unit' => 'required|unique:produk,kode_unit,' . $this->produk_id,
            'harga_modal' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ];
    }

    public function tambahBaru()
    {
        $this->reset(['produk_id', 'kategori_id', 'merek_id', 'nama', 'kode_unit', 'harga_modal', 'harga_jual', 'stok', 'berat_gram', 'deskripsi_singkat', 'deskripsi_lengkap', 'gambar_baru']);
        $this->status = 'aktif';
        $this->dispatch('open-panel-form-produk');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $this->produk_id = $produk->id;
        $this->kategori_id = $produk->kategori_id;
        $this->merek_id = $produk->merek_id;
        $this->nama = $produk->nama;
        $this->kode_unit = $produk->kode_unit;
        $this->harga_modal = $produk->harga_modal;
        $this->harga_jual = $produk->harga_jual;
        $this->stok = $produk->stok;
        $this->berat_gram = $produk->berat_gram;
        $this->deskripsi_singkat = $produk->deskripsi_singkat;
        $this->deskripsi_lengkap = $produk->deskripsi_lengkap;
        $this->status = $produk->status;

        $this->dispatch('open-panel-form-produk');
    }

    public function simpan()
    {
        $this->validate();

        $data = [
            'kategori_id' => $this->kategori_id,
            'merek_id' => $this->merek_id,
            'nama' => $this->nama,
            'kode_unit' => $this->kode_unit,
            'harga_modal' => $this->harga_modal,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
            'berat_gram' => $this->berat_gram ?? 1000,
            'deskripsi_singkat' => $this->deskripsi_singkat,
            'deskripsi_lengkap' => $this->deskripsi_lengkap,
            'status' => $this->status,
        ];

        if ($this->gambar_baru) {
            $path = $this->gambar_baru->store('produk', 'public');
            $data['gambar_utama'] = '/storage/' . $path;
        }

        if ($this->produk_id) {
            // Mode Edit
            $produk = Produk::findOrFail($this->produk_id);
            $stokLama = $produk->stok;
            $produk->update($data);

            // Log Perubahan Stok jika ada selisih
            if ($this->stok != $stokLama) {
                $selisih = $this->stok - $stokLama;
                $layananStok = new LayananStok;
                $layananStok->tambahStok($produk, $selisih, "Penyesuaian stok manual via Admin (Edit)");
            }

            LogHelper::catat(
                'ubah_produk',
                $this->nama,
                "Admin mengubah data produk: {$this->nama} (ID: {$this->produk_id})",
                ['sebelum' => $produk->getOriginal(), 'sesudah' => $data]
            );

            $pesan = "Data unit {$this->nama} berhasil diperbarui!";
        } else {
            // Mode Buat Baru
            $produk = Produk::create($data);

            if ($this->stok > 0) {
                $layananStok = new LayananStok;
                $layananStok->tambahStok($produk, $this->stok, 'Input stok awal produk baru');
            }

            LogHelper::catat(
                'buat_produk',
                $this->nama,
                "Admin menambahkan produk baru: {$this->nama} (kode_unit: {$this->kode_unit})",
                $data
            );

            $pesan = "Unit baru {$this->nama} berhasil didaftarkan ke inventaris!";
        }

        $this->dispatch('close-panel-form-produk');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        $this->reset(['produk_id', 'gambar_baru']);
    }

    public function hapus($id)
    {
        $produk = Produk::findOrFail($id);
        $nama = $produk->nama;
        $produk->delete();

        LogHelper::catat(
            'hapus_produk',
            $nama,
            "Admin menghapus produk: {$nama} dari inventaris.",
            ['id_terhapus' => $id]
        );

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Unit {$nama} telah dihapus dari sistem."]);
    }

    #[Title('Manajemen Produk - Teqara Admin')]
    public function render()
    {
        $daftar_produk = Produk::query()
            ->with(['kategori', 'merek'])
            ->where('nama', 'like', '%'.$this->cari.'%')
            ->when($this->filter_kategori, fn ($q) => $q->where('kategori_id', $this->filter_kategori))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.manajemen-produk.manajemen-produk', [
            'produk' => $daftar_produk,
            'kategori' => Kategori::all(),
            'merek' => Merek::all(),
        ])->layout('components.layouts.admin');
    }
}
