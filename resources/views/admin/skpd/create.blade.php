@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4">Tambah SKPD</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.skpd.store') }}" method="POST">
                @csrf

                {{-- Pilihan Kedinasan --}}
<div class="mb-3">
    <label class="form-label">Kedinasan</label>
    <select name="kedinasan" class="form-control" required>
        <option value="">-- Pilih Kedinasan --</option>
        @foreach ($kedinasan as $kd)
            <option value="{{ $kd }}" {{ old('kedinasan') == $kd ? 'selected' : '' }}>
                {{ $kd }}
            </option>
        @endforeach
    </select>
    @error('kedinasan')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


                <div class="mb-3">
                    <label class="form-label">Nama SKPD</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.skpd.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
