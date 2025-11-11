<!DOCTYPE html>
<html lang="id">
@include('skpd.layouts.head')

<body style="background-color: #f8f9fa;">
    <div class="d-flex">
        {{-- Sidebar kiri --}}
        @include('skpd.layouts.sidebar')

        {{-- Konten utama --}}
        <div class="flex-grow-1 skpd-page-inner" style="position: relative;">

            {{-- Tombol Profil mengambang --}}
            <div class="skpd-topbar d-flex justify-content-end align-items-center">
                <div class="dropdown">
                    <button
                        class="btn btn-light d-flex align-items-center rounded-pill px-3 py-2 shadow-sm skpd-profile-btn"
                        type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=0d6efd&color=fff&size=32"
                             alt="Avatar" class="rounded-circle me-2">
                        <strong>{{ Auth::user()->name ?? 'Pengguna' }}</strong>
                    </button>

                    {{-- Dropdown Isi Profil --}}
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2"
                        aria-labelledby="profileDropdown" style="min-width: 250px;">
                        <li class="text-center p-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=0d6efd&color=fff&size=64"
                                 class="rounded-circle shadow-sm mb-2">
                            <h6 class="mb-0">{{ Auth::user()->name ?? 'Nama Tidak Ditemukan' }}</h6>
                            <small class="text-muted d-block">{{ Auth::user()->email ?? 'Email tidak tersedia' }}</small>
                            <span class="badge bg-primary mt-2 px-3 py-1">{{ Auth::user()->role ?? 'SKPD' }}</span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="text-center">
                            <button class="btn btn-sm btn-outline-primary mb-2"
                                    data-bs-toggle="modal" data-bs-target="#editNameModal">
                                <i class="bi bi-pencil-square"></i> Ubah Nama
                            </button>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger text-center fw-semibold"
                               href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Konten Halaman --}}
            <div class="flex-grow-1 skpd-main-content">
                @include('skpd.layouts.content')
            </div>

            @include('skpd.layouts.footer')
        </div>
    </div>

    {{-- Modal Edit Nama --}}
    <div class="modal fade" id="editNameModal" tabindex="-1"
         aria-labelledby="editNameModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editNameModalLabel">
                        <i class="bi bi-person-lines-fill me-2"></i>Ubah Nama Pengguna
                    </h5>
                    <button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.updateName') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="newName" class="form-label">Nama Baru</label>
                            <input type="text" class="form-control" id="newName"
                                   name="name" value="{{ Auth::user()->name }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- CSS khusus topbar profil --}}
    <style>
        .skpd-topbar {
            position: fixed;
            top: 16px;
            right: 10px;
            z-index: 1100;
        }

        .skpd-profile-btn {
            background: rgba(255, 255, 255, 0.95);
            border: none;
        }

        .skpd-profile-btn:hover {
            background: #ffffff;
        }

        @media (max-width: 991.98px) {
            .skpd-topbar {
                right: 16px;
                top: 12px;
            }
        }
    </style>

    {{-- Script untuk geser konten & sidebar saat toggle diklik --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar      = document.getElementById('sidebar');
            const toggleButton = document.getElementById('sidebar-toggle');
            const pageInner    = document.querySelector('.skpd-page-inner');
            const body         = document.body;

            if (!sidebar || !toggleButton || !pageInner) return;

            // posisi awal: sidebar terbuka
            let collapsed = false;
            sidebar.style.left        = '0px';
            pageInner.style.marginLeft = '250px';

            toggleButton.addEventListener('click', function () {
                collapsed = !collapsed;

                if (collapsed) {
                    // ===== TUTUP SIDEBAR =====
                    sidebar.style.left         = '-250px';  // geser ke kiri, keluar layar
                    pageInner.style.marginLeft = '0px';     // konten ke tengah penuh
                    body.classList.add('sidebar-collapsed');
                } else {
                    // ===== BUKA SIDEBAR =====
                    sidebar.style.left         = '0px';     // kembali nempel kiri
                    pageInner.style.marginLeft = '250px';   // konten mundur lagi
                    body.classList.remove('sidebar-collapsed');
                }
            });

             // --- ANIMASI PERPINDAHAN HALAMAN ---
            const mainContent = document.querySelector('.skpd-main-content');
            const navLinks    = document.querySelectorAll('.skpd-sidebar .nav-link');

            if (mainContent && navLinks.length) {
                navLinks.forEach(link => {
                    link.addEventListener('click', function (e) {
                        const href = this.getAttribute('href');

                        // kalau tidak ada href / link aktif / buka tab baru, biarkan default
                        if (!href ||
                            this.classList.contains('active') ||
                            this.getAttribute('target') === '_blank') {
                            return;
                        }

                        e.preventDefault(); // tahan dulu pindah halaman

                        // tambah kelas animasi keluar
                        mainContent.classList.add('skpd-page-leave');

                        // setelah animasi selesai, baru pindah halaman
                        setTimeout(() => {
                            window.location.href = href;
                        }, 250); // sama dengan durasi animasi leave (0.25s)
                    });
                });
            }
         });
    </script>
</body>
</html>
