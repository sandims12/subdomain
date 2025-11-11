<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    
    </head>
    
        <main role="main" class="main-content">
        @if(auth()->user()->role != "kasir")
                <a href="/admin/transaksi" class="btn btn-info"><i class="fe fe-arrow-left"></i> Kembali </a>
            @endif
            @if(auth()->user()->role != "admin")
            <a href="/kasir/transaksi" class="btn btn-info"><i class="fe fe-arrow-left"></i> Kembali </a>
    
            @endif
            <div class="container-fluid pt-2">
                
                <div class="row">
                    
                    <div class="col-md-6">
                        
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="row mt-1">
                                    
                                    <div class="col-md-12">
                                        <table class="table" id="mamank">
                                            <thead>
                                                <tr>
                                                    <th>Kode Produk</th>
                                                    <th>Nama Produk</th>
                                                    <th>Gambar Produk</th>
                                                    <th>QTY</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($produk as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->stock }}</td>
                                                        <td><img src="{{ asset('images/' . $item->foto) }}"
                                                            alt="Gambar Produk" style="max-width: 100px;"></td>    
                                                        <td>
                                                            <form method="GET">
                                                                @csrf
                                                                <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                                                <button type="submit" class="btn btn-primary">Tambah</button>
                                                            </form>
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
                    <div class="col-md-6">
                    
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="GET">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Total Belanja</label>
                                        <input type="number" value="{{ $transaksi->total }}" name="total_belanja" class="form-control" id="">
                                    </div>
    
                                    <div class="form-group">
                                        <label for="">Dibayarkan</label>
                                        <input type="number" name="dibayarkan" value="{{ request('dibayarkan', $transaksi->dibayarkan) }}" class="form-control" id="" min="0">
                                    </div>

                                    <div class="form-group">
                                        <label for="metode_pembayaran">Metode Pembayaran</label>
                                        <select name="metode_pembayaran" class="form-control" required>
                                            <option value="cash" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="dana" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'dana' ? 'selected' : '' }}>Dana</option>
                                            <option value="ovo" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'ovo' ? 'selected' : '' }}>OVO</option>
                                            <option value="qris" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'qris' ? 'selected' : '' }}>Qris</option>
                                        </select>
                                    </div>
                                    
    
                                    <button type="submit" class="btn btn-primary btn-block"> Hitung </button>
                                </form>
                                <hr>
    
                                <div class="form-group">
                                    <label for="">Uang Kembalian</label>
                                    <input type="number" value="{{ format_rupiah($kembalian) }}" disabled name="kembalian" class="form-control" id="">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                @if(isset($p_detail)) <!-- Menyembunyikan formulir jika $p_detail tidak ada -->
            <form action="{{ auth()->user()->role == 'kasir' ? '/kasir/transaksi/detail/create' : '/admin/transaksi/detail/create' }}" method="POST" id="formTambah">
            @csrf
            <input type="hidden" name="transaksi_id" value="{{ Request::segment(3) }}">
            <input type="hidden" name="produk_id" value="{{ isset($p_detail) ? $p_detail->id : '' }}">
            <input type="hidden" name="produk_name" value="{{ isset($p_detail) ? $p_detail->nama : '' }}">
            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
    
            <div class="row mt-1">
                <div class="col-md-4">
                    <label for="">Nama Produk</label>
                </div>
                <div class="col-md-8">
                    <input type="text" value="{{ isset($p_detail) ? $p_detail->nama : '' }}" class="form-control" disabled name="nama_produk">
                </div>
            </div>
    
            <div class="row mt-1">
        <div class="col-md-4">
            <label for="">Harga Satuan</label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{{ isset($p_detail) ? $p_detail->harga : '' }}" class="form-control" disabled name="harga_satuan" id="harga_satuan">
        </div>
    </div>
    
    <div class="row mt-1">
        <div class="col-md-4">
            <label for="">QTY</label>
        </div>
        <div class="col-md-8">
            <div class="d-flex">
                <a href="#" class="btn btn-primary" id="btnMinus"><i class="fe fe-minus"></i></a>
                <input type="number" value="{{ $qty }}" class="form-control" name="qty" id="qty" min="1">
                <a href="#" class="btn btn-primary" id="btnPlus"><i class="fe fe-plus"></i></a>
            </div>
        </div>
    </div>
    
    
    
    <div class="row mt-1">
        <div class="col-md-4">
            <label for="">Diskon</label>
        </div>
        <div class="col-md-8">
            <h5>
                @if(isset($p_detail) && $p_detail->diskon !== null)
                    {{ $p_detail->diskon . '%' }}
                @else
                    Tidak Ada Diskon
                @endif
            </h5>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Menambahkan event listener pada formulir
            document.getElementById('formTambah').addEventListener('submit', function () {
                // Menonaktifkan tombol setelah diklik
                document.getElementById('tombolTambah').disabled = true;
            });
        });
    </script>
            <div class="row mt-1">
                <div class="col-md-4">
                </div>
                <div class="col-md-8"> 
                    <button type="submit" class="btn btn-primary" id="tombolTambah">Tambah <i class="fe fe-arrow-right"></i></button></i></button>
                </div>
            </div>
        </form>
    @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Some content if needed -->
                    </div>
                </div>
            </div>
               
                  
        <div class="col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <strong class="card-title">Barang Yang dipesan</strong>
            </div>
            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>QTY</th>
                                            <th>Subtotal</th>
                                            <th>Metode Pembayaran</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksi_detail as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->produk_name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ 'Rp. '.format_rupiah($item->subtotal) }}</td>
                                                <td>{{ ucfirst($transaksi->metode_pembayaran) }}</td>
                                                <td>
                                                    <a href="/kasir/transaksi/detail/delete?id={{ $item->id }}"><i class="fe fe-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
    
                                <!-- <a href="" class="btn btn-info"><i class="fe fe-file"></i> Print </a> -->
                                @if(auth()->user()->role != "kasir")
                                <a href="/admin/transaksi/detail/selesai/{{ Request::segment(3) }}" class="btn btn-success{{ $kembalian <= -1 ? ' disabled' : '' }}">
                                    <i class="fe fe-check"></i> Selesai
                                </a>
                            @endif
    
                            @if(auth()->user()->role != "admin")
                                <a href="/kasir/transaksi/detail/selesai/{{ Request::segment(3) }}" class="btn btn-success{{ $kembalian <= -1 ? ' disabled' : '' }}">
                                    <i class="fe fe-check"></i> Selesai
                                </a>
                            @endif
                            </div>
                        </div>
                </div> <!-- / .list-group -->
            </div> <!-- / .card-body -->
        </div> <!-- / .card --> 
    
        </main>
        
        <script src="{{asset('vendor/light/js/jquery.min.js')}}"></script>
        <script src="{{asset('vendor/light/js/popper.min.js')}}"></script>
        <script src="{{asset('vendor/light/js/config.js')}}"></script>
        <script src="{{asset('vendor/light/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('vendor/light/js/dataTables.bootstrap4.min.js')}}"></script>
        <script>
    
          $('#mamank').DataTable(
          {
            autoWidth: true,
            "lengthMenu": [
              [5, 32, 64, -1],
              [5, 32, 64, "All"]
            ]
          });
        </script>
    
    <!-- ... (bagian HTML lainnya) ... -->
    
    <script>
        // Simpan posisi scroll saat halaman dimuat
        $(document).ready(function () {
            var scrollPosition = localStorage.getItem("scrollPosition");
            if (scrollPosition !== null) {
                $(window).scrollTop(scrollPosition);
            }
        });
    
        // Simpan posisi scroll saat halaman ditutup
        $(window).on("beforeunload", function () {
            var scrollPosition = $(window).scrollTop();
            localStorage.setItem("scrollPosition", scrollPosition);
        });
    </script>
    
    <script>
        $(document).ready(function () {
            updateSubtotal();
    
            // Ketika nilai qty berubah, perbarui subtotal
            $('#qty').on('input', function () {
                updateSubtotal();
            });
    
            // Ketika tombol Plus diklik, tambahkan qty dan perbarui subtotal
            $('#btnPlus').on('click', function (e) {
                e.preventDefault();
                $('#qty').val(parseInt($('#qty').val()) + 1);
                updateSubtotal();
            });
    
            // Ketika tombol Minus diklik, kurangkan qty dan perbarui subtotal
            $('#btnMinus').on('click', function (e) {
                e.preventDefault();
                if ($('#qty').val() > 0) {
                    $('#qty').val(parseInt($('#qty').val()) - 1);
                    updateSubtotal();
                }
            });
    
            // Fungsi untuk memperbarui subtotal
            function updateSubtotal() {
                var hargaSatuan = parseFloat($('#harga_satuan').val()) || 0;
                var qty = parseInt($('#qty').val()) || 0;
                var subtotal = hargaSatuan * qty;
    
                // Tampilkan subtotal
                $('#subtotal').text('Rp. ' + formatRupiah(subtotal));
    
                // Update input hidden 'subtotal'
                $('input[name="subtotal"]').val(subtotal);
            }
    
            // Fungsi untuk memformat angka ke dalam format rupiah
            function formatRupiah(angka) {
                var number_string = angka.toString();
                var split = number_string.split(',');
                var sisa = split[0].length % 3;
                var rupiah = split[0].substr(0, sisa);
                var ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
    
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah;
            }
        });
    </script>
    
    </body>
    
    </html>