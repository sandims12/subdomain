<footer class="footer mt-auto py-3 text-center border-top">
    <p class="mb-0">
        © {{ date('Y') }} Aplikasi Subdomain
    </p>
</footer>

<!-- Wajib: Bootstrap JS agar dropdown bisa berfungsi -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

<!-- Sweetalert -->
@include('sweetalert::alert')