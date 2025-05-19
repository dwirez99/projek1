<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kesimpulan Penilaian - {{ $peserta->namapd }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { text-align: center; }
        .content { margin: 20px; }
        .content p { font-size: 14px; }
    </style>
</head>
<body>
    <h2>Kesimpulan Penilaian untuk {{ $peserta->namapd }}</h2>
    <div class="content">
        <p><strong>Nama:</strong> {{ $peserta->namapd }}</p>
        <p><strong>NISN:</strong> {{ $peserta->nisn }}</p>
        <p><strong>Status Gizi Terakhir:</strong> {{ $peserta->statusgizi ? $peserta->statusgizi->status : 'Tidak ada data' }}</p>

        @if(isset($assessmentDetails) && count($assessmentDetails) > 0)
            <h4>Detail Penilaian:</h4>
            <table border="1" cellpadding="5" cellspacing="0" width="100%">
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
    </div>
</body>
</html>
