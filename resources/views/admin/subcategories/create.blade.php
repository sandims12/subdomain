@extends('admin.layouts.wrapper')

@section('content')
    <h1>Tambah Subkategori</h1>

    <form action="{{ route('admin.subcategories.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="category_id">Pilih Kategori</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="name">Nama Subkategori</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success mt-4">Simpan Subkategori</button>
    </form>
@endsection
