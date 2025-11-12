@extends('admin.layouts.wrapper')

@section('content')
    <h1>Data Subkategori</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol untuk menambah subkategori -->
    <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary mb-3">Tambah Subkategori</a>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Subkategori</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subcategories as $subcategory)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $subcategory->name }}</td>
                    <td>{{ $subcategory->category->name }}</td> <!-- Menampilkan kategori yang terkait -->
                    <td>
                        <a href="{{ route('admin.subcategories.edit', [$subcategory->category->id, $subcategory->id]) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.subcategories.destroy', [$subcategory->category->id, $subcategory->id]) }}" method="POST" style="display:inline;">
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
