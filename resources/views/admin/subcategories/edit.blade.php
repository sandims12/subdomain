@extends('admin.layouts.wrapper')

@section('content')
    <h1>Edit Subkategori</h1>

    <form action="{{ route('admin.subcategories.update', [$category->id, $subcategory->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Subkategori</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $subcategory->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success mt-3">Perbarui</button>
    </form>
@endsection
