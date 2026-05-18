<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MEX Berlian Dirgantara</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Tambahkan link font/AOS di sini -->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    </head>

    <body class=" font-poppins antialiased ">
        <div class="w-full overflow-x-hidden relative">

            @include('layouts.navigation-cust')

            <main class="pt-20 mx-auto w-full items-center px-4 lg:px-14">
                <!-- Konten welcome.blade.php akan masuk ke sini -->
                @yield('content')
            </main>

            <!-- Panggil footer customer Anda -->
            @include('components.footer-cust')
        </div>
        <!-- Panggil navigasi customer Anda -->

    </body>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Inisialisasi AOS (Script Pemicu) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                once: true,              // Animasi hanya berjalan 1 kali (tidak ngulang kalau di-scroll ke atas lagi)
                offset: 80,              // Jarak dari bawah layar sebelum animasi dimulai (pixel)
                duration: 800,           // Durasi waktu animasi (0.8 detik)
                easing: 'ease-out-cubic' // Transisi animasi yang halus
            });
        });
    </script>


</html>