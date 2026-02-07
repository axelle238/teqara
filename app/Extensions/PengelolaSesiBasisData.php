<?php

namespace App\Extensions;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Session\DatabaseSessionHandler;
use Illuminate\Support\Carbon;

/**
 * Class PengelolaSesiBasisData
 * Tujuan: Ekstensi Driver Sesi Laravel untuk mendukung kolom Bahasa Indonesia secara penuh.
 * Kolom: id, pengguna_id, alamat_ip, agen_pengguna, muatan, aktivitas_terakhir.
 */
class PengelolaSesiBasisData extends DatabaseSessionHandler
{
    /**
     * Membaca data sesi dari database.
     * 
     * @param  string  $sessionId
     * @return string
     */
    public function read($sessionId): string
    {
        $session = (object) $this->getQuery()->find($sessionId);

        if (isset($session->muatan)) {
            $this->exists = true;

            return base64_decode($session->muatan);
        }

        return '';
    }

    /**
     * Menulis data sesi ke database.
     * 
     * @param  string  $sessionId
     * @param  string  $data
     * @return bool
     */
    public function write($sessionId, $data): bool
    {
        $payload = $this->getDefaultPayload($data);

        if (! $this->exists) {
            $this->read($sessionId);
        }

        if ($this->exists) {
            $this->getQuery()->where('id', $sessionId)->update($payload);
        } else {
            $payload['id'] = $sessionId;
            $this->getQuery()->insert($payload);
        }

        $this->exists = true;

        return true;
    }

    /**
     * Dapatkan payload default untuk penyimpanan sesi.
     */
    protected function getDefaultPayload($data)
    {
        $payload = [
            'muatan' => base64_encode($data),
            'aktivitas_terakhir' => time(),
        ];

        if (! $this->container) {
            return $payload;
        }

        return tap($payload, function (&$payload) {
            $this->addUserInformation($payload)
                 ->addRequestInformation($payload);
        });
    }

    /**
     * Tambahkan informasi pengguna ke payload.
     */
    protected function addUserInformation(&$payload)
    {
        if ($this->container->bound(Guard::class)) {
            $payload['pengguna_id'] = $this->userId();
        }

        return $this;
    }

    /**
     * Tambahkan informasi permintaan (IP & UA) ke payload.
     */
    protected function addRequestInformation(&$payload)
    {
        if ($this->container->bound('request')) {
            $payload['alamat_ip'] = $this->ipAddress();
            $payload['agen_pengguna'] = $this->userAgent();
        }

        return $this;
    }

    /**
     * Menghapus sesi berdasarkan ID.
     */
    public function destroy($sessionId): bool
    {
        $this->getQuery()->where('id', $sessionId)->delete();

        return true;
    }

    /**
     * Membersihkan sesi yang sudah kedaluwarsa.
     */
    public function gc($lifetime): int
    {
        return $this->getQuery()->where('aktivitas_terakhir', '<=', time() - $lifetime)->delete();
    }

    /**
     * Dapatkan query builder untuk tabel sesi.
     */
    protected function getQuery()
    {
        return $this->connection->table($this->table);
    }
}