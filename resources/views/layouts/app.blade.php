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

    @stack('style')
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script>
        window.addEventListener("scroll", function () {
            const navbar = document.querySelector(".navbar");
            const footer = document.querySelector("footer");
            const navbarBottom = navbar.getBoundingClientRect().bottom;
            const footerTop = footer.getBoundingClientRect().top;

            if (navbarBottom >= footerTop) {
                navbar.classList.add("force-responsive");
            } else {
                navbar.classList.remove("force-responsive");
            }
        });
    </script>
    @include('livewire.daftar-popout')
    <style>
        .user-menu {
            position: relative;
            display: flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }

        .user-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #F58B05;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            border: 2px solid black;
            transition: background-color 0.3s;
        }

        .user-menu:hover .user-icon,
        .user-menu.show .user-icon {
            background-color: #e07a00;
        }

        .user-dropdown {
            position: absolute;
            bottom: 110%;
            right: 0;
            background: white;
            border: 2px solid black;
            border-radius: 8px;
            box-shadow: 7px 7px black;
            min-width: 180px;
            z-index: 1100;
            display: none;
            flex-direction: column;
        }

        .user-dropdown.show {
            display: flex;
        }

        .user-dropdown a {
            padding: 10px 15px;
            color: black;
            text-decoration: none;
            border-bottom: 1px solid #ddd;
        }

        .user-dropdown a:last-child {
            border-bottom: none;
        }

        .user-dropdown a:hover {
            background-color: #F58B05;
            color: black;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar">
            <img src="{{ asset('img/logo-dwp.png') }}" alt="Logo" class="logo" onclick="toggleMenu()"/>
            <ul class="nav-menu" id="nav">
                <li><a href="{{ route('home') }}" class="nav-item">Halaman Utama</a></li>
                <li><a href="/#artikel" class="nav-item">Kegiatan</a></li>
                <li><a href="/#tentang-kami" class="nav-item">Tentang Kami</a></li>
                <li><a href="/bagian bita/guru.html" class="nav-item">Daftar Guru</a></li>
                <li>
                    <a href="#siswa" class="nav-item" onclick="toggleDropdownSiswa(event)">Siswa</a>
                    <div class="dropdown-menu" id="dropdownSiswa">
                        <a href="#">Nilai Siswa</a>
                        <a href="#">Status Gizi Siswa</a>
                    </div>
                </li>
                <li>
                    <a href="#guru" class="nav-item" onclick="toggleDropdownGuru(event)">Guru</a>
                    <div class="dropdown-menu" id="dropdownGuru">
                        <a href="../siswas" wire:navigate>Biodata Peserta Didik</a>
                        <a href="../penilaian siswa/penilaianSiswa.html">Nilai Peserta Didik</a>
                        <a href="../hitung zscore/zscore.html">Deteksi Stunting</a>
                        <a href="{{ route('artikel.index') }}">Kelola Kegiatan Instansi</a>
                        <a href="../akun ortu/crudortu.html">Kelola Akun</a>
                    </div>
                </li>
                {{-- Authentication Links --}}
                @auth
                <li>
                    <div class="user-menu" id="userMenu" tabindex="0" aria-label="User menu" onclick="toggleUserDropdown(event)">
                        <div class="user-icon" id="userIcon" title="User menu">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    </div>

                    <div class="user-dropdown" id="userDropdown" role="menu" aria-hidden="true">
                        <a href="#" class="user-name" tabindex="0">{{ Auth::user()->name }}</a>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <a href="#" onclick="this.closest('form').submit()" style="display: block; padding: 10px 15px; color: black; text-decoration: none;">
                                Logout
                            </a>
                        </form>

                    </div>
                </li>
                @endauth

                @guest
                <li><a href="{{ route('login') }}" class="nav-item">Login</a></li>
                <li><a href="{{ route('register') }}" class="nav-item">Register</a></li>
                @endguest
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('templates.footer')
    </footer>

    @stack('script')
</body>
</html>

