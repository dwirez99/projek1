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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @extends('layouts.app')

  </head>

  <body class="bg-cover bg-center" style="background-image: url('public/build/assets/bg.png'); height: 400px;">


    <div id="default-carousel" class="relative h-32 md:h-56 lg:h-96 overflow-hidden rounded-lg bg-gray-200" data-carousel="slide">
  <!-- Carousel wrapper -->
  <div class="relative h-56 overflow-hidden rounded-lg md:h-96 bg-gray-200">
    <!-- Item 1 - Aktif -->
    <div class="block duration-700 ease-in-out" data-carousel-item="active">
      <img src="build/assets/car1.png" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Slide 1">
    </div>
    <!-- Item 2 -->
    <div class="hidden duration-700 ease-in-out" data-carousel-item>
      <img src="build/assets/car2.png" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Slide 2">
    </div>
    <!-- Item 3 -->
    <div class="hidden duration-700 ease-in-out" data-carousel-item>
      <img src="build/assets/car3.png" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Slide 3">
    </div>
  </div>

  <!-- Slider indicators -->
  <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
    <button type="button" class="w-3 h-3 rounded-full bg-white" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
    <button type="button" class="w-3 h-3 rounded-full bg-white/50" aria-label="Slide 2" data-carousel-slide-to="1"></button>
    <button type="button" class="w-3 h-3 rounded-full bg-white/50" aria-label="Slide 3" data-carousel-slide-to="2"></button>
  </div>

  <!-- Slider controls -->
  <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
      <svg class="w-4 h-4 text-white rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
      </svg>
      <span class="sr-only">Previous</span>
    </span>
  </button>
  <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
      <svg class="w-4 h-4 text-white rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
      </svg>
      <span class="sr-only">Next</span>
    </span>
  </button>
</div>


      <div class="text-center mt-8 mb-12">
        <h3 class="text-xl font-bold mb-6 md:mb-12" id="welcome">Selamat Datang</h3>
        <h1 class="text-3xl font-extrabold" id='name'>TK DHARMA WANITA LAMONG</h1>
        <p class="mt-4 text-gray-700 text-center" id="intro">
            TK Dharma Wanita Lamong adalah taman kanak-kanak swasta yang berdiri sejak tahun 1977 di Desa Lamong, Kecamatan Badas, Kabupaten Kediri, Jawa Timur. Dengan pengalaman lebih dari 30 tahun, TK ini menjadi tempat pertama anak-anak mengenal dunia belajar sambil bermain. Menggunakan Kurikulum Merdeka, TK Dharma Wanita Lamong menghadirkan suasana belajar yang menyenangkan, kreatif, dan membebaskan potensi anak-anak. Dipimpin oleh Ibu Siti Innamanasiroh dan berstatus terakreditasi B, sekolah ini berkomitmen membangun fondasi karakter, kemandirian, dan rasa ingin tahu anak sejak usia dini. Berlokasi di Jl. Glatik RT 03 RW 03, Dusun Lamong, TK ini siap menjadi tempat terbaik bagi generasi kecil untuk tumbuh, belajar, dan bermimpi lebih tinggi.
        </p>
      </div>

      <h4 class="text-2xl font-bold text-center mt-12 mb-6" id="tag">Kegiatan Kami</h4>
      <div class="section-kegiatan mb-12">
        <div class="container mx-auto">
          <div id="artikelCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                  @forelse($artikels as $artikel)
                  <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{asset('storage/' . $artikel->thumbnail)}}" class="w-full h-48 object-cover" alt="Kegiatan 1">
                    <div class="p-4">
                      <h5 class="text-lg font-semibold">{{$artikel->judul}}</h5>
                      <a href="{{ route('artikel.show', $artikel->id)}}" class="text-blue-500 underline">Selengkapnya</a>
                    </div>
                  </div>
                  @empty
                  <p class="col-span-full text-center text-gray-500">Belum ada kegiatan yang dipublikasikan.</p>
                  @endforelse
                </div>
              </div>
            </div>
          </div>
          @if($artikels->isNotEmpty())
          <div class="flex justify-center mt-4">
          <button class="mt-4 bg-blue-500 text-orange-100 py-2 px-4 rounded"><a href="/kegiatan" wire:navigate>Lihat Semua Kegiatan</a></button>
          </div>
          @endif
        </div>
      </div>

      <h4 class="text-2xl font-bold text-center mt-12 mb-6" id="tag">Profil Guru</h4>
      <div class="section-guru mb-12">
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
          @if($gurus->isNotEmpty())
          <div class="flex justify-center mt-4">
            <button class="bg-blue-500 text-white py-2 px-4 rounded">
                <a href="/guru" wire:navigate>Lihat Semua Guru</a>
            </button>
        </div>
        @endif
        </div>
      </div>

      <table class="table table-bordered table-hover align-middle" id="statusTable" data-sort-dir="asc" style="display: none;">
        <thead class="table-dark">
            <tr>
                <th style="display:none">Kelas</th>
                <th>Status</th>
                <th>Tanggal <i class="bi bi-arrow-down-up" onclick="sortTable(9)"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($status as $item)
            <tr>
                <td style="display:none">{{ $item->pesertaDidik->kelas ?? 'A' }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggalpembuatan)->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

      {{-- Tabel --}}
    {{-- Awal Chart --}}
<h4 class="text-2xl font-bold text-center mt-12 mb-6" id="tag">Statistik Pertumbuhan Anak</h4>
<div class="section-stats mb-12">
    <div class="container mb-12">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Filter Rentang Tanggal Status Gizi</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="startDate" class="form-label">Tanggal Mulai</label>
                        <input type="date" id="startDate" class="form-control" onchange="updateCharts()" />
                    </div>
                    <div class="col-md-6">
                        <label for="endDate" class="form-label">Tanggal Akhir</label>
                        <input type="date" id="endDate" class="form-control" onchange="updateCharts()" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Chart Status Gizi Kelas A</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartKelasA" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Chart Status Gizi Kelas B</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartKelasB" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    let chartA = null, chartB = null;

    function getChartDataByClass() {
        const rows = document.querySelectorAll('#statusTable tbody tr');
        const data = { A: {}, B: {} };

        const start = document.getElementById('startDate')?.value;
        const end = document.getElementById('endDate')?.value;
        const startDate = start ? new Date(start) : null;
        const endDate = end ? new Date(end) : null;

        rows.forEach(row => {
            if (row.style.display === 'none') return;

            const kelas = row.cells[0].textContent.trim();
            const status = row.cells[1].textContent.trim();
            const tanggal = row.cells[2].textContent.trim();

            const dateObj = new Date(tanggal);
            if (isNaN(dateObj)) return;

            if (startDate && dateObj < startDate) return;
            if (endDate && dateObj > endDate) return;

            const bulan = dateObj.toISOString().slice(0, 7);

            if (!data[kelas]) data[kelas] = {};
            if (!data[kelas][bulan]) data[kelas][bulan] = {};
            if (!data[kelas][bulan][status]) data[kelas][bulan][status] = 0;
            data[kelas][bulan][status]++;
        });

        return data;
    }

    function prepareChartData(data, kelas) {
        if (!data[kelas]) return { labels: [], datasets: [] };
        const bulanLabels = Object.keys(data[kelas]).sort();
        const statusLabels = ['Gizi Kurang', 'Gizi Baik', 'Gizi Lebih', 'Obesitas'];
        const colors = {
            'Gizi Kurang': '#dc3545',
            'Gizi Baik': '#198754',
            'Gizi Lebih': '#ffc107',
            'Obesitas': '#0d6efd'
        };

        const datasets = statusLabels.map(status => ({
            label: status,
            backgroundColor: colors[status],
            data: bulanLabels.map(b => data[kelas][b][status] || 0)
        }));

        return { labels: bulanLabels, datasets };
    }

    function renderChart(canvasId, chartRef, chartData) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        if (chartRef) {
            chartRef.data = chartData;
            chartRef.update();
        } else {
            return new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: { size: 14 }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.dataset.label}: ${context.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan',
                                font: { size: 14 }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Anak',
                                font: { size: 14 }
                            },
                            ticks: { stepSize: 1, precision: 0 }
                        }
                    }
                }
            });
        }
    }

    function updateCharts() {
        const data = getChartDataByClass();
        const chartDataA = prepareChartData(data, 'A');
        const chartDataB = prepareChartData(data, 'B');

        chartA = renderChart('chartKelasA', chartA, chartDataA) || chartA;
        chartB = renderChart('chartKelasB', chartB, chartDataB) || chartB;
    }

    window.onload = function () {
        updateCharts();
    }
</script>

      <h4 class="text-2xl font-bold text-center mt-12 mb-6" id="about">Tentang Kami</h4>
      <div class="section-about mb-12">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/3">
                    <img src="{{ asset('build/assets/logo/logo_dw.png') }}" alt="LOGO DHARMA WANITA" class="w-full">
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

      {{-- Akhir Tentang kami --}}

      {{-- Tabel --}}


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Akhir Chart --}}


      {{-- Awal Footer --}}
      {{-- Akhir Footer --}}





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->

    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

  </body>
</html>
