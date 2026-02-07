<?php

namespace App\Livewire\Pengelola\ManajemenApi;

use App\Helpers\LogHelper;
use App\Models\PengaturanSistem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;

class KonfigurasiEmail extends Component
{
    public $smtp_host;
    public $smtp_port;
    public $smtp_username;
    public $smtp_password;
    public $smtp_encryption = 'tls';
    public $mail_from_address;
    public $mail_from_name;

    public $test_email;

    public function mount()
    {
        $settings = PengaturanSistem::where('kunci', 'like', 'mail_%')->pluck('nilai', 'kunci');

        $this->smtp_host = $settings['mail_host'] ?? config('mail.mailers.smtp.host');
        $this->smtp_port = $settings['mail_port'] ?? config('mail.mailers.smtp.port');
        $this->smtp_username = $settings['mail_username'] ?? config('mail.mailers.smtp.username');
        $this->smtp_password = $settings['mail_password'] ?? config('mail.mailers.smtp.password');
        $this->smtp_encryption = $settings['mail_encryption'] ?? config('mail.mailers.smtp.encryption');
        $this->mail_from_address = $settings['mail_from_address'] ?? config('mail.from.address');
        $this->mail_from_name = $settings['mail_from_name'] ?? config('mail.from.name');
    }

    public function simpan()
    {
        $this->validate([
            'smtp_host' => 'required',
            'smtp_port' => 'required|numeric',
            'smtp_username' => 'required',
            'mail_from_address' => 'required|email',
        ]);

        $settings = [
            'mail_host' => $this->smtp_host,
            'mail_port' => $this->smtp_port,
            'mail_username' => $this->smtp_username,
            'mail_password' => $this->smtp_password,
            'mail_encryption' => $this->smtp_encryption,
            'mail_from_address' => $this->mail_from_address,
            'mail_from_name' => $this->mail_from_name,
        ];

        foreach ($settings as $key => $val) {
            PengaturanSistem::updateOrCreate(['kunci' => $key], ['nilai' => $val]);
        }

        LogHelper::catat('update_smtp', 'System', 'Konfigurasi SMTP diperbarui.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pengaturan SMTP berhasil disimpan.']);
    }

    public function kirimTestEmail()
    {
        $this->validate(['test_email' => 'required|email']);

        // Set config runtime
        Config::set('mail.mailers.smtp.host', $this->smtp_host);
        Config::set('mail.mailers.smtp.port', $this->smtp_port);
        Config::set('mail.mailers.smtp.username', $this->smtp_username);
        Config::set('mail.mailers.smtp.password', $this->smtp_password);
        Config::set('mail.mailers.smtp.encryption', $this->smtp_encryption);
        Config::set('mail.from.address', $this->mail_from_address);
        Config::set('mail.from.name', $this->mail_from_name);

        try {
            Mail::raw('Ini adalah email percobaan dari Teqara Enterprise System.', function ($message) {
                $message->to($this->test_email)
                    ->subject('Test Koneksi SMTP Teqara');
            });

            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Email percobaan berhasil dikirim!']);
        } catch (\Exception $e) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal kirim email: ' . $e->getMessage()]);
        }
    }

    #[Title('Konfigurasi Email SMTP - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-api.konfigurasi-email')
            ->layout('components.layouts.admin', ['header' => 'Server Email']);
    }
}
