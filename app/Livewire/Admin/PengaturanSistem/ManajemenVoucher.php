<?php

namespace App\Livewire\Admin\PengaturanSistem;

use App\Models\Voucher;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ManajemenVoucher
 * Tujuan: Pengelolaan kode promo dan voucher diskon sistem.
 */
class ManajemenVoucher extends Component
{
    use WithPagination;

    public $kode;

    public $deskripsi;

    public $tipe_diskon = 'persen';

    public $nilai_diskon;

    public $min_pembelian = 0;

    public $maks_potongan;

    public $kuota = 100;

    public $berlaku_mulai;

    public $berlaku_sampai;

    public $cari = '';

    public function generateCode()
    {
        $this->kode = 'TEQ-'.strtoupper(\Illuminate\Support\Str::random(6));
    }

    public function tambahBaru()
    {
        $this->reset(['voucherId', 'kode', 'deskripsi', 'tipe_diskon', 'nilai_diskon', 'min_pembelian', 'maks_potongan', 'kuota', 'berlaku_mulai', 'berlaku_sampai']);
        $this->berlaku_mulai = now()->format('Y-m-d\TH:i');
        $this->berlaku_sampai = now()->addMonth()->format('Y-m-d\TH:i');
        $this->dispatch('open-slide-over', id: 'form-voucher');
    }

    public function edit($id)
    {
        $v = Voucher::findOrFail($id);
        $this->voucherId = $v->id;
        $this->kode = $v->kode;
        $this->deskripsi = $v->deskripsi;
        $this->tipe_diskon = $v->tipe_diskon;
        $this->nilai_diskon = $v->nilai_diskon;
        $this->min_pembelian = $v->min_pembelian;
        $this->maks_potongan = $v->maks_potongan;
        $this->kuota = $v->kuota;
        $this->berlaku_mulai = $v->berlaku_mulai ? \Carbon\Carbon::parse($v->berlaku_mulai)->format('Y-m-d\TH:i') : null;
        $this->berlaku_sampai = $v->berlaku_sampai ? \Carbon\Carbon::parse($v->berlaku_sampai)->format('Y-m-d\TH:i') : null;

        $this->dispatch('open-slide-over', id: 'form-voucher');
    }

    public function simpan()
    {
        $rules = $this->rules;
        if ($this->voucherId) {
            $rules['kode'] = 'required|unique:voucher,kode,'.$this->voucherId;
        }
        $this->validate($rules);

        $data = [
            'kode' => strtoupper($this->kode),
            'deskripsi' => $this->deskripsi,
            'tipe_diskon' => $this->tipe_diskon,
            'nilai_diskon' => $this->nilai_diskon,
            'min_pembelian' => $this->min_pembelian,
            'maks_potongan' => $this->maks_potongan,
            'kuota' => $this->kuota,
            'berlaku_mulai' => $this->berlaku_mulai,
            'berlaku_sampai' => $this->berlaku_sampai,
        ];

        if ($this->voucherId) {
            Voucher::find($this->voucherId)->update($data);
            $aksi = 'update_voucher';
            $pesan = "Voucher {$this->kode} diperbarui.";
        } else {
            Voucher::create($data);
            $aksi = 'buat_voucher';
            $pesan = "Voucher baru {$this->kode} dibuat.";
        }

        \App\Helpers\LogHelper::catat($aksi, $this->kode, $pesan);
        $this->dispatch('close-slide-over', id: 'form-voucher');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

    public function hapus($id)
    {
        $voucher = Voucher::findOrFail($id);
        $kode = $voucher->kode;
        $voucher->delete();

        \App\Helpers\LogHelper::catat('hapus_voucher', $kode, "Admin menghapus voucher: {$kode}");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Voucher dihapus.']);
    }

    #[Title('Manajemen Voucher - Admin')]
    public function render()
    {
        return view('livewire.admin.pengaturan-sistem.manajemen-voucher', [
            'vouchers' => Voucher::where('kode', 'like', '%'.$this->cari.'%')->latest()->paginate(10),
        ])->layout('components.layouts.admin');
    }
}
