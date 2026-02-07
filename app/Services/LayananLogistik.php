<?php

namespace App\Services;

use App\Models\PengaturanSistem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

/**
 * Layanan Logistik
 * 
 * Bertanggung jawab untuk integrasi RajaOngkir guna perhitungan biaya pengiriman otomatis
 * dan pengelolaan data wilayah (Provinsi & Kota).
 */
class LayananLogistik
{
    protected $kunciApi;
    protected $urlDasar;
    protected $tipe;

    /**
     * Inisialisasi layanan dengan konfigurasi dari database.
     */
    public function __construct()
    {
        $pengaturan = PengaturanSistem::where('kunci', 'like', 'logistic_rajaongkir_%')->pluck('nilai', 'kunci');
        $this->kunciApi = $pengaturan['logistic_rajaongkir_key'] ?? config('services.rajaongkir.key');
        $this->tipe = $pengaturan['logistic_rajaongkir_type'] ?? 'starter';
        $this->urlDasar = "https://api.rajaongkir.com/{$this->tipe}";
    }

    /**
     * Mengambil daftar provinsi dari API RajaOngkir.
     */
    public function ambilProvinsi()
    {
        return Cache::remember('rajaongkir_provinces', 86400, function () {
            $respons = Http::withHeaders(['key' => $this->kunciApi])
                ->get("{$this->urlDasar}/province");

            return $respons->json()['rajaongkir']['results'] ?? [];
        });
    }

    /**
     * Mengambil daftar kota berdasarkan ID provinsi.
     */
    public function ambilKota($idProvinsi = null)
    {
        $kunciCache = "rajaongkir_cities_" . ($idProvinsi ?? 'semua');
        return Cache::remember($kunciCache, 86400, function () use ($idProvinsi) {
            $url = "{$this->urlDasar}/city";
            $parameter = $idProvinsi ? ['province' => $idProvinsi] : [];
            
            $respons = Http::withHeaders(['key' => $this->kunciApi])
                ->get($url, $parameter);

            return $respons->json()['rajaongkir']['results'] ?? [];
        });
    }

    /**
     * Menghitung estimasi biaya pengiriman.
     */
    public function hitungBiaya($idKotaTujuan, $beratGram, $kurir = 'jne')
    {
        $idKotaAsal = PengaturanSistem::where('kunci', 'logistic_rajaongkir_origin_id')->value('nilai') ?? '153'; // Default Jakarta Selatan

        if (empty($this->kunciApi)) {
            return [];
        }

        $respons = Http::withHeaders(['key' => $this->kunciApi])
            ->asForm()
            ->post("{$this->urlDasar}/cost", [
                'origin' => $idKotaAsal,
                'destination' => $idKotaTujuan,
                'weight' => $beratGram,
                'courier' => $kurir,
            ]);

        $hasil = $respons->json()['rajaongkir']['results'] ?? [];
        
        $terformat = [];
        foreach ($hasil as $h) {
            foreach ($h['costs'] as $biaya) {
                $terformat[] = [
                    'kode' => $h['code'],
                    'nama' => $h['name'] . ' (' . $biaya['service'] . ')',
                    'layanan' => $biaya['service'],
                    'nominal' => $biaya['cost'][0]['value'],
                    'estimasi' => $biaya['cost'][0]['etd'],
                    'deskripsi' => $biaya['description']
                ];
            }
        }

        return $terformat;
    }
}
