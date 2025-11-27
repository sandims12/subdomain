<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Reset Password | Admin Indramayu</title>
  <link rel="stylesheet" href="{{ asset('vendor/light/css/app-light.css') }}">
  <style>
    body {
      background: linear-gradient(145deg, #007bff, #0056b3);
      font-family: 'Poppins', sans-serif;
    }
    .card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
      padding: 2.5rem;
    }
  </style>
</head>
<body>
  <div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-4 card text-center">
      <img src="{{ asset('images/Lambang_Kabupaten_Indramayu.png') }}" width="80" alt="Logo" class="mb-3">
      <h4 class="text-primary fw-bold">Buat Password Baru</h4>

      <form method="POST" action="{{ route('admin.password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password Baru" required>
        </div>
        <div class="mb-3">
          <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
      </form>
    </div>
  </div>
</body>
</html>
