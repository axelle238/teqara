<?php

namespace App\Livewire\Pengelola\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\Produk;
use App\Models\ProdukSeri;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ManajemenSeri
 * Tujuan: Otoritas pelacakan identitas unit (IMEI/Serial Number) untuk akurasi inventaris tinggi.
 * Arsitektur: 100% Full Page SPA (Tanpa Slide Over/Modal).
 */
class ManajemenSeri extends Component
{
    use WithPagination;

    // State Halaman
    public $tampilkanForm = false;

    // Filter State
    public $cari = '';
    public $filterStatus = ''; // tersedia, terjual, rusak, retur
    public $filterProduk = '';

    // Form State
    public $produkTerpilihId;
    public $inputSeriMassal; // Untuk input banyak seri sekaligus

    public function updated($property)
    {
        if (in_array($property, ['cari', 'filterStatus', 'filterProduk'])) {
            $this->resetPage();
        }
    }

    /**
     * Buka form registrasi seri (Halaman Penuh).
     */
    public function bukaPanelRegistrasi($produkId = null)
    {
        $this->produkTerpilihId = $produkId;
        $this->tampilkanForm = true;
    }

    /**
     * Kembali ke daftar seri.
     */
    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset(['produkTerpilihId', 'inputSeriMassal']);
    }

    public function registrasiSeri()
    {
        $this->validate([
            'produkTerpilihId' => 'required|exists:produk,id',
            'inputSeriMassal' => 'required',
        ], [
            'produkTerpilihId.required' => 'Pilih unit produk terlebih dahulu.',
            'inputSeriMassal.required' => 'Masukkan setidaknya satu nomor seri.',
        ]);

        $daftarSeri = preg_split('/[
,]+/', $this->inputSeriMassal);
        $daftarSeri = array_map('trim', $daftarSeri);
        $daftarSeri = array_filter($daftarSeri);

        $produk = Produk::find($this->produkTerpilihId);
        $berhasil = 0;
        $gagal = 0;

        foreach ($daftarSeri as $seri) {
            try {
                ProdukSeri::create([
                    'produk_id' => $produk->id,
                    'nomor_seri' => $seri,
                    'status' => 'tersedia',
                ]);
                $berhasil++;
            } catch (\Exception $e) {
                $gagal++;
            }
        }

        // Sinkronisasi stok fisik produk secara otomatis
        $produk->increment('stok', $berhasil);

        LogHelper::catat(
            'registrasi_seri',
            $produk->nama,
            "Admin meregistrasi {$berhasil} nomor seri baru untuk unit {$produk->nama}. (Gagal: {$gagal})"
        );

        $this->tampilkanForm = false;
        $this->reset(['inputSeriMassal', 'produkTerpilihId']);
        $this->dispatch('notifikasi', [
            'tipe' => 'sukses', 
            'pesan' => "Otorisasi berhasil: {$berhasil} unit terdaftar. Database stok disinkronkan."
        ]);
    }

    public function ubahStatus($id, $statusBaru)
    {
        $seri = ProdukSeri::findOrFail($id);
        $statusLama = $seri->status;
        $seri->update(['status' => $statusBaru]);

        // Logic stok: Jika berubah dari/ke 'tersedia', update stok fisik produk
        if ($statusLama !== 'tersedia' && $statusBaru === 'tersedia') {
            $seri->produk->increment('stok');
        } elseif ($statusLama === 'tersedia' && $statusBaru !== 'tersedia') {
            $seri->produk->decrement('stok');
        }

        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => "Status seri #{$seri->nomor_seri} diperbarui."]);
    }

    public function hapus($id)
    {
        $seri = ProdukSeri::findOrFail($id);
        if ($seri->status === 'tersedia') {
            $seri->produk->decrement('stok');
        }
        $seri->delete();
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Data seri dihapus dari database.']);
    }

    #[Title('IMEI & Serial Number Hub - Teqara Admin')]
    public function render()
    {
        $query = ProdukSeri::query()
            ->with(['produk.kategori'])
            ->when($this->cari, fn($q) => $q->where('nomor_seri', 'like', '%'.$this->cari.'%'))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterProduk, fn($q) => $q->where('produk_id', $this->filterProduk))
            ->latest();

        // Statistik Dashboard
        $statistik = [
            'total' => ProdukSeri::count(),
            'tersedia' => ProdukSeri::where('status', 'tersedia')->count(),
            'terjual' => ProdukSeri::where('status', 'terjual')->count(),
            'masalah' => ProdukSeri::whereIn('status', ['rusak', 'retur'])->count(),
        ];

        return view('livewire.pengelola.manajemen-produk.manajemen-seri', [
            'daftarSeri' => $query->paginate(15),
            'semuaProduk' => Produk::orderBy('nama')->get(),
            'statistik' => $statistik,
        ])->layout('components.layouts.admin');
    }
}
