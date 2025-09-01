<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kuitansi / Tanda Terima</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 13px; color: #222; background: #f8f9fa; }
        .container { max-width: 700px; margin: 24px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #0001; padding: 32px 32px 24px 32px; }
        .header { text-align: center; margin-bottom: 28px; }
        .header img { max-height: 60px; margin-bottom: 8px; }
        .title { font-size: 22px; font-weight: bold; color: #219653; margin-bottom: 6px; }
        .subtitle { font-size: 14px; color: #555; margin-bottom: 18px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 4px 0; vertical-align: top; }
        .info-label { color: #888; width: 140px; }
        .bordered { border: 1.5px solid #219653; border-radius: 8px; padding: 14px; margin-bottom: 22px; background: #f6fff8; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .items-table th, .items-table td { border: 1px solid #e0e0e0; padding: 7px 10px; text-align: left; }
        .items-table th { background: #e9f7ef; color: #219653; }
        .right { text-align: right; }
        .footer { margin-top: 32px; font-size: 11px; text-align: right; color: #888; }
        .signature { margin-top: 48px; text-align: right; }
        .signature .label { color: #888; }
        .total-row th, .total-row td { background: #e9f7ef; color: #219653; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            {{-- <img src="{{ public_path('logo.png') }}" alt="Logo"> --}}
            <div class="title">TANDA TERIMA / KUITANSI</div>
            <div class="subtitle">No: #{{ $transaction->transaction_id }}</div>
        </div>

        <table class="info-table">
            <tr>
                <td class="info-label"><b>Tanggal</b></td>
                <td>: {{ \Carbon\Carbon::parse($transaction->order_date)->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <td class="info-label"><b>Nama Penerima</b></td>
                <td>: {{ $transaction->recipient_name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label"><b>Alamat Pengiriman</b></td>
                <td>: {{ $transaction->shippingAddress->full_address ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label"><b>Status Pembayaran</b></td>
                <td>: 
                    @php
                        $status = $transaction->payments->first()->status ?? '-';
                        $color = $status === 'APPROVED' ? '#219653' : ($status === 'PENDING' ? '#f2c94c' : '#eb5757');
                    @endphp
                    <span style="color: {{ $color }}; font-weight:600;">{{ $status }}</span>
                </td>
            </tr>
        </table>

        <div class="bordered">
            <b>Detail Pembelian:</b>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->transactionItems as $i => $item)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $item->product->product_name ?? '-' }}</td>
                        <td>{{ $item->quantity }} {{ $item->product->unit ?? '' }}</td>
                        <td class="right">Rp{{ number_format($item->price,0,',','.') }}</td>
                        <td class="right">Rp{{ number_format($item->price * $item->quantity,0,',','.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <th colspan="4" class="right">Total Belanja</th>
                        <th class="right">Rp{{ number_format($transaction->total_price,0,',','.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="right">Ongkir</th>
                        <th class="right">Rp{{ number_format($transaction->shipping_cost,0,',','.') }}</th>
                    </tr>
                    <tr class="total-row">
                        <th colspan="4" class="right">Total Pembayaran</th>
                        <th class="right">Rp{{ number_format($transaction->total_price + $transaction->shipping_cost,0,',','.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="footer">
            Dicetak pada: {{ now()->format('d M Y H:i') }}
        </div>

        <div class="signature">
            <div class="label">Hormat Kami,</div>
            <br><br><br>
            <div><b>{{ config('app.name', 'Benih BRMP') }}</b></div>
        </div>
    </div>
</body>
</html>