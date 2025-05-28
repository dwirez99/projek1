<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kesimpulan Penilaian - {{ $peserta->namapd }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            vertical-align: top;
            padding: 5px;
        }
        .photo img {
            width: 100%;
            max-width: 150px;
            border-radius: 6px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }
        .table th {
            background-color: #eee;
        }
    </style>
</head>
<body>

    <h2>Kesimpulan Penilaian untuk {{ $peserta->namapd }}</h2>

    <table class="info-table" border="0">
        <tr>
            <!-- Kolom 1 -->
            <td width="33%">
                <p><strong>Nama:</strong> {{ $peserta->namapd }}</p>
                <p><strong>NISN:</strong> {{ $peserta->nisn }}</p>
                <p><strong>Tanggal Lahir:</strong> {{ $peserta->tanggallahir }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ $peserta->jeniskelamin }}</p>
                <p><strong>Kelas:</strong> {{ $peserta->kelas }}</p>
            </td>

            <!-- Kolom 2 -->
            <td width="33%">
                <p><strong>Tahun Ajar:</strong> {{ $peserta->tahunajar }}</p>
                <p><strong>Semester:</strong> {{ $peserta->semester }}</p>
                <p><strong>Tinggi Badan:</strong> {{ $peserta->tinggibadan }} cm</p>
                <p><strong>Berat Badan:</strong> {{ $peserta->beratbadan }} kg</p>
                <p><strong>Status Gizi Terakhir:</strong> {{ $peserta->statusgizi ? $peserta->statusgizi->status : 'Tidak ada data' }}</p>
            </td>

            <!-- Kolom 3 (Foto) -->
            <td width="34%" class="photo">
                @php
                    $fotoPath = $peserta->foto
                        ? public_path('storage/' . $peserta->foto)
                        : public_path('images/default-student.jpg');
                @endphp

                @if(file_exists($fotoPath))
                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($fotoPath)) }}" alt="Foto {{ $peserta->namapd }}">
                @else
                    <p><em>Foto tidak tersedia</em></p>
                @endif
            </td>
        </tr>
    </table>

    @if(isset($assessmentDetails) && count($assessmentDetails) > 0)
        <h4>Detail Penilaian:</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Aspek</th>
                    <th>Indikator</th>
                    <th>Skor</th>
                    <th>Komentar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assessmentDetails as $detail)
                    <tr>
                        <td>{{ $detail->aspect }}</td>
                        <td>{{ $detail->indicator }}</td>
                        <td>{{ $detail->score }}</td>
                        <td>{{ $detail->comment ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p><strong>Kesimpulan:</strong> Kesimpulan penilaian belum tersedia.</p>
    @endif

</body>
</html>
