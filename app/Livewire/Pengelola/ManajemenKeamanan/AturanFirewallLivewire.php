<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use App\Helpers\LogHelper;
use App\Models\AturanFirewall;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class AturanFirewallLivewire extends Component
{
    use WithPagination;

    public $activeTab = 'list'; // list, create
    public $cari = '';

    // Form Properties
    public $ruleId;
    public $alamat_ip;
    public $user_agent;
    public $negara;
    public $tipe_aturan = 'blokir';
    public $level_ancaman = 'medium';
    public $alasan;
    public $kadaluarsa_pada;

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        if ($tab === 'create') {
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->reset(['ruleId', 'alamat_ip', 'user_agent', 'negara', 'tipe_aturan', 'level_ancaman', 'alasan', 'kadaluarsa_pada']);
    }

    public function edit($id)
    {
        $r = AturanFirewall::findOrFail($id);
        $this->ruleId = $r->id;
        $this->alamat_ip = $r->alamat_ip;
        $this->user_agent = $r->user_agent;
        $this->negara = $r->negara;
        $this->tipe_aturan = $r->tipe_aturan;
        $this->level_ancaman = $r->level_ancaman;
        $this->alasan = $r->alasan;
        $this->kadaluarsa_pada = $r->kadaluarsa_pada?->format('Y-m-d\TH:i');
        
        $this->activeTab = 'create';
    }

    public function simpan()
    {
        $this->validate([
            'tipe_aturan' => 'required|in:blokir,izinkan',
            'alasan' => 'required|string|max:255',
        ]);

        if (empty($this->alamat_ip) && empty($this->user_agent) && empty($this->negara)) {
            $this->addError('target', 'Minimal satu target (IP, User Agent, atau Negara) harus diisi.');
            return;
        }

        $data = [
            'alamat_ip' => $this->alamat_ip,
            'user_agent' => $this->user_agent,
            'negara' => $this->negara,
            'tipe_aturan' => $this->tipe_aturan,
            'level_ancaman' => $this->level_ancaman,
            'alasan' => $this->alasan,
            'kadaluarsa_pada' => $this->kadaluarsa_pada ?: null,
            'dibuat_oleh' => auth()->id(),
            'aktif' => true,
        ];

        if ($this->ruleId) {
            AturanFirewall::find($this->ruleId)->update($data);
            $pesan = "Aturan firewall #{$this->ruleId} diperbarui.";
            $action = 'update';
        } else {
            $rule = AturanFirewall::create($data);
            $pesan = "Aturan WAF baru diterapkan.";
            $action = 'create';
        }

        LogHelper::catat('firewall_' . $action, 'WAF', $pesan);
        
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        $this->activeTab = 'list';
    }

    public function toggleStatus($id)
    {
        $r = AturanFirewall::find($id);
        $r->aktif = !$r->aktif;
        $r->save();
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Status aturan diperbarui.']);
    }

    public function hapus($id)
    {
        AturanFirewall::find($id)->delete();
        LogHelper::catat('firewall_delete', 'WAF', "Aturan firewall dihapus.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Aturan dihapus dari database.']);
    }

    #[Title('Web Application Firewall (WAF) - Teqara Security')]
    public function render()
    {
        $rules = AturanFirewall::query()
            ->when($this->cari, function($q) {
                $q->where('alamat_ip', 'like', '%'.$this->cari.'%')
                  ->orWhere('alasan', 'like', '%'.$this->cari.'%')
                  ->orWhere('user_agent', 'like', '%'.$this->cari.'%');
            })
            ->latest('dibuat_pada')
            ->paginate(10);

        return view('livewire.pengelola.manajemen-keamanan.aturan-firewall', [
            'rules' => $rules
        ])->layout('components.layouts.admin', ['header' => 'Firewall & Traffic Control']);
    }
}