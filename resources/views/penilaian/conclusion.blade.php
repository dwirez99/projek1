@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Kesimpulan Penilaian untuk {{ $peserta->namapd }}</h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $peserta->namapd }}</p>
            <p><strong>NISN:</strong> {{ $peserta->nisn }}</p>
            <p><strong>Status Gizi Terakhir:</strong> {{ $peserta->statusgizi ? $peserta->statusgizi->status : 'Tidak ada data' }}</p>

            @if(isset($assessmentDetails) && count($assessmentDetails) > 0)
                <h5>Detail Penilaian:</h5>
                <table class="table table-bordered">
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
    </div>

    <a href="{{ route('penilaian.conclusion.pdf', $peserta->nisn) }}" class="btn btn-primary" target="_blank">
        <i class="fas fa-file-pdf"></i> Download PDF
    </a>

    <a href="{{ route('assessments.show', $peserta->nisn) }}" class="btn btn-secondary">
        Kembali ke Riwayat Penilaian
    </a>
</div>
@endsection
