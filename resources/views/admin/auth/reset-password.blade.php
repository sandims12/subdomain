<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Reset Password | SKPD Indramayu</title>
  <link rel="stylesheet" href="{{ asset('vendor/light/css/app-light.css') }}">
  <style>
    body {
      background: linear-gradient(135deg, #0d6efd, #007bff);
      font-family: 'Poppins', sans-serif;
    }
    .card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      padding: 2.5rem;
    }
  </style>
</head>
<body>
  <div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-4 card text-center">
      <img src="{{ asset('images/Lambang_Kabupaten_Indramayu.png') }}" width="80" class="mb-3">
      <h4 class="fw-bold text-primary mb-3">Buat Password Baru</h4>

      <form action="{{ route('password.update') }}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ request()->token }}">
        <input type="hidden" name="email" value="{{ request()->email }}">

        <div class="form-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password Baru">
        </div>
        <div class="form-group mb-3">
          <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password">
        </div>
        <button class="btn btn-primary w-100" type="submit">Simpan Password</button>
        <p class="mt-3"><a href="/login" class="text-primary small">Kembali ke Login</a></p>
      </form>
    </div>
  </div>
</body>
</html>
