<?php

namespace App\Livewire\Pengelola\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\GambarProduk;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use App\Models\SpesifikasiProduk;
use App\Models\VarianProduk;
use App\Services\LayananStok;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Class FormProduk
 * Tujuan: Pusat Komando Editor Unit untuk registrasi dan modifikasi mendalam unit teknologi (ERP Standard).
 */
class FormProduk extends Component
{
    use WithFileUploads;

    public $produkId;
    public $activeTab = 'info'; // info, media, varian, bundling, logistik, spesifikasi, seo

    // Properti Inti
    public $nama, $slug, $kode_unit, $kategori_id, $merek_id;
    public $harga_modal = 0, $harga_jual = 0, $stok = 0, $berat_gram = 0;
    public $deskripsi_singkat, $deskripsi_lengkap;
    public $status = 'aktif', $memiliki_varian = false;
    public $tipe_produk = 'fisik'; // fisik, digital, bundle

    // Koleksi Dinamis
    public $gambar_baru = [];
    public $gambar_lama = [];
    public $daftarVarian = [];
    public $daftarSpesifikasi = [];
    public $daftarGrosir = [];
    public $dimensi = ['p' => 0, 'l' => 0, 't' => 0];
    public $daftarBundling = []; // [child_id, jumlah]
    
    // SEO State
    public $meta_judul, $meta_deskripsi;

    public function mount($id = null)
    {
        if ($id) {
            $produk = Produk::with(['varian', 'gambar', 'spesifikasi', 'bundlingItems'])->findOrFail($id);
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
            $this->tipe_produk = $produk->tipe_produk;
            $this->daftarGrosir = $produk->harga_grosir ?? [];
            $this->dimensi = $produk->dimensi_kemasan ?? ['p' => 0, 'l' => 0, 't' => 0];

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
                    'id' => $spek->id,
                    'label' => $spek->label,
                    'nilai' => $spek->nilai,
                ];
            }

            foreach ($produk->bundlingItems as $bund) {
                $this->daftarBundling[] = [
                    'child_id' => $bund->child_produk_id,
                    'jumlah' => $bund->jumlah,
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
        if (empty($this->meta_judul)) $this->meta_judul = $value;
    }

    // --- Manajemen Bundling ---
    public function tambahBarisBundling()
    {
        $this->daftarBundling[] = ['child_id' => '', 'jumlah' => 1];
    }

    public function hapusBarisBundling($index)
    {
        unset($this->daftarBundling[$index]);
        $this->daftarBundling = array_values($this->daftarBundling);
    }

    // --- Manajemen Grosir ---
    public function tambahBarisGrosir()
    {
        $this->daftarGrosir[] = ['min_qty' => 10, 'harga' => 0];
    }

    public function hapusBarisGrosir($index)
    {
        unset($this->daftarGrosir[$index]);
        $this->daftarGrosir = array_values($this->daftarGrosir);
    }

    // --- Manajemen Varian ---
    public function tambahBarisVarian()
    {
        $this->daftarVarian[] = [
            'id' => null,
            'nama_varian' => '',
            'kode_unit' => $this->kode_unit . '-VAR-' . (count($this->daftarVarian) + 1),
            'harga_tambahan' => 0,
            'stok' => 0,
        ];
    }

    public function hapusBarisVarian($index)
    {
        unset($this->daftarVarian[$index]);
        $this->daftarVarian = array_values($this->daftarVarian);
    }

    // --- Manajemen Spesifikasi ---
    public function tambahBarisSpesifikasi()
    {
        $this->daftarSpesifikasi[] = ['id' => null, 'label' => '', 'nilai' => ''];
    }

    public function hapusBarisSpesifikasi($index)
    {
        unset($this->daftarSpesifikasi[$index]);
        $this->daftarSpesifikasi = array_values($this->daftarSpesifikasi);
    }

    public function terapkanTemplate($tipe)
    {
        $templates = [
            'laptop' => ['Prosesor', 'RAM', 'Penyimpanan', 'Kartu Grafis', 'Layar'],
            'smartphone' => ['Chipset', 'RAM/Internal', 'Kamera Utama', 'Layar', 'Baterai'],
        ];

        foreach ($templates[$tipe] ?? [] as $label) {
            $this->daftarSpesifikasi[] = ['id' => null, 'label' => $label, 'nilai' => '-'];
        }
    }

    // --- Manajemen Media ---
    public function hapusGambarLama($id)
    {
        GambarProduk::destroy($id);
        $this->gambar_lama = array_filter($this->gambar_lama, fn ($g) => $g['id'] != $id);
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Visual dihapus dari galeri.']);
    }

    // --- Eksekusi Utama ---
    public function simpan()
    {
        $this->validate([
            'nama' => 'required|min:5',
            'kode_unit' => 'required|unique:produk,kode_unit,' . $this->produkId,
            'harga_jual' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategori,id',
            'merek_id' => 'required|exists:merek,id',
            'gambar_baru.*' => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'nama' => $this->nama,
                'slug' => $this->slug,
                'kode_unit' => $this->kode_unit,
                'kategori_id' => $this->kategori_id,
                'merek_id' => $this->merek_id,
                'harga_modal' => $this->harga_modal,
                'harga_jual' => $this->harga_jual,
                'stok' => $this->tipe_produk === 'bundle' ? 0 : $this->stok, // Stok bundle dihitung dinamis
                'deskripsi_singkat' => $this->deskripsi_singkat,
                'deskripsi_lengkap' => $this->deskripsi_lengkap,
                'status' => $this->status,
                'tipe_produk' => $this->tipe_produk,
                'memiliki_varian' => $this->memiliki_varian,
                'harga_grosir' => $this->daftarGrosir,
                'dimensi_kemasan' => $this->dimensi,
            ];

            if ($this->produkId) {
                $produk = Produk::find($this->produkId);
                $produk->update($data);
                $aksi = 'update_unit';
                $memo = "Modifikasi mendalam pada unit {$this->nama}.";
            } else {
                $produk = Produk::create($data);
                $this->produkId = $produk->id;
                $aksi = 'registrasi_unit';
                $memo = "Pendaftaran unit teknologi baru {$this->nama} ke inventaris.";
                
                // Input Stok Awal (Hanya non-bundle)
                if ($this->stok > 0 && $this->tipe_produk !== 'bundle') {
                    (new LayananStok)->tambahStok($produk, $this->stok, 'Registrasi awal unit');
                }
            }

            // Sync Bundling
            if ($this->tipe_produk === 'bundle') {
                \App\Models\ProdukBundling::where('parent_produk_id', $produk->id)->delete();
                foreach ($this->daftarBundling as $bund) {
                    if (!empty($bund['child_id'])) {
                        \App\Models\ProdukBundling::create([
                            'parent_produk_id' => $produk->id,
                            'child_produk_id' => $bund['child_id'],
                            'jumlah' => $bund['jumlah']
                        ]);
                    }
                }
            }

            // Sync Varian
            if ($this->memiliki_varian && $this->tipe_produk !== 'bundle') {
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

            // Sync Spesifikasi
            SpesifikasiProduk::where('produk_id', $produk->id)->delete();
            foreach ($this->daftarSpesifikasi as $spek) {
                if (! empty($spek['label'])) {
                    SpesifikasiProduk::create([
                        'produk_id' => $produk->id,
                        'label' => $spek['label'],
                        'nilai' => $spek['nilai'],
                    ]);
                }
            }

            // Sync Gambar
            foreach ($this->gambar_baru as $img) {
                $path = $img->store('produk', 'public');
                GambarProduk::create([
                    'produk_id' => $produk->id,
                    'url' => '/storage/' . $path,
                    'is_utama' => false,
                ]);
            }

            LogHelper::catat($aksi, $this->nama, $memo);
            
            DB::commit();
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Seluruh parameter unit berhasil disinkronkan ke pusat data.']);
            return redirect()->route('pengelola.produk.katalog');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal sinkronisasi: ' . $e->getMessage()]);
        }
    }

    #[Title('Editor Command Center - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.form-produk', [
            'daftarKategori' => Kategori::all(),
            'daftarMerek' => Merek::all(),
            'semuaProduk' => Produk::where('tipe_produk', 'fisik')->orderBy('nama')->get(), // Untuk pilihan bundling
        ])->layout('components.layouts.admin');
    }
}
