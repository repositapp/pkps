<!-- Snackbar Notification (Popup Mirip Android) -->
<div id="snackbar"
    class="hidden fixed top-5 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-sm px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300 flex items-center gap-2">
    <i id="snackbar-icon" class=""></i>
    <span id="snackbar-message"></span>
</div>

<script type="text/javascript">
    // Tampilkan snackbar
    function showSnackbar(message, icon = 'las la-check-circle', bgColor = 'bg-green-600') {
        const snackbar = document.getElementById('snackbar');
        const snackbarIcon = document.getElementById('snackbar-icon');
        const snackbarMessage = document.getElementById('snackbar-message');

        snackbar.classList.remove('hidden', 'bg-green-600', 'bg-red-600', 'bg-blue-600');
        snackbar.classList.add(bgColor);
        snackbarIcon.className = icon;
        snackbarMessage.textContent = message;

        snackbar.classList.remove('hidden');

        setTimeout(() => {
            snackbar.classList.add('hidden');
        }, 5000);
    }

    // Cek session Laravel dan tampilkan notifikasi
    @if (session('success'))
        showSnackbar("{{ session('success') }}", "las la-check-circle", "bg-green-600");
    @endif

    @if (session('error'))
        showSnackbar("{{ session('error') }}", "las la-exclamation-circle", "bg-red-600");
    @endif

    // Tampilkan error validasi jika ada
    @if ($errors->any())
        showSnackbar("Periksa kembali data yang Anda masukkan.", "las la-exclamation-triangle", "bg-red-600");
    @endif

    // Tampilkan notifikasi login/logout otomatis jika dari route
    @if (request()->session()->has('login_success'))
        showSnackbar("Berhasil masuk!", "las la-sign-in-alt", "bg-blue-600");
    @endif

    @if (request()->session()->has('logout_success'))
        showSnackbar("Berhasil keluar!", "las la-sign-out-alt", "bg-gray-600");
    @endif
</script>
@stack('script')
