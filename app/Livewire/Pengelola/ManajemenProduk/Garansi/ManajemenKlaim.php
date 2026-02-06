<?php

namespace App\Livewire\Pengelola\ManajemenProduk\Garansi;

use App\Helpers\LogHelper;
use App\Models\KlaimGaransi;
use App\Models\ProdukSeri;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenKlaim extends Component
{
    use WithPagination;

    public $filterStatus = 'all';
    public $cari = '';

    // Form State
    public $klaimId;
    public $inputSeri;
    public $jenis_klaim = 'perbaikan';
    public $keluhan;
    public $hasilPencarianSeri = null;

    // Process State
    public $solusi;
    public $catatan_teknisi;
    public $status_proses;

    public function updatedInputSeri()
    {
        if (strlen($this->inputSeri) > 3) {
            $this->hasilPencarianSeri = ProdukSeri::with('produk')
                ->where('nomor_seri', $this->inputSeri)
                ->first();
        } else {
            $this->hasilPencarianSeri = null;
        }
    }

    public function buatKlaimBaru()
    {
        $this->reset(['klaimId', 'inputSeri', 'jenis_klaim', 'keluhan', 'hasilPencarianSeri']);
        $this->dispatch('open-slide-over', id: 'form-klaim');
    }

    public function simpanKlaim()
    {
        $this->validate([
            'inputSeri' => 'required',
            'keluhan' => 'required|min:5',
        ]);

        if (!$this->hasilPencarianSeri) {
            $this->addError('inputSeri', 'Nomor Seri tidak valid atau tidak ditemukan di sistem.');
            return;
        }

        $kode = 'RMA-'.date('ymd').'-'.strtoupper(bin2hex(random_bytes(2)));

        KlaimGaransi::create([
            'kode_klaim' => $kode,
            'produk_seri_id' => $this->hasilPencarianSeri->id,
            'jenis_klaim' => $this->jenis_klaim,
            'keluhan' => $this->keluhan,
            'status' => 'menunggu_unit',
            'tgl_masuk' => now(),
        ]);

        // Update status unit jadi rusak/retur jika perlu, tapi biasanya nanti setelah cek fisik
        // Kita biarkan status seri tetap dulu sampai unit diterima teknisi.

        LogHelper::catat('buat_rma', $kode, "Klaim garansi baru dibuka untuk unit SN: {$this->inputSeri}");

        $this->dispatch('close-slide-over', id: 'form-klaim');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Tiket RMA berhasil dibuat.']);
    }

    public function prosesKlaim($id)
    {
        $k = KlaimGaransi::with('seri.produk')->findOrFail($id);
        $this->klaimId = $k->id;
        $this->status_proses = $k->status;
        $this->solusi = $k->solusi;
        $this->catatan_teknisi = $k->catatan_teknisi;
        $this->inputSeri = $k->seri->nomor_seri; // For display
        
        $this->dispatch('open-slide-over', id: 'proses-klaim');
    }

    public function updateStatusKlaim()
    {
        $k = KlaimGaransi::find($this->klaimId);
        
        $k->update([
            'status' => $this->status_proses,
            'solusi' => $this->solusi,
            'catatan_teknisi' => $this->catatan_teknisi,
            'tgl_selesai' => ($this->status_proses === 'selesai' || $this->status_proses === 'siap_ambil') ? now() : null,
        ]);

        // Jika selesai tukar unit atau refund, update status seri
        if ($this->status_proses === 'selesai') {
            if ($k->jenis_klaim === 'tukar_unit') {
                $k->seri->update(['status' => 'retur']); // Unit lama jadi retur
                // Idealnya pilih unit baru pengganti (out of scope for basic RMA, but good for enterprise)
            }
        }

        $this->dispatch('close-slide-over', id: 'proses-klaim');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Status RMA diperbarui.']);
    }

    #[Title('Manajemen Garansi & RMA - Admin Teqara')]
    public function render()
    {
        $klaim = KlaimGaransi::with(['seri.produk', 'pelanggan'])
            ->when($this->filterStatus !== 'all', fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->cari, fn($q) => $q->where('kode_klaim', 'like', '%'.$this->cari.'%'))
            ->latest()
            ->paginate(10);

        return view('livewire.pengelola.manajemen-produk.garansi.manajemen-klaim', [
            'daftarKlaim' => $klaim,
            'stats' => [
                'menunggu' => KlaimGaransi::where('status', 'menunggu_unit')->count(),
                'proses' => KlaimGaransi::whereIn('status', ['cek_fisik', 'proses_servis'])->count(),
                'selesai' => KlaimGaransi::where('status', 'selesai')->count(),
            ]
        ])->layout('components.layouts.admin');
    }
}
