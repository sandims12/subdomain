<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Aplikasi Subdomain</title>

<style>
/* ======================== */
/* 🔵 TOPBAR ADMIN STYLING  */
/* ======================== */

.admin-topbar {
    position: fixed;
    top: 16px;
    right: 20px;
    z-index: 2000;
}

.admin-profile-btn {
    background: rgba(255, 255, 255, 0.95);
    border: none;
    transition: 0.25s ease-in-out;
    border-radius: 40px;
}

.admin-profile-btn:hover {
    background: #ffffff;
    transform: translateY(-2px);
}

/* ======================== */
/* 🔵 DROPDOWN ADMIN CARD   */
/* ======================== */

.dropdown-menu {
    margin-top: 12px;
    min-width: 280px !important;
    padding: 20px !important;
    border-radius: 18px !important;
    background: #ffffff;
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    backdrop-filter: blur(6px);
    z-index: 3000 !important;

    /* Animasi smooth */
    animation: fadeIn 0.25s ease-out;
}

.dropdown-item {
    border-radius: 10px;
    padding: 10px 14px;
}

.dropdown-item:hover {
    background: #f0f4ff !important;
    color: #0d6efd !important;
}

/* Fade-in animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ======================== */
/* 🔵 NAVIGATION SIDEBAR     */
/* ======================== */

.nav-link:hover {
    background-color: #0d6efd;
    color: white !important;
    border-radius: 8px;
}

.nav-link.active {
    background-color: #0d6efd !important;
    color: white !important;
}

</style>

<!-- Vendor CSS -->
<link rel="stylesheet" href="{{ asset('vendor/light/css/simplebar.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/light/css/feather.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/light/css/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/light/css/app-light.css') }}" id="lightTheme">
<link rel="stylesheet" href="{{ asset('vendor/light/css/app-dark.css') }}" id="darkTheme" disabled>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
