<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan PDF</title>
    <!-- Add any additional styles or meta tags here -->
</head>
<body>
    <h1>Laporan Transaksi</h1>
    <p>Periode: {{ $start_date }} - {{ $end_date }}</p> 

    <table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Jumlah</th> 
            <th>Subtotal</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalQty = 0; // Inisialisasi total qty
            $totalSubtotal = 0; // Inisialisasi total subtotal
        @endphp

        @foreach ($transaksiDetails as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->produk_name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ format_rupiah($item->subtotal) }}</td>
                <td>{{ $item->created_at->timezone('Asia/Jakarta') }}</td>
            </tr>

            @php
                $totalQty += $item->qty; // Akumulasi total qty
                $totalSubtotal += $item->subtotal; // Akumulasi total subtotal
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
          
        </tr>
    </tfoot>
            <td colspan="2"><strong>Subtotal</strong>
            {{ format_rupiah($totalSubtotal) }}</td>
            <td colspan="2"><strong>Total Barang dipesan</strong>
            {{ $totalQty }}</td>
    
</table>

    <!-- Add any additional content or styling as needed -->

</body>
</html>