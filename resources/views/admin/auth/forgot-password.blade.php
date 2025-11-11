<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Lupa Password | SKPD Indramayu</title>
  <link rel="stylesheet" href="{{ asset('vendor/light/css/app-light.css') }}">
  <style>
    body {
      background: linear-gradient(145deg, #0d6efd, #007bff);
      font-family: 'Poppins', sans-serif;
    }
    .card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      padding: 2.5rem;
    }
  </style>
</head>
<body>
  <div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-4 card text-center">
      <img src="{{ asset('images/Lambang_Kabupaten_Indramayu.png') }}" width="80" alt="Logo" class="mb-3">
      <h4 class="text-primary fw-bold">Reset Password</h4>
      <p class="text-muted small mb-4">Masukkan email Anda untuk menerima tautan reset password</p>

      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Masukkan Email">
        </div>
        <button type="submit" class="btn btn-primary w-100">Kirim Tautan</button>
        <p class="mt-3"><a href="/login" class="text-primary small">Kembali ke Login</a></p>
      </form>
    </div>
  </div>
</body>
</html>
