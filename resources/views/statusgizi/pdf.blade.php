<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Status Gizi Peserta Didik</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }
        .kop {
            text-align: center;
            border-bottom: 3px double black;
            padding-bottom: 10px;
            margin-bottom: 10px;
            position: relative;
        }
        .logo-kiri, .logo-kanan {
            position: absolute;
            width: 80px;
            height: auto;
            top: 0;
        }
        .logo-kiri { left: 20px; }
        .logo-kanan { right: 20px; }

        h1, h2, h3, h4, h5, p {
            margin: 0;
        }
        .uline {
            border-bottom: 4px solid black;
            margin-top: 5px;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }

        .js {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 6px;
            text-align: center;
        }
    </style>
</head>
<body>

<img src="{{ public_path('images/logo-tk.png') }}" class="logo-kiri">
<!-- <img src="{{ public_path('images/logo-kanan.png') }}" class="logo-kanan"> -->

<div class="kop">
    <h1 style="font-weight: bold;">DHARMA WANITA PERSATUAN</h1>
    <h2>TK DHARMA WANITA LAMONG</h2>

    <p>Alamat: Lamong, Kec. Badas, Kabupaten Kediri, Jawa Timur 64216</p>
</div>

<div class="js">
    <h2>LAPORAN STATUS GIZI PESERTA DIDIK</h2>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NISN</th>
            <th>Nama</th>
            <th>Tinggi Badan (cm)</th>
            <th>Berat Badan (kg)</th>
            <th>Z-Score</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($filteredStatus as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->nisn }}</td>
            <td>{{ $item->pesertaDidik->namapd ?? '-' }}</td>
            <td>{{ $item->pesertaDidik->tinggibadan ?? '-' }}</td>
            <td>{{ $item->pesertaDidik->beratbadan ?? '-' }}</td>
            <td>{{ $item->z_score }}</td>
            <td>{{ $item->status }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggalpembuatan)->format('d-M-Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
