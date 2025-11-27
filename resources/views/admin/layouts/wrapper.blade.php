<!DOCTYPE html>
<html lang="id">
@include('admin.layouts.head')

<body style="background-color: #f8f9fa;">

    {{-- TOPBAR PROFILE --}}
    <div class="admin-topbar d-flex justify-content-end align-items-center">
        <div class="dropdown">
            <button
                class="btn btn-light d-flex align-items-center rounded-pill px-3 py-2 shadow-sm admin-profile-btn"
                type="button"
                id="adminProfileDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                
                <strong>{{ Auth::user()->name ?? 'Admin' }}</strong>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-3"
    aria-labelledby="adminProfileDropdown"
    style="min-width: 280px; border-radius: 18px;">

    <li class="text-center">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=0d6efd&color=fff&size=80"
             class="rounded-circle shadow mb-2">

        <h5 class="fw-bold text-dark mb-0">{{ Auth::user()->name }}</h5>
        <p class="text-muted small mb-1">{{ Auth::user()->email }}</p>

        <span class="badge px-3 py-2"
              style="background:#e8f0ff; color:#0d6efd; border-radius:10px; font-weight:600;">
            {{ Auth::user()->role ?? 'admin' }}
        </span>
    </li>

    <li><hr class="dropdown-divider my-3"></li>

    <li>
        <a class="dropdown-item text-center fw-bold text-danger py-2"
           style="border-radius: 10px; background: #ffecec;"
           href="{{ route('logout') }}">
            Logout
        </a>
    </li>
</ul>

        </div>
    </div>

    <div class="d-flex">
        @include('admin.layouts.sidebar')

        <div class="flex-grow-1 mt-5 pt-3" style="margin-left: 250px; padding: 20px;">
            @include('admin.layouts.content')
        </div>
    </div>

    @include('admin.layouts.footer')

</body>
</html>