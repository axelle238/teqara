<?php

namespace App\Livewire\Pengelola\ManajemenApi;

use App\Models\KunciApi;
use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class DaftarKunciApi extends Component
{
    use WithPagination;

    public $tampilkanForm = false;
    public $cari = '';

    // Form fields
    public $kunciId;
    public $pengguna_id;
    public $nama_token;
    public $status = 'aktif';
    public $hak_akses = []; // e.g. ['produk', 'pesanan', 'pelanggan']

    public $tokenBaru; // Tampilkan sekali setelah dibuat

    public function tambahBaru()
    {
        $this->reset(['kunciId', 'pengguna_id', 'nama_token', 'status', 'hak_akses', 'tokenBaru']);
        $this->tampilkanForm = true;
    }

    public function edit($id)
    {
        $kunci = KunciApi::findOrFail($id);
        $this->kunciId = $kunci->id;
        $this->pengguna_id = $kunci->pengguna_id;
        $this->nama_token = $kunci->nama_token;
        $this->status = $kunci->status;
        $this->hak_akses = $kunci->hak_akses ?? [];
        $this->tampilkanForm = true;
    }

    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset(['kunciId', 'tokenBaru']);
    }

    public function simpan()
    {
        $this->validate([
            'pengguna_id' => 'required|exists:pengguna,id',
            'nama_token' => 'required|min:3',
            'status' => 'required',
        ]);

        if ($this->kunciId) {
            $kunci = KunciApi::findOrFail($this->kunciId);
            $kunci->update([
                'pengguna_id' => $this->pengguna_id,
                'nama_token' => $this->nama_token,
                'status' => $this->status,
                'hak_akses' => $this->hak_akses,
            ]);
            $pesan = 'Kunci API diperbarui.';
        } else {
            $rawToken = Str::random(40);
            $kunci = KunciApi::create([
                'pengguna_id' => $this->pengguna_id,
                'nama_token' => $this->nama_token,
                'token' => hash('sha256', $rawToken),
                'status' => $this->status,
                'hak_akses' => $this->hak_akses,
            ]);
            $this->tokenBaru = $rawToken;
            $pesan = 'Kunci API baru berhasil dibuat.';
        }

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        if (!$this->tokenBaru) {
            $this->tampilkanForm = false;
        }
    }

    public function hapus($id)
    {
        KunciApi::destroy($id);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Kunci API dicabut.']);
    }

    #[Title('Manajemen Kunci API - Teqara Admin')]
    public function render()
    {
        $kunciApis = KunciApi::with('pengguna')
            ->where('nama_token', 'like', '%' . $this->cari . '%')
            ->latest('dibuat_pada')
            ->paginate(10);

        return view('livewire.pengelola.manajemen-api.daftar-kunci-api', [
            'kunciApis' => $kunciApis,
            'daftarPengguna' => Pengguna::whereIn('peran', ['admin', 'pelanggan'])->get()
        ])->layout('components.layouts.admin', ['header' => 'Integrasi API']);
    }
}
