<?php

namespace App\Livewire\Pengelola;

use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Models\Pengguna;
use App\Models\Pesanan;
use App\Models\Produk;
use Livewire\Component;

class PencarianAdmin extends Component
{
    public $kueri = '';
    public $hasil = [];

    public function updatedKueri()
    {
        if (strlen($this->kueri) < 3) {
            $this->hasil = [];
            return;
        }

        $this->hasil = [
            'produk' => Produk::where('nama', 'like', '%' . $this->kueri . '%')
                ->orWhere('kode_unit', 'like', '%' . $this->kueri . '%')
                ->take(3)->get(),
            'pesanan' => Pesanan::where('nomor_faktur', 'like', '%' . $this->kueri . '%')
                ->take(3)->get(),
            'pelanggan' => Pengguna::where('peran', 'pelanggan')
                ->where(function($q) {
                    $q->where('nama', 'like', '%' . $this->kueri . '%')
                      ->orWhere('email', 'like', '%' . $this->kueri . '%');
                })
                ->take(3)->get(),
            'vendor' => Pemasok::where('nama_perusahaan', 'like', '%' . $this->kueri . '%')
                ->take(3)->get(),
        ];
    }

    public function render()
    {
        return view('livewire.pengelola.pencarian-admin');
    }
}
