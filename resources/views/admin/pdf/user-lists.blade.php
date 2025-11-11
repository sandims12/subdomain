<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Receipt</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 20px;
        }
        .receipt_header h1, .receipt_header h2 {
            margin: 0;
            padding: 0;
        }
        .receipt_body .date_time_con {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Transaction Receipt</h3>
                    </div>
                    <div class="card-body">
                        <div class="receipt_header">
                            <h1>proyek2</h1>
                            <h2>Rumah Alek <br><span>Tel: +62 821 2643 0546</span></h2>
                        </div>

                        <div class="receipt_body">
                            <div class="date_time_con">
                                <div class="date">{{ $transaction->created_at->timezone('Asia/Jakarta')->format('d/m/Y') }}</div>
                                <div class="time">{{ $transaction->created_at->timezone('Asia/Jakarta')->format('h:i:s A') }}</div>
                            </div>

                            <div class="items">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>QTY</th>
                                            <th colspan="2">ITEM</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactionDetail as $detail)
                                            <tr>
                                                <td>{{ $detail->qty }}</td>
                                                <td colspan="2">{{ $detail->produk_name }}</td>
                                                <td>{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>metode pembayaran</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ ucfirst($transaction->metode_pembayaran) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ number_format($transaction->total, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Bayar</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ number_format($transaction->dibayarkan, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td>kembalian</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ number_format($transaction->dibayarkan - $transaction->total, 0, ',', '.') }}</td>
                                        </tr>                                        
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <h3>Thank You!</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
