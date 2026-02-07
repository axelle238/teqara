<?php

namespace App\Livewire\Pengelola\PengaturanSistem;

use App\Models\Voucher;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use App\Helpers\LogHelper;

/**
 * Class ManajemenVoucher
 * Tujuan: Pengelolaan kampanye kode promo dan voucher diskon sistem (Marketing Campaign).
 * Arsitektur: 100% Full Page SPA (Tanpa Slide Over/Modal).
 */
class ManajemenVoucher extends Component
{
    use WithPagination;

    // State Antarmuka
    public $tampilkanForm = false;

    // Properti Model
    public $voucherId;
    public $kode;
    public $deskripsi;
    public $tipe_diskon = 'persen';
    public $nilai_diskon;
    public $min_pembelian = 0;
    public $maks_potongan;
    public $kuota = 100;
    public $berlaku_mulai;
    public $berlaku_sampai;

    // Filter
    public $cari = '';

    protected $rules = [
        'kode' => 'required|unique:voucher,kode',
        'nilai_diskon' => 'required|numeric|min:1',
        'kuota' => 'required|integer|min:1',
    ];

    protected $messages = [
        'kode.required' => 'Kode voucher unik wajib diisi.',
        'kode.unique' => 'Kode promo ini sudah digunakan sebelumnya.',
        'nilai_diskon.min' => 'Nilai diskon minimal harus 1.',
        'kuota.min' => 'Kuota minimal rilis adalah 1 voucher.',
    ];

    /**
     * Generate kode promo unik secara otomatis.
     */
    public function generateCode()
    {
        $this->kode = 'TEQ-'.strtoupper(Str::random(6));
    }

    /**
     * Beralih ke mode peluncuran kampanye baru (Halaman Penuh).
     */
    public function tambahBaru()
    {
        $this->reset(['voucherId', 'kode', 'deskripsi', 'tipe_diskon', 'nilai_diskon', 'min_pembelian', 'maks_potongan', 'kuota', 'berlaku_mulai', 'berlaku_sampai']);
        $this->berlaku_mulai = now()->format('Y-m-d\TH:i');
        $this->berlaku_sampai = now()->addMonth()->format('Y-m-d\TH:i');
        $this->tampilkanForm = true;
    }

    /**
     * Beralih ke mode sunting kampanye (Halaman Penuh).
     */
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

        $this->tampilkanForm = true;
    }

    /**
     * Membatalkan operasi dan kembali ke daftar voucher.
     */
    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset(['voucherId']);
    }

    /**
     * Menyimpan data kampanye ke database.
     */
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
            $pesan = "Kampanye Promo {$this->kode} berhasil diperbarui.";
        } else {
            Voucher::create($data);
            $aksi = 'buat_voucher';
            $pesan = "Kampanye Promo {$this->kode} resmi diluncurkan.";
        }

        LogHelper::catat($aksi, $this->kode, $pesan);
        $this->tampilkanForm = false;
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

    /**
     * Menghentikan kampanye promo.
     */
    public function hapus($id)
    {
        $voucher = Voucher::findOrFail($id);
        $kode = $voucher->kode;
        $voucher->delete();

        LogHelper::catat('hapus_voucher', $kode, "Admin menghentikan kampanye promo: {$kode}");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Kampanye berhasil dihentikan.']);
    }

    #[Title('Manajemen Voucher & Promo - Teqara')]
    public function render()
    {
        return view('livewire.pengelola.pengaturan-sistem.manajemen-voucher', [
            'vouchers' => Voucher::where('kode', 'like', '%'.$this->cari.'%')->latest('dibuat_pada')->paginate(10),
        ])->layout('components.layouts.admin');
    }
}
