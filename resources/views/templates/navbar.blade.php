<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script>
        function toggleMenu() {
        const nav = document.getElementById("nav");
        nav.classList.toggle("active");
        }


        document.addEventListener("click", function(e) {
        const siswaDropdown = document.getElementById("dropdownSiswa");
        const guruDropdown = document.getElementById("dropdownGuru");

        if (!e.target.closest("li")) {
            siswaDropdown.classList.remove("show");
            guruDropdown.classList.remove("show");
        }
        });

        function toggleDropdownSiswa(event) {
        event.preventDefault();
        document.getElementById("dropdownSiswa").classList.toggle("show");
        }

        function toggleDropdownGuru(event) {
        event.preventDefault();
        document.getElementById("dropdownGuru").classList.toggle("show");
        }
    </script>
    <style>
    ul {
        list-style: none;
    }

    .navbar {
    display: flex;
    background-color: white;    
    align-items: center;
    width: 1122px;
    height: 76px;
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    gap: 10px;
    margin-bottom: 76px;
    padding: 0 20px;
    border: 2px solid black;
    border-radius: 28px;
    box-shadow: 7px 7px black;
    }


    .navbar img {
        background-color: white;
        max-width: 64px;
        max-height: 64px;
    }

    .nav-menu {
        background-color: white;
        height: 64px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .nav-item {
        padding: 10px;
        background-color: white;
        color: #F58B05;
        text-decoration: none;
    }

    .nav-item.active {
        background-color: #F58B05;
        color: white;
        font-weight: bold;
        border: none;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }

    .nav-menu li {
        position: relative;
    }

    .navbar a:hover{
        background-color: #F58B05;
        color: black;
        border: 2px solid black;
        border-radius: 8px;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        bottom: 100%; /* dropdown muncul di atas tombol */
        left: 0;
        background: white;
        border: 2px solid black;
        box-shadow: 7px 7px black;
        border-radius: 5px;
        min-width: 200px;
        z-index: 1000;
        color: black;
    }

    .dropdown-menu a {
        display: block;
        padding: 10px 15px;
        color: black;
        text-decoration: none;
    }

    .dropdown-menu a:hover {
        background: #F58B05;
    }

    .show {
        display: block;
    }

    @media (max-width: 1200px) {
        .dropdown-menu {
            position: static;
            box-shadow: none;
            border-radius: 5px;
            background: white;
            min-width: 100%;
        }
        .dropdown-menu a {
            padding: 10px;
            border-top: 1px solid #444;
        }
    }

    @media (max-width: 1200px) {
    .navbar {
        flex-direction: column;
        height: auto;
        padding: 10px;
        max-width: 20%;
        margin-bottom: 10px;
      }
    
      .nav-menu {
        display: none;
        flex-direction: column;
        min-width: 200%;
        max-width: 200%;
        height: auto;
        margin-top: 10px;
        position: absolute;
        bottom: 80px; /* tampil di atas navbar */
        background-color: white;
        border: 2px solid black;
        border-radius: 28px;
        padding: 10px;
      }
    
      .nav-menu.active {
        display: flex;
        margin: auto;
      }

    .nav-item {
        padding: 10px;
        width: 100%;
        text-align: left;
    }

    .navbar img.logo {
        max-width: 48px;
        max-height: 48px;
    }

    .nav-menu {
        transition: max-height 0.3s ease;
        overflow: hidden;
    }
}

    </style>
</head>
<body>
    <div class="navbar">
        <img
          src="{{ asset('img/logo-dwp.png') }}" alt="Logo" class="logo" onclick="toggleMenu()"/>
        <ul class="nav-menu" id="nav">
          <li>
            <a href="../home/home.html#welcome-page" class="nav-item">Halaman Utama</a>
          </li>
          <li>
            <a href="../home/home.html#artikel" class="nav-item">Kegiatan</a>
          </li>
          <li>
            <a href="../home/home.html#tentang-kami" class="nav-item">Tentang Kami</a>
          </li>
          <li>
            <a href="../bagian bita/guru.html" class="nav-item">Daftar Guru</a>
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
              <a href="../biodata peserta didik/biodata.html">Biodata Peserta Didik</a>
              <a href="../penilaian siswa/penilaianSiswa.html">Nilai Peserta Didik</a>
              <a href="../hitung zscore/zscore.html">Deteksi Stunting</a>
              <a href="../artikel/kelolaartikel.html">Kelola Kegiatan Instansi</a>
              <a href="../akun ortu/crudortu.html">Kelola Akun</a>
            </div>
          </li>
        </ul>
        </div>
          
</body>
</html>