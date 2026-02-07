<?php

namespace App\Livewire\Pengelola\ManajemenProduk\Pemasok;

use App\Models\LogAktivitas;
use App\Models\Pemasok;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPemasok extends Component
{
    use WithPagination;

    public $cari = '';
    public $filterStatus = '';

    // Form State
    public $pemasokId;
    public $kode_pemasok, $nama_perusahaan, $penanggung_jawab, $telepon, $email, $website, $npwp, $alamat, $catatan, $status = 'aktif';

    public function mount()
    {
        // Auto generate kode untuk form tambah
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['pemasokId', 'nama_perusahaan', 'penanggung_jawab', 'telepon', 'email', 'website', 'npwp', 'alamat', 'catatan', 'status']);
        $this->kode_pemasok = 'SUP-'.date('Y').'-'.strtoupper(bin2hex(random_bytes(2)));
    }

    public function tambahPemasok()
    {
        $this->resetForm();
        $this->dispatch('open-slide-over', id: 'form-pemasok');
    }

    public function edit($id)
    {
        $p = Pemasok::findOrFail($id);
        $this->pemasokId = $p->id;
        $this->kode_pemasok = $p->kode_pemasok;
        $this->nama_perusahaan = $p->nama_perusahaan;
        $this->penanggung_jawab = $p->penanggung_jawab;
        $this->telepon = $p->telepon;
        $this->email = $p->email;
        $this->website = $p->website;
        $this->npwp = $p->npwp;
        $this->alamat = $p->alamat;
        $this->catatan = $p->catatan;
        $this->status = $p->status;

        $this->dispatch('open-slide-over', id: 'form-pemasok');
    }

    public function simpan()
    {
        $this->validate([
            'nama_perusahaan' => 'required|min:3',
            'kode_pemasok' => 'required|unique:pemasok,kode_pemasok,'.$this->pemasokId,
            'email' => 'nullable|email',
            'telepon' => 'required',
        ]);

        $data = [
            'kode_pemasok' => $this->kode_pemasok,
            'nama_perusahaan' => $this->nama_perusahaan,
            'penanggung_jawab' => $this->penanggung_jawab,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'website' => $this->website,
            'npwp' => $this->npwp,
            'alamat' => $this->alamat,
            'catatan' => $this->catatan,
            'status' => $this->status,
        ];

        if ($this->pemasokId) {
            Pemasok::find($this->pemasokId)->update($data);
            $pesan = 'Data pemasok diperbarui.';
        } else {
            Pemasok::create($data);
            $pesan = 'Pemasok baru berhasil didaftarkan.';
        }

        LogAktivitas::create([
            'pengguna_id' => auth()->id(),
            'aksi' => $this->pemasokId ? 'update_pemasok' : 'buat_pemasok',
            'target' => $this->nama_perusahaan,
            'pesan_naratif' => "Admin mengelola data vendor: {$this->nama_perusahaan}",
            'waktu' => now(),
        ]);

        $this->dispatch('close-slide-over', id: 'form-pemasok');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        $this->resetForm();
    }

    #[Title('Manajemen Vendor & Pemasok - Teqara Admin')]
    public function render()
    {
        $pemasok = Pemasok::query()
            ->when($this->cari, fn($q) => $q->where('nama_perusahaan', 'like', '%'.$this->cari.'%'))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->latest('dibuat_pada')
            ->paginate(10);

        return view('livewire.pengelola.manajemen-produk.pemasok.daftar-pemasok', [
            'pemasok' => $pemasok
        ])->layout('components.layouts.admin');
    }
}
