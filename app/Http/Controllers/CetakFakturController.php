<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;

class CetakFakturController extends Controller
{
    public function __invoke($invoice)
    {
        $pesanan = Pesanan::where('nomor_invoice', $invoice)
            ->where('pengguna_id', auth()->id())
            ->with(['detailPesanan.produk', 'pengguna'])
            ->firstOrFail();

        return view('cetak.invoice', compact('pesanan'));
    }
}
