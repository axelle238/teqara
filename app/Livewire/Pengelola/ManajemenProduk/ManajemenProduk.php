<?php

namespace App\Livewire\Pengelola\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use App\Models\VarianProduk;
use App\Models\SpesifikasiProduk;
use App\Services\LayananStok;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

/**
 * Class ManajemenProduk
 * Tujuan: Mengelola inventaris produk komputer dan gadget secara hulu ke hilir.
 * Arsitektur: 100% Full Page SPA (Tanpa Slide Over/Modal).
 */
class ManajemenProduk extends Component
{
    use WithFileUploads, WithPagination;

    // State Halaman
    public $tampilkanForm = false;

    // Properti Form Produk Utama
    public $produk_id;
    public $kategori_id;
    public $merek_id;
    public $nama;
    public $kode_unit;
    public $harga_modal;
    public $harga_jual;
    public $stok;
    public $berat_gram = 1000;
    public $deskripsi_singkat;
    public $deskripsi_lengkap;
    public $status = 'aktif';
    public $gambar_baru;
    public $gambar_lama;

    // Properti Varian (Enterprise Feature)
    public $varian = []; // Array: [['nama' => '', 'sku' => '', 'harga' => 0, 'stok' => 0]]

    // Properti Spesifikasi (Enterprise Feature)
    public $spesifikasi = []; // Array: [['judul' => '', 'nilai' => '']]

    // Properti Harga Grosir (B2B Feature)
    public $harga_grosir = []; // Array: [['min' => 0, 'harga' => 0]]

    // Filter & Pencarian
    public $cari = '';
    public $filter_kategori = '';
    public $selectedProduk = [];
    public $selectAll = false;

    /**
     * Sinkronisasi pilihan massal.
     */
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedProduk = Produk::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedProduk = [];
        }
    }

    // --- MANAJEMEN VARIAN ---
    public function tambahBarisVarian()
    {
        $this->varian[] = ['nama' => '', 'sku' => '', 'harga_tambahan' => 0, 'stok' => 0];
    }

    public function hapusBarisVarian($index)
    {
        unset($this->varian[$index]);
        $this->varian = array_values($this->varian);
    }

    // --- MANAJEMEN SPESIFIKASI ---
    public function tambahBarisSpesifikasi()
    {
        $this->spesifikasi[] = ['judul' => '', 'nilai' => ''];
    }

    public function hapusBarisSpesifikasi($index)
    {
        unset($this->spesifikasi[$index]);
        $this->spesifikasi = array_values($this->spesifikasi);
    }

    // --- MANAJEMEN HARGA GROSIR ---
    public function tambahBarisGrosir()
    {
        $this->harga_grosir[] = ['min_qty' => 0, 'harga' => 0];
    }

    public function hapusBarisGrosir($index)
    {
        unset($this->harga_grosir[$index]);
        $this->harga_grosir = array_values($this->harga_grosir);
    }

    /**
     * Penghapusan massal unit terpilih.
     */
    public function bulkDelete()
    {
        $count = count($this->selectedProduk);
        if ($count > 0) {
            Produk::whereIn('id', $this->selectedProduk)->delete();
            LogHelper::catat('hapus_massal_produk', "{$count} Produk", "Admin menghapus {$count} produk sekaligus dari inventaris.");
            $this->reset(['selectedProduk', 'selectAll']);
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "{$count} unit berhasil dihapus."]);
        }
    }

    /**
     * Pengarsipan massal unit terpilih.
     */
    public function bulkArchive()
    {
        $count = count($this->selectedProduk);
        if ($count > 0) {
            Produk::whereIn('id', $this->selectedProduk)->update(['status' => 'arsip']);
            LogHelper::catat('arsip_massal_produk', "{$count} Produk", "Admin mengarsipkan {$count} produk sekaligus.");
            $this->reset(['selectedProduk', 'selectAll']);
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "{$count} unit berhasil diarsipkan."]);
        }
    }

    /**
     * Beralih ke mode tambah unit (Halaman Penuh).
     */
    public function tambahBaru()
    {
        $this->reset(['produk_id', 'kategori_id', 'merek_id', 'nama', 'kode_unit', 'harga_modal', 'harga_jual', 'stok', 'berat_gram', 'deskripsi_singkat', 'deskripsi_lengkap', 'gambar_baru', 'gambar_lama', 'varian', 'spesifikasi', 'harga_grosir']);
        $this->status = 'aktif';
        
        // Template default spesifikasi
        $this->spesifikasi = [
            ['judul' => 'Processor', 'nilai' => ''],
            ['judul' => 'RAM', 'nilai' => ''],
            ['judul' => 'Storage', 'nilai' => ''],
            ['judul' => 'Layar', 'nilai' => ''],
        ];
        
        $this->tampilkanForm = true;
    }

    /**
     * Beralih ke mode edit unit (Halaman Penuh).
     */
    public function edit($id)
    {
        $produk = Produk::with(['varian', 'spesifikasi'])->findOrFail($id);
        
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
        $this->gambar_lama = $produk->gambar_utama;
        
        // Load Relasi
        $this->varian = $produk->varian->map(function($v) {
            return [
                'id' => $v->id, // Track ID for update
                'nama' => $v->nama_varian,
                'sku' => $v->sku,
                'harga_tambahan' => $v->harga_tambahan,
                'stok' => $v->stok
            ];
        })->toArray();

        $this->spesifikasi = $produk->spesifikasi->map(function($s) {
            return ['judul' => $s->judul, 'nilai' => $s->nilai];
        })->toArray();

        $this->harga_grosir = $produk->harga_grosir ?? [];

        $this->tampilkanForm = true;
    }

    /**
     * Membatalkan operasi dan kembali ke katalog.
     */
    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset(['produk_id', 'gambar_baru']);
    }

    /**
     * Menyimpan data unit ke database (Transaksi Database Penuh).
     */
    public function simpan()
    {
        $this->validate([
            'nama' => 'required|min:5',
            'kategori_id' => 'required|exists:kategori,id',
            'merek_id' => 'required|exists:merek,id',
            'kode_unit' => 'required|unique:produk,kode_unit,' . $this->produk_id,
            'harga_modal' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'varian.*.nama' => 'required_with:varian|string',
            'spesifikasi.*.judul' => 'required_with:spesifikasi|string',
        ]);

        DB::beginTransaction();

        try {
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
                'harga_grosir' => $this->harga_grosir, // JSON cast di model
                'memiliki_varian' => count($this->varian) > 0,
            ];

            if ($this->gambar_baru) {
                $path = $this->gambar_baru->store('produk', 'public');
                $data['gambar_utama'] = '/storage/' . $path;
            }

            if ($this->produk_id) {
                $produk = Produk::findOrFail($this->produk_id);
                $stokLama = $produk->stok;
                $produk->update($data);

                // Update Varian (Hapus lama, buat baru - strategi simplifikasi untuk MVP Enterprise)
                // Idealnya: update existing ID, create new, delete missing.
                $produk->varian()->delete(); 
                $produk->spesifikasi()->delete();

                $pesan = "Data unit {$this->nama} berhasil diperbarui!";
            } else {
                $produk = Produk::create($data);
                $pesan = "Unit baru {$this->nama} berhasil didaftarkan!";
            }

            // Simpan Varian Baru
            foreach ($this->varian as $v) {
                if(!empty($v['nama'])) {
                    VarianProduk::create([
                        'produk_id' => $produk->id,
                        'nama_varian' => $v['nama'],
                        'sku' => $v['sku'] ?? ($produk->kode_unit . '-' . \Str::slug($v['nama'])),
                        'harga_tambahan' => $v['harga_tambahan'] ?? 0,
                        'stok' => $v['stok'] ?? 0
                    ]);
                }
            }

            // Simpan Spesifikasi Baru
            foreach ($this->spesifikasi as $s) {
                if(!empty($s['judul']) && !empty($s['nilai'])) {
                    SpesifikasiProduk::create([
                        'produk_id' => $produk->id,
                        'judul' => $s['judul'],
                        'nilai' => $s['nilai']
                    ]);
                }
            }

            if (!$this->produk_id && $this->stok > 0) {
                (new LayananStok)->tambahStok($produk, $this->stok, 'Input stok awal registrasi unit');
            }

            DB::commit();
            LogHelper::catat($this->produk_id ? 'ubah_produk' : 'buat_produk', $this->nama, "Data produk lengkap disimpan.");

            $this->tampilkanForm = false;
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
            $this->reset(['produk_id', 'gambar_baru', 'varian', 'spesifikasi', 'harga_grosir']);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }

    /**
     * Menghapus unit dari sistem.
     */
    public function hapus($id)
    {
        $produk = Produk::findOrFail($id);
        $nama = $produk->nama;
        $produk->delete();
        LogHelper::catat('hapus_produk', $nama, "Unit '{$nama}' telah dihapus dari inventaris sistem.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Unit {$nama} telah dihapus."]);
    }

    #[Title('Manajemen Inventaris - Teqara')]
    public function render()
    {
        $daftar_produk = Produk::query()
            ->with(['kategori', 'merek'])
            ->where('nama', 'like', '%'.$this->cari.'%')
            ->when($this->filter_kategori, fn ($q) => $q->where('kategori_id', $this->filter_kategori))
            ->latest('dibuat_pada')
            ->paginate(10);

        return view('livewire.pengelola.manajemen-produk.manajemen-produk', [
            'produk' => $daftar_produk,
            'kategori' => Kategori::all(),
            'merek' => Merek::all(),
        ])->layout('components.layouts.admin');
    }
}
