<!DOCTYPE html>
<html>
<head>
    <title>Hitung Status Gizi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-success text-white">Hitung Status Gizi</div>
        <div class="card-body">
            <div>
                <img src="{{ $pd->foto ? asset('storage/' . $pd->foto) : 'https://via.placeholder.com/300x200' }}" alt="Foto">
            </div>
            <p><strong>Nama:</strong> {{ $pd->namapd }}</p>
            <p><strong>Tinggi Badan:</strong> {{ $pd->tinggibadan }} cm</p>
            <p><strong>Berat Badan:</strong> {{ $pd->beratbadan }} kg</p>
            @if (isset($z_score) && isset($status_gizi))
                {{-- <p><strong>Z-Score:</strong> {{ $z_score }}</p> --}}
                <p><strong>Status Gizi:</strong> {{ $status_gizi }}</p>
            @endif
            <form method="POST" action="{{ route('statusgizi.store') }}">
                @csrf
                <input type="hidden" name="nisn" value="{{ $pd->nisn }}">
                <button type="submit" class="btn btn-primary">Hitung Z-Score</button>
                <a href="{{ route('pesertadidik.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
