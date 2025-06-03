<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
 --}}

    <title>SIPENDIKAR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@700&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
          <div id="artikelCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="row justify-content-center g-4">
                  @foreach($artikels as $artikel)
                  <div class="col-md-5">
                    <div class="card card-custom h-100">
                      <img src="{{asset('storage/' . $artikel->thumbnail)}}" class="card-img-top img-fixed" alt="Kegiatan 1" style="border-radius: 20px 20px 0 0;">
                      <div class="card-body">
                        <h5 class="card-title">{{$artikel->judul}}</h5>
                        <div class="card-text">
                          {{-- {!! Str::limit($artikel->konten, 25) !!} --}}
                        </div>
                        <a href="{{ route('artikel.show', $artikel->id)}}" class="text-dark text-decoration-underline fw-standar">Selengkapnya</a>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <button class="btn-lihat mt-4"><a href="/kegiatan" wire:navigate>Lihat Semua Kegiatan</a></button>
        </div>
      </div>

{{-- Mulai Guru --}}
<h4 id="tag">Profil Guru</h4>
      <div class="section-guru">
        <div class="container">
          <style>
            .fixed-aspect-ratio {
              width: 100%;
              height: 250px;
              object-fit: cover;
              object-position: center;
            }
            .profile-card {
              width: 300px;
              height: 400px;
              background-color: white;
              border-radius: 1rem;
              box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
              overflow: hidden;
              display: flex;
              flex-direction: column;
              align-items: center;
              transition: transform 0.3s ease;
            }
            .profile-card:hover {
              transform: scale(1.05);
            }
            .profile-header {
              width: 100%;
              text-align: center;
            }
            .profile-name {
              font-weight: 300;
              font-size: 5px;
              margin-top:5px;
            }
            .profile-title {
              font-size: 20px;
              color: #666;
              margin-bottom: 10px;
            }
          </style>

          <div class="row justify-content-center g-4">
            @foreach($gurus as $guru)
              <div class="col-md-3 d-flex justify-content-center">
                <div class="profile-card">
                  <div class="profile-header">
                    <img src="{{ asset($guru->image) }}"
                         class="card-img-top img-profil fixed-aspect-ratio"
                         alt="{{ $guru->name }}"
                         style="border-radius: 30px 10px 0 0;">
                    <div class="profile-name">{{ $guru->name }}</div>
                    <div class="profile-title">{{ $guru->position }}</div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

    <button class="btn-lihat"><a href="/guru" wire:navigate>Lihat Semua Guru</a></button>
  </div>
</div>
{{-- Akhir Guru --}}


      {{-- Mulai Tentang Kami --}}
      <h4 id="about">Tentang Kami</h4>
      <div class="section-about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <img src="{{ asset('build/assets/logo/GKL33_Dharma Wanita - Koleksilogo.com 3.png') }}" alt="LOGO DHARMA WANITA" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <p id="intro">
                        Biro Organisasi Sekretariat Daerah Provinsi Jawa Timur didukung oleh tiga bagian yaitu Bagian Kelembagaan dan Analisis Jabatan, Bagian Reformasi Birokrasi dan Akuntablitas Kinerja, serta Bagian Tata Laksana. Masing-masing bagian terdapat sub bagian dan kelompok jabatan fungsional yang mendukung dalam kinerja di bidang tersebut. Sebagai wujud transparansi informasi dalam menuju reformasi birokrasi, Biro Organisasi menyajikan berbagai layanan informasi baik terkait dengan kegiatan sehari-hari maupun layanan lain yang terkait dengan informasi pelayanan publik.
                    </p>
                </div>
            </div>
            <div class="map-container" style="width: 100%; height: 400px;">
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
<h4 id="stats">Statistik Pertumbuhan Anak</h4>
<div class="container mt-4">
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

    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Chart Status Gizi Kelas A</h5>
        </div>
        <div class="card-body">
            <canvas id="chartKelasA" style="height: 300px;"></canvas>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Chart Status Gizi Kelas B</h5>
        </div>
        <div class="card-body">
            <canvas id="chartKelasB" style="height: 300px;"></canvas>
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

  </body>
</html>