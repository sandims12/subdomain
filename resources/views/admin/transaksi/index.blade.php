<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Transaksi</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/light/css/dataTables.bootstrap4.css') }}">
    <!-- Sertakan file CSS lainnya yang dibutuhkan -->

    <style>
        /* Tambahkan style custom jika diperlukan */
    </style>
</head>
<body>
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="mb-2 page-title"><b>{{ $title }}</b></h2>
                    @if(auth()->user()->role != "kasir")
                        <a href="/admin/transaksi/create" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                    @endif
                    @if(auth()->user()->role != "admin")
                        <a href="/kasir/transaksi/create" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                    @endif

                    @if ($completedTransactionsToday->where('status', 'menunggu')->isNotEmpty())
                        <div class="card mt-2 shadow">
                            <div class="card-body">
                                <table class="table table-striped" id="mamank">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Nama Kasir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($completedTransactionsToday as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
                                                <td>{{ ucfirst($item->status) }}</td>
                                                <td>Rp.{{ format_rupiah($item->total) }}</td>
                                                <td>{{ $item->kasir_name }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        @if ($item->status == 'menunggu')
                                                            <a href="/kasir/transaksi/{{ $item->id }}/edit" class="btn btn-info btn-sm"><i class="fe fe-edit"></i></a>
                                                            <form action="/kasir/transaksi/{{ $item->id }}" method="POST">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm ml-1"><i class="fe fe-trash"></i></button>
                                                            </form>
                                                        @elseif ($item->status == 'selesai')
                                                            <a href="/kasir/{{ $item->id }}/generate-pdf" class="btn btn-success btn-block"><i class="fe fe-file-plus"></i></a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card mt-2 shadow">
                        <div class="card-body">
                            <table class="table table-striped" id="mamank2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Metode pembayaran</th>
                                        <th>Nama Kasir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($completedTransactionsNotToday as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
                                            <td>{{ ucfirst($item->status) }}</td>
                                            <td>Rp.{{ format_rupiah($item->total) }}</td>
                                            <td>{{ ucfirst($item->metode_pembayaran) }}</td>                                 
                                            <td>{{ $item->kasir_name }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @if ($item->status == 'menunggu')
                                                        @if (auth()->user()->role != "kasir")
                                                            <a href="/admin/transaksi/{{ $item->id }}/edit" class="btn btn-info btn-sm"><i class="fe fe-edit"></i></a>
                                                            <form action="/admin/transaksi/{{ $item->id }}" method="POST">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm ml-1"><i class="fe fe-trash"></i></button>
                                                            </form>
                                                        @endif
                                                    @elseif ($item->status == 'selesai')
                                                        <a href="/kasir/{{ $item->id }}/generate-pdf" class="btn btn-success btn-block"><i class="fe fe-file-plus"></i></a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="{{ asset('vendor/light/js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/light/js/popper.min.js') }}"></script>
    <!-- Sertakan file JS lainnya yang dibutuhkan -->
    <script src="{{ asset('vendor/light/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/light/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.payment-method-select').on('change', function() {
            var selectedMethod = $(this).val();
            var transactionId = $(this).attr('id').replace('metode_pembayaran_', '');

            $.ajax({
                url: '/update-payment-method',
                method: 'POST',
                data: {
                    transaction_id: transactionId,
                    payment_method: selectedMethod
                },
                success: function(response) {
                    console.log(response);

                    $('#metode_pembayaran_' + transactionId + ' option').each(function() {
                        if ($(this).val() === selectedMethod) {
                            $(this).prop('selected', true);
                        } else {
                            $(this).remove();
                        }
                    });

                    $('#metode_pembayaran_' + transactionId).prop('disabled', true);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });
</script>
</body>
</html>
