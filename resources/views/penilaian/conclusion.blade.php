@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Kesimpulan Penilaian untuk {{ $peserta->namapd }}</h2>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <!-- Kolom 1 -->
                <div class="col-md-4">
                    <p><strong>Nama:</strong> {{ $peserta->namapd }}</p>
                    <p><strong>NISN:</strong> {{ $peserta->nisn }}</p>
                    <p><strong>Tanggal Lahir:</strong> {{ $peserta->tanggallahir }}</p>
                    <p><strong>Jenis Kelamin:</strong> {{ $peserta->jeniskelamin }}</p>
                    <p><strong>Kelas:</strong> {{ $peserta->kelas }}</p>
                </div>

                <!-- Kolom 2 -->
                <div class="col-md-4">
                    <p><strong>Tahun Ajar:</strong> {{ $peserta->tahunajar }}</p>
                    <p><strong>Semester:</strong> {{ $peserta->semester }}</p>
                    <p><strong>Tinggi Badan:</strong> {{ $peserta->tinggibadan }}</p>
                    <p><strong>Berat Badan:</strong> {{ $peserta->beratbadan }}</p>
                    <p><strong>Status Gizi Terakhir:</strong>
                        {{ $peserta->statusgizi ? $peserta->statusgizi->status : 'Tidak ada data' }}
                    </p>
                </div>

                <!-- Kolom 3: Foto -->
                <div class="col-md-4 d-flex align-items-center">
                    <img src="{{ $peserta->foto ? asset('storage/' . $peserta->foto) : asset('images/default-student.jpg') }}"
                         class="img-fluid object-fit-cover rounded"
                         alt="Foto {{ $peserta->namapd }}"
                         style="width: 100%; min-height: 200px; max-height: 300px; object-fit: cover;">
                </div>
            </div>

            @if(isset($assessmentDetails) && count($assessmentDetails) > 0)
                <h5 class="mt-4">Detail Penilaian:</h5>
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

    <a href="{{ route('penilaian.conclusion.pdf', $peserta->nisn) }}"
       class="btn btn-primary" target="_blank">
        <i class="fas fa-file-pdf"></i> Download PDF
    </a>

    <a href="{{ route('assessments.show', $peserta->nisn) }}"
       class="btn btn-secondary">
        Kembali ke Riwayat Penilaian
    </a>
</div>
@endsection
