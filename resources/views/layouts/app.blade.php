<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@700&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    
    @stack('style')

    <script src="{{asset('js/navbar.js')}}"></script>

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
</head>
<body>
  <nav>
    <div class="navbar">
      <img
        src="{{ asset('img/logo-dwp.png') }}" alt="Logo" class="logo" onclick="toggleMenu()"/>
      <ul class="nav-menu" id="nav">
        <li>
          <a href="/" class="nav-item" wire:navigate>Halaman Utama</a>
        </li>
        <li>
          <a href="/#artikel" class="nav-item">Kegiatan</a>
        </li>
        <li>
          <a href="/#tentang-kami" class="nav-item">Tentang Kami</a>
        </li>
        <li>
          <a href="/bagian bita/guru.html" class="nav-item">Daftar Guru</a>
        </li>
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
            <a href="/artikels" wire:navigate>Kelola Kegiatan Instansi</a>
            <a href="../akun ortu/crudortu.html">Kelola Akun</a>
          </div>
        </li>
      </ul>
  </div>
  </nav>
    


        <main>
            @yield('content')
        </main>

        <footer>
            @include('templates.footer')
        </footer>

    
    {{-- Tambahkan script JS jika perlu --}}
</body>
</html>
