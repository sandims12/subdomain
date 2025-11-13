@extends('admin.layouts.wrapper')

@section('content')
    <h1>Daftar Kategori</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Tambah Kategori</a>

    <!-- Tabel Kategori -->
    <table id="categoriesTable" class="table table-striped mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <!-- Menambahkan DataTables JS dan CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#categoriesTable').DataTable({
                "order": [[1, 'asc']], // Penyortiran default berdasarkan kolom 1 (Nama Kategori) secara ascending
                "columnDefs": [
                    { "orderable": true, "targets": 1 },  // Mengizinkan penyortiran di kolom Nama Kategori
                    { "orderable": false, "targets": 0 }, // Tidak bisa diurutkan di kolom nomor (#)
                    { "orderable": false, "targets": 2 }, // Tidak bisa diurutkan di kolom Aksi
                ]
            });
        });
    </script>
@endsection
