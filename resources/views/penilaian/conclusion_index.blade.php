@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Anak</h2>

    @if($children->isEmpty())
        <p>Tidak ada data anak yang tersedia.</p>
    @else
        <div class="row">
            @foreach($children as $child)
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0 h-100">

                        <!-- Left Side - Student Info -->
                        <div class="col-md-7">
                            <div class="card-body">
                                <h5 class="card-title mb-3">{{ $child->namapd }}</h5>

                                <div class="student-info">
                                    <div class="border-bottom pb-2 mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">NISN:</span>
                                            <strong>{{ $child->nisn }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Jenis Kelamin:</span>
                                            <strong>{{ $child->jeniskelamin }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Kelas:</span>
                                            <strong>{{ $child->kelas }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Tahun Ajar:</span>
                                            <strong>{{ $child->tahunajar }}</strong>
                                        </div>
                                    </div>

                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <div class="bg-light rounded p-2">
                                                <small class="text-muted d-block">Berat Badan</small>
                                                <strong class="text-primary">{{ $child->beratbadan }} kg</strong>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="bg-light rounded p-2">
                                                <small class="text-muted d-block">Tinggi Badan</small>
                                                <strong class="text-primary">{{ $child->tinggibadan }} cm</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <span class="badge bg-{{ $child->statusgizi ? 'success' : 'secondary' }} p-2 w-100">
                                            Status Gizi: {{ $child->statusgizi ? $child->statusgizi->status : 'Belum dinilai' }}
                                        </span>
                                    </div>

                                    <div class="d-grid">
                                        <a href="{{ route('penilaian.conclusion', $child->nisn) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-chart-line me-1"></i> Lihat Penilaian
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side - Student Photo -->
                        <div class="col-md-5">
                            <div class="h-100">
                                <img src="{{ $child->foto ? asset('storage/' . $child->foto) : asset('images/default-student.jpg') }}"
                                     class="img-fluid h-100 w-100 object-fit-cover rounded-end"
                                     alt="Foto {{ $child->namapd }}"
                                     style="min-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
        </div>
    @endif
</div>
@endsection
