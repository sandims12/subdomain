@extends('admin.layouts.wrapper')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4">Edit Subdomain</h3>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.subdomain.update', $subdomain->id) }}" method="POST" class="card p-4 border-0 shadow-sm rounded-4">
        @csrf
        @method('PUT')

        <div class="row g-3">
            {{-- NAMA SUBDOMAIN --}}
            <div class="col-md-6">
                <label for="nama_subdomain" class="form-label">Nama Subdomain</label>
                <input type="text"
                       class="form-control"
                       id="nama_subdomain"
                       name="nama_subdomain"
                       value="{{ old('nama_subdomain', $subdomain->nama_subdomain) }}"
                       required>
            </div>

            {{-- LINK --}}
            <div class="col-md-6">
                <label for="link" class="form-label">Link</label>
                <input type="url"
                       class="form-control"
                       id="link"
                       name="link"
                       placeholder="https://...."
                       value="{{ old('link', $subdomain->link) }}">
            </div>

            {{-- NAMA APLIKASI --}}
            <div class="col-md-6">
                <label class="form-label">Nama Aplikasi</label>
                <input type="text"
                       name="nama_aplikasi"
                       class="form-control"
                       value="{{ old('nama_aplikasi', $subdomain->nama_aplikasi) }}">
            </div>

            {{-- TAHUN PENGANGGARAN --}}
            <div class="col-md-3">
                <label class="form-label">Tahun Penganggaran</label>
                <input type="number"
                       name="tahun_penganggaran"
                       class="form-control"
                       value="{{ old('tahun_penganggaran', $subdomain->tahun_penganggaran) }}">
            </div>

            {{-- ANGGARAN --}}
            <div class="col-md-3">
                <label class="form-label">Anggaran</label>
                <select name="anggaran" class="form-select">
                    <option value="">-- Pilih Anggaran --</option>
                    <option value="lebih dari 1 milyar"
                        {{ old('anggaran', $subdomain->anggaran) == 'lebih dari 1 milyar' ? 'selected' : '' }}>
                        lebih dari 1 milyar
                    </option>
                    <option value="lebih dari 500 juta < 1 milyar"
                        {{ old('anggaran', $subdomain->anggaran) == 'lebih dari 500 juta < 1 milyar' ? 'selected' : '' }}>
                        lebih dari 500 juta &lt; 1 milyar
                    </option>
                    <option value="lebih dari 100 juta < 500 juta"
                        {{ old('anggaran', $subdomain->anggaran) == 'lebih dari 100 juta < 500 juta' ? 'selected' : '' }}>
                        lebih dari 100 juta &lt; 500 juta
                    </option>
                    <option value="kurang dari 100 juta"
                        {{ old('anggaran', $subdomain->anggaran) == 'kurang dari 100 juta' ? 'selected' : '' }}>
                        kurang dari 100 juta
                    </option>
                </select>
            </div>

            {{-- SIFAT APLIKASI --}}
            <div class="col-md-4">
                <label class="form-label">Sifat Aplikasi</label>
                <select name="sifat" class="form-select">
                    <option value="">-- Pilih --</option>
                    <option value="Online"  {{ old('sifat', $subdomain->sifat) == 'Online'  ? 'selected' : '' }}>Online</option>
                    <option value="Offline" {{ old('sifat', $subdomain->sifat) == 'Offline' ? 'selected' : '' }}>Offline</option>
                </select>
            </div>

            {{-- LAYANAN --}}
            <div class="col-md-8">
                <label class="form-label">Dimanfaatkan Untuk Layanan</label>
                <input type="text"
                       name="layanan"
                       class="form-control"
                       value="{{ old('layanan', $subdomain->layanan) }}">
            </div>

            {{-- PLATFORM OS --}}
            <div class="col-md-4">
                <label class="form-label">Platform OS</label>
                <select name="platform_os" class="form-select">
                    <option value="">-- Pilih --</option>
                    @foreach (['Windows','Linux','MacOS','Web Base'] as $os)
                        <option value="{{ $os }}" {{ old('platform_os', $subdomain->platform_os) == $os ? 'selected' : '' }}>
                            {{ $os }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- JENIS APLIKASI --}}
            <div class="col-md-4">
                <label class="form-label">Jenis Aplikasi</label>
                <select name="jenis_aplikasi" class="form-select">
                    <option value="">-- Pilih --</option>
                    @foreach (['Desktop Client-Server','Web Base','Mobile App'] as $jenis)
                        <option value="{{ $jenis }}" {{ old('jenis_aplikasi', $subdomain->jenis_aplikasi) == $jenis ? 'selected' : '' }}>
                            {{ $jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- DATABASE --}}
            <div class="col-md-4">
                <label class="form-label">Database Engine</label>
                <select name="database_engine" class="form-select">
                    <option value="">-- Pilih --</option>
                    @foreach (['Mysql','PostgreSQL','SQL Server','Oracle'] as $db)
                        <option value="{{ $db }}" {{ old('database_engine', $subdomain->database_engine) == $db ? 'selected' : '' }}>
                            {{ $db }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- BAHASA PEMROGRAMAN --}}
            <div class="col-md-4">
                <label class="form-label">Bahasa Pemrograman</label>
                <select name="bahasa_pemrograman" class="form-select">
                    <option value="">-- Pilih --</option>
                    @foreach (['PHP','Java','Python','Javascript','.NET'] as $lang)
                        <option value="{{ $lang }}" {{ old('bahasa_pemrograman', $subdomain->bahasa_pemrograman) == $lang ? 'selected' : '' }}>
                            {{ $lang }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- STATUS APLIKASI --}}
            <div class="col-md-4">
                <label class="form-label">Status Aplikasi</label>
                <select name="status_aplikasi" class="form-select">
                    <option value="">Belum Ditetapkan</option>
                    <option value="aktif" {{ old('status_aplikasi', $subdomain->status_aplikasi) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak aktif" {{ old('status_aplikasi', $subdomain->status_aplikasi) == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            {{-- PENGELOLA --}}
            <div class="col-md-4">
                <label class="form-label">Pengelola</label>
                <input type="text"
                       name="pengelola"
                       class="form-control"
                       value="{{ old('pengelola', $subdomain->pengelola) }}">
            </div>

            {{-- KONDISI (sudah ada, tetap dipakai) --}}
            <div class="col-md-4">
                <label for="kondisi" class="form-label">Kondisi</label>
                <select name="kondisi" id="kondisi" class="form-select" required>
                    <option value="aktif"    {{ old('kondisi', $subdomain->kondisi) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('kondisi', $subdomain->kondisi) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="error"    {{ old('kondisi', $subdomain->kondisi) == 'error' ? 'selected' : '' }}>Error</option>
                </select>
            </div>

{{-- STATUS DOMAIN --}}
<div class="col-md-4">
    <label class="form-label">Status Domain</label>
    <select name="status" class="form-select">
        <option value="Aktif"
            {{ old('status', $subdomain->status) == 'Aktif' ? 'selected' : '' }}>
            Aktif
        </option>
        <option value="Tidak Aktif"
            {{ old('status', $subdomain->status) == 'Tidak Aktif' ? 'selected' : '' }}>
            Nonaktif
        </option>

        <option value="Pending"
            {{ old('status', $subdomain->status) == 'Pending' ? 'selected' : '' }}>
            Pending
        </option>
    </select>
</div>

        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-save"></i> Perbarui
            </button>
            <a href="{{ route('admin.subdomain.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
