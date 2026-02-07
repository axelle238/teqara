<?php

namespace App\Services;

use App\Models\PengaturanSistem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

/**
 * Class LayananLogistik
 * Tujuan: Integrasi RajaOngkir untuk perhitungan biaya pengiriman otomatis.
 */
class LayananLogistik
{
    protected $apiKey;
    protected $baseUrl;
    protected $type;

    public function __construct()
    {
        $settings = PengaturanSistem::where('kunci', 'like', 'logistic_rajaongkir_%')->pluck('nilai', 'kunci');
        $this->apiKey = $settings['logistic_rajaongkir_key'] ?? config('services.rajaongkir.key');
        $this->type = $settings['logistic_rajaongkir_type'] ?? 'starter';
        $this->baseUrl = "https://api.rajaongkir.com/{$this->type}";
    }

    /**
     * Ambil daftar provinsi.
     */
    public function getProvinces()
    {
        return Cache::remember('rajaongkir_provinces', 86400, function () {
            $response = Http::withHeaders(['key' => $this->apiKey])
                ->get("{$this->baseUrl}/province");

            return $response->json()['rajaongkir']['results'] ?? [];
        });
    }

    /**
     * Ambil daftar kota berdasarkan provinsi.
     */
    public function getCities($provinceId = null)
    {
        $cacheKey = "rajaongkir_cities_" . ($provinceId ?? 'all');
        return Cache::remember($cacheKey, 86400, function () use ($provinceId) {
            $url = "{$this->baseUrl}/city";
            $params = $provinceId ? ['province' => $provinceId] : [];
            
            $response = Http::withHeaders(['key' => $this->apiKey])
                ->get($url, $params);

            return $response->json()['rajaongkir']['results'] ?? [];
        });
    }

    /**
     * Hitung biaya pengiriman.
     */
    public function hitungBiaya($destinationCityId, $weightGram, $courier = 'jne')
    {
        $originCityId = PengaturanSistem::where('kunci', 'logistic_rajaongkir_origin_id')->value('nilai') ?? '153'; // Default Jakarta Selatan if not set

        if (empty($this->apiKey)) {
            return [];
        }

        $response = Http::withHeaders(['key' => $this->apiKey])
            ->asForm()
            ->post("{$this->baseUrl}/cost", [
                'origin' => $originCityId,
                'destination' => $destinationCityId,
                'weight' => $weightGram,
                'courier' => $courier,
            ]);

        $results = $response->json()['rajaongkir']['results'] ?? [];
        
        $formatted = [];
        foreach ($results as $res) {
            foreach ($res['costs'] as $cost) {
                $formatted[] = [
                    'code' => $res['code'],
                    'name' => $res['name'] . ' (' . $cost['service'] . ')',
                    'service' => $cost['service'],
                    'cost' => $cost['cost'][0]['value'],
                    'etd' => $cost['cost'][0]['etd'],
                    'description' => $cost['description']
                ];
            }
        }

        return $formatted;
    }
}
