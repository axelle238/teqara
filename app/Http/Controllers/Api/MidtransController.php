<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSistem;
use App\Services\LayananGerbangPembayaran;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function notification(Request $request)
    {
        // Load Config
        $settings = PengaturanSistem::pluck('nilai', 'kunci');
        Config::$serverKey = $settings['payment_midtrans_server'] ?? config('services.midtrans.server_key');
        Config::$isProduction = ($settings['payment_midtrans_mode'] ?? 'sandbox') === 'production';
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Notification Error: ' . $e->getMessage()], 500);
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        // Find Transaction
        $transaksi = \App\Models\TransaksiPembayaran::where('kode_pembayaran', $orderId)->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $status = 'menunggu';

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $status = 'menunggu';
                } else {
                    $status = 'sukses';
                }
            }
        } else if ($transaction == 'settlement') {
            $status = 'sukses';
        } else if ($transaction == 'pending') {
            $status = 'menunggu';
        } else if ($transaction == 'deny') {
            $status = 'gagal';
        } else if ($transaction == 'expire') {
            $status = 'gagal';
        } else if ($transaction == 'cancel') {
            $status = 'gagal';
        }

        // Process Notification
        (new LayananGerbangPembayaran)->prosesNotifikasi($transaksi->id, $status);

        return response()->json(['message' => 'Notification processed'], 200);
    }
}
