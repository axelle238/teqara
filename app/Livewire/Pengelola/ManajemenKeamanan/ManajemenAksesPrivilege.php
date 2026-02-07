<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenAksesPrivilege extends Component
{
    use WithPagination;

    public $requests = [
        ['id' => 'REQ-001', 'user' => 'Developer A', 'role' => 'Super Admin', 'duration' => '2 Hours', 'reason' => 'Database Maintenance', 'status' => 'pending'],
        ['id' => 'REQ-002', 'user' => 'Support Lead', 'role' => 'User Manager', 'duration' => '4 Hours', 'reason' => 'Audit User Accounts', 'status' => 'approved'],
    ];

    public $secrets = [
        ['name' => 'Stripe API Key', 'type' => 'API Key', 'last_accessed' => '2023-10-25 10:30:00', 'accessed_by' => 'System'],
        ['name' => 'Database Root Password', 'type' => 'Password', 'last_accessed' => '2023-10-24 14:15:00', 'accessed_by' => 'Admin'],
    ];

    public function approveRequest($id)
    {
        $this->requests = array_map(function ($req) use ($id) {
            if ($req['id'] === $id) {
                $req['status'] = 'approved';
            }
            return $req;
        }, $this->requests);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Permintaan akses {$id} disetujui."]);
    }

    public function rejectRequest($id)
    {
        $this->requests = array_map(function ($req) use ($id) {
            if ($req['id'] === $id) {
                $req['status'] = 'rejected';
            }
            return $req;
        }, $this->requests);

        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => "Permintaan akses {$id} ditolak."]);
    }

    #[Title('PAM - Manajemen Akses Privilege - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.manajemen-akses-privilege', [
            'requests' => $this->requests,
            'secrets' => $this->secrets
        ])->layout('components.layouts.admin');
    }
}
