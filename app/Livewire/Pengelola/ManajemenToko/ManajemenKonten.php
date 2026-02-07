<?php

namespace App\Livewire\Pengelola\ManajemenToko;

use App\Helpers\LogHelper;
use App\Models\KontenHalaman;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Class ManajemenKonten
 * Tujuan: Editor CMS Enterprise untuk mengelola seluruh aspek visual halaman depan.
 * Fitur: Tabulasi per bagian, upload gambar dinamis, reordering, dan toggle status.
 */
class ManajemenKonten extends Component
{
    use WithFileUploads;

    // State Tampilan
    public $tampilkanForm = false;
    public $filterBagian = 'hero_section'; // Default tab

    // Properti Model (Form)
    public $kontenId;
    public $judul;
    public $bagian = 'hero_section'; 
    public $deskripsi;
    public $teks_tombol;
    public $tautan_tujuan;
    public $urutan = 0;
    public $aktif = 1;
    
    // Upload Gambar
    public $gambar;       // File upload temporary
    public $gambar_lama;  // Path string dari DB

    /**
     * Berpindah tab filter bagian.
     */
    public function gantiTab($bagian)
    {
        $this->filterBagian = $bagian;
        $this->tampilkanForm = false;
    }

    /**
     * Membuka form tambah baru.
     */
    public function tambahBaru()
    {
        $this->resetForm();
        $this->bagian = $this->filterBagian; // Auto-set bagian sesuai tab aktif
        $this->urutan = KontenHalaman::where('bagian', $this->filterBagian)->max('urutan') + 1;
        $this->tampilkanForm = true;
    }

    /**
     * Membuka form edit.
     */
    public function edit($id)
    {
        $konten = KontenHalaman::findOrFail($id);
        
        $this->kontenId = $konten->id;
        $this->judul = $konten->judul;
        $this->bagian = $konten->bagian;
        $this->deskripsi = $konten->deskripsi;
        $this->teks_tombol = $konten->teks_tombol;
        $this->tautan_tujuan = $konten->tautan_tujuan;
        $this->urutan = $konten->urutan;
        $this->aktif = $konten->aktif;
        $this->gambar_lama = $konten->gambar;
        
        $this->tampilkanForm = true;
    }

    /**
     * Membatalkan input.
     */
    public function batal()
    {
        $this->tampilkanForm = false;
        $this->resetForm();
    }

    /**
     * Menyimpan data (Create/Update).
     */
    public function simpan()
    {
        $this->validate([
            'judul' => 'required|min:3|max:255',
            'bagian' => 'required|in:hero_section,promo_banner,fitur_unggulan',
            'gambar' => 'nullable', // Bisa image file atau string icon class jika fitur_unggulan
            'urutan' => 'integer|min:0',
            'tautan_tujuan' => 'nullable|url',
        ], [
            'judul.required' => 'Judul konten wajib diisi.',
            'bagian.required' => 'Lokasi penempatan wajib dipilih.',
            'tautan_tujuan.url' => 'Format tautan tidak valid (harus https://...).'
        ]);

        // Handle Upload Gambar
        $pathGambar = $this->gambar_lama;
        
        // Khusus Fitur Unggulan, jika input gambar bukan file tapi string (icon), simpan langsung
        if ($this->bagian == 'fitur_unggulan' && is_string($this->gambar) && !empty($this->gambar)) {
             // Logic khusus jika ingin support input text icon, tapi sementara kita fokus file upload standar
        }

        if ($this->gambar instanceof \Illuminate\Http\UploadedFile) {
            // Hapus gambar lama jika ada dan bukan dummy
            if ($this->gambar_lama && Storage::disk('public')->exists(str_replace('/storage/', '', $this->gambar_lama))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $this->gambar_lama));
            }
            // Simpan gambar baru
            $path = $this->gambar->store('konten-toko', 'public');
            $pathGambar = 'storage/' . $path; // Simpan path relatif untuk kemudahan akses
        }

        $data = [
            'judul' => $this->judul,
            'bagian' => $this->bagian,
            'deskripsi' => $this->deskripsi,
            'teks_tombol' => $this->teks_tombol,
            'tautan_tujuan' => $this->tautan_tujuan,
            'urutan' => $this->urutan,
            'aktif' => $this->aktif,
            'gambar' => $pathGambar,
        ];

        if ($this->kontenId) {
            KontenHalaman::find($this->kontenId)->update($data);
            $pesan = 'Konten visual berhasil diperbarui.';
            LogHelper::catat('update_konten', $this->judul, "Memperbarui elemen visual bagian {$this->bagian}.");
        } else {
            KontenHalaman::create($data);
            $pesan = 'Konten visual baru berhasil ditambahkan.';
            LogHelper::catat('buat_konten', $this->judul, "Menambahkan elemen visual baru di {$this->bagian}.");
        }

        Cache::forget('konten_halaman_all');

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        $this->tampilkanForm = false;
        $this->resetForm();
    }

    /**
     * Mengubah status aktif/nonaktif secara instan.
     */
    public function toggleStatus($id)
    {
        $konten = KontenHalaman::findOrFail($id);
        $konten->aktif = !$konten->aktif;
        $konten->save();

        Cache::forget('konten_halaman_all');

        $status = $konten->aktif ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => "Konten '{$konten->judul}' berhasil {$status}."]);
    }

    /**
     * Menghapus konten permanen.
     */
    public function hapus($id)
    {
        $konten = KontenHalaman::findOrFail($id);
        
        // Hapus file fisik
        if ($konten->gambar && Storage::disk('public')->exists(str_replace('/storage/', '', $konten->gambar))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $konten->gambar));
        }

        $judul = $konten->judul;
        $konten->delete();

        Cache::forget('konten_halaman_all');

        LogHelper::catat('hapus_konten', $judul, "Menghapus elemen visual permanen.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Konten berhasil dihapus.']);
    }

    private function resetForm()
    {
        $this->reset(['kontenId', 'judul', 'deskripsi', 'teks_tombol', 'tautan_tujuan', 'urutan', 'aktif', 'gambar', 'gambar_lama']);
        $this->bagian = $this->filterBagian;
    }

    #[Title('Editor Visual Toko - Teqara Enterprise')]
    public function render()
    {
        $dataKonten = KontenHalaman::where('bagian', $this->filterBagian)
            ->orderBy('urutan', 'asc')
            ->orderBy('diperbarui_pada', 'desc')
            ->get();

        return view('livewire.pengelola.manajemen-toko.manajemen-konten', [
            'daftar_konten' => $dataKonten
        ])->layout('components.layouts.admin');
    }
}
