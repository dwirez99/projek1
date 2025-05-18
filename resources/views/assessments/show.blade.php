@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>History Penilaian: {{ $peserta->namapd }}</h2>
        <a href="{{ route('assessments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @foreach($peserta->assessments as $assessment)
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Penilaian tanggal: {{ $assessment->assessment_date->format('d/m/Y') }}</h5>
            <form action="{{ route('assessments.destroy', $assessment->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Hapus penilaian ini?')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-light">
                            <th>Aspek</th>
                            <th>Indikator</th>
                            <th>Nilai</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assessment->details as $detail)
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $detail->aspect)) }}</td>
                            <td>{{ $detail->indicator }}</td>
                            <td>
                                <span class="badge
                                    @if($detail->score == 'Sangat Berkembang') bg-success
                                    @elseif($detail->score == 'Belum Berkembang') bg-warning
                                    @else bg-primary @endif">
                                    {{ $detail->score }}
                                </span>
                            </td>
                            <td>{{ $detail->comment ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection