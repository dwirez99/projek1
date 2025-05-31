@stack('script')
<script src="{{ asset('js/navbar.js') }}"></script>
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
    {{-- @include('livewire.daftar-popout') --}}
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

<nav class="navbar">
    <img src="{{ asset('img/logo-dwp.png') }}" alt="Logo" class="logo" onclick="toggleMenu()"/>
    <ul class="nav-menu" id="nav">
        <li><a href="{{ route('home') }}" class="nav-item">Halaman Utama</a></li>
        <li><a href="/kegiatan" wire:navigate class="nav-item">Kegiatan</a></li>
        <li><a href="{{ route('home') }}#about" class="nav-item">Tentang Kami</a></li>
        <li><a href="{{ route('guru.index') }}" class="nav-item">Daftar Guru</a></li>
        @role('orangtua')
        <li>
            <a href="#siswa" class="nav-item" onclick="toggleDropdownSiswa(event)">Siswa</a>
            <div class="dropdown-menu" id="dropdownSiswa">
                <a href="{{ route('orangtua.anak') }}">Nilai Siswa</a>
                <a href="{{ route('statusOrtu.index') }}">Status Gizi Siswa</a>
            </div>
        </li>
        @endrole
        @role('guru')
        <li>
            <a href="#guru" class="nav-item" onclick="toggleDropdownGuru(event)">Guru</a>
            <div class="dropdown-menu" id="dropdownGuru">
                <a href="{{ route('pesertadidik.index') }}" wire:navigate>Kelola Peserta Didik</a>
                <a href="{{ route('orangtua.index') }}">Kelola Wali Murid</a>
                <a href=" {{ route('statusgizi.index') }} ">Deteksi Stunting</a>
                <a href="{{ route('artikel.index') }}">Kelola Kegiatan Instansi</a>
            </div>
        </li>
        @endrole
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
                @role('orangtua')
                <form method="GET" action="{{ route('orangtuas.profiles') }}" style="margin: 0;">
                <a href="#" onclick="this.closest('form').submit()" style="display: block; padding: 10px 15px; color: black; text-decoration: none;">
                    User Profile
                </a>
                </form>
                @endrole
            </div>
        </li>
        @endauth

{{-- Panggil navbar dari folder template --}}

{{-- <div class="content">
@yield('content')
</div> --}}
        @guest
        <li><a href="{{ route('login') }}" class="nav-item">Login</a></li>
        {{-- <li><a href="{{ route('register') }}" class="nav-item">Register</a></li> --}}
        @endguest
    </ul>
</nav>


