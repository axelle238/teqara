<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPembayaran;
use App\Models\PengaturanSistem;
use App\Services\LayananGerbangPembayaran;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class MidtransNotificationController extends Controller
{
    public function handle(Request $request, LayananGerbangPembayaran $layanan)
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
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['message' => 'Invalid Notification'], 400);
        }

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraudStatus = $notif->fraud_status;

        // Find transaction by order_id (which is mapped to kode_pembayaran in DB)
        $transaksi = TransaksiPembayaran::where('kode_pembayaran', $orderId)->first();

        if (!$transaksi) {
            Log::warning('Midtrans Notification: Transaction not found for Order ID ' . $orderId);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Map Midtrans Status to App Status
        $status = $transaksi->status;

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $status = 'menunggu';
            } else {
                $status = 'sukses';
            }
        } else if ($transactionStatus == 'settlement') {
            $status = 'sukses';
        } else if ($transactionStatus == 'pending') {
            $status = 'menunggu';
        } else if ($transactionStatus == 'deny') {
            $status = 'gagal';
        } else if ($transactionStatus == 'expire') {
            $status = 'kadaluarsa';
        } else if ($transactionStatus == 'cancel') {
            $status = 'batal';
        }

        // Process Status Change
        if ($status == 'sukses' && $transaksi->status != 'sukses') {
            $layanan->prosesNotifikasi($transaksi->id, 'sukses');
        } elseif ($status == 'gagal' || $status == 'kadaluarsa' || $status == 'batal') {
             if ($transaksi->status != $status) {
                $transaksi->update(['status' => $status]);
                // Update Order Status as well if needed
                if ($transaksi->pesanan) {
                    $transaksi->pesanan->update(['status_pembayaran' => 'gagal']);
                }
             }
        }

        return response()->json(['message' => 'OK']);
    }
}
