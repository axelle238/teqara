<?php

namespace App\Livewire\Admin\Produk;

use App\Models\Kategori;
use App\Models\LogAktivitas;
use App\Models\Merek;
use App\Models\Produk;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormProduk extends Component
{
    use WithFileUploads;

    public $produkId;

    public $nama;

    public $slug;

    public $sku;

    public $kategori_id;

    public $merek_id;

    public $harga_modal = 0;

    public $harga_jual = 0;

    public $stok = 0;

    public $deskripsi_singkat;

    public $deskripsi_lengkap;

    public $status = 'aktif';

    public $gambar_baru;

    public $gambar_lama;

    public function mount($id = null)
    {
        if ($id) {
            $produk = Produk::findOrFail($id);
            $this->produkId = $produk->id;
            $this->nama = $produk->nama;
            $this->slug = $produk->slug;
            $this->sku = $produk->sku;
            $this->kategori_id = $produk->kategori_id;
            $this->merek_id = $produk->merek_id;
            $this->harga_modal = $produk->harga_modal;
            $this->harga_jual = $produk->harga_jual;
            $this->stok = $produk->stok;
            $this->deskripsi_singkat = $produk->deskripsi_singkat;
            $this->deskripsi_lengkap = $produk->deskripsi_lengkap;
            $this->status = $produk->status;
            $this->gambar_lama = $produk->gambar_utama;
        }
    }

    // Otomatis buat slug saat nama diketik
    public function updatedNama($value)
    {
        $this->slug = Str::slug($value);
    }

    public function simpan()
    {
        $aturan = [
            'nama' => 'required|min:5',
            'slug' => 'required|unique:produk,slug,'.$this->produkId,
            'sku' => 'required|unique:produk,sku,'.$this->produkId,
            'kategori_id' => 'required|exists:kategori,id',
            'harga_modal' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
            'status' => 'required|in:aktif,arsip,habis',
            'gambar_baru' => $this->produkId ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];

        $pesan = [
            'nama.required' => 'Nama produk wajib diisi.',
            'slug.unique' => 'Slug sudah digunakan, silakan ubah nama.',
            'sku.required' => 'SKU wajib diisi.',
            'kategori_id.required' => 'Pilih kategori produk.',
            'gambar_baru.required' => 'Foto produk wajib diunggah.',
        ];

        $this->validate($aturan, $pesan);

        $data = [
            'nama' => $this->nama,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'kategori_id' => $this->kategori_id,
            'merek_id' => $this->merek_id,
            'harga_modal' => $this->harga_modal,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
            'deskripsi_singkat' => $this->deskripsi_singkat,
            'deskripsi_lengkap' => $this->deskripsi_lengkap,
            'status' => $this->status,
        ];

        // Handle Unggah Gambar
        if ($this->gambar_baru) {
            // Di produksi, gunakan: $path = $this->gambar_baru->store('produk', 'public');
            // Untuk demo, kita simpan URL temporary atau path simulasi
            $data['gambar_utama'] = $this->gambar_baru->temporaryUrl();
        }

        if ($this->produkId) {
            $produk = Produk::find($this->produkId);
            $produk->update($data);
            $aksi = 'memperbarui';
        } else {
            Produk::create($data);
            $aksi = 'menambahkan';
        }

        // Catat Log
        LogAktivitas::create([
            'pengguna_id' => auth()->id(),
            'aksi' => $this->produkId ? 'update_produk' : 'tambah_produk',
            'target' => $this->nama,
            'pesan_naratif' => 'Admin '.auth()->user()->nama." berhasil $aksi produk {$this->nama}",
            'waktu' => now(),
        ]);

        $this->dispatch('notifikasi', [
            'tipe' => 'sukses',
            'pesan' => "Produk {$this->nama} berhasil disimpan!",
        ]);

        return redirect()->to('/admin/produk');
    }

    #[Title('Formulir Produk - Teqara')]
    public function render()
    {
        return view('livewire.admin.produk.form-produk', [
            'daftarKategori' => Kategori::all(),
            'daftarMerek' => Merek::all(),
        ])->layout('components.layouts.admin');
    }
}
