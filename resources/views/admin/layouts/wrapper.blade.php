<!DOCTYPE html>
<html lang="id">
@include('admin.layouts.head')
<body style="background-color: #f8f9fa;">

    <div class="d-flex">
        {{-- Sidebar kiri --}}
        @include('admin.layouts.sidebar')

        {{-- Konten utama --}}
        <div class="flex-grow-1" style="margin-left: 250px; padding: 20px;">
            @include('admin.layouts.content')
        </div>
    </div>

    @include('admin.layouts.footer')
</body>
</html>
