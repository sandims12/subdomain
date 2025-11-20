@extends('admin.layouts.wrapper')

@section('content')
    <h1>Edit Subkategori</h1>

    <form action="{{ route('admin.subcategories.update', $subcategory) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="category_id">Kategori</label>
            <select id="category_id"
                    name="category_id"
                    class="form-control @error('category_id') is-invalid @enderror"
                    required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('category_id', $subcategory->category_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="name">Nama Subkategori</label>
            <input type="text"
                   id="name"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $subcategory->name) }}"
                   required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success mt-3">Perbarui</button>
        <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
@endsection
