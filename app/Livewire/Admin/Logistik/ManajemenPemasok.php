<?php

namespace App\Livewire\Admin\Logistik;

use App\Models\Pemasok;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class ManajemenPemasok extends Component
{
    use WithPagination;

    public $cari = '';
    
    // Form State
    public $pemasokId;
    public $nama_perusahaan, $penanggung_jawab, $telepon, $email, $alamat, $status = 'aktif';

    protected $rules = [
        'nama_perusahaan' => 'required|min:3',
        'penanggung_jawab' => 'required',
        'telepon' => 'required|numeric',
        'email' => 'nullable|email',
        'alamat' => 'required',
        'status' => 'required'
    ];

    public function tambah()
    {
        $this->reset(['pemasokId', 'nama_perusahaan', 'penanggung_jawab', 'telepon', 'email', 'alamat', 'status']);
        $this->dispatch('open-slide-over', id: 'form-pemasok');
    }

    public function edit($id)
    {
        $p = Pemasok::findOrFail($id);
        $this->pemasokId = $id;
        $this->nama_perusahaan = $p->nama_perusahaan;
        $this->penanggung_jawab = $p->penanggung_jawab;
        $this->telepon = $p->telepon;
        $this->email = $p->email;
        $this->alamat = $p->alamat;
        $this->status = $p->status;
        
        $this->dispatch('open-slide-over', id: 'form-pemasok');
    }

    public function simpan()
    {
        $this->validate();

        $data = [
            'nama_perusahaan' => $this->nama_perusahaan,
            'penanggung_jawab' => $this->penanggung_jawab,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'status' => $this->status,
        ];

        if ($this->pemasokId) {
            Pemasok::find($this->pemasokId)->update($data);
            $msg = 'Data pemasok diperbarui.';
        } else {
            $data['kode_pemasok'] = 'SUP-' . mt_rand(1000, 9999);
            Pemasok::create($data);
            $msg = 'Pemasok baru ditambahkan.';
        }

        $this->dispatch('close-slide-over', id: 'form-pemasok');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $msg]);
    }

    #[Title('Manajemen Pemasok - Teqara')]
    public function render()
    {
        $pemasok = Pemasok::where('nama_perusahaan', 'like', '%' . $this->cari . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.logistik.manajemen-pemasok', [
            'pemasok' => $pemasok
        ])->layout('components.layouts.admin');
    }
}
