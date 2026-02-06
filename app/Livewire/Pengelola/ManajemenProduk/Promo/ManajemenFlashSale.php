<?php

namespace App\Livewire\Pengelola\ManajemenProduk\Promo;

use App\Helpers\LogHelper;
use App\Models\PenjualanKilat;
use App\Models\Produk;
use App\Models\ProdukPenjualanKilat;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ManajemenFlashSale extends Component
{
    use WithPagination, WithFileUploads;

    public $filterStatus = 'all';

    // Form State
    public $campaignId;
    public $nama_campaign;
    public $mulai;
    public $selesai;
    public $aktif = true;
    public $banner;
    public $items = []; // [produk_id, harga_diskon, kuota_stok]
    public $cariProduk = '';
    public $hasilPencarian = [];

    public function tambahCampaign()
    {
        $this->reset(['campaignId', 'nama_campaign', 'mulai', 'selesai', 'banner', 'items']);
        $this->mulai = now()->format('Y-m-d\TH:i');
        $this->selesai = now()->addDays(1)->format('Y-m-d\TH:i');
        $this->dispatch('open-slide-over', id: 'form-flash-sale');
    }

    public function updatedCariProduk()
    {
        if (strlen($this->cariProduk) > 2) {
            $this->hasilPencarian = Produk::where('nama', 'like', '%'.$this->cariProduk.'%')
                ->where('status', 'aktif')
                ->take(5)
                ->get();
        } else {
            $this->hasilPencarian = [];
        }
    }

    public function tambahItem($id)
    {
        $produk = Produk::find($id);
        
        // Cek duplikasi
        foreach ($this->items as $item) {
            if ($item['produk_id'] == $id) return;
        }

        $this->items[] = [
            'produk_id' => $produk->id,
            'nama' => $produk->nama,
            'harga_asli' => $produk->harga_jual,
            'harga_diskon' => $produk->harga_jual * 0.9, // Default diskon 10%
            'kuota_stok' => 10,
        ];

        $this->reset(['cariProduk', 'hasilPencarian']);
    }

    public function hapusItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function simpan()
    {
        $this->validate([
            'nama_campaign' => 'required|min:3',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after:mulai',
            'items' => 'required|array|min:1',
            'items.*.harga_diskon' => 'required|numeric|min:1000',
            'items.*.kuota_stok' => 'required|integer|min:1',
        ]);

        $data = [
            'nama_campaign' => $this->nama_campaign,
            'mulai' => $this->mulai,
            'selesai' => $this->selesai,
            'aktif' => $this->aktif,
        ];

        if ($this->banner) {
            $path = $this->banner->store('promo', 'public');
            $data['banner'] = '/storage/'.$path;
        }

        if ($this->campaignId) {
            $campaign = PenjualanKilat::find($this->campaignId);
            $campaign->update($data);
            ProdukPenjualanKilat::where('penjualan_kilat_id', $campaign->id)->delete();
        } else {
            $campaign = PenjualanKilat::create($data);
        }

        foreach ($this->items as $item) {
            ProdukPenjualanKilat::create([
                'penjualan_kilat_id' => $campaign->id,
                'produk_id' => $item['produk_id'],
                'harga_diskon' => $item['harga_diskon'],
                'kuota_stok' => $item['kuota_stok'],
            ]);
        }

        LogHelper::catat('buat_flash_sale', $this->nama_campaign, "Campaign Flash Sale '{$this->nama_campaign}' berhasil dibuat/diupdate.");

        $this->dispatch('close-slide-over', id: 'form-flash-sale');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Flash Sale berhasil dijadwalkan.']);
    }

    public function edit($id)
    {
        $campaign = PenjualanKilat::with('detailProduk.produk')->findOrFail($id);
        $this->campaignId = $campaign->id;
        $this->nama_campaign = $campaign->nama_campaign;
        $this->mulai = $campaign->mulai->format('Y-m-d\TH:i');
        $this->selesai = $campaign->selesai->format('Y-m-d\TH:i');
        $this->aktif = $campaign->aktif;
        
        $this->items = [];
        foreach ($campaign->detailProduk as $detail) {
            $this->items[] = [
                'produk_id' => $detail->produk_id,
                'nama' => $detail->produk->nama,
                'harga_asli' => $detail->produk->harga_jual,
                'harga_diskon' => $detail->harga_diskon,
                'kuota_stok' => $detail->kuota_stok,
            ];
        }

        $this->dispatch('open-slide-over', id: 'form-flash-sale');
    }

    #[Title('Manajemen Flash Sale - Teqara Admin')]
    public function render()
    {
        $campaigns = PenjualanKilat::withCount('detailProduk')
            ->when($this->filterStatus === 'aktif', fn($q) => $q->where('aktif', true)->where('selesai', '>', now()))
            ->latest()
            ->paginate(10);

        return view('livewire.pengelola.manajemen-produk.promo.manajemen-flash-sale', [
            'campaigns' => $campaigns
        ])->layout('components.layouts.admin');
    }
}
