<?php

namespace App\Livewire\Admin\Voucher;

use Livewire\Component;
use App\Models\Voucher;
use App\Models\LogAktivitas;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class DaftarVoucher extends Component
{
    use WithPagination;

    public $kode, $deskripsi, $tipe_diskon = 'persen', $nilai_diskon;
    public $min_pembelian = 0, $maks_potongan, $kuota = 100;
    public $berlaku_mulai, $berlaku_sampai;
    
    public $voucherId, $modeEdit = false;

    protected $rules = [
        'kode' => 'required|unique:voucher,kode',
        'tipe_diskon' => 'required|in:persen,nominal',
        'nilai_diskon' => 'required|numeric',
        'kuota' => 'required|integer|min:1',
        'berlaku_mulai' => 'required|date',
        'berlaku_sampai' => 'required|date|after:berlaku_mulai',
    ];

    public function simpan()
    {
        $this->validate();

        Voucher::create([
            'kode' => strtoupper($this->kode),
            'deskripsi' => $this->deskripsi,
            'tipe_diskon' => $this->tipe_diskon,
            'nilai_diskon' => $this->nilai_diskon,
            'min_pembelian' => $this->min_pembelian,
            'maks_potongan' => $this->maks_potongan,
            'kuota' => $this->kuota,
            'berlaku_mulai' => $this->berlaku_mulai,
            'berlaku_sampai' => $this->berlaku_sampai,
        ]);

        LogAktivitas::create([
            'pengguna_id' => auth()->id(),
            'aksi' => 'tambah_voucher',
            'target' => $this->kode,
            'pesan_naratif' => "Admin membuat voucher baru: " . strtoupper($this->kode),
            'waktu' => now()
        ]);

        $this->reset();
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Voucher berhasil dibuat.']);
    }

    public function hapus($id)
    {
        $voucher = Voucher::findOrFail($id);
        $kode = $voucher->kode;
        $voucher->delete();

        LogAktivitas::create([
            'pengguna_id' => auth()->id(),
            'aksi' => 'hapus_voucher',
            'target' => $kode,
            'pesan_naratif' => "Admin menghapus voucher: " . $kode,
            'waktu' => now()
        ]);

        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Voucher dihapus.']);
    }

    #[Title('Manajemen Voucher - Admin')]
    public function render()
    {
        return view('livewire.admin.voucher.daftar-voucher', [
            'vouchers' => Voucher::latest()->paginate(10)
        ])->layout('components.layouts.admin');
    }
}
