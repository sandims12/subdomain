<!DOCTYPE html>
<html lang="id">
@include('skpd.layouts.head')

<body style="background-color: #f8f9fa; overflow-x:hidden;">
    {{-- Tombol toggle sidebar --}}
    <button id="sidebar-toggle" class="position-fixed top-0 start-0 mt-3 ms-3 btn btn-light shadow-sm rounded-circle"
            style="z-index: 2000; width: 42px; height: 42px;">
        <i class="bi bi-list fs-5"></i>
    </button>

    <div class="wrapper d-flex">
        {{-- Sidebar kiri --}}
        @include('skpd.layouts.sidebar')

        {{-- Konten utama --}}
        <div id="pageContent" class="flex-grow-1 skpd-page-inner" style="position: relative; transition: all 0.35s ease; margin-left:250px;">

            {{-- Floating Profil --}}
            <div class="floating-profile-card shadow-lg" id="profileCard">
                <div class="profile-header text-center">
                    

                    <h5 class="fw-semibold mt-2 mb-0">{{ Auth::user()->name ?? 'Nama Pengguna' }}</h5>
                    <p class="text-muted small mb-1">{{ Auth::user()->email ?? 'Email tidak tersedia' }}</p>
                    <span class="badge bg-primary px-3 py-1">{{ Auth::user()->role ?? 'SKPD' }}</span>
                </div>

                <div class="profile-actions mt-3 text-center">
                    <button class="btn btn-outline-primary btn-sm px-3 mb-2"
                            data-bs-toggle="modal" data-bs-target="#editNameModal">
                        <i class="bi bi-pencil-square me-1"></i> Ubah Nama
                    </button>
                    <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm px-3">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </div>
            </div>

            {{-- Tombol profil kecil --}}
            <button class="profile-float-btn btn btn-light shadow-sm" id="toggleProfile">
                <img id="miniProfile"
                     src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'User') . '&background=0d6efd&color=fff&size=64' }}"
                     class="rounded-circle"
                     alt="Mini Profil" width="36" height="36">
            </button>

            {{-- Isi halaman --}}
            <div class="flex-grow-1 skpd-main-content">
                @include('skpd.layouts.content')
            </div>

            @include('skpd.layouts.footer')
        </div>
    </div>

    {{-- Modal ubah nama --}}
    <div class="modal fade" id="editNameModal" tabindex="-1" aria-labelledby="editNameModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-person-lines-fill me-2"></i>Ubah Nama Pengguna</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('user.updateName') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label for="newName" class="form-label">Nama Baru</label>
                        <input type="text" class="form-control" id="newName"
                               name="name" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Sidebar dan konten responsif */
        #sidebar {
            transition: all 0.3s ease;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 1000;
        }

        .sidebar-collapsed #sidebar {
            left: -250px !important;
        }

        .sidebar-collapsed #pageContent {
            margin-left: 0 !important;
        }

        #pageContent {
            transition: margin-left 0.35s ease;
        }

        /* Profil floating */
        .floating-profile-card {
            position: fixed;
            top: 100px;
            right: 40px;
            width: 280px;
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            z-index: 1200;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.35s ease;
            pointer-events: none;
        }

        .floating-profile-card.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .profile-header { text-align: center; }

        .profile-photo-wrapper { position: relative; display: inline-block; }

        .profile-photo {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
        }

        .upload-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #0d6efd;
            color: #fff;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            cursor: pointer;
            border: 2px solid #fff;
        }

        .profile-actions .btn { width: 85%; }

        .profile-float-btn {
            position: fixed;
            top: 16px;
            right: 16px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            z-index: 1300;
            padding: 0;
        }

        .profile-float-btn img {
            border: 2px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            #pageContent { margin-left: 0 !important; }
            .floating-profile-card {
                width: 90%;
                right: 5%;
                top: 80px;
            }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById("sidebar");
            const toggleSidebar = document.getElementById("sidebar-toggle");
            const pageContent = document.getElementById("pageContent");

            toggleSidebar.addEventListener("click", () => {
                document.body.classList.toggle("sidebar-collapsed");
            });

            const toggleBtn = document.getElementById("toggleProfile");
            const profileCard = document.getElementById("profileCard");
            const uploadPhoto = document.getElementById("uploadPhoto");
            const profilePhotoMain = document.getElementById("profilePhotoMain");
            const miniProfile = document.getElementById("miniProfile");

            toggleBtn.addEventListener("click", () => {
                profileCard.classList.toggle("show");
            });

            document.addEventListener("click", (e) => {
                if (!profileCard.contains(e.target) && !toggleBtn.contains(e.target)) {
                    profileCard.classList.remove("show");
                }
            });

            uploadPhoto.addEventListener("change", (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        profilePhotoMain.src = e.target.result;
                        miniProfile.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>
</html>