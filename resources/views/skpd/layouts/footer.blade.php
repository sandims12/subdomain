<footer class="text-center py-3 skpd-footer text-white">
    <small>© {{ date('Y') }} SEGALENGKO INDRAMAYU</small>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript untuk Sidebar Toggle -->
    <script>
        // Ambil elemen tombol dan sidebar
        const sidebar = document.getElementById("sidebar");
        const toggleButton = document.getElementById("sidebar-toggle");

        // Tambahkan event listener untuk tombol toggle
        toggleButton.addEventListener("click", function() {
            sidebar.classList.toggle("closed");
        });
    </script>
</footer>
