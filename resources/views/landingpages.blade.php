<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


    <title>SIPENDIKAR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@700&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    @extends('layouts.app')
  </head>
  <body>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="{{ asset('build/assets/car1.png') }}" class="d-block w-100" alt="Slide 1">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('build/assets/car2.png') }}" class="d-block w-100" alt="Slide 2">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('build/assets/car3.png') }}" class="d-block w-100" alt="Slide 3">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <div>
        <h3 id="welcome">Selamat Datang</h3>
        <h1 id= 'name'>TK DHARMA WANITA LAMONG</h1>
        <p id="intro">
            TK Dharma Wanita Lamong adalah taman kanak-kanak swasta yang berdiri sejak tahun 1988 di Desa Lamong, Kecamatan Badas, Kabupaten Kediri, Jawa Timur. Dengan pengalaman lebih dari 30 tahun, TK ini menjadi tempat pertama anak-anak mengenal dunia belajar sambil bermain. Menggunakan Kurikulum Merdeka, TK Dharma Wanita Lamong menghadirkan suasana belajar yang menyenangkan, kreatif, dan membebaskan potensi anak-anak. Dipimpin oleh Ibu Siti Innamanasiroh dan berstatus terakreditasi B, sekolah ini berkomitmen membangun fondasi karakter, kemandirian, dan rasa ingin tahu anak sejak usia dini. Berlokasi di Jl. Glatik RT 03 RW 03, Dusun Lamong, TK ini siap menjadi tempat terbaik bagi generasi kecil untuk tumbuh, belajar, dan bermimpi lebih tinggi.
        </p>
      </div>

      <h4 id="tag">Kegiatan Kami </h4>
      <div class="section-kegiatan">
        <div class="container">
          <div class="row justify-content-center g-4">

            <div class="col-md-5">
              <div class="card card-custom h-100">
                <img src="{{ asset('build/assets/artikelkegiatan/artikel1.jpg') }}" class="card-img-top img-fixed" alt="Kegiatan 1" style="border-radius: 20px 20px 0 0;">
                <div class="card-body">
                  <h5 class="card-title">Menggambar bersama</h5>
                  <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla massa.</p>
                  <a href="#" class="text-dark text-decoration-underline fw-standar">Selengkapnya</a>
                </div>
              </div>
            </div>

            <div class="col-md-5">
              <div class="card card-custom h-100">
                <img src="{{ asset('build/assets/artikelkegiatan/artikel2.jpeg') }}" class="card-img-top img-fixed" alt="Kegiatan 2" style="border-radius: 20px 20px 0 0;">
                <div class="card-body">
                  <h5 class="card-title">Makan Bersama</h5>
                  <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla massa.</p>
                  <a href="#" class="text-dark text-decoration-underline fw-standar">Selengkapnya</a>

                </div>
              </div>
            </div>
          </div>
          <button class="btn-lihat">Lihat Semua Kegiatan</button>
        </div>
      </div>
      </div>
      {{-- Mulai Guru --}}
      <h4 id="tag">Profil Guru</h4>
      <div class="section-guru">
        <div class="container">
          <div class="row justify-content-center g-4">

            <div class="col-md-3">
                <div class="profile-card">
                    <div class="profile-header">
                        <img src="{{ asset('build/assets/fotoguru/takerusato.png') }}" class="card-img-top img-profil" alt="takeru sato" style="border-radius: 30px 10px 0 0;">
                        <div class="profile-name">Takeru Sato</div>
                        <div class="profile-title">Kepala Sekolah</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="profile-card">
                    <div class="profile-header">
                        <img src="{{ asset('build/assets/fotoguru/dankuruto.png') }}" class="card-img-top img-profil" alt="takeru sato" style="border-radius: 30px 10px 0 0;">
                        <div class="profile-name">Dan Kuruto</div>
                        <div class="profile-title">Guru</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="profile-card">
                    <div class="profile-header">
                        <img src="{{ asset('build/assets/fotoguru/eichiro_oda.png') }}" class="card-img-top img-profil" alt="takeru sato" style="border-radius: 30px 10px 0 0;">
                        <div class="profile-name">Eichiro Oda</div>
                        <div class="profile-title">Guru</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="profile-card">
                    <div class="profile-header">
                        <img src="{{ asset('build/assets/fotoguru/karl_marks.png') }}" class="card-img-top img-profil" alt="takeru sato" style="border-radius: 30px 10px 0 0;">
                        <div class="profile-name">Karl Marks</div>
                        <div class="profile-title">Guru</div>
                    </div>
                </div>
            </div>

          </div>
          <button class="btn-lihat">Lihat Semua Guru</button>
        </div>
      </div>
      {{-- Akhir Guru --}}
      {{-- Mulai Tentang Kami --}}
      <h4 id="tag">Tentang Kami</h4>
      <div class="section-about">
        <div class="container">
            <div class="row">
                <div class="col-2">
                  <img src="{{asset('build/assets/logo/GKL33_Dharma Wanita - Koleksilogo.com 3.png')}}" alt="LOGO DHARMA WANITA" style="width: 90%">
                </div>
                <div class="col-5">
                  <p id="intro">
                    Biro Organisasi Sekretariat Daerah Provinsi Jawa Timur didukung oleh tiga bagian yaitu Bagian Kelembagaan dan Analisis Jabatan, Bagian Reformasi Birokrasi dan Akuntablitas Kinerja, serta Bagian Tata Laksana. Masing-masing bagian terdapat sub bagian dan kelompok jabatan fungsional yang mendukung dalam kinerja di bidang tersebut. Sebagai wujud transaparansi informasi dalam menuju reformasi birokrasi, Biro Organisasi menyajikan berbagai layanan informasi baik terkait dengan kegiatan sehari-hari maupun layanan lain yang terkait dengan informasi pelayanan publik.
                  </p>
                </div>
          </div>
        </div>
      </div>
      {{-- Akhir Tentang kami --}}
      {{-- Awal Footer --}}
      <footer class="bg-warning text-dark pt-5 pb-3">
        <div class="container">
            <div class="row text-start">
                <div class="col-md-3 mb-4">
                    <img src="{{ asset('img/logo-dwp.png') }}" alt="Logo" class="mb-2" style="width: 60px;">
                    <h5 class="fw-bold mt-2">TK DW Lamong</h5>
                    <p class="small mb-0">&copy; 2025–2030 | All Rights Reserved</p>
                    <p class="small">Powered by projek1</p>
                </div>

                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold">Menu Utama</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-dark text-decoration-none">Home</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">About</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Blog</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Gallery</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Contact</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold">Akademik</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-dark text-decoration-none">Guru</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Siswa</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Pengumuman</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Kegiatan</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Download</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold">Hubungi Kami</h5>
                    <p class="mb-0">Alamat: Jln Glatik RT 03 RW 03</p>
                    <p class="mb-0">Desa Lamong, Pare Kediri</p>
                    <p class="mb-0">Email: <a href="mailto:tkdwlamongkediri@gmail.com" class="text-dark text-decoration-none">tkdwlamongkediri@gmail.com</a></p>
                    <p class="mb-0">Phone: 021-5725610</p>
                    <p class="mb-2">Fax: 021-5725610</p>
                    <div class="d-flex gap-3">
                        <a href="#"><img src="{{ asset('img/youtube.png') }}" alt="YouTube" width="24"></a>
                        <a href="#"><img src="{{ asset('img/facebook.png') }}" alt="Facebook" width="24"></a>
                        <a href="#"><img src="{{ asset('img/instagram.png') }}" alt="Instagram" width="24"></a>
                        <a href="#"><img src="{{ asset('img/whatsapp.png') }}" alt="WhatsApp" width="24"></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

      {{-- Akhir Footer --}}




    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

  </body>
</html>