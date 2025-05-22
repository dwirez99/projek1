<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@700&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>   


    {{-- @include('livewire.daftar-popout') --}}
    {{-- @include('templates.navbar') --}}
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('style')

</head>

<body class="d-flex flex-column min-vh-100">
    <header>
        @include('templates.navbar')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('templates.footer')
    </footer>

    {{-- Tambahkan script JS jika perlu --}}
    <script>
        function toggleUserDropdown(event) {
            event.stopPropagation(); // Prevent closing immediately

            const dropdown = document.getElementById('userDropdown');
            const userMenu = document.getElementById('userMenu');

            // Toggle the .show class
            dropdown.classList.toggle('show');
            userMenu.classList.toggle('show');
        }

        // Close the dropdown if clicked outside
        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById('userDropdown');
            const userMenu = document.getElementById('userMenu');

            if (!userMenu.contains(event.target)) {
                dropdown.classList.remove('show');
                userMenu.classList.remove('show');
            }
        });



    </script>

</body>
</html>

