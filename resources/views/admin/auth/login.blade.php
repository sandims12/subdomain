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

    <!-- LANDSCAPE SPLIT (kiri biru, kanan form) -->
    <div class="auth-landscape">

      <!-- LEFT BLUE PANEL -->
      <div class="left-panel blue">
  <div class="brand-wrap">
    <!-- Logo Reang di atas, lebih besar -->
    <img src="{{ asset('images/reang.png') }}" alt="Indramayu Reang" class="brand-reang">

    <h2 class="brand-title">APLIKASI PENGAJUAN<br>SUBDOMAIN</h2>

    <!-- Subjudul 2 baris sesuai permintaan -->
    <p class="brand-sub">
      Satuan Kerja Perangkat Daerah<br>
      Kabupaten Indramayu
    </p>
  </div>

  <div class="brand-footer">© {{ date('Y') }} Pemerintah Kabupaten Indramayu</div>
</div>



      <!-- RIGHT WHITE PANEL (FORM LOGIN – tetap logic/field lama) -->
      <div class="right-panel">
        <div class="form-wrapper">

          <div class="login-header text-center">
            <img src="{{ asset('images/Lambang_Kabupaten_Indramayu.png') }}" alt="Logo" class="logo-circle">
            <h4>LOGIN SKPD</h4>
          </div>

          {{-- Error captcha --}}
          @if(session('captcha_error'))
            <div class="alert alert-danger py-2">{{ session('captcha_error') }}</div>
          @endif
          {{-- Error email/password --}}
          @if(session()->has('loginError'))
            <div class="alert alert-danger py-2 text-center">{{ session('loginError') }}</div>
          @endif

          <form action="{{ url('/login') }}" method="POST" id="loginForm">
            @csrf

            <input type="email" class="form-control" name="email" placeholder="Email" required>

            <div class="password-wrapper">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
              <i class="fa-solid fa-eye" id="togglePassword"></i>
            </div>

            <div class="captcha-box" id="captchaText"></div>
            <button type="button" class="refresh-btn" id="refreshCaptcha">Ganti Kode</button>
            <input type="text" id="captchaInput" class="form-control mt-2" placeholder="Masukkan kode di atas" required>

            <button class="btn-login" type="submit">Masuk</button>
            <p class="small-link"><a href="/forgot-password">Lupa Password?</a></p>
            <p class="small-link mt-3">Belum punya akun? <a href="/register">Daftar</a></p>
            
          </form>
        </div>
      </div>

    </div>

    <script>
      // Captcha
      function generateCaptcha() {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
        let captcha = '';
        for (let i = 0; i < 6; i++) captcha += chars.charAt(Math.floor(Math.random() * chars.length));
        sessionStorage.setItem('captcha_code', captcha);
        document.getElementById('captchaText').textContent = captcha;
      }
      document.getElementById('loginForm').addEventListener('submit', function(e) {
        const input = document.getElementById('captchaInput').value.trim();
        const code = sessionStorage.getItem('captcha_code');
        if (input !== code) { e.preventDefault(); alert('⚠️ Captcha salah, silakan ulangi.'); generateCaptcha(); }
      });
      document.getElementById('refreshCaptcha').addEventListener('click', generateCaptcha);

      // Toggle password
      document.getElementById('togglePassword').addEventListener('click', function () {
        const el = document.getElementById('password');
        el.type = el.type === 'password' ? 'text' : 'password';
        this.classList.toggle('fa-eye-slash');
      });

      window.onload = generateCaptcha;
    </script>

    @include('sweetalert::alert')
  </body>
</html>
