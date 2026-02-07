<?php

namespace App\Livewire\Pengelola\PengaturanSistem;

use App\Models\Voucher;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class ManajemenVoucher extends Component
{
    use WithPagination;

    public $modeForm = false;
    public $idEdit = null;

    // Form Fields
    public $kode, $tipe = 'persentase', $nominal = 0, $min_belanja = 0;
    public $kuota = 100, $berlaku_sampai;
    
    protected $rules = [
        'kode' => 'required|unique:voucher,kode',
        'tipe' => 'required|in:tetap,persentase',
        'nominal' => 'required|numeric|min:0',
        'min_belanja' => 'required|numeric|min:0',
        'kuota' => 'required|integer|min:1',
        'berlaku_sampai' => 'required|date|after:today',
    ];

    public function tambahBaru()
    {
        $this->reset();
        $this->modeForm = true;
        $this->kode = strtoupper(Str::random(8));
    }

    public function edit($id)
    {
        $v = Voucher::findOrFail($id);
        $this->idEdit = $id;
        $this->kode = $v->kode;
        $this->tipe = $v->tipe;
        $this->nominal = $v->nominal;
        $this->min_belanja = $v->min_belanja;
        $this->kuota = $v->kuota;
        $this->berlaku_sampai = $v->berlaku_sampai->format('Y-m-d');
        $this->modeForm = true;
    }

    public function simpan()
    {
        if ($this->idEdit) {
            $this->validate([
                'kode' => 'required|unique:voucher,kode,' . $this->idEdit,
                'berlaku_sampai' => 'required|date',
            ]);
            
            Voucher::find($this->idEdit)->update([
                'kode' => strtoupper($this->kode),
                'tipe' => $this->tipe,
                'nominal' => $this->nominal,
                'min_belanja' => $this->min_belanja,
                'kuota' => $this->kuota,
                'berlaku_sampai' => $this->berlaku_sampai,
            ]);
        } else {
            $this->validate();
            
            Voucher::create([
                'kode' => strtoupper($this->kode),
                'tipe' => $this->tipe,
                'nominal' => $this->nominal,
                'min_belanja' => $this->min_belanja,
                'kuota' => $this->kuota,
                'berlaku_sampai' => $this->berlaku_sampai,
            ]);
        }
        
        $this->reset();
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Voucher promo berhasil disimpan.']);
    }

    public function hapus($id)
    {
        Voucher::destroy($id);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Voucher berhasil dihapus.']);
    }

    public function render()
    {
        return view('livewire.pengelola.pengaturan-sistem.manajemen-voucher', [
            'voucher' => Voucher::latest()->paginate(10)
        ])->layout('components.layouts.admin', ['header' => 'Promo & Voucher']);
    }
}