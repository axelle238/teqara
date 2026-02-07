<?php

namespace App\Extensions;

use Illuminate\Cache\DatabaseStore;

/**
 * Class PengelolaCacheBasisData
 * Tujuan: Ekstensi Driver Cache Laravel untuk mendukung kolom Bahasa Indonesia.
 * Kolom: key -> kunci, value -> nilai, expiration -> kedaluwarsa.
 */
class PengelolaCacheBasisData extends DatabaseStore
{
    /**
     * Dapatkan query builder untuk tabel cache.
     * 
     * @return \Illuminate\Database\Query\Builder
     */
    protected function table()
    {
        return $this->connection->table($this->table);
    }

    /**
     * Ambil item dari cache berdasarkan kunci.
     * 
     * @param  string  $key
     * @return mixed
     */
    public function get($key)
    {
        $cache = $this->table()->where('kunci', $this->prefix.$key)->first();

        if (is_null($cache)) {
            return;
        }

        $cache = is_array($cache) ? (object) $cache : $cache;

        if (time() >= $cache->kedaluwarsa) {
            $this->forget($key);
            return;
        }

        return $this->unserialize($cache->nilai);
    }

    /**
     * Simpan item ke dalam cache.
     * 
     * @param  string  $key
     * @param  mixed   $value
     * @param  int     $seconds
     * @return bool
     */
    public function put($key, $value, $seconds)
    {
        $key = $this->prefix.$key;
        $expiration = $this->getTime() + $seconds;

        try {
            return $this->table()->insert([
                'kunci' => $key,
                'nilai' => $this->serialize($value),
                'kedaluwarsa' => $expiration,
            ]);
        } catch (\Exception $e) {
            return $this->table()->where('kunci', $key)->update([
                'nilai' => $this->serialize($value),
                'kedaluwarsa' => $expiration,
            ]);
        }
    }

    /**
     * Tambahkan nilai numerik ke item dalam cache.
     * 
     * @param  string  $key
     * @param  mixed   $value
     * @return int|bool
     */
    public function increment($key, $value = 1)
    {
        return $this->incrementOrDecrement($key, $value, function ($current, $value) {
            return $current + $value;
        });
    }

    /**
     * Kurangi nilai numerik dari item dalam cache.
     * 
     * @param  string  $key
     * @param  mixed   $value
     * @return int|bool
     */
    public function decrement($key, $value = 1)
    {
        return $this->incrementOrDecrement($key, $value, function ($current, $value) {
            return $current - $value;
        });
    }

    /**
     * Lakukan increment atau decrement pada item cache.
     */
    protected function incrementOrDecrement($key, $value, $callback)
    {
        return $this->connection->transaction(function () use ($key, $value, $callback) {
            $prefixed = $this->prefix.$key;

            $cache = $this->table()->where('kunci', $prefixed)->lockForUpdate()->first();

            if (is_null($cache)) {
                return false;
            }

            $cache = is_array($cache) ? (object) $cache : $cache;

            $current = $this->unserialize($cache->nilai);

            $new = $callback((int) $current, $value);

            $this->table()->where('kunci', $prefixed)->update([
                'nilai' => $this->serialize($new),
            ]);

            return $new;
        });
    }

    /**
     * Hapus item dari cache.
     * 
     * @param  string  $key
     * @return bool
     */
    public function forget($key)
    {
        $this->table()->where('kunci', $this->prefix.$key)->delete();

        return true;
    }

    /**
     * Hapus seluruh item dari cache.
     * 
     * @return bool
     */
    public function flush()
    {
        $this->table()->delete();

        return true;
    }
}
