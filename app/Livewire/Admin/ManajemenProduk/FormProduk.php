<?php

namespace App\Livewire\Admin\ManajemenProduk;

use App\Models\GambarProduk;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use App\Models\SpesifikasiProduk;
use App\Models\VarianProduk;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Class FormProduk
 * Tujuan: Formulir komprehensif untuk registrasi unit produk baru atau modifikasi unit lama.
 */
class FormProduk extends Component
{
    use WithFileUploads;

    public $produkId;

    public $activeTab = 'info';

    public $nama;

    public $slug;

    public $kode_unit;

    public $kategori_id;

    public $merek_id;

    public $harga_modal = 0;

    public $harga_jual = 0;

    public $stok = 0;

    public $deskripsi_singkat;

    public $deskripsi_lengkap;

    public $status = 'aktif';

    public $memiliki_varian = false;

    public $gambar_baru = [];

    public $gambar_lama = [];

    public $daftarVarian = [];

    public $daftarSpesifikasi = [];

    public function mount($id = null)
    {
        if ($id) {
            $produk = Produk::with(['varian', 'gambar', 'spesifikasi'])->findOrFail($id);
            $this->produkId = $produk->id;
            $this->nama = $produk->nama;
            $this->slug = $produk->slug;
            $this->kode_unit = $produk->kode_unit;
            $this->kategori_id = $produk->kategori_id;
            $this->merek_id = $produk->merek_id;
            $this->harga_modal = $produk->harga_modal;
            $this->harga_jual = $produk->harga_jual;
            $this->stok = $produk->stok;
            $this->deskripsi_singkat = $produk->deskripsi_singkat;
            $this->deskripsi_lengkap = $produk->deskripsi_lengkap;
            $this->status = $produk->status;
            $this->memiliki_varian = $produk->memiliki_varian;

            foreach ($produk->varian as $var) {
                $this->daftarVarian[] = [
                    'id' => $var->id,
                    'nama_varian' => $var->nama_varian,
                    'kode_unit' => $var->kode_unit,
                    'harga_tambahan' => $var->harga_tambahan,
                    'stok' => $var->stok,
                ];
            }

            foreach ($produk->spesifikasi as $spek) {
                $this->daftarSpesifikasi[] = [
                    'judul' => $spek->judul,
                    'nilai' => $spek->nilai,
                ];
            }

            $this->gambar_lama = $produk->gambar->toArray();
        } else {
            $this->tambahBarisSpesifikasi();
        }
    }

    public function updatedNama($value)
    {
        $this->slug = Str::slug($value);
    }

    public function tambahBarisVarian()
    {
        $this->daftarVarian[] = [
            'id' => null,
            'nama_varian' => '',
            'kode_unit' => '',
            'harga_tambahan' => 0,
            'stok' => 0,
        ];
    }

    public function hapusBarisVarian($index)
    {
        unset($this->daftarVarian[$index]);
        $this->daftarVarian = array_values($this->daftarVarian);
    }

    public function tambahBarisSpesifikasi()
    {
        $this->daftarSpesifikasi[] = ['judul' => '', 'nilai' => ''];
    }

    public function hapusBarisSpesifikasi($index)
    {
        unset($this->daftarSpesifikasi[$index]);
        $this->daftarSpesifikasi = array_values($this->daftarSpesifikasi);
    }

    public function hapusGambarLama($id)
    {
        GambarProduk::destroy($id);
        $this->gambar_lama = array_filter($this->gambar_lama, fn ($g) => $g['id'] != $id);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'kode_unit' => 'required',
            'harga_jual' => 'required|numeric',
        ]);

        $data = [
            'nama' => $this->nama,
            'slug' => $this->slug,
            'kode_unit' => $this->kode_unit,
            'kategori_id' => $this->kategori_id,
            'merek_id' => $this->merek_id,
            'harga_modal' => $this->harga_modal,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
            'deskripsi_singkat' => $this->deskripsi_singkat,
            'deskripsi_lengkap' => $this->deskripsi_lengkap,
            'status' => $this->status,
            'memiliki_varian' => $this->memiliki_varian,
        ];

        if ($this->produkId) {
            $produk = Produk::find($this->produkId);
            $produk->update($data);
        } else {
            $produk = Produk::create($data);
            $this->produkId = $produk->id;
        }

        if ($this->memiliki_varian) {
            foreach ($this->daftarVarian as $var) {
                if (! empty($var['nama_varian'])) {
                    VarianProduk::updateOrCreate(
                        ['id' => $var['id'] ?? null],
                        [
                            'produk_id' => $produk->id,
                            'nama_varian' => $var['nama_varian'],
                            'kode_unit' => $var['kode_unit'],
                            'harga_tambahan' => $var['harga_tambahan'],
                            'stok' => $var['stok'],
                        ]
                    );
                }
            }
        }

        SpesifikasiProduk::where('produk_id', $produk->id)->delete();
        foreach ($this->daftarSpesifikasi as $spek) {
            if (! empty($spek['judul'])) {
                SpesifikasiProduk::create([
                    'produk_id' => $produk->id,
                    'judul' => $spek['judul'],
                    'nilai' => $spek['nilai'],
                ]);
            }
        }

        foreach ($this->gambar_baru as $img) {
            $url = $img->temporaryUrl();
            GambarProduk::create([
                'produk_id' => $produk->id,
                'url' => $url,
                'is_utama' => false,
            ]);
        }

        return redirect()->route('admin.produk.katalog');
    }

    #[Title('Formulir Produk Lengkap')]
    public function render()
    {
        return view('livewire.admin.manajemen-produk.form-produk', [
            'daftarKategori' => Kategori::all(),
            'daftarMerek' => Merek::all(),
        ])->layout('components.layouts.admin');
    }
}
