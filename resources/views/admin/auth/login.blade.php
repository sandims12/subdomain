<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login | SKPD Kabupaten Indramayu</title>

    <link rel="stylesheet" href="{{ asset('vendor/light/css/app-light.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  </head>
  <body>
    <div class="login-card text-center">
      <div class="login-header">
        <img src="{{ asset('images/Lambang_Kabupaten_Indramayu.png') }}" alt="Logo Indramayu">
        <h5>LOGIN SKPD</h5>
        <h4>Satuan Kerja Perangkat Daerah</h4>
        <p>Kabupaten Indramayu</p>
      </div>

      {{-- 🔴 Pesan error captcha --}}
      @if(session('captcha_error'))
        <div class="alert alert-danger py-2">
          {{ session('captcha_error') }}
        </div>
      @endif

      {{-- 🔴 Pesan error email/password --}}
      @if(session()->has('loginError'))
        <div class="alert alert-danger py-2 text-center">
          {{ session('loginError') }}
        </div>
      @endif

      <form action="{{ url('/login') }}" method="POST" id="loginForm">
        @csrf
        <div class="form-group mb-3">
          <input type="email" class="form-control form-control-lg" name="email" placeholder="Masukkan Email" required>
        </div>

        <div class="form-group mb-3 password-wrapper">
          <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Masukkan Password" required>
          <i class="fa-solid fa-eye" id="togglePassword"></i>
        </div>

        {{-- ✅ CAPTCHA --}}
        <div class="form-group mb-3">
          <div class="captcha-box mb-2" id="captchaText"></div>
          <button type="button" class="refresh-btn" id="refreshCaptcha">🔄 Ganti Kode</button>
          <input type="text" id="captchaInput" class="form-control mt-2" placeholder="Masukkan kode di atas" required>
          <small class="text-muted">Masukkan huruf & angka sesuai gambar di atas</small>
        </div>

        <button class="btn btn-lg btn-primary w-100 mt-2" type="submit">Masuk</button>

        <p class="small-link mt-3 mb-1">Belum punya akun? <a href="/register">Daftar</a></p>
        <p class="small-link"><a href="/forgot-password">Lupa Password?</a></p>
      </form>
    </div>

    <script>
      // 🔠 Generate Captcha (Frontend)
      function generateCaptcha() {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
        let captcha = '';
        for (let i = 0; i < 6; i++) {
          captcha += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        sessionStorage.setItem('captcha_code', captcha);
        document.getElementById('captchaText').textContent = captcha;
      }

      // 🔍 Validasi Captcha
      document.getElementById('loginForm').addEventListener('submit', function(event) {
        const input = document.getElementById('captchaInput').value.trim();
        const code = sessionStorage.getItem('captcha_code');
        if (input !== code) {
          event.preventDefault();
          alert('⚠️ Captcha salah, silakan ulangi.');
          generateCaptcha();
        }
      });

      // 🔄 Tombol refresh captcha
      document.getElementById('refreshCaptcha').addEventListener('click', function() {
        generateCaptcha();
      });

      // 👁️ Toggle Password Visibility
      document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
      });

      window.onload = generateCaptcha;
    </script>
    {{-- SweetAlert Include --}}
    @include('sweetalert::alert')

  </body>
</html>
