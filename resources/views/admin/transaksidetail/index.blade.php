<!-- View for Displaying Transaksi Details -->
<link rel="stylesheet" href="{{asset('vendor/light/css/dataTables.bootstrap4.css')}}">

<body>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title"><b>{{$title}}</b></h2>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#dateRangeModal"><i class="fas fa-plus"></i> Print</a>
                <div class="card mt-2 shadow">
                    <div class="card-body">
                        <table class="table" id="mamank">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($td as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->produk_name }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item->created_at->timezone('Asia/Jakarta') }}</td>
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
</body>

<script src="{{asset('vendor/light/js/jquery.min.js')}}"></script>
<script src="{{asset('vendor/light/js/popper.min.js')}}"></script>
<script src="{{asset('vendor/light/js/config.js')}}"></script>
<script src="{{asset('vendor/light/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/light/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
  $('#mamank').DataTable({
    autoWidth: true,
    "lengthMenu": [
      [16, 32, 64, -1],
      [16, 32, 64, "All"]
    ]
  });
</script>

<div class="modal fade" id="dateRangeModal" tabindex="-1" role="dialog" aria-labelledby="dateRangeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateRangeModalLabel">Generate PDF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('generate-pdf') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="start_date">Tanggal Awal</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate PDF</button>
                </form>
            </div>
        </div>
    </div>
</div>
