<?php

namespace App\Livewire\Admin\Produk;

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

class FormProduk extends Component
{
    use WithFileUploads;

    public $produkId;

    // Tab State
    public $activeTab = 'info'; // info, media, varian, spesifikasi

    // Info Dasar
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

    public $memiliki_varian = false;

    // Media
    public $gambar_baru = []; // Upload multiple

    public $gambar_lama = []; // Existing

    // Varian (Array of Arrays)
    public $daftarVarian = [];

    // Spesifikasi
    public $daftarSpesifikasi = [];

    public function mount($id = null)
    {
        if ($id) {
            $produk = Produk::with(['varian', 'gambar', 'spesifikasi'])->findOrFail($id);
            $this->produkId = $produk->id;

            // Hydrate Info
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
            $this->memiliki_varian = $produk->memiliki_varian;

            // Hydrate Varian
            foreach ($produk->varian as $var) {
                $this->daftarVarian[] = [
                    'id' => $var->id,
                    'nama_varian' => $var->nama_varian,
                    'sku' => $var->sku,
                    'harga_tambahan' => $var->harga_tambahan,
                    'stok' => $var->stok,
                ];
            }

            // Hydrate Spesifikasi
            foreach ($produk->spesifikasi as $spek) {
                $this->daftarSpesifikasi[] = [
                    'judul' => $spek->judul,
                    'nilai' => $spek->nilai,
                ];
            }

            // Hydrate Gambar
            $this->gambar_lama = $produk->gambar->toArray();
        } else {
            // Default Empty Rows
            $this->tambahBarisSpesifikasi();
        }
    }

    public function updatedNama($value)
    {
        $this->slug = Str::slug($value);
    }

    // --- Varian Logic ---
    public function tambahBarisVarian()
    {
        $this->daftarVarian[] = [
            'id' => null,
            'nama_varian' => '',
            'sku' => '',
            'harga_tambahan' => 0,
            'stok' => 0,
        ];
    }

    public function hapusBarisVarian($index)
    {
        unset($this->daftarVarian[$index]);
        $this->daftarVarian = array_values($this->daftarVarian);
    }

    // --- Spesifikasi Logic ---
    public function tambahBarisSpesifikasi()
    {
        $this->daftarSpesifikasi[] = ['judul' => '', 'nilai' => ''];
    }

    public function hapusBarisSpesifikasi($index)
    {
        unset($this->daftarSpesifikasi[$index]);
        $this->daftarSpesifikasi = array_values($this->daftarSpesifikasi);
    }

    // --- Media Logic ---
    public function hapusGambarLama($id)
    {
        GambarProduk::destroy($id);
        $this->gambar_lama = array_filter($this->gambar_lama, fn ($g) => $g['id'] != $id);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'sku' => 'required',
            'harga_jual' => 'required|numeric',
        ]);

        // Simpan Produk Utama
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
            'memiliki_varian' => $this->memiliki_varian,
        ];

        if ($this->produkId) {
            $produk = Produk::find($this->produkId);
            $produk->update($data);
        } else {
            $produk = Produk::create($data);
            $this->produkId = $produk->id;
        }

        // Simpan Varian
        if ($this->memiliki_varian) {
            // Hapus yang tidak ada di list (jika edit) - Simplifikasi: delete all insert all or update logic
            // Untuk demo ini, kita update yang punya ID, create yang null
            foreach ($this->daftarVarian as $var) {
                if (! empty($var['nama_varian'])) {
                    VarianProduk::updateOrCreate(
                        ['id' => $var['id'] ?? null],
                        [
                            'produk_id' => $produk->id,
                            'nama_varian' => $var['nama_varian'],
                            'sku' => $var['sku'],
                            'harga_tambahan' => $var['harga_tambahan'],
                            'stok' => $var['stok'],
                        ]
                    );
                }
            }
        }

        // Simpan Spesifikasi (Delete all insert new for simplicity in repeater)
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

        // Simpan Gambar Baru
        foreach ($this->gambar_baru as $img) {
            // Simulasi URL (Di production pakai Storage::put)
            $url = $img->temporaryUrl();
            GambarProduk::create([
                'produk_id' => $produk->id,
                'url' => $url,
                'is_utama' => false,
            ]);
        }

        return redirect()->to('/admin/produk');
    }

    #[Title('Formulir Produk Lengkap')]
    public function render()
    {
        return view('livewire.admin.produk.form-produk', [
            'daftarKategori' => Kategori::all(),
            'daftarMerek' => Merek::all(),
        ])->layout('components.layouts.admin');
    }
}
