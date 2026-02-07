<?php

namespace App\Livewire\Pengelola\ManajemenApi;

use App\Services\LayananIntegrasi;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Pusat Kendali Integrasi API
 * 
 * Monitoring real-time status koneksi ke Midtrans, RajaOngkir, dan WhatsApp.
 */
class PusatIntegrasi extends Component
{
    public $statusIntegrasi = [];

    public function mount(LayananIntegrasi $layanan)
    {
        $this->segarkanStatus($layanan);
    }

    public function segarkanStatus(LayananIntegrasi $layanan)
    {
        $this->statusIntegrasi = [
            'pembayaran' => $layanan->cekStatus('midtrans'),
            'logistik' => $layanan->cekStatus('rajaongkir'),
            'whatsapp' => $layanan->cekStatus('fonnte'),
            'email' => $layanan->cekStatus('mailgun'),
        ];
    }

    #[Title('Pusat Integrasi API - Teqara Enterprise')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-api.pusat-integrasi')
            ->layout('components.layouts.admin', ['header' => 'Integrasi API']);
    }
}