<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@700&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    
    <script>
        window.addEventListener("scroll", function () {
            const navbar = document.querySelector(".navbar");
            const footer = document.querySelector("footer");
            const navbarBottom = navbar.getBoundingClientRect().bottom;
            const footerTop = footer.getBoundingClientRect().top;
    
            // Jika bawah navbar melewati atas footer
            if (navbarBottom >= footerTop) {
                navbar.classList.add("force-responsive");
            } else {
                navbar.classList.remove("force-responsive");
            }
        });
    </script>

    @include('templates.navbar')
</head>
<body>

    {{-- Panggil navbar dari folder template --}}

    <div class="content">
        @yield('content')
    </div>

    
    {{-- Tambahkan script JS jika perlu --}}
</body>
@include('templates.footer')
</html>
