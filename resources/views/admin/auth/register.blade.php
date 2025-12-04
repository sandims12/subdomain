<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | SEGALENGKO</title>

    <link rel="stylesheet" href="{{ asset('vendor/light/css/app-light.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
  </head>
  <body>

    <div class="auth-landscape">
      <!-- LEFT: Branding -->
      <div class="left-panel blue">
        <div class="brand-wrap">
          <img src="{{ asset('images/reang.png') }}" alt="Indramayu Reang" class="brand-reang">
          <h2 class="brand-title">SEGALENGKO</h2>
          <p class="brand-sub">Sistem Pengajuan Layanan Elektronik
          dan Gangguan Kominfo</p>
        </div>
        <div class="brand-footer">© {{ date('Y') }} Pemerintah Kabupaten Indramayu</div>
      </div>

      <!-- RIGHT: Form Register -->
      <div class="right-panel">
        <div class="form-wrapper">
          <div class="reg-header text-center">
            <img src="{{ asset('images/Lambang_Kabupaten_Indramayu.png') }}" alt="Logo" class="logo-circle">
            <h4>Daftar</h4>
            <p class="muted">SEGALENGKO</p>
          </div>

          <form action="{{ route('register') }}" method="post" novalidate>
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
              <div class="input-group simple">
                <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi" required>
                <button class="addon" type="button" id="togglePassword"><i class="fa fa-eye"></i></button>
              </div>
            </div>

            <div class="form-group mb-3">
              <label>Konfirmasi Password</label>
              <div class="input-group simple">
                <input type="password" class="form-control" id="confirmPassword" name="re_password" placeholder="Ulangi Kata Sandi" required>
                <button class="addon" type="button" id="toggleConfirmPassword"><i class="fa fa-eye"></i></button>
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

            <button class="btn-primary w-100" type="submit">Daftar</button>
            <p class="small-link mt-3 text-center">Sudah punya akun? <a href="/login">Login</a></p>
          </form>
        </div>
      </div>
    </div>

    <script>
      const togglePassword = document.querySelector('#togglePassword');
      const password = document.querySelector('#password');
      togglePassword.addEventListener('click', () => {
        password.type = password.type === 'password' ? 'text' : 'password';
        togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
      });

      const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
      const confirmPassword = document.querySelector('#confirmPassword');
      toggleConfirmPassword.addEventListener('click', () => {
        confirmPassword.type = confirmPassword.type === 'password' ? 'text' : 'password';
        toggleConfirmPassword.querySelector('i').classList.toggle('fa-eye-slash');
      });
    </script>
  </body>
</html>