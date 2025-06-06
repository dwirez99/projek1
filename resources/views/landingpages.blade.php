<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    <title>SIPENDIKAR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@700&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    @extends('layouts.app')

  </head>

  <body class="bg-cover bg-center" style="background-image: url('public/build/assets/bg.png'); height: 400px;">


    <div id="default-carousel" class="relative h-32 md:h-56 lg:h-96 overflow-hidden rounded-lg md:h-96 bg-gray-200" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-lg md:h-96 bg-gray-200">
             <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="build/assets/car1.png" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="build/assets/car2.png" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="build/assets/car3.png" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
        </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>

      <div class="text-center my-8">
        <h3 class="text-xl font-bold mb-12" id="welcome">Selamat Datang</h3>
        <h1 class="text-3xl font-extrabold" id='name'>TK DHARMA WANITA LAMONG</h1>
        <p class="mt-4 text-gray-700 text-center" id="intro">
            TK Dharma Wanita Lamong adalah taman kanak-kanak swasta yang berdiri sejak tahun 1977 di Desa Lamong, Kecamatan Badas, Kabupaten Kediri, Jawa Timur. Dengan pengalaman lebih dari 30 tahun, TK ini menjadi tempat pertama anak-anak mengenal dunia belajar sambil bermain. Menggunakan Kurikulum Merdeka, TK Dharma Wanita Lamong menghadirkan suasana belajar yang menyenangkan, kreatif, dan membebaskan potensi anak-anak. Dipimpin oleh Ibu Siti Innamanasiroh dan berstatus terakreditasi B, sekolah ini berkomitmen membangun fondasi karakter, kemandirian, dan rasa ingin tahu anak sejak usia dini. Berlokasi di Jl. Glatik RT 03 RW 03, Dusun Lamong, TK ini siap menjadi tempat terbaik bagi generasi kecil untuk tumbuh, belajar, dan bermimpi lebih tinggi.
        </p>
      </div>

      <h4 class="text-2xl font-bold text-center my-4" id="tag">Kegiatan Kami</h4>
      <div class="section-kegiatan">
        <div class="container mx-auto">
          <div id="artikelCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                  @foreach($artikels as $artikel)
                  <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{asset('storage/' . $artikel->thumbnail)}}" class="w-full h-48 object-cover" alt="Kegiatan 1">
                    <div class="p-4">
                      <h5 class="text-lg font-semibold">{{$artikel->judul}}</h5>
                      <a href="{{ route('artikel.show', $artikel->id)}}" class="text-blue-500 underline">Selengkapnya</a>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          <div class="flex justify-center mt-4">
          <button class="mt-4 bg-blue-500 text-orange-100 py-2 px-4 rounded"><a href="/kegiatan" wire:navigate>Lihat Semua Kegiatan</a></button>
          </div>
        </div>
      </div>

      <h4 class="text-2xl font-bold text-center my-4" id="tag">Profil Guru</h4>
      <div class="section-guru">
        <div class="container mx-auto">
          <div class="grid grid-cols-5 md:grid-cols-5 lg:grid-cols-5 gap-3">
            @foreach($gurus as $guru)
              <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="{{ asset($guru->image) }}" class="w-full h-48 object-cover" alt="{{ $guru->name }}">
                <div class="p-4 text-center">
                  <div class="font-semibold">{{ $guru->name }}</div>
                  <div class="text-gray-600">{{ $guru->position }}</div>
                </div>
              </div>
            @endforeach
          </div>
          <div class="flex justify-center mt-4">
            <button class="bg-blue-500 text-white py-2 px-4 rounded">
                <a href="/guru" wire:navigate>Lihat Semua Guru</a>
            </button>
        </div>
        </div>
      </div>

      <h4 class="text-2xl font-bold text-center my-4" id="about">Tentang Kami</h4>
      <div class="section-about">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/3">
                    <img src="{{ asset('build/assets/logo/GKL33_Dharma Wanita - Koleksilogo.com 3.png') }}" alt="LOGO DHARMA WANITA" class="w-full">
                </div>
                <div class="md:w-2/3 md:pl-4">
                    <p class="mt-4 text-gray-700">
                        Biro Organisasi Sekretariat Daerah Provinsi Jawa Timur didukung oleh tiga bagian yaitu Bagian Kelembagaan dan Analisis Jabatan, Bagian Reformasi Birokrasi dan Akuntablitas Kinerja, serta Bagian Tata Laksana. Masing-masing bagian terdapat sub bagian dan kelompok jabatan fungsional yang mendukung dalam kinerja di bidang tersebut. Sebagai wujud transparansi informasi dalam menuju reformasi birokrasi, Biro Organisasi menyajikan berbagai layanan informasi baik terkait dengan kegiatan sehari-hari maupun layanan lain yang terkait dengan informasi pelayanan publik.
                    </p>
                </div>
            </div>
            <div class="map-container mt-4" style="width: 100%; height: 400px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.289730510619!2d112.20740907595419!3d-7.7590656769486825!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e785d48f5702d4f%3A0xb219f218217474dd!2sTK%20DHARMA%20WANITA%20LAMONG!5e0!3m2!1sen!2snl!4v1747543215535!5m2!1sen!2snl"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
  </body>
</html>
