<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $pesanan->nomor_faktur }}</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.6; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; }
        .header { display: flex; justify-content: space-between; margin-bottom: 40px; }
        .title { font-size: 24px; font-weight: bold; color: #0891b2; }
        .info { font-size: 14px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background: #f8f9fa; text-align: left; padding: 12px; border-bottom: 2px solid #eee; font-size: 12px; text-transform: uppercase; }
        td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        .total-row td { border-top: 2px solid #333; font-weight: bold; font-size: 16px; }
        .status { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .lunas { background: #d1fae5; color: #065f46; }
        .belum { background: #fef3c7; color: #92400e; }
        @media print { .no-print { display: none; } .invoice-box { border: none; } }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="no-print" style="text-align: right; margin-bottom: 20px;">
            <button onclick="window.print()" style="padding: 10px 20px; background: #333; color: white; border: none; cursor: pointer;">Cetak Faktur</button>
        </div>

        <div class="header">
            <div>
                <div class="title">TEQARA</div>
                <div class="info">
                    Sistem Penjualan Komputer & Gadget<br>
                    support@teqara.com
                </div>
            </div>
            <div style="text-align: right;">
                <div class="title">INVOICE</div>
                <div class="info">
                    Nomor: #{{ $pesanan->nomor_faktur }}<br>
                    Tanggal: {{ $pesanan->dibuat_pada->format('d M Y') }}<br>
                    Status: <span class="status {{ $pesanan->status_pembayaran == 'lunas' ? 'lunas' : 'belum' }}">{{ $pesanan->status_pembayaran }}</span>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 40px; display: flex; gap: 40px;">
            <div style="flex: 1;">
                <strong>Ditagihkan Kepada:</strong><br>
                {{ $pesanan->pengguna->nama }}<br>
                {{ $pesanan->pengguna->email }}<br>
                {{ $pesanan->pengguna->nomor_telepon }}
            </div>
            <div style="flex: 1;">
                <strong>Dikirim Ke:</strong><br>
                {{ $pesanan->alamat_pengiriman }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: right;">Harga Satuan</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan->detailPesanan as $detail)
                <tr>
                    <td>{{ $detail->produk->nama }}</td>
                    <td style="text-align: center;">{{ $detail->jumlah }}</td>
                    <td style="text-align: right;">Rp {{ number_format($detail->harga_saat_ini, 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                @if($pesanan->potongan_diskon > 0)
                <tr>
                    <td colspan="3" style="text-align: right;">Diskon Voucher ({{ $pesanan->kode_voucher }})</td>
                    <td style="text-align: right; color: red;">- Rp {{ number_format($pesanan->potongan_diskon, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">TOTAL PEMBAYARAN</td>
                    <td style="text-align: right;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #777;">
            <p>Terima kasih telah berbelanja di Teqara Computer.<br>Simpan bukti pembayaran ini sebagai jaminan garansi resmi.</p>
        </div>
    </div>
</body>
</html>
