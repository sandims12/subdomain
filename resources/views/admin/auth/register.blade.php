<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | SKPD Kabupaten Indramayu</title>
    <link rel="stylesheet" href="{{ asset('vendor/light/css/app-light.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
  </head>
  <body>
    <div class="container vh-100 d-flex align-items-start justify-content-center">
      <div class="col-md-6 register-card">
        <div class="text-center register-header mb-3">
          <img src="{{ asset('images/Lambang_Kabupaten_Indramayu.png') }}" alt="Logo">
          <h4 class="fw-bold text-primary mt-2">Daftar SKPD</h4>
          <p class="text-muted">Kabupaten Indramayu</p>
        </div>

        <form action="{{ route('register') }}" method="post">
          @csrf
          <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
          </div>
          <div class="form-group mb-3">
            <label>Nama SKPD</label>
            <input type="text" class="form-control" name="name" placeholder="Nama SKPD" required>
          </div>
          
          <div class="form-group mb-3">
            <label>Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi" required>
              <span class="input-group-text" id="togglePassword"><i class="fa fa-eye"></i></span>
            </div>
          </div>

          <div class="form-group mb-3">
            <label>Konfirmasi Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="confirmPassword" name="re_password" placeholder="Ulangi Kata Sandi" required>
              <span class="input-group-text" id="toggleConfirmPassword"><i class="fa fa-eye"></i></span>
            </div>
          </div>

          <div class="password-rules mb-3">
            <strong>Persyaratan Kata Sandi:</strong>
            <ul class="mb-0 mt-1">
              <li>Minimum 8 karakter</li>
              <li>Setidaknya satu karakter khusus</li>
              <li>Setidaknya satu angka</li>
              
            </ul>
          </div>

          <button class="btn btn-lg btn-primary w-100 mt-3" type="submit">Daftar</button>
          <p class="text-center mt-3">Sudah punya akun? <a href="/login" class="text-primary">Login</a></p>
        </form>
      </div>
    </div>

    <script>
      // Tampilkan / sembunyikan password
      const togglePassword = document.querySelector('#togglePassword');
      const password = document.querySelector('#password');
      togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye-slash');
      });

      const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
      const confirmPassword = document.querySelector('#confirmPassword');
      toggleConfirmPassword.addEventListener('click', function () {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye-slash');
      });
    </script>
  </body>
</html>
