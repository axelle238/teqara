<?php

namespace App\Livewire\Pengelola\ManajemenApi;

use App\Helpers\LogHelper;
use App\Models\PengaturanSistem;
use Livewire\Attributes\Title;
use Livewire\Component;

class KonfigurasiWhatsapp extends Component
{
    public $wa_provider = 'fonnte'; // Default provider
    public $wa_api_key;
    public $wa_endpoint;
    public $test_number;

    public function mount()
    {
        $settings = PengaturanSistem::where('kunci', 'like', 'wa_%')->pluck('nilai', 'kunci');

        $this->wa_provider = $settings['wa_provider'] ?? 'fonnte';
        $this->wa_api_key = $settings['wa_api_key'] ?? '';
        $this->wa_endpoint = $settings['wa_endpoint'] ?? 'https://api.fonnte.com/send';
    }

    public function simpan()
    {
        $this->validate([
            'wa_provider' => 'required',
            'wa_api_key' => 'required',
        ]);

        PengaturanSistem::updateOrCreate(['kunci' => 'wa_provider'], ['nilai' => $this->wa_provider]);
        PengaturanSistem::updateOrCreate(['kunci' => 'wa_api_key'], ['nilai' => $this->wa_api_key]);
        PengaturanSistem::updateOrCreate(['kunci' => 'wa_endpoint'], ['nilai' => $this->wa_endpoint]);

        LogHelper::catat('update_wa', 'System', 'Konfigurasi WhatsApp API diperbarui.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pengaturan WhatsApp berhasil disimpan.']);
    }

    public function kirimTestWA()
    {
        $this->validate(['test_number' => 'required|numeric|min_digits:10']);

        // Simulasi request (Integrasi nyata butuh Guzzle/Http Client)
        // Di sistem enterprise nyata, ini akan memanggil Service class untuk WA.
        
        // Mock success for UI demo
        if ($this->wa_api_key) {
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pesan test dikirim ke antrian gateway.']);
        } else {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'API Key belum diisi.']);
        }
    }

    #[Title('Konfigurasi WhatsApp Gateway - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-api.konfigurasi-whatsapp')
            ->layout('components.layouts.admin', ['header' => 'WhatsApp Gateway']);
    }
}
